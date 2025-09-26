<?php
require __DIR__ . '/../vendor/autoload.php';
use Controllers\PropiedadController;
use MVC\Router;
use Controllers\UsuarioController;
use Controllers\EtiquetaController;
use Controllers\LoginController;
use Controllers\PropiedadEtiquetaController;
use Model\Usuario;
$router=new Router();   
$router->post('/login', [LoginController::class, 'login']);
$router->get('/login', [LoginController::class, 'login']);

$router->post('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);
$router->get('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);

$router->post('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);
$router->get('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);


$router->get('/usuario/home', [UsuarioController::class, 'Home']);
$router->post('/usuario/home', [UsuarioController::class, 'Home']);

$router->post('/singUp', [UsuarioController::class, 'Crear']);
$router->get('/singUp', [UsuarioController::class, 'Crear']);
//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();

?>