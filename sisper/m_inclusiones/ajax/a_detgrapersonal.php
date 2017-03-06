<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idg=iseguro($cone,$_POST["idg"]);
	if(isset($idg) && !empty($idg)){
		$cgt=mysqli_query($cone,"SELECT * FROM gradotitulo AS gt INNER JOIN nivgratit AS ngt ON gt.idNivGraTit=ngt.idNivGraTit WHERE idGradoTitulo=$idg");
		$rgt=mysqli_fetch_assoc($cgt);
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
					<td colspan="2" class="text-fuchsia"><?php echo $rgt['Denominacion'] ?></td>
				</tr>
				<tr>
					<th>Grado</th>
					<td><?php echo $rgt['NivGraTit'] ?></td>
				</tr>
				<tr>
					<th>Fecha Expedición</th>
					<td><?php echo fnormal($rgt['FechaExp']) ?></td>
				</tr>
				<tr>
					<th>Institución</th>
					<td><?php echo $rgt['Institucion'] ?></td>
				</tr>
				<?php if(!empty($rgt['NumeroDip'])){ ?>
				<tr>
					<th>Número de Diploma</th>
					<td><?php echo $rgt['NumeroDip'] ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($rgt['NumeroCol'])){ ?>
				<tr>
					<th>Número de Colegiatura</th>
					<td><?php echo $rgt['NumeroCol'] ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($rgt['FechaCol']) && $rgt['FechaCol']!='1970-01-01'){ ?>
				<tr>
					<th>Fecha Colegiatura</th>
					<td><?php echo $rgt['FechaCol'] ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cgt);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún grado y/o título.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>