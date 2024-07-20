<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Product extends CI_Migration
{
    protected $tableName  = 'products';
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
			'attachment' => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
				'null'				=> true
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
				'type'              => 'LONGTEXT',
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
		for ($i=1; $i < 5; $i++) {
			$this->db->insert($this->tableName, [
				'created_by' => 1,
				'title'   => 'Strawberry-'.$i,
				'slug' => slug("Strawberry-".$i),
				'category_id' => rand(1,4),
				'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales nunc eu enim dignissim, eu sagittis leo semper. Ut tempor, neque non ullamcorper lobortis, ante sem molestie leo, eu dapibus diam mi id eros. Praesent ac viverra dolor. Nunc dictum, nisl ac tincidunt porttitor, neque leo blandit neque, non efficitur purus dui in ante. Fusce tristique velit lectus, non consectetur neque rhoncus at. Mauris vitae sapien at est tempor viverra. Donec efficitur hendrerit viverra. In lobortis eros eget commodo elementum. Suspendisse pulvinar eu odio non maximus. Aenean vestibulum lacus ut nisl commodo, ut efficitur lorem malesuada. Phasellus quis congue tortor, in ultrices odio. Cras feugiat sagittis ex in efficitur. Donec varius enim ante, placerat porta massa suscipit vel. Fusce sed gravida felis. Proin nec augue ex.",
				'stock' => rand(1,10),
				'price' => rand(1, 10),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);
		}
    }

    public function down()
    {
        // Hapus tabel users
        $this->dbforge->drop_table($this->tableName);
    }
}

/* End of file 20240606231741_users.php and path \application\migrations\20240606231741_users.php */
