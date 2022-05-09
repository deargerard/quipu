<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$sislab=$_POST["sislab"];
	$reglab=$_POST["reglab"];
	$pervac=$_POST["pervac"];
	$estvac=$_POST["estvac"];
	$convac=$_POST["convac"];
	if(isset($reglab) && isset($pervac) && isset($estvac) && isset($convac) && isset($sislab) && !empty($sislab)){

		$wrl="(";
		$wpv="(";
		$wev="(";
		$wcv="(";
		$wsl="(";

		for ($i=0; $i < count($reglab); $i++) {
			$wrl.= $i==(count($reglab)-1) ? " ec.idCondicionLab=$reglab[$i])" : "ec.idCondicionLab=$reglab[$i] OR ";
		}

		for ($j=0; $j < count($pervac); $j++) {
			$wpv.=$j==(count($pervac)-1) ? " pv.idPeriodoVacacional=$pervac[$j])" : "pv.idPeriodoVacacional=$pervac[$j] OR ";
		}

		for ($k=0; $k < count($estvac); $k++) {
			$wev.= $k==(count($estvac)-1) ? " pv.Estado=$estvac[$k])" : "pv.Estado=$estvac[$k] OR ";
		}

		for ($l=0; $l < count($convac); $l++) {
			$wcv.=$l==(count($convac)-1) ? " pv.Condicion=$convac[$l])" : "pv.Condicion=$convac[$l] OR ";
		}

		for ($m=0; $m < count($sislab); $m++) {
			$wsl.=$m==(count($sislab)-1) ? " sl.idSistemaLab=$sislab[$m])" : "sl.idSistemaLab=$sislab[$m] OR ";
		}

			$c="SELECT sl.idSistemaLab, e.NumeroDoc, e.idEmpleado, c.Denominacion as cargo, d.Denominacion, cl.Tipo, ec.FechaVac, pva.idPeriodoVacacional, pva.PeriodoVacacional, pv.FechaIni, pv.FechaFin, pv.Estado, pv.Condicion FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN periodovacacional pva ON pv.idPeriodoVacacional=pva.idPeriodoVacacional INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab WHERE cd.Oficial=1 AND $wrl AND $wpv AND $wev AND $wcv AND $wsl";
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
						$tot=0;
							while($rpc=mysqli_fetch_assoc($cpv)){
								$con="";
								if($rpc['Condicion']=='1'){
									$con="active";
								}else {
									$con="warning";
									}
								$dt=intervalo ($rpc['FechaFin'], $rpc['FechaIni']);
								$tot=$tot+1;
					?>
						<tr> <!--Fila de vacaciones-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['NumeroDoc']?></td> <!--columna CÓDIGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo nomempleado($cone, $rpc['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['cargo']?></td> <!--columna CARGO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['Denominacion']?></td> <!--columna DEPENDENCIA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo substr($rpc['Tipo'],0,13); ?></td> <!--columna REGIMEN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaVac'])?></td> <!--columna ALTA-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $rpc['PeriodoVacacional']?></td> <!--columna PERIODO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaIni'])?></td> <!--columna INICIO-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo fnormal($rpc['FechaFin'])?></td> <!--columna FIN-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
							<td style="font-size:11px;" class="<?php echo $con?>"><?php echo estadoVac($rpc['Estado']) ?></td> <!--columna ESTADO-->

						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
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
						text: '<i class="fa fa-print"></i>',
						titleAttr: 'Imprimir'
					}
				]
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
