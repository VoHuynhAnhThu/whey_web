<?php

declare(strict_types=1);

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');

$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');

$router->get('/profile', 'ProfileController@show');
$router->post('/profile', 'ProfileController@update');

$router->get('/admin', 'AdminController@dashboard');

//Trang danh sách sản phẩm
$router->get('/products', 'ProductController@index');
//Trang chi tiết sản phẩm và Giỏ hàng
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