<?php
namespace Controllers;
use Model\Propiedad;
use MVC\Router;
use Model\Etiqueta;
class PropiedadController{
    public static function IndexPropiedad(Router $router){
    
        $propiedades = Propiedad::listar();
        
        $router->render('usuario/venta',[
            'propiedades' => $propiedades
        ]);
    }
    public static function MisPropiedades(Router $router) {
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    $usuarioId = $_SESSION['id'];

    $propiedades = Propiedad::where('id_usuario', $usuarioId);

    $router->render('usuario/ver_propiedades_propias', [
        'propiedades' => $propiedades
    ]);
    }

public static function verDetalleContacto(Router $router) {//ojo
    
    $id_propiedad = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
    
    if (!$id_propiedad) {
        
        header('Location: /venta');
        exit;
    }
    $contactos = Propiedad::findConContactos($id_propiedad);

    $router->render('usuario/detalleContacto', [
        'contactos' => $contactos,
        'id_propiedad' => $id_propiedad
    ]);
}

    public static function Crear(Router $router){
        $propiedades = new Propiedad();
        $etiquetas = Etiqueta::listar();

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])){
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
            header('Location: /usuario/propiedades');
            exit;
        }
   }
   $router->render('usuario/publicar_propiedad',[
    'propiedades'=> $propiedades,
    'etiquetas'=>$etiquetas
    ]);
}
}

?>