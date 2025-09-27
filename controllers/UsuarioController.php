<?php
namespace Controllers;
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

        $usuarios = Usuario::listar();
        $router->render('admin/home',[
            'usuarios' => $usuarios
        ]);
    }

    public static function Gestion(Router $router){
        $usuarios = Usuario::listar();
        $router->render('usuario/admin_usuarios', [
            'usuarios' => $usuarios
        ]);
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
        } 
        if (empty(trim($confirmar))) {
            $errores['confirmar'] = "Debe confirmar la contraseña";
        } elseif ($password !== $confirmar) {
            $errores['confirmar'] = "Las contraseñas no coinciden";
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
}

?>