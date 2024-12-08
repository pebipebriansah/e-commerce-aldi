<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'pemilik',
            'password' => password_hash('pemilik123', PASSWORD_DEFAULT),
            'email'    => 'pemilik@admin.com',
            'full_name' => 'Pemilik',
            'role' => 'owner',
            'address' => 'Ciawigebang',
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
