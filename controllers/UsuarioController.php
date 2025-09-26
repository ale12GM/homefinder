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
    public static function Home(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('usuario/home',[
            'usuarios' => $usuarios
        ]);
    }
    public static function AdminHome(Router $router){

        $usuarios = Usuario::listar();
        $router->render('admin/home',[
            'usuarios' => $usuarios
        ]);
    }
}

?>