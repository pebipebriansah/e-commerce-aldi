<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{

    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
    }
    public function index()
    {

        $order = $this->orderModel->getOrderWhere();
        $data = [
            'title' => 'Laporan',
            'data' => $order
        ];

        return view('admin/laporan/index', $data);
    }
}
