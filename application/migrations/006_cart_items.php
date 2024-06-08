<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Cart_Items extends CI_Migration
{
    protected $tableName  = 'cart_items';
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
                'auto_increment'    => TRUE
            ],
			'cart_id' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
			],
			'product_id' => [
				'type'              => 'INT',
				'constraint'        => 11,
				'unsigned'          => TRUE,
			],
			'quantity' => [
				'type'              => 'INT',
				'constraint'        => 11
			],
        ]);

        $this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field("updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
        $this->dbforge->add_field("created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE ON UPDATE CASCADE');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE');

        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        // Hapus tabel users
        $this->dbforge->drop_table($this->tableName);
    }
}

/* End of file 20240606231741_users.php and path \application\migrations\20240606231741_users.php */
