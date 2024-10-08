<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// route group for admin
$routes->group('admin', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');

    $routes->get('kategori', 'KategoriController::index');
    $routes->post('kategori/add', 'KategoriController::add');
    $routes->post('kategori/delete', 'KategoriController::delete');
    $routes->post('kategori/update', 'KategoriController::update');

    $routes->get('produk', 'ProdukController::index');
    $routes->get('produk/tambah', 'ProdukController::tambah');
    $routes->post('produk/add', 'ProdukController::add');
    $routes->post('produk/delete', 'ProdukController::delete');
});

// rooute group for api
$routes->group('api', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('kategori', 'KategoriController::getData');
    $routes->post('kategori', 'KategoriController::create');
    $routes->put('kategori/(:num)', 'KategoriController::update/$1');
    $routes->delete('kategori/(:num)', 'KategoriController::delete/$1');
});
