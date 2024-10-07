<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukVarian extends Migration
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
                'null' => false,
            ],
            'size' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'stock' => [
                'type'       => 'INT',
                'null'       => false,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'produk', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_varian');
    }

    public function down()
    {
        $this->forge->dropTable('produk_varian');
    }
}
