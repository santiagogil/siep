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
}