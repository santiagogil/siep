<?php
class Centro extends AppModel {
	var $name = 'Centro';
    var $displayField = 'sigla';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Integracion' => array(
			'className' => 'Integracion',
			'foreignKey' => 'centro_id',
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
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'centro_id',
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
		'Curso' => array(
			'className' => 'Curso',
			'foreignKey' => 'centro_id',
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
			'foreignKey' => 'centro_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'centro_id',
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

	var $hasAndBelongsToMany = array(
		'Empleado' => array(
			'className' => 'Empleado',
			'joinTable' => 'centros_empleados',
			'foreignKey' => 'centro_id',
			'associationForeignKey' => 'empleado_id',
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
		'Titulacion' => array(
			'className' => 'Titulacion',
			'joinTable' => 'centros_titulacions',
			'foreignKey' => 'centro_id',
			'associationForeignKey' => 'titulacion_id',
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
	var $belongsTo = array(
		'Ciudad' => array(
			'className' => 'Ciudad',
			'foreignKey' => 'ciudad_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		));
	//Validaciones

        var $validate = array(
                   'cue' => array(
                           'minLength' => array(
                           'rule' => array('minLength',9),
                           'allowEmpty' => false,
                           'message' => 'Indicar número de 9 dígitos.'
                           ),
                           'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este CUE esta siendo usado.'
	                     )
                   ),
				   'nombre' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'Indicar un nombre (Ejemplo: Centro Educativo de Nivel Secundario 1 o Colegio Provincial Los Andes).'
                           ),
                           'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este nombre de centro esta siendo usado.'
	                     )
                   ),
                   'sigla' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 5),
                           'allowEmpty' => false,
                           'message' => 'Indicar una sigla (Ejemplo: CENS 1 o CP Los Andes).'
                           ),
                           'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Esta sigla de centro esta siendo usado.'
	                     )
                   ),
			    'sector'=> array(
					'minLength' => array(
					'rule' => array('inList', array('ESTATAL' ,'PRIVADO')),
					'allowEmpty' => false,
					'message' => 'Indicar una opcion.'
					)
				),

                   'fechaFundacion' => array(
                           'datetime' => array(
                           'rule' => 'datetime',
                           'allowEmpty' => false,
                           'message' => 'Indicar fecha de creacion del centro.'
                           )
                   ),
                   'equipoDirectivo' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 5),
                           'allowEmpty' => false,
                           'message' => 'Indicar nombres del equipo directivo (Director, Vicedirector y Secretario).'
                           )
                   ),

			    'ambito' => array(
		 	    		'minLength' => array(
		 			'rule' => array('inList', array('URBANO' ,'RURAL')),
		 			'allowEmpty' => false,
		 			'message' => 'Indicar una opcion.'
		 			)
   				),

                    'direccion' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'Indicar direccion que contenga numeros y letras.'
                           )
                   ),

			    'cp' => array(
	  	    			'minLength' => array(
	  				'rule' => array('minLength',4),
	  				'allowEmpty' => true,
	  				'message' => 'Indicar código postal.'
	  				)
				),

				'codigoLocalidad' => array(
				  	'minLength' => array(
                      	'rule' => array('minLength',5),
					'allowEmpty' => true,
			       	'message' => 'Indicar una opcion.'
				      )
				),

                    'ciudad_id' => array(
                           'minLength' => array(
                           'rule' => 'notBlank',
                           'allowEmpty' => false,
                           'message' => 'Indicar una ciudad.'
                           )
                   ),

									 'departamento_id' => array(

                   'required' => array(
						   	 	 'rule' => 'notBlank',
						       'required' => 'create',
                   'message' => 'seleccionar un departamento.'
								 				)
									 ),

									 'barrio_id' => array(

										'required' => array(
									 'rule' => 'notBlank',
									 'required' => 'create',
										'message' => 'seleccionar un barrio.'
												)
										),

                   'telefono' => array(
                           'minLength' => array(
                           'rule' => array('minLength',6),
                           'allowEmpty' => false,
                           'message' => 'Indicar un telefono de referencia.'
                           )
                   ),
                   'email' => array(
                           'email' => array(
                           'rule' => 'email',
                           'allowEmpty' => false,
                           'message' => 'Indicar correo electronico valido.'
                           )
                   ),
                  'url' => array(
                           'url' => array(
                           'rule' => 'url',
                           'allowEmpty' => true,
                           'message' => 'Indicar una url valida.'
                           )
                   )

     );
}
?>
