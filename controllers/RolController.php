<?php
namespace Controllers;
use Model\Rol;
use MVC\Router;

class RolController {
    public static function Gestion(Router $router) {
        $roles = Rol::listar(); // ¡AQUÍ ESTÁ EL CAMBIO!
                                      // Ahora obtendrás un array de objetos Rol
        $router->render('/admin/gestion_de_roles', [
            'roles' => $roles
        ]);
    }

}