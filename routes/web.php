<?php

declare(strict_types=1);

$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');

$router->get('/profile', 'ProfileController@show');
$router->post('/profile', 'ProfileController@update');

// News routes
$router->get('/news', 'NewsController@index');
$router->get('/news/detail', 'NewsController@show');
$router->post('/news/comment', 'NewsController@addComment');

// Admin News & Comments routes
$router->get('/admin', 'AdminController@dashboard');
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
