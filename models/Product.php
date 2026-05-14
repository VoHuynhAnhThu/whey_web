<?php

declare(strict_types=1);

class Product extends Model
{
    /**
     * Lấy toàn bộ danh sách sản phẩm
     * Hỗ trợ yêu cầu về Phân trang (Pagination) sau này
     */
    public function all(): array
    {
        // Lấy thông tin sản phẩm
        $sql = "SELECT p.*, pi.url 
                FROM Products p 
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1 
                WHERE p.is_active = 1 
                ORDER BY p.created_at DESC";
                
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Tìm sản phẩm theo Slug (Dành cho SEO)
     */
    public function findBySlug(string $slug)
    {
        $sql = "SELECT p.*, pi.url 
                FROM Products p 
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE p.slug = :slug AND p.is_active = 1 
                LIMIT 1";

        // Thay vì dùng $this->db->query(), ta dùng prepare()
        $stmt = $this->db->prepare($sql);
        
        // Thực thi với mảng tham số
        $stmt->execute(['slug' => $slug]);
        
        // Trả về kết quả
        return $stmt->fetch();
    }

    public function findBySlugOrId(string $identifier)
    {
        // Truy vấn tìm theo ID hoặc Slug, lấy kèm ảnh chính
        $sql = "SELECT p.*, pi.url 
                FROM Products p 
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE (p.id = :id OR p.slug = :slug) AND p.is_active = 1 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        
        // Gán giá trị identifier cho cả 2 tham số để tìm ở cả 2 cột
        $stmt->execute([
            'id' => $identifier,
            'slug' => $identifier
        ]);
        
        return $stmt->fetch();
    }

    /**
     * Tìm kiếm sản phẩm theo từ khóa (Yêu cầu Job #3)
     */
    public function search(string $keyword): array
    {
        $sql = "SELECT p.*, pi.url 
                FROM Products p 
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE (p.name LIKE :keyword OR p.description LIKE :keyword) AND p.is_active = 1";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll();
    }

    public function checkout(): void
    {
        // Kiểm tra xem giỏ hàng có dữ liệu không
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            Session::flash('error', 'Giỏ hàng của bạn đang trống!');
            header('Location: /whey_web/products');
            exit;
        }

        unset($_SESSION['cart']);

        Session::flash('success', 'Thanh toán thành công! Đơn hàng của bạn đang được xử lý.');

        // Chuyển hướng sang trang thông báo thành công
        $this->view('public/cart/success', [
            'title' => 'Thanh toán thành công'
        ]);
    }
    /**
     * Tạo sản phẩm mới (Sử dụng UUID)
     */
    public function createFull(array $productData, array $nutritionData, string $imageUrl): bool
        {
            try {
                $this->db->beginTransaction(); // Bắt đầu Transaction để bảo vệ dữ liệu 3 bảng

                // 1. Tạo UUID và xử lý Slug
                $productId = Str::uuid();
                $productData['id'] = $productId;
                $productData['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $productData['name'])));

                // 2. Chèn vào bảng Products
                $sqlProd = "INSERT INTO Products (id, category_id, name, slug, description, price, sale_price, stock_quantity, weight, flavor) 
                            VALUES (:id, :category_id, :name, :slug, :description, :price, :sale_price, :stock_quantity, :weight, :flavor)";
                $stmtProd = $this->db->prepare($sqlProd);
                $stmtProd->execute($productData); // Truyền mảng vào execute thay vì query

                // 3. Chèn vào bảng Product_Nutrition
                $nutritionData['product_id'] = $productId;
                $sqlNutri = "INSERT INTO Product_Nutrition (product_id, serving_size, serving_unit, calories, protein, carbs, fat) 
                            VALUES (:product_id, :serving_size, :serving_unit, :calories, :protein, :carbs, :fat)";
                $stmtNutri = $this->db->prepare($sqlNutri);
                $stmtNutri->execute($nutritionData);

                // 4. Chèn vào bảng Product_Images (Ảnh chính)
                $imgId = Str::uuid();
                $sqlImg = "INSERT INTO Product_Images (id, product_id, url, is_main) VALUES (:id, :product_id, :url, :is_main)";
                $stmtImg = $this->db->prepare($sqlImg);
                $stmtImg->execute([
                    'id' => $imgId,
                    'product_id' => $productId,
                    'url' => $imageUrl,
                    'is_main' => 1
                ]);

                $this->db->commit(); // Xác nhận lưu mọi thứ
                return true;
            } catch (Exception $e) {
                $this->db->rollBack(); // Nếu một bảng lỗi, hủy bỏ toàn bộ để tránh rác DB[cite: 1]
                // Có thể dùng error_log($e->getMessage()); để debug nếu cần
                return false;
            }
        }

    // Lấy toàn bộ thông tin của 1 sản phẩm từ 3 bảng
    public function getFullProductById($id) {
        $sql = "SELECT p.*, pn.serving_size, pn.serving_unit, pn.calories, pn.protein, pn.carbs, pn.fat, pi.url as image_url
                FROM Products p
                LEFT JOIN Product_Nutrition pn ON p.id = pn.product_id
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật sản phẩm (Transaction)
    public function updateFull(array $p, array $n, string $img): bool {
        try {
            $this->db->beginTransaction();

            // 1. Tạo lại Slug từ tên mới (để đồng bộ hệ thống)
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $p['name'])));

            // 2. Cập nhật bảng Products
            $sqlP = "UPDATE Products SET 
                    category_id = :cat_id, 
                    name = :name, 
                    slug = :slug, 
                    description = :desc, 
                    price = :price, 
                    sale_price = :s_price, 
                    stock_quantity = :stock, 
                    weight = :weight, 
                    flavor = :flavor 
                    WHERE id = :id";
            
            $this->db->prepare($sqlP)->execute([
                'cat_id' => $p['category_id'],
                'name'   => $p['name'],
                'slug'   => $slug,
                'desc'   => $p['description'],
                'price'  => $p['price'],
                's_price'=> $p['sale_price'],
                'stock'  => $p['stock_quantity'],
                'weight' => $p['weight'],
                'flavor' => $p['flavor'],
                'id'     => $p['id']
            ]);

            // 3. Cập nhật bảng Product_Nutrition
            $sqlN = "UPDATE Product_Nutrition SET 
                    serving_size = :size, 
                    serving_unit = :unit, 
                    calories = :cal, 
                    protein = :pro, 
                    carbs = :carb, 
                    fat = :fat 
                    WHERE product_id = :prod_id";
            
            $this->db->prepare($sqlN)->execute([
                'size'    => $n['serving_size'],
                'unit'    => $n['serving_unit'],
                'cal'     => $n['calories'],
                'pro'     => $n['protein'],
                'carb'    => $n['carbs'],
                'fat'     => $n['fat'],
                'prod_id' => $p['id']
            ]);

            // 4. Cập nhật bảng Product_Images
            $sqlI = "UPDATE Product_Images SET url = :url WHERE product_id = :prod_id AND is_main = 1";
            $this->db->prepare($sqlI)->execute([
                'url'     => $img,
                'prod_id' => $p['id']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Mở dòng dưới đây nếu muốn "nội soi" lỗi chính xác bảng nào bị sai[cite: 1]
            // die("Lỗi tại Model: " . $e->getMessage()); 
            return false;
        }
    }
    /**
 * Lấy danh sách sản phẩm dành cho trang Admin (kèm phân trang và tìm kiếm)
 */
public function getAllProductsAdmin($search = '', $limit = 10, $offset = 0) {
    // Câu lệnh SQL JOIN với bảng Categories để lấy tên danh mục
    $sql = "SELECT p.*, c.name as category_name 
            FROM Products p 
            LEFT JOIN Categories c ON p.category_id = c.id";
    
    $params = [];
    
    // Xử lý tìm kiếm nếu có
    if (!empty($search)) {
        $sql .= " WHERE p.name LIKE :search OR p.flavor LIKE :search";
        $params['search'] = "%$search%";
    }
    
    $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
    
    $stmt = $this->db->prepare($sql);
    
    // Bind các giá trị phân trang (phải ép kiểu INT)
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    
    foreach ($params as $key => $val) {
        $stmt->bindValue(':' . $key, $val);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    /**
     * Đếm tổng số sản phẩm để tính số trang[cite: 1]
     */
    public function countAllProducts($search = '') {
        $sql = "SELECT COUNT(*) FROM Products";
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE name LIKE :search";
            $params['search'] = "%$search%";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function deleteProduct($id): bool {
        $sql = "DELETE FROM Products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getPaginated(int $limit, int $offset): array {
        $sql = "SELECT p.*, c.name as category_name, pi.url 
                FROM Products p
                LEFT JOIN Categories c ON p.category_id = c.id
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE p.is_active = 1
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearch(string $keyword): int {
        $sql = "SELECT COUNT(*) FROM Products 
                WHERE (name LIKE :keyword OR description LIKE :keyword) 
                AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return (int)$stmt->fetchColumn();
    }

    public function getTotalCount(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM Products")->fetchColumn();
    }

}