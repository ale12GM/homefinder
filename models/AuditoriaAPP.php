<?php

namespace Model;

class AuditoriaApp extends ActivaModelo {
    protected static $tabla = 'auditoriaapp';
    protected static $columnDB = ['id','fecha','usuario','operacion','resultado','ip_origen'];

    public $fecha;
    public $usuario;
    public $operacion;
    public $resultado;
    public $ip_origen;


    public function __construct($args = []) {
        $this->fecha = $args['fecha'] ?? null;
        $this->usuario = $args['usuario'] ?? null;
        $this->operacion = $args['operacion'] ?? null;
        $this->resultado = $args['resultado'] ?? null;
        $this->ip_origen = $args['ip_origen'] ?? null;
    }
}

?>