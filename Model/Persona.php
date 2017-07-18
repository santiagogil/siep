<?php 
class Persona extends AppModel {
	
	var $name = 'Persona';
    //var $displayField = 'apellido';
	public $virtualFields = array('nombre_completo_persona'=> 'CONCAT(Persona.nombres, " ", Persona.apellidos)');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

  var $hasMany = array(
    'Familiar' => array(
      'className' => 'Familiar',
      'foreignKey' => 'persona_id',
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
    'Integracion' => array(
      'className' => 'Integracion',
      'foreignKey' => 'persona_id',
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
      'foreignKey' => 'persona_id',
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
      'foreignKey' => 'persona_id',
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
      'foreignKey' => 'persona_id',
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
      'foreignKey' => 'persona_id',
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
            ),
            'nombres' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar los nombres.'
                )
            ),
            'apellidos' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar los apellidos.'
                )
            ),
            'sexo' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar sexo.'
                )
            ),
            'documento_tipo' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un tipo de documento.'
                )
            ),
            'documento_nro' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un nº de documento.'
                ),
                'numeric' => array(
                  'rule' => 'numeric',
                  'allowEmpty' => false,
                  'message' => 'Indicar número sin puntos ni espacios.'
                ),
                'isUnique' => array(
                  'rule' => 'isUnique',
                  'message' => 'Este documento de alumno esta siendo usado.'
                )
            ),
            'fecha_nac' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar una fecha de nacimiento.'
                ),
             'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
              )
            ),
            'edad' => array(
                'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
                )
            ),
            'pcia_nac' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar una provincia.'
                )
            ),
            'nacionalidad' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar una nacionalidad.'
                )
            ),
            'indigena' => array(
            ),
            'estado_civil' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un estado civil.'
                )
            ), 
            'ocupacion' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar una ocupación.'
                )
            ),
            'lugar_de_trabajo' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un lugar de trabajo.'
                )
            ),
            'horario_de_trabajo' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un horario de trabajo.'
                )
            ),
            'telefono_nro' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un nº de teléfono.'
                )
            ),
            'email' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un correo electrónico.'
                )
            ),
            'calle_nombre' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un nombre de calle.'
                )
            ),
            'calle_nro' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar un nº de calle.'
                )
            ),
           'ciudad' => array(
                'required' => array(
                'rule' => 'notBlank',
                'required' => 'create',
                'message' => 'Indicar una ciudad.'
               )
            ),
      );
}
?>
