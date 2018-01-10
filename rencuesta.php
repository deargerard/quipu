<?php
    include ("ajax/a_coneenc.php");
    include ("sisper/m_inclusiones/php/funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="1000">

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
    $c="SELECT idEncuesta, Nombre FROM encuesta ORDER BY FecFin DESC;";
    $ce=mysqli_query($con,$c);
    if(mysqli_num_rows($ce)>0){
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4 class="text-maroon text-center"><strong>Ver resultados encuesta</strong></h4>
		</div>
		<div class="col-md-12">
			<form class="form-horizontal" id="rencuesta">
			  <div class="form-group">
			    <label for="enc" class="col-sm-2 control-label">Elija la encuesta</label>
			    <div class="col-sm-8">
					<select class="form-control" name="enc" id="enc">
<?php
					while($re=mysqli_fetch_assoc($ce)){
?>
					  <option value="<?php echo $re['idEncuesta']; ?>"><?php echo $re['Nombre']; ?></option>					
<?php
					}
?>
					</select>
			    </div>
			    <div class="col-sm-2">
			      <button type="submit" class="btn btn-default">Mostrar Resultados</button>
			    </div>
			  </div>
			</form>
		</div>
		<div class="col-md-12" id="resultados">
			
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
	<h1 class="text-danger text-center"><i class="fa fa-file-o"></i> No existen encuestas.</h1>
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