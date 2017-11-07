<?php
App::uses('AppController', 'Controller');

class VacantesController extends AppController
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

        $this->loadModel('Centro');

        $this->Centro->recursive = -1;
        $comboSectorDb = $this->Centro->find('all', array('fields'=>'DISTINCT sector'));
        // Sanatizo el combo sector, a una simple lista
        $comboSector = [];
        while (list($c, $v) = each($comboSectorDb)) {
            $sector = $v['Centro']['sector'];
            $comboSector[$sector] = $sector;
        }

        $this->loadModel('Ciudad');
        $comboCiudad = $this->Ciudad->find('list', array('fields'=>array('id', 'nombre')));

        $this->loadModel('Ciclo');
        $comboCiclo = $this->Ciclo->find('list', array('fields'=>array('id', 'nombre')));
        $cicloIdUltimo = $this->getLastCicloId();

        $this->loadModel('Curso');
        $conditions = array('AND'=>array(
            'Curso.anio' => array('sala de 4 años', 'sala de 5 años', '1ro', '2do', '3ro', '4to', '5to', '6to'),
            'Curso.division' =>''
        ));
        // Es necesario hacer una columna virtual, para que despues se pueda ordenar en el datatable
        $this->Curso->virtualFields['por_hermanos'] = '
                        (
                select count(ins.id) as hermanos
                from  cursos_inscripcions as curi
                
                left join inscripcions as ins on ins.id = curi.inscripcion_id
                
                where
                   ins.tipo_inscripcion = \'Hermano de alumno regular\' 
                 and ins.centro_id = Centro.id 
                
                and   curi.curso_id = Curso.id
                ) 
        ';
        $this->paginate = array(
            'limit' => 10,
            'conditions' => $conditions,
            'order' => array('Curso.sigla' => 'asc' ),
            'fields' => array(
                'Centro.sigla',
                'Centro.id',
                'Centro.sector',
                'Centro.ciudad_id',
                'Curso.id',
                'Curso.anio',
                'Curso.turno',
                'Curso.plazas',
                'Curso.matricula',
                'Curso.vacantes',
                'por_hermanos',
            ),
            /*
            'group' => array(
                'Centro.sigla',
                'Centro.id',
                'Curso.anio'
            ),
            */
            'contain' => [
                'Centro'
            ]
        );

        $this->redirectToNamed();

        if(!empty($this->params['named']['centro_id']))
        {
            $conditions['Centro.id = '] = $this->params['named']['centro_id'];
        }

        if(!empty($this->params['named']['anio']))
        {
            $conditions['Curso.anio = '] = $this->params['named']['anio'];
        }

        if(!empty($this->params['named']['ciudad_id']))
        {
            $conditions['Centro.ciudad_id = '] = $this->params['named']['ciudad_id'];
        }

        if(!empty($this->params['named']['sector']))
        {
            $conditions['Centro.sector = '] = $this->params['named']['sector'];
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

        $this->set(compact('matriculas','cicloIdUltimo','comboCiclo','comboCiudad','comboSector'));
    }
}
