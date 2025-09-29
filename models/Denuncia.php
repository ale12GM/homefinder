<?php

namespace Model;

class Denuncia extends ActivaModelo {
    protected static $tabla = 'denuncias';
    protected static $columnDB = ['id', 'id_propiedad', 'id_usuario', 'motivo', 'descripcion', 'fecha_denuncia', 'estado'];
    public $id ;
    public $id_propiedad;
    public $motivo;
    public $descripcion;
    public $fecha_denuncia;
    public $estado;
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_propiedad = $args['id_propiedad'] ?? null;
        $this->motivo = $args['motivo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha_denuncia = $args['fecha_denuncia'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }
}
?>