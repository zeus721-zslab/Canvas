<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddFieldToUsers extends Migration
{
    /**
     * @var string[]
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
                'mobile_number' => ['type' => 'VARCHAR', 'constraint' => '13', 'null' => true]
            ,   'login_id'      => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => false]
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [ 'mobile_number'];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}