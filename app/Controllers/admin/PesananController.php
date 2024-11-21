<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class PesananController extends BaseController
{

    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
    }
    public function index()
    {
        $order = $this->orderModel->getOrder();

        $data = [
            'title' => 'Pesanan',
            'data' => $order
        ];

        return view('admin/pesanan/index', $data);
    }

    public function detail($id)
    {
        $order = $this->orderModel->getOrderById($id);

        $data = [
            'title' => 'Detail Pesanan',
            'data' => $order
        ];

        return view('admin/pesanan/detail', $data);
    }
}
