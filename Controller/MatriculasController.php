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
		$result = $this->Curso->find('all');

		$this->autoRender = false;
		$this->response->type('json');

		$result = [
			"data" => $result
		];

		$json = json_encode($result);
		$this->response->body($json);
	}

}
?>
