<?php
namespace Controllers;
use Model\UsuarioRol;
use MVC\Router;
class UsuarioRolController{
    public static function IndexEtiqueta(Router $router){
    
        $usuariorol = UsuarioRol::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'usuariorol' => $usuariorol
        ]);
    }
}

?>