<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Config\App;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Login Admin'
        ];
        return view('admin/auth/login', $data);
    }

    public function auth()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->user->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($data);
                return redirect()->to(base_url('admin/dashboard'))->with('success', 'Selamat Datang ' . $user['full_name']);
            } else {
                session()->setFlashdata('error', 'Password Salah');
                return redirect()->to(base_url('login'));
            }
        } else {
            session()->setFlashdata('error', 'username tidak ditemukan');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
