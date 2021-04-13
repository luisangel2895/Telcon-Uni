<?php 
	include("conexion.php");

	if (!empty($_POST["actualizar"])) {
		$sql4 = "UPDATE redes_1";
		$conn->query($sql4);
	}

	if (!empty($_POST["bp"])) {
		$sql2 = "DELETE FROM redes_1 WHERE id = '".$_POST['bp']."' ";
		$conn->query($sql2);
	}
	if (!empty($_POST["btp"])) {
		$sql3 = "DELETE  FROM  redes_1";
		$conn->query($sql3);
	}

?>


<!DOCTYPE html>
 <html style="background-image:url('../media/fondo_formulario.png');">
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Visor Preguntas</title>
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
 		<div class="uk-container uk-container-center uk-text-center uk-h2  uk-margin-small-top uk-margin-small-bottom"><strong>Visor Preguntas</strong></div>
 		<div class="uk-container uk-container-center  uk-margin-small-top">
 			<form action="preguntas.php" method="post" accept-charset="utf-8">
	 			<table id="cuadro" class="display" cellspacing="0" width="90%" style="margin:auto;">
		 			<thead>
		 				<tr>
		 					<th>Id</th>
		 					<th>Pregunta</th>
		 					<th>Control</th>			
		 				</tr>
		 			</thead>
		 			<tfoot>
			            <tr>
			               	<th>Id</th>
		 					<th>Pregunta</th>
		 					<th>Control</th>
			            </tr>
			        </tfoot>
		 			<tbody>

		 			<?php 
		 				$sql = "SELECT * FROM redes_1";
						$result = $conn->query($sql);
				
						
						//$row = $result->fetch_array();//comentar cuando se descomente el while
						while($fila = $result->fetch_array()){
							

						echo '<tr>
								<td>'.$fila["id"].'</td>
								<td>'.$fila["preguntas"].'</td>
								<td class="uk-text-center"><button type="submit" name="bp" value="'.$fila["id"].'" class="uk-button uk-button-danger">Eliminar</button></td>	
							</tr>';
						}
							
		 			 ?>

		 			</tbody>
	 			</table>
	 				<div class="uk-container uk-text-center" style="margin:10px;margin-bottom:20px">
	 					<button type="submit" class="uk-button uk-button-large uk-button-success" name="actualizar" value="1" style="margin:0px 5px 0px 7px;">Actualizar</button>
	 				</div>
	 				<div class="uk-container uk-text-center"> 				
		 				<button type="submit" class="uk-button uk-button-danger" name="btp" value="1" style="margin:0px 5px 0px 7px;">Eliminar Todas</button>
	 				</div>
	 				
 			</form>
 		</div>


 	</div>
</body>
</html>