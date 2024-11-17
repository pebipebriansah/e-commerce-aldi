<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;
use App\Models\ProdukVarianModel;
use App\Models\CartModel;

class ShopController extends BaseController
{
    protected $produkModel;
    protected $produkVarianModel;
    protected $cartModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->produkVarianModel = new ProdukVarianModel();
        $this->cartModel = new CartModel();
    }
    public function index()
    {
        $produk = $this->produkModel->getProduk();
        $data = [
            'title' => 'Shop',
            'produk' => $produk
        ];
        return view('customer/shop/shop', $data);
    }

    public function getDataProduk()
    {
        $data = $this->produkModel->getProduk();
        return $this->response->setJSON($data);
    }

    public function detail($id)
    {
        $produk = $this->produkModel->getProdukById($id);

        $data = [
            'title' => 'Detail Produk',
            'id' => $id,
            'produk' => $produk
        ];

        return view('customer/shop/detail', $data);
    }

    public function addToCart()
    {
        // Dapatkan data dari JSON
        $data = $this->request->getJSON();
        $variant_id = $data->variant_id;
        $qty = $data->qty;
        $user_id = $data->user_id;

        $dataAdd = [
            'product_variant_id' => $variant_id,
            'quantity' => $qty,
            'user_id' => $user_id
        ];

        // Cek apakah produk sudah ada di keranjang
        $cek = $this->cartModel->where('product_variant_id', $variant_id)
            ->where('user_id', $user_id)
            ->first();

        if ($cek) {
            // Jika sudah ada, tambahkan jumlahnya
            $dataAdd['quantity'] = $cek['quantity'] + $qty;
            $simpan = $this->cartModel->update($cek['id'], $dataAdd);

            if ($simpan) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Berhasil menambahkan ke keranjang']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambahkan ke keranjang']);
            }
        } else {
            // Jika belum ada, buat entri baru di keranjang
            $simpan = $this->cartModel->insert($dataAdd);

            if ($simpan) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Produk berhasil ditambahkan ke keranjang']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambahkan produk ke keranjang']);
            }
        }
    }

    public function cart()
    {
        $costumer_id = session()->get('id');
        $cart = $this->cartModel->getCart($costumer_id);

        $data = [
            'title' => 'Keranjang Belanja',
            'produk' => $cart,
        ];
        return view('customer/shop/cart', $data);
    }

    public function countCart()
    {
        $costumer_id = session()->get('id');
        $cart = $this->cartModel->where('user_id', $costumer_id)->countAllResults();

        return $this->response->setJSON(['count' => $cart]);
    }

    public function deleteCart()
    {
        $id = $this->request->getPost('id');
        $delete = $this->cartModel->delete($id);

        if ($delete) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Berhasil menghapus produk dari keranjang']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus produk dari keranjang']);
        }
    }

    public function checkout()
    {
        $costumer_id = session()->get('id');
        $cart = $this->cartModel->getCart($costumer_id);
        $provinsi = $this->cartModel->getProvinsi();

        $ekspedisi = [
            [
                'id' => 'jne',
                'name' => 'JNE'
            ],
            [
                'id' => 'pos',
                'name' => 'POS'
            ],
            [
                'id' => 'tiki',
                'name' => 'TIKI'
            ]
        ];

        $data = [
            'title' => 'Checkout',
            'produk' => $cart,
            'provinsi' => $provinsi,
            'ekspedisi' => $ekspedisi
        ];
        return view('customer/shop/checkout', $data);
    }
}
