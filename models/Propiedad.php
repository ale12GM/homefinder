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

    /**
     * Valida los datos de una propiedad
     * @param array $datos Datos a validar
     * @param array $contactos_data Datos de contactos (opcional)
     * @param array $imagen_file Datos del archivo de imagen (opcional)
     * @return array Array con errores encontrados
     */
    public static function validarDatos($datos, $contactos_data = [], $imagen_file = null) {
        $errores = [];
        
        // Título
        if (empty($datos['titulo'])) {
            $errores['titulo'] = "El título es obligatorio.";
        } elseif (mb_strlen($datos['titulo']) > 50) {
            $errores['titulo'] = "El título no puede exceder 50 caracteres.";
        }

        // Dirección
        if (empty($datos['direccion'])) {
            $errores['direccion'] = "La dirección es obligatoria.";
        } elseif (mb_strlen($datos['direccion']) > 255) {
            $errores['direccion'] = "La dirección no puede exceder 255 caracteres.";
        }

        // Superficie
        if (empty($datos['superficie_total'])) {
            $errores['superficie'] = "La superficie es obligatoria.";
        } elseif (!is_numeric($datos['superficie_total'])) {
            $errores['superficie'] = "La superficie debe ser un número.";
        } elseif ((float)$datos['superficie_total'] < 0) {
            $errores['superficie'] = "La superficie no puede ser negativa.";
        }

        // Latitud
        if (!empty($datos['latitud'])) {
            if (!is_numeric($datos['latitud'])) {
                $errores['latitud'] = "La latitud debe ser numérica.";
            }
        }

        // Longitud
        if (!empty($datos['longitud'])) {
            if (!is_numeric($datos['longitud'])) {
                $errores['longitud'] = "La longitud debe ser numérica.";
            }
        }

        // Habitaciones
        if (!empty($datos['num_habitaciones'])) {
            if (filter_var($datos['num_habitaciones'], FILTER_VALIDATE_INT) === false) {
                $errores['habitaciones'] = "Número de habitaciones inválido.";
            } elseif ((int)$datos['num_habitaciones'] < 0) {
                $errores['habitaciones'] = "El número de habitaciones no puede ser negativo.";
            }
        }

        // Baños
        if (!empty($datos['num_banos'])) {
            if (filter_var($datos['num_banos'], FILTER_VALIDATE_INT) === false) {
                $errores['banos'] = "Número de baños inválido.";
            } elseif ((int)$datos['num_banos'] < 0) {
                $errores['banos'] = "El número de baños no puede ser negativo.";
            }
        }

        // Precio
        if (empty($datos['precio'])) {
            $errores['precio'] = "El precio es obligatorio.";
        } elseif (!is_numeric($datos['precio'])) {
            $errores['precio'] = "El precio debe ser un número.";
        } elseif ((float)$datos['precio'] < 0) {
            $errores['precio'] = "El precio no puede ser negativo.";
        }

        // Descripción
        if (empty($datos['descripcion'])) {
            $errores['descripcion'] = "La descripción es obligatoria.";
        } elseif (mb_strlen($datos['descripcion']) > 500) {
            $errores['descripcion'] = "La descripción no puede exceder 500 caracteres.";
        }

        // Estado
        if (!empty($datos['estado']) && mb_strlen($datos['estado']) > 15) {
            $errores['estado'] = "El estado no puede exceder 15 caracteres.";
        }

        // Contactos
        if (!empty($contactos_data)) {
            $contactos_validos = 0;
            $tiene_principal = false;
            
            foreach ($contactos_data as $contacto) {
                $tipo = trim($contacto['tipo_contacto'] ?? '');
                $valor = trim($contacto['valor'] ?? '');
                $es_principal = isset($contacto['es_principal']) ? 1 : 0;
                
                if (!empty($tipo) && !empty($valor)) {
                    $contactos_validos++;
                    if ($es_principal) {
                        $tiene_principal = true;
                    }
                    
                    if ($tipo === 'email' && !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                        $errores['contactos'] = "El email no tiene un formato válido.";
                        break;
                    }
                } elseif (!empty($tipo) || !empty($valor)) {
                    $errores['contactos'] = "Todos los campos de contacto deben estar completos.";
                    break;
                }
            }
            
            if ($contactos_validos > 0 && !$tiene_principal) {
                $errores['contactos'] = "Debe seleccionar al menos un contacto como principal.";
            }
        }

        // Imagen
        if ($imagen_file && (!$imagen_file || $imagen_file['error']['imagen'] !== UPLOAD_ERR_OK)) {
            $errores['imagen'] = "Debes subir una imagen.";
        }

        return $errores;
    }

    /**
     * Formatea los datos antes de guardar
     * @param array $datos Datos a formatear
     * @return array Datos formateados
     */
    public static function formatearDatos($datos) {
        $formateados = $datos;
        
        // Formatear superficie
        if (!empty($datos['superficie_total'])) {
            $formateados['superficie_total'] = number_format((float)$datos['superficie_total'], 2, '.', '');
        }
        
        // Formatear latitud
        if (!empty($datos['latitud'])) {
            $formateados['latitud'] = number_format((float)$datos['latitud'], 6, '.', '');
        }
        
        // Formatear longitud
        if (!empty($datos['longitud'])) {
            $formateados['longitud'] = number_format((float)$datos['longitud'], 6, '.', '');
        }
        
        // Formatear precio
        if (!empty($datos['precio'])) {
            $formateados['precio'] = number_format((float)$datos['precio'], 2, '.', '');
        }
        
        // Formatear habitaciones
        if (!empty($datos['num_habitaciones'])) {
            $formateados['num_habitaciones'] = (int)$datos['num_habitaciones'];
        }
        
        // Formatear baños
        if (!empty($datos['num_banos'])) {
            $formateados['num_banos'] = (int)$datos['num_banos'];
        }
        
        return $formateados;
    }
}

?>