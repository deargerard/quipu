<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)  || accesocon($cone,$_SESSION['identi'],9)){
	$idcd=iseguro($cone,$_POST["idcd"]);
	if(isset($idcd) && !empty($idcd)){
		$ccd=mysqli_query($cone,"SELECT Denominacion, TipoDesplaza, FecInicio, FecFin, NumResolucion, Motivo, cd.Estado, Oficial FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia INNER JOIN tipodesplaza AS td ON cd.idTipoDesplaza=td.idTipoDesplaza WHERE idCarDependencia=$idcd");
		$rcd=mysqli_fetch_assoc($ccd);
		if($rcd['Estado']==1){
			$est="<span class='label label-success'>Activo</span>";
		}else{
			$est="<span class='label label-danger'>Inactivo</span>";
		}
		if($rcd['Oficial']==1){
			$ofi="<span class='label label-success'>Sí</span>";
		}else{
			$ofi="<span class='label label-danger'>No</span>";
		}
	?>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th colspan="2"><i class="fa fa-university"></i> Dependencia</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="2" class="text-aqua"><?php echo $rcd['Denominacion'] ?></th>
				</tr>
				<tr>
					<th>Tipo Desplazamiento</th>
					<td><?php echo $rcd['TipoDesplaza'] ?></td>
				</tr>
				<tr>
					<th>Inició</th>
					<td><?php echo fnormal($rcd['FecInicio']) ?></td>
				</tr>
				<tr>
					<th>Probable Fin</th>
					<td><?php echo fnormal($rcd['FecFin']) ?></td>
				</tr>
				<tr>
					<th>N° Resolución</th>
					<td><?php echo $rcd['NumResolucion'] ?></td>
				</tr>
				<tr>
					<th>Motivo</th>
					<td><?php echo $rcd['Motivo'] ?></td>
				</tr>
				<tr>
					<th>Oficial para Lima</th>
					<td><?php echo $ofi ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($ccd);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ningún desplazamiento.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>