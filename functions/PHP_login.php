<?php
    @session_start();
    include_once '../config/conexion.php';
	include_once '../functions/funciones.php';
	include_once '../config/datos.php';
	$fecha = date('Y-m-d H:i:s');
    if(!isset($_SESSION['intentos'])){
        $_SESSION['intentos']= 0;
    }

    if(empty($_POST['email'])){
        $errors[]="Ingrese su correo";
    }elseif(empty($_POST['password'])){
        $errors[]="Ingrese su contraseña";
    }else{
        //programar la validacion de datos
        $email = $conector->real_escape_string($_POST['email']);
		$pass = $conector->real_escape_string($_POST['password']);
		$clave = $template['clave_publica'];
		//Encriptar contraseña
		$pass = encrypt($pass,$clave);
		//validar el correo en BD
		$sql = "SELECT *FROM usuarios WHERE emaUsu='".$email."'";
		$query_email = $conector->query($sql);
		$ver_email = $query_email->num_rows;
		if($ver_email<1){
			$errors[]="El correo ingresado no existe!";
		}else{
            //obtener codigo de usuario
            while($row = $query_email->fetch_array()){
                $cod_user = $row['codUsu'];
                $est_User = $row['estUsu'];
            }
			//validar al contraseña en la BD con el correo
			$sql = "SELECT *FROM usuarios WHERE emaUsu='".$email."' AND pasUsu='".$pass."'";
			$query_pass = $conector->query($sql);
			$ver_pass = $query_pass->num_rows;
			if($ver_pass<1){
				
                $_SESSION['intentos'] +=1;
                if($_SESSION['intentos']<3){
                    $inten_pend= $_SESSION['intentos'];
                    $errors[]="El password ingresado no valido. le quedan ".$inten_pend. "intentos";
             
                }else{
                    //Bloquea al Usurio
                    $sql_bloqueo = "UPDATE usuarios SET estUsu=0 WHERE emaUsu='".$email."'";
                    $query_bloqueo = $conector->query($sql_bloqueo);
                    //Inserta el USUARIO LOGIN
    
                    $sql_login = "INSERT INTO usuarios_login (codUsu,detUL,tipUL,regUL)
                    VALUES ('".$cod_user."','Bloqueo por 03 intentos',0,'". $fecha."' ) ";
                    $insert = $conector->query($sql_login);
                    //Envio Final del Mensaje
                    $errors[]="Usuario bloqueado por intentos fallidoso";
                    unset($_SESSION['intentos']) ;
                        
                    }
                
			}else{
				//extraer informacion basica de mi BD - Codigo del usuarios
				while($row = $query_pass->fetch_array()){
					$_SESSION['codUsu'] = $row['codUsu'];
					$nombre = $row['nomUsu'];					
				}
                //insertar el Usuario LOGIN
                $sql_login = "INSERT INTO usuarios_login (codUsu,detUL,tipUL,regUL)
                VALUES ('".$_SESSION['codUsu']."','Acceso permitido',1,'".$fecha."' ) ";
                $insert = $conector->query($sql_login);
            if($insert){
                $messages[]=$nombre."
				<script type='text/javascript'>
					function redireccionar(){
						window.location='http://localhost/Language/admin.php'

					}
					setTimeout('redireccionar()',4000);
				</script>
				";
            }else{
                $errors[]="no guarda login";
            }
				
			}
		}
    }
	
    if(isset($errors)){
    ?>
        <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Error!</strong>
     <?php
        foreach($errors as $error)
         {
            echo $error;
        }
     ?>
       </div>
    <?php
    }
	
	if(isset($messages)){
    ?>
        <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Bienvenido!</strong>
     <?php
        foreach($messages as $sms)
         {
            echo $sms;
        }
     ?>
       </div>
    <?php
    }
?>