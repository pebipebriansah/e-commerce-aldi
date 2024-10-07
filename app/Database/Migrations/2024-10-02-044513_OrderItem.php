<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderItem extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
            ],
            'product_variant_id' => [
                'type' => 'INT',
            ],
            'quantity' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_variant_id', 'produk_varian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_item');
    }

    public function down()
    {
        $this->forge->dropTable('order_item');
    }
}
