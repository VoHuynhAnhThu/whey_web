<?php

declare(strict_types=1);

class ProductController extends Controller
{
    public function index(): void {
        $productModel = new Product();
        $keyword = $_GET['search'] ?? '';

        // 1. Cấu hình phân trang
        $limit = 8; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // 2. Lấy dữ liệu có giới hạn
        if (!empty($keyword)) {
            $products = $productModel->search($keyword, $limit, $offset);
            $totalRecords = $productModel->countSearch($keyword);
            $title = "Kết quả tìm kiếm cho: " . htmlspecialchars($keyword);
        } else {
            $products = $productModel->getPaginated($limit, $offset);
            $totalRecords = $productModel->getTotalCount();
            $title = "Tất cả sản phẩm";
        }

        $totalPages = ceil($totalRecords / $limit);

        // 3. Truyền thêm biến phân trang sang View
        $this->view('products/index', [
            'title' => $title,
            'products' => $products,
            'keyword' => $keyword,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function show(): void
    {
        $productModel = new Product();
        
        // Lấy slug từ URL: /product?slug=gold-standard-100-whey
        $slug = $_GET['slug'] ?? '';

        if (empty($slug)) {
            // Nếu không có slug, quay về trang danh sách
            header('Location: /whey_web/products');
            exit;
        }

        // Tìm sản phẩm dựa trên slug
        $product = $productModel->findBySlug($slug);
        
        if (!$product) {
            // Nếu không tìm thấy, có thể thông báo lỗi
            die("Sản phẩm không tồn tại hoặc đã bị xóa.");
        }

        // Truyền dữ liệu sang View detail.php
        $this->view('products/detail', [
            'title' => $product['name'] . ' - Fitwhey',
            'product' => $product
        ]);
    }
}