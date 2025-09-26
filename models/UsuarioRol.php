<?php

namespace Model;

class UsuarioRol extends ActivaModelo {
    protected static $tabla = 'usuariorol';
    protected static $columnDB = ['id_usuario','id_rol'];

    public $id_usuario;
    public $id_rol;


    public function __construct($args = []) {
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->id_rol = $args['id_rol'] ?? null;
    }
}

?>