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

            $auth = new Usuario($postData); // Creamos un objeto Usuario con los datos enviados

            // 1. Validar que los campos email y password no estén vacíos.
            $errores = $auth->validar();

            if (empty($errores)){
                // 2. Si no hay errores de campos vacíos, verificar si el usuario existe.
                $resultadoExisteUsuario = $auth->existeUsuario();

                if(!$resultadoExisteUsuario){
                    // El método existeUsuario() ya se encarga de registrar el fallo en AuditoriaApp
                    // si el usuario no es encontrado.
                    $errores = Usuario::getErrores(); // Obtenemos el mensaje de error "El Usuario no existe"
                } else {
                    // 3. El usuario existe, ahora verificamos la contraseña.
                    // El método comprobarPassword() ya se encarga de registrar el evento en AuditoriaApp
                    // ya sea éxito o fallo de la contraseña.
                    $autenticado = $auth->comprobarPassword($resultadoExisteUsuario);

                    if($autenticado){
                        // 4. Login exitoso: Obtener el ID del usuario y autenticar la sesión.
                        $auth->obtenerId(); // Esto es para obtener el 'id' y guardarlo en $auth->id
                        $auth->autenticar(); // Inicia la sesión y redirige
                        return; // Se detiene la ejecución después de la redirección.
                    } else {
                        // 5. Login fallido (contraseña incorrecta).
                        // El método comprobarPassword() ya registró este fallo en AuditoriaApp.
                        $errores = Usuario::getErrores(); // Obtenemos el mensaje de error "El password es incorrecto"
                    }
                }
            }
        }
        
        // Renderizar la vista del formulario de login.
        // Si el método es GET, o si hubo errores en el POST, se muestra el formulario con los errores.
        $router->render('auth/login',[
            'errores' => $errores,
            'email' => $email_intentado // Para pre-llenar el campo email si hubo un error
        ]);
    }
}