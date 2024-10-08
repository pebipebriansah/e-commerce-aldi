<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KategoriController extends BaseController
{
    protected $kategoriModel;
    // cunstructor
    public function __construct()
    {
        $this->kategoriModel = new \App\Models\KategoriModel();
    }
    public function index()
    {
        $kategori = $this->kategoriModel->orderBy('id', 'DESC')->findAll();
        $data = [
            'title' => 'Kategori',
            'data' => $kategori
        ];

        return view('admin/kategori/index', $data);
    }

    public function add()
    {
        $name = $this->request->getPost('name');
        $deskripsi = $this->request->getPost('deskripsi');
        $this->kategoriModel->insert([
            'name' => $name,
            'description' => $deskripsi,
        ]);

        return redirect()->to(base_url('admin/kategori'))->with('success', 'Data berhasil ditambahkan');
    }

    public function delete()
    {
        // Terima POST id
        $requestBody = $this->request->getJSON();

        $id = $requestBody->id;
        // Cek apakah id valid
        if ($id) {
            // Coba hapus kategori berdasarkan id
            $deleted = $this->kategoriModel->delete($id);

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
            'message' => 'ID tidak valid' . $id,
        ]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $deskripsi = $this->request->getPost('deskripsi');

        $this->kategoriModel->where('id', $id)->set([
            'name' => $name,
            'description' => $deskripsi,
        ])->update();

        return redirect()->to(base_url('admin/kategori'))->with('success', 'Data berhasil diupdate');
    }
}
