<?php

$host="localhost";
$bd="tienda_televisores";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
/*try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contracenia);
    // Establecer el modo de error PDO en excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}*/
?>