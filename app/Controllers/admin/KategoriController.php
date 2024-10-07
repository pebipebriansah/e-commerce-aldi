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
        $data = [
            'title' => 'Kategori',
        ];

        return view('admin/kategori/index', $data);
    }

    public function getData()
    {

        $kategori = $this->kategoriModel->orderBy('id', 'DESC')->findAll();

        $data = [
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'Data berhasil ditemukan',
            'data' => $kategori,

        ];

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $kategoriModel = new \App\Models\KategoriModel();
        $data = $this->request->getJSON();

        $insert = $kategoriModel->insert($data);
        if (!$insert) {
            $data = [
                'status' => ResponseInterface::HTTP_BAD_REQUEST,
                'message' => 'Data gagal ditambahkan',
            ];

            return $this->response->setJSON($data);
        }

        $data = [
            'status' => ResponseInterface::HTTP_CREATED,
            'message' => 'Data berhasil ditambahkan',
        ];

        return $this->response->setJSON($data);
    }
}
