<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idco=iseguro($cone,$_POST["idco"]);
	if(isset($idco) && !empty($idco)){

		$cco=mysqli_query($cone,"SELECT * FROM coordinacion WHERE idCoordinacion=$idco");
		if($rco=mysqli_fetch_assoc($cco)){
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2" class="text-center">COORDINACIÓN</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><h4 class="text-aqua text-center"><strong><?php echo $rco['Denominacion'] ?></strong></h4></td>
				</tr>
				<tr>
					<th>Oficial</th>
					<td><?php echo $rco['Oficial'] == 1 ? Si : No ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td><?php echo estado($rco['Estado']) ?></td>
				</tr>
				<tr>
					<th colspan="2" class="text-center">COORDINADOR</th>
				</tr>
				<?php
				$c=mysqli_query($cone, "SELECT * FROM coordinador WHERE idCoordinacion=$idco AND FecFin='0000-00-00'");
				if($r=mysqli_fetch_assoc($c)){
				?>
				<tr>
					<td colspan="2" class="text-blue text-center"><?php echo nomempleado($cone, $r['idEmpleado']) ?> (<?php echo $r['Condicion'] == 1 ? "Oficial" : "Encargad@" ?>)</td>
				</tr>
				<?php
				}else{
				?>
				<tr>
					<td colspan="2" class="text-maroon text-center">Sin coordinador asignado.</td>
				</tr>
				<?php
				}
				mysqli_free_result($c);
				?>
				<tr>
					<th colspan="2" class="text-center">DEPENDENCIAS</th>
				</tr>
				<?php
				$c=mysqli_query($cone,"SELECT Denominacion FROM dependencia WHERE idCoordinacion=$idco");
				if(mysqli_num_rows($c)>0){
					while($r=mysqli_fetch_assoc($c)){
				?>
				<tr>
					<td colspan="2" class="text-blue text-center"><?php echo $r['Denominacion']; ?></td>
				</tr>
				<?php
					}
				}else{
				?>
				<tr>
					<td colspan="2" class="text-maroon text-center">Sin dependencias asignadas.</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
		}else{
			echo mensajewa("Error: No se encontró ningún registro con los datos enviados.");
		}
		mysqli_free_result($cco);
		mysqli_close($cone);
	}else{
		echo mensajewa("Error: No se seleccionó ninguna coordinación");
	}
}else{
  echo accrestringidoa();
}
?>
