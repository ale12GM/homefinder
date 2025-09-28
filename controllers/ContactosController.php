<?php
namespace Controllers;
use Model\Contactos;
use MVC\Router;
class ContactosController{
    public static function IndexContactos(Router $router){
        $contactos = Contactos::listar();
        $router->render('usuario/contacto',[
            'contacto' => $contactos
        ]);
    }
    
}
?>