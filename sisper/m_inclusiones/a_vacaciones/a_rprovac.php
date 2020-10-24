<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$sislab=$_POST["sislab"];
	$reglab=$_POST["reglab"];
	$pervac=$_POST["pervac"];
	$estvac=$_POST["estvac"];
	$dep=$_POST["dep"];
	if(isset($pervac) && !empty($pervac) && isset($estvac) && !empty($estvac)){

		$wrl="";
		$wev="AND (";
		$wsl="";
		$wdep="";

		if ($dep!="t") {
			$wdep="AND d.idDependencia=$dep";
		}

		for ($k=0; $k < count($estvac); $k++) {
			$wev.= $k==(count($estvac)-1) ? " pv.Estado=$estvac[$k])" : "pv.Estado=$estvac[$k] OR ";
		}

		if(isset($reglab) && !empty($reglab)){

			$wrl="AND (";

			for ($i=0; $i < count($reglab); $i++) {
				$wrl.= $i==(count($reglab)-1) ? " ec.idCondicionLab=$reglab[$i])" : "ec.idCondicionLab=$reglab[$i] OR ";
			}

		}

		if(isset($sislab) && !empty($sislab)){

			$wsl="AND (";

			for ($m=0; $m < count($sislab); $m++) {
				$wsl.=$m==(count($sislab)-1) ? " sl.idSistemaLab=$sislab[$m])" : "sl.idSistemaLab=$sislab[$m] OR ";
			}
		}

			$c="SELECT sl.idSistemaLab, e.NumeroDoc, e.idEmpleado, ca.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab WHERE pv.idPeriodoVacacional=$pervac AND cd.Estado=1 $wrl $wev $wsl $wdep AND (d.Observacion!='e' OR sl.SistemaLab!='FISCAL');";
			//echo $c;
			$cpv=mysqli_query($cone,$c);
			if (mysqli_num_rows($cpv)>0) {
		?>
		<hr>
		<table id="dtvare" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					  <thead>
							<tr>
								<th style="font-size:12px;">DNI</th>
								<th style="font-size:12px;">EMPLEADO</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">DEPENDENCIA</th>
								<th style="font-size:12px;">FECH. VAC</th>
								<th style="font-size:12px;">DIAS</th>
			          <th style="font-size:12px;">INICIA</th>
								<th style="font-size:12px;">TERMINA</th>
			          <th style="font-size:12px;">ESTADO</th>

							</tr>
						</thead>
				<tbody>
					<?php
						$est="";
						$cap="";
						//$tot=0;
							while($rpc=mysqli_fetch_assoc($cpv)){
								if ($rpc['Estado']=='6') {
									$est="default";
									$cap="Solicitada";
								}elseif($rpc['Estado']=='7') {
									$est="purple";
									$cap="Aceptada";
								}
								$dt=intervalo ($rpc['FechaFin'], $rpc['FechaIni']);
								//$tot=$tot+1;
					?>
						<tr> <!--Fila de vacaciones-->
							<td style="font-size:11px;"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
							<td style="font-size:11px;"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:11px;"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
							<td style="font-size:11px;"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->
							<td style="font-size:11px;"><?php echo fnormal($rpc['FechaVac'])?></td> <!--columna ALTA-->
							<td style="font-size:12px;"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
							<td style="font-size:12px;"><?php echo "<span class='hidden'>".$rpc['FechaIni']."</span> ".fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
							<td style="font-size:12px;"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
							<td style="font-size:11px;"><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->

						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
			<script>
			$('#dtvare').DataTable({
				"order": [[1,"asc"]]
			});
			</script>
		<?php
	}else {
			echo mensajewa("No se encontraron resultados");
		}
		mysqli_close($cone);
}else{
		//echo mensajeda("Resultado de los que no han programado");
	$cta=mysqli_query($cone, "SELECT ec.idEmpleadoCargo, e.idEmpleado, ec.FechaVac FROM dependencia d INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN dependencia de ON cd.idDependencia=de.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo ca ON ec.idCargo=ca.idCargo INNER JOIN sistemalab sl ON ca.idSistemaLab=sl.idSistemaLab WHERE cd.Estado=1 AND ec.idEstadoCar=1 AND (de.Observacion!='e' OR sl.SistemaLab!='FISCAL') AND (ec.idCargo!=32 AND ec.idCargo!=34);");

	if (mysqli_num_rows($cta)>0) {
?>
<br>

<table id="dtvare" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
				<thead>
					<tr>
						<th style="font-size:12px;">DNI</th>
						<th style="font-size:12px;">EMPLEADO</th>
						<th style="font-size:12px;">CARGO</th>
						<th style="font-size:12px;">DEPENDENCIA</th>
						<th style="font-size:12px;">FECH. VAC</th>
						<th style="font-size:12px;">PROGRAMÓ</th>
					</tr>
				</thead>
		<tbody>
<?php
		$fal=0;
		while ($rta=mysqli_fetch_assoc($cta)) {
			$idec=$rta['idEmpleadoCargo'];
			$ide=$rta['idEmpleado'];
			$fvac=fnormal($rta['FechaVac']);
			$cpv=mysqli_query($cone,"SELECT FechaIni, FechaFin FROM  provacaciones  WHERE idEmpleadoCargo=$idec AND idPeriodoVacacional=$pervac;");

			if (mysqli_num_rows($cpv)>0) {
				$total=0;
				$n=0;
				while ($rpv=mysqli_fetch_assoc($cpv)) {
					$dias=intervalo($rpv['FechaFin'], $rpv['FechaIni']);
					$total = $total + $dias;
					$n++;
				}

			}else{
				$total=0;
				$fal++;
			}
			//$difa=30-$total;
			//if($total!=30){
				?>
									<tr> <!--Fila de vacaciones-->
										<td style="font-size:11px;"><?php echo docidentidad($cone, $ide); ?></td> <!--columna CÓDIGO-->
										<td style="font-size:11px;"><?php echo nomempleado($cone, $ide); ?></td> <!--columna APELLIDOS Y NOMBRES-->
										<td style="font-size:11px;"><?php echo cargoe($cone, $ide); ?></td> <!--columna CARGO-->
										<td style="font-size:11px;"><?php echo dependenciae($cone, $ide); ?></td> <!--columna DEPENDENCIA-->
										<td style="font-size:11px;"><?php echo $fvac; ?></td> <!--columna ALTA-->
										<td style="font-size:12px;" class="<?php echo $total!=30 ? "danger" : "success"; ?>"><?php echo $total." Días"; ?></td> <!--columna CAMTIDAD DE DIAS-->
									</tr>
				<?php
			//}

		}
?>
	</tbody>
</table>
<span class="label label-danger">Faltan <?php echo $fal; ?> personas programar sus vacaciones.</span>
<script>
$('#dtvare').DataTable({
	"order": [[1,"asc"]],
	dom: 'Bfrtip',
	buttons: [
		{
			extend: 'excel',
			text: '<i class="fa fa-file-excel-o"></i>',
			titleAttr: 'Exportar a Excel'
		},
		{
			extend: 'print',
			text: '<i class="fa fa-print></i>',
			titleAttr: 'Imprimir'
		}
	]
});

</script>
<?php
	}else {
		echo mensajewa("Atención, No existen Trabajadores Activos");
	}


	}

}else{
  echo accrestringidoa();
}
?>
