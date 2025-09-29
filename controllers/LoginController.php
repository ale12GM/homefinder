<?php
namespace Controllers;

use MVC\Router;
use Model\Usuario;
// No es necesario 'use Model\AuditoriaApp;' aquí,
// ya que la clase Usuario es la que interactúa directamente con AuditoriaApp.

class LoginController{
    public static function login(Router $router): void
    {
        $errores = [];
        $email_intentado = ''; // Para guardar el email si el formulario lo envía

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            // Sanitizamos los datos del POST.
            $postData = filter_input_array(INPUT_POST,[
                'email'=> FILTER_SANITIZE_EMAIL,
                'password'=> FILTER_UNSAFE_RAW // password_verify manejará la seguridad de la contraseña
            ]) ?? [];

            $email_intentado = $postData['email'] ?? ''; // Guardamos el email para los errores y auditoría

            // Si no hay bloqueos, continuar con la validación normal
            if (empty($errores)) {
                $auth = new Usuario($postData); // Creamos un objeto Usuario con los datos enviados

                // 1. Validar que los campos email y password no estén vacíos.
                $errores = $auth->validar();
            }

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
            'errores' => $errores,
            'email' => $email_intentado // Para pre-llenar el campo email si hubo un error
        ]);
    }
}