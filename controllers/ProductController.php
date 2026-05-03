<?php

declare(strict_types=1);

class ProductController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        
        $keyword = $_GET['search'] ?? '';

        if (!empty($keyword)) {
            $products = $productModel->search($keyword);
            $title = "Kết quả tìm kiếm cho: " . htmlspecialchars($keyword);
        } else {
            $products = $productModel->all();
            $title = "Tất cả sản phẩm";
        }

        $this->view('products/index', [
            'title' => $title,
            'products' => $products,
            'keyword' => $keyword
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
        $this->view('public/products/detail', [
            'title' => $product['name'] . ' - Fitwhey',
            'product' => $product
        ]);
    }
}