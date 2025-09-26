<?php
namespace Controllers;
use Model\AuditoriaApp;
use MVC\Router;
class AuditoriaAPPController{
    public static function IndexEtiqueta(Router $router){
    
        $auditoriaapp = AuditoriaAPP::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'auditoriaapp' => $auditoriaapp
        ]);
    }
}

?>