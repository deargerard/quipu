<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idec=iseguro($cone,$_POST["idec"]);
	if(isset($idec) && !empty($idec)){
		$cec=mysqli_query($cone,"SELECT EstadoCar, FechaIni, FechaFin, NumResolucion, Motivo, ec.Estado FROM estadocargo AS ec INNER JOIN estadocar AS e ON ec.idEstadoCar=e.idEstadoCar WHERE ec.idEstadoCargo=$idec");
		$rec=mysqli_fetch_assoc($cec);
		if($rec['Estado']==1){
			$est="<span class='label label-success'>Activo</span>";
		}else{
			$est="<span class='label label-danger'>Inactivo</span>";
		}
		if($rec['EstadoCar']=='ACTIVO'){
			$estado="<span class='label label-success'>ACTIVO</span>";
		}elseif($rec['EstadoCar']=='RESERVADO'){
			$estado="<span class='label label-warning'>RESERVADO</span>";
		}elseif ($rec['EstadoCar']=='CESADO'){
			$estado="<span class='label label-danger'>CESADO</span>";
		}
?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Estado Cargo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="2" class="text-aqua"><?php echo $estado ?></th>
				</tr>
				<tr>
					<th>Inició</th>
					<td><?php echo fnormal($rec['FechaIni']) ?></td>
				</tr>
				<tr>
					<th>Finalizó</th>
					<td><?php echo fnormal($rec['FechaFin']) ?></td>
				</tr>
				<tr>
					<th>N° Resolución</th>
					<td><?php echo $rec['NumResolucion'] ?></td>
				</tr>
				<tr>
					<th>Motivo</th>
					<td><?php echo $rec['Motivo'] ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cec);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún estado de cargo.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>