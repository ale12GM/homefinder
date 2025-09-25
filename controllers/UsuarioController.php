<?php
namespace Controllers;
use Model\Usuario;
use MVC\Router;
class UsuarioController{
    public static function Index(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('inicio_registro/login',[
            'usuarios' => $usuarios
        ]);
    }
}

?>