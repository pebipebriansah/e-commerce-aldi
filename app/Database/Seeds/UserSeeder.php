<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'email'    => 'admin@admin.com',
            'full_name' => 'Administrator',
            'role' => 'admin',
            'address' => 'Ciawigebang',
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
