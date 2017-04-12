<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idc=iseguro($cone,$_POST["idc"]);
	if(isset($idc) && !empty($idc)){
		$cc=mysqli_query($cone,"SELECT idEmpleado, c.Denominacion AS Cargo, Rol, Concurso, CondicionCar, idModAcceso, FechaAsu, FechaJur, FechaVen, Reemplazado, Motivo, Tipo, NumResolucion, NumContrato, e.EstadoCar FROM empleadocargo AS ec INNER JOIN cargo AS c ON ec.idCargo=c.idCargo INNER JOIN condicionlab AS cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN condicioncar AS cc ON ec.idCondicionCar=cc.idCondicionCar INNER JOIN estadocar AS e ON ec.idEstadoCar=e.idEstadoCar WHERE idEmpleadoCargo=$idc");
		$rc=mysqli_fetch_assoc($cc);
		if($rc['EstadoCar']=='ACTIVO'){
			$est="<span class='label label-success'>ACTIVO</span>";
		}elseif($rc['EstadoCar']=='RESERVADO'){
			$est="<span class='label label-warning'>RESERVADO</span>";
		}elseif($rc['EstadoCar']=='CESADO'){
			$est="<span class='label label-danger'>CESADO</span>";
		}
	?>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th colspan="<?php echo $rc['CondicionCar']=="NINGUNO" ? 4 : 2; ?>"><i class="fa fa-black-tie"></i> Cargo</th>
					<?php if($rc['CondicionCar']!='NINGUNO'){ ?>
					<th colspan="2">Condición</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="<?php echo $rc['CondicionCar']=="NINGUNO" ? 4 : 2; ?>" class="text-aqua"><h5><strong><?php echo $rc['Cargo']; ?></strong></h5></th>
					<?php if($rc['CondicionCar']!='NINGUNO'){ ?>
					<th colspan="2" class="text-red"><?php echo $rc['CondicionCar'] ?></th>
					<?php } ?>
				</tr>
				<tr>
					<th>Mod. Acceso</th>
					<?php
					$ma=$rc['idModAcceso'];
					$cma=mysqli_query($cone,"SELECT ModAcceso FROM modacceso WHERE idModAcceso=$ma");
					$rma=mysqli_fetch_assoc($cma);
					?>
					<td><?php echo $rma['ModAcceso'] ?></td>
					<?php
					mysqli_free_result($cma);
					?>
					<th>Concurso</th>
					<td><?php echo $rc['Concurso'] ?></td>
				</tr>
				<tr>
					<th>Condición laboral</th>
					<td><?php echo $rc['Tipo'] ?></td>
					<th>Rol</th>
					<td><?php echo $rc['Rol'] ?></td>
				</tr>
				<tr>
					<th>Fecha asume</th>
					<td><?php echo fnormal($rc['FechaAsu']) ?></td>
					<th>Fecha juramentación</th>
					<td><?php echo fnormal($rc['FechaJur']) ?></td>
				</tr>
				<tr>
					<th>Fecha vencimiento</th>
					<td><?php echo fnormal($rc['FechaVen']) ?></td>
				<?php
				$ree=$rc['Reemplazado'];
				if($ree==0){
					$reem='NO REEMPLAZA';
				}else{
					$cr=mysqli_query($cone,"SELECT NombreCom FROM enombre WHERE idEmpleado=$ree");
					$rr=mysqli_fetch_assoc($cr);
					$reem=$rr['NombreCom'];
				}
				?>
					<th>Reemplaza a</th>
					<td><?php echo $reem ?></td>
				</tr>
				<tr>
					<th>N° Documento</th>
					<td><?php echo $rc['NumResolucion'] ?></td>
					<th>N° Contrato</th>
					<td><?php echo $rc['NumContrato'] ?></td>
				</tr>
				<tr>
					<th>Motivo</th>
					<td><?php echo $rc['Motivo'] ?></td>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
		<?php
		$ce=mysqli_query($cone, "SELECT * FROM estadocargo ec INNER JOIN estadocar ecar ON ec.idEstadoCar=ecar.idEstadoCar WHERE idEmpleadoCargo=$idc ORDER BY idEstadoCargo ASC");
		if(mysqli_num_rows($ce)>0){
		?>
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th colspan="5"><i class="fa fa-toggle-on"></i> Estado del cargo</th>
					</tr>
					<tr>
						<th>Estado</th>
						<th>Desde</th>
						<th>Prob. Hasta</th>
						<th># Resolución</th>
						<th>Motivo</th>
					</tr>
				</thead>
				<tbody>
		<?php
			while ($re=mysqli_fetch_assoc($ce)) {
		?>
				
					<tr>
						<td><?php echo estadocar($re['EstadoCar']); ?></td>
						<td><?php echo fnormal($re['FechaIni']); ?></td>
						<td><?php echo fnormal($re['FechaFin']); ?></td>
						<td><?php echo $re['NumResolucion']; ?></td>
						<td><?php echo $re['Motivo']; ?></td>
					</tr>
				
		<?php
			}
		?>
				</tbody>
			</table>
		<?php
		}
		?>
	</div>
	<?php
		mysqli_free_result($cc);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún cargo.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>