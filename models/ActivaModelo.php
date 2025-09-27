<?php
namespace Model;
require_once("../includes/app.php");
class ActivaModelo{
    //base de datos
    protected static $db;
    protected static $tabla;
    protected static $columnDB=[];
    public static function setDB($baseDatos){
        self::$db = conectarDB();
    }
    public static function listar(){
        $query = "Select * from ".static::$tabla;
        $resultado=self::$db->query($query);
        $producto=[];
        if($resultado){
            $producto=$resultado->fetch_all(MYSQLI_ASSOC); //convierte en array asociativo
        }
        return $producto;
    }
    public function crear()
    {
       $atributos = $this->pasar();
    $query = " insert into ".static::$tabla." (";
    $query .= join(",", array_keys($atributos));
    $query .= ") values ('";
    $query .= join("','", array_values($atributos));
    $query .= "')";
    $resultado = self::$db->query($query);
    return $resultado;
    }
     public function pasar()
    {
        $resultado = [];
        foreach(static::$columnDB as $columna) {
            if(isset($this->$columna) && $this->$columna !== null){
                $resultado[$columna] = self::$db->escape_string($this->$columna);
            }
        }
        return $resultado;
    }
    public static function where(string $columna, string|int $valor) {
    $columna = self::$db->escape_string($columna);
    $valor = self::$db->escape_string($valor);

    $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
    $resultado = self::$db->query($query);

    $registros = [];
    if ($resultado) {
        $registros = $resultado->fetch_all(MYSQLI_ASSOC);
    }

    return $registros;
}

}
?>