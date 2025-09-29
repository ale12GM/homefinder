<?php
require __DIR__ . '/../vendor/autoload.php';

use Controllers\PropiedadController;
use Controllers\UsuarioController;
use Controllers\EtiquetaController;
use Controllers\LoginController;
use Controllers\PropiedadEtiquetaController;
use Model\Propiedad;
use Model\Usuario;
use Controllers\RolController;
use MVC\Router;
$router=new Router(); 

$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);


// --- USUARIO PROPIEDADES ---
$router->get('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);
$router->post('/usuario/propiedades', [PropiedadController::class, 'IndexPropiedad']);

$router->get('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);
$router->post('/usuario/propiedades/publicar', [PropiedadController::class, 'Crear']);

$router->get('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);
$router->post('/usuario/mispropiedades', [PropiedadController::class, 'MisPropiedades']);

$router->get('/usuario/propiedades/editar', [PropiedadController::class, 'EditarPropiedad']);
$router->post('/usuario/propiedades/editar', [PropiedadController::class, 'EditarPropiedad']);

$router->get('/usuario/mispropiedades/eliminar', [PropiedadController::class, 'Eliminar']);
$router->post('/usuario/mispropiedades/eliminar', [PropiedadController::class, 'Eliminar']);

// --- ADMIN PROPIEDADES ---
$router->get('/admin/propiedades', [PropiedadController::class, 'GestionPropiedades']);
$router->post('/admin/propiedades', [PropiedadController::class, 'GestionPropiedades']);

$router->get('/admin/propiedades/editar', [PropiedadController::class, 'EditarPropiedad']);
$router->post('/admin/propiedades/editar', [PropiedadController::class, 'EditarPropiedad']);

// --- USUARIO / ADMIN ---
$router->get('/usuario/home', [UsuarioController::class, 'Home']);
$router->post('/usuario/home', [UsuarioController::class, 'Home']);

$router->get('/admin/usuarios', [UsuarioController::class, 'Gestion']);
$router->post('/admin/usuarios', [UsuarioController::class, 'Gestion']);

$router->get('/admin/roles', [RolController::class, 'Gestion']);
$router->post('/admin/roles', [RolController::class, 'Gestion']);

$router->get('/admin/home', [UsuarioController::class, 'AdminHome']);
$router->post('/admin/home', [UsuarioController::class, 'AdminHome']);

$router->post('/singUp', [UsuarioController::class, 'Crear']);
$router->get('/singUp', [UsuarioController::class, 'Crear']);

$router->get('/usuario/restablecer', [UsuarioController::class, 'RestablecerContrasena']);
$router->post('/usuario/restablecer', [UsuarioController::class, 'RestablecerContrasena']);

$router->get('/usuarios/obtener', [UsuarioController::class, 'Obtener']);
$router->post('/usuarios/actualizar', [UsuarioController::class, 'Actualizar']);

$router->get('/acceso_denegado', function() use ($router) {
    $router->render('acceso_denegado'); // apunta a views/acceso_denegado.php
});

// --- COMPROBAR RUTAS ---
$router->ComprobarRutas();




?>