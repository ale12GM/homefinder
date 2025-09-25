<?php
require __DIR__ . '/../vendor/autoload.php';
use Controllers\PropiedadController;
use MVC\Router;
use Controllers\UsuarioController;
use Controllers\EtiquetaController;
use Model\Usuario;
$router=new Router();   
$router->post('/login', [UsuarioController::class, 'Index']);
$router->get('/login', [UsuarioController::class, 'Index']);

$router->post('/login/venta', [PropiedadController::class, 'IndexPropiedad']);
$router->get('/login/venta', [PropiedadController::class, 'IndexPropiedad']);

$router->post('/login/publicar_propiedad', [PropiedadController::class, 'Crear']);
$router->get('/login/publicar_propiedad', [PropiedadController::class, 'Crear']);

$router->post('/login/publicar_propiedad', [EtiquetaController::class, 'IndexEtiqueta']);
$router->get('/login/publicar_propiedad', [EtiquetaController::class, 'IndexEtiqueta']);
//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();

?>