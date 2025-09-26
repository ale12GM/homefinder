<?php
namespace Controllers;
use Model\NormativasContrasenias;
use MVC\Router;
class NormativasContraseniasController{
    public static function IndexEtiqueta(Router $router){
    
        $normativascontrasenias = NormativasContrasenias::listar();
        $router->render('',[                    # Aqui va la ruta donde se mandara la informacion
            'normativascontrasenias' => $normativascontrasenias
        ]);
    }
}

?>