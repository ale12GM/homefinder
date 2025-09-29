<?php
namespace Controllers;
use MVC\Router;
use Model\Usuario;

class LoginController{
    public static function login(Router $router):void
    {
        $errores = [];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $postData = filter_input_array(INPUT_POST,[
                'email'=> FILTER_SANITIZE_EMAIL,
                'password'=> FILTER_UNSAFE_RAW
            ]) ?? [];

            $auth = new Usuario($postData);
            $errores = $auth->validar();
            if (empty($errores)){
                $resultado = $auth->existeUsuario();
                if(!$resultado){
                    $errores = Usuario::getErrores();
                }else{
                    // Verificar si el usuario está activo antes de comprobar la contraseña
                    $usuario = $resultado->fetch_assoc();
                    if($usuario['estado'] != 1) {
                        $errores[] = "Tu cuenta está desactivada. Contacta al administrador para más información.";
                    } else {
                        // Resetear el puntero del resultado para que funcione con comprobarPassword
                        $resultado->data_seek(0);
                        $auth->comprobarPassword($resultado);
                        if($auth->autenticado ?? false){
                            $auth->obtenerId();
                            $auth->autenticar();
                            return;
                        } else {
                            $errores = Usuario::getErrores();
                        }
                    }
                }
            }

        }
        $router->render('auth/login',[
            'errores' => $errores
        ]);
    }
}

?>