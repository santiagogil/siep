<?php
class Siep041817082017 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'siep041817082017';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'centros_empleados' => array(
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
				),
				'titulos' => array(
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'centros_empleados' => array('indexes' => array('PRIMARY')),
				'titulos' => array('indexes' => array('PRIMARY')),
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
