<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PromosiController extends BaseController
{
    protected $promosiModel;
    protected $produkVarianModel;
    protected $produkModel;

    public function __construct()
    {
        $this->promosiModel = new \App\Models\PromosiModel();
        $this->produkVarianModel = new \App\Models\ProdukVarianModel();
        $this->produkModel = new \App\Models\ProdukModel();
    }

    public function index()
    {
        $promo = $this->promosiModel->findAll();
        $data = [
            'title' => 'Promosi',
            'data' => $promo
        ];

        return view('admin/promosi/promosi', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Promosi'
        ];

        return view('admin/promosi/tambah', $data);
    }

    public function addPromo()
    {
        $variasi = $this->request->getVar('variasi');
        $nama_promosi = $this->request->getVar('name');
        $tgl_mulai = $this->request->getVar('tgl_mulai');
        $tgl_selesai = $this->request->getVar('tgl_selesai');
        $banner_promo = $this->request->getFile('image');
        $diskon = $this->request->getVar('diskon');


        $rules = [
            'name' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {

            // random nama file
            $nama_file = $banner_promo->getRandomName();

            $promoData = [
                'promotion_name' => $nama_promosi,
                'start_date' => $tgl_mulai,
                'end_date' => $tgl_selesai,
                'banner' => $nama_file
            ];

            $banner_promo->move('promo', $nama_file);
            $this->promosiModel->insert($promoData);

            $promoId = $this->promosiModel->insertID();

            // loop setiap variasi produk dan diskon
            foreach ($variasi as $key => $value) {
                // Decode JSON string menjadi array
                $decodedValue = json_decode($value, true);

                // Pastikan decoding berhasil dan key 'id' ada
                if (is_array($decodedValue) && isset($decodedValue['id'])) {
                    $this->produkVarianModel->update($decodedValue['id'], [
                        'discount' => $diskon[$key],
                        'promotion_id' => $promoId
                    ]);
                }
            }

            return redirect()->to(base_url('admin/promosi'))->with('success', 'Promosi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/promosi'))->with('error', 'Promosi gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $promo = $this->promosiModel->find($id);
        // cari ke tabel produk_varian dengan id promosi
        $produkVarian = $this->produkVarianModel->where('promotion_id', $id)->findAll();

        $data = [
            'title' => 'Edit Promosi',
            'data' => $promo,
            'produk' => $produkVarian,
            'produks' => $this->produkModel->findAll()
        ];

        return view('admin/promosi/edit', $data);
    }

    public function update()
    {
        $idPromo = $this->request->getVar('id');
        $variasi = $this->request->getVar('variasi');
        $diskon = $this->request->getVar('diskon');
        $name = $this->request->getVar('name');
        $tgl_mulai = $this->request->getVar('tgl_mulai');
        $tgl_selesai = $this->request->getVar('tgl_selesai');
        $banner_promo = $this->request->getFile('image');


        // Cek apakah user mengupload banner baru
        if ($banner_promo->isValid()) {
            $rules = [
                'name' => 'required',
                'tgl_mulai' => 'required',
                'tgl_selesai' => 'required',
                'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]'
            ];
        } else {
            $rules = [
                'name' => 'required',
                'tgl_mulai' => 'required',
                'tgl_selesai' => 'required'
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        try {
            $promoData = [
                'promotion_name' => $name,
                'start_date' => $tgl_mulai,
                'end_date' => $tgl_selesai
            ];

            // Cek apakah user mengupload banner baru
            if ($banner_promo->isValid()) {
                // random nama file
                $nama_file = $banner_promo->getRandomName();
                $promoData['banner'] = $nama_file;
                $banner_promo->move('promo', $nama_file);
            }

            $this->promosiModel->update($idPromo, $promoData);

            // loop setiap variasi produk dan diskon
            for ($i = 0; $i < count($variasi); $i++) {
                $this->produkVarianModel->update($variasi[$i], [
                    'discount' => $diskon[$i],
                    'promotion_id' => $idPromo
                ]);
            }
            return redirect()->to(base_url('admin/promosi'))->with('success', 'Promosi berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Promosi gagal diupdate');
        }
    }

    public function delete()
    {
        // terima data json id
        $id = $this->request->getJSON('id');

        try {
            $this->produkVarianModel->where('promotion_id', $id)->set(['promotion_id' => 0, 'discount' => 0])->update();
            $this->promosiModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Promosi berhasil dihapus']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Promosi gagal dihapus']);
        }
    }
}
