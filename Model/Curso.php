<?php
class Curso extends AppModel {
	var $name = 'Curso';
    //var $displayField = 'division';
	public $virtualFields = array('nombre_completo_curso'=> 'CONCAT(Curso.anio, " ", Curso.division)');
    public $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
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

	var $hasMany = array(
		'Materia' => array(
			'className' => 'Materia',
			'foreignKey' => 'curso_id',
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
		'Ciclo' => array(
			'className' => 'Ciclo',
			'joinTable' => 'ciclos_cursos',
			'foreignKey' => 'curso_id',
			'associationForeignKey' => 'ciclo_id',
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
		'Inscripcion' => array(
			'className' => 'Inscripcion',
			'joinTable' => 'cursos_inscripcions',
			'foreignKey' => 'curso_id',
			'associationForeignKey' => 'inscripcion_id',
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
		'Inasistencia' => array(
			'className' => 'Inasistencia',
			'joinTable' => 'cursos_inasistencias',
			'foreignKey' => 'curso_id',
			'associationForeignKey' => 'inasistencia_id',
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
				   'tipo' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un tipo.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{4,}$/i',
												 'message' => 'Indicar una opción válida'
                   )

                   ),

				   'anio' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un año.'
                           )
                   ),
                   'division' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una división.'
                           )
                   ),

                   'turno' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un turno.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{4,}$/i',
												 'message' => 'Indicar un turno válido'
                   )),
                   'plazas' => array(
                   			'required' => array(
						   	'rule' => 'notBlank',
						   	'required' => 'create',
                           	'message' => 'Indicar una matrícula.'
                           	),
							'numeric' => array(
							'rule' => 'naturalNumber',
							'message' => 'Indicar número sin puntos ni comas ni espacios.'
							)
                   ),
                   'matricula' => array(
		                'numeric' => array(
		                'rule' => 'naturalNumber',
		                'required' => true,
		                'message' => 'Indicar número sin puntos ni comas ni espacios.'
		                )
		            ),
                   	'vacantes' => array(
		                'numeric' => array(
		                'rule' => 'naturalNumber',
		                'required' => true,
		                'message' => 'Indicar número sin puntos ni comas ni espacios.'
		                )
		            ),
				   'aula_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un aula.'
                           ),
													 'numeric' => array(
								 						'rule' => 'naturalNumber',
								 						'message' => 'Indicar número sin puntos ni comas ni espacios.'
								 					)
                   ),

                   'ciclo_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un ciclo.'
												 ),
												 'numeric' => array(
							 						'rule' => 'naturalNumber',
							 						'message' => 'Indicar número sin puntos ni comas ni espacios.'
							 					)
                   ),

				   'titulacion_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una titulación.'
												 ),
												 'numeric' => array(
							 						'rule' => 'naturalNumber',
							 						'message' => 'Indicar número sin puntos ni comas ni espacios.'
							 					)
                   )

     );
}
?>
