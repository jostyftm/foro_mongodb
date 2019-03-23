<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

use App\Models\User;

class LoginController extends BaseController
{
    
    public function showForm()
    {
        return $this->renderView('auth/login.twig', []);   
    }

    public function login()
    {
        // 
        $user = new User();
        $user->find('email', $_POST['email']);
        
        if(password_verify($_POST['password'], $user->getPassword()))
        {
            $_SESSION['authenticated'] = true;
            $_SESSION['_id'] = $user->getId();
            $_SESSION['user'] = $user->getName();

            return json_encode([
                'success' => true,
                'message' => 'Inicio de sesión exitoso'
            ]);
        }else {
            return json_encode([
                'success' => false,
                'message' => 'Datos incorrectos'
            ]);
        }
        // echo $_POST['password'].' <br />';
        // echo $user->getPassword().'<br />';
        // echo password_verify($_POST['password'], $user->getPassword());
    }

    public function validator($data = array())
    {

    }
}
