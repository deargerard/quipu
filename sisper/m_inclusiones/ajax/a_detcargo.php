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
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Cargo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="2" class="text-aqua"><?php echo $rc['Cargo'] ?></th>
				</tr>
				<?php if($rc['CondicionCar']!='NINGUNO'){ ?>
				<tr>
					<th>Condición cargo</th>
					<td><?php echo $rc['CondicionCar'] ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($rc['Rol'])){ ?>
				<tr>
					<th>Rol</th>
					<td><?php echo $rc['Rol'] ?></td>
				</tr>
				<?php } ?>
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
				</tr>
				<?php if(!empty($rc['Concurso'])){ ?>
				<tr>
					<th>Concurso</th>
					<td><?php echo $rc['Concurso'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Condición laboral</th>
					<td><?php echo $rc['Tipo'] ?></td>
				</tr>
				<tr>
					<th>Fecha asume</th>
					<td><?php echo fnormal($rc['FechaAsu']) ?></td>
				</tr>
				<?php if($rc['FechaJur']!='1969-12-31'){ ?>
				<tr>
					<th>Fecha juramentación</th>
					<td><?php echo fnormal($rc['FechaJur']) ?></td>
				</tr>
				<?php } ?>
				<?php if($rc['FechaVen']!='1969-12-31'){ ?>
				<tr>
					<th>Fecha vencimiento</th>
					<td><?php echo fnormal($rc['FechaVen']) ?></td>
				</tr>
				<?php } ?>
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
				<tr>
					<th>Reemplaza a</th>
					<td><?php echo $reem ?></td>
				</tr>
				<tr>
					<th>N° Resolución</th>
					<td><?php echo $rc['NumResolucion'] ?></td>
				</tr>
				<?php if(!empty($rc['NumContrato'])){ ?>
				<tr>
					<th>N° Contrato</th>
					<td><?php echo $rc['NumContrato'] ?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($rc['Motivo'])){ ?>
				<tr>
					<th>Motivo</th>
					<td><?php echo $rc['Motivo'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
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