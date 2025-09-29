<?php

namespace Model;

class NormativaContrasenia extends ActivaModelo {
    protected static $tabla = 'normativascontrasenias';
    protected static $columnDB = ['id','longitud_minima','longitud_maxima','requiere_mayusculas','requiere_minusculas','requiere_numeros','requiere_simbolos','cantidad_simbolos','caducidad_dias','intentos_maximos','es_activa','fecha_creacion'];

    public $longitud_minima;
    public $longitud_maxima;
    public $requiere_mayusculas;
    public $requiere_minusculas;
    public $requiere_numeros;
    public $requiere_simbolos;
    public $cantidad_simbolos;
    public $caducidad_dias;
    public $intentos_maximos;
    public $es_activa;
    public $fecha_creacion;


    public function __construct($args = []) {
        $this->longitud_minima = $args['longitud_minima'] ?? null;
        $this->longitud_maxima = $args['longitud_maxima'] ?? null;
        $this->requiere_mayusculas = $args['requiere_mayusculas'] ?? null;
        $this->requiere_minusculas = $args['requiere_minusculas'] ?? null;
        $this->requiere_numeros = $args['requiere_numeros'] ?? null;
        $this->requiere_simbolos = $args['requiere_simbolos'] ?? null;
        $this->cantidad_simbolos = $args['cantidad_simbolos'] ?? null;
        $this->caducidad_dias = $args['caducidad_dias'] ?? null;
        $this->intentos_maximos = $args['intentos_maximos'] ?? null;
        $this->es_activa = $args['es_activa'] ?? null;
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
    }

    /**
     * Obtiene la normativa de contraseña activa
     * @return NormativaContrasenia|null
     */
    public static function obtenerNormativaActiva() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE es_activa = 1 LIMIT 1";
        $resultado = self::$db->query($query);
        
        if ($resultado && $resultado->num_rows > 0) {
            $normativa = $resultado->fetch_assoc();
            return new self($normativa);
        }
        
        return null;
    }
}

?>