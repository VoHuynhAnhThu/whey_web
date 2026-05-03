<?php

declare(strict_types=1);

class CartController extends Controller
{
    public function index(): void
    {
        $currentUser = Auth::user(); // Lấy thông tin user hiện tại
        
        if (!$currentUser) {
            header('Location: /whey_web/login');
            exit;
        }

        $cartModel = new Cart();
        $dataFromDb = $cartModel->getItemsByUserId($currentUser['id']);
        
        $total = 0;
        foreach ($dataFromDb as $item) {
            $total += $item['sale_price'] * $item['quantity'];
        }

        // LƯU Ý QUAN TRỌNG: Khóa ở đây là 'items'
        $this->view('cart/index', [
            'title' => 'Giỏ hàng của bạn',
            'items' => $dataFromDb, // Biến này sẽ xuất hiện trong View là $items
            'total' => $total
        ]);
    }

    public function add(): void {
    // 1. Kiểm tra đăng nhập qua Auth::user() của nhóm
        $currentUser = Auth::user();
        if ($currentUser === null) {
            Session::flash('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
            header('Location: /whey_web/login');
            exit;
        }

        $productId = $_POST['product_id'] ?? '';
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId) {
            $cartModel = new Cart();
            $success = $cartModel->addToCart($currentUser['id'], $productId, $quantity);

            if ($success) {
                Session::flash('success', 'Đã cập nhật giỏ hàng hệ thống!');
            } else {
                Session::flash('error', 'Có lỗi xảy ra khi thêm vào giỏ hàng.');
            }
        }

        header('Location: /whey_web/products');
        exit;
    }

    public function remove(): void {
        $currentUser = Auth::user();
        $productId = $_POST['product_id'] ?? '';

        if ($currentUser && $productId) {
            $cartModel = new Cart();
            $cartModel->removeItem($currentUser['id'], $productId);
            Session::flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }

        header('Location: /whey_web/cart');
        exit;
    }

    public function checkout(): void {
        $currentUser = Auth::user();
        if (!$currentUser) {
            header('Location: /whey_web/login');
            exit;
        }

        $cartModel = new Cart();
        $db = $cartModel->getDb(); // Lấy kết nối PDO từ Model
        $items = $cartModel->getItemsByUserId($currentUser['id']);

        if (empty($items)) {
            Session::flash('error', 'Giỏ hàng của bạn đang trống.');
            header('Location: /whey_web/cart');
            exit;
        }

        // Tạo mã UUID cho đơn hàng mới
        $orderId = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));

        try {
            $db->beginTransaction();

            $total = 0;
            foreach ($items as $item) {
                // Kiểm tra xem kho còn đủ hàng không trước khi trừ
                if ($item['stock_quantity'] < $item['quantity']) {
                    throw new Exception("Sản phẩm " . $item['name'] . " chỉ còn " . $item['stock_quantity'] . " sản phẩm trong kho.");
                }
                $total += ($item['sale_price'] * $item['quantity']);
            }

            // 1. Lưu thông tin vào bảng Orders
            $stmtOrder = $db->prepare("INSERT INTO Orders (id, user_id, total_amount) VALUES (?, ?, ?)");
            $stmtOrder->execute([$orderId, $currentUser['id'], $total]);

            foreach ($items as $item) {
                // 2. Lưu chi tiết vào bảng Order_Items
                $stmtItem = $db->prepare("INSERT INTO Order_Items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmtItem->execute([$orderId, $item['product_id'], $item['quantity'], $item['sale_price']]);

                // 3. THỰC HIỆN TRỪ KHO (Cập nhật bảng Products)
                $stmtUpdateStock = $db->prepare("UPDATE Products SET stock_quantity = stock_quantity - ? WHERE id = ?");
                $stmtUpdateStock->execute([$item['quantity'], $item['product_id']]);
            }

            // 4. Xóa sạch giỏ hàng trong DB sau khi mua xong
            $cartModel->clearCart($currentUser['id']);

            $db->commit();
            Session::flash('success', 'Thanh toán thành công! Kho hàng đã được cập nhật.');
            $this->view('cart/success', ['title' => 'Hoàn tất đơn hàng']);

        } catch (Exception $e) {
            $db->rollBack();
            Session::flash('error', 'Thanh toán thất bại: ' . $e->getMessage());
            header('Location: /whey_web/cart');
        }
    }
}