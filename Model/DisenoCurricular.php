<?php
App::uses('AppModel', 'Model');

class DisenoCurricular extends AppModel {
	var $name = 'DisenoCurricular';
    var $displayField = 'resolucion_id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $belongsTo = array(
		'Resolucion' => array(
			'className' => 'Resolucion',
			'foreignKey' => 'resolucion_id',
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

	var $hasMany = array(
		'Materia' => array(
			'className' => 'Materia',
			'foreignKey' => 'disenocurricular_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
    );

    //Validaciones
                   var $validate = array(
				   'created' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
						 'message' => 'Indicar una fecha y hora.'
                         )
                   )
          );
}
?>
