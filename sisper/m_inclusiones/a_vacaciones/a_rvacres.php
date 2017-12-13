<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$doc=iseguro($cone, $_POST["doc"]);
	if(isset($doc) && !empty($doc)){

			$c="SELECT e.idEmpleado, e.NumeroDoc, ec.FechaVac, pv.FechaIni, pv.FechaFin, pv.Estado  FROM  provacaciones pv INNER JOIN aprvacaciones apv ON pv.idProVacaciones=apv.idProVacaciones INNER JOIN empleadocargo ec ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado WHERE apv.idDoc=$doc ORDER BY e.ApellidoPat, e.ApellidoMat, e.Nombres, pv.FechaIni ASC;";
			//echo $c;
			$cva=mysqli_query($cone,$c);
			if (mysqli_num_rows($cva)>0) {
		?>
		<hr>
		<table id="dtaprovac" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					  <thead>
							<tr>
								<th style="font-size:12px;">DNI</th>
								<th style="font-size:12px;">EMPLEADO</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">DEPENDENCIA</th>
								<th style="font-size:12px;">RÉGIMEN</th>
								<th style="font-size:12px;">FECH. VAC.</th>
			          <th style="font-size:12px;">INICIA</th>
								<th style="font-size:12px;">TERMINA</th>
								<th style="font-size:12px;">DIAS</th>
			          <th style="font-size:12px;">ESTADO</th>

							</tr>
						</thead>
				<tbody>
					<?php
						$est="";
						$cap="";
						$tot=0;
							while($rva=mysqli_fetch_assoc($cva)){
								if ($rva['Estado']=='0') {
									$est="info";
									$cap="Pendiente";
									//$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
								}elseif($rva['Estado']=='1') {
									$est="success";
									$cap="Ejecutada";
									//$eje= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $eje;
								}elseif ($rva['Estado']=='2') {
									$est="danger";
									$cap="Cancelada";
								}elseif ($rva['Estado']=='3'){
									$est="primary";
									$cap="Ejecutandose";
								}elseif ($rva['Estado']=='5'){
									$est="default";
									$cap="Suspendida";
								}else{
									$est="warning";
									$cap="Planificada";
								}
								$con="";
								if($rva['Condicion']=='1'){
									$con="active";
								}else {
									$con="warning";
									}
								$dt=intervalo ($rva['FechaFin'], $rva['FechaIni']);
								$tot=$tot+1;
					?>
						<tr> <!--Fila de vacaciones-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rva['NumeroDoc']?></td> <!--columna CÓDIGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo nomempleado($cone, $rva['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo cargoe($cone, $rva['idEmpleado'])?></td> <!--columna CARGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo dependenciae($cone, $rva['idEmpleado'])?></td> <!--columna DEPENDENCIA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo condicionlabe($cone, $rva['idEmpleado'])?></td> <!--columna REGIMEN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rva['FechaVac'])?></td> <!--columna ALTA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo "<span class='hidden'>".$rva['FechaIni']."</span> ".fnormal($rva['FechaIni'])?></td> <!--columna INICIO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rva['FechaFin'])?></td> <!--columna FIN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
							<td style="font-size:11px;" class="<?php echo $con?>"><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->

						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
			<script>
			$('#dtaprovac').DataTable({
				"order": [[1,"asc"]]
			});
			</script>
		<?php
	}else {
			echo mensajewa("No se encontraron resultados");
		}
		mysqli_close($cone);
}else{
		echo mensajeda("Error: Debe seleccionar al menos un valor en cada campo");
	}

}else{
  echo accrestringidoa();
}
?>
