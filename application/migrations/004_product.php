<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Product extends CI_Migration
{
    protected $tableName  = 'products';

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
			'title' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
			'category_id' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
			],
			'created_by' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
			],
			'slug' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
			'description' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
			'stock' => [
				'type'              => 'INT',
				'constraint'        => 11
			],
			'price' => [
				'type'              => 'INT',
				'constraint'        => 11
			],
        ]);

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
        $this->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE');

        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        // Hapus tabel users
        $this->dbforge->drop_table($this->tableName);
    }
}

/* End of file 20240606231741_users.php and path \application\migrations\20240606231741_users.php */
