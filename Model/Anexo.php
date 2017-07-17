<?php
App::uses('AppModel', 'Model');

class Anexo extends AppModel {
	var $name = 'Anexo';
    var $displayField = 'numero';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $belongsTo = array(
		'Resolucion' => array(
			'className' => 'Resolucion',
			'foreignKey' => 'resolucion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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