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

    public function customerLogin()
    {
        $data = [
            'title' => 'Login Customer'
        ];
        return view('customer/auth/customer_login', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Register'
        ];
        return view('customer/auth/register', $data);
    }

    public function signup()
    {
        $fullName = $this->request->getVar('full_name');

        // username adalah full name yang di lowercase tanpa spasi
        $username = strtolower(str_replace(' ', '', $fullName));
        $data = [
            'full_name' => $this->request->getVar('full_name'),
            'username' => $username,
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => 'customer'
        ];

        $this->user->insert($data);
        return redirect()->to(base_url('customer/login'))->with('success', 'Registrasi Berhasil, Silahkan Login');
    }

    public function auth()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // jika admih menggunakan username dan password


        $user = $this->user->where('username', $username)->first();

        if ($user['role'] == 'admin') {
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

    public function authCustomer()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // jika admih menggunakan username dan password


        $user = $this->user->where('email', $email)->first();

        if ($user['role'] == 'customer') {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($data);
                return redirect()->to(base_url('/'))->with('success', 'Selamat Datang ' . $user['full_name']);
            } else {
                session()->setFlashdata('error', 'Password Salah');
                return redirect()->to(base_url('customer/login'));
            }
        } else {
            session()->setFlashdata('error', 'username tidak ditemukan');
            return redirect()->to(base_url('customer/login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function customerLogout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
