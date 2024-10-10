<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ShopController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Shop'
        ];
        return view('customer/shop/shop', $data);
    }
}
