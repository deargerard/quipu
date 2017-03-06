<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idca=iseguro($cone,$_POST["idca"]);
	if(isset($idca) && !empty($idca)){
		$cca=mysqli_query($cone,"SELECT * FROM capacitacion AS c INNER JOIN tipcap AS tc ON c.idTipCap=tc.idTipCap WHERE idCapacitacion=$idca");
		$rca=mysqli_fetch_assoc($cca);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Denominación</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-fuchsia"><?php echo $rca['Denominacion'] ?></td>
				</tr>
				<tr>
					<th>Tipo</th>
					<td><?php echo $rca['TipCap'] ?></td>
				</tr>
				<tr>
					<th>Institución</th>
					<td><?php echo $rca['Institucion'] ?></td>
				</tr>
				<tr>
					<th>Fecha Inicio</th>
					<td><?php echo fnormal($rca['FechaIni']) ?></td>
				</tr>
				<tr>
					<th>Fecha Fin</th>
					<td><?php echo fnormal($rca['FechaFin']) ?></td>
				</tr>
				<tr>
					<th>Duración</th>
					<td><?php echo $rca['Duracion'] ?> Horas</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cca);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna capacitación.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>