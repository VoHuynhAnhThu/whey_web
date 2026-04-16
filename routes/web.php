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
