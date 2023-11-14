<?php

$host="localhost";
$bd="tienda_televisores";
$usuario="limber";
$contrasenia="limber";


try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
    

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>