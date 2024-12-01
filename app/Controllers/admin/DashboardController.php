<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
    }

    public function index()
    {
        // Tahun dan bulan saat ini
        $currentYear = date('Y');
        $currentMonth = date('n');

        // Tentukan rentang tahun (misalnya, dari 2022 hingga tahun saat ini)
        $startYear = date('Y');
        $endYear = $currentYear;

        $months = [];

        // Generate bulan dan tahun dari rentang waktu
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                // Jangan tambahkan bulan di masa depan jika tahun adalah tahun ini
                if ($year == $currentYear && $month > $currentMonth) {
                    break;
                }

                $months[] = [
                    'value' => sprintf('%04d-%02d', $year, $month), // Format Y-m
                    'text' => date('F Y', mktime(0, 0, 0, $month, 1, $year)), // Nama bulan
                ];
            }
        }

        // get value

        $dateFilter = $this->request->getGet('value');

        if ($dateFilter) {
            $date = explode('-', $dateFilter);
            $grafik = $this->orderModel->getOrderByMonth($date[0], $date[1]);
        } else {
            $grafik = $this->orderModel->getOrderByMonth(date('Y'), date('m'));
        }


        // grafik order buat menjadi 2 array
        $data = [
            'title' => 'Dashboard',
            'grafik' => $grafik,
            'months' => $months,
            'dateFilter' => $dateFilter ? $dateFilter : date('Y-m'),
        ];
        return view('admin/dashboard/index', $data);
    }
}
