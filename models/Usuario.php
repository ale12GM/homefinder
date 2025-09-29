<?php

namespace Model;

class Usuario extends ActivaModelo {
    protected static $tabla = 'usuarios';
    protected static $columnDB = ['id','nombre','apellido','email','password','fecha_registro', 'estado'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $autenticado=false;
    public $estado;
    protected static $errores=[];

    public function __construct($args = []) {
        $this->id = $args['id']??null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->password = $args['password'] ?? null;
        $this->estado = $args['estado'] ?? null;
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
            
            return;
        }
        return $resultado;
    }
    public function comprobarPassword($resultado): bool
{
    // Obtenemos el usuario desde el resultado del query
    $usuario = $resultado->fetch_object();

    // Validamos si el usuario existe y tiene contraseña
    if (!$usuario || !isset($usuario->password)) {
        self::$errores[] = "Usuario inválido o sin contraseña";
        return false;
    }

    // Verificación segura de la contraseña usando password_verify
    if (password_verify($this->password, $usuario->password)) {
        $this->autenticado = true;
    } else {
        $this->autenticado = false;
        self::$errores[] = "El password es incorrecto";
    }

    // Mantenemos el query original (aunque ya no lo usamos para comparar)
    $query = "SELECT * FROM " . self::$tabla . " WHERE password = '" . $this->password . "' LIMIT 1";
    $resultado = self::$db->query($query);

    // Retornamos el estado de autenticación
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
    session_start();

    $_SESSION['usuario']  = $this->email;
    $_SESSION['login']    = true;
    $_SESSION['id']       = $this->id;
    $_SESSION['nombre']   = $this->nombre;
    $_SESSION['apellido'] = $this->apellido;
    $_SESSION['email']    = $this->email;

    header('Location: /usuario/propiedades');
    exit;
}

    public static function getErrores()
    {
        return static::$errores;
    }

    public static function find($id) {
    $id = self::$db->escape_string($id); 
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id} LIMIT 1";
    $resultado = self::$db->query($query);

    if($resultado && $resultado->num_rows === 1) {
        $registro = $resultado->fetch_assoc();
        return new static($registro);
    }
    return null;
}


    
}

?>