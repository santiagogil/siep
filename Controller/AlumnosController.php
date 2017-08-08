<?php
App::uses('AppController', 'Controller');

class AlumnosController extends AppController {

	var $name = 'Alumnos';
	var $paginate = array('Alumno' => array('limit' => 4, 'order' => 'Alumno.created DESC'));

    public function beforeFilter() {
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
		$this->Alumno->recursive = -1;
		$this->paginate['Alumno']['limit'] = 4;
		$this->paginate['Alumno']['order'] = array('Alumno.id' => 'ASC');
		
		$userCentroId = $this->getUserCentroId();
		if($this->Auth->user('role') === 'admin') {
		$this->paginate['Alumno']['conditions'] = array('Alumno.centro_id' => $userCentroId);
		}
        
        $personasId = $this->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions' => array('id' => $personasId)));
        $personaDocumento = $this->Persona->find('list', array('fields'=>array('documento_nro'), 'conditions' => array('id' => $personasId)));
          		
        $this->redirectToNamed();
		$conditions = array();
        if(!empty($this->params['named']['legajo_fisico_nro'])){
			$conditions['Alumno.legajo_fisico_nro ='] = $this->params['named']['legajo_fisico_nro'];
		}
		$alumnos = $this->paginate('Alumno', $conditions);

        $this->set(compact('alumnos', 'personaNombre', 'personaDocumento'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Alumno no valido', 'default', array('class' => 'alert alert-danger'));
			$this->redirect(array('action' => 'index'));
		}
		$options = array('conditions' => array('Alumno.' . $this->Alumno->primaryKey => $id));
		$this->pdfConfig = array(
			'download' => true,
			'filename' => 'alumno_' . $id .'.pdf'
		);
		$this->set('alumno', $this->Alumno->read(null, $id));
        //Genera nombres en el view.
		//Datos personales del Alumno
		$alumnoId = $this->Alumno->find('list', array('fields'=>array('persona_id')));
        $this->loadModel('Persona');
        $alumnoNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona'), 'conditions' => array('id' => $alumnoId)));
        $alumnoDocumentoTipo = $this->Persona->find('list', array('fields'=>array('documento_tipo'), 'conditions' => array('id' => $alumnoId)));
        $alumnoDocumentoNumero = $this->Persona->find('list', array('fields'=>array('documento_nro'), 'conditions' => array('id' => $alumnoId)));
        $alumnoEdad = $this->Persona->find('list', array('fields'=>array('edad'), 'conditions' => array('id' => $alumnoId)));

        $notaCicloId = $this->Alumno->Nota->find('list', array('fields'=>array('ciclo_id')));
		$this->loadModel('Ciclo');
		$cicloNombre = $this->Ciclo->find('list', array('fields'=>array('nombre'), 'conditions'=>array('id'=>$notaCicloId)));
        
		$centroId = $this->Alumno->Inscripcion->find('list', array('fields'=>array('centro_id')));
		$this->loadModel('Centro');
		$centroNombre = $this->Centro->find('list', array('fields'=>array('nombre'), 'conditions'=>array('id'=>$centroId)));
        
		$notaMateriaId = $this->Alumno->Nota->find('list', array('fields'=>array('materia_id')));
		$this->loadModel('Materia');
		$materiaAlia = $this->Materia->find('list', array('fields'=>array('alia'), 'conditions'=>array('id'=>$notaMateriaId)));
		//Familiares relacionados.
        $this->loadModel('Persona');
        $familiarNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
        /*
        $familiarVinculo = $this->Persona->Familiar->find('list', array('fields' => array('vinculo'), 'conditions' => array('id' => $alumnoId))); 
        $familiarCuilCuit = $this->Persona->find('list', array('fields' => array('cuil_cuit')));
        $familiarTelefono = $this->Persona->find('list', array('fields' => array('telefono_nro')));        
        $familiarEmail = $this->Persona->find('list', array('fields' => array('email')));
		*/
		$this->set(compact('alumnos', 'alumnoNombre', 'alumnoDocumentoTipo', 'alumnoDocumentoNumero', 'alumnoEdad', 'centroNombre', 'cicloNombre', 'foto', 'materiaAlia', 'barrioNombre', 'familiarNombre', '$familiarCuilCuit', '$familiarTelefono', '$familiarEmail'));
    }
	
	public function add() {
		//abort if cancel button was pressed  
        if(isset($this->params['data']['cancel'])){
            $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
            $this->redirect( array( 'action' => 'index' ));
		}
        if (!empty($this->data)) {
			$this->Alumno->create();
			// Obtiene y asigna el centro al alumno
			$centroId = $this->getUserCentroId();
			$this->request->data['Alumno']['centro_id'] = $centroId;

			if ($this->Alumno->save($this->request->data)) {
				$this->Session->setFlash('El alumno ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Alumno->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El alumno no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
        $personas = $this->Alumno->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('alumnos', 'personas'));
    }

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Alumno no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array( 'action' => 'index' ));
		  }
	    if ($this->Alumno->save($this->data)) {
				$this->Session->setFlash('El alumno ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Alumno->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El alumno no ha sido grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Alumno->read(null, $id);
		}
		$personas = $this->Alumno->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('alumnos', 'personas'));
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para el alumno', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Alumno->delete($id)) {
			$this->Session->setFlash('El alumno ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El alumno no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
