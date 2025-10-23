<?php

namespace Controllers;

use MVC\Router;

class ContactoController
{
    public static function enviar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'errores' => ['Método no permitido']]);
            return;
        }

        $errores = [];
        $datos = [];

        // Validar y sanitizar datos
        if (empty($_POST['nombre']) || strlen(trim($_POST['nombre'])) < 2) {
            $errores[] = 'El nombre es requerido y debe tener al menos 2 caracteres';
        } else {
            $datos['nombre'] = trim($_POST['nombre']);
        }

        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El email es requerido y debe ser válido';
        } else {
            $datos['email'] = trim($_POST['email']);
        }

        if (empty($_POST['mensaje']) || strlen(trim($_POST['mensaje'])) < 10) {
            $errores[] = 'El mensaje es requerido y debe tener al menos 10 caracteres';
        } else {
            $datos['mensaje'] = trim($_POST['mensaje']);
        }

        // Campos opcionales
        $datos['empresa'] = !empty($_POST['empresa']) ? trim($_POST['empresa']) : '';
        $datos['telefono'] = !empty($_POST['telefono']) ? trim($_POST['telefono']) : '';

        if (!empty($errores)) {
            echo json_encode(['success' => false, 'errores' => $errores]);
            return;
        }

        // Guardar lead en archivo de texto (alternativa sin servidor de correo)
        $resultado = self::guardarLead($datos);

        if ($resultado) {
            echo json_encode([
                'success' => true, 
                'mensaje' => '¡Mensaje recibido correctamente! Te contactaremos pronto.',
                'datos' => $datos // Incluir datos para mostrar en consola
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'errores' => ['Error al procesar el mensaje. Inténtalo de nuevo.']
            ]);
        }
    }

    private static function guardarLead($datos)
    {
        try {
            // Crear directorio si no existe
            $directorio = __DIR__ . '/../leads/';
            if (!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }
            
            // Formatear datos para guardar
            $contenido = "=== NUEVO LEAD - " . date('Y-m-d H:i:s') . " ===\n";
            $contenido .= "Nombre: " . $datos['nombre'] . "\n";
            $contenido .= "Email: " . $datos['email'] . "\n";
            
            if (!empty($datos['empresa'])) {
                $contenido .= "Empresa: " . $datos['empresa'] . "\n";
            }
            
            if (!empty($datos['telefono'])) {
                $contenido .= "Teléfono: " . $datos['telefono'] . "\n";
            }
            
            $contenido .= "Mensaje: " . $datos['mensaje'] . "\n";
            $contenido .= "=====================================\n\n";
            
            // Guardar en archivo
            $archivo = $directorio . 'leads_' . date('Y-m') . '.txt';
            $resultado = file_put_contents($archivo, $contenido, FILE_APPEND | LOCK_EX);
            
            // También mostrar en consola del navegador
            error_log("=== NUEVO LEAD ===");
            error_log("Nombre: " . $datos['nombre']);
            error_log("Email: " . $datos['email']);
            if (!empty($datos['empresa'])) {
                error_log("Empresa: " . $datos['empresa']);
            }
            if (!empty($datos['telefono'])) {
                error_log("Teléfono: " . $datos['telefono']);
            }
            error_log("Mensaje: " . $datos['mensaje']);
            error_log("==================");
            
            return $resultado !== false;
            
        } catch (Exception $e) {
            error_log("Error al guardar lead: " . $e->getMessage());
            return false;
        }
    }
}