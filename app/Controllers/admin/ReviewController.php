<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ReviewController extends BaseController
{
    protected $reviewModel;
    public function __construct()
    {
        $this->reviewModel = new \App\Models\ReviewModel();
    }
    public function index()
    {
        $review = $this->reviewModel->getReview();
        $data = [
            'title' => 'Review',
            'data' => $review
        ];
        return view('admin/review/index', $data);
    }
}
