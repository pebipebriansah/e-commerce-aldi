<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;
    protected $imageModel;
    // cunstructor
    public function __construct()
    {
        $this->produkModel = new \App\Models\ProdukModel();
        $this->kategoriModel = new \App\Models\KategoriModel();
        $this->imageModel = new \App\Models\GambarModel();
    }
    public function index()
    {
        $produk = $this->produkModel->getProduk();
        $data = [
            'title' => 'Produk',
            'data' => $produk,
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
        $colors = $this->request->getPost('color');

        // Proses gambar
        $images = $this->request->getFileMultiple('images'); // Mendapatkan semua file gambar

        // Simpan gambar ke folder dan buat array untuk menyimpan nama file
        $imageNames = [];
        foreach ($images as $image) {
            if ($image->isValid() && !$image->hasMoved()) {
                $imageName = $image->getRandomName();
                $image->move('produk', $imageName);
                $imageNames[] = $imageName;
            }
        }

        // Siapkan array varian
        $variants = [];
        for ($i = 0; $i < count($sizes); $i++) {
            $variants[] = [
                'size' => $sizes[$i],
                'price' => $prices[$i],
                'stock' => $stocks[$i],
                'color' => $colors[$i]
            ];
        }

        $data = [
            'name' => $name,
            'description' => $deskripsi,
            'category_id' => $kategori,
            'variants' => $variants,
            'images' => $imageNames // Array gambar
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

    public function edit($id)
    {
        $produk = $this->produkModel->getProdukById($id);
        $category = $this->kategoriModel->findAll();
        $data = [
            'title' => 'Edit Produk',
            'product' => $produk,
            'categories' => $category
        ];
        return view('admin/produk/edit', $data);
    }

    public function update()
    {

        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori = $this->request->getPost('kategori');
        $imagesToDelete = json_decode($this->request->getPost('images_to_delete'), true); // Gambar yang ditandai untuk dihapus
        $uploadedImages = $this->request->getFileMultiple('images'); // Mendapatkan semua file yang di-upload

        $sizes = $this->request->getPost('size');
        $prices = $this->request->getPost('price');
        $stocks = $this->request->getPost('stock');
        $colors = $this->request->getPost('color');
        $discounts = $this->request->getPost('discount');


        // Hapus gambar yang ditandai untuk dihapus
        $imageIdDelete = [];
        if (!empty($imagesToDelete)) {
            foreach ($imagesToDelete as $imageId) {
                $imageIdDelete[] = $imageId;
            }
        }

        $imageNames = [];
        if (!empty($uploadedImages)) {
            foreach ($uploadedImages as $image) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $imageName = $image->getRandomName();
                    $image->move('produk', $imageName);
                    $imageNames[] = $imageName;
                }
            }
        }

        // Siapkan array varian
        $variants = [];
        for ($i = 0; $i < count($sizes); $i++) {
            $variants[] = [
                'size' => $sizes[$i],
                'price' => $prices[$i],
                'stock' => $stocks[$i],
                'color' => $colors[$i],
                'discount' => $discounts[$i]
            ];
        }

        $data = [
            'id' => $id,
            'name' => $name,
            'description' => $deskripsi,
            'category_id' => $kategori,
            'variants' => $variants,
            'images' => $imageNames,
            'imageId' => $imageIdDelete // Array gambar
        ];

        $this->produkModel->updateProduk($data);
        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil diperbarui');
    }
}
