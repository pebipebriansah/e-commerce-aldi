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
        // Ambil semua data produk
        $produk = $this->orderBy('id', 'DESC')->findAll();

        // Array untuk menyimpan hasil akhir
        $allData = [];

        foreach ($produk as $p) {
            // Ambil varian untuk setiap produk
            $varian = $this->db->table('produk_varian')
                ->where('product_id', $p['id'])
                ->get()
                ->getResultArray();

            // Ambil gambar untuk setiap produk
            $gambar = $this->db->table('gambar_produk')
                ->where('product_id', $p['id'])
                ->get()
                ->getResultArray();

            // Siapkan array size dan image untuk tiap produk
            $size = [];
            $image = [];

            foreach ($varian as $v) {
                $size[] = [
                    'variant_id' => $v['id'],
                    'size' => $v['size'],
                    'price' => $v['price'],
                    'stock' => $v['stock'],
                    'color' => $v['color'],
                    'discount' => $v['discount'],
                ];
            }

            foreach ($gambar as $g) {
                $image[] = [
                    'id' => $g['id'],
                    'image' => $g['image'],
                    'is_primary' => $g['is_primary']
                ];
            }

            // Struktur data untuk tiap produk
            $data = [
                'produk_id' => $p['id'],
                'name' => $p['name'],
                'description' => $p['description'],
                'category_id' => $p['category_id'],
                'size' => $size,
                'image' => $image,
            ];

            // Tambahkan data produk ke array hasil akhir
            $allData[] = $data;
        }

        return $allData;
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
                'size' => $variant['size'],
                'color' => $variant['color'], // Jika size di sini hanya string, langsung dimasukkan
                'price' => $variant['price'], // Harga
                'stock' => $variant['stock'], // Stok
            ]);
        }

        // Simpan gambar ke tabel gambar_produk
        foreach ($data['images'] as $index => $image) {
            $this->db->table('gambar_produk')->insert([
                'product_id' => $product_id,
                'image' => $image,
                'is_primary' => $index === 0 ? 1 : 0,
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

        if ($data['variants']) {
            // delete all variant with id
            $this->db->table('produk_varian')->where('product_id', $data['id'])->delete();
            // Loop melalui setiap varian
            foreach ($data['variants'] as $variant) {
                // Konversi array ke JSON jika diperlukan
                $this->db->table('produk_varian')->insert([
                    'product_id' => $data['id'],
                    'size' => $variant['size'], // Jika size di sini hanya string, langsung dimasukkan
                    'price' => $variant['price'], // Harga
                    'color' => $variant['color'], // Warna
                    'stock' => $variant['stock'], // Stok
                    'discount' => $variant['discount'], // Diskon
                ]);
            }
        }

        if ($data['imageId']) {
            // Ambil semua gambar berdasarkan product_id
            $images = $this->db->table('gambar_produk')->where('product_id', $data['id'])->get()->getResultArray();

            // Hapus setiap file gambar dari folder dan data dari database
            foreach ($images as $image) {
                $filePath = 'produk/' . $image['image'];

                // Hapus file jika ada
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data gambar dari database berdasarkan product_id
            $this->db->table('gambar_produk')->where('product_id', $data['id'])->delete();
        }

        if ($data['images']) {
            // Simpan gambar ke tabel gambar_produk
            foreach ($data['images'] as $index => $image) {
                $this->db->table('gambar_produk')->insert([
                    'product_id' => $data['id'],
                    'image' => $image,
                    'is_primary' => 0,
                ]);
            }
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

    public function getProdukById($id)
    {
        // cari ke tabel roduk
        $produk = $this->find($id);
        // cari ke tabel produk_varian
        $varian = $this->db->table('produk_varian')->where('product_id', $id)->get()->getResultArray();
        // cari ke tabel gambar_produk
        $gambar = $this->db->table('gambar_produk')->where('product_id', $id)->get()->getResultArray();

        $size = [];
        $image = [];

        foreach ($varian as $v) {
            $size[] = [
                'variant_id' => $v['id'],
                'size' => $v['size'],
                'price' => $v['price'],
                'stock' => $v['stock'],
                'color' => $v['color'],
                'discount' => $v['discount'],
            ];
        }
        foreach ($gambar as $g) {
            $image[] = [
                'id' => $g['id'],
                'image' => $g['image'],
                'is_primary' => $g['is_primary']
            ];
        }

        $data = [
            'product_id' => $id,
            'name' => $produk['name'],
            'description' => $produk['description'],
            'category_id' => $produk['category_id'],
            'size' => $size,
            'image' => $image,

        ];

        return $data;
    }
}
