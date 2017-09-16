<?php
App::uses('AppController', 'Controller');

class MatriculasController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();

        /* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        switch ($this->Auth->user('role')) {
            case 'superadmin':
            case 'admin':
                $this->Auth->allow();
            break;
            case 'usuario':
                $this->Auth->allow('index', 'view', 'requestDatatable');
            break;
        }
    }

    public function index() {
        
  	}

    public function requestDatatable()
    {
        $this->loadModel('Curso');
        $userCentroId = $this->getUserCentroId();
        $userRole = $this->Auth->user('role');
        // Modifique las rutas de ROLES al formato SWITCH que es mas llevadero que los IF
				switch ($userRole) {
					case 'admin':
						$result = $this->Curso->find('all', array(
							'contain' => array('Centro'),
							'conditions'=>array('Curso.centro_id' => $userCentroId)
						));
					break;
					case 'usuario':
    				$userCentroId = $this->getUserCentroId();
            $this->loadModel('Curso');
            $nivelCentroArray = $this->Curso->Centro->findById($userCentroId, 'nivel_servicio');
            $nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];
            if ($nivelCentroString === 'Común - Inicial - Primario') {
                $nivelCentroId = $this->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));     
                $result = $this->Curso->find('all', array('conditions'=>array('Curso.centro_id' => $nivelCentroId)));
            } else  {
                $nivelCentroId = $this->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
                $result = $this->Curso->find('all', array('conditions'=>array('Curso.centro_id' => $nivelCentroId)));
            }
          break;
					case 'superadmin':
						// Al definir contain solo relaciona el modelo solicitado en el array y no todas las dependencias definidas en el modelo
						$result = $this->Curso->find('all', array(
							'contain' => array('Centro')
						));
					break;
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
