<?php
namespace Controllers;
use Model\Propiedad;
use MVC\Router;
use Model\Etiqueta;
use Model\Contacto;
use Model\Contactos;
class PropiedadController{
    public static function IndexPropiedad(Router $router){
    // Obtener todas las propiedades
    $propiedades = Propiedad::listar();

    // Filtrar solo las activas
    $propiedadesActivas = array_filter($propiedades, function($p){
        return isset($p['estado']) && $p['estado'] === 'activo';
    });

    // Procesar filtros de búsqueda
    $filtros = [];
    $buscar = $_GET['buscar'] ?? '';
    $precio_min = $_GET['precio_min'] ?? '';
    $precio_max = $_GET['precio_max'] ?? '';
    $habitaciones = $_GET['habitaciones'] ?? '';

    // Aplicar filtros si existen
    if (!empty($buscar) || !empty($precio_min) || !empty($precio_max) || !empty($habitaciones)) {
        $propiedadesFiltradas = array_filter($propiedadesActivas, function($propiedad) use ($buscar, $precio_min, $precio_max, $habitaciones) {
            $cumpleFiltros = true;

            // Filtro de búsqueda por texto
            if (!empty($buscar)) {
                $buscarLower = strtolower($buscar);
                $cumpleFiltros = $cumpleFiltros && (
                    stripos($propiedad['titulo'] ?? '', $buscar) !== false ||
                    stripos($propiedad['direccion'] ?? '', $buscar) !== false ||
                    stripos($propiedad['descripcion'] ?? '', $buscar) !== false
                );
            }

            // Filtro de precio mínimo
            if (!empty($precio_min) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (float)$propiedad['precio'] >= (float)$precio_min;
            }

            // Filtro de precio máximo
            if (!empty($precio_max) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (float)$propiedad['precio'] <= (float)$precio_max;
            }

            // Filtro de habitaciones
            if (!empty($habitaciones) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (int)$propiedad['num_habitaciones'] >= (int)$habitaciones;
            }

            return $cumpleFiltros;
        });

        $propiedadesActivas = $propiedadesFiltradas;
        $filtros = [
            'buscar' => $buscar,
            'precio_min' => $precio_min,
            'precio_max' => $precio_max,
            'habitaciones' => $habitaciones
        ];
    }

    $router->render('usuario/venta', [
        'propiedades' => $propiedadesActivas,
        'filtros' => $filtros
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

    // Procesar filtros de búsqueda
    $filtros = [];
    $buscar = $_GET['buscar'] ?? '';
    $precio_min = $_GET['precio_min'] ?? '';
    $precio_max = $_GET['precio_max'] ?? '';
    $habitaciones = $_GET['habitaciones'] ?? '';
    $estado = $_GET['estado'] ?? '';

    // Aplicar filtros si existen
    if (!empty($buscar) || !empty($precio_min) || !empty($precio_max) || !empty($habitaciones) || !empty($estado)) {
        $propiedadesFiltradas = array_filter($propiedades, function($propiedad) use ($buscar, $precio_min, $precio_max, $habitaciones, $estado) {
            $cumpleFiltros = true;

            // Filtro de búsqueda por texto
            if (!empty($buscar)) {
                $buscarLower = strtolower($buscar);
                $cumpleFiltros = $cumpleFiltros && (
                    stripos($propiedad['titulo'] ?? '', $buscar) !== false ||
                    stripos($propiedad['direccion'] ?? '', $buscar) !== false ||
                    stripos($propiedad['descripcion'] ?? '', $buscar) !== false
                );
            }

            // Filtro de precio mínimo
            if (!empty($precio_min) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (float)$propiedad['precio'] >= (float)$precio_min;
            }

            // Filtro de precio máximo
            if (!empty($precio_max) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (float)$propiedad['precio'] <= (float)$precio_max;
            }

            // Filtro de habitaciones
            if (!empty($habitaciones) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && (int)$propiedad['num_habitaciones'] >= (int)$habitaciones;
            }

            // Filtro de estado
            if (!empty($estado) && $cumpleFiltros) {
                $cumpleFiltros = $cumpleFiltros && ($propiedad['estado'] ?? '') === $estado;
            }

            return $cumpleFiltros;
        });

        $propiedades = $propiedadesFiltradas;
        $filtros = [
            'buscar' => $buscar,
            'precio_min' => $precio_min,
            'precio_max' => $precio_max,
            'habitaciones' => $habitaciones,
            'estado' => $estado
        ];
    }

    $router->render('admin/gestion_de_propiedades',[
        'propiedades'=> $propiedades,
        'permisos' => $permisosUsuario,
        'filtros' => $filtros
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
    
    // Inicializar array de errores
    $errores = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Obtener datos del formulario
        $datos_propiedad = $_POST['propiedades'] ?? [];
        $etiquetas_ids = $_POST['etiquetas'] ?? [];
        $contactos_data = $_POST['contactos'] ?? [];
        $imagen_file = $_FILES['propiedades'] ?? null;

        // Validar datos usando el modelo
        $errores = Propiedad::validarDatos($datos_propiedad, $contactos_data, $imagen_file);
        
        // Validar etiquetas (opcional)
        if (!empty($etiquetas_ids)) {
            foreach ($etiquetas_ids as $etiqueta_id) {
                if (!ctype_digit(strval($etiqueta_id))) {
                    $errores['etiquetas'] = "Una o más etiquetas son inválidas.";
                    break;
                }
            }
        }

        // Verificar si hay errores
        $hay_errores = !empty($errores);

        if (!$hay_errores) {
            // Formatear datos usando el modelo
            $datos_formateados = Propiedad::formatearDatos($datos_propiedad);
            
            // Si no hay errores, procesar la imagen y crear la propiedad
            $nombre_imagen = $_FILES['propiedades']['name']['imagen'];
            $ubicacion = __DIR__ . '/../public/img/' . $nombre_imagen;
            move_uploaded_file($_FILES['propiedades']['tmp_name']['imagen'], $ubicacion);
            
            $propiedades = new Propiedad($datos_formateados);
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
        'errores' => $errores ?? []
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

}

?>