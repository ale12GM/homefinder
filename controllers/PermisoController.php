<?php
namespace Controllers;
use Model\Permiso;
use MVC\Router;
class PermisoController{
    public static function IndexPermisos(Router $router){
        $permisos = Permiso::listar();
        $router->render('',[
            'permisos' => $permisos
        ]);
    }
}
?>