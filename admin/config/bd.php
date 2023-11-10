<?php

$host="localhost";
$bd="tienda_televisores";
$usuario="root";
$contrasenia="";

try {
     $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
     
 } catch(PDOExeption $e){
          echo "Error al guardar los datos:".$e ->GetMessaje();
}

?>