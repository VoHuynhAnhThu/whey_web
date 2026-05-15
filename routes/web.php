<?php

declare(strict_types=1);
class AdminUserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->requireRole('admin');
        $this->userModel = new User();
    }

    public function index(): void
    {
        $users = $this->userModel->getAll();

        $this->view('admin/users/index', [
            'title' => 'Quản lý người dùng - FITWHEY',
            'users' => $users,
        ], 'admin');
    }
}

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->post('/logout', 'AuthController@logout');

$router->get('/profile', 'ProfileController@show');
$router->post('/profile', 'ProfileController@update');

// News routes
$router->get('/news', 'NewsController@index');
$router->get('/news/detail', 'NewsController@show');
$router->post('/news/comment', 'NewsController@addComment');

// Admin News & Comments routes
$router->get('/admin', 'AdminController@dashboard');

// Trang danh sách sản phẩm
$router->get('/products', 'ProductController@index');
// Trang chi tiết sản phẩm và Giỏ hàng
$router->get('/product', 'ProductController@show');
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/update', 'CartController@update');
$router->post('/cart/remove', 'CartController@remove');
$router->post('/cart/checkout', 'CartController@checkout');

// --- QUẢN LÝ ĐƠN HÀNG CHO USER ---
$router->get('/orders', 'OrderController@index');
$router->get('/orders/detail', 'OrderController@detail');

// --- QUẢN LÝ SẢN PHẨM ---
$router->get('/admin/products', 'AdminProductController@index');
$router->get('/admin/products/create', 'AdminProductController@create');
$router->post('/admin/products/store', 'AdminProductController@store');

$router->get('/admin/products/edit', 'AdminProductController@edit');
$router->post('/admin/products/update', 'AdminProductController@update');
$router->post('/admin/products/delete', 'AdminProductController@delete');

// --- QUẢN LÝ ĐƠN HÀNG ---
$router->get('/admin/orders', 'AdminOrderController@index');
$router->post('/admin/orders/update-status', 'AdminOrderController@updateStatus');
$router->get('/admin/orders/detail/{id}', 'AdminOrderController@detail');

// --- QUẢN LÝ CÀI ĐẶT & LIÊN HỆ ---
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/update-settings', 'AdminController@updateSettings');
$router->post('/admin/settings/update', 'AdminController@updateSettings');

$router->get('/admin/settings/about', 'AdminController@editAbout');
$router->post('/admin/settings/about', 'AdminController@editAbout');

$router->get('/admin/contacts', 'AdminController@listContacts');
$router->post('/admin/contacts/update-status', 'AdminController@updateContactStatus');
$router->post('/admin/contacts/delete', 'AdminController@deleteContact');

// Hiển thị trang liên hệ
$router->get('/contact', 'HomeController@contact'); 
// Xử lý gửi form
$router->post('/contact/send', 'HomeController@submitContact');

// --- QUẢN LÝ TIN TỨC & BÌNH LUẬN ---
$router->get('/admin/news', 'AdminNewsController@newsList');
$router->get('/admin/news/create', 'AdminNewsController@createForm');
$router->post('/admin/news', 'AdminNewsController@store');
$router->get('/admin/news/edit', 'AdminNewsController@editForm');
$router->post('/admin/news/update', 'AdminNewsController@update');
$router->post('/admin/news/delete', 'AdminNewsController@delete');

$router->get('/admin/comments', 'AdminNewsController@commentsList');
$router->post('/admin/comments/approve', 'AdminNewsController@approveComment');
$router->post('/admin/comments/reject', 'AdminNewsController@rejectComment');
$router->post('/admin/comments/delete', 'AdminNewsController@deleteComment');

$router->get('/admin/users', 'AdminController@index');
$router->get('/admin/users/add', 'AdminController@add');
$router->post('/admin/users/add', 'AdminController@add');
$router->get('/admin/users/edit', 'AdminController@edit');
$router->post('/admin/users/edit', 'AdminController@edit');
$router->get('/admin/users/delete', 'AdminController@delete');

// --- QUẢN LÝ FAQs ---
$router->get('/faq', 'HomeController@faq');
$router->post('/faq/ask', 'HomeController@ask');

$router->get('/admin/faqs/create', 'AdminController@createFaqForm');
$router->post('/admin/faqs/store', 'AdminController@storeFaq');
$router->get('/admin/faqs/delete', 'AdminController@deleteFaq');

$router->get('/admin/faqs', 'AdminController@manageFaqs');
$router->get('/admin/faqs/reply', 'AdminController@showReplyForm'); 
$router->post('/admin/faqs/reply', 'AdminController@replyFaq');

?>