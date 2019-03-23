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
            return json_encode([
                'success'   =>  true,
                'message'   =>  'Registro exitoso'
            ]);
        }else{
            return json_encode([
                'success'   =>  false,
                'message'     =>  'Los sentimos ocurrio un error vuelve a intertarlo'  
            ]);
        }
    }

    public function validator($data = array())
    {
        
    }
}
