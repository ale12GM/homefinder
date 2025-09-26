<?php

namespace Model;

class Contactos extends ActivaModelo {
    protected static $tabla = 'contacto';
    protected static $columnDB = ['id','id_usuario','tipo_contacto','valor','es_principal'];
    public $id ;
    public $id_usuario;
    public $tipo_contacto;
    public $valor;
    public $es_principal;
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->tipo_contacto = $args['tipo_contacto'] ?? '';
        $this->valor = $args['valor'] ?? '';
        $this->es_principal = $args['es_principal'] ?? '';
    }
}
?>