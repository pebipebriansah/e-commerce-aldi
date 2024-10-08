<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
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

    public function getProduk()
    {
        return $this->db->table('produk')
            ->select('produk.id as produk_id, produk.name, produk.description, MIN(produk_varian.id) as varian_id, MIN(produk_varian.price) as price, MIN(produk_varian.stock) as stock, MIN(gambar_produk.image) as image')
            ->join('produk_varian', 'produk_varian.product_id = produk.id')
            ->join('gambar_produk', 'gambar_produk.product_id = produk.id')
            ->groupBy('produk.id')
            ->orderBy('produk_id', 'DESC')  // Mengelompokkan berdasarkan produk
            ->get()
            ->getResultArray();
    }
    // insert data produk
    public function insertProduk($data)
    {
        $this->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
        ]);
        $product_id = $this->insertID();

        // Loop melalui setiap varian
        foreach ($data['variants'] as $variant) {
            // Konversi array ke JSON jika diperlukan
            $this->db->table('produk_varian')->insert([
                'product_id' => $product_id,
                'size' => $variant['size'], // Jika size di sini hanya string, langsung dimasukkan
                'price' => $variant['price'], // Harga
                'stock' => $variant['stock'], // Stok
            ]);
        }

        // Simpan gambar ke tabel gambar_produk
        foreach ($data['images'] as $image) {
            $this->db->table('gambar_produk')->insert([
                'product_id' => $product_id,
                'image' => $image
            ]);
        }
    }

    public function updateProduk($data)
    {
        $this->update($data['id'], [
            'name' => $data['name'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
        ]);

        // Loop melalui setiap varian
        foreach ($data['variants'] as $variant) {
            // Konversi array ke JSON jika diperlukan
            $this->db->table('produk_varian')->where('product_id', $data['id'])->set([
                'product_id' => $data['id'],
                'size' => $variant['size'], // Jika size di sini hanya string, langsung dimasukkan
                'price' => $variant['price'], // Harga
                'stock' => $variant['stock'], // Stok
            ])->update();
        }

        // Simpan gambar ke tabel gambar_produk
        foreach ($data['images'] as $image) {
            $this->db->table('gambar_produk')->where('product_id', $data['id'])->set([
                'product_id' => $data['id'],
                'image' => $image
            ])->update();
        }
    }

    public function deleteProduk($id)
    {
        $this->delete($id);
        // delete varian
        $this->db->table('produk_varian')->where('product_id', $id)->delete();
        // delete gambar
        $this->db->table('gambar_produk')->where('product_id', $id)->delete();

        return true;
    }
}
