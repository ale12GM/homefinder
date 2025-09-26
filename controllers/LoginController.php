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
        $router->render('auth/login',[
            'errores' => $errores
        ]);
    }
}

?>