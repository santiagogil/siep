<?php
App::uses('AppModel', 'Model');

class Alumno extends AppModel {
	
	var $name = 'Alumno';
    //var $displayField = 'apellido';
	//public $virtualFields = array('nombre_completo_alumno'=> 'CONCAT(Alumno.apellidos, " ", Alumno.nombres)');
    /*
	public $actsAs = array(
			'Upload.Upload' => array(
				'foto' => array(
					'fields' => array(
						'dir' => 'foto_dir'
					),
					'thumbnailMethod' => 'php',
					'thumbnailSizes' => array(
						'vga' => '640x480',
						'thumb' => '150x150'
					),
					'deleteOnUpdate' => true,
					'deleteFolderOnDelete' => true
				)
			)
		);
	*/
	
    var $belongsTo = array(
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
   
	var $hasMany = array(
	    'Integracion' => array(
	      'className' => 'Integracion',
	      'foreignKey' => 'alumno_id',
	      'dependent' => false,
	      'conditions' => '',
	      'fields' => '',
	      'order' => '',
	      'limit' => '',
	      'offset' => '',
	      'exclusive' => '',
	      'finderQuery' => '',
	      'counterQuery' => ''
	    ),
	    'Servicio' => array(
	      'className' => 'Servicio',
	      'foreignKey' => 'alumno_id',
	      'dependent' => false,
	      'conditions' => '',
	      'fields' => '',
	      'order' => '',
	      'limit' => '',
	      'offset' => '',
	      'exclusive' => '',
	      'finderQuery' => '',
	      'counterQuery' => ''
	    ),
	    'Inscripcion' => array(
	      'className' => 'Inscripcion',
	      'foreignKey' => 'alumno_id',
	      'dependent' => false,
	      'conditions' => '',
	      'fields' => '',
	      'order' => '',
	      'limit' => '',
	      'offset' => '',
	      'exclusive' => '',
	      'finderQuery' => '',
	      'counterQuery' => ''
	    ),
	    'Inasistencia' => array(
	      'className' => 'Inasistencia',
	      'foreignKey' => 'alumno_id',
	      'dependent' => false,
	      'conditions' => '',
	      'fields' => '',
	      'order' => '',
	      'limit' => '',
	      'offset' => '',
	      'exclusive' => '',
	      'finderQuery' => '',
	      'counterQuery' => ''
	    ),
	    'Nota' => array(
	      'className' => 'Nota',
	      'foreignKey' => 'alumno_id',
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

   /**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	var $hasAndBelongsToMany = array(
		'Familiar' => array(
			'className' => 'Familiar',
			'joinTable' => 'alumnos_familiars',
			'foreignKey' => 'familiar_id',
			'associationForeignKey' => 'alumno_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Mesaexamen' => array(
			'className' => 'Mesaexamen',
			'joinTable' => 'alumnos_mesaexamens',
			'foreignKey' => 'mesaexamen_id',
			'associationForeignKey' => 'alumno_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
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
                   ),
				   /*
				   'persona_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar una persona.'
                           )
                   ),
                   */
                   'centro_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un centro.'
                           )
                   ),
                   'legajo_fisico_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un número de legajo.'
                           )
                   )
	       );
		
	//Funciones privadas.
	
	function addAsterisco($id){
	   $this->id = $id;
	   $this->saveField('pendientes', 1);
	}
}
?>
