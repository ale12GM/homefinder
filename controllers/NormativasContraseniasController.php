<?php
namespace Controllers;
use Model\NormativaContrasenia;
use MVC\Router;
class NormativaContraseniaController{
    public static function IndexEtiqueta(Router $router){
    
        $normativascontrasenias = NormativaContrasenia::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'normativascontrasenias' => $normativascontrasenias
        ]);
    }
}

?>