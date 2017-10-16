<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fiscales</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php

include("../php/conexion_sp.php");
include("../php/funciones.php");

$c=mysqli_query($cone, "SELECT idEmpleado FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab WHERE idEstadocar=1 AND sl.idSistemaLab=1;");
if(mysqli_num_rows($c)>0){
?>
	<table class="table">
		<thead>
			<tr>
				<th>Foto</th>
				<th>Nombre</th>
				<th>Cargo</th>
				<th>Dependencia</th>
			</tr>
		</thead>
<?php
	while($r=mysqli_fetch_assoc($c)){
?>
		<tbody>
			<tr>
				<td><img src="../../m_fotos/<?php echo docidentidad($cone,$r['idEmpleado']); ?>.jpg" height="80"></td>
				<td><font size="-1"></font><?php echo nomempleado($cone,$r['idEmpleado']); ?></td>
				<td><?php echo cargoe($cone,$r['idEmpleado']); ?></td>
				<td><?php echo dependenciae($cone,$r['idEmpleado']); ?></td>
			</tr>
		</tbody>
<?php
	}
?>
	</table>
<?php
}


?>

</body>

</html>