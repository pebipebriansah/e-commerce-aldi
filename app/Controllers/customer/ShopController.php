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
        //    get data from json
        $data = $this->request->getJSON();
        $variant_id = $data->variant_id;
        $qty = $data->qty;
        $user_id = $data->user_id;

        $dataAdd = [
            'product_variant_id' => $variant_id,
            'quantity' => $qty,
            'user_id' => $user_id
        ];

        // cek apakah produk sudah ada di keranjang
        $cek = $this->cartModel->where('product_variant_id', $variant_id)->where('user_id', $user_id)->first();
        if ($cek) {
            $dataAdd['quantity'] = $cek['quantity'] + $qty;
            $simpan = $this->cartModel->update($cek['id'], $dataAdd);
            if ($simpan) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Berhasil menambahkan ke keranjang']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambahkan ke keranjang']);
            }
        }
    }
}
