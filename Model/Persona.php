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
    'Alumno' => array(
      'className' => 'Alumno',
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
                'rule' => array('inList', array('FEMENINO', 'MASCULINO')),
                'required' => 'create',
                'message' => 'Indicar sexo.'
                )
            ),
            'documento_tipo' => array(
                'required' => array(
                'rule' => array('inList', array('DNI','CI','LC','LE','Cédula Mercosur','Pasaporte extranjero','Cédula de identidad extranjera','Otro documento extranjero','No posee', 'En trámite')),
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
                'rule' =>  array('inList', array('Argentino', 'Boliviana', 'Brasileña', 'Chilena', 'Colombiana','Ecuatoriana','Guyanesa','Paraguaya','Peruana','Surinamesa','Uruguaya','Venezolana','Beliceña',
			 'Costarricense','Guatemalteca','Hondureña','Nicaragüense','Salvadoreña','Canadiense','Estadounidense','Mexicana','Cubana','Arubana','Bahameña','Barbadense','Dominiquesa',
			 'Dominicana','Haitiana','Jamaiquina','Puertorriqueña','Sancristobaleña','Santaluciana','Sanvicentina','Albanesa','Alemana','Andorrana','Armenia','Austríaca','Belga','Bielorrusa',
			 'Bosnia','Búlgara','Checa','Chipriota','Croata','Danesa','Escocesa','Eslovaca','Hindú','Eslovena','Española','Estonia','Finlandesa','Francesa','Griega','Holandesa','Húngara',
			 'Británica','Irlandesa','Italiana','Letona','Lituana','Luxemburguesa','Maltesa','Moldava','Monegasca','Montenegrina','Noruega','Luxemburguesa','Portuguesa','Rumana','Rusa',
			 'Serbia','Sueca','Suiza','Turca','Ucraniana','Australiana','Neozelandesa','Afgana','Azerbaiyana','Bangladesí','Bareiní','China','Liberiana','Emiratí','Filipina','Georgiana',
			 'Hindú','Indonesia','Israelí','Japonesa','Libanesa','Mongola','Norcoreana','Hindú','Siria','Surcoreana','Vietnamita','Argelina','Camerunesa','Etíope','Ecuatoguineana','Egipcia',
			 'Libia','Marroquí','Namibia','Nigeriana','Saharaui','Senegalesa','Sudafricana','Togolesa')),
                'required' => 'create',
                'message' => 'Indicar una nacionalidad.'
                )
            ),
            /*
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
            */
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
            )
      );
}
?>
