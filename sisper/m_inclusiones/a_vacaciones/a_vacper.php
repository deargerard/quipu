<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$per=iseguro($cone,$_POST["per"]);
	$pervac=iseguro($cone,$_POST["pervac"]);
	$val=$_POST["can"];
	$idec=iseguro($cone,$_POST["car"]);
	if(isset($per) && !empty($per) && isset($pervac) && !empty($pervac)){
// Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
		for ($i=0; $i < count($val); $i++) {
			$can = $i==(count($val)-1) ? $val[$i] : $val[$i];
		}
include("a_ofechas.php");
if ($asume<=$anot) {	
?>
<div class="row">
  <div class="col-sm-2"> <!--Botón Nuevo-->
		<button id="b_nuevac" class="btn btn-info" data-toggle="modal" data-target="#m_nvacaciones" onclick="nuevac(<?php echo $idec .", ".$pervac.",".$st.",'".$av."'" ?>)">Nuevas Vacaciones</button>
	</div>
  <div class="col-sm-7"> <!--Nombre-->
		<?php
		if ($rin['idEstadoCar']==1) {
		?>
			<h4 class="text-aqua text-center"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?> </strong>| <small><i class="fa fa-black-tie"></i> <?php echo $rin['Denominacion']; ?></small></h4>
		<?php
		}else{
		 ?>
		 <h4 class="text-center"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?> </strong>| <small><i class="fa fa-black-tie"></i> <?php echo $rin['Denominacion']."  (INACTIVO)"; ?></small></h4>
		<?php
		}
		?>
	</div>
	<div class="col-sm-3"> <!--Nombre-->
    <h6 class="text-red" style="margin-bottom: 2px; text-align:right"> ALTA DEL TRABAJADOR: <?php echo fnormal($rin['FechaAsu'])?></h6>
		<h6 class="text-red" style="margin-top: 2px; text-align:right"> CÁLCULO DE VACACIONES: <?php echo date('d/m/Y', $nf)?></h6>
	</div>
</div>
<br>
<?php
$num=1;
$tot=0;
		if($can=="2"){
			$cvac=mysqli_query($cone,"SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE v.idEmpleadoCargo = $rin[idEmpleadoCargo] AND v.idPeriodoVacacional=$pervac" );
		}else{
				$cvac=mysqli_query($cone,"SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo WHERE v.idEmpleadoCargo = $rin[idEmpleadoCargo] AND v.idPeriodoVacacional=$pervac AND v.Estado!=2");
				}
		//se obtine el periodo seleccionado
		$cperi=mysqli_query($cone,"SELECT PeriodoVacacional FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
		$rperi=mysqli_fetch_assoc($cperi);
		$peri=$rperi['PeriodoVacacional'];
		// fin se obtine el periodo seleccionado
	if(mysqli_num_rows($cvac)>0){
		$est="";
		$cap="";
		$pen=0;
		$eje=0;
?>
		<table id="dtdir" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
			  <thead>
					<tr>
						<th>PERÍODO</th>
						<th>NÚMERO DE RESOLUCIÓN</th>
						<th>FECHA RES.</th>
						<th>PROGRAMACIÓN</th>
						<th>DÍAS</th>
						<th>INICIA</th>
	          <th>TERMINA</th>
	          <th>ESTADO</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
				<?php
						while($rvac=mysqli_fetch_assoc($cvac)){
							if ($rvac['Estado']=='0') {
								$est="info";
								$cap="Pendiente";
								$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
							}elseif($rvac['Estado']=='1') {
								$est="success";
								$cap="Ejecutada";
								$eje= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $eje;
							}elseif ($rvac['Estado']=='2') {
								$est="danger";
								$cap="Cancelada";
							}elseif($rvac['Estado']=='3'){
								$est="primary";
								$cap="Ejecutandose";
								$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
							}elseif($rvac['Estado']=='5'){
								$est="default";
								$cap="Suspendida";
								$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
							}else {
								$est="warning";
								$cap="Planificada";
								$pen= intervalo($rvac['FechaFin'], $rvac['FechaIni']) + $pen;
							}
							$con="";
							if($rvac['Condicion']=='1'){
								$con="PROGRAMADAS";
								}else {
											$con="REPROGRAMADAS";
											}
							$dt=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
							?>
				<tr> <!--Fila de vacaciones-->
					<td><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
					<td><?php echo $rvac['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
					<td><?php echo fnormal($rvac['FechaDoc'])?></td> <!--columna FECHA DOCUMENTO-->
					<td><?php echo $con ?></td> <!--columna CONDICIÓN-->
					<td><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
					<td><?php echo fnormal($rvac['FechaIni'])?></td> <!--columna INICIO-->
					<td><?php echo fnormal($rvac['FechaFin'])?></td> <!--columna FIN-->
					<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
          <td> <!--columna ACCIÓN-->
					<?php
					$falta = intervalo($rvac['FechaIni'],$hoy)-1;
					$perm = 0;
						if ($rvac['Estado']=='0'|| $rvac['Estado']=='4'){
							if ($falta>16) {
							$perm=1;
							}
						}
						?>
						<div class="btn-group">  <!--menu desplegable-->
              <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-cog"></i>&nbsp;
                <span class="caret"></span>
                <span class="sr-only">Desplegar menú</span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#" data-toggle="modal" data-target="#m_evacaciones" onclick="edivac(<?php echo $perm.",". $rvac['idProVacaciones'].",".$rvac['idAprVacaciones'].",'".$av."'"?>)">Editar </a></li>
								<?php
								if ($rvac['Estado']!='2'){
								?>
									<li><a href="#" data-toggle="modal" data-target="#m_cvacaciones" onclick="canvac(<?php echo $perm.",". $rvac['idProVacaciones']?>)">Cancelar</a></li>
								<?php
								}
								?>
              </ul>
            </div>

          </td> <!--/columna ACCIÓN-->
				</tr>
				<?php
				$peri=$rvac['PeriodoVacacional'];  //se obtiene el ultimo período
				}
				$re="reprogramar ";
				}else{
				?>
				<tr>
					<?php
				 		mensajewa("El trabajador no tiene vacaciones para el período $peri.");
					?>
				</tr>
				<?php
				$re="programar ";
				}
					$tot=(30*$num)-($pen+$eje); //Calculo de días de vacaciones pendientes de programar
					mysqli_free_result($cvac);
				?>
		</tbody>
		<script>
		var tot= parseInt(<?php echo $tot ?>);
		var int= parseInt(<?php intervalo($fff, $hoy) ?>);
		if (tot==0 || int<=15) {
			$("#b_nuevac").hide();
		}
		</script>
	</table>
		<table class="table table-hover table-bordered"> <!--Datos relacionados a los dias de vacaciones-->
			<tr>
				<input type="hidden" name="df" id="df" value="<?php echo $tot ?>">
			<?php
			if ($tot!=0){
				if ($tot<0){
					?>
					<td class="text-red">El trabajador(a) ha excedido en <?php echo abs($tot) ?> día(s) al <?php echo $re ?> las vacaciones para el período <?php echo $peri ?>.</td>
					<?php
				}else{
					?>
					<td class="text-red">El trabajador(a) tiene <?php echo $tot ?> días de vacaciones pendientes de <?php echo $re ?> en el período <?php echo $peri ?>.</td>
					<?php
				}
			}elseif ($falta<15){
				if ($falta==1) {
					?>
					<td class="text-success">Mañana iniciarán las vacaciones del período <?php echo $peri ?>.</td>
					<?php
				}elseif ($falta==0){
					?>
					<td class="text-success">El trabajador(a) esta ejecutando sus vacaciones del período <?php echo $peri ?>.</td>
					<?php
				}elseif ($falta>0) {
					?>
					<td class="text-success">En <?php echo $falta?> días iniciarán las vacaciones del período <?php echo $peri ?>.</td>
					<?php
				}
			}

			?>
			</tr>
	</table>
	<?php
		mysqli_close($cone);
}else{
	echo mensajewa("Al trabajador ".nomempleado($cone,$per)." no le corresponde programar vacaciones en el periodo ".$rpv['PeriodoVacacional']);
} //
	}else{
		echo mensajewa("Atención: Debe seleccionar el Trabajador y el Período Vacacional");
	}

}else{
  echo accrestringidoa();
}
?>
