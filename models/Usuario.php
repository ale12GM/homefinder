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

    public static function listarEmail(){
        $query = "SELECT id, email FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        $usuarios =[];
        if($resultado){
            $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);

        }
        return $usuarios;
    }
}

?>