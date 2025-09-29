<?php
namespace Controllers;
use Model\Rol;
use Model\Usuario;
use MVC\Router;

class RolController {
    public static function Gestion(Router $router) {
        // CAMBIO CLAVE: Usar la nueva función que incluye el conteo
        $roles = \Model\Rol::listarConteoUsuarios(); 
                                
        $router->render('/admin/gestion_de_roles', [
            'roles' => $roles
        ]);
    }

    // En RolController.php


    public static function asignarRolAPI() {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            http_response_code(405);
            echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
            return;
        }
        
        $idUsuario = filter_var($_POST['id_usuario'] ?? null, FILTER_VALIDATE_INT);
        $idRol = filter_var($_POST['id_rol'] ?? null, FILTER_VALIDATE_INT);
        // Acción ahora puede ser 'añadir' o 'quitar'
        // Opción 1: Reemplazo recomendado para saneamiento general de cadenas
        $accion = filter_var($_POST['accion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$idUsuario || !$idRol || !in_array($accion, ['añadir', 'quitar'])) {
            header('Content-Type: application/json');
            http_response_code(400); 
            echo json_encode(['success' => false, 'mensaje' => 'Datos inválidos.']);
            return;
        }

        // Llamar a la lógica del Modelo para gestionar el rol
        $resultado = Rol::gestionarRol($idUsuario, $idRol, $accion);
        
        header('Content-Type: application/json');
        if ($resultado) {
            if ($accion === 'añadir') {
                $mensaje = "Usuario asignado al nuevo rol correctamente.";
            } else {
                $mensaje = "Rol quitado. Usuario degradado al Rol Base (ID 2).";
            }
            echo json_encode(['success' => true, 'mensaje' => $mensaje, 'accion_realizada' => $accion]);
        } else {
            http_response_code(500); 
            echo json_encode(['success' => false, 'mensaje' => 'Error en la base de datos al gestionar el rol.']);
        }
    }

    public static function CrearRol(Router $router){
        $roles = new Rol();
        $alertas = [
            'nombre' => '',
            'descripcion' => ''
        ];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $datos_rol=$_POST['roles'];
            $roles = new Rol($datos_rol);
            $alertas=$roles->validar();
            
            if(empty($alertas)){
                $resultado = $roles->crear();
                if($resultado){
                    header('Location: /admin/roles');
                    exit;
                }
            }

        }
        $router->render('/admin/addRol', [ // ruta de donde esta la vista
            'rol' => $roles, 
            'alertas' => $alertas
        ]);
        
    }

    public static function editarRol(Router $router){
        $id_rol = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if(!$id_rol){
            header('Location: /admin/roles');
            exit;
        }
        
        // Obtener conexión a la base de datos
        require_once __DIR__ . '/../includes/app.php';
        $db = conectarDB();
        
        // Obtener el rol por ID
        $rol_data = Rol::obtener($id_rol);
        if(!$rol_data){
            header('Location: /admin/roles');
            exit;
        }
        $rol = new Rol($rol_data);
        
        $alertas = [
            'nombre' => '',
            'descripcion' => ''
        ];
        
        // Obtener todos los permisos disponibles
        $permisos = \Model\Permiso::listar();
        
        // Obtener permisos ya asignados al rol
        $permisos_asignados = [];
        $query = "SELECT id_permiso FROM rolpermiso WHERE id_rol = " . $db->escape_string($id_rol);
        $resultado = $db->query($query);
        if($resultado){
            $permisos_asignados = array_column($resultado->fetch_all(MYSQLI_ASSOC), 'id_permiso');
        }
        
        // Marcar permisos como asignados
        foreach($permisos as &$permiso){
            $permiso['asignado'] = in_array($permiso['id'], $permisos_asignados);
        }
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $datos_rol = $_POST['roles'];
            $rol->nombre = $datos_rol['nombre'];
            $rol->descripcion = $datos_rol['descripcion'];
            $alertas = $rol->validar();
            
            if(empty($alertas)){
                $resultado = $rol->actualizar($id_rol);
                if($resultado){
                    // Eliminar permisos existentes
                    $query = "DELETE FROM rolpermiso WHERE id_rol = " . $db->escape_string($id_rol);
                    $db->query($query);
                    
                    // Agregar nuevos permisos seleccionados
                    if(isset($_POST['permisos']) && is_array($_POST['permisos'])){
                        foreach($_POST['permisos'] as $id_permiso){
                            $rolPermiso = new \Model\RolPermiso([
                                'id_rol' => $id_rol,
                                'id_permiso' => $id_permiso
                            ]);
                            $rolPermiso->crear();
                        }
                    }
                    
                    header('Location: /admin/roles');
                    exit;
                }
            }
        }
        
        $router->render('admin/editarRol', [
            'rol' => $rol,
            'alertas' => $alertas,
            'permisos' => $permisos
        ]);
    }

    public static function asignarUsuarios(Router $router){
        $id_rol = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if(!$id_rol){
            header('Location: /admin/gestion_de_roles');
            exit;
        }
        $usuarios_disponibles=Usuario::listarEmail();
        $usuarios_asignados = Rol::obtenerUsuariosAsignados($id_rol);

        $usuarios_con_estado=[];
        $ids_asignados = array_column($usuarios_asignados, 'id_usuario');

        foreach($usuarios_disponibles as $usuario){
            $usuario['asignado'] = in_array($usuario['id'], $ids_asignados);
            $usuarios_con_estado[]=$usuario;
        }
        $router->render('admin/addUsuarioRol', [
            'id_rol'=> $id_rol,
            'usuarios'=>$usuarios_con_estado//asignado o no, true o false
        ]);
    }

    

}