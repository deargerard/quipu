<?php
    include ("ajax/a_coneenc.php");
    include ("sisper/m_inclusiones/php/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Encuesta - MPFN - Distrito Fiscal de Cajamarca</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="plugins/select2/select2.css" rel="stylesheet">

    <link rel="stylesheet" href="sisper/dist/css/AdminLTE.css">

    <link href="plugins/pace/pace.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php
    $hoy=date('Y-m-d');
    $c="SELECT * FROM encuesta WHERE '$hoy' BETWEEN FecInicio AND FecFin;";
    $ce=mysqli_query($con,$c);
    if($re=mysqli_fetch_assoc($ce)){
    	$ide=$re['idEncuesta'];
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="text-center text-maroon"><i class="fa fa-pie-chart"></i> ENCUESTA: <strong><?php echo $re['Nombre']; ?></strong></h1>
		</div>
		<div class="col-md-offset-1 col-md-11" id="introduccion">
			<hr style="border-bottom: 1px dashed #ff851b; margin: 0;">
			<p class="text-default text-justify"><?php echo $re['Introduccion']; ?></p>
			<hr style="border-bottom: 1px dashed #ff851b; margin: 0;">
			<br>
		</div>
		<div class="clearfix"></div>
<?php
		$cp=mysqli_query($con, "SELECT * FROM pregunta WHERE idEncuesta=$ide;");
		if(mysqli_num_rows($cp)>0){
?>
		<form id="f_encuesta" method="post">
			<input type="hidden" name="ide" value="<?php echo $ide; ?>">
<?php
			$n=0;
			while($rp=mysqli_fetch_assoc($cp)){
				$n++;
				$idp=$rp['idPregunta'];
?>
		<div class="col-md-1 text-right"><span class="text-orange"><strong><?php echo $n; ?></strong></span></div>
		<div class="col-md-11"><strong><?php echo $rp['Pregunta']; ?></strong></div>
<?php
				if($rp['TipoRespuesta']==1){
					$ca=mysqli_query($con, "SELECT * FROM alternativa WHERE idPregunta=$idp;");
					if(mysqli_num_rows($ca)>0){
?>
		<div class="col-md-offset-1 col-md-11" style="background: #FBFBFB; border-radius: 10px;">
			<div class="row">
<?php
						while($ra=mysqli_fetch_assoc($ca)){
?>
				<div class="col-sm-3">
							<label class="radio-inline"><input type="radio" name="enc_<?php echo $idp ?>" value="<?php echo $ra['Alternativa'] ?>"><?php echo $ra['Alternativa'] ?></label>
				</div>
<?php
						}
?>
			</div>
		</div>
<?php
					}else{
?>
		<div class="col-md-offset-1 col-md-11">No se hallaron alternativas.</div>
<?php
					}
					mysqli_free_result($ca);
				}elseif($rp['TipoRespuesta']==2){
?>
		<div class="col-md-offset-1 col-md-11">
			<div class="form-group">
			  <textarea class="form-control" rows="3" name="enc_<?php echo $idp ?>"></textarea>
			</div>
		</div>
<?php
				}else{
?>
		<div class="col-md-12">No eligió correctamente el tipo de respuesta.</div>
<?php
				}

			}
?>
		<div class="col-md-offset-1 col-md-11" id="e_respuesta">
			
		</div>
		<div class="col-md-offset-1 col-md-11">
			<br>
			<button class="btn bg-aqua" type="submit" id="b_eencuesta"><i class='fa fa-paper-plane'></i> Enviar Encuesta</button>
		</div>		
		</form>
<?php
		}else{
?>
		<div class="col-md-12">
			<p class="text-danger text-center"><?php echo "Aún no existen preguntas."; ?></p>
		</div>
<?php
		}
		mysqli_free_result($cp);
?>

		<div class="col-md-offset-1 col-md-11">
			<br>
			<hr style="border-bottom: 1px dashed #ff851b; margin: 0;">
			<p class="text-blue text-justify"><?php echo $re['Finalizacion']; ?></p>
			<hr style="border-bottom: 1px dashed #ff851b; margin: 0;">
		</div>
	</div>
</div>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/pace/pace.js"></script>
    <script src="plugins/select2/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="sisper/dist/js/app.min.js"></script>

    <script src="js/main.js"></script>
<?php
	}else{
?>
	<h1 class="text-danger text-center"><i class="fa fa-file-o"></i> No se encontraron encuestas activas.</h1>
<?php
	}
	mysqli_free_result($ce);
mysqli_close($con);
?>
	<footer>
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-12">
	                <p><strong>Ministerio Público - Fiscalia de la Nación - Distrito Fiscal de Cajamarca</strong></p>
	            </div>
	        </div>
	    </div>
	</footer>
</body>
</html>