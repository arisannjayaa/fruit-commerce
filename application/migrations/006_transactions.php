<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Transactions extends CI_Migration
{
    protected $tableName  = 'transactions';
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->load->helper('custom');
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
			'order_id' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255'
			],
			'products' => [
				'type'              => 'JSON',
			],
			'gross_amount' => [
				'type'              => 'DOUBLE',
			],
			'status_code' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
			'payment_type' => [
				'type' 				=> 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
			'bank' => [
				'type' 				=> 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
			'va_number' => [
				'type' 				=> 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
			'pdf_url' => [
				'type' 				=> 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
			],
        ]);

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
		$this->dbforge->add_field("transaction_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
        $this->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE');

        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        // Hapus tabel users
        $this->dbforge->drop_table($this->tableName);
    }
}

/* End of file 20240606231741_users.php and path \application\migrations\20240606231741_users.php */
