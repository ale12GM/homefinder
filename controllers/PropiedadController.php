<?php
namespace Controllers;
use Model\Propiedad;
use MVC\Router;
class PropiedadController{
    public static function IndexPropiedad(Router $router){
    
        $propiedades = Propiedad::listar();
        $router->render('usuario/venta',[
            'propiedades' => $propiedades
        ]);
    }
    
    public static function Crear(Router $router){
        $propiedades = new Propiedad();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $propiedades = new Propiedad($_POST['propiedades']);
            $nombre_imagen = $_FILES['propiedades']['name']['imagen'];
$ubicacion = __DIR__ . '/../public/img/' . $nombre_imagen;
move_uploaded_file(
    $_FILES['propiedades']['tmp_name']['imagen'],
    $ubicacion);
    
        $propiedades->setImagen($nombre_imagen);
        $resultado = $propiedades->crear();
        if($resultado){
            echo "Se insertó los datos";
            header('Location: /login/venta');
            exit;
        }
   }
   $router->render('usuario/publicar_propiedad',[
    'propiedades'=> $propiedades
    ]);
}
}

?>