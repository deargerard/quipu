<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$per=iseguro($cone,$_POST["per"]);
	$estvac=$_POST["estvac"];
	$convac=$_POST["convac"];
	$pervac1=$_POST["pervac1"];
	$car=$_POST["car"];
	if(isset($per) && !empty($per) && isset($estvac) && isset($convac) && !empty($pervac1)){

		$west="(";
		$wcon="(";
		$wpv="(";

		for ($i=0; $i < count($estvac); $i++) {
			$west.= $i==(count($estvac)-1) ? " v.Estado=$estvac[$i])" : "v.Estado=$estvac[$i] OR ";
			}

		for ($j=0; $j < count($convac); $j++) {
			$wcon.=$j==(count($convac)-1) ? " v.Condicion=$convac[$j])" : "v.Condicion=$convac[$j] OR ";
		}

		for ($k=0; $k < count($pervac1); $k++) {
			$wpv.=$k==(count($pervac1)-1) ? " pv.idPeriodoVacacional=$pervac1[$k])" : "pv.idPeriodoVacacional=$pervac1[$k] OR ";
		}
	
?>
		<hr>
		<div class="row">
			<div class="col-sm-12"> <!--Nombre-->
				<p><h4 class="text-blue"><strong><i class="fa fa-user text-gray"></i> <?php echo nomempleado($cone,$per); ?> </strong></h4></p>
			</div>
		</div>
<?php
		//Obtener idEmpleadoCargo, fechas para cálculo de vacaciones del cargo activo del empleado
		$cin=mysqli_query($cone,"SELECT ec.idEstadoCar as est, ec.idEmpleadoCargo, ec.FechaVac, ec.FechaAsu, cl.Tipo, ma.ModAcceso, eca.EstadoCar, c.Denominacion AS cargo, d.Denominacion FROM empleadocargo ec INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN modacceso ma ON ec.idModAcceso=ma.idModAcceso INNER JOIN estadocar eca ON ec.idEstadoCar=eca.idEstadoCar INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE ec.idEmpleado=$per AND ec.idEstadoCar=1");
		if($rin=mysqli_fetch_assoc($cin)){
			$das=(caldiant($cone, $rin['idEmpleadoCargo'])%365);
			$nf=strtotime('+'.$das.' day',strtotime($rin['FechaAsu']));
?>
		<div class="row">
		  <div class="col-sm-1">
				<p><strong>N° Documento</strong></p>
		  </div>
		  <div class="col-sm-3"> <!--Nombre-->
				<strong>:</strong><?php echo " ".docidentidad($cone, $per) ?>
			</div>
			<div class="col-sm-1"> <!--Nombre-->
				<strong>PLANILLA</strong>
			</div>
			<div class="col-sm-3"> <!--Nombre-->
		     <strong>:</strong> <?php echo $rin['Tipo'] ?>
			</div>
			<div class="col-sm-1 text-right">
			<strong>CONDICIÓN</strong>
		  </div>
		  <div class="col-sm-3"> <!--Nombre-->
				<strong>:</strong> <?php echo $rin['ModAcceso'] ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1"> <!--Nombre-->
		    	<p><strong>INGRESO<br>VAC</strong></p>
			</div>
			<div class="col-sm-3"> <!--Nombre-->
		   		<strong>: </strong><?php echo fnormal($rin['FechaAsu'])."<br><strong>: </strong>".date('d/m/Y', $nf); ?>
			</div>
			<div class="col-sm-1"> <!--Nombre-->
		   		<strong>ESTADO</strong>
			</div>
			<div class="col-sm-3"> <!--Nombre-->
		    	<strong>: </strong><?php echo $rin['EstadoCar'] ?>
			</div>
			<div class="col-sm-1"> <!--Nombre-->
				
			</div>
			<div class="col-sm-3"> <!--Nombre-->
				
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1">
				<strong>CARGO</strong>
		  </div>
		  <div class="col-sm-3"> <!--Nombre-->
				<strong>:</strong> <?php echo $rin['cargo'] ?>
			</div>
			<div class="col-sm-1">
				<strong>DEPENDENCIA</strong>
		  </div>
		  <div class="col-sm-4"> <!--Nombre-->
				<strong>:</strong> <?php echo $rin['Denominacion'] ?>
			</div>
		</div>
		<div class="row">
		</div>
<?php
		}else{
			echo mensajewa("El personal no cuenta con cargo activo.");
		}
?>
		<hr>
		<?php
		$q="SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, d.Descripcion, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, v.Observaciones, av.idAprVacaciones, c.Denominacion AS cargo, cc.CondicionCar FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE idEmpleado = $per AND $west AND $wcon AND $wpv ORDER BY pv.PeriodoVacacional DESC, v.FechaIni DESC";
		//echo $q;
		$cvac=mysqli_query($cone,$q);

		if (mysqli_num_rows($cvac)>0) {
		?>
		<table id="dtreva" class="table table-bordered table-hover" style="font-size: 11px;"> <!--Tabla que Lista las vacaciones-->
			  <thead>
					<tr>
						<th>PERÍODO</th>
						<th>CARGO</th>
						<th>RESOLUCIÓN</th>
						<th>PROGRAMACIÓN</th>
						<th>DÍAS</th>
						<th>FECHAS</th>
	          			<th>ESTADO</th>
						<th>D. RES.</th>
					</tr>
				</thead>
		<tbody>
			<?php
			$tot=0;
					while($rvac=mysqli_fetch_assoc($cvac)){
						$dt=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
						$tot=$tot+1;
						?>
				<tr> <!--Fila de vacaciones-->
					<td><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
					<td><?php echo $rvac['cargo'].($rvac['CondicionCar']=="NINGUNO" ? "" : " (".substr($rvac['CondicionCar'],0,1).")") ?></td> <!--columna CARGO-->
					<td><?php echo $rvac['Resolucion']?> <small class="text-info">(<?php echo fnormal($rvac['FechaDoc']); ?>)</small></td> <!--columna NÚMERO DE RESOLUCIÓN-->
					<td><?php echo condicionVac($rvac['Condicion']) ?></td> <!--columna CONDICIÓN-->
					<td><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
					<td><?php echo "<span class='hidden'>".$rvac['FechaIni']."</span> ".fnormal($rvac['FechaIni'])." - ".fnormal($rvac['FechaFin']) ?></td> <!--columna FECHAS-->
					<td><?php echo estadoVac($rvac['Estado']) ?></td> <!--columna ESTADO-->
					<td>
						<?php if($rvac['Observaciones']){ ?>
						<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo $rvac['Observaciones']; ?>">Obs.</button>
						<?php } ?>
						<?php if($rvac['Descripcion']){ ?>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo $rvac['Descripcion']; ?>">Res.</button>
						<?php } ?>
						
					</td>
        </tr>
				<?php
					}
				 ?>
		</tbody>

	</table>
	<script>
	$('#dtreva').DataTable({
		"order": [[0,"desc"]]
	});
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
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
