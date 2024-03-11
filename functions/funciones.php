<?php
function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
    }
    return base64_encode($result);
        }
     
function decrypt($string, $key) {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}


//prueba de encriptacion
/*include_once '../config/datos.php';
$password = "12345678";
$clave = $template['clave_publica'];
$new_pass = encrypt($password,$clave);
echo $new_pass; 
$des_pass = decrypt($new_pass,$clave);
echo '<br>'.$des_pass;*/
?>