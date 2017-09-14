<?php
App::uses('AppController', 'Controller');

class PasesController extends AppController {

	var $name = 'Pases';
    var $paginate = array('Pase' => array('limit' => 4, 'order' => 'Pase.created DESC'));

	function beforeFilter(){
	    parent::beforeFilter();
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        * Si el usuario tiene un rol de superadmin le damos acceso a todo.
        * Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        if (($this->Auth->user('role') === 'superadmin') || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') {
	        $this->Auth->allow('index', 'view');
	    }
			if ($this->ifActionIs(array('add', 'edit'))) {
				$this->__lists();
			}
	    /* FIN */
    }

	public function index() {
		$this->Pase->recursive = -1;
		$this->paginate['Pase']['limit'] = 4;
		$this->paginate['Pase']['order'] = array('Pase.created' => 'DESC');
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($userRole === 'admin') {
		$this->paginate['Pase']['conditions'] = array('Pase.centro_id_origen' => $userCentroId);
		} else if ($userRole === 'usuario') {
			$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
			$this->paginate['Pase']['conditions'] = array('Pase.centro_id' => $nivelCentroId);
		}
		$this->redirectToNamed();
		$conditions = array();
		if (!empty($this->params['named']['ciclo_id'])) {
			$conditions['Inscripcion.ciclo_id ='] = $this->params['named']['ciclo_id'];
		}
		if (!empty($this->params['named']['alumno_id'])) {
			$conditions['Pase.alumno_id ='] = $this->params['named']['alumno_id'];
		}
		if (!empty($this->params['named']['centro_id_destino'])) {
			$conditions['Pase.centro_id_destino ='] = $this->params['named']['centro_id_destino'];
		}
		if(!empty($this->params['named']['tipo'])) {
			$conditions['Pase.tipo ='] = $this->params['named']['tipo'];
		}
		$pases = $this->paginate('Pase',$conditions);
		$this->loadModel('Ciclo');
		$ciclosNombre = $this->Ciclo->find('list', array('fields'=>array('nombre')));
		$this->loadModel('Centro');
		$centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla')));
		$this->loadModel('Persona');
		$personasId = $this->Persona->find('list', array('fields' => array('id')));
    $personaNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions'=>array('id'=>$personasId)));
  	$this->set(compact('pases', 'ciclosNombre', 'personaNombre', 'centrosNombre'));

		$this->loadModel('Alumno');
		$alumnosId = $this->Alumno->find('list', array('fields' => array('persona_id')));
		$this->set('alumnosId', $alumnosId);
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Pase no válido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pase', $this->Pase->read(null, $id));

		$this->loadModel('Persona');
		$personasId = $this->Persona->find('list', array('fields' => array('id')));
    $personaNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions'=>array('id'=>$personasId)));
    $this->set(compact('pases', 'personaNombre'));

		$this->loadModel('Ciclo');
		$ciclos = $this->Ciclo->find('list', array('fields' => array('nombre')));
		$this->set('ciclos', $ciclos);


		$this->loadModel('Centro');
		$centros = $this->Centro->find('list', array('fields' => array('nombre')));
		$this->set('centros', $centros);

		$this->loadModel('Alumno');
		$alumnosId = $this->Alumno->find('list', array('fields' => array('persona_id')));
		$this->set('alumnosId', $alumnosId);



	}

	public function add() {
		/* BOTÓN CANCELAR (INICIO).
		*abort if cancel button was pressed.
		*/
        if(isset($this->params['data']['cancel'])){
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		 }
		/* FIN */
		if (!empty($this->data)) {
			$this->Pase->create();
 		    // Genera el ciclo id y se deja en los datos que se intentarán guardar.
			$cicloId = $this->getLastCicloId();
			$this->request->data['Pase']['ciclo_id'] = $cicloId;
			// Genera el centro id y se deja en los datos que se intentarán guardar.
			$userCentroId = $this->getUserCentroId();
			$this->request->data['Pase']['centro_id_origen'] = $userCentroId;
			$persona_id = $this->request->data['Pase']['alumno_id'];
			$alumno_id = $this->Alumno->findByPersonaId($persona_id,'id');
			$alumno= $alumno_id['Alumno']['id'];
			$this->request->data['Pase']['alumno_id'] = $alumno;

			  //Antes de guardar genera el estado del pase
			if ($this->request->data['Pase']['nota_tutor'] == true) {
			    	$estado = "COMPLETA";
			    }else{
			        $estado = "PENDIENTE";
			    }
			// Genera el estado y se deja en los datos que se intentarán guardar.
			$this->request->data['Pase']['estado'] = $estado;
			// Genera el usuario id y se deja en los datos que se intentarán guardar.
			$userId = $this->Auth->user('id');
			$this->request->data['Pase']['usuario_id'] = $userId;
 		    if ($this->Pase->save($this->data)) {
				$this->Session->setFlash('El pase ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Pase->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El pase no fue grabado. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}

	}

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Pase no válido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed
            if (isset($this->params['data']['cancel'])) {
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		    }
	
			//Antes de guardar genera el estado de la inscripción
			if ($this->request->data['Pase']['nota_tutor'] == true) {
			   $estado = "COMPLETA";
			} else {
			   $estado = "PENDIENTE";
			}
			//Se genera el estado y se deja en los datos que se intentaran guardar
			$this->request->data['Pase']['estado'] = $estado;
			if ($this->Pase->save($this->data)) {
				$this->Session->setFlash('El pase ha sido grabado.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Pase->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El pase no fué grabado. Intente nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pase->read(null, $id);
			$this->set('pase', $this->Pase->read(null, $id));
		}
		$this->loadModel('Persona');
		$personasid = $this->Persona->find('list', array('fields' => array('id')));
    $personaNombres = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions'=>array('id'=>$personasid)));
    $this->set(compact('pases', 'personaNombres'));

		$this->loadModel('Alumno');
		$alumnosId = $this->Alumno->find('list', array('fields' => array('persona_id')));
		$this->set('alumnosId', $alumnosId);
	}

    public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valida para pase.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pase->delete($id)) {
			$this->Session->setFlash('El pase ha sido borrado.', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El pase no fué borrado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}

	//Métodos privados
	private function __lists(){
		$this->loadModel('Persona');
		$this->loadModel('User');
		$this->loadModel('Alumno');
		$this->loadModel('Centro');
		$userRol = $this->Auth->user('role');
		if($userRol == 'admin'){
			$userCentroId = $this->getUserCentroId();
			$centro= $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$listacentros= $this->Centro->find('list', array('fields'=>array('sigla'), 'conditions'=>array('nivel_servicio'=>$centro)));
			$alumnos = $this->Alumno->find('list', array('fields'=>array('persona_id'), 'conditions'=>array('centro_id'=>$userCentroId)));
			$PersonaAlumnoId = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'),'conditions'=>array('id'=>$alumnos)));
		}
		else{  //SI es superUsuario

			$listacentros= $this->Centro->find('list', array('fields'=>array('sigla'),));
			$alumnos = $this->Alumno->find('list', array('fields'=>array('persona_id')));
			$PersonaAlumnoId = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'),'conditions'=>array('id'=>$alumnos)));

		}

		$this->set(compact('listacentros', 'personasNombre', 'centrosNombre','PersonaAlumnoId'));
	}
}
?>
