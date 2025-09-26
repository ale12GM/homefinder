<?php
namespace Controllers;
use Model\Denuncias;
use MVC\Router;
class DenunciaController{
    public static function IndexDenuncias(Router $router){
        $contactos = Denuncias::listar();
        $router->render('usuario/denuncia',[
            'denuncia' => $contactos
        ]);
    }
}
?>