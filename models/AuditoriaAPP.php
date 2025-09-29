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

    public static function registrarLogin(string $email, bool $exitoso, string $operacion): bool {
        $resultadoTexto = $exitoso ? 'Exitoso' : 'Fallido';
        $ipOrigen = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida'; // Obtener la IP del cliente

        $auditoria = new self([ // Usamos 'self' para instanciar la propia clase
            'usuario' => $email,
            'operacion' => $operacion,
            'resultado' => $resultadoTexto,
            'ip_origen' => $ipOrigen
            // 'fecha' se establecerá automáticamente por la base de datos
        ]);

        return $auditoria->crear(); // Asume que 'crear()' guarda el objeto en la DB
    }
}

?>