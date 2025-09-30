<?php
namespace Controllers;

use Model\Propiedad;
use Model\Usuario;
use MVC\Router;
class UsuarioController{
    public static function Index(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('auth/login',[
            'usuarios' => $usuarios
        ]);
    }
    public static function Home(Router $router){
    
        $usuarios = Usuario::listar();
        $router->render('usuario/home',[
            'usuarios' => $usuarios
        ]);
    }
    public static function AdminHome(Router $router){
        $propiedades = Propiedad::listar();
        $ultimosusuarios = Usuario::ultimos(2);

        $usuarios = Usuario::listar();
        $router->render('admin/home',[
            'usuarios' => $usuarios,
            'propiedades' => $propiedades,
            'ultimosUsuarios' => $ultimosusuarios
        ]);
    }

    public static function Gestion(Router $router){
        $usuarios = Usuario::listar();
        $router->render('admin/gestion_de_usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    // dentro de class UsuarioController { ... }

    public static function Obtener() {
        header('Content-Type: application/json; charset=utf-8');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'id requerido']);
            exit;
        }

        $usuario = Usuario::obtener($id);

        if ($usuario) {
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        }
        exit;
    }


    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function Crear(Router $router){
        $Usuario = new Usuario();
        $errores = [
            'nombre' => '',
            'apellido' => '',
            'email' => '',
            'password' => '',
            'confirmar' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        
        $nombre    = $_POST['usuarios']['nombre'] ?? '';
        $apellido  = $_POST['usuarios']['apellido'] ?? '';
        $email     = $_POST['usuarios']['email'] ?? '';
        $password  = $_POST['usuarios']['password'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';

        if (empty(trim($nombre))) {
            $errores['nombre'] = "El nombre es obligatorio";
        }
        if (empty(trim($apellido))) {
            $errores['apellido'] = "El apellido es obligatorio";
        }
        if (empty(trim($email))) {
            $errores['email'] = "El email es obligatorio";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El formato del email no es válido";
        }
        if (empty(trim($password))) {
            $errores['password'] = "La contraseña es obligatoria";
        } else {
            // Validar contraseña según normativas de la base de datos
            $erroresPassword = Usuario::validarPassword($password, $confirmar);
            if (!empty($erroresPassword)) {
                // Si hay múltiples errores, mostrar el primero en el campo password
                $errores['password'] = $erroresPassword[0];
                // Si hay error de confirmación, mostrarlo en el campo confirmar
                foreach ($erroresPassword as $error) {
                    if (strpos($error, 'coinciden') !== false) {
                        $errores['confirmar'] = $error;
                        break;
                    }
                }
            }
        }
        
        if (empty(trim($confirmar))) {
            $errores['confirmar'] = "Debe confirmar la contraseña";
        }

        $sinErrores = true;
        foreach($errores as $campo => $mensaje){
            if(!empty($mensaje)){
                $sinErrores = false;
                break;
            }
        }
        if ($sinErrores) {
            $Usuario = new Usuario($_POST['usuarios']);
            $Usuario->password = self::hashPassword($Usuario->password);

            $resultado = $Usuario->crear();

            if ($resultado) {
                header("Location: /login");
                exit;
            } else {
                $errores['general'] = "Hubo un problema al registrar el usuario";
            }
        }
    }

    $router->render('auth/singUP', [
        'usuarios'=> $Usuario,
        'errores' => $errores
    ]);
    
    
}








public static function EditarUsuario(Router $router) {
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Solo si es POST se actualiza (AJAX o formulario)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: /admin/gestion_de_usuarios?error=id_requerido');
            exit;
        }

        $usuario = Usuario::find($id);
        if (!$usuario) {
            header('Location: /admin/gestion_de_usuarios?error=no_encontrado');
            exit;
        }

        // Actualizamos campos
        $usuario->nombre = $_POST['nombre'] ?? $usuario->nombre;
        $usuario->apellido = $_POST['apellido'] ?? $usuario->apellido;
        $usuario->email = $_POST['email'] ?? $usuario->email;

        // Si envía nueva contraseña
        if (!empty($_POST['password'])) {
            $usuario->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $resultado = $usuario->actualizar($id);

        header('Location: /admin/gestion_de_usuarios?mensaje=' . ($resultado ? 'actualizado' : 'error'));
        exit;
    }   

    // Si llega por GET (por ejemplo si abres una página aparte)
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: /admin/gestion_de_usuarios?error=id_requerido');
        exit;
    }

    $usuarioData = Usuario::obtener($id);
    if (!$usuarioData) {
        header('Location: /admin/gestion_de_usuarios?error=no_encontrado');
        exit;
    }

    $usuario = new Usuario($usuarioData);

    // Renderizar una vista (solo si la usas aparte)
    $router->render('admin/editar_usuario', [
        'usuario' => $usuario
    ]);
}











public static function actualizarPerfil() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success'=>false,'message'=>'Método no permitido']);
        exit;
    }

    $id = $_POST['id'] ?? null;
    if (!$id) {
        echo json_encode(['success'=>false,'message'=>'ID requerido']);
        exit;
    }

    $usuario = Usuario::find($id);
    if (!$usuario) {
        echo json_encode(['success'=>false,'message'=>'Usuario no encontrado']);
        exit;
    }

    // Validar campos básicos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($nombre)) {
        echo json_encode(['success'=>false,'message'=>'El nombre es obligatorio']);
        exit;
    }

    if (empty($apellido)) {
        echo json_encode(['success'=>false,'message'=>'El apellido es obligatorio']);
        exit;
    }

    if (empty($email)) {
        echo json_encode(['success'=>false,'message'=>'El email es obligatorio']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success'=>false,'message'=>'El formato del email no es válido']);
        exit;
    }

    // Verificar si el email ya existe en otro usuario
    $usuariosExistentes = Usuario::where('email', $email);
    if (!empty($usuariosExistentes)) {
        foreach ($usuariosExistentes as $usuarioExistente) {
            if ($usuarioExistente['id'] != $id) {
                echo json_encode(['success'=>false,'message'=>'Este email ya está registrado por otro usuario']);
                exit;
            }
        }
    }

    // Actualizar campos básicos
    $usuario->nombre = $nombre;
    $usuario->apellido = $apellido;
    $usuario->email = $email;

    // Cambio de contraseña
    $actual = $_POST['actual'] ?? '';
    $nueva = $_POST['nueva'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($nueva) {
        // Validar que se ingresó la contraseña actual
        if (empty($actual)) {
            echo json_encode(['success'=>false,'message'=>'Debes ingresar tu contraseña actual para cambiarla']);
            exit;
        }

        // Verificar contraseña actual
        $usuarioActual = Usuario::where('id', $id);
        if (empty($usuarioActual) || !password_verify($actual, $usuarioActual[0]['password'])) {
            echo json_encode(['success'=>false,'message'=>'La contraseña actual es incorrecta']);
            exit;
        }

        // Validar nueva contraseña
        if (strlen($nueva) < 6) {
            echo json_encode(['success'=>false,'message'=>'La nueva contraseña debe tener al menos 6 caracteres']);
            exit;
        }

        if ($nueva !== $confirmar) {
            echo json_encode(['success'=>false,'message'=>'Las contraseñas nuevas no coinciden']);
            exit;
        }

        $usuario->password = password_hash($nueva, PASSWORD_DEFAULT);
    }

    $resultado = $usuario->actualizar($id);
    
    if ($resultado) {
        echo json_encode(['success'=>true,'message'=>'Perfil actualizado correctamente']);
    } else {
        echo json_encode(['success'=>false,'message'=>'Error al actualizar el perfil']);
    }
    exit;
}

public static function bloquearUsuario() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header('Location: /admin/gestion_de_usuarios?error=metodo_no_permitido');
        exit;
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: /admin/gestion_de_usuarios?error=id_requerido');
        exit;
    }

    $usuario = Usuario::find($id);
    if (!$usuario) {
        header('Location: /admin/gestion_de_usuarios?error=usuario_no_encontrado');
        exit;
    }

    // Cambiar el estado: si está activo (1) lo bloqueamos (0), si está bloqueado (0) lo activamos (1)
    $nuevoEstado = $usuario->estado == 1 ? 0 : 1;
    $usuario->estado = $nuevoEstado;

    $resultado = $usuario->actualizar($id);
    
    if ($resultado) {
        $mensaje = $nuevoEstado == 1 ? 'usuario_activado' : 'usuario_bloqueado';
        header("Location: /admin/gestion_de_usuarios?mensaje={$mensaje}");
    } else {
        header('Location: /admin/gestion_de_usuarios?error=error_actualizacion');
    }
    exit;
}

}

?>