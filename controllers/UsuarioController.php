<?php
namespace Controllers;
use Model\Usuario;
use MVC\Router;
class UsuarioController{
    public static function Index(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('auth/login',[
            'usuarios' => $usuarios
        ]);
    }
    public static function Home(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('usuario/home',[
            'usuarios' => $usuarios
        ]);
    }
}

?>