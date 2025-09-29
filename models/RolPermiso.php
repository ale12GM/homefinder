<?php

namespace Model;

class RolPermiso extends ActivaModelo {
    protected static $tabla = 'rolpermiso';
    protected static $columnDB = ['id_rol','id_permiso'];

    public $id_rol;
    public $id_permiso;

    public function __construct($args = []) {
        $this->id_rol = $args['id_rol'] ?? null;
        $this->id_permiso = $args['id_permiso'] ?? null;
    }
}

?>