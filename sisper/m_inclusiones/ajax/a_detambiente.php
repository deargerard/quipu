<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idamb=iseguro($cone,$_POST["idamb"]);
	if(isset($idamb) && !empty($idamb)){
		$camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, tl.Tipo, de.Denominacion, dl.idLocal, p.Piso, dl.Oficina, dl.Estado  FROM dependencialocal dl INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN dependencia de ON dl.idDependencia=de.idDependencia WHERE idDependenciaLocal=$idamb");
		$ramb=mysqli_fetch_assoc($camb);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="3" ><h4 class="text-aqua"> <strong> <?php echo $ramb['Tipo'] ?></strong></h4></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="3"><?php echo $ramb['Denominacion'] ?></th>
				</tr>
				<tr>
					<td colspan="3" ><?php echo nomlocal( $cone, $ramb['idLocal']) ?></td>
				</tr>
				<?php if(!empty($ramb['Piso'])){ ?>
				<tr>
					<th><?php echo $ramb['Piso'] ?></th>
					<th>Ambiente</th>
					<td><?php echo $ramb['Oficina'] ?></td>
				</tr>
				<?php } ?>

				<?php if(!empty($ramb['Oficina'])){ ?>

				<?php } ?>
				<tr>
					<th>Estado</th>
					<td colspan="2"><?php echo estado ($ramb['Estado']) ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($camb);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún ambiente.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>
