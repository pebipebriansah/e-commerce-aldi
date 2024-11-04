<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new \App\Models\ProdukModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Home',
            'produk' => $this->produkModel->getProduk()
        ];
        return view('customer/home/home', $data);
    }
}
