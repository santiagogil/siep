<?php
class FamiliarsController extends AppController {

	var $name = 'Familiars';
	var $paginate = array('Familiar' => array('limit' => 3, 'order' => 'Familiar.id DESC'));

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

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Familiar no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('controller' => 'personas', 'action' => 'index'));
		}
		$this->set('familiar', $this->Familiar->read(null, $id));
		$this->loadModel('Persona');
		$personaNombre = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $personaNacionalidad = $this->Persona->find('list', array('fields'=>array('id', 'nacionalidad')));        
        $personaCuilCuit = $this->Persona->find('list', array('fields'=>array('id', 'cuil_cuit')));
        $personaOcupacion = $this->Persona->find('list', array('fields'=>array('id', 'ocupacion')));
        $personaLugarTrabaja = $this->Persona->find('list', array('fields'=>array('id', 'lugar_de_trabajo')));
        $personaCiudad = $this->Persona->find('list', array('fields'=>array('id', 'ciudad')));
        $personaCalleNombre = $this->Persona->find('list', array('fields'=>array('id', 'calle_nombre')));
        $personaCalleNumero = $this->Persona->find('list', array('fields'=>array('id', 'calle_nro')));
        $personaTelefono = $this->Persona->find('list', array('fields'=>array('id', 'telefono_nro')));
        $personaEmail = $this->Persona->find('list', array('fields'=>array('id', 'email'))); 
        $this->set(compact('personaNombre', 'personaNacionalidad', 'personaCuilCuit', 'personaOcupacion', 'personaLugarTrabaja', 'personaCiudad', 'personaCalleNombre', 'personaCalleNumero', 'personaTelefono', 'personaEmail'));
	}

	function add() {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Agregación cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect(array('controller' => 'personas', 'action' => 'index'));
		  }
   		  if (!empty($this->data)) {
			$this->Familiar->create();
			if ($this->Familiar->save($this->data)) {
				$this->Session->setFlash('El familiar ha sido grabado', 'default', array('class' => 'alert alert-success'));
				$inserted_id = $this->Familiar->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El familiar no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$alumnoId = $this->Familiar->Alumno->find('list', array('fields'=>array('id', 'persona_id')));
        $this->loadModel('Persona');
        $alumnos = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions' => array('id' => $alumnoId)));
        $personas = $this->Familiar->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('alumnos', 'personas'));
    }

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Familiar no valido', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('controller' => 'personas', 'action' => 'index'));
		}
		if (!empty($this->data)) {
		  //abort if cancel button was pressed  
          if(isset($this->params['data']['cancel'])){
                $this->Session->setFlash('Los cambios no fueron guardados. Edición cancelada.', 'default', array('class' => 'alert alert-warning'));
                $this->redirect( array('controller' => 'familiars', 'action' => 'view', $id));
		  }
		  if ($this->Familiar->save($this->data)) {
				$this->Session->setFlash('El familiar ha sido grabado', 'default', array('class' => 'alert alert-success'));
				//$this->redirect($this->referer());
				//$this->redirect(array('controller' => 'alumnos','action' => 'index'));
				$inserted_id = $this->Familiar->id;
				$this->redirect(array('action' => 'view', $inserted_id));
			} else {
				$this->Session->setFlash('El familiar no fue grabado. Intentelo nuevamente.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Familiar->read(null, $id);
		}
		$alumnoId = $this->Familiar->Alumno->find('list', array('fields'=>array('id', 'persona_id')));
        $this->loadModel('Persona');
        $alumnos = $this->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona'), 'conditions' => array('id' => $alumnoId)));
        $personas = $this->Familiar->Persona->find('list', array('fields'=>array('id', 'nombre_completo_persona')));
        $this->set(compact('alumnos', 'personas'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Id no valido para familiar', 'default', array('class' => 'alert alert-warning'));
			$this->redirect(array('controller' => 'personas', 'action' => 'index'));
		}
		if ($this->Familiar->delete($id)) {
			$this->Session->setFlash('El Familiar ha sido borrado', 'default', array('class' => 'alert alert-success'));
			$this->redirect(array('controller' => 'personas', 'action' => 'index'));
		}
		$this->Session->setFlash('Familiar no fue borrado', 'default', array('class' => 'alert alert-danger'));
		$this->redirect(array('controller' => 'personas', 'action' => 'index'));
	}
}
?>
