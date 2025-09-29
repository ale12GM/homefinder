<?php

namespace Model;
use Model\Rol;
use Model\NormativaContrasenia;


class Usuario extends ActivaModelo {
    protected static $tabla = 'usuarios';
    protected static $columnDB = ['id','nombre','apellido','email','password','fecha_registro', 'estado', 'intentos_login', 'ultimo_intento'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $autenticado=false;
    public $estado;
    public $intentos_login;
    public $ultimo_intento;
    protected static $errores=[];

    public function __construct($args = []) {
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->password = $args['password'] ?? null;
        $this->estado = $args['estado'] ?? null;
        $this->intentos_login = $args['intentos_login'] ?? 0;
        $this->ultimo_intento = $args['ultimo_intento'] ?? null;
    }
    public function validar(){
        if(!$this->email){
            self::$errores[] = 'El email del usuario es obligatorio';
        }
        if(!$this->password){
            self::$errores[] = 'El password del usuario es obligatorio';
        }
        return self::$errores;
    }
    public function existeUsuario()
    {
        $query = "Select * from ".self::$tabla." Where email = '" . $this->email . "' Limit 1";
        $resultado = self::$db->query($query);
        if(!$resultado->num_rows)
        {
            self::$errores[]="El Usuario no existe";
            AuditoriaApp::registrarLogin(
                $this->email ?? 'desconocido', // El email que se intentó usar
                false,
                'Intento de Login (Usuario no encontrado)'
            );
            
            return;
        }
        return $resultado;
    }
    public function comprobarPassword($resultado): bool
    {
        $usuario = $resultado->fetch_object();

        // Validamos si el usuario existe y tiene contraseña (esto ya lo haria existeUsuario)
        // Pero lo mantenemos para ser robustos si se llama a este método directamente
        if (!$usuario || !isset($usuario->password)) {
            self::$errores[] = "Usuario inválido o sin contraseña";
            // Registrar intento de login fallido (si se llega aquí por alguna razón sin usuario válido)
            AuditoriaApp::registrarLogin(
                $this->email ?? 'desconocido',
                false,
                'Intento de Login (Problema interno al obtener usuario)'
            );
            return false;
        }

        if (password_verify($this->password, $usuario->password)) {
            $this->autenticado = true;
            // Registrar login exitoso
            AuditoriaApp::registrarLogin(
                $usuario->email,
                true,
                'Login'
            );
        } else {
            $this->autenticado = false;
            self::$errores[] = "El password es incorrecto";
            // Registrar login fallido (contraseña incorrecta)
            AuditoriaApp::registrarLogin(
                $this->email, // Email del usuario que intentó loguearse
                false,
                'Intento de Login (Contraseña incorrecta)'
            );
        }
        
        return $this->autenticado;
    }



    
    public function obtenerId()
{
    $query = "SELECT id FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
    $resultado = self::$db->query($query);

    if($resultado && $resultado->num_rows > 0){
        $usuario = $resultado->fetch_object();
        $this->id = $usuario->id; // Guardamos el id en la propiedad del objeto
        return $this->id;
    } else {
        self::$errores[] = "No se pudo obtener el ID del usuario";
        return null;
    }
}
    public function autenticar()
{
    // Inicia la sesión si no está activa
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Datos básicos de sesión
    $_SESSION['usuario'] = $this->email;
    $_SESSION['login']   = true;
    $_SESSION['id']      = $this->id;

    // Roles del usuario
    $_SESSION['roles'] = $this->obtenerRoles();

    // Permisos del usuario
    $_SESSION['permisos'] = $this->obtenerPermisos();
    
    // Redirección final (se elimina temporalmente para depuración)
    header('Location: /usuario/home');
    exit;
}

public function obtenerPermisos(): array {
    $idUsuario = $this->id;
    $permisos = [];

    $query = "SELECT p.nombre
              FROM permisos p
              INNER JOIN rolpermiso rp ON p.id = rp.id_permiso
              INNER JOIN usuariorol ur ON rp.id_rol = ur.id_rol
              WHERE ur.id_usuario = $idUsuario";

    $resultado = self::$db->query($query);
    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $permisos[] = $row['nombre'];
        }
    }

    return $permisos; // ej: ['ver_propiedad_propia', 'editar_propiedad_propia']
}

    public static function getErrores()
    {
        return static::$errores;
    }

    public function obtenerRoles(): array {
    $roles = [];
    $idUsuario = $this->id;

    $query = "SELECT r.nombre 
              FROM roles r
              INNER JOIN usuariorol ur ON r.id = ur.id_rol
              WHERE ur.id_usuario = $idUsuario";

    $resultado = self::$db->query($query);
    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $roles[] = $row['nombre'];
        }
    }

    return $roles; // ej: ['usuario', 'admin']
}

    /**
     * Valida la contraseña según las normativas de la base de datos
     * @param string $password
     * @param string $confirmar
     * @return array Array de errores, vacío si no hay errores
     */
    public static function validarPassword($password, $confirmar = null): array {
        $errores = [];
        
        // Obtener la normativa activa
        $normativa = NormativaContrasenia::obtenerNormativaActiva();
        
        if (!$normativa) {
            $errores[] = "No se encontró normativa de contraseña activa";
            return $errores;
        }
        
        // Validar longitud mínima
        if ($normativa->longitud_minima && strlen($password) < $normativa->longitud_minima) {
            $errores[] = "La contraseña debe tener al menos {$normativa->longitud_minima} caracteres";
        }
        
        // Validar longitud máxima
        if ($normativa->longitud_maxima && strlen($password) > $normativa->longitud_maxima) {
            $errores[] = "La contraseña no puede tener más de {$normativa->longitud_maxima} caracteres";
        }
        
        // Validar mayúsculas
        if ($normativa->requiere_mayusculas && !preg_match('/[A-Z]/', $password)) {
            $errores[] = "La contraseña debe contener al menos una letra mayúscula";
        }
        
        // Validar minúsculas
        if ($normativa->requiere_minusculas && !preg_match('/[a-z]/', $password)) {
            $errores[] = "La contraseña debe contener al menos una letra minúscula";
        }
        
        // Validar números
        if ($normativa->requiere_numeros && !preg_match('/[0-9]/', $password)) {
            $errores[] = "La contraseña debe contener al menos un número";
        }
        
        // Validar símbolos
        if ($normativa->requiere_simbolos) {
            $simbolos = preg_match_all('/[^a-zA-Z0-9]/', $password);
            if ($simbolos == 0) {
                $errores[] = "La contraseña debe contener al menos un símbolo";
            } elseif ($normativa->cantidad_simbolos && $simbolos < $normativa->cantidad_simbolos) {
                $errores[] = "La contraseña debe contener al menos {$normativa->cantidad_simbolos} símbolos";
            }
        }
        
        // Validar confirmación de contraseña
        if ($confirmar !== null && $password !== $confirmar) {
            $errores[] = "Las contraseñas no coinciden";
        }
        
        return $errores;
    }

    /**
     * Verifica si la cuenta está bloqueada por intentos fallidos
     * @param string $email
     * @return array ['bloqueada' => bool, 'tiempo_restante' => int, 'mensaje' => string]
     */
    public static function verificarBloqueo($email): array {
        $query = "SELECT intentos_login, ultimo_intento FROM " . self::$tabla . " WHERE email = '" . $email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        // Debug: Log para verificar consulta
        error_log("Verificando bloqueo para: " . $email);
        error_log("Query: " . $query);
        
        if (!$resultado || $resultado->num_rows == 0) {
            error_log("Usuario no encontrado o sin resultado");
            return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
        }
        
        $usuario = $resultado->fetch_object();
        $intentos = $usuario->intentos_login ?? 0;
        $ultimoIntento = $usuario->ultimo_intento;
        
        error_log("Intentos actuales: " . $intentos);
        error_log("Último intento: " . $ultimoIntento);
        
        // Obtener normativa para saber el máximo de intentos
        $normativa = NormativaContrasenia::obtenerNormativaActiva();
        $maxIntentos = $normativa ? $normativa->intentos_maximos : 3; // Default 3 si no hay normativa
        
        error_log("Máximo de intentos permitidos: " . $maxIntentos);
        
        if ($intentos >= $maxIntentos && $ultimoIntento) {
            $tiempoBloqueo = 5 * 60; // 5 minutos en segundos
            $tiempoTranscurrido = time() - strtotime($ultimoIntento);
            $tiempoRestante = $tiempoBloqueo - $tiempoTranscurrido;
            
            error_log("Tiempo transcurrido: " . $tiempoTranscurrido . " segundos");
            error_log("Tiempo restante: " . $tiempoRestante . " segundos");
            
            if ($tiempoRestante > 0) {
                $minutos = ceil($tiempoRestante / 60);
                return [
                    'bloqueada' => true,
                    'tiempo_restante' => $tiempoRestante,
                    'mensaje' => "Cuenta bloqueada por {$intentos} intentos fallidos. Intenta nuevamente en {$minutos} minutos."
                ];
            } else {
                // El bloqueo expiró, resetear intentos
                error_log("Bloqueo expirado, reseteando intentos");
                self::resetearIntentos($email);
                return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
            }
        }
        
        return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
    }

    /**
     * Incrementa el contador de intentos fallidos
     * @param string $email
     * @return bool
     */
    public static function incrementarIntentos($email): bool {
        $query = "UPDATE " . self::$tabla . " 
                  SET intentos_login = intentos_login + 1, 
                      ultimo_intento = NOW() 
                  WHERE email = '" . $email . "'";
        
        $resultado = self::$db->query($query);
        
        // Debug: Log para verificar si se ejecuta
        error_log("Incrementando intentos para: " . $email);
        error_log("Query: " . $query);
        error_log("Resultado: " . ($resultado ? 'true' : 'false'));
        if (self::$db->error) {
            error_log("Error SQL: " . self::$db->error);
        }
        
        return $resultado;
    }

    /**
     * Resetea el contador de intentos fallidos
     * @param string $email
     * @return bool
     */
    public static function resetearIntentos($email): bool {
        $query = "UPDATE " . self::$tabla . " 
                  SET intentos_login = 0, 
                      ultimo_intento = NULL 
                  WHERE email = '" . $email . "'";
        
        return self::$db->query($query);
    }

    /**
     * Establece una cookie de bloqueo por 5 minutos
     * @param string $email
     * @return void
     */
    public static function establecerCookieBloqueo($email): void {
        $tiempoBloqueo = 5 * 60; // 5 minutos
        $valor = base64_encode($email . '|' . time());
        setcookie('bloqueo_login', $valor, time() + $tiempoBloqueo, '/', '', false, true);
    }

    /**
     * Verifica si existe una cookie de bloqueo válida
     * @param string $email
     * @return array ['bloqueada' => bool, 'tiempo_restante' => int, 'mensaje' => string]
     */
    public static function verificarCookieBloqueo($email): array {
        if (!isset($_COOKIE['bloqueo_login'])) {
            return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
        }
        
        $valor = base64_decode($_COOKIE['bloqueo_login']);
        $partes = explode('|', $valor);
        
        if (count($partes) !== 2 || $partes[0] !== $email) {
            return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
        }
        
        $tiempoBloqueo = 5 * 60; // 5 minutos
        $tiempoTranscurrido = time() - intval($partes[1]);
        $tiempoRestante = $tiempoBloqueo - $tiempoTranscurrido;
        
        if ($tiempoRestante > 0) {
            $minutos = ceil($tiempoRestante / 60);
            return [
                'bloqueada' => true,
                'tiempo_restante' => $tiempoRestante,
                'mensaje' => "Cuenta bloqueada temporalmente. Intenta nuevamente en {$minutos} minutos."
            ];
        } else {
            // La cookie expiró, eliminarla
            setcookie('bloqueo_login', '', time() - 3600, '/');
            return ['bloqueada' => false, 'tiempo_restante' => 0, 'mensaje' => ''];
        }
    }

    /**
     * Obtiene los últimos usuarios registrados
     * @param int $limite
     * @return array
     */
    public static function ultimos($limite = 5): array {
        $query = "SELECT * FROM " . self::$tabla . " ORDER BY fecha_registro DESC LIMIT " . intval($limite);
        $resultado = self::$db->query($query);
        
        $usuarios = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $usuarios[] = new self($row);
            }
        }
        
        return $usuarios;
    }


}

?>