<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Diskon extends Migration
{
    public function up()
    {
        // $this->forge->addField([
        //     'id' => [
        //         'type'           => 'INT',
        //         'auto_increment' => true,
        //     ],
        //     'product_id' => [
        //         'type' => 'INT',
        //         'null' => false,
        //     ],
        //     'size' => [
        //         'type'       => 'VARCHAR',
        //         'constraint' => '50',
        //         'null'       => true,  // Nullable for discounts that apply to all sizes
        //     ],
        //     'discount_type' => [
        //         'type'       => 'ENUM',
        //         'constraint' => ['percentage', 'fixed'],
        //         'default'    => 'percentage',
        //     ],
        //     'discount_value' => [
        //         'type'       => 'DECIMAL',
        //         'constraint' => '10,2',
        //         'null'       => false,
        //     ],
        //     'start_date' => [
        //         'type'    => 'DATETIME',
        //         'null'    => true,
        //     ],
        //     'end_date' => [
        //         'type'    => 'DATETIME',
        //         'null'    => true,
        //     ],
        //     'created_at' => [
        //         'type'    => 'TIMESTAMP',
        //         'null'    => true,
        //         'default' => 'CURRENT_TIMESTAMP',
        //     ],
        // ]);
        // $this->forge->addKey('id', true);
        // $this->forge->addForeignKey('product_id', 'produk', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->createTable('diskon');
    }

    public function down()
    {
        // $this->forge->dropTable('diskon');
    }
}
