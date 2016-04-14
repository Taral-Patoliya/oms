<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_pending_tasks extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'pending_tasks';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'created_by' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        ),
        'created_on' => array(
            'type'       => 'DATETIME',
            'null'       => true,
            'default'    => '0000-00-00 00:00:00',
        ),
        'title' => array(
            'type'       => 'VARCHAR',
            'constraint' => 256,
            'null'       => false,
        ),
        'content' => array(
            'type'       => 'VARCHAR',
            'constraint' => 512,
            'null'       => true,
        ),
        'status' => array(
            'type'       => 'BOOL',
            'null'       => false,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}