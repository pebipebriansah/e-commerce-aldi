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

    public function updateCart($data)
    {
        // update where id, update qty
        $this->update($data['id'], ['quantity' => $data['qty']]);
    }

    public function getProvinsi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 6bad9044fb6fdb33caac381cb5b5bc5c"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);
            $data_provinsi = $array_response['rajaongkir']['results'];

            return $data_provinsi;
        }
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

    public function getCartByUserId($id)
    {
        return $this->where('user_id', $id)->findAll();
    }

    public function deleteCart($id)
    {
        // delete cart by user_id
        $this->where('user_id', $id)->delete();
    }
}
