<?php

namespace App\Models;

use CodeIgniter\Model;
use Pusher\Pusher;

class OrderModel extends Model
{
    protected $table            = 'order';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // insert data
    public function insertOrder($data)
    {

        $userId = $data['user_id'];

        // insert detail order
        $cartModel = new CartModel();
        $cart = $cartModel->getCartByUserId($userId);



        if ($cart) {
            $no_order = 'INV-' . date('Ym') . '-' . substr(md5(microtime(true)), 0, 4);
            $data['no_order'] = $no_order;
            $this->insert($data);
            $idOrder = $this->db->insertID();

            // insert ke order_item
            $orderItemModel = new OrderItemModel();
            foreach ($cart as $c) {
                $orderItem = [
                    'order_id' => $idOrder,
                    'product_variant_id' => $c['product_variant_id'],
                    'price' => $c['price'],
                    'quantity' => $c['quantity']
                ];

                $orderItemModel->insert($orderItem);
            }

            // delete cart
            $cartModel->deleteCart($userId);

            // return id order yang baru saja dibuat

            return $idOrder;
        } else {
            return false;
        }
    }

    public function insertOrderManual($data)
    {
        $this->db->transStart();

        try {
            $userModel = new UserModel();
            // name to lower dan menghilangkan spasi
            // Insert ke tabel user
            $dataUser = [
                'email' =>  strtolower(str_replace(' ', '', $data['name'])) . '@gmail.com',
                'password' => password_hash('default', PASSWORD_DEFAULT),
                'username' => strtolower(str_replace(' ', '', $data['name'])),
                'full_name' => $data['name'],
                'phone' => $data['no_hp'],
                'address_detail' => $data['alamat'],
                'address' => $data['alamat'],
                'role' => 'customer',
            ];
            $userModel->insert($dataUser);

            if ($this->db->affectedRows() <= 0) {
                throw new \Exception('Gagal menyimpan data pengguna.');
            }

            // Ambil ID user yang baru ditambahkan
            $userId = $this->db->insertID();

            // Insert ke tabel order
            $no_order = 'INV-' . date('Ym') . '-' . substr(md5(microtime(true)), 0, 4);
            $dataOrder = [
                'user_id' => $userId,
                'total' => $data['total_harga'],
                'status' => $data['status'],
                'order_date' => $data['tanggal'],
                'no_order' => $no_order,
                'cost' => 0,
                'payment_method' => 'cash',
            ];
            $this->insert($dataOrder);

            if ($this->db->affectedRows() <= 0) {
                throw new \Exception('Gagal menyimpan data pesanan.');
            }

            // Ambil ID order
            $orderId = $this->db->insertID();

            // Insert data order item
            foreach ($data['product_variant_id'] as $key => $item) {
                $orderItem = [
                    'order_id' => $orderId,
                    'product_variant_id' => $item->id,
                    'price' => $data['price'][$key],
                    'quantity' => $data['quantity'][$key],
                ];
                $this->db->table('order_item')->insert($orderItem);

                // hapus stok pada tabel produk_varian
                $this->db->table('produk_varian')->set('stock', 'stock - ' . $data['quantity'][$key], false)->where('id', $item->id)->update();

                if ($this->db->affectedRows() <= 0) {
                    throw new \Exception("Gagal menyimpan data order item untuk varian ID: {$item['id']}.");
                }
            }

            // Insert ke tabel pembayaran
            $dataPembayaran = [
                'order_id' => $orderId,
                'payment_date' => $data['tanggal'],
                'payment_method' => 'cash',
                'payment_status' => 'completed',
            ];
            $this->db->table('pembayaran')->insert($dataPembayaran);

            if ($this->db->affectedRows() <= 0) {
                throw new \Exception('Gagal menyimpan data pembayaran.');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaksi gagal diselesaikan.');
            }

            return true;
        } catch (\Exception $e) {
            $this->db->transRollback();

            // Log error untuk debugging
            log_message('error', $e->getMessage());
            log_message('error', $this->db->getLastQuery()); // Query terakhir
            log_message('error', json_encode($this->db->error())); // Informasi error database

            // Tampilkan pesan error untuk pengguna
            throw new \Exception('Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function getOrderByUserId($userId)
    {
        // Ambil data order berdasarkan user_id
        $orders = $this->where('user_id', $userId)->orderBy('id', 'DESC')->findAll();

        if ($orders) {
            foreach ($orders as &$order) {
                // Ambil data order_item berdasarkan order_id
                $orderItems = $this->db->table('order_item')
                    ->where('order_id', $order['id'])
                    // Relasi ke produk_varian
                    ->join('produk_varian', 'produk_varian.id = order_item.product_variant_id')
                    // Relasi ke produk
                    ->join('produk', 'produk.id = produk_varian.product_id')
                    // relasi ke gambar_produk
                    ->join('gambar_produk', 'gambar_produk.product_id = produk.id')
                    ->where('gambar_produk.is_primary', 1)
                    ->select('order_item.*, produk.name as product_name, produk_varian.size as product_size, produk_varian.color as product_color, gambar_produk.image as product_image')
                    ->get()
                    ->getResultArray();

                // Tambahkan order_item ke dalam data order
                $order['item'] = $orderItems;
            }
        }

        return $orders;
    }


    public function getOrder($keyword)
    {
        // relasi ke user
        $this->join('users', 'users.id = order.user_id');
        // select field
        $this->select('order.*, users.full_name as user_name');
        // where
        if ($keyword) {
            $this->like('order.status', $keyword);
        }
        return $this->orderBy('order.id', 'DESC')->findAll();
    }

    public function getOrderWhere()
    {
        // relasi ke user
        $this->join('users', 'users.id = order.user_id');
        // join ke order_item
        $this->join('order_item', 'order_item.order_id = order.id');
        // join ke produk_varian
        $this->join('produk_varian', 'produk_varian.id = order_item.product_variant_id');
        // join ke produk
        $this->join('produk', 'produk.id = produk_varian.product_id');
        // select field
        $this->select('order.*, users.full_name as user_name, produk.name as product_name, order_item.price as price, order_item.quantity as quantity, produk_varian.size as size, produk_varian.color as color');
        // where
        $this->where('order.status', 'completed');
        return $this->findAll();
    }
    public function getOrderById($id)
    {
        // relasi ke user
        $this->join('users', 'users.id = order.user_id');
        // select field
        $this->select('order.*, users.full_name as user_name, users.phone as phone');
        // bangun data
        $orderItem = new OrderItemModel();
        // relasi order_item ke produk_varian
        $orderItem->join('produk_varian', 'produk_varian.id = order_item.product_variant_id');
        // produk_varian ke produk
        $orderItem->join('produk', 'produk.id = produk_varian.product_id');
        // produk ke gambar
        $orderItem->join('gambar_produk', 'gambar_produk.product_id = produk.id');
        // where
        $orderItem->where('gambar_produk.is_primary', 1);
        // select field
        $orderItem->select('order_item.*, produk.name as product_name, produk_varian.size as product_size, produk_varian.color as product_color, gambar_produk.image as product_image');

        // tabel pembayaran
        $pembayaran = new PembayaranModel();
        // cek deadline pembayaran. Jika sudah lewat dari 1 hari, maka status order menjadi cancel

        $data = [
            'order' => $this->find($id),
            'order_item' => $orderItem->where('order_id', $id)->findAll(),
            'pembayaran' => $pembayaran->where('order_id', $id)->first(),
            'deadline' => date('Y-m-d H:i:s', strtotime('+1 day', strtotime($this->find($id)['order_date'])))
        ];
        return $data;
    }

    public function uploadBukti($data)
    {
        $pembayaran = new PembayaranModel();
        $pembayaran->insert($data);

        return true;
    }

    public function insertReview($data)
    {
        // relasi ke order_item
        $this->join('order_item', 'order_item.order_id = order.id');
        // where
        $this->where('order_item.id', $data['order_item_id']);
        // select field
        $this->select('order_item.product_variant_id');
        // get data
        $order = $this->first();
        $produkVarianId = $order['product_variant_id'];
        // cari ke tabel produk_varian
        $produkVarian = new ProdukVarianModel();
        $produkVarian->where('id', $produkVarianId);
        $produkVarian = $produkVarian->first();
        // cek apakah produk varian ada
        $reviews = [
            'product_id' => $produkVarian['product_id'],
            'user_id' => session()->get('id'),
            'rating' => $data['rating'],
            'review' => $data['review']
        ];

        // tabel reviews
        $this->db->table('reviews')->insert($reviews);

        return true;
    }

    public function getOrderByMonth($year, $month)
    {
        $builder = $this->db->table('order');
        $builder->select('DATE(order_date) as date, COUNT(*) as jumlah_order');
        $builder->where('status', 'completed');
        $builder->selectSum('total', 'total');
        $builder->where('YEAR(order_date)', $year);
        $builder->where('MONTH(order_date)', $month);
        $builder->groupBy('DATE(order_date)'); // Kelompokkan berdasarkan tanggal
        $builder->orderBy('DATE(order_date)', 'ASC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getReview($id)
    {
        // model review
        $review = new ReviewModel();
        // where
        $review->where('product_id', $id);
        // relasi ke tabel produk
        $review->join('produk', 'produk.id = reviews.product_id');
        // relasi ke tabel user
        $review->join('users', 'users.id = reviews.user_id');
        // select field
        $review->select('reviews.*, produk.name as product_name, users.full_name as user_name');
        // get data
        return $review->findAll();
    }
}
