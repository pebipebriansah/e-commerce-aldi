<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProdukModel;
use App\Models\ProdukVarianModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use Pusher\Pusher;

class ShopController extends BaseController
{
    protected $produkModel;
    protected $produkVarianModel;
    protected $cartModel;
    protected $orderModel;
    protected $categoryModel;
    protected $userModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->produkVarianModel = new ProdukVarianModel();
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        $this->categoryModel = new \App\Models\KategoriModel();
        $this->userModel = new \App\Models\UserModel();
    }
    public function index()
    {
        $idCategory = $this->request->getGet('category');

        $search = $this->request->getGet('search');

        if ($idCategory) {
            $produk = $this->produkModel->getProdukByCategory($idCategory);
        } else if ($search) {
            $produk = $this->produkModel->searchProduk($search);
        } else {
            $produk = $this->produkModel->getProduk();
        }

        $category = $this->categoryModel->findAll();
        $data = [
            'title' => 'Shop',
            'produk' => $produk,
            'search' => $search,
            'category' => $category
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
        $review = $this->orderModel->getReview($id);


        $data = [
            'title' => 'Detail Produk',
            'id' => $id,
            'produk' => $produk,
            'review' => $review
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
            // cek stok
            $stok = $this->produkVarianModel->where('id', $variant_id)->first();
            if ($stok['stock'] < $qty || $stok['stock'] == 0) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Stok Habis atau tidak mencukupi']);
            }
            // Jika belum ada, buat entri baru di keranjang
            $simpan = $this->cartModel->insert($dataAdd);

            if ($simpan) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Produk berhasil ditambahkan ke keranjang']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambahkan produk ke keranjang']);
            }
        }
    }

    public function updateCart()
    {
        $data = $this->request->getJSON();

        // loop data
        foreach ($data as $cart) {

            $this->cartModel->update($cart->id_cart, ['quantity' => $cart->qty]);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Berhasil mengupdate keranjang']);
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
        $alamat = $this->userModel->where('id', $costumer_id)->first();

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
            'alamat' => $alamat['address_detail'] . ' ' . $alamat['address'],
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
        $alamat_lengkap = $this->userModel->where('id', $user_id)->first();
        $ekspedisi = $this->request->getPost('ekspedisi');
        $estimasi = $this->request->getPost('estimasi');
        $ongkir = $this->request->getPost('ongkir');
        $total = $this->request->getPost('total');

        $alamat = $alamat_lengkap['address_detail'] . ' ' . $alamat_lengkap['address'];
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

        $this->sendNotifikasi($user_id);

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

    public function upload_bukti($id)
    {
        $file = $this->request->getFile('bukti');
        $fileName = $file->getRandomName();
        $file->move('bukti', $fileName);

        $data = [
            'payment_method' => 'Transfer Bank',
            'payment_date' => date('Y-m-d H:i:s'),
            'order_id' => $id,
            'bukti_transfer' => $fileName,
            'payment_status' => 'pending'
        ];

        $update = $this->orderModel->uploadBukti($data);

        if ($update) {
            return redirect()->to(base_url('shop/order/' . $id))->with('success', 'Bukti pembayaran berhasil diupload');
        } else {
            return redirect()->to(base_url('shop/order/' . $id))->with('error', 'Gagal mengupload bukti pembayaran');
        }
    }

    public function confirm($id)
    {
        $update = $this->orderModel->update($id, ['status' => 'completed']);

        if ($update) {
            return redirect()->to(base_url('shop/order/' . $id))->with('success', 'Pesanan berhasil dikonfirmasi');
        } else {
            return redirect()->to(base_url('shop/order/' . $id))->with('error', 'Gagal mengkonfirmasi pesanan');
        }
    }

    public function review()
    {
        $data = $this->request->getPost();

        $simpan = $this->orderModel->insertReview($data);

        if ($simpan) {
            return redirect()->to(base_url('shop/order/' . $data['order_id']))->with('success', 'Review berhasil ditambahkan');
        } else {
            return redirect()->to(base_url('shop/order/' . $data['order_id']))->with('error', 'Gagal menambahkan review');
        }
    }

    public function cancelOrder()
    {
        $id = $this->request->getPost('id');
        $update = $this->orderModel->update($id, ['status' => 'cancelled']);

        if ($update) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Pesanan berhasil dibatalkan']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal membatalkan pesanan']);
        }
    }

    private function sendNotifikasi($idOrder)
    {
        // cari ke tabel user
        $user = new \App\Models\UserModel();
        $user->where('id', $idOrder);
        $user = $user->first();
        $fullName = $user['full_name'];
        // autoload.php
        require ROOTPATH . 'vendor/autoload.php';
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '3d6dc9011db726edee70',
            '3e9a019c4b7ac9c59eb3',
            '1911103',
            $options
        );
        $message = 'Pesanan Baru! dari, ' . $fullName;

        $data['message'] = $message;
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function autoCancel()
    {
        $orderId = $this->request->getPOST('transaction_id');
        // cek status order
        $order = $this->orderModel->where('id', $orderId)->first();
        if ($order['status'] != 'pending') {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Anda telah melakukan pembayaran']);
        } else {
            $this->orderModel->update($orderId, ['status' => 'cancelled']);
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Pending orders older than 24 hours have been cancelled']);
    }
}
