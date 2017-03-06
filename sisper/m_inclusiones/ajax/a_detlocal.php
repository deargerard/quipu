<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idlo=iseguro($cone,$_POST["idlo"]);
	if(isset($idlo) && !empty($idlo)){
		$clo=mysqli_query($cone,"SELECT * FROM local WHERE idLocal=$idlo");
		$rlo=mysqli_fetch_assoc($clo);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Dirección</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-fuchsia"><?php echo $rlo['Direccion'] ?></td>
				</tr>
				<?php if(!empty($rlo['Urbanizacion'])){ ?>
				<tr>
					<th>Urbanización</th>
					<td><?php echo $rlo['Urbanizacion'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Distrito</th>
					<td><?php echo nomdistrito($cone,$rlo['idDistrito']) ?></td>
				</tr>
				<?php if(!empty($rlo['Telefono'])){ ?>
				<tr>
					<th>Teléfono</th>
					<td><?php echo $rlo['Telefono'] ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($rlo['Observacion'])){ ?>
				<tr>
					<th>Observación</th>
					<td><?php echo $rlo['Observacion'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Estado</th>
					<?php
					if($rlo['Estado']==1)
						$est='<span class="label label-success">Activo</span>';
					else
						$est='<span class="label label-danger">Inactivo</span>';
					?>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($clo);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún grado y/o título.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>