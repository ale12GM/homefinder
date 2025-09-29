<?php
namespace Controllers;
use Model\RolPermiso;
use MVC\Router;
class RolPermisoController{
    public static function IndexRolPermiso(Router $router){
    
        $rolpermiso = RolPermiso::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'rolpermiso' => $rolpermiso
        ]);
    }
}

?>