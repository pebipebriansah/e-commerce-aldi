<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class PesananController extends BaseController
{

    protected $orderModel;
    protected $pembayaranModel;
    protected $orderItem;
    protected $produkVarianModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
        $this->pembayaranModel = new \App\Models\PembayaranModel();
        $this->orderItem = new \App\Models\OrderItemModel();
        $this->produkVarianModel = new \App\Models\ProdukVarianModel();
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

    public function konfirmasi($id)
    {
        $this->orderModel->update($id, ['status' => 'paid']);

        // cari ke tabel order_item kemudian ambil product_variant_id dan quantity, lalu update stock di tabel produk_varian
        $orderItem = $this->orderItem->where('order_id', $id)->findAll();
        foreach ($orderItem as $item) {
            $this->produkVarianModel->updateStok($item['product_variant_id'], $item['quantity']);
        }
        // update status pembayaran
        $this->pembayaranModel->where('order_id', $id)->set(['payment_status' => 'completed'])->update();

        return redirect()->to('/admin/pesanan/' . $id)->with('success', 'Pesanan berhasil dikonfirmasi');
    }

    public function kirim($id)
    {
        $no_resi = $this->request->getPost('resi');
        $this->orderModel->update($id, ['status' => 'shipped', 'resi' => $no_resi]);
        return redirect()->to('/admin/pesanan/' . $id)->with('success', 'Pesanan berhasil dikirim');
    }
}
