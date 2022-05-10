<?php
//coneccion a la base de datos
//datos de coneccion
$host="localhost";
$bd="sitio";
$usuario="root";
$password="";
//datos de coneccion

try {
        $conexion= new PDO("mysql:host=$host;dbname=$bd",$usuario,$password);
        //if($conexion){ echo "conectado... a Sistema"; }
} catch (Exception $ex) {
    
    echo "Error de coneccion al sistema";
}

//coneccion a la base de datos
?>