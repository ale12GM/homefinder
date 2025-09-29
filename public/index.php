<?php
require __DIR__ . '/../vendor/autoload.php';
use Controllers\PropiedadController;
use MVC\Router;
use Controllers\UsuarioController;
use Controllers\EtiquetaController;
use Controllers\LoginController;
use Controllers\PropiedadEtiquetaController;
use Model\Propiedad;
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

$router->get('/admin_usuarios', [UsuarioController::class, 'Gestion']);
$router->post('/admin_usuarios', [UsuarioController::class, 'Gestion']);

$router->post('/singUp', [UsuarioController::class, 'Crear']);
$router->get('/singUp', [UsuarioController::class, 'Crear']);

$router->get('/usuarios/obtener', [UsuarioController::class, 'EditarUsuario']);
$router->post('/usuarios/actualizar', [UsuarioController::class, 'EditarUsuario']);

$router->post('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);
$router->get('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);

$router->get('/admin/gestion_de_usuarios', [UsuarioController::class, 'Gestion']);
$router->get('/admin/editar_usuario', [UsuarioController::class, 'EditarUsuario']);
$router->post('/admin/editar_usuario', [UsuarioController::class, 'EditarUsuario']);
$router->get('/usuarios/bloquear', [UsuarioController::class, 'bloquearUsuario']);

// para AJAX:
$router->get('/usuarios/obtener', [UsuarioController::class, 'Obtener']);
$router->post('/usuarios/actualizarPerfil', [UsuarioController::class, 'actualizarPerfil']);

//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();

?>