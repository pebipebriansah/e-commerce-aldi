<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    public function index()
    {
        $customer = $this->userModel->getAllCustomer();
        $data = [
            'title' => 'Customer',
            'data' => $customer
        ];
        return view('admin/user/index', $data);
    }
}
