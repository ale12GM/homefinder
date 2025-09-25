<?php
function conectarDB() : mysqli 
{
    $servidor='localhost';
    $usuario='root';
    $contrasena= '';
    $bd='homefinder';
    $db = new mysqli($servidor,$usuario,$contrasena,$bd);
    if($db->connect_error){
        throw new Exception('Error de conexion'.$db->connect_error);
    }
    return $db;
}
?>