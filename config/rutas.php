<?php 

use Phroute\Phroute\RouteCollector;

// Obtenemos la ruta que viene por el navegado (GET)
$route = $_GET['route'] ?? '/'; 

$router = new RouteCollector();

// Rutas para la autenticación y registro de usuarios
$router->group(['prefix' => 'auth'], function($router){

    // Ruta que muestra el formulario para el inicio de sesión
    $router->get('login', [App\Controllers\Auth\LoginController::class, 'showForm']);
    $router->post('login', [App\Controllers\Auth\LoginController::class, 'login']);

    // Ruta que muestra el formulario para el registros de nuevo usuarios
    $router->get('register', [App\Controllers\Auth\RegisterController::class, 'showForm']);
    $router->post('register', [App\Controllers\Auth\RegisterController::class, 'register']);
});

// Creamos un filtro para asegurar el acesso a las rutas protegidas
$router->filter('auth', function(){    
    if(!isset($_SESSION['authenticated'])) 
    {
        header('Location: auth/login');
        return false;
    }
});

// 
$router->group(['before' => 'auth'], function($router){

    // Ruta raiz
    $router->get('/', [App\Controllers\IndexController::class, 'index']);
    $router->get('/home', [App\Controllers\HomeController::class, 'index']);

});

// Instanciamos el objeto dispacher para llamar el medoto que se esta accediendo
$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

// Obtenemos la respuesta del dispatcher
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $route);

// // Retornamos la respuesta
echo $response;