<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OngkirController extends BaseController
{
    private $api_key = '6bad9044fb6fdb33caac381cb5b5bc5c';
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
        $id_kota_asal = 211; // Kuningan
        $id_kota = $this->request->getPost('id_kota');
        $berat = 1000;
        $expedisi = $this->request->getPost('expedisi');
        $curl = curl_init();
        // terima data dari fetch

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
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
            //echo '<pre>';
            //print_r($array_response['rajaongkir']['results'][0]['costs']);
            //echo '</pre>';
            $data_paket = $array_response['rajaongkir']['results'][0]['costs'];
            echo "<option value=''>--Pilih Paket---</option>";
            foreach ($data_paket as $key => $value) {
                $estimasi = $value['service']  . " | " . $value['cost'][0]['etd'] . " Hari";
                echo "<option value='" . $estimasi . "' ongkir='" . $value['cost'][0]['value'] . "' estimasi='" . $value['cost'][0]['etd'] . " Hari'>";
                echo $value['service'] . " | Rp." . $value['cost'][0]['value'] . " | " . $value['cost'][0]['etd'] . " Hari";
                echo "</option>";
            }
        }
    }
}
