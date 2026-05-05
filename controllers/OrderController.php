<?php

class OrderController extends Controller {
    public function index(): void {
        // 1. Kiểm tra đăng nhập
        
        $this->requireAuth();

        $currentUser = Session::get('auth_user');
        $userId = $currentUser['id'] ?? null; 

        if (!$userId) {
             Session::flash('error', 'Bạn cần đăng nhập để xem đơn hàng của mình.');
             $this->redirect('/whey_web/login');
             exit;
        }

        $orderModel = new Order();
        
        // 2. Phân trang
        $limit = 5; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // 3. Lấy dữ liệu của riêng người dùng này
        $orders = $orderModel->getPaginatedByUserId($userId, $limit, $offset);
        $totalRecords = $orderModel->getCountByUserId($userId);
        $totalPages = ceil($totalRecords / $limit);

        $this->view('orders/index', [
            'orders' => $orders,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
    public function detail(): void {
        $this->requireAuth(); // Đảm bảo đã đăng nhập

        $orderId = $_GET['id'] ?? null;
        $currentUser = Session::get('auth_user'); // Lấy từ key đúng
        $userId = $currentUser['id'];

        if (!$orderId) {
            $this->redirect('/whey_web/orders');
        }

        $orderModel = new Order();
        $order = $orderModel->getById($orderId, $userId);

        // Bảo mật: Nếu đơn hàng không tồn tại hoặc không thuộc về user này
        if (!$order) {
            $this->redirect('/whey_web/orders');
        }

        $items = $orderModel->getItemsByOrderId($orderId);

        $this->view('orders/detail', [
            'order' => $order,
            'items' => $items
        ]);
    }
}

?>