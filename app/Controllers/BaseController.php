<?php 

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use App\Models\User;

use App\Traits\StringTrait;

use App\Libraries\Http\ResponseHttp;

class BaseController
{
    use StringTrait;

    private $loader;

    protected $twig;

    protected $validator;

    protected $user;

    protected $responseHttp;

    public function __construct()
    {
        $this->loadTemplateEngine();

        $this->getUserLoged();

        $this->configFilters();

        $this->responseHttp = new ResponseHttp();
    }

    private function loadTemplateEngine()
    {
        // Creamos el objeto que se encarga de cargar las plantillas twig desde una ruta
        $this->loader = new FilesystemLoader('../resources/views'); 
        
        // Creamos el entorno
        $this->twig = new Environment($this->loader, [
            'debug' =>  true,
            'cache' =>  false,
            'auto_reload '  =>  true,
        ]);
    }

    private function configFilters()
    {
        // Agregamos un filtro para imprimir la url mediante twig
        $this->twig->addFilter(new \Twig_SimpleFilter('url', function($url){
            return BASE_URL.$url;
        }));
    }

    private function getUserLoged()
    {
        // 
        if(isset($_SESSION['authenticated'])){

            $this->user = new User();

            $this->user->find('_id', $_SESSION['_id']);
        }
    }

    protected function renderView($template, $data)
    {
        return $this->twig->render($template, [
            'user' => $this->user,
            'data'  =>  $data
        ]);
    }

    protected function sendResponse($data = array(), $code = 200)
    {
        return $this->responseHttp->response($data, $code);
    }
}
