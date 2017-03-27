<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idlo=iseguro($cone,$_POST["idlo"]);
	if(isset($idlo) && !empty($idlo)){
		$clo=mysqli_query($cone,"SELECT * FROM local l INNER JOIN condicionloc cl on l.idCondicionLoc=cl.idCondicionLoc WHERE idLocal=$idlo");
		$rlo=mysqli_fetch_assoc($clo);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="3"><strong><h4><?php echo $rlo['Alias'] ?></strong></h5></th>
					<td ><strong><?php echo $rlo['CondicionLocal'] ?></strong></td>
				</tr>
				<?php if(!empty($rlo['Propietario']) && $rlo['idCondicionLoc']==2){?>
				<tr>
					<th>Propietario</th>
					<td><?php echo $rlo['Propietario'] ?></td>
				</tr>
				<?php } ?>
			</thead>
			<tbody>
				<tr>
					<td colspan="3" class="text-aqua"><h4><strong><?php echo $rlo['Direccion'] ?></strong></h4></td>
					<?php
					if($rlo['Estado']==1)
						$est='<span class="label label-success">Activo</span>';
					else
						$est='<span class="label label-danger">Inactivo</span>';
					?>
					<td><?php echo $est ?></td>
				</tr>
				<?php if(!empty($rlo['Urbanizacion'])){ ?>
				<tr>
					<?php if(!empty($rlo['Telefono'])){ ?>
					<tr>
						<th>Central Telefónica</th>
						<td><?php echo $rlo['Telefono'] ?></td>
					</tr>
					<?php } ?>
					<th>Urbanización</th>
					<td><?php echo $rlo['Urbanizacion'] ?></td>
				<?php } ?>
					<th>Distrito</th>
					<td class="text-olive"><?php echo nomdistrito($cone,$rlo['idDistrito'])?></td>
				</tr>
				<tr>
					<?php if(!empty($rlo['Material'])){ ?>
					<th>Material</th>
					<td><?php echo $rlo['Material'] ?></td>
					<?php } ?>
					<?php if(!empty($rlo['NumPisos'])){ ?>
					<th>Pisos </th>
					<td><?php echo $rlo['NumPisos'] ?></td>
					<?php } ?>
				</tr>

				<tr>
					<?php if(!empty($rlo['AreaTot'])){ ?>
					<th>Área Total (m2)</th>
					<td><?php echo $rlo['AreaTot'] ?></td>
					<?php } ?>
					<?php if(!empty($rlo['NumPisos'])){ ?>
					<th>Área Construida (m2) </th>
					<td><?php echo $rlo['AreaCons'] ?></td>
					<?php } ?>
				</tr>

				<tr>
					<?php if(!empty($rlo['MonAlquiler'])){ ?>
					<th>Alquiler (S/)</th>
					<td><?php echo $rlo['MonAlquiler'] ?></td>
					<?php } ?>
					<?php if(!empty($rlo['MonMantenimiento'])){ ?>
					<th>Mantenimiento (S/) </th>
					<td><?php echo $rlo['MonMantenimiento'] ?></td>
					<?php } ?>
				</tr>

				<tr>
					<?php if(!empty($rlo['Saneamiento'])){ ?>
					<th>Saneamiento</th>
					<?php
					if($rlo['Saneamiento']==1){?>
						<td>SANEADO</td>
					<?php } else if($rlo['Saneamiento']==2){?>
						<td>NO SANEADO</td>
					<?php } else if($rlo['Saneamiento']==3){?>
						<td>EN TRÁMITE</td>
					<th>Inició Trámite</th>
					<td><?php echo $rlo['FecTraSaneamiento'] ?></td>
					<?php }
				}?>
				</tr>
				<tr>
					<?php if(!empty($rlo['AnoConstruccion'])){ ?>
					<th>Construido en </th>
					<td><?php echo $rlo['AnoConstruccion'] ?></td>
					<?php } ?>
					<?php if(!empty($rlo['FecInspeccion'])){ ?>
					<th>Inspección INDECI</th>
					<td><?php echo $rlo['FecInspeccion'] ?></td>
					<?php } ?>
				</tr>
				<tr>
					<?php if(!empty($rlo['UsoPlanificado'])){ ?>
					<th>Se construyó para</th>
					<td><?php echo $rlo['UsoPlanificado'] ?></td>
					<?php } ?>
					<?php if(!empty($rlo['UsoReal'])){ ?>
					<th>Se usa como</th>
					<td><?php echo $rlo['UsoReal'] ?></td>
					<?php } ?>
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
