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

$router->get('/usuario/home', [UsuarioController::class, 'Home']);
$router->post('/usuario/home', [UsuarioController::class, 'Home']);

$router->post('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);
$router->get('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);

$router->post('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);
$router->get('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);

$router->post('/usuario/propiedades/publicar', [EtiquetaController::class, 'IndexEtiqueta']);
$router->get('/usuario/propiedades/publicar', [EtiquetaController::class, 'IndexEtiqueta']);

$router->post('/usuario/propiedades/publicar', [PropiedadEtiquetaController::class, 'IndexPropiedadEtiqueta']);
$router->get('/usuario/propiedades/publicar', [PropiedadEtiquetaController::class, 'IndexPropiedadEtiqueta']);


$router->post('/admin/home',[UsuarioController::class,'AdminHome']);
$router->get('/admin/home',[UsuarioController::class,'AdminHome']);


//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();

?>