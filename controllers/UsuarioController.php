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
    public static function Actualizar() {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (!$id || $nombre === '' || $apellido === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        $usuario = new Usuario([
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ]);

        $resultado = $usuario->actualizar($id);

        echo json_encode([
            'success' => $resultado ? true : false,
            'message' => $resultado ? 'Usuario actualizado' : 'No se pudo actualizar'
        ]);
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

        public static function RestablecerContrasena(Router $router) {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';
            $id       = $_POST['id'] ?? null; // podrías pasarlo por hidden input

            if (empty($password) || empty($confirm)) {
                $errores[] = "Todos los campos son obligatorios";
            } else {
                // Validar contraseña según normativas de la base de datos
                $erroresPassword = Usuario::validarPassword($password, $confirm);
                if (!empty($erroresPassword)) {
                    $errores = array_merge($errores, $erroresPassword);
                }
            }

            if (empty($errores) && $id) {
                $usuario = new Usuario([
                    'id' => $id,
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ]);

                $resultado = $usuario->actualizar($id);

                if ($resultado) {
                    header("Location: /login?msg=restablecido");
                    exit;
                } else {
                    $errores[] = "No se pudo actualizar la contraseña";
                }
            }
        }

        $router->render('auth/restablecer', [
            'errores' => $errores
        ]);
    }

}

?>