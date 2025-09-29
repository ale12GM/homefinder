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
        'propiedades' => $propiedadesActivas,
        'permisos' => $permisosUsuario
    ]);
}



public static function Crear(Router $router){
    if(session_status() === PHP_SESSION_NONE) session_start();
    
    $propiedades = new Propiedad();
    $etiquetas = Etiqueta::listar();
    
    // Variables de error inicializadas vacías
    $error_titulo        = "";
    $error_direccion     = "";
    $error_superficie    = "";
    $error_latitud       = "";
    $error_longitud      = "";
    $error_habitaciones  = "";
    $error_banos         = "";
    $error_precio        = "";
    $error_descripcion   = "";
    $error_estado        = "";
    $error_imagen        = "";
    $error_etiquetas     = "";
    $error_contactos     = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Obtener datos del formulario
        $titulo        = trim($_POST['propiedades']['titulo'] ?? '');
        $direccion     = trim($_POST['propiedades']['direccion'] ?? '');
        $superficie    = trim($_POST['propiedades']['superficie_total'] ?? '');
        $latitud       = trim($_POST['propiedades']['latitud'] ?? '');
        $longitud      = trim($_POST['propiedades']['longitud'] ?? '');
        $habitaciones  = $_POST['propiedades']['num_habitaciones'] ?? null;
        $banos         = $_POST['propiedades']['num_banos'] ?? null;
        $precio        = trim($_POST['propiedades']['precio'] ?? '');
        $descripcion   = trim($_POST['propiedades']['descripcion'] ?? '');
        $estado        = trim($_POST['propiedades']['estado'] ?? '');
        $etiquetas_ids = $_POST['etiquetas'] ?? [];
        $contactos_data = $_POST['contactos'] ?? [];
        $imagen_file   = $_FILES['propiedades'] ?? null;

        // --- Validaciones obligatorias ---

        // Título
        if ($titulo === '') {
            $error_titulo = "El título es obligatorio.";
        } elseif (mb_strlen($titulo) > 50) {
            $error_titulo = "El título no puede exceder 50 caracteres.";
        }


        // Dirección
        if ($direccion === '') {
            $error_direccion = "La dirección es obligatoria.";
        } elseif (mb_strlen($direccion) > 255) {
            $error_direccion = "La dirección no puede exceder 255 caracteres.";
        }

        // Superficie
        if ($superficie === '') {
            $error_superficie = "La superficie es obligatoria.";
        } elseif (!is_numeric($superficie)) {
            $error_superficie = "La superficie debe ser un número.";
        } elseif ((float)$superficie < 0) {
            $error_superficie = "La superficie no puede ser negativa.";
        } else {
            $superficie = number_format((float)$superficie, 2, '.', '');
        }

        // Latitud
        if ($latitud !== '') {
            if (!is_numeric($latitud)) {
                $error_latitud = "La latitud debe ser numérica.";
            } else {
                $latitud = number_format((float)$latitud, 6, '.', '');
            }
        }

        // Longitud
        if ($longitud !== '') {
            if (!is_numeric($longitud)) {
                $error_longitud = "La longitud debe ser numérica.";
            } else {
                $longitud = number_format((float)$longitud, 6, '.', '');
            }
        }

        // Habitaciones
        if ($habitaciones !== null && $habitaciones !== '') {
            if (filter_var($habitaciones, FILTER_VALIDATE_INT) === false) {
                $error_habitaciones = "Número de habitaciones inválido.";
            } elseif ((int)$habitaciones < 0) {
                $error_habitaciones = "El número de habitaciones no puede ser negativo.";
            } else {
                $habitaciones = (int)$habitaciones;
            }
        } else {
            $habitaciones = null;
        }

        // Baños
        if ($banos !== null && $banos !== '') {
            if (filter_var($banos, FILTER_VALIDATE_INT) === false) {
                $error_banos = "Número de baños inválido.";
            } elseif ((int)$banos < 0) {
                $error_banos = "El número de baños no puede ser negativo.";
            } else {
                $banos = (int)$banos;
            }
        } else {
            $banos = null;
        }

        // Precio
        if ($precio === '') {
            $error_precio = "El precio es obligatorio.";
        } elseif (!is_numeric($precio)) {
            $error_precio = "El precio debe ser un número.";
        } elseif ((float)$precio < 0) {
            $error_precio = "El precio no puede ser negativo.";
        } else {
            $precio = number_format((float)$precio, 2, '.', '');
        }

        // Descripción
        if ($descripcion === '') {
            $error_descripcion = "La descripción es obligatoria.";
        } elseif (mb_strlen($descripcion) > 500) {
            $error_descripcion = "La descripción no puede exceder 500 caracteres.";
        }

        // Estado (opcional)
        if ($estado !== '' && mb_strlen($estado) > 15) {
            $error_estado = "El estado no puede exceder 15 caracteres.";
        }

        // Etiquetas (opcional)
        if (!empty($etiquetas_ids)) {
            foreach ($etiquetas_ids as $etiqueta_id) {
                if (!ctype_digit(strval($etiqueta_id))) {
                    $error_etiquetas = "Una o más etiquetas son inválidas.";
                    break;
                }
            }
        }

        // Contactos (opcional)
        if (!empty($contactos_data)) {
            $contactos_validos = 0;
            $tiene_principal = false;
            
            foreach ($contactos_data as $index => $contacto) {
                $tipo = trim($contacto['tipo_contacto'] ?? '');
                $valor = trim($contacto['valor'] ?? '');
                $es_principal = isset($contacto['es_principal']) ? 1 : 0;
                
                // Validar que tenga tipo y valor
                if (!empty($tipo) && !empty($valor)) {
                    $contactos_validos++;
                    if ($es_principal) {
                        $tiene_principal = true;
                    }
                    
                    // Validar formato según tipo
                    if ($tipo === 'email' && !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $error_contactos = "El email no tiene un formato válido.";
                        break;
                    }
                } elseif (!empty($tipo) || !empty($valor)) {
                    $error_contactos = "Todos los campos de contacto deben estar completos.";
                    break;
                }
            }
            
            // Si hay contactos válidos, debe haber al menos uno principal
            if ($contactos_validos > 0 && !$tiene_principal) {
                $error_contactos = "Debe seleccionar al menos un contacto como principal.";
            }
        }

        // Imagen (obligatoria)
        if (!$imagen_file || $imagen_file['error']['imagen'] !== UPLOAD_ERR_OK) {
            $error_imagen = "Debes subir una imagen.";
        }

        // Verificar si hay errores
        $hay_errores = !empty($error_titulo) || !empty($error_direccion) || 
                      !empty($error_superficie) || !empty($error_latitud) || !empty($error_longitud) || 
                      !empty($error_habitaciones) || !empty($error_banos) || !empty($error_precio) || 
                      !empty($error_descripcion) || !empty($error_estado) || !empty($error_imagen) || 
                      !empty($error_etiquetas) || !empty($error_contactos);

        if (!$hay_errores) {
            // Si no hay errores, procesar la imagen y crear la propiedad
            $nombre_imagen = $_FILES['propiedades']['name']['imagen'];
            $ubicacion = __DIR__ . '/../public/img/' . $nombre_imagen;
            move_uploaded_file($_FILES['propiedades']['tmp_name']['imagen'], $ubicacion);
            
            $propiedades = new Propiedad($_POST['propiedades']);
            $propiedades->setImagen($nombre_imagen);
            $resultado = $propiedades->crear();
            
            if($resultado){
                // Guardar contactos si existen
                if (!empty($contactos_data)) {
                    $usuarioId = $_SESSION['id'] ?? 0;
                    
                    foreach ($contactos_data as $contacto) {
                        $tipo = trim($contacto['tipo_contacto'] ?? '');
                        $valor = trim($contacto['valor'] ?? '');
                        $es_principal = isset($contacto['es_principal']) ? 1 : 0;
                        
                        // Solo guardar contactos completos
                        if (!empty($tipo) && !empty($valor)) {
                            $contactoData = [
                                'id_usuario' => $usuarioId,
                                'tipo_contacto' => $tipo,
                                'valor' => $valor,
                                'es_principal' => $es_principal
                            ];
                            
                            $nuevoContacto = new Contacto($contactoData);
                            $nuevoContacto->crear();
                        }
                    }
                }
                
                header('Location: /usuario/mispropiedades');
                exit;
            }
        }
    }

    $router->render('usuario/publicar_propiedad', [
        'propiedades' => $propiedades,
        'etiquetas' => $etiquetas,
        'error_titulo' => $error_titulo,
        'error_direccion' => $error_direccion,
        'error_superficie' => $error_superficie,
        'error_latitud' => $error_latitud,
        'error_longitud' => $error_longitud,
        'error_habitaciones' => $error_habitaciones,
        'error_banos' => $error_banos,
        'error_precio' => $error_precio,
        'error_descripcion' => $error_descripcion,
        'error_estado' => $error_estado,
        'error_imagen' => $error_imagen,
        'error_etiquetas' => $error_etiquetas,
        'error_contactos' => $error_contactos
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