<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  routes for admin login
$routes->get('login', 'admin\AuthController::index');
$routes->post('auth', 'admin\AuthController::auth');
$routes->get('logout', 'admin\AuthController::logout');

// route group for admin
$routes->group('admin', ['filter' => 'authAdmin', 'namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    $routes->get('kategori', 'KategoriController::index');
    $routes->post('kategori/add', 'KategoriController::add');
    $routes->post('kategori/delete', 'KategoriController::delete');
    $routes->post('kategori/update', 'KategoriController::update');

    $routes->get('produk', 'ProdukController::index');
    $routes->get('produk/tambah', 'ProdukController::tambah');
    $routes->post('produk/add', 'ProdukController::add');
    $routes->post('produk/update', 'ProdukController::update');
    $routes->post('produk/delete', 'ProdukController::delete');
    $routes->get('produk/edit/(:num)', 'ProdukController::edit/$1');
});

// routes home
$routes->get('/', 'customer\HomeController::index');
$routes->get('/shop', 'customer\ShopController::index');
$routes->get('/shop/(:num)', 'customer\ShopController::detail/$1');
$routes->post('/cart/add', 'customer\ShopController::addToCart');
