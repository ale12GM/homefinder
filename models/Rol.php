<?php

namespace Model;

class Rol extends ActivaModelo {
    protected static $tabla = 'roles';
    protected static $columnDB = ['id','nombre','descripcion'];

    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
    }

    // Método para obtener todos los permisos y marcar cuáles están asignados
    public function obtenerPermisos() {
        // 1. Traer todos los permisos
        $todos = Permiso::listar();

        // 2. Traer permisos asociados a este rol
        $idRol = self::$db->escape_string($this->id);
        $query = "SELECT id_permiso FROM rolpermiso WHERE id_rol = {$idRol}";
        $resultado = self::$db->query($query);

        $asignados = [];
        if ($resultado) {
            $asignados = array_column($resultado->fetch_all(MYSQLI_ASSOC), 'id_permiso');
        }

        // 3. Marcar cada permiso como asignado o no
        foreach ($todos as &$permiso) {
            $permiso['asignado'] = in_array($permiso['id'], $asignados);
        }

        return $todos;
    }
}
