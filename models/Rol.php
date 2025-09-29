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

    public function validar(){
        $alertas = [];
        if(!$this->nombre){
            $alertas['nombre']='El nombre del rol es obligatorio';
        }
        if(!$this->descripcion){
            $alertas['descripcion']="La descripcion del rol es obligatoria";
        }
        $nombre_seguro = self::$db->escape_string($this->nombre);
        $query = "SELECT * FROM " . static::$tabla . " WHERE nombre = '{$nombre_seguro}' LIMIT 1";
        $resultado=self::$db->query($query);
        if($resultado && $resultado->num_rows > 0){
            $rol_existente = $resultado->fetch_assoc();
            if($this->id != $rol_existente['id']){
                $alertas['nombre']='El nombre de este rol ya esta registrado.';
            }
        }
        return $alertas;
    }

    public static function obtenerUsuariosAsignados(int $id_rol){
        $id_rol_seguro = self::$db->escape_string($id_rol);
        $query = "SELECT id_usuario FROM usuariorol WHERE id_rol = {$id_rol_seguro}";
        $resultado = self::$db->query($query);
        $asignados=[];
        if($resultado){
            $asignados = $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return $asignados;
    }
    const ROL_BASE_ID = 2;
    public static function gestionarRol(int $idUsuario, int $idRol, string $accion){
        $db = self::$db;
        $idUsuario = $db->escape_string($idUsuario);
        $idRol = $db->escape_string($idRol);

        

        if($accion === 'añadir'){
            $query = "UPDATE usuariorol SET id_rol = {$idRol} WHERE id_usuario = {$idUsuario}";
            $resultado = $db->query($query);
            if($db->affected_rows === 0){
                $query = "INSERT INTO usuariorol (id_usuario, id_rol) VALUES ({$idUsuario}, {$idRol})";
                $resultado = $db->query($query);
            }
            return $resultado;
        }
        elseif ($accion === 'quitar'){
            $query = "UPDATE usuariorol SET id_rol = " . self::ROL_BASE_ID . " WHERE id_usuario = {$idUsuario}";
            return $db->query($query);
        }
        return false;
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

    // En Rol.php o ActivaModelo.php
    public static function listarConteoUsuarios() {
        $tablaRol = static::$tabla; // 'roles'
        $query = "SELECT 
                    r.*, 
                    COUNT(ur.id_usuario) AS total_usuarios 
                FROM {$tablaRol} r
                LEFT JOIN usuariorol ur 
                    ON r.id = ur.id_rol
                GROUP BY r.id";
                
        $resultado = self::$db->query($query);
        
        $roles = [];
        if($resultado) {
            // fetch_all(MYSQLI_ASSOC) es ideal para este tipo de consultas
            $roles = $resultado->fetch_all(MYSQLI_ASSOC); 
        }
        return $roles;
    }

}
