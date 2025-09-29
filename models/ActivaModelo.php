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
    public static function obtener($id){
        $id = self::$db->escape_string($id);
        $query = "Select * from ".static::$tabla." WHERE id = '{$id}' LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado && $resultado->num_rows > 0){
            return $resultado->fetch_assoc();
        }
        return null;
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

    public function actualizar($id){
        $atributos = $this->pasar();
        $valores = [];

        foreach($atributos as $columna => $valor){
            if($columna === 'id') continue;
            $valores[] = "{$columna} = '{$valor}'";
        }

        if(empty($valores)) return false; // nada que actualizar

        $query = "UPDATE ".static::$tabla." SET ";
        $query .= join(", ", $valores);
        $query .= " WHERE id = '".self::$db->escape_string($id)."' LIMIT 1";

        return self::$db->query($query);
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