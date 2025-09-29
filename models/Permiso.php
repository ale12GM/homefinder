<?php

namespace Model;

class Permiso extends ActivaModelo {
    protected static $tabla = 'permisos';
    protected static $columnDB = ['id', 'nombre', 'descripcion', 'estado'];

    public $id;
    public $nombre;
    public $descripcion;
    public $estado;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }
}
?>