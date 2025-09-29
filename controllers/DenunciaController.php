<?php
namespace Controllers;
use Model\Denuncia;
use MVC\Router;
class DenunciaController{
    public static function IndexDenuncias(Router $router){
        $contactos = Denuncia::listar();
        $router->render('usuario/denuncia',[
            'denuncia' => $contactos
        ]);
    }
}
?>