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
use Controllers\RolController;
$router=new Router();   
$router->post('/login', [LoginController::class, 'login']);
$router->get('/login', [LoginController::class, 'login']);

$router->post('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);
$router->get('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);

$router->post('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);
$router->get('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);


$router->get('/usuario/home', [UsuarioController::class, 'Home']);
$router->post('/usuario/home', [UsuarioController::class, 'Home']);

$router->get('/admin/usuarios', [UsuarioController::class, 'Gestion']);
$router->post('/admin/usuarios', [UsuarioController::class, 'Gestion']);

$router->get('/admin/roles', [RolController::class, 'Gestion']);
$router->post('/admin/roles', [RolController::class, 'Gestion']);

$router->post('/singUp', [UsuarioController::class, 'Crear']);
$router->get('/singUp', [UsuarioController::class, 'Crear']);

$router->get('/usuarios/obtener', [UsuarioController::class, 'Obtener']);
$router->post('/usuarios/actualizar', [UsuarioController::class, 'Actualizar']);

$router->post('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);
$router->get('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);

$router->get('/detalle-contacto',[PropiedadController::class, 'verDetalleContacto']);

$router->post('/admin/roles/crear', [RolController::class, 'CrearRol']);
$router->get('/admin/roles/crear', [RolController::class, 'CrearRol']);

$router->get('/admin/roles/asignar-usuarios', [RolController::class, 'asignarUsuarios']);

$router->get('/admin/roles/editar', [RolController::class, 'editarRol']);
$router->post('/admin/roles/editar', [RolController::class, 'editarRol']);

$router->post('/admin/roles/asignar', [RolController::class, 'asignarRolAPI']);
//$router->get('/producto/crear', [ProductController::class, 'crear']);
$router->ComprobarRutas();




?>