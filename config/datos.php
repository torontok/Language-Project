<?php 
include_once 'conexion.php';
$sql = "select * from empresa LIMIT 1";
$query = $conector -> query($sql);
$company = array();
while($row = $query -> fetch_array())
{
    $company = $row;
}
//prueba de datos
//echo $company  ['nomEmp'];
$template = array(
    'active_page' => basename($_SERVER['PHP_SELF']),
    'clave_publica'=> "EAPIIS",
    'version' => "1.0",
    'desarrollador' => "Toronto",
    'name' => "LANGUAGE",
    'icono' => 'assets/images/icono.ico'
);
?>