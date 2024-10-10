<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];
        return view('customer/home/home', $data);
    }
}
