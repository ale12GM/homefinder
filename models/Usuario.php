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
        session_start();
        $_SESSION['usuario']=$this->email;
        $_SESSION['login']=true;
        $_SESSION['id']=$this->id;
        header('Location: /usuario/propiedades');
        exit;
    }
    public static function getErrores()
    {
        return static::$errores;
    }


    public static function ultimos($cantidad = 2) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT " . intval($cantidad);
        $resultado = self::$db->query($query);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    

    protected static function convertirAObjetos($resultado) {
        $array = [];
        while($registro = $resultado->fetch_object()){
            $array[] = static::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
}

?>