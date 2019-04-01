<?php 

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use App\Models\User;

use App\Libraries\Http\ResponseHttp;

/**
 * Clase BaseController
 * Representa el controlador base, este controlador sera hereado por otros controladores
 */
class BaseController
{
    private $loader;

    protected $twig;

    protected $validator;

    protected $user;

    protected $responseHttp;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Cargamos el motor de plantilla
        $this->loadTemplateEngine();

        // Obtenemos el usuario con la sessión iniciada si lo hay
        $this->getUserLoged();

        // Cargamos los filtros
        $this->configFilters();

        // Instanceamos el objetos para retornar las respuestas json a las vistas
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

    /**
     * Función que obtiene la session del usuario, si lo hay
     */
    private function getUserLoged()
    {
        // 
        if(isset($_SESSION['authenticated'])){

            $this->user = new User();

            $this->user->find('_id', $_SESSION['_id']);
        }
    }

    /**
     * Función que renderiza una vista con los datos
     */
    protected function renderView($template, $data)
    {
        return $this->twig->render($template, [
            'user' => $this->user,
            'data'  =>  $data
        ]);
    }

    /**
     * Funcion que envia respuesta json
     * 
     */
    protected function sendResponse($data = array(), $code = 200)
    {
        return $this->responseHttp->response($data, $code);
    }
}
