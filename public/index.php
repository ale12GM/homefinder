<?php
require __DIR__ . '/../vendor/autoload.php';
use Controllers\PropiedadController;
use MVC\Router;
use Controllers\UsuarioController;
use Controllers\EtiquetaController;
use Controllers\PropiedadEtiquetaController;
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

$router->post('/login/publicar_propiedad', [PropiedadEtiquetaController::class, 'IndexPropiedadEtiqueta']);
$router->get('/login/publicar_propiedad', [PropiedadEtiquetaController::class, 'IndexPropiedadEtiqueta']);

$router->get('/home', [UsuarioController::class, 'Home']);
$router->post('/home', [UsuarioController::class, 'Home']);
//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();

?>