<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Transactions extends CI_Migration
{
    protected $tableName  = 'addresses';
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function up()
    {
        $this->dbforge->add_field([
            'id' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
				'auto_increment'    => TRUE,
            ],
			'user_id' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
			],
			'address' => [
				'type'              => 'VARCHAR',
				'constraint'        => 255,
			],
			'label' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
			'addressee' => [
				'type'              => 'VARCHAR',
				'constraint'        => 255,
			],
			'telephone' => [
				'type'              => 'VARCHAR',
				'constraint'        => 255,
			],
			'postal_code' => [
				'type'              => 'DOUBLE',
			],
			'is_primary' => [
				'type' 				=> 'BOOLEAN',
				'default'			=> false,
			],
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE');

		$this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->tableName);
    }
}
