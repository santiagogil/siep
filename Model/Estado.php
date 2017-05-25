<?php
class Estado extends AppModel {
	var $name = 'Estado';
	var $displayField = 'nombre';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'estado_id',
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
                   'nombre' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 4), 
                           'allowEmpty' => false,       
                           'message' => 'Indicar nombre del estado con mayusculas.'
                           )
                   )                   
        );
}
?>