<?php
	
	 session_start();
	 $ahora = time();
	 $inicio = $_SESSION["inicio"];
	 $final_maximo = $inicio + 3600;//poner la duracion de la prueba

	 if (!empty($_POST["salir"])) {
	 	$final = time();
	 	$tiempo = $final - $inicio;
	 	$minutos = (int)($tiempo/60);
	 	$segundos = $tiempo - $minutos*60;
	 	$tiempo = $minutos." : ".$segundos;

	 include("conexion.php");

		$respuesta = "";
		$claves_por_pregunta = "";
	 	 for ($i=0; $i < count($_SESSION["ids_preguntas"]); $i++) { 	
	 	 		$claves_marcadas = $_POST["res".$_SESSION["ids_preguntas"][$i]];
	 	 		for ($j=0; $j < count($claves_marcadas); $j++) { 
	 	 			$claves_por_pregunta .= $claves_marcadas[$j]; 
	 	 		}
	 	 		$respuesta .= $_SESSION["ids_preguntas"][$i].".".$claves_por_pregunta." ";
	 	 		$claves_por_pregunta = "";
	 	 }

		 
		 $id = $_SESSION['id'];
		 $sql = "UPDATE redes_0 SET respuestas = '$respuesta', habilitados = 0, tiempos = '$tiempo' WHERE id = '$id' ";
		 $conn->query($sql);
		 session_destroy();
		 header('Location:mensaje_final.php');
	 }

	 if (empty($_SESSION["id"])) {
		header('Location:index.php');		
	 }

?>


<!DOCTYPE html>
<html style="background-image:url('media/fondo_formulario.png');">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Plataforma Virtual</title>
	<link rel="stylesheet" href="css/uikit.css">
	<link rel="stylesheet" href="css/estilos_animacion.css">
	<link rel="stylesheet" type="text/css" href="css/uikit.gradient.css">
	<link rel="stylesheet" href="owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="owl-carousel/owl.theme.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/uikit.min.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="owl-carousel/owl.carousel.js"></script>
	<script type="text/javascript" charset="utf-8" async defer>
		$(document).ready(function() {
		  $("#owl-demo").owlCarousel({
		 
		      navigation : true, // Show next and prev buttons
		      slideSpeed : 300,
		      paginationSpeed : 400,
		      singleItem:true
		 
		      // "singleItem:true" is a shortcut for:
		      // items : 1, 
		      // itemsDesktop : false,
		      // itemsDesktopSmall : false,
		      // itemsTablet: false,
		      // itemsMobile : false
		     });
		});
	</script>

	<style type="text/css" media="screen">
		#owl-demo .item{
		    display: block;
		    width: 100%;
		    height: auto;
   		 }
	</style>


	<script type="text/javascript" charset="utf-8" async defer>

	function funcion_contador (argument) {

		var ahora = "<?php echo $ahora ?>";
		var final = "<?php echo $final_maximo ?>";
	    var minutos = 0;
	    var segundos = 0;
	    var diferencia = final - ahora;

	    setInterval(function(){
			if( diferencia >= 0){
			        minutos = Math.floor(diferencia/60);
			        segundos = diferencia-(60 * minutos);
			        document.getElementById("minutos").innerHTML = minutos;
			    	document.getElementById("segundos").innerHTML = segundos;
			    	diferencia -- ;
			}
			else {
				document.getElementById('boton_envio').click();
			}

		 }, 1000);
	}

	</script>


</head>


<body onload = "funcion_contador()">
	 <!--
	 <div id="contenedor_fondo_animacion">
		<div id="loader-wrapper">
		    <div id="loader"></div>
	    </div>
	 </div>
	 -->

	<div class="uk-container uk-container-center uk-padding-remove uk-margin-small-top" style="border:1px solid #999999;border-radius:0px 0px 15px 15px;background-color:rgb(249,249,249);">
		 <div class="uk-container uk-container-center uk-padding-remove">
			<div class="uk-grid uk-margin-remove">
				<div class="uk-width-1-2 uk-h2 uk-text-center uk-margin-small-bottom" style="background-color:#395174;color:white;padding:7px;">
					Concurso de Redes 
				</div>
				<div class="uk-width-1-2 uk-h2 uk-text-center uk-margin-small-bottom" style="background-color:#395174;color:white;padding:7px;">
					<span id="minutos"></span>:<span id="segundos"></span>
				</div>
			</div>
		 </div>

		 <div class="uk-container uk-container-center uk-padding-remove uk-margin-remove">
			<form action="plataforma.php" method="post" accept-charset="utf-8" class="uk-form">
				<div id="owl-demo" class="owl-carousel owl-theme uk-container uk-container-center uk-padding-remove">




		<?php 
			include("conexion.php");
			$sql2 = "SELECT * FROM redes_1";
			$result = $conn->query($sql2);
			$num = $result->num_rows;

			while($row = $result->fetch_array()){$id_validos[] = $row["id"];}

			$preguntas_examen = 4 ;
			$preguntas_total_banco_preguntas = $num;
			$min = $id_validos[0];
			$max = $id_validos[$num-1];
			$total_preguntas = 0; 

			while ($total_preguntas != $preguntas_examen) {
				$id_aleatorio = rand ($min, $max);
				for ($i=0; $i < $num; $i++) { 
					if ($id_validos[$i] == $id_aleatorio) {
						$ids_preguntas[$total_preguntas] = $id_aleatorio;
						$id_validos[$i] = 0;
						$total_preguntas ++;
					}
				}
			}

			$_SESSION["ids_preguntas"] = $ids_preguntas;

			 for ($i=0; $i < $preguntas_examen; $i++) { 

				$id_pregunta = $_SESSION["ids_preguntas"][$i];
				$sql3 = "SELECT * FROM redes_1 WHERE id = '$id_pregunta' ";
				$result_2 = $conn->query($sql3);
				$datos_pregunta = $result_2->fetch_array();

					echo '
					<div class="item uk-container uk-container-center">
						<div class="uk-container uk-container-center  uk-margin-small-top uk-margin-small-bottom">
							<strong>'.$datos_pregunta["preguntas"].'</strong>
						</div>
					';
						
					$mostrar_imagen = "inline";
					if (empty($datos_pregunta["imagenes"])) {
						$mostrar_imagen = "none";
					}
					else{
						echo '
						<div class="uk-container uk-container-center uk-text-center uk-margin-small-top uk-margin-small-bottom">
							<img src="media/preguntas/'.$datos_pregunta["imagenes"].'" style = "display :'.$mostrar_imagen.';height : 350px; width:650px;"> 
						</div> 

						';		// ver si a la imagen se le pone heith y width en la etiqueta principal y no como estilo para que se haga responsive 
					}

					 $letras = array("a","b","c","d","e");
					 shuffle($letras);

					 echo '

							<div class="uk-container uk-container-center  uk-margin-small-top">
								<input id="a'.$id_pregunta.'" type="checkbox" name="res'.$id_pregunta.'[]" value="'.$letras[0].'"><label for="a'.$id_pregunta.'">'.$datos_pregunta[$letras[0]].'</label>
							</div>
							<div class="uk-container uk-container-center">
								<input id="b'.$id_pregunta.'" type="checkbox" name="res'.$id_pregunta.'[]" value="'.$letras[1].'"><label for="b'.$id_pregunta.'">'.$datos_pregunta[$letras[1]].'</label>
							</div>
							<div class="uk-container uk-container-center">
								<input id="c'.$id_pregunta.'" type="checkbox" name="res'.$id_pregunta.'[]" value="'.$letras[2].'"><label for="c'.$id_pregunta.'">'.$datos_pregunta[$letras[2]].'</label>
							</div>
							<div class="uk-container uk-container-center">
								<input id="d'.$id_pregunta.'" type="checkbox" name="res'.$id_pregunta.'[]" value="'.$letras[3].'"><label for="d'.$id_pregunta.'">'.$datos_pregunta[$letras[3]].'</label>
							</div>
							<div class="uk-container uk-container-center">
								<input id="e'.$id_pregunta.'" type="checkbox" name="res'.$id_pregunta.'[]" value="'.$letras[4].'"><label for="e'.$id_pregunta.'">'.$datos_pregunta[$letras[4]].'</label>
							</div>
							

					</div>
					';



			 }

		?>

					 <div class="item uk-container uk-container-center">
					 	<div class="uk-container uk-container-center uk-text-center uk-margin-large-top">
					 		<button type="button" class="uk-button uk-button-primary uk-button-large" data-uk-modal="{target:'#my-id'}">Enviar Respuestas</button>
					 	</div>
					 </div>

				 </div>

				 <div id="my-id" class="uk-modal">
					 <div class="uk-modal-dialog uk-text-center">
						 <a class="uk-modal-close uk-close"></a>
						 <div class="uk-h2">¿Esta seguro de enviar sus respuestas?</div>
						 <div>Una vez enviado ya no habra forma de volver atras</div>
						 <button type="submit" class="uk-button uk-button-success" name="salir" value="1" style="margin:10px 5px 10px 5px;" id="boton_envio">Enviar Respuestas</button>
					</div>
				 </div>




			</form>	
		 </div>

	 </div>

	 


</body>
</html>