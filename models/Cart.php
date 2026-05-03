<?php
class Cart extends Model {
    public function getDb() {
        return $this->db;
    }

    public function addToCart($userId, $productId, $quantity) {
        // Sử dụng ON DUPLICATE KEY UPDATE để tự động tăng số lượng nếu đã tồn tại
        $sql = "INSERT INTO Cart_Items (user_id, product_id, quantity) 
                VALUES (:user_id, :product_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity_plus";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'quantity_plus' => $quantity
        ]);
    }

    public function getItemsByUserId($userId) {
        $sql = "SELECT c.quantity, p.id as product_id, p.name, p.sale_price, p.stock_quantity, p.slug, pi.url 
                FROM Cart_Items c
                LEFT JOIN Products p ON c.product_id = p.id
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE c.user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCart($userId) {
        $sql = "DELETE FROM Cart_Items WHERE user_id = :user_id";
        return $this->db->prepare($sql)->execute(['user_id' => $userId]);
    }
    // Thêm hàm này vào trong class Cart của file models/Cart.php
    public function removeItem($userId, $productId) {
        $sql = "DELETE FROM Cart_Items WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }
}