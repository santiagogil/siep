<?php
App::uses('AppController', 'Controller');

class PersonasController extends AppController {

	var $name = 'Personas';
	public $helpers = array('Form', 'Time', 'Js');
	public $components = array('Session', 'RequestHandler');
	var $paginate = array('Persona' => array('limit' => 3, 'order' => 'Persona.id DESC'));

	
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
		
	public function index() {
		$this->Persona->recursive = 0;
		$this->paginate['Persona']['limit'] = 4;
		$this->paginate['Persona']['order'] = array('Persona.id' => 'ASC');
		$this->redirectToNamed();
		$conditions = array();
				
		if(!empty($this->params['named']['nombre_completo_persona']))
		{
			$conditions['Persona.nombre_completo_persona ='] = $this->params['named']['nombre_completo_persona'];
		}

		if(!empty($this->params['named']['documento_nro']))
		{
			$conditions['Persona.documento_nro ='] = $this->params['named']['documento_nro'];
		}
        //Evalúa si existe foto.
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		$personas = $this->paginate('Persona', $conditions);
		$this->set(compact('personas', 'foto'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Persona no valida', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array('Persona.' . $this->Persona->primaryKey => $id));
		$this->pdfConfig = array(
			'download' => true,
			'filename' => 'persona_' . $id .'.pdf'
		);
		$this->set('persona', $this->Persona->read(null, $id));
		
        //Evalúa si existe foto.
		if(empty($this->params['named']['foto'])){
			$foto = 0;
		} else {
			$foto = 1;
		}
		$this->loadModel('Barrio');
		$barrioNombre = $this->Barrio->find('list', array('fields'=>array('nombre')));
	    $this->set(compact('foto', 'barrioNombre'));
     }

	public function add() {
		//abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if (!empty($this->data)) {
			$this->Persona->create();
		    // Antes de guardar pasa a mayúsculas el nombre completo.
			$apellidosMayuscula = strtoupper($this->request->data['Persona']['apellidos']);
			$nombresMayuscula = strtoupper($this->request->data['Persona']['nombres']);
			// Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
			$this->request->data['Persona']['apellidos'] = $apellidosMayuscula;
			$this->request->data['Persona']['nombres'] = $nombresMayuscula;
			// Antes de guardar calcula la edad
			$day = $this->request->data['Persona']['fecha_nac']['day'];
			$month = $this->request->data['Persona']['fecha_nac']['month'];
			$year = $this->request->data['Persona']['fecha_nac']['year'];
			// Calcula la edad y se deja en los datos que se intentaran guardar
			$this->request->data['Persona']['edad'] = $this->__getEdad($day, $month, $year);
			if ($this->Persona->save($this->data)) {
				$this->Session->setFlash('La persona ha sido grabada.', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Persona->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La persona no fué grabada. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$this->loadModel('Barrio');          
        $barrios = $this->Barrio->find('list', array('fields' => array('nombre')));
        $this->set('barrios', $barrios);
	}

	function edit($id = null) {
	    if (!$id && empty($this->data)) {
			$this->Session->setFlash('Persona no válida', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
          // Antes de guardar pasa a mayúsculas el nombre completo.
		  $apellidosMayuscula = strtoupper($this->request->data['Persona']['apellidos']);
		  $nombresMayuscula = strtoupper($this->request->data['Persona']['nombres']);
		  // Genera el nombre completo en mayúsculas y se deja en los datos que se intentaran guardar
		  $this->request->data['Persona']['apellidos'] = $apellidosMayuscula;
		  $this->request->data['Persona']['nombres'] = $nombresMayuscula;
    	  // Antes de guardar calcula la edad
		  $day = $this->request->data['Persona']['fecha_nac']['day'];
		  $month = $this->request->data['Persona']['fecha_nac']['month'];
		  $year = $this->request->data['Persona']['fecha_nac']['year'];
		  // Calcula la edad y se deja en los datos que se intentaran guardar
		  $this->request->data['Persona']['edad'] = $this->__getEdad($day, $month, $year);          
		  if ($this->Persona->save($this->data)) {
				$this->Session->setFlash('La persona ha sido grabada', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Persona->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('La persona no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Persona->read(null, $id);
		}

		$this->loadModel('Barrio');          
        $barrios = $this->Barrio->find('list', array('fields' => array('nombre')));
        $this->set('barrios', $barrios);
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no válido para la persona', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Alumno->delete($id)) {
			$this->Session->setFlash('La persona ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('La persona no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
	
	//Métodos Privados
	private function __getEdad($day, $month, $year){
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 && $month_diff==0) $year_diff--;
		if ($day_diff < 0 && $month_diff < 0) $year_diff--;
                return $year_diff;
	}
}
?>