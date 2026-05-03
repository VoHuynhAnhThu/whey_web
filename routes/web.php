<?php

declare(strict_types=1);

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');

$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/profile', 'ProfileController@show');
$router->post('/profile', 'ProfileController@update');

$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/update-settings', 'AdminController@updateSettings');
$router->post('/admin/settings/update', 'AdminController@updateSettings');
$router->get('/admin/contacts', 'AdminController@listContacts');
$router->post('/admin/contacts/update-status', 'AdminController@updateContactStatus');
$router->post('/admin/contacts/delete', 'AdminController@deleteContact');
// Hiển thị trang liên hệ
$router->get('/contact', 'HomeController@contact'); 
// Xử lý gửi form
$router->post('/contact', 'HomeController@submitContact');