<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Category extends CI_Migration
{
    protected $tableName  = 'categories';

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => TRUE,
                'auto_increment'    => TRUE
            ],
			'attachment' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
			'name' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
        ]);

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
        $this->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");

        $this->dbforge->create_table($this->tableName);
		$this->db->insert($this->tableName, [
            'attachment'   => 'uploads/category/default.jpg',
            'name'   => 'Buah',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
        ]);

		$this->db->insert($this->tableName, [
			'attachment'   => 'uploads/category/default.jpg',
			'name'   => 'Sayur',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);
    }

    public function down()
    {
        // Hapus tabel users
        $this->dbforge->drop_table($this->tableName);
    }
}

/* End of file 20240606231741_users.php and path \application\migrations\20240606231741_users.php */
