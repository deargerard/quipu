<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idd=iseguro($cone,$_POST["idd"]);
	if(isset($idd) && !empty($idd)){
		$cmandet=mysqli_query($cone,"SELECT * FROM dependencia as d INNER JOIN local as l ON d.idLocal=l.idLocal WHERE idDependencia=$idd");
		$rmandet=mysqli_fetch_assoc($cmandet);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Dependencia</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-fuchsia"><?php echo $rmandet['Denominacion'] ?></td>
				</tr>
				<tr>
					<th>Pertenece a</th>
					<td><?php echo nomdependencia($cone, $rmandet['idDependenciaPadre']) ?></td>
				</tr>

				<tr>
					<th>Siglas</th>
					<td><?php echo $rmandet['Siglas'] ?></td>
				</tr>
				<tr>
					<th>Dirección</th>
					<td><?php echo $rmandet['Direccion'] ?></td>
				</tr>
				<?php if(!empty($rmandet['Urbanizacion'])){ ?>
				<tr>
					<th>Urbanización</th>
					<td><?php echo $rmandet['Urbanizacion'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Distrito</th>
					<td><?php echo nomdistrito($cone,$rmandet['idDistrito']) ?></td>
				</tr>
				<tr>
					<th>Distrito Fiscal</th>
					<td><?php echo nomdisfiscal($cone,$rmandet['idDistritoFiscal']) ?></td>
				</tr>
				<?php if(!empty($rmandet['Observacion'])){ ?>
				<tr>
					<th>Observación</th>
					<td><?php $rmandet['Observacion'] ?></td>
				</tr>
				<?php } ?>
				<tr>
				<?php
					if($rmandet['Estado']==1)
						$est='<span class="label label-success">Activo</span>';
					else
						$est='<span class="label label-danger">Inactivo</span>';
				?>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cmandet);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna dependencia.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>
