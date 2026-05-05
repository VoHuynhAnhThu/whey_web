<?php
class Order extends Model {
    // Lấy danh sách đơn hàng kèm tên khách hàng và email
    public function getAllOrdersWithProfiles() {
        $sql = "SELECT o.*, p.full_name, u.email 
                FROM Orders o 
                JOIN Users u ON o.user_id = u.id 
                JOIN Profiles p ON u.id = p.user_id 
                ORDER BY o.created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái (pending, processing, completed, cancelled)
    public function updateStatus($orderId, $status) {
        $sql = "UPDATE Orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'id' => $orderId
        ]);
    }
    
    // Lấy chi tiết các món hàng trong một đơn hàng[cite: 1]
    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.name 
                FROM Order_Items oi
                JOIN Products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderId) {
        $sql = "SELECT oi.*, p.name, pi.url as image_url
                FROM Order_Items oi
                JOIN Products p ON oi.product_id = p.id
                LEFT JOIN Product_Images pi ON p.id = pi.product_id AND pi.is_main = 1
                WHERE oi.order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng có phân trang
    public function getPaginated(int $limit, int $offset): array {
        // Lấy o.* (tất cả cột đơn hàng), p.full_name (tên khách), u.email (email khách)
        $sql = "SELECT o.*, p.full_name, u.email 
                FROM Orders o
                LEFT JOIN profiles p ON o.user_id = p.user_id
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm tổng số đơn hàng
    public function getTotalCount(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM Orders")->fetchColumn();
    }

    public function getPaginatedByUserId(string $userId, int $limit, int $offset): array {
        $sql = "SELECT * FROM Orders 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCountByUserId(string $userId): int {
        $sql = "SELECT COUNT(*) FROM Orders WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return (int)$stmt->fetchColumn();
    }

    // Lấy thông tin chung của đơn hàng
    public function getById(string $id, string $userId): ?array {
        $sql = "SELECT * FROM orders WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    // Lấy danh sách sản phẩm thuộc đơn hàng đó
    public function getItemsByOrderId(string $orderId): array {
        $sql = "SELECT oi.*, p.name, pi.url 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                LEFT JOIN product_images pi ON p.id = pi.product_id
                WHERE oi.order_id = :order_id
                GROUP BY oi.id"; 
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}