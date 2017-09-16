<?php
App::uses('AppController', 'Controller');

class CursosInscripcionsController extends AppController {

	var $name = 'CursosInscripcions';
   	public $paginate = array('CursosInscripcion' => array('limit' => 2, 'order' => 'CursosInscripcion.curso_id ASC'));

    public function beforeFilter() {
        parent::beforeFilter();
        /* ACCESOS SEGÚN ROLES DE USUARIOS (INICIO).
        *Si el usuario tiene un rol de superadmin le damos acceso a todo. Si no es así (se trata de un usuario "admin o usuario") tendrá acceso sólo a las acciones que les correspondan.
        */
        if($this->Auth->user('role') === 'superadmin') {
	        $this->Auth->allow();
	    } elseif (($this->Auth->user('role') === 'admin') || ($this->Auth->user('role') === 'usuario')) { 
	        $this->Auth->allow('index');
	    }
	    /* FIN */ 
    } 

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CursosInscripcion->recursive = 1;
		$this->paginate['CursosInscripcion']['limit'] = 8;
		$this->paginate['CursosInscripcion']['order'] = array('CursosInscripcion.curso_id' => 'ASC');
		/* PAGINACIÓN SEGÚN ROLES DE USUARIOS (INICIO).
		*Sí el usuario es "admin" muestra los cursos del establecimiento. Sino sí es "usuario" externo muestra los cursos del nivel.
		*/
		//$cicloIdActual = $this->getLastCicloId();
		$userCentroId = $this->getUserCentroId();
		$userRole = $this->Auth->user('role');
		$estado2 = array("COMPLETA", "PENDIENTE");
		if ($this->Auth->user('role') === 'admin') {
		//$this->paginate['CursosInscripcion']['conditions'] = array('Inscripcion.ciclo_id' => $cicloIdActual, 'Inscripcion.estado' => $estado2, 'Inscripcion.centro_id' => $userCentroId);
		$this->paginate['CursosInscripcion']['conditions'] = array('Inscripcion.estado' => $estado2, 'Inscripcion.centro_id' => $userCentroId);	
		} else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$this->loadModel('Centro');
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$this->paginate['CursosInscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId);
		} else if ($userRole === 'usuario') {
			$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
			$this->paginate['CursosInscripcion']['conditions'] = array('Inscripcion.centro_id' => $nivelCentroId);
		}
		/* FIN */
        /* PAGINACIÓN SEGÚN CRITERIOS DE BÚSQUEDAS (INICIO).
		*Pagina según búsquedas simultáneas ya sea por CENTRO y/o CURSO y/o INSCRIPCIÓN.
		*/
  		$this->redirectToNamed();
		$conditions = array();
		if(!empty($this->params['named']['centro_id'])) {
			$conditions['Inscripcion.centro_id ='] = $this->params['named']['centro_id'];
		}
		if(!empty($this->params['named']['curso_id'])) {
			$conditions['CursosInscripcion.curso_id ='] = $this->params['named']['curso_id'];
		}
		if(!empty($this->params['named']['inscripcion_id'])) {
			$conditions['CursosInscripcion.inscripcion_id ='] = $this->params['named']['inscripcion_id'];
		}
		$cursosInscripcions = $this->paginate('CursosInscripcion', $conditions);
		/* FIN */
		/* SETS DE DATOS PARA COMBOBOX BÚSQUEDA (INICIO). */
        // Por ciclo...
        $ciclosId = $this->CursosInscripcion->Inscripcion->find('list', array('fields'=>array('ciclo_id')));
        $this->loadModel('Ciclo');
        $ciclos = $this->Ciclo->find('list', array('fields'=>array('nombre'), 'conditions' => array('id' => $ciclosId)));
        // Por centro...
        $this->loadModel('Centro');
		$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
		$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro)));
		if ($userRole == 'superadmin') {
			$centros = $this->CursosInscripcion->Centro->find('list', array('fields'=>array('id', 'sigla')));
		} else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$centros = $this->Centro->find('list', array('fields'=>array('sigla'), 'conditions'=>array('id'=>$nivelCentroId)));
		} else if ($userRole == 'admin') {
			$centros = $this->Inscripcion->Centro->find('list', array('fields'=>array('id', 'sigla'), 'conditions'=>array('id'=>$nivelCentroId)));	
		}
		// Por sección...
        $nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
        if ($userRole === 'admin') {
          	$cursos = $this->CursosInscripcion->Curso->find('list', array('fields'=>array('id', 'nombre_completo_curso'), 'conditions' => array('centro_id' => $userCentroId)));    
        } else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$this->loadModel('Centro');
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$cursos = $this->CursosInscripcion->Curso->find('list', array('fields'=>array('nombre_completo_curso'), 'conditions'=>array('centro_id'=>$nivelCentroId)));
		} else if ($userRole === 'usuario') {
           	$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
	        $cursos = $this->CursosInscripcion->Curso->find('list', array('fields'=>array('id', 'nombre_completo_curso'), 'conditions'=>array('centro_id'=>$nivelCentroId)));  
        } else {
        	//Sí es "superadmin"
 	        $cursos = $this->CursosInscripcion->Curso->find('list', array('fields'=>array('id', 'nombre_completo_curso')));
        }
        
        // Por código de inscripción...
        $nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
        if ($userRole === 'admin') {
          	$inscripcions = $this->CursosInscripcion->Inscripcion->find('list', array('fields'=>array('id', 'legajo_nro'), 'conditions' => array('centro_id' => $userCentroId)));    
        } else if (($userRole === 'usuario') || ($nivelCentro === 'Común - Inicial - Primario')) {
			$this->loadModel('Centro');
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>array('Común - Inicial', 'Común - Primario')))); 		
			$inscripcions = $this->CursosInscripcion->Inscripcion->find('list', array('fields'=>array('id', 'legajo_nro'), 'conditions' => array('centro_id' => $nivelCentroId)));
		} else if ($userRole === 'usuario') {
           	$this->loadModel('Centro');
			$nivelCentro = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$userCentroId)));	
			$nivelCentroId = $this->Centro->find('list', array('fields'=>array('id'), 'conditions'=>array('nivel_servicio'=>$nivelCentro))); 		
	        			$inscripcions = $this->CursosInscripcion->Inscripcion->find('list', array('fields'=>array('id', 'legajo_nro'), 'conditions' => array('centro_id' => $nivelCentroId)));  
        } else {
        	//Sí es "superadmin"
 	        $inscripcions = $this->CursosInscripcion->Inscripcion->find('list', array('fields'=>array('id', 'legajo_nro')));
        }
        $personaId = $this->CursosInscripcion->Inscripcion->Alumno->find('list', array('fields'=>array('persona_id')));
		$this->loadModel('Persona');
		$personaNombre = $this->Persona->find('list', array('fields'=>array('nombre_completo_persona')));
		/* FIN */
		$this->set(compact('cursosInscripcions', 'cicloActual', 'cursos', 'inscripcions', 'ciclos', 'personaId', 'personaNombre', 'centros', 'materias'));
   }
}
