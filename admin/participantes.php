<?php 
	include("conexion.php");
	
	if (!empty($_POST["actualizar"])) {
	$sql8 = "UPDATE redes_0";
	$conn->query($sql8);
	}

	if (!empty($_POST["rh"])) {
		$arreglo_cambio = explode(".",$_POST["rh"]);
		$habilitado_cambio = $arreglo_cambio[0];
		$id_cambio = $arreglo_cambio[1];

		if ($habilitado_cambio == 1) {
			$habilitado_cambio = 0;
		}
		else{
			$habilitado_cambio = 1;
		}

		$sql5 = "UPDATE redes_0 SET habilitados = '$habilitado_cambio' WHERE id = '$id_cambio' ";
		$conn->query($sql5);
		}

		if (!empty($_POST["ht"])) {
			$sql6 = "UPDATE redes_0 SET habilitados = '".$_POST['ht']."' ";
			$conn->query($sql6);
		}
		
		if (!empty($_POST["dt"])) {
			$sql7 = "UPDATE redes_0 SET habilitados = '".$_POST['dt']."' ";
			$conn->query($sql7);
		}




		$sql = "SELECT * FROM redes_0";
		$result = $conn->query($sql);
		//$row = $result->fetch_array();//comentar cuando se descomente el while
		while($row = $result->fetch_array()){
			$respuesta = $row["respuestas"];
			$id = $row["id"];
			//conversion de respuestas en puntaje
			$puntaje = 0;
			$respuestas = explode(" ",$respuesta);

			for ($i=0; $i < count($respuestas) - 1; $i++) { 

				//echo $respuestas[$i]."----------------------";

				$pr = explode(".", $respuestas[$i]);
				if ( ! isset($pr[1])) {//logre hacer que sin esto funcione pero hay que dejarlo por siacaso
				   $pr[1] = null;
				}
				$claves_participante = str_split($pr[1]);
				sort($claves_participante);
				$respuesta_pregunta = "";
				for ($j=0; $j < count($claves_participante); $j++) { 
					$respuesta_pregunta .= $claves_participante[$j];
				}

				if (!empty($respuesta_pregunta)) {
					$id_pregunta = $pr[0];
					$sql2 = "SELECT  * FROM redes_1 WHERE id = '$id_pregunta' AND respuestas = '$respuesta_pregunta'";
					$result2 = $conn->query($sql2);
					$num = $result2->num_rows;

						if ($num > 0) {
							$puntaje += 5;//correctas
						}
						else{
							$puntaje -= 1;//incorrectas
						}



				}
				else{
					$puntaje += 0; //blanco
				}


			}

			$sql3 = "UPDATE redes_0 SET resultados = '$puntaje' WHERE id = '$id' ";
		 	$conn->query($sql3);
		}	
 ?>

 <!DOCTYPE html>
 <html style="background-image:url('../media/fondo_formulario.png');">
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Visor Participantes</title>
 	<link rel="stylesheet" href="../css/uikit.css">
	<link rel="stylesheet" type="text/css" href="../css/uikit.gradient.css">
	<link rel="stylesheet" href="datatable.css">
	<script src="jquery.js" type="text/javascript"></script>
	<script src="../js/uikit.min.js" type="text/javascript" charset="utf-8" async defer></script>
 	
 	
 	<script src="datatable.js" type="text/javascript"></script>
 	

 	<script type="text/javascript">
		$(document).ready(function() {
			$('#cuadro').DataTable();
		});


 	</script>

 </head>
 <body>
 	<div class="uk-container uk-container-center uk-margin-large-top" style="border:solid 1px #969696;border-radius:10px;padding-bottom:10px;background-color:white;padding-top:7px;">
 		<div class="uk-container uk-container-center uk-text-center uk-h2  uk-margin-small-top uk-margin-small-bottom"><strong>Visor Concurso</strong></div>
 		<div class="uk-container uk-container-center  uk-margin-small-top">
 			<form action="participantes.php" method="post" accept-charset="utf-8">
	 			<table id="cuadro" class="display" cellspacing="0" width="90%" style="margin:auto;">
		 			<thead>
		 				<tr>
		 					<th>Equipo</th>
		 					<th>Clave</th>
		 					<th>Tiempo</th>
		 					<th>Habilitado</th>
		 					<th>Puntaje</th>

		 				</tr>
		 			</thead>
		 			<tfoot>
			            <tr>
			               	<th>Equipo</th>
		 					<th>Clave</th>
		 					<th>Tiempo</th>
		 					<th>Habilitado</th>
		 					<th>Puntaje</th>
			            </tr>
			        </tfoot>
		 			<tbody>
						
		 			<?php 
		 				$sql4 = "SELECT * FROM redes_0";
						$result3 = $conn->query($sql4);
				
						
						//$row = $result->fetch_array();//comentar cuando se descomente el while
						while($fila = $result3->fetch_array()){
							$clase_boton = "uk-button-danger";
							$texto_boton = "Deshabilitado";

						echo '<tr>
								<td>'.$fila["equipos"].'</td>
								<td>'.$fila["claves"].'</td>
								<td class="uk-text-center">'.$fila["tiempos"].'</td>';

								if ($fila["habilitados"] == 1) {
									$clase_boton = "uk-button-primary";
									$texto_boton = "Habilitado";
								}


						echo '	<td class="uk-text-center"><button type="submit" name="rh" value="'.$fila["habilitados"].'.'.$fila["id"].'" class="uk-button '.$clase_boton.'">'.$texto_boton.'</button></td>	
								<td class="uk-text-center">'.$fila["resultados"].'</td>
							</tr>';
						}
							
		 			 ?>

		 			</tbody>
	 			</table>
	 				<div class="uk-container uk-text-center" style="margin:10px;margin-bottom:20px">
	 					<button type="submit" class="uk-button uk-button-large uk-button-success" name="actualizar" value="1" style="margin:0px 5px 0px 7px;">Actualizar</button>
	 				</div>
	 				<div class="uk-container uk-text-center"> 				
		 				<button type="submit" class="uk-button uk-button-primary" name="ht" value="1" style="margin:0px 5px 0px 7px;">Habilitar a todos</button>
		 				<button type="submit" class="uk-button uk-button-danger" name="dt" value="2" style="margin:0px 5px 0px 7px;">Deshabilitar a todos</button>
	 				</div>
	 				
 			</form>
 		</div>


 	</div>
 	
 </body>
 </html>