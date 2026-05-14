<?php
class AdminOrderController extends Controller {

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
        $orderModel = new Order();
        
        // 1. Cấu hình
        $limit = 2; // Số đơn hàng trên mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // 2. Lấy dữ liệu
        $orders = $orderModel->getPaginated($limit, $offset);
        $totalRecords = $orderModel->getTotalCount();
        $totalPages = ceil($totalRecords / $limit);

        // 3. Render View
        $this->view('admin/orders/index', [
            'orders' => $orders,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ], 'admin');
    }
    public function updateStatus(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderId = $_POST['order_id'] ?? '';
            $status = $_POST['status'] ?? '';

            // Kiểm tra dữ liệu đầu vào (Validation) - Yêu cầu bài tập lớn
            $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
            if (empty($orderId) || !in_array($status, $validStatuses)) {
                Session::flash('error', 'Dữ liệu trạng thái không hợp lệ!');
                header('Location: /whey_web/admin/orders');
                exit;
            }

            $orderModel = new Order();
            if ($orderModel->updateStatus($orderId, $status)) {
                Session::flash('success', 'Cập nhật trạng thái đơn hàng thành công.');
            } else {
                Session::flash('error', 'Có lỗi xảy ra khi cập nhật.');
            }
            
            header('Location: /whey_web/admin/orders');
            exit;
        }
    }

    public function detail(): void {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /whey_web/admin/orders');
            exit;
        }

        $orderModel = new Order();
        $items = $orderModel->getOrderDetails($id);
        
        $this->view('admin/orders/detail', [
            'title' => 'Chi tiết đơn hàng',
            'items' => $items
        ], 'admin');
    }
}