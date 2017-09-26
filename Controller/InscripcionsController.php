<?php
App::uses('AppController', 'Controller');

class InscripcionsController extends AppController {

	var $name = 'Inscripcions';
    var $paginate = array('Inscripcion' => array('limit' => 4, 'order' => 'Inscripcion.fecha_alta DESC'));

	function beforeFilter(){
	    parent::beforeFilter();
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        if ($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    } elseif (($this->Auth->user('role') === 'usuario') || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow('index', 'add', 'view', 'edit');
	    }
	    /* FIN */
        /* FUNCIÓN PRIVADA "LISTS" (INICIO).
        *Si se ejecutan las acciones add/edit activa la función privada "lists".
		*/
		if ($this->ifActionIs(array('add', 'edit'))) {
			$this->__lists();
		}
		/* FIN */
    }

	public function index() {
		$this->Inscripcion->recursive = 1;
		$this->paginate['Inscripcion']['limit'] = 4;
		$this->paginate['Inscripcion']['order'] = array('Inscripcion.fecha_alta' => 'DESC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*Sí el usuario es "admin" muestra los cursos del establecimiento. Sino sí es "usuario" externo muestra los cursos del nivel.
		*/
		//$cicloIdActual = $this->getLastCicloId();
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
        $this->loadModel('Centro');
        $nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));

		if ($this->Auth->user('role') === 'admin') {
		//$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.ciclo_id' => $cicloIdActual, 'Inscripcion.centro_id' => $userCentroId);
		//$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $userCentroId);	
        $this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $userCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));    
        } else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));
			$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));
		} else if ($userRole === 'usuario') {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId, 'Inscripcion.estado_inscripcion' =>array('CONFIRMADA','NO CONFIRMADA'));
		}
		/* FIN */
    	/* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		*Pagina según búsquedas simultáneas ya sea por CICLO y/o CENTRO y/o LEGAJO y/o ESTADO.
		*/
    	$this->redirectToNamed();
		$conditions = array();
		if (!empty($this->params['named']['ciclo_id'])) {
			$conditions['Inscripcion.ciclo_id ='] = $this->params['named']['ciclo_id'];
		}
		if (!empty($this->params['named']['centro_id'])) {
			$conditions['Inscripcion.centro_id ='] = $this->params['named']['centro_id'];
		}
		if (!empty($this->params['named']['legajo_nro'])) {
			$conditions['Inscripcion.legajo_nro ='] = $this->params['named']['legajo_nro'];
		}
		if(!empty($this->params['named']['estado_documentacion'])) {
			$conditions['Inscripcion.estado_documentacion ='] = $this->params['named']['estado_documentacion'];
		}
        if(!empty($this->params['named']['estado_inscripcion'])) {
            $conditions['Inscripcion.estado_inscripcion ='] = $this->params['named']['estado_inscripcion'];
        }
		$inscripcions = $this->paginate('Inscripcion',$conditions);
		/* FIN */
		/* SETS DE DATOS PARA COMBOBOX (INICIO). */
		/* Carga de Ciclos */
        $ciclos = $this->Inscripcion->Ciclo->find('list', array('fields'=>array('id', 'nombre')));
        /* Carga de Centros
        *  Sí es superadmin carga todos los centros.
        *  Sino sí es un usario de Inicial/Primaria, carga los centros de ambos niveles.
        *  Sino sí es un usuario del resto de los niveles, carga los centros del nivel correspondientes.     
        */
        $this->loadModel('Centro');
		$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
		$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		if ($userRole == 'superadmin') {
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla')));
		} else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Inscripcion->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole == 'admin') {
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
		}
        /* Carga de Alumnos */
		$personaId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        /* FIN */
		$this->set(compact('inscripcions', 'personaId', 'personaNombre', 'centros', 'ciclos'));
	}

	   public function view($id = null) {
        if (!$id) {
            $this->Session->setFlash('Inscripcion no valida.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('inscripcion', $this->Inscripcion->read(null, $id));
        $personaId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        $this->set(compact('inscripcions', 'personaId', 'personaNombre'));
    }

	public function add() {
        /* BOTÓN CANCELAR (INICIO).
        *abort if cancel button was pressed.
        */
        if (isset($this->params['data']['cancel'])) {
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		}
	    /* FIN */
        //Al realizar SUBMIT
        if (!empty($this->data)) {
            //Iniciamos proceso de inscripcion
            $this->Inscripcion->create();
            //Se genera el id del usuario
            $this->request->data['Inscripcion']['usuario_id'] = $this->Auth->user('id');
            //La fecha de alta se toma del servidor php al momento de ejecutar el controlador
            $this->request->data['Inscripcion']['fecha_alta'] = date('Y-m-d');
            $userCentroId = $this->getUserCentroId();
            //Se obtiene el rol del usuario
            $userRole = $this->Auth->user('role');
            switch($userRole) {
                case 'superadmin':
                case 'usuario':
                    // Usa el centro especificado en el formulario
                    $userCentroId = $this->request->data['Inscripcion']['centro_id'];
                break;
                case 'admin':
                    // Usa el centro definido para el usuario
                    $userCentroId = $this->getUserCentroId();
                    $this->request->data['Inscripcion']['centro_id'] = $userCentroId ;
                break;
            }
            /*
            //Genera el ciclo id y se deja en los datos que se intentaran guardar
            $cicloId = $this->getLastCicloId();
            $this->request->data['Inscripcion']['ciclo_id'] = $cicloId;
            //Antes de guardar genera el número de legajo del Alumno.
            $ciclos = $this->Inscripcion->Ciclo->findById($cicloId, 'nombre');
            $ciclo = substr($ciclos['Ciclo']['nombre'], -2);
            */
            // Luego de seleccionar el ciclo, se deja en los datos que se intentarán guardar.
            $cicloId = $this->request->data['Inscripcion']['ciclo_id'];
            $ciclos = $this->Inscripcion->Ciclo->findById($cicloId, 'nombre');
            $ciclo = substr($ciclos['Ciclo']['nombre'], -2);
            /*
             *  VERIFICACION DE PERSONA
             */
            //Antes que nada obtengo personaId
            $personaId = $this->request->data['Persona']['persona_id'];
            if (empty($personaId))
            {
                //No esta definida? terminamos volvemos al formulario anterior
                $this->Session->setFlash('No se definio la persona.', 'default', array('class' => 'alert alert-danger'));
                $this->redirect($this->referer());
            }
            //Obtenemos algunos datos de esa personaId
            $this->loadModel('Persona');
            $this->Persona->recursive = 0;
            $persona = $this->Persona->findById($personaId,'id, documento_nro');
            $personaDni = $persona['Persona']['documento_nro'];
            //Genera el nro de legajo y se deja en los datos que se intentaran guardar
            $codigoActual = $this->__getCodigo($ciclo, $personaDni);
            //Comprueba que ese legajo no exista directamente a la base de datos
            $personaInscripta = $this->Inscripcion->find('list', array(
                'fields'=>array('legajo_nro'),
                'conditions'=>array('legajo_nro'=>$codigoActual)
            ));
            /*
             *  FIN VERIFICACION DE PERSONA
             */
            if (count($personaInscripta)) {
                $this->Session->setFlash('El alumno ya está inscripto en este ciclo.', 'default', array('class' => 'alert alert-danger'));
            } else {
                $this->request->data['Inscripcion']['legajo_nro'] = $codigoActual;
                //Antes de guardar genera el estado de la inscripción
                if($this->request->data['Inscripcion']['fotocopia_dni'] == true && $this->request->data['Inscripcion']['certificado_septimo'] == true && $this->request->data['Inscripcion']['analitico'] == true) {
                    $estadoDocumentacion = "COMPLETA";
                } else {
                    $estadoDocumentacion = "PENDIENTE";
                }
                //Genera el estado y se deja en los datos que se intentaran guardar
                $this->request->data['Inscripcion']['estado_documentacion'] = $estadoDocumentacion;
                /*
                 *  VERIFICACION DE ALUMNO
                 */
                //Antes de guardar hay que ver si la persona se encuentra inscripta como alumno
                $this->loadModel('Alumno');
                $this->Alumno->recursive = 0;
                $alumno = $this->Alumno->findByPersonaId($personaId);
                if (count($alumno) == 0) {
                    // Si no existe el alumno, hay que crearlo
                    $this->Alumno->create();
                    $insert = array(
                        'Alumno' => array(
                            'created' => '2017-09-08 12:01',
                            'persona_id' => $personaId,
                            'centro_id' => $userCentroId
                        ));
                    $alumno = $this->Alumno->save($insert);
                    if (!$alumno['Alumno']['id']) {
                        print_r("Error al registrar a la persona como alumno");
                        die;
                    }
                } 
                $this->request->data['Inscripcion']['alumno_id'] = $alumno['Alumno']['id'];
                /*
                 *  FIN VERIFICACION DE ALUMNO
                 */
                if ($this->Inscripcion->save($this->data)) {
                    $this->Session->setFlash('La inscripcion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
                    /* ATUALIZA MATRÍCULA Y VACANTES (INICIO).
                    *  Al registrarse una Inscripción, actualiza valores de matrícula y vacantes
                    *  del curso correspondiente en el modelo Curso.
                    */
                    $this->loadModel('Curso');
                    $cursoIdArray = $this->request->data['Curso'];
                    $cursoIdString = $cursoIdArray['Curso'];
                    $matriculaActual = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdString)));
                    $this->Curso->id=$cursoIdString;
                    $this->Curso->saveField("matricula", $matriculaActual);
                    $plazasArray = $this->Curso->findById($cursoIdString, 'plazas');
                    $plazasString = $plazasArray['Curso']['plazas'];
                    $vacantesActual = $plazasString - $matriculaActual;
                    $this->Curso->saveField("vacantes", $vacantesActual);
                    /* FIN */
                    $inserted_id = $this->Inscripcion->id;
                    $this->redirect(array('action' => 'view', $inserted_id));
                } else {
                    $this->Session->setFlash('La inscripcion no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
                }
            }
        }
    }

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Inscripcion no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed
            if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		    }
			// Antes de guardar genera el id del alumno.
            $personaId = $this->request->data['Persona']['persona_id'];
            $this->loadModel('Alumno');
            $alumno = $this->Alumno->findByPersonaId($personaId);
            $this->request->data['Inscripcion']['alumno_id'] = $alumno['Alumno']['id'];
            //Antes de guardar genera el estado de la inscripción
			if($this->request->data['Inscripcion']['fotocopia_dni'] == true && $this->request->data['Inscripcion']['certificado_septimo'] == true && $this->request->data['Inscripcion']['analitico'] == true){
			   $estadoDocumentacion = "COMPLETA";
			}else{
			   $estadoDocumentacion = "PENDIENTE";
			}
			//Se genera el estado y se deja en los datos que se intentaran guardar
			$this->request->data['Inscripcion']['estado_documentacion'] = $estadoDocumentacion;
			// Se define el id del centro.
            $userCentroId = $this->getUserCentroId();
            //Se obtiene el rol del usuario
            $userRole = $this->Auth->user('role');
            switch($userRole) {
                case 'superadmin':
                case 'usuario':
                    // Usa el centro especificado en el formulario
                    $userCentroId = $this->request->data['Inscripcion']['centro_id'];
                break;
                case 'admin':
                    // Usa el centro definido para el usuario
                    $userCentroId = $this->getUserCentroId();
                    $this->request->data['Inscripcion']['centro_id'] = $userCentroId ;
                break;
            }
            /* Se trata de un pase sí se identifica un cambio en el id del centro.
            *  Actualiza el id del centro del Alumno.
            *  Actualiza valores de matrícula y vacantes.
            */
            $alumnoId = $this->Inscripcion->alumno_id;
            $centroIdAnterior = $this->Inscripcion->Alumno->find('list', array('fields'=>array('centro_id'), 'conditions'=>array('id'=>$alumnoId))); 
            if ($centroIdAnterior != $userCentroId) {
                /* Actualiza el id del centro del Alumno. */
                $personaId = $this->request->data['Persona']['persona_id'];
                $this->loadModel('Alumno');
                $alumnoIdArray = $this->Alumno->findByPersonaId($personaId);
                $alumnoIdString = $alumnoIdArray['Alumno'];
                $this->Alumno->id=$alumnoIdString;
                $this->Alumno->saveField("centro_id", $userCentroId);
                /* ATUALIZA MATRÍCULA Y VACANTES (INICIO). */
                $this->loadModel('Curso');
                $cursoIdArray = $this->request->data['Curso'];
                $cursoIdString = $cursoIdArray['Curso'];
                $matriculaActual = $this->Inscripcion->CursosInscripcion->find('count', array('fields'=>array('curso_id'), 'conditions'=>array('CursosInscripcion.curso_id'=>$cursoIdString)));
                $this->Curso->id=$cursoIdString;
                $this->Curso->saveField("matricula", $matriculaActual);
                $plazasArray = $this->Curso->findById($cursoIdString, 'plazas');
                $plazasString = $plazasArray['Curso']['plazas'];
                $vacantesActual = $plazasString - $matriculaActual;
                $this->Curso->saveField("vacantes", $vacantesActual);
                /* Modifica a "CONFIRMADO" el estado del pase. */
                $alumnoIdString = $alumnoIdArray['Alumno'];
                $this->loadModel('Pase');
                $this->Pase->alumno_id=$alumnoIdString;
                $this->Pase->saveField("estado_pase", 'CONFIRMADO');
                /* FIN */
            }
            if ($this->Inscripcion->save($this->data)) {
				$this->Session->setFlash('La inscripcion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Inscripcion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La inscripcion no fue grabada. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Inscripcion->read(null, $id);
		}
	}

    public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para inscripcion.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inscripcion->delete($id)) {
			$this->Session->setFlash('La Inscripcion ha sido borrada.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La Inscripcion no fue borrada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	//Métodos privados
	private function __lists(){
	    $this->loadModel('User');
        $ciclos = $this->Inscripcion->Ciclo->find('list');
		$cicloIdActual = $this->getLastCicloId();
		$centros = $this->Inscripcion->Centro->find('list');
		//Sí es "superadmin" o "usuario" ve combobox con todos los cursos. Sino ve los propios del centro.
		$userRol = $this->Auth->user('role');
		if (($userRol == 'superadmin') || ($userRol == 'usuario')) {
			$cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso')));
		} else if ($userRol == 'admin') {
			$userCentroId = $this->getUserCentroId();
			$cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso'), 'conditions'=>array('centro_id'=>$userCentroId)));
		}
		//$materias = $this->Inscripcion->Materia->find('list');
    	/* Sí es "superadmin" o "usuario" ve combobox con todos los alumnos.
    	*  Sino ve los propios del centro. (INICIO) */
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($this->Auth->user('role') === 'admin') {
			$this->loadModel('Alumno');
			$personaId = $this->Alumno->find('list', array('fields'=>array('persona_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
		    $this->loadModel('Persona');
			$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
		} else if ($userRole === 'usuario') {
			$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$personaId = $this->Inscripcion->find('list', array('fields'=>array('alumno_id'), 'conditions'=>array('centro_id'=>$nivelCentroId)));
			$this->loadModel('Persona');
            $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
		} else {
			//Sí es superadmin
			$this->loadModel('Alumno');
			$personaId = $this->Alumno->find('list', array('fields'=>array('persona_id')));
		    $this->loadModel('Persona');
			$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
		}
		/* FIN */
		$this->set(compact('personaNombre', 'ciclos', 'centros', 'cursos', 'materias', 'empleados', 'cicloIdActual'));
	}

	private function __getCodigo($ciclo, $personaDocString){
		$legajo = $personaDocString."-".$ciclo;
		return $legajo;
    }
}
?>
