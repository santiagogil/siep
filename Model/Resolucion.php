<?php
App::uses('AppModel', 'Model');

class Resolucion extends AppModel {
	var $name = 'Resolucion';
    //var $displayField = 'numero';
	public $virtualFields = array('numero_completo_resolucion'=> 'CONCAT(Resolucion.numero, " / ", Resolucion.anio)');
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
    var $hasOne = array(
		'Disenocurricular' => array(
			'className' => 'Disenocurricular',
			'foreignKey' => 'resolucion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Anexo' => array(
			'className' => 'Anexo',
			'foreignKey' => 'resolucion_id',
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
