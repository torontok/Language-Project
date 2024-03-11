<?php
include_once 'bd.php';
$conector = new mysqli($servidor,$usuario,$password,$basededatos);
if ($conector->connect_error) {
die('Error de Conexi�n (' . $conector->connect_errno . ') '. $conector->connect_error);
}/*else {
    
   echo "conexion realizada";
}

$conector->close();*/
?>