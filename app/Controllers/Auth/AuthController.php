<?php 
namespace App\Controllers\Auth;

use App\Controllers\BaseController;


class AuthController extends BaseController
{
    
    public function logout()
    {
        if(isset($_SESSION['authenticated']))
        {
            session_destroy();

            header("Location: ". BASE_URL);
        }
    }
}
