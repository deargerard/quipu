<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$sislab=$_POST["sislab"];
	$pervac=$_POST["pervac"];
	$reglab=$_POST["reglab"];
	$mesini=iseguro($cone, $_POST["mesini"]);
	$mesfin=iseguro($cone, $_POST["mesfin"]);
	$estvac=$_POST["estvac"];

	if(isset($pervac) && !empty($pervac) && isset($reglab) && !empty($reglab) && isset($mesini) && !empty($mesini) && isset($mesfin) && !empty($mesfin) && isset($estvac) && isset($sislab) && !empty($sislab)){

		$mesini=fmysql("01/".$mesini);
		$mesfin=fmysql("01/".$mesfin);
		$mesfin=strtotime('+ 1 month',strtotime ($mesfin) );
		$mesfin=date('Y-m-j', $mesfin);
		$mesfin=strtotime('- 1 day',strtotime ($mesfin) );
		$mesfin=date('Y-m-j', $mesfin);

		$wpv="(";
		$wrl="(";
		$wsl="(";
		$wev="(";

		for ($j=0; $j < count($pervac); $j++) {
			$wpv.=$j==(count($pervac)-1) ? " pv.idPeriodoVacacional=".iseguro($cone, $pervac[$j]).")" : "pv.idPeriodoVacacional=".iseguro($cone,$pervac[$j])." OR ";
		}

		for ($i=0; $i < count($reglab); $i++) {
			$wrl.= $i==(count($reglab)-1) ? " ec.idCondicionLab=$reglab[$i])" : "ec.idCondicionLab=$reglab[$i] OR ";
		}

		for ($l=0; $l < count($sislab); $l++) {
			$wsl.=$l==(count($sislab)-1) ? " sl.idSistemaLab=$sislab[$l])" : "sl.idSistemaLab=$sislab[$l] OR ";
		}

		for ($k=0; $k < count($estvac); $k++) {
			$wev.= $k==(count($estvac)-1) ? " pv.Estado=$estvac[$k])" : "pv.Estado=$estvac[$k] OR ";
		}


			$c="SELECT sl.idSistemaLab, e.NumeroDoc, e.idEmpleado, c.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion, do.Numero, do.Ano, do.Siglas FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab INNER JOIN aprvacaciones ava ON pv.idProVacaciones=ava.idProVacaciones INNER JOIN doc do ON ava.idDoc=do.idDoc WHERE (FechaIni BETWEEN '$mesini' AND '$mesfin') AND cd.Oficial=1 AND ec.idEstadoCar=1 AND $wrl AND $wpv AND $wev AND $wsl";
			//echo $c." -- ".$mesini." -- ".$mesfin;

			$cpv=mysqli_query($cone,$c);
			if (mysqli_num_rows($cpv)>0) {
		?>
		<hr>
		<table id="dtejva" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					  <thead>
							<tr>
								<th style="font-size:12px;">DNI</th>
								<th style="font-size:12px;">EMPLEADO</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">DEPENDENCIA</th>
								<th style="font-size:12px;">RÉGIMEN</th>
								<th style="font-size:12px;">ALTA</th>
								<th style="font-size:12px;">PERIODO</th>
			          			<th style="font-size:12px;">INICIA</th>
								<th style="font-size:12px;">TERMINA</th>
								<th style="font-size:12px;">DIAS</th>
								<th style="font-size:12px;"">DOCUMENTO</th>
			          			<th style="font-size:12px;">ESTADO</th>

							</tr>
						</thead>
				<tbody>
					<?php
						$est="";
						$cap="";
						//$tot=0;
							while($rpc=mysqli_fetch_assoc($cpv)){
								$dt=intervalo ($rpc['FechaFin'], $rpc['FechaIni']);
								if ($rpc['Estado']=='0') {
									$est="info";
									$cap="Pendiente";
									//$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
								}elseif($rpc['Estado']=='1') {
									$est="success";
									$cap="Ejecutada";
									//$eje= intervalo($rvac['FechaFin'], $rvac['FechaIni']);
								}elseif ($rpc['Estado']=='2') {
									$est="danger";
									$cap="Cancelada";
								}elseif ($rpc['Estado']=='3'){
									$est="primary";
									$cap="Ejecutandose";
									$hoy= date('Y-m-j');
									$dt= intervalo($hoy, $rpc['FechaIni']);
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
									//$tot= $tot+1;
					?>
						<tr> <!--Fila de vacaciones-->
							<td style="font-size:9px;" class="<?php echo $con?>"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:9px;" class="<?php echo $con?>"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
							<td style="font-size:9px;" class="<?php echo $con?>"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo substr($rpc['Tipo'],0,13); ?></td> <!--columna REGIMEN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaVac'])?></td> <!--columna ALTA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['PeriodoVacacional']?></td> <!--columna PERIODO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo"<span class='hidden'>".$rpc['FechaIni']."</span> ". fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
							<td style="font-size:9px;" class="<?php echo $con?>"><?php echo $rpc['Numero']."-".$rpc['Ano'].$rpc['Siglas'] ?></td>
							<td style="font-size:12px;" class="<?php echo $con?>"><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->

						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
			<script>
			$('#dtejva').DataTable({
				"order": [[7,"asc"]]
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
