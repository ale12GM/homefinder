<?php
namespace Controllers;
use Model\Contacto;
use MVC\Router;
class ContactosController{
    public static function IndexContactos(Router $router){
        $contactos = Contacto::listar();
        $router->render('usuario/contacto',[
            'contacto' => $contactos
        ]);
    }
    
}
?>