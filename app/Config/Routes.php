<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  routes for admin login
$routes->get('login', 'admin\AuthController::index');
$routes->post('auth', 'admin\AuthController::auth');
$routes->post('auth-customer', 'admin\AuthController::authCustomer');
$routes->get('logout', 'admin\AuthController::logout');
$routes->get('logout-customer', 'admin\AuthController::customerLogout');

$routes->get('register', 'admin\AuthController::register');
$routes->post('signup', 'admin\AuthController::signup');
$routes->get('customer/login', 'admin\AuthController::customerLogin');


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
$routes->get('cart', 'customer\ShopController::cart');
$routes->post('/cart/add', 'customer\ShopController::addToCart');
$routes->get('cart/count', 'customer\ShopController::countCart');
$routes->post('cart/delete', 'customer\ShopController::deleteCart');
