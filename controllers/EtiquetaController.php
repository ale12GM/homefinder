<?php
namespace Controllers;
use Model\Etiqueta;
use MVC\Router;
class EtiquetaController{
    public static function IndexEtiqueta(Router $router){
    
        $etiquetas = Etiqueta::listar();
        $router->render('usuario/publicar_propiedad',[
            'etiquetas' => $etiquetas
        ]);
    }
}

?>