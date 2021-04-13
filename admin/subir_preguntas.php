<?php 
	$m = 0 ;
	$n = 0 ;
	$p = 0 ;
	$q = 0 ;
	include("conexion.php");
	if (!empty($_POST["respuestas_correctas"])) {
			$pregunta = $_POST["pregunta"];
			$a = $_POST["a"];
			$b = $_POST["b"];
			$c = $_POST["c"];
			$d = $_POST["d"];
			$e = $_POST["e"];

			$respuestas_correctas = $_POST["respuestas_correctas"];
			$respuesta = "";
		    for ($i = 0; $i < count($respuestas_correctas) ; $i++) {
		        $respuesta .= $respuestas_correctas[$i];
		    }


		    
			 
			

		if ($_FILES['imagen']['name'] == !NULL) {
			// Recibo los datos de la imagen
			$nombre_img = $_FILES['imagen']['name'];
			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];


		
			   //indicamos los formatos que permitimos subir a nuestro servidor
			if (($_FILES["imagen"]["type"] == "image/gif")
			|| ($_FILES["imagen"]["type"] == "image/jpeg")
			|| ($_FILES["imagen"]["type"] == "image/jpg")
			|| ($_FILES["imagen"]["type"] == "image/png"))
			 {
			      
				    if ($_FILES['imagen']['size'] <= 1048576){//Si existe imagen y tiene un tamaño correcto
						 // Ruta donde se guardarán las imágenes que subamos
					      $directorio = $_SERVER['DOCUMENT_ROOT'].'../plataforma/media/preguntas/';//tener cuidado con la ruta/////////////////////////
					      // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
					      move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio.$nombre_img);
					      $imagen = $nombre_img;
					 }

					else {
					   //si existe la variable pero se pasa del tamaño permitido
					   if($nombre_img == !NULL) $p = 1; 
					}

			 } 

			 else{
			     //si no cumple con el formato
			     $n = 1 ;
			 }
			 
			

		}

		else{
			$imagen = "";
		}



		if ($n == 0 && $p == 0 ) {
			$sql = "INSERT INTO redes_1 (preguntas,a,b,c,d,e,imagenes,respuestas)
					VALUES ('$pregunta','$a','$b','$c','$d','$e','$imagen','$respuesta');";
			$conn->query($sql);
			$q = 1 ;
		}



	}
	else{
		$m = 1 ;
	}

	


 ?>

 <script type="text/javascript" charset="utf-8" async defer>

	var m = "<?php echo $m; ?>";
		if (m == 1) {
			window.alert("No ha seleccionado las respuestas");
		}
	var n = "<?php echo $n; ?>";
		if (n == 1) {
			window.alert("El formato de la imagen no es valido");
		}
	var p = "<?php echo $p; ?>";
		if (p == 1) {
			window.alert("La imagen es demasiado grande");
		}
	var q = "<?php echo $q; ?>";
		if (q == 1) {
			window.alert("La pregunta fue enviada correctamente");
		}
		 	
		 

</script>

<!DOCTYPE html>
<html style="background-image:url('../media/fondo_formulario.png');">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Formulario de entrada</title>
	<link rel="stylesheet" href="../css/uikit.css">
	<link rel="stylesheet" type="text/css" href="../css/uikit.gradient.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/uikit.min.js" type="text/javascript" charset="utf-8" async defer></script>
</head>

<body>
	<!--<div class="uk-container uk-container-center" style=" position:fixed; z-index:5; top:0px;background-image:url('media/fondo_formulario.png');"> con esto se esconde el error :/)-->
	<div class="uk-container uk-container-center">
		<div class="uk-grid">
			<div class="uk-width-medium-8-10 uk-width-small-1-1 uk-container-center uk-margin-large-top">
				<div class="uk-container uk-container-center uk-text-center uk-h2 uk-margin-small-top uk-margin-small-bottom"><strong>SUBIR PREGUNTAS</strong></div>
				<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom">
					<form action="subir_preguntas.php" method="post" accept-charset="utf-8" class="uk-form" enctype="multipart/form-data">

						<div class="uk-form-row uk-margin-small-top uk-margin-small-bottom">
							<div class="uk-text-center">
								<label for="pregunta" class="uk-h4"><strong>Pregunta :</strong></label>
							</div>
							<div class="uk-text-center uk-margin-small-bottom">
								<textarea id="pregunta" name="pregunta" cols="200" rows="5" required></textarea>
							</div>
							<div class="uk-text-center uk-margin-small-top uk-margin-small-bottom">
								<label for="imagen" class="uk-h4"><strong>Subir Imagen : </strong></label><input type="file" name="imagen" id="imagen">
							</div>
						</div>
						<div class="uk-form-row uk-margin-small-top uk-margin-small-bottom uk-text-center">
							<div class="uk-text-center uk-h4 uk-margin-small-top uk-margin-small-bottom">
								<strong>Alternativas : </strong> (Maque las correctas)
							</div>
							<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom ">
								<label for="a1"><input id="a1" type="checkbox" name="respuestas_correctas[]" value="a"> a : </label><input type="text" name="a" class="uk-form-width-large" required>		
							</div>
							<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom ">
								<label for="b1"><input id="b1" type="checkbox" name="respuestas_correctas[]" value="b"> b : </label><input type="text" name="b" class="uk-form-width-large" required>		
							</div>
							<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom ">
								<label for="c1"><input id="c1" type="checkbox" name="respuestas_correctas[]" value="c"> c : </label><input type="text" name="c" class="uk-form-width-large" required>		
							</div>
							<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom ">
								<label for="d1"><input id="d1" type="checkbox" name="respuestas_correctas[]" value="d"> d : </label><input type="text" name="d" class="uk-form-width-large" required>		
							</div>
							<div class="uk-container uk-container-center uk-margin-small-top uk-margin-small-bottom ">
								<label for="e1"><input id="e1" type="checkbox" name="respuestas_correctas[]" value="e"> e : </label><input type="text" name="e" class="uk-form-width-large" required>		
							</div>
						</div>
						<div class="uk-container uk-container-center uk-text-center uk-form-row uk-margin-small-top uk-margin-small-bottom">
							<button type="submit" class="uk-button uk-button-primary uk-button-large">Subir Pregunta</button>
						</div>


					</form>
				</div>
			</div>	
		</div>
	</div>
</body>
</html>