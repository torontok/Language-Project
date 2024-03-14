<?php
	@session_start();
	include_once 'config/datos.php';
	include_once 'sections/admin_pages.php';
	if(isset($_SESSION['codUsu'])){
		//extraer datos del usuario
		$page_actual = $template['active_page'];
		foreach($pages as $id => $pagina){
			if($page_actual == $id){
				$title = $pagina;
				break;
			}
		}		
		$sql = "SELECT *FROM usuarios WHERE codUsu='".$_SESSION['codUsu']."' AND estUsu=1";
		$query = $conector->query($sql);
		$ver_estado = $query->num_rows;
		if($ver_estado>0){
			$usuario = array();
			while($row = $query->fetch_array()){
				$usuario = $row;
			}
		}else{
			echo "
			<script type='text/javascript'>
				function redireccionar(){
					window.location='index.php'
				}
				setTimeout('redireccionar()',0);
			</script>
			";
		}
		
	}else{
		//enviar al login
		echo "
			<script type='text/javascript'>
				function redireccionar(){
					window.location='index.php'
				}
				setTimeout('redireccionar()',0);
			</script>
			";
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>
     <!-- Icons -->
	<link rel="shortcut icon" href="<?php echo $template['icono'];?>">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>