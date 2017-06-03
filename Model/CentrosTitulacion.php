<?php
App::uses('AppModel', 'Model');
/**
 * CentroTitulacion Model
 *
 * @property Centro $Centro
 * @property Titulacion $Titulacion
 */
class CentrosTitulacion extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $name = 'CentrosTitulacion';
	public $virtualFields = array('matricula'=> 'CONCAT(CentrosTitulacion.centro_id, " ", CentrosTitulacion.titulacion_id)');	


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Centro' => array(
			'className' => 'Centro',
			'foreignKey' => 'centro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Titulacion' => array(
			'className' => 'Titulacion',
			'foreignKey' => 'titulacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
