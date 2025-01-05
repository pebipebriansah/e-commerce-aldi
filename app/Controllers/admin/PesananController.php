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
    protected $produkModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
        $this->pembayaranModel = new \App\Models\PembayaranModel();
        $this->orderItem = new \App\Models\OrderItemModel();
        $this->produkVarianModel = new \App\Models\ProdukVarianModel();
        $this->produkModel = new \App\Models\ProdukModel();
    }
    public function index()
    {
        // get keyword
        $keyword = $this->request->getVar('status') ?? 'pending';
        if ($keyword) {
            $order = $this->orderModel->getOrder($keyword);
        } else {
            $order = $this->orderModel->getOrder('pending');
        }
        $data = [
            'title' => 'Pesanan',
            'data' => $order,
            'keyword' => $keyword
        ];

        return view('admin/pesanan/index', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Pesanan'
        ];

        return view('admin/pesanan/tambah', $data);
    }

    public function tambah()
    {
        $tanggal = $this->request->getPost('tanggal');
        $name = $this->request->getPost('name');
        $alamat = $this->request->getPost('alamat');
        $no_hp = $this->request->getPost('no_hp');
        $product_variant_id = $this->request->getPost('variasi');
        $quantity = $this->request->getPost('qty');
        $price = $this->request->getPost('harga');
        $total_harga = $this->request->getPost('total_harga');

        $data = [
            'tanggal' => $tanggal,
            'name' => $name,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'product_variant_id' => array_map('json_decode', $product_variant_id),
            'quantity' => $quantity,
            'price' => $price,
            'total_harga' => $total_harga,
            'status' => 'completed',
        ];

        //    insert data
        $result = $this->orderModel->insertOrderManual($data);

        if ($result == true) {
            // Berhasil
            return redirect()->to('/admin/pesanan')->with('success', 'Pesanan berhasil ditambahkan');
        } else {
            // Gagal
            // log_message('error', $result['message']);
            return redirect()->to('admin/pesanan')->withInput()->with('error', 'Gagal menambahkan pesanan');
        }
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

    // AJAX
    public function getProduk()
    {
        $produk = $this->produkModel->findAll();
        return $this->response->setJSON($produk);
    }

    public function getVariasiProduk($id)
    {
        $variasi = $this->produkVarianModel->where('product_id', $id)->findAll();
        return $this->response->setJSON($variasi);
    }
}
