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

$router->get('/admin/users', 'AdminController@index');
$router->get('/admin/users/add', 'AdminController@add');
$router->post('/admin/users/add', 'AdminController@add');
$router->get('/admin/users/edit', 'AdminController@edit');
$router->post('/admin/users/edit', 'AdminController@edit');
$router->get('/admin/users/delete', 'AdminController@delete');

$router->get('/admin/settings/about', 'AdminController@editAbout');
$router->post('/admin/settings/about', 'AdminController@editAbout');


$router->get('/faq', 'HomeController@faq');
$router->post('/faq/ask', 'HomeController@ask');

$router->get('/admin/faqs', 'AdminController@manageFaqs');
$router->post('/admin/faqs/reply', 'AdminController@replyFaq');


$router->get('/admin/faqs/reply', 'AdminController@showReplyForm'); 


$router->post('/admin/faqs/reply', 'AdminController@replyFaq');
?>