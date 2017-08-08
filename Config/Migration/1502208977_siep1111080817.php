<?php
class Siep1111080817 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'siep1111080817';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'barrios' => array(
					'ciudad_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'after' => 'nombre'),
				),
				'personas' => array(
					'ciudad_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'after' => 'calle_nro'),
					'asentamiento_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'after' => 'barrio_id'),
					'pueblosoriginario_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'after' => 'asentamiento_id'),
				),
			),
			'alter_field' => array(
				'ciclos' => array(
					'primer_periodo' => array('type' => 'date', 'null' => true, 'default' => null),
					'segundo_periodo' => array('type' => 'date', 'null' => true, 'default' => null),
					'tercer_periodo' => array('type' => 'date', 'null' => true, 'default' => null),
				),
				'personas' => array(
					'barrio_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
				),
			),
			'create_table' => array(
				'ciudads' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'pueblosoriginarios' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),
			),
			'drop_field' => array(
				'personas' => array('indigena', 'asentamiento', 'ciudad'),
			),
		),
		'down' => array(
			'drop_field' => array(
				'barrios' => array('ciudad_id'),
				'personas' => array('ciudad_id', 'asentamiento_id', 'pueblosoriginario_id'),
			),
			'alter_field' => array(
				'ciclos' => array(
					'primer_periodo' => array('type' => 'date', 'null' => false, 'default' => null),
					'segundo_periodo' => array('type' => 'date', 'null' => false, 'default' => null),
					'tercer_periodo' => array('type' => 'date', 'null' => false, 'default' => null),
				),
				'personas' => array(
					'barrio_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
				),
			),
			'drop_table' => array(
				'ciudads', 'pueblosoriginarios'
			),
			'create_field' => array(
				'personas' => array(
					'indigena' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
					'asentamiento' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'ciudad' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
