<?php
class AdminProductController extends Controller {

    //Check Auth tạm thời, xóa sau
    public function __construct() {
        // Kiểm tra xem đã đăng nhập chưa
        if (!isset($_SESSION['auth_user'])) {
            header('Location: /whey_web/login');
            exit;
        }

        // Đã đăng nhập nhưng không phải admin thì đuổi về trang chủ
        if ($_SESSION['auth_user']['role'] !== 'admin') {
            header('Location: /whey_web/');
            exit;
        }
    }
 

    public function index(): void {
        $productModel = new Product();
        
        // 1. Cấu hình phân trang
        $limit = 2; // Số sản phẩm trên mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // 2. Lấy dữ liệu
        $products = $productModel->getPaginated($limit, $offset);
        $totalRecords = $productModel->getTotalCount();
        $totalPages = ceil($totalRecords / $limit);

        // 3. Truyền dữ liệu sang View
        $this->view('admin/products/index', [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ], 'admin');
    }

    public function create(): void {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll(); // Lấy danh sách danh mục cho thẻ select[cite: 1]
        
        $this->view('admin/products/create', [
            'title' => 'Thêm sản phẩm mới',
            'categories' => $categories
        ], 'admin');
    }

    // 2. Xử lý lưu dữ liệu vào Database (POST)[cite: 1]
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Chuẩn bị dữ liệu cho bảng Products[cite: 1]
            $productData = [
                'category_id'    => $_POST['category_id'],
                'name'           => $_POST['name'],
                'description'    => $_POST['description'],
                'price'          => $_POST['price'],
                'sale_price'     => $_POST['sale_price'] ?: null,
                'stock_quantity' => $_POST['stock_quantity'] ?? 0,
                'weight'         => $_POST['weight'] ?? null,
                'flavor'         => $_POST['flavor'] ?? null
            ];

            // Chuẩn bị dữ liệu cho bảng Product_Nutrition[cite: 1]
            $nutritionData = [
                'serving_size' => $_POST['serving_size'],
                'serving_unit' => $_POST['serving_unit'],
                'calories'     => $_POST['calories'] ?: 0,
                'protein'      => $_POST['protein'] ?: 0,
                'carbs'        => $_POST['carbs'] ?: 0,
                'fat'          => $_POST['fat'] ?: 0
            ];

            $imageUrl = 'uploads/products/default.png'; // Placeholder tạm thời nếu chưa có upload[cite: 1]

            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                $uploadDir = 'uploads/products/'; // Thư mục lưu ảnh trên server
                
                // Tạo thư mục nếu chưa có
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Tạo tên file duy nhất (dùng UUID hoặc timestamp) để không bị trùng
                $fileName = time() . '_' . $_FILES['product_image']['name'];
                $targetPath = $uploadDir . $fileName;

                // Thực hiện lệnh "Copy" file từ máy người dùng lên server
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
                    $imageUrl = $targetPath; // Lưu đường dẫn này vào database
                }
            }

            $productModel = new Product();
            
            // Gọi hàm lưu đồng bộ 3 bảng (Products, Images, Nutrition)[cite: 1]
            if ($productModel->createFull($productData, $nutritionData, $imageUrl)) {
                Session::flash('success', 'Thêm sản phẩm thành công!');
                header('Location: /whey_web/admin/products');
            } else {
                Session::flash('error', 'Lỗi: Không thể lưu sản phẩm.');
                header('Location: /whey_web/admin/product/create');
            }
            exit;
        }
    }

    public function edit(): void {
        $id = $_GET['id'] ?? ''; // Lấy ID từ URL ?id=...
        
        if (empty($id)) {
            header('Location: /whey_web/admin/products');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getFullProductById($id);
        
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        $this->view('admin/products/edit', [
            'product' => $product,
            'categories' => $categories
        ], 'admin');
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $oldImagePath = $_POST['old_image_url'] ?? 'uploads/products/default.png'; // Mặc định dùng ảnh cũ
            $imageUrl = $oldImagePath;

            // Nếu có upload ảnh mới
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                $uploadDir = 'uploads/products/';
                $fileName = time() . '_' . $_FILES['product_image']['name'];
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
                    $imageUrl = $targetPath; // Cập nhật đường dẫn mới để lưu DB

                    // Chỉ xóa nếu ảnh cũ tồn tại, không phải là ảnh mặc định và không phải chính nó
                    if (!empty($oldImagePath) && 
                        $oldImagePath !== 'uploads/products/default.png' && 
                        file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Lệnh xóa file khỏi folder
                    }
                }
            }

            $productData = [
                'id' => $id,
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description'    => $_POST['description'] ?? '',
                'price' => $_POST['price'],
                'sale_price' => $_POST['sale_price'] ?: null,
                'stock_quantity' => $_POST['stock_quantity'] ?? 0,
                'weight' => $_POST['weight'] ?? null,
                'flavor' => $_POST['flavor'] ?? null
            ];

            $nutritionData = [
                'serving_size' => $_POST['serving_size'],
                'serving_unit' => $_POST['serving_unit'],
                'calories' => $_POST['calories'],
                'protein' => $_POST['protein'],
                'carbs' => $_POST['carbs'],
                'fat' => $_POST['fat']
            ];

            $productModel = new Product();
            if ($productModel->updateFull($productData, $nutritionData, $imageUrl)) {
                Session::flash('success', 'Cập nhật thành công!');
                header('Location: /whey_web/admin/products');
            } else {
                Session::flash('error', 'Lỗi cập nhật!');
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            exit;
        }
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            
            if ($id) {
                $productModel = new Product();
                
                // 1. Chủ động lấy thông tin sản phẩm để tìm đường dẫn ảnh trước khi xóa khỏi DB
                $product = $productModel->getFullProductById($id);
                if ($product && !empty($product['image_url'])) {
                    $imagePath = $product['image_url'];
                    
                    // Kiểm tra né ảnh mặc định và chắc chắn file có tồn tại trên thư mục thì mới xóa
                    if ($imagePath !== 'uploads/products/default.png' && file_exists($imagePath)) {
                        unlink($imagePath); // Lệnh xóa file vật lý khỏi folder
                    }
                }
                
                // 2. Gọi hàm xóa dữ liệu từ Model giống nguyên bản của bạn
                if ($productModel->deleteProduct($id)) {
                    Session::flash('success', 'Đã xóa sản phẩm thành công.');
                } else {
                    Session::flash('error', 'Lỗi: Không thể xóa sản phẩm.');
                }
            }
            
            header('Location: /whey_web/admin/products');
            exit;
        }
    }
}