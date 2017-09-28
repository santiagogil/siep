<?php
App::uses('AppController', 'Controller');

class MatriculasController extends AppController
{
    // Permite agregar el Helper de Siep a las vistas
    public $helpers = array('Siep');

    public function beforeFilter()
    {
        parent::beforeFilter();

        /* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */

        // Importa el Helper de Siep al controlador es accesible mediante $this->Siep
        App::import('Helper', 'Siep');
        $this->Siep= new SiepHelper(new View());

        /*
        --------------------------------------------------------------
                   Ejemplo de verificacion de rol con el Helper
        --------------------------------------------------------------
        if($this->Siep->isAdmin() || $this->Siep->isSuperAdmin()) {
            $this->Auth->allow();
        }

        if($this->Siep->isUsuario()) {
            $this->Auth->allow('index', 'view', 'requestDatatable');
        }
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
        //$this->User->recursive = 0;

        $this->loadModel('Curso');

        $this->paginate = array(
            'contain' => array('Centro'),
            'limit' => 10,
            'order' => array('Curso.centro_id' => 'asc' )
        );

        $this->redirectToNamed();
        $conditions = array();

        if(!empty($this->params['named']['centro_id'])) 
        {
            $conditions['Centro.id = '] = $this->params['named']['centro_id'];
        }

        $userCentroId = $this->getUserCentroId();

        if($this->Siep->isAdmin()) 
        {
            $conditions['Curso.centro_id'] = $userCentroId;
            $matriculas = $this->paginate('Curso',$conditions);
        }

        if($this->Siep->isUsuario())
        {
            $nivelCentroArray = $this->Curso->Centro->findById($userCentroId, 'nivel_servicio');
            $nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];

            if ($nivelCentroString === 'Común - Inicial - Primario') {
                $nivelCentroId = $this->Curso->Centro->find('list', array(
                    'fields' => array('id'),
                    'conditions' => array(
                        'nivel_servicio' => array('Común - Inicial', 'Común - Primario')
                    )
                ));

                $conditions['Curso.centro_id'] = $nivelCentroId;
                $matriculas = $this->paginate('Curso', $conditions);

            } else {
                $nivelCentroId = $this->Curso->Centro->find('list', array(
                    'fields' => array('id'),
                    'conditions' => array('nivel_servicio' => $nivelCentroString)
                ));

                $conditions['Curso.centro_id'] = $nivelCentroId;
                $matriculas = $this->paginate('Curso', $conditions);
            }
        }

        if($this->Siep->isSuperAdmin())
        {
            $matriculas = $this->paginate('Curso',$conditions);
        }

        $this->set(compact('matriculas'));
  	}

/*    public function requestDatatable()
    {
        $conditions = [];


        $query = $this->request->data;

        $columns = $query['columns'];
        $order = $query['order'][0];

        $orderColumn = $columns[$order['column']]['data'];
        $orderColumnDir = $order['dir'];

        $start = $query['start'];
        if($start<=0) { $start = 1; }
        $limite = $query['length'];
        $search = $query['search'];

        $this->paginate = array(
            'contain' => array('Centro'),
            'limit' => $limite,
            'order' => array($orderColumn => $orderColumnDir )
        );

        foreach ($columns as $index => $item)
        {
            $columna = $item['data'];
            $busqueda = $item['search']['value'];
            if(!empty($busqueda))
            {
                switch($columna) {
                    case 'Centro.sigla':
                        $conditions[$columna.' LIKE'] = '%'.$busqueda.'%';
                    break;
                    default:
                        $conditions[$columna] = $busqueda;
                    break;
                }
            }
        }

        $this->loadModel('Curso');
        $userCentroId = $this->getUserCentroId();
        $userRole = $this->Auth->user('role');
        // Modifique las rutas de ROLES al formato SWITCH que es mas llevadero que los IF
        switch ($userRole) {
            case 'admin':
                $conditions['Curso.centro_id'] = $userCentroId;
                $result = $this->paginate('Curso',$conditions);
            break;
            case 'usuario':
                $userCentroId = $this->getUserCentroId();
                $this->loadModel('Curso');
                $nivelCentroArray = $this->Curso->Centro->findById($userCentroId, 'nivel_servicio');
                $nivelCentroString = $nivelCentroArray['Centro']['nivel_servicio'];
                if ($nivelCentroString === 'Común - Inicial - Primario') {
                    $nivelCentroId = $this->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario'))));

                    $conditions['Curso.centro_id'] = $nivelCentroId;
                    $result = $this->paginate('Curso',$conditions);
                } else  {
                    $nivelCentroId = $this->Curso->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));

                    $conditions['Curso.centro_id'] = $nivelCentroId;
                    $result = $this->paginate('Curso',$conditions);
                }
          break;
            case 'superadmin':
                $result = $this->paginate('Curso',$conditions);
            break;
        }
        $result = [
        	"data" => $result
        ];
        $this->autoRender = false;
        $this->response->type('json');
        $json = json_encode($result);
        $this->response->body($json);
    }*/
}
