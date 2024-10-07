<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GambarProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'is_primary' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'comment'    => 'Tandai gambar utama',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'produk', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('gambar_produk');
    }

    public function down()
    {
        $this->forge->dropTable('gambar_produk');
    }
}
