<?php

namespace Model;

class PropiedadEtiqueta extends ActivaModelo {
    protected static $tabla = 'propiedadetiqueta';
    protected static $columnDB = ['id_propiedad','id_etiqueta'];

    public $id_propiedad;
    public $id_etiqueta;

    public function __construct($args = []) {
        $this->id_propiedad = $args['id_propiedad'] ?? null;
        $this->id_etiqueta = $args['id_etiqueta'] ?? null;
    }
}

?>