<?php
session_start();
include_once '../config/conexion.php';
include_once '../functions/funciones.php';
include_once '../config/datos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST['email'])) {
        echo "<script>alert('Ingrese su correo');</script>";
    } elseif(empty($_POST['password'])) {
        echo "<script>alert('Ingrese su contraseña');</script>";
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Ingrese un correo electrónico válido');</script>";
    } elseif(!preg_match('/@unamba\.edu\.pe$/', $_POST['email'])) {
        echo "<script>alert('Solo se permite el acceso con correos de @unamba.edu.pe');</script>";
    } else {
        $email = $conector->real_escape_string($_POST['email']);
        $pass = $conector->real_escape_string($_POST['password']);
        $clave = $template['clave_publica'];
        $pass = encrypt($pass, $clave);

        $sql = "SELECT * FROM usuarios WHERE emaUsu='".$email."'";
        $query_email = $conector->query($sql);
        $ver_email = $query_email->num_rows;
        if($ver_email < 1) {
            echo "<script>alert('El correo ingresado no existe');</script>";
        } else {
            $sql = "SELECT * FROM usuarios WHERE emaUsu='".$email."' AND pasUsu='".$pass."'";
            $query_pass = $conector->query($sql);
            $ver_pass = $query_pass->num_rows;
            if($ver_pass < 1) {
                echo "<script>alert('Contraseña incorrecta');</script>";
            } else {
                // Extraer información básica del usuario
                while($row = $query_pass->fetch_array()){
                    $_SESSION['codUsu'] = $row['codUsu'];
                    $nombre = $row['nomUsu'];
                }
                // Redirigir al usuario a la página principal
                header("Location: http://localhost/Language/index.html");
                exit();
            }
        }
    }
}
if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }
}

?>

