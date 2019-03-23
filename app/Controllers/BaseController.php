<?php 

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use App\Models\User;

class BaseController
{

    private $loader;

    protected $twig;

    protected $validator;

    protected $user;

    public function __construct()
    {
        // Creamos el objeto que se encarga de cargar las plantillas twig desde una ruta
        $this->loader = new FilesystemLoader('../resources/views'); 
        
        // Creamos el entorno
        $this->twig = new Environment($this->loader, [
            'debug' =>  true,
            'cache' =>  false,
            'auto_reload '  =>  true,
        ]);

        // 
        if(isset($_SESSION['authenticated'])){

            $this->user = new User();

            $this->user->find('_id', $_SESSION['_id']);
        }

        // Agregamos un filtro para imprimir la url mediante twig
        $this->twig->addFilter(new \Twig_SimpleFilter('url', function($url){
            return BASE_URL.$url;
        }));
    }

    protected function renderView($template, $data)
    {
        return $this->twig->render($template, $data);
    }
}
