<?php 
	session_start();
	$a = 0;
	$b = 0;
	$c = 0;

	if (!empty($_POST["entrar"])) {
	
	include("conexion.php");
	$sql2 = "SELECT  * FROM redes_0 WHERE equipos = '".$_POST['equipo']."' AND claves = '".$_POST['clave']."' ";
	$result = $conn->query($sql2);
	$num = $result->num_rows;

		if ($num > 0) {
				$row = $result->fetch_assoc();
				$id = $row["id"];
				

			if ($row["habilitados"] == 1) {
				$inicio = time();
				$hora_limite_concurso = 1472805600;//buscar conversor en inter de la tentativa fecha limite  para que no entren mas tarde 
				if ($inicio < $hora_limite_concurso) {
					$_SESSION["inicio"] = $inicio;
					$_SESSION["id"] = $id;
					header('Location:plataforma.php');
				}
				else{
					$c = 1 ;
				}
				
			}

			else{
				$b = 1;
			}

			
		}
		else{
			$a = 1;
		}		
	}
	
 ?>

<script type="text/javascript" charset="utf-8" async defer>

	var a = "<?php echo $a; ?>";
	var b = "<?php echo $b; ?>";
	var c = "<?php echo $c; ?>";
		 if (a == "1") {
		 	//document.getElementById("error_usuario").innerHTML = "El usuario o la contraseña son incorrectos";	//sale si se hace con ajax asi no ya que ni bien coloca la pagina se recarga
		 	window.alert("El usuario o la contraseña son incorrecta");
		 }

		 if (b == "1") {
		 	window.alert("Ya se enviaron las preguntas con esta cuenta");	
		 }
		 
		 if (c == "1") {
		 	window.alert("El concurso ha concluido ");	
		 }

</script>

<!DOCTYPE html>
<html style="background-image:url('media/fondo_formulario.png');">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Formulario de entrada</title>
	<link rel="stylesheet" href="css/uikit.css">
	<link rel="stylesheet" type="text/css" href="css/uikit.gradient.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/uikit.min.js" type="text/javascript" charset="utf-8" async defer></script>
	 

</head>
<body>

	<div class="uk-container uk-container-center" style="height:100%;z-index:20;">
		<div class="uk-container uk-container-center uk-margin-large-top">
			<div class="uk-grid">
				<div class="uk-width-medium-1-2 uk-width-small-1-1 uk-container-center" >
					<div class="uk-container uk-container-center" style="border:solid 1px #969696;padding:10px 5px 20px 0px;border-radius:15px; background-color:#F9F9F9;">
						<div class=" uk-h2 uk-text-center uk-margin-small-top uk-margin-large-bottom">
							<strong>Identificacion</strong>
						</div>
						<div class="uk-container uk-container-center">
							<form action="index.php" method="post" accept-charset="utf-8" class="uk-form">
								 <div class="uk-container uk-container-center uk-text-center" style="margin-bottom:25px;">
								 	 <label for="equipo" class="uk-h5"><strong>Equipo :</strong></label>
									 <div class="uk-form-icon">
									     <i class="uk-icon-user"></i>
									     <input id="equipo" type="text" name="equipo" required>
									 </div>
								 </div>

								 <div class="uk-container uk-container-center uk-text-center" style="margin-bottom:25px;">
								 	 <label for="clave" class="uk-h5"><strong>Contraseña : </strong></label>
									 <div class="uk-form-icon">
									     <i class="uk-icon-unlock-alt"></i>
									     <input id="clave" type="password" name="clave" required>
									 </div>
								 </div>
								
								 <div class="uk-container uk-container-center uk-text-center uk-margin-small-top">
								 	<button type="submit" class="uk-button uk-button-primary" name="entrar" value="1">Entrar</button>
								 </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>