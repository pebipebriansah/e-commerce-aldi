<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;
    // cunstructor
    public function __construct()
    {
        $this->produkModel = new \App\Models\ProdukModel();
        $this->kategoriModel = new \App\Models\KategoriModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Produk',
            'data' => $this->produkModel->getProduk()
        ];

        return view('admin/produk/produk', $data);
    }
    public function tambah()
    {
        $kategori = $this->kategoriModel->findAll();
        $data = [
            'title' => 'Tambah Produk',
            'categories' => $kategori
        ];
        return view('admin/produk/tambah', $data);
    }
    public function add()
    {
        $name = $this->request->getPost('name');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori = $this->request->getPost('kategori');

        // Ambil data size, price, dan stock
        $sizes = $this->request->getPost('size');
        $prices = $this->request->getPost('price');
        $stocks = $this->request->getPost('stock');

        // Proses gambar
        $image = $this->request->getFile('image');

        // Simpan gambar ke folder
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('produk', $imageName);
        } else {
            $imageName = 'default.jpg'; // Jika gambar tidak di-upload
        }

        // Siapkan array varian
        $variants = [];
        for ($i = 0; $i < count($sizes); $i++) {
            $variants[] = [
                'size' => $sizes[$i],
                'price' => $prices[$i],
                'stock' => $stocks[$i]
            ];
        }

        $data = [
            'name' => $name,
            'description' => $deskripsi,
            'category_id' => $kategori,
            'variants' => $variants, // Kirim data varian dalam bentuk array
            'images' => [$imageName] // Gambar dalam bentuk array, jika lebih dari satu bisa ditambahkan
        ];

        // Kirim data ke model
        $this->produkModel->insertProduk($data);

        // Redirect setelah berhasil menambahkan produk
        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil ditambahkan');
    }

    public function delete()
    {
        // Terima POST id
        $requestBody = $this->request->getJSON();

        $id = $requestBody->id;
        // Cek apakah id valid
        if ($id) {
            // Coba hapus produk berdasarkan id
            $deleted = $this->produkModel->deleteProduk($id);

            if ($deleted) {
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data tidak ditemukan' . $id,
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'ID tidak valid ' . $id,
        ]);
    }
}
