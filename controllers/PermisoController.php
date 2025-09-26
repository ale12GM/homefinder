<?php
namespace Controllers;
use Model\Permisos;
use MVC\Router;
class PermisoController{
    public static function IndexPermiso(Router $router){
        $contactos = Permisos::listar();
        $router->render('usuario/permisos',[
            'permisos' => $contactos
        ]);
    }
}
?>