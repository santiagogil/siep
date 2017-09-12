<?php
App::uses('AppController', 'Controller');

class MatriculasController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		/* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
		*Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
		*/
		if (($this->Auth->user('role') === 'superadmin')  || ($this->Auth->user('role') === 'admin')) {
			$this->Auth->allow();
		} elseif ($this->Auth->user('role') === 'usuario') {
			$this->Auth->allow('index', 'view');
		}
		/* FIN */
	}

	function index() {

	}

	function requestDatatable() {

		$this->loadModel('Curso');
		$this->Curso->contain();
		
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		if ($userRole === 'admin') {
			$result = $this->Curso->find('all', array('conditions'=>array('Curso.centro_id' => $userCentroId)));
		} else if ($userRole === 'usuario') {
			$nivelCentro = $this->Curso->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));
			$nivelCentroId = $this->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
			$result = $this->Curso->find('all', array('conditions'=>array('Curso.centro_id' => $nivelCentroId)));
		} else if ($userRole === 'superadmin') {
			$result = $this->Curso->Centro->find('all');
		}	

		$result = [
			"data" => $result
		];

		$this->autoRender = false;
		$this->response->type('json');

		$json = json_encode($result);
		$this->response->body($json);
	}
}
?>
