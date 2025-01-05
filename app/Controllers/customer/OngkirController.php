<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class OngkirController extends BaseController
{
    private $api_key = '6bad9044fb6fdb33caac381cb5b5bc5c';
    private $userModel;

    // constructor
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }
    public function index()
    {

        $curl = curl_init();
        // terima data dari fetch
        $id = $this->request->getPost('id_provinsi');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);
            $data_kota = $array_response['rajaongkir']['results'];
            // echo select kota
            echo "<option value=''>Pilih Kabupaten/Kota</option>";
            foreach ($data_kota as $key => $value) {
                echo "<option value='" . $value['city_name'] . "'id_kota='" . $value['city_id'] . "'>" . $value['city_name'] . "</option>";
            }
        }
    }

    public function ongkir()
    {
        $user_id = session()->get('id');
        $id_kota_asal = 45591; // Kuningan
        $alamat = $this->userModel->where('id', $user_id)->first()['address'];
        // isi dari $alamat adalah CIAWILOR, CIAWIGEBANG, KUNINGAN, JAWA BARAT, 45591 kemudian kita ambil kode posnya
        $id_kota = explode(', ', $alamat);
        $id_kota = $id_kota[4]; // 45591
        $berat = 1000; // 1 kg
        $expedisi = $this->request->getPost('expedisi');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $id_kota_asal . "&destination=" . $id_kota . "&weight=" . $berat . "&courier=" . $expedisi,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: bcd65694a694a9bb206302a2adb9e216"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);

            // Memastikan bahwa data 'data' ada dalam respons
            if (isset($array_response['data']) && !empty($array_response['data'])) {
                $data_paket = $array_response['data'];

                // Menampilkan opsi kosong terlebih dahulu
                echo "<option value=''>--Pilih Paket---</option>";

                // Iterasi data paket ongkir dan tampilkan di dropdown
                foreach ($data_paket as $key => $value) {
                    // Mendapatkan estimasi pengiriman dan biaya ongkir
                    $estimasi = $value['service'] . " | " . $value['etd'];
                    $ongkir = $value['cost']; // Biaya ongkir
                    $etd = $value['etd']; // Estimasi waktu pengiriman (hari)

                    // Membuat tag option untuk setiap paket ongkir
                    echo "<option value='" . $estimasi . "' ongkir='" . $ongkir . "' estimasi='" . $etd . "'>";
                    echo $value['service'] . " | Rp." . number_format($ongkir, 0, ',', '.') . " | " . $etd;
                    echo "</option>";
                }
            } else {
                // Jika tidak ada data ongkir yang ditemukan
                echo "<option value=''>Ongkir tidak tersedia</option>";
            }
        }
    }

    public function alamat()
    {
        $curl = curl_init();
        // terima data dari fetch
        $search = $this->request->getGet('term');
        if (!$search == '') {

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=" . $search,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "key: bcd65694a694a9bb206302a2adb9e216"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return $this->response->setJSON([
                    'meta' => [
                        'message' => "Error fetching data",
                        'code' => 500,
                        'status' => 'error'
                    ],
                    'data' => []
                ]);
            } else {
                $responseData = json_decode($response, true); // Decode respons JSON
                $results = array_map(function ($item) {
                    return [
                        'id' => $item['label'], // ID untuk value
                        'text' => $item['label'] // Label untuk ditampilkan
                    ];
                }, $responseData['data']); // Sesuaikan dengan key 'data' pada respons asli

                return $this->response->setJSON([
                    'results' => $results // Select2 membutuhkan key 'results'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'results' => [] // Jika term kosong, kembalikan array kosong
            ]);
        }
    }
}
