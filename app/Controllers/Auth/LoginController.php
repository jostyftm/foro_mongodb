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

            $this->sendLoginResponse();
        }else {

            $this->sendFaliedLoginResponse();
        }
    }

    public function validator($data = array())
    {

    }

    private function sendLoginResponse()
    {
        $data = [
            'success' => true,
            'message' => 'Inicio de sesión exitoso'
        ];

        return $this->sendResponse($data, 200);
    }

    private function sendFaliedLoginResponse()
    {
        $data = [
            'success' => false,
            'message' => 'Datos incorrectos'
        ];

        return $this->sendResponse($data, 400);
    }
}
