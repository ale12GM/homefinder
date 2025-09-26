<?php
namespace Controllers;
use Model\Rol;
use MVC\Router;
class RolController{
    public static function IndexEtiqueta(Router $router){
    
        $rol = Rol::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'rol' => $rol
        ]);
    }
}

?>