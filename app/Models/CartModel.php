<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'keranjang';
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

    public function addToCart($data)
    {
        $this->insert($data);
    }

    public function getCart($user_id)
    {
        $customerCart = $this->where('user_id', $user_id)->findAll();

        $data = [];

        foreach ($customerCart as $cart) {
            $produkVarian = $this->db->table('produk_varian')->where('id', $cart['product_variant_id'])->get()->getRowArray();
            $produk = $this->db->table('produk')->where('id', $produkVarian['product_id'])->get()->getRowArray();
            $gambar = $this->db->table('gambar_produk')->where('product_id', $produk['id'])->get()->getRowArray();

            $diskon = $produkVarian['discount'];
            $harga = $produkVarian['price'];

            if ($diskon > 0) {
                $harga = $harga - ($harga * $diskon / 100);
            }

            $data[] = [
                'id' => $cart['id'],
                'produk_id' => $produk['id'],
                'name' => $produk['name'],
                'price' => $harga,
                'image' => $gambar['image'],
                'size' => $produkVarian['size'],
                'color' => $produkVarian['color'],
                'qty' => $cart['quantity'],
                'subtotal' => $harga * $cart['quantity']
            ];
        }

        return $data;
    }
}
