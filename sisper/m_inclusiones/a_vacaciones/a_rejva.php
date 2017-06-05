<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$pervac=$_POST["pervac"];
	$reglab=$_POST["reglab"];
	$mes=$_POST["mes"];
	$estvac=$_POST["estvac"];

	if(isset($pervac) && !empty($pervac) && isset($reglab) && !empty($reglab) && isset($mes) && isset($estvac)){

		$wpv="(";
		$wrl="(";
		//$wmes="(";
		$wev="(";

		for ($j=0; $j < count($pervac); $j++) {
			$wpv.=$j==(count($pervac)-1) ? " pv.idPeriodoVacacional=$pervac[$j])" : "pv.idPeriodoVacacional=$pervac[$j] OR ";
		}

		for ($i=0; $i < count($reglab); $i++) {
			$wrl.= $i==(count($reglab)-1) ? " ec.idCondicionLab=$reglab[$i])" : "ec.idCondicionLab=$reglab[$i] OR ";
		}

		//for ($l=0; $l < count($mes); $l++) {
			//$wmes.=$l==(count($cmes)-1) ? " pv.Condicion=$mes[$l])" : "pv.Condicion=$mes[$l] OR ";
		//}

		for ($k=0; $k < count($estvac); $k++) {
			$wev.= $k==(count($estvac)-1) ? " pv.Estado=$estvac[$k])" : "pv.Estado=$estvac[$k] OR ";
		}


			$c="SELECT e.NumeroDoc, e.idEmpleado, c.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional WHERE date_format(pv.FechaIni,'%m')=$mes AND cd.Oficial=1 AND $wrl AND $wpv AND $wev";
			//echo $c;
			$cpv=mysqli_query($cone,$c);
			if (mysqli_num_rows($cpv)>0) {
		?>
		<hr>
		<table id="dtdir" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					  <thead>
							<tr>
								<th style="font-size:12px;">CÓDIGO</th>
								<th style="font-size:12px;">APELLIDOS Y NOMBRES</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">DEPENDENCIA</th>
								<th style="font-size:12px;">RÉGIMEN</th>
								<th style="font-size:12px;">ALTA</th>
								<th style="font-size:12px;">PERIODO</th>
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
						<tr> <!--Fila de vacaciones-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo substr($rpc['Tipo'],-8); ?></td> <!--columna REGIMEN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaVac'])?></td> <!--columna ALTA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['PeriodoVacacional']?></td> <!--columna PERIODO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
							<td style="font-size:11px;" class="<?php echo $con?>"><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->

						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
			<table class="table table-hover table-bordered"> <!--Datos relacionados a los dias de vacaciones-->
			  <tr>
				<?php
					if ($tot==1){
				?>
						<td class="text-blue"> <?php echo $tot ?> Registro encontrado.</td>
				<?php
					}else{
					?>
						<td class="text-blue"> <?php echo $tot ?> Registros encontrados.</td>
					<?php
					}
					?>
			  </tr>
			</table>
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
