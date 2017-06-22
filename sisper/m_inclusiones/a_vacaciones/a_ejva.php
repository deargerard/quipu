<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$pervac=$_POST["pervac"];
	$mes=$_POST["mes"];
	$sislab=$_POST["sislab"];

	if(isset($pervac) && !empty($pervac) && isset($mes) && isset($sislab) && !empty($sislab)){

		$wpv="(";
		$wsl="(";

		for ($j=0; $j < count($pervac); $j++) {
			$wpv.=$j==(count($pervac)-1) ? " pv.idPeriodoVacacional=$pervac[$j])" : "pv.idPeriodoVacacional=$pervac[$j] OR ";
		}

		for ($m=0; $m < count($sislab); $m++) {
			$wsl.=$m==(count($sislab)-1) ? " sl.idSistemaLab=$sislab[$m])" : "sl.idSistemaLab=$sislab[$m] OR ";
		}

			$c="SELECT sl.idSistemaLab, pv.idProVacaciones, e.NumeroDoc, e.idEmpleado, c.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab WHERE date_format(pv.FechaIni,'%m/%Y')='$mes' AND cd.Oficial=1 AND pv.Estado=0 AND $wpv AND $wsl";
			//echo $c;
			$cpv=mysqli_query($cone,$c);
			if (mysqli_num_rows($cpv)>0) {
				?>
				<table id="dtvac" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
								<thead>
									<tr>
										<th style="font-size:12px;">DNI</th>
										<th style="font-size:12px;">EMPLEADO</th>
										<th style="font-size:12px;">CARGO</th>
										<th style="font-size:12px;">DEPENDENCIA</th>
										<th style="font-size:12px;">PERIODO</th>
										<th style="font-size:12px;">INICIA</th>
										<th style="font-size:12px;">TERMINA</th>
										<th style="font-size:12px;">DIAS</th>
										<th style="font-size:12px;"></th>
									</tr>
								</thead>
						<tbody>
							<?php
								$est="";
								$cap="";
								$tot=0;
									while($rpc=mysqli_fetch_assoc($cpv)){
										if ($rpc['Estado']=='0') {
											$est="info";
											$cap="Pendiente";
											//$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
										}elseif($rpc['Estado']=='1') {
											$est="success";
											$cap="Ejecutada";
											//$eje= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $eje;
										}elseif ($rpc['Estado']=='2') {
											$est="danger";
											$cap="Cancelada";
										}elseif ($rpc['Estado']=='3'){
											$est="primary";
											$cap="Ejecutandose";
										}elseif ($rpc['Estado']=='5'){
											$est="default";
											$cap="Suspendida";
										}else{
											$est="warning";
											$cap="Planificada";
										}
										$con="";
										if($rpc['Condicion']=='1'){
											$con="active";
										}else {
											$con="warning";
											}
										$dt=intervalo ($rpc['FechaFin'], $rpc['FechaIni']);
										$tot= $tot+1;
							?>
								<tr data-toggle="tooltip" title="<?php echo "Régimen: ".substr($rpc['Tipo'],0,13)." Vacaciones desde: ".fnormal($rpc['FechaVac']); ?>" data-placement="left"> <!--Fila de vacaciones-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->

									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['PeriodoVacacional']?></td> <!--columna PERIODO-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
									<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->


									<td> <!--columna ACCIÓN-->
									  <button type="button" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#m_ejvacaciones"  onclick="ejevac(<?php echo $rpc['idProVacaciones'].", '".nomempleado($cone, $rpc['idEmpleado'])."'"?>)">
											<i class="fa fa-plane"></i>
										</button>
									</td> <!--/columna ACCIÓN-->
								</tr>
								<?php
									}
								 ?>
						</tbody>
					</table>
					<script>
					$('#dtvac').DataTable({
						"order": [[5,"asc"]]
					});
					$('[data-toggle="tooltip"]').tooltip();

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
