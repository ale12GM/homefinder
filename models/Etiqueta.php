<?php

namespace Model;

class Etiqueta extends ActivaModelo {
    protected static $tabla = 'etiquetas';
    protected static $columnDB = ['id','nombre'];

    public $nombre;

    public function __construct($args = []) {
        $this->nombre = $args['nombre'] ?? null;
    }
}

?>