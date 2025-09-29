<?php

namespace Model;

class Rol extends ActivaModelo {
    protected static $tabla = 'roles';
    protected static $columnDB = ['id','nombre','descripcion'];

    public $nombre;
    public $descripcion;


    public function __construct($args = []) {
        $this->nombre = $args['nombre'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
    }


}

?>