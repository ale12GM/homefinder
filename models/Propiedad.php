<?php

namespace Model;

class Propiedad extends ActivaModelo {
    protected static $tabla = 'propiedades';
    protected static $columnDB = ['id','id_usuario','titulo','descripcion','latitud','longitud', 'precio', 'direccion', 'superficie_total', 'num_habitaciones', 'num_banos', 'estado', 'fecha_publicacion', 'fecha_actualizacion', 'imagen'];

    public $id_usuario;
    public $titulo;
    public $descripcion;
    public $latitud;
    public $longitud;
    public $precio;
    public $direccion;
    public $superficie_total;
    public $num_habitaciones;
    public $num_banos;
    public $estado;
    public $fecha_publicacion;
    public $fecha_actualizacion;
    public $imagen;

    public function __construct($args = []) {
        $this->id_usuario = $args['id_usuario'] ?? null;
        $this->titulo = $args['titulo'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
        $this->latitud = $args['latitud'] ?? null;
        $this->longitud = $args['longitud'] ?? null;
        $this->precio = $args['precio'] ?? null;
        $this->direccion = $args['direccion'] ?? null;
        $this->superficie_total = $args['superficie_total'] ?? null;
        $this->num_habitaciones = $args['num_habitaciones'] ?? null;
        $this->num_banos = $args['num_banos'] ?? null;
        $this->estado = $args['estado'] ?? null;
        $this->fecha_publicacion = $args['fecha_publicacion'] ?? null;
        $this->fecha_actualizacion = $args['fecha_actualizacion'] ?? null;
        $this->imagen = $args['imagen'] ?? null;
        
    }


    public function setImagen($imagen){
    $this->imagen = $imagen;
    }

    public static function findConContactos(int $id_propiedad) : array{
        $queryUsuario = "SELECT id_usuario FROM " . static::$tabla . " WHERE id = '{$id_propiedad}'";
        $resultadoUsuario = self::$db->query($queryUsuario);

        if(!$resultadoUsuario || $resultadoUsuario->num_rows===0){
            return ['error' =>'Propiedad no encontrada o sin usuario asociado.'];
        }
        $propiedad = $resultadoUsuario->fetch_assoc();
        $usuarioId=$propiedad['id_usuario'];

        $queryContactos = "SELECT tipo_contacto, valor FROM contacto WHERE id_usuario = '{$usuarioId}' AND es_principal = 1";
        $resultadoContactos = self::$db->query($queryContactos);

        $contactos_raw =[];

        if($resultadoContactos){
            $contactos_raw = $resultadoContactos->fetch_all(MYSQLI_ASSOC);
        }
        $contactos_formateados = [];
        foreach($contactos_raw as $contacto){
            $contactos_formateados[$contacto['tipo_contacto']] = $contacto['valor'];
        }
        return $contactos_formateados;
    }
}

?>