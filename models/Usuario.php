<?php

namespace Model;

class Usuario extends ActivaModelo {
    protected static $tabla = 'usuarios';
    protected static $columnDB = ['id','nombre','apellido','email','contrasenia_hash','fecha_registro', 'estado'];

    public $nombre;
    public $apellido;
    public $email;
    public $contrasenia_hash;

    public function __construct($args = []) {
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->contrasenia_hash = $args['contrasenia_hash'] ?? null;
    }
}

?>