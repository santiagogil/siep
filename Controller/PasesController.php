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
		$personasNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
		$this->set(compact('pases', 'ciclosNombre', 'personasNombre', 'centrosNombre'));
	}
    
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Pase no válido.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pase', $this->Pase->read(null, $id));
        
		$personaId = $this->Pase->find('list', array('fields'=>array('alumno_id'), 'conditions'=>array('id'=>$id)));
		$this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions'=>array('id'=>$personaId)));
        $this->set(compact('pases', 'personaNombre'));
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
 		    //Antes de guardar genera el estado de la inscripción
			if ($this->request->data['Inscripcion']['tutor_nota'] == true) {
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
		$this->loadModel('Persona');
		$personasNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
		$this->loadModel('Centro');
		$centrosNombre = $this->Centro->find('list', array('fields'=>array('sigla')));
		$this->set(compact('pases', 'ciclos', 'personasNombre', 'centrosNombre'));
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
			$this->data = $this->Inscripcion->read(null, $id);
		}
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
}
?>
