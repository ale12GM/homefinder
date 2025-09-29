<?php
namespace Controllers;
use Model\Propiedad;
use MVC\Router;
use Model\Etiqueta;
use Model\Contacto;
class PropiedadController{
    public static function IndexPropiedad(Router $router){
    // Obtener todas las propiedades
    $propiedades = Propiedad::listar();

    // Filtrar solo las activas
    $propiedadesActivas = array_filter($propiedades, function($p){
        return isset($p['estado']) && $p['estado'] === 'activo';
    });

    $router->render('usuario/venta', [
        'propiedades' => $propiedadesActivas
    ]);
}
public static function GestionPropiedades(Router $router){
    if(session_status() === PHP_SESSION_NONE) session_start();
    $usuarioId = $_SESSION['id'] ?? 0;
    $permisosUsuario = $_SESSION['permisos'] ?? [];

    // Verificar si tiene permiso para ver todas las propiedades
    if(!in_array('ver_todas_propiedades', $permisosUsuario)){
        $router->render('acceso_denegado');
        return;
    }

    $propiedades = Propiedad::listar();

    $router->render('admin/gestion_de_propiedades',[
        'propiedades'=> $propiedades,
        'permisos' => $permisosUsuario
    ]);
}

public static function MisPropiedades(Router $router) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $usuarioId = $_SESSION['id'] ?? 0;
    $permisosUsuario = $_SESSION['permisos'] ?? [];

    // Verificar si tiene permiso para ver sus propias propiedades
    if(!in_array('ver_propiedad_propia', $permisosUsuario)){
        $router->render('acceso_denegado');
        return;
    }

    $propiedades = Propiedad::where('id_usuario', $usuarioId);

    $propiedadesActivas = array_filter($propiedades, function($p){
        return isset($p['estado']) && $p['estado'] === 'activo';
    });

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
public static function EditarPropiedad(Router $router){
    if(session_status() === PHP_SESSION_NONE) session_start();

    $usuarioId = $_SESSION['id'];
    $permisosUsuario = $_SESSION['permisos'] ?? [];
    $etiquetas = Etiqueta::listar();

    if(!isset($_GET['id'])){
        header('Location: /usuario/mispropiedades');
        exit;
    }

    $id = intval($_GET['id']);
    $propiedadData = Propiedad::obtener($id);

    if(!$propiedadData){
        header('Location: /usuario/mispropiedades');
        exit;
    }

    // Validación de permisos
    $puedeEditarTodas = in_array('editar_todas_propiedades', $permisosUsuario);
    $puedeEditarPropia = in_array('editar_propiedad_propia', $permisosUsuario) && $propiedadData['id_usuario'] == $usuarioId;

    if(!$puedeEditarTodas && !$puedeEditarPropia){
        // No tiene permiso
        header('Location: /usuario/mispropiedades');
        exit;
    }

    $propiedad = new Propiedad($propiedadData);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $propiedad = new Propiedad($_POST['propiedades']);

        if(isset($_FILES['propiedades']['name']['imagen']) && $_FILES['propiedades']['name']['imagen'] != ''){
            $nombre_imagen = $_FILES['propiedades']['name']['imagen'];
            $ubicacion = __DIR__ . '/../public/img/' . $nombre_imagen;
            move_uploaded_file($_FILES['propiedades']['tmp_name']['imagen'], $ubicacion);
            $propiedad->setImagen($nombre_imagen);
        }

        $resultado = $propiedad->actualizar($id);

        if($resultado){
            // Determinar de dónde vino el usuario para redirigir apropiadamente
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            $volver = '/usuario/mispropiedades'; // Por defecto
            
            // Si viene de gestión de propiedades, volver ahí
            if(strpos($referer, '/admin/propiedades') !== false || strpos($referer, 'gestion_de_propiedades') !== false){
                $volver = '/admin/propiedades';
            }
            
            header('Location: ' . $volver);
            exit;
        }
    }

    // Determinar la URL de retorno basada en el referer
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $volver = '/usuario/mispropiedades'; // Por defecto
    
    // Si viene de gestión de propiedades, volver ahí
    if(strpos($referer, '/admin/propiedades') !== false || strpos($referer, 'gestion_de_propiedades') !== false){
        $volver = '/admin/propiedades';
    }

    $router->render('propiedades/editar_propiedad', [
        'propiedades' => $propiedad,
        'etiquetas'   => $etiquetas,
        'volver'      => $volver
    ]);
}

public static function Eliminar(Router $router) {
    if(session_status() === PHP_SESSION_NONE) session_start();
    $usuarioId = $_SESSION['id'];

    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $propiedad = Propiedad::obtener($id);

        // Validar que exista y sea del usuario
        if($propiedad && $propiedad['id_usuario'] == $usuarioId){
            // Cambiar estado a 'inactivo'
            $prop = new Propiedad($propiedad);
            $prop->estado = 'inactivo';
            $prop->actualizar($id);
        }
    }

    // Redirigir a la lista
    header('Location: /usuario/mispropiedades');
    exit;
}


}

?>