<?php
class Titulacion extends AppModel {
	var $name = 'Titulacion';
  public $displayField = 'nombre';
	public $actsAs = array('Containable');

  //The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Disenocurricular' => array(
      'className' => 'Disenocurricular',
      'foreignKey' => 'titulacion_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ),
    'Curso' => array(
			'className' => 'Curso',
			'foreignKey' => 'titulacion_id',
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
  );

  var $hasAndBelongsToMany = array(
    'Centro' => array(
      'className' => 'Centro',
      'joinTable' => 'centros_titulacions',
      'foreignKey' => 'titulacion_id',
      'associationForeignKey' => 'centro_id',
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
				    'nombre' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opcion.'
               ),
						   'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este nombre esta siendo usado.'
	                     )
               ),
            'certificacion' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar la certificación.'
                       )
               ),
				    'condicion_ingreso' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar la condición de ingreso.'
                       )
               ),
				   'ciclo_implementacion' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar el ciclo de implementación.'
                       )
               ),
				   'a_termino' => array(
               'boolean' => array(
               'rule' => array('boolean'),
					     'message' => 'Indicar una opción'
				               )
                ),
				   'orientacion' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opción.'
                       )
                ),
				   'organizacion_plan' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opción.'
                       )
                ),
				   'organizacion_cursada' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opción.'
                       )
                ),
				   'forma_dictado' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opción.'
                        )
                ),
				   'carga_horaria_en' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',       
               'message' => 'Indicar una opción.'
                           )
                ),
				   'carga_horaria' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una carga horaria.'
                           )						   
                ),
				   'edad_minima' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una edad.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => false,       
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'tiene_articulacion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una articulación.'
                           )
                   ),
				   'duracion_en' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una opción.'
                           )
                   ),
				   'duracion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una duración.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => false,       
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'norma_aprob_jur_tipo' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una opción.'
                           )
				   ),
                  'norma_aprob_jur_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_aprob_jur_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => true,       
                           'message' => 'Indicar un año.'
                           )
                   ),
				   'norma_val_nac_tipo' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 4), 
                           'allowEmpty' => true,       
                           'message' => 'Indicar una opción.'
                           )
                   ),
				   'norma_val_nac_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_val_nac_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => true,       
                           'message' => 'Indicar un año.'
                           )
                   ),
				   'norma_ratif_jur_tipo' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 4), 
                           'allowEmpty' => true,       
                           'message' => 'Indicar una opción.'
                           )
                   ),
				   'norma_ratif_jur_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_ratif_jur_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => true,       
                           'message' => 'Indicar un año.'
                           )
                   ),
				   'norma_homologacion_tipo' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 4), 
                           'allowEmpty' => true,       
                           'message' => 'Indicar una opción.'
                           )
                   ),
				   'norma_homologacion_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_homologacion_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric', 
                           'allowEmpty' => true,       
                           'message' => 'Indicar un año.'
                           )
                   )
		);
}
?>