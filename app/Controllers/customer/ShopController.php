<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;
use App\Models\ProdukVarianModel;
use App\Models\CartModel;
use App\Models\OrderModel;

class ShopController extends BaseController
{
    protected $produkModel;
    protected $produkVarianModel;
    protected $cartModel;
    protected $orderModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->produkVarianModel = new ProdukVarianModel();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
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
        $price = $data->price;
        $user_id = $data->user_id;

        if (!$user_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Silahkan login terlebih dahulu']);
        }
        // ubah Rp. 74,250 menjadi 74250
        $price = str_replace(['Rp', '.', ','], '', $price);
        $dataAdd = [
            'product_variant_id' => $variant_id,
            'quantity' => $qty,
            'price' => $price,
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

    public function order()
    {
        // date asia/jakarta
        date_default_timezone_set('Asia/Jakarta');
        // get user id
        $user_id = session()->get('id');
        $provinsi = $this->request->getPost('prov');
        $kabupaten = $this->request->getPost('kab');
        $kecamatan = $this->request->getPost('kec');
        $alamat_lengkap = $this->request->getPost('alamat_lengkap');
        $ekspedisi = $this->request->getPost('ekspedisi');
        $estimasi = $this->request->getPost('estimasi');
        $ongkir = $this->request->getPost('ongkir');
        $total = $this->request->getPost('total');

        $alamat = $alamat_lengkap . ', ' . $kecamatan . ', ' . $kabupaten . ', ' . $provinsi;
        // generrate no_order INV-202108-0001

        $data = [
            'user_id' => $user_id,
            'status' => 'pending',
            'order_date' => date('Y-m-d H:i:s'),
            'shipping_address' => $alamat,
            'payment_method' => 'Transfer Bank',
            'expedisi' => $ekspedisi,
            'estimasi' => $estimasi,
            'cost' => $ongkir,
            'total' => $total,
        ];

        $idOrder = $this->orderModel->insertOrder($data);

        return redirect()->to(base_url('shop/order/' . $idOrder))->with('success', 'Pesanan berhasil dibuat');
    }

    public function myOrder()
    {
        $order = $this->orderModel->getOrderByUserId(session()->get('id'));
        $data = [
            'title' => 'Pesanan Saya',
            'data' => $order
        ];

        return view('customer/shop/order', $data);
    }

    public function detailOrder($id)
    {
        $order = $this->orderModel->getOrderById($id);

        $data = [
            'title' => 'Detail Order',
            'data' => $order
        ];

        return view('customer/shop/order_detail', $data);
    }
}
