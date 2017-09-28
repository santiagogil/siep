<?php
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
App::uses('Controller', 'Controller');

class AppController extends Controller {

    // added the debug toolkit
	// sessions support
	// authorization for login and logut redirect
    public $components = array(
            'DebugKit.Toolbar',
			'RequestHandler',
			'Session',
		    'Auth' => array(
                        'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
					    'logoutRedirect' => array('controller' => 'users', 'action' => 'login'), 'authError' => 'Debe estar logueado para ver esta página.',
					    'loginError' => 'Nombre de usuario o contraseña incorrectos, inténtelo nuevamente.',
						'authorize' => array('Controller'),
			),
	);

	public $helpers = array('Form', 'Time', 'Js');

    // Allow the login controllers only
	public function beforeFilter() {
        $this->Auth->allow('login');
		$this->set('current_user', $this->Auth->user());
	}

    public function isAuthorized($user) {
		// Superadmin puede acceder a todo
		// Si no es así entonces se trata de un usuario común y lo redirigimos a otra página.
		// En este caso a la acción usuario del controller users

    	if ($user['status'] == 1 ) {

            if ((isset($user['username']) == "admin") || (isset($user['username']) == "usuario")) {
    			$this->redirect('usuario');
    		}
    	} else {
    		$this->Auth->logout();
    		$this->redirect('login');
        }
	    return true;
	}

	/**
	* Recarga la página ubicando los valores de la matriz 'params[url]'
	* dentro de la matriz 'params[named]'
	*/
	function redirectToNamed()
	{
		$urlArray = $this->params['url'];
		unset($urlArray['url']);
		if(!empty($urlArray))
		{
			$this->redirect($urlArray,null,true);
		}
	}

	/**
	* Recarga la página ubicando los valores de la matriz 'params[url]'
	* dentro de la matriz 'params[named]'
	*/
	function ifActionIs($actions = array())
	{
		foreach($actions as $action)
		{
		   if($action == $this->params['action'])
		   {
			   return true;
		   }
		}
		return false;
	}

	/**
	* Devuelve el Id del último Ciclo cargado.
	*/
	function getLastCicloId()
	{
	    $this->loadModel('Ciclo');
		$MaxCicloId = $this->Ciclo->find('first', array('order'=>'Ciclo.id DESC'));
	    return $MaxCicloId['Ciclo']['id'];
	}

  	/**
	* Devuelve el Id del Centro al que pertenece el usuario logueado.
	*/
	function getUserCentroId()
	{
	    $centroId = $this->Auth->user('centro_id');
	    return $centroId;
	}

  	/**
	* Devuelve el nivel del Centro al que pertenece el usuario logueado.  
	*/
	function getUserCentroNivel()
	{
	    $centroId = $this->Auth->user('centro_id');
	    $this->loadModel('Centro');
	    $centroNivel = $this->Centro->find('list', array('fields'=>array('nivel_servicio'), 'conditions'=>array('id'=>$centroId)));
	    return $centroNivel;
	}

	/**
	* Devuelve el Id de la última Inscripción de un alumno determinado.
	*/
	function getLastInscripcionId($alumnoId)
	{
	    $this->loadModel('Inscripcion');
		$MaxInscripcionId = $this->Inscripcion->find('first', array('order'=>'Inscripcion.id DESC', 'conditions'=>array('alumno_id'=>$alumnoId)));
	    return $MaxInscripcionId['Inscripcion']['id'];
	}

	/**
	* Devuelve el nivel el id del Ciclo actual.  
	*/
	function getActualCicloId()
	{
		$hoyArray = getdate();
        $hoyAñoString = $hoyArray['year']; 
        $this->loadModel('Ciclo');
        $cicloIdActual = $this->Ciclo->find('list', array('fields'=>array('id'), 'conditions' => array('nombre' => $hoyAñoString)));	
		return $cicloIdActual;
	}

	/**
	* Devuelve el ciclo actual y el posterior sí lo hubiera.
	*/
	function getTwoLastCicloNombres($cicloIdActual, $cicloIdUltimo)
	{
	    if ($cicloIdActual != $cicloIdUltimo) {
			$this->loadModel('Ciclo');
	        $cicloNombresDosUltimos = $this->Ciclo->find('list', array('fields'=>array('nombre'), 'conditions' => array('id' => array($cicloIdActual, $cicloIdUltimo))));
	        return $cicloNombresDosUltimos;
		} else {
			return $cicloNombreActual;			
		}
	}	
}
