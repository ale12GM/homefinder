<?php
namespace Controllers;
use Model\PropiedadEtiqueta;
use MVC\Router;
class PropiedadEtiquetaController{
    public static function IndexPropiedadEtiqueta(Router $router){
    
        $propiedadetiquetas = PropiedadEtiqueta::listar();
        $router->render('usuario/publicar_propiedad',[
            'propiedadetiqueta' => $propiedadetiquetas
        ]);
    }
}

?>