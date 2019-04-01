<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

use App\Models\User;

class RegisterController extends BaseController
{
    
    public function showForm()
    {
        return $this->renderView('auth/register.twig', []);   
    }

    public function register()
    {
        // Validamos los datos del usuario
        
        // 
        $user = new User();

        // 
        if($user->save($_POST))
        {
            $this->sendRegisterResponse();
        }else{
            $this->sendFaliedRegisterResponse();
        }
    }

    public function validator($data = array())
    {
        
    }

    private function sendRegisterResponse()
    {
        return $this->sendResponse([
            'success'   =>  true,
            'message'   =>  'Registro exitoso'
        ], 200);
    }

    private function sendFaliedRegisterResponse()
    {
        return $this->sendResponse([
            'success'   =>  false,
            'message'     =>  'Los sentimos ocurrio un error vuelve a intertarlo'  
        ], 500);
    }
}
