<?php
App::uses('AppController', 'Controller');

class InscripcionsController extends AppController {

	var $name = 'Inscripcions';
    public $uses = array('Inscripcion', 'Curso', 'Materia');
	public $helpers = array('Form', 'Time', 'Js', 'TinyMCE.TinyMCE');
	public $components = array('Session', 'RequestHandler');
	var $paginate = array('Inscripcion' => array('limit' => 4, 'order' => 'Inscripcion.fecha_alta DESC'));
		
	function beforeFilter(){
	    parent::beforeFilter();
		//Si el usuario tiene un rol de superadmin le damos acceso a todo.
        //Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        if(($this->Auth->user('role') === 'superadmin')  || ($this->Auth->user('role') === 'admin')) {
	        $this->Auth->allow();
	    } elseif ($this->Auth->user('role') === 'usuario') { 
	        $this->Auth->allow('index', 'view');
	    }
        //Si se ejecutan las acciones add/edit activa la función privada "lists".
		if($this->ifActionIs(array('add', 'edit'))){
			$this->__lists();
		}
    }
	
	public function index() {
		$this->Inscripcion->recursive = 1;
		$this->paginate['Inscripcion']['limit'] = 4;
		$this->paginate['Inscripcion']['order'] = array('Inscripcion.fecha_alta' => 'DESC');
		$cicloIdActual = $this->getLastCicloId();
		$userCentroId = $this->getUserCentroId();
		if($this->Auth->user('role') === 'admin') {
		$this->paginate['Inscripcion']['conditions'] = array('Inscripcion.ciclo_id' => $cicloIdActual, 'Inscripcion.centro_id' => $userCentroId);
		}
    	$alumnoId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('id', 'persona_id')));
		$this->loadModel('Persona');
        $alumnoNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));    
		$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla')));
		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['centro_id']))
		{
			$conditions['Inscripcion.centro_id ='] = $this->params['named']['centro_id'];
		}
		if(!empty($this->params['named']['legajo_nro']))
		{
			$conditions['Inscripcion.legajo_nro ='] = $this->params['named']['legajo_nro'];
		}
		if(!empty($this->params['named']['estado']))
		{
			$conditions['Inscripcion.estado ='] = $this->params['named']['estado'];
		}
		$inscripcions = $this->paginate('Inscripcion',$conditions);
		$this->set(compact('inscripcions', 'alumnoNombre', 'centros'));
	}
    
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Inscripcion no valida.', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('inscripcion', $this->Inscripcion->read(null, $id));

		$alumnoId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('id', 'persona_id')));
		$this->loadModel('Persona');
        $alumnoNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('inscripcions', 'alumnoNombre'));
	}
        
	public function add() {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
		  if (!empty($this->data)) {
			$this->Inscripcion->create();
 		    //Antes de guardar genera el nombre del agente
			$this->request->data['Inscripcion']['empleado_id'] = $this->Auth->user('empleado_id');
			//Genera el centro id del usuario y se deja en los datos que se intentaran guardar
		    $userCentroId = $this->getUserCentroId();
		    $this->request->data['Inscripcion']['centro_id'] = $userCentroId;
			//Genera el ciclo id y se deja en los datos que se intentaran guardar
			$cicloId = $this->getLastCicloId();
			$this->request->data['Inscripcion']['ciclo_id'] = $cicloId;
			//Antes de guardar genera el número de legajo del Alumno.
			$ciclos = $this->Inscripcion->Ciclo->findById($cicloId, 'nombre');
			$ciclo = substr($ciclos['Ciclo']['nombre'], -2);
			$alumnoId = $this->request->data['Inscripcion']['alumno_id'];
			$personaDoc = $this->Inscripcion->Alumno->Persona->findById($alumnoId, 'documento_nro');
            //$personaDoc = $personasDoc['Persona']['documento_nro'];
			//Genera el nro de legajo y se deja en los datos que se intentaran guardar
			$codigoActual = $this->__getCodigo($ciclo, $personaDoc);
			//Comprueba que ese legajo no exista.
			$codigoLista = $this->Inscripcion->find('list', array('fields'=>array('legajo_nro')));
            if (in_array($codigoActual, $codigoLista, true))
            { 
                $this->Session->setFlash('El alumno ya está inscripto en este ciclo.', 'default', array('class' => 'alert alert-danger'));
			}else{
				$this->request->data['Inscripcion,']['legajo_nro'] = $this->__getCodigo($ciclo, $personaDoc);
			//Antes de guardar genera el estado de la inscripción
			    if($this->request->data['Inscripcion']['fotocopia_dni'] == true && $this->request->data['Inscripcion']['certificado_septimo'] == true && $this->request->data['Inscripcion']['analitico'] == true){
			        $estado = "COMPLETA";	
			    }else{
			        $estado = "PENDIENTE";
			    }
			//Genera el estado y se deja en los datos que se intentaran guardar
			    $this->request->data['Inscripcion']['estado'] = $estado;
				if ($this->Inscripcion->save($this->data)) {
					$this->Session->setFlash('La inscripcion ha sido grabada.', 'default', array('class' => 'alert alert-success'));
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
			//Antes de guardar genera el estado de la inscripción
			if($this->request->data['Inscripcion']['fotocopia_dni'] == true && $this->request->data['Inscripcion']['certificado_septimo'] == true && $this->request->data['Inscripcion']['certificado_laboral'] == true){
			   $estado = "COMPLETA";	
			}else{
			   $estado = "PENDIENTE";
			}
			//Se genera el estado y se deja en los datos que se intentaran guardar
			$this->request->data['Inscripcion']['estado'] = $estado;
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
        $this->loadModel('Empleado');
        $ciclos = $this->Inscripcion->Ciclo->find('list');
		$cicloIdActual = $this->getLastCicloId();
		$centros = $this->Inscripcion->Centro->find('list');
		$empleados = $this->Inscripcion->Empleado->find('list', array('fields'=>array('id', 'nombre_completo_empleado'), 'conditions'=>array('id'== 'empleadoId')));
		$userCentroId = $this->getUserCentroId();
		$cursos = $this->Inscripcion->Curso->find('list', array('fields'=>array('id','nombre_completo_curso')));
		$materias = $this->Inscripcion->Materia->find('list');
    	$alumnoId = $this->Inscripcion->Alumno->find('list', array('fields'=>array('id', 'persona_id')));
        $this->loadModel('Persona');
        $alumnoNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions' => array('id' => $alumnoId), 'order'=>'nombre_completo_persona ASC'));		
		$this->set(compact('alumnoNombre', 'ciclos', 'centros', 'cursos', 'materias', 'empleados', 'cicloIdActual'));
	}
	
	private function __getCodigo($ciclo, $personaDoc){
		$legajo= $personaDoc."-".$ciclo;
		return $legajo;
    }
}
?>
