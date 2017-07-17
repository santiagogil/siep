<?php
class TitulacionsController extends AppController {

	var $name = 'Titulacions';
<<<<<<< HEAD
    public $uses = array('Titulacion', 'Centro');
    public $helpers = array('Session');
	public $components = array('Auth','Session');
=======
    var $helpers = array('Session');
	var $components = array('Auth','Session');
>>>>>>> c7995caecfa37091c952f6bab236d376020c7a7e
	var $paginate = array('Titulacion' => array('limit' => 4, 'order' => 'Titulacion.nombre DESC'));

    function beforeFilter(){
	    parent::beforeFilter();
		//Si el usuario tiene un rol de superadmin le damos acceso a todo.
        //Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        if(($this->Auth->user('role') === 'superadmin')  || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') { 
	        $this->Auth->allow('index', 'view');
	    }
    }	

	function index() {
		$this->Titulacion->recursive = -1;
		$titulacions = $this->Titulacion->find('list', array('fields'=>array('id', 'nombre')));
		$userCentroId = $this->getUserCentroId();
		if($this->Auth->user('role') === 'admin') {
<<<<<<< HEAD
			$this->paginate['Titulacion']['conditions'] = array('Titulacion.nombre' => $userCentroId);
=======
			$this->paginate['Titulacion']['conditions'] = array('Titulacion.centro_id' => $userCentroId);
>>>>>>> c7995caecfa37091c952f6bab236d376020c7a7e
		}

		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['nombre']))
		{
			$conditions['Titulacion.nombre ='] = $this->params['named']['nombre'];
		}
		$titulacions = $this->paginate('Titulacion', $conditions);
		
<<<<<<< HEAD
		$centros = $this->Titulacion->CentrosTitulacion->find('list', array('fields' => array('centro_id'), array('conditions' => array('titulacion_id' => $titulacions))));
		
		$this->set(compact('titulacions', 'centros', $centros));
=======
		$this->loadModel('Centro');
		$centrosId = $this->Titulacion->find('list', array('fields'=>array('centro_id')));
        $centros = $this->Centro->find('list', array('fields'=>array('sigla'), 'conditions' => array('id' => $centrosId)));
		$this->set(compact('titulacions', 'centros'));

>>>>>>> c7995caecfa37091c952f6bab236d376020c7a7e
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Titulación no valida.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('titulacion', $this->Titulacion->read(null, $id));
		
		$resolucionsId = $this->Titulacion->Disenocurricular->find('list', array('fields'=>array('resolucion_id')));
        $this->loadModel('Resolucion');
        $resolucions = $this->Resolucion->find('list', array('fields'=>array('numero_completo_resolucion'), 'conditions' => array('id' => $resolucionsId)));
		
		$this->set(compact('resolucions'));	
	}

	function add() {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if (!empty($this->data)) {
		    $this->Titulacion->create();
			
			if ($this->Titulacion->save($this->data)) {
				$this->Session->setFlash('La titulacion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Titulacion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La titulacion no ha sido grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$centros = $this->Centro->find('list');
		$this->set(compact('centros', $centros));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Titulacion no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
            if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
			if ($this->Titulacion->save($this->data)) {
				$this->Session->setFlash('La titulación ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				//$this->redirect(array('action' => 'index'));
				$inserted_id = $this->Titulacion->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La titulación no ha sido grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Titulacion->read(null, $id);
		}
		$centros = $this->Centro->find('list');
		$this->set(compact('centros', $centros));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para titulación.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Titulacion->delete($id)) {
			$this->Session->setFlash('La Titulación ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La Titulación no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
?>