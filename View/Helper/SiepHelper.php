<?php

App::uses('AppHelper', 'View/Helper');

class SiepHelper extends AppHelper
{
    public function isSuperAdmin()
    {
        return (AuthComponent::user('role') == 'superadmin') ? true : false;
    }

    public function isUsuario()
    {
        return (AuthComponent::user('role') == 'usuario') ? true : false;
    }

    public function isAdmin()
    {
        return (AuthComponent::user('role') == 'admin') ? true : false;
    }

    public function verUltimaQuery($modelo)
    {
        $log = $modelo->getDataSource()->getLog(false, false);
        debug($log);
    }

    public function clearfix($counter,$rows=2)
    {
        if($counter%$rows==0)
        {
            echo '<div class="clearfix"></div>';
        }
        $counter++;
        return $counter;
    }
}