<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["per"]) && !empty($_POST["per"]) && isset($_POST["pervac"]) && !empty($_POST["pervac"])){
		$per=iseguro($cone,$_POST["per"]);
		$pervac=iseguro($cone,$_POST["pervac"]);
		$can=iseguro($cone,$_POST["can"]);
?>
<div class="row">
	<h3 class="text-center text-primary"><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone,$per) ?></h3>
</div>
<?php
		//si no tiene cargo activo no podrá registrar vacaciones
		$reg_vacaciones=false;
		//Consultar su empleado cargo activo para validar si le corresponde vacaciones
		$cec=mysqli_query($cone, "SELECT ec.idEmpleadoCargo, ec.FechaAsu, ec.FechaVac, c.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$per AND ec.idEstadoCar=1");
		if($rec=mysqli_fetch_assoc($cec)){
			$idec=$rec['idEmpleadoCargo'];
			$das=(caldiant($cone, $idec)%365);
			//obtenemos el periodo vacacional
			$cvp=mysqli_query($cone,"SELECT PeriodoVacacional FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
			if($rvp=mysqli_fetch_assoc($cvp)){
				$periodovac=explode('-', $rvp['PeriodoVacacional']);
			}
			mysqli_free_result($cvp);
			
			if(strtotime($rec['FechaAsu']) <= strtotime(trim($periodovac[0])."-".date("m-d", strtotime($rec['FechaAsu'])))) {
				$reg_vacaciones=true;
			}
?>
	<div class="row">
		<div class="col-sm-4"> <!--Nombre-->
			<p><i class="fa fa-calendar text-maroon"></i> ALTA DEL TRABAJADOR: <?php echo fnormal($rec['FechaAsu'])?><br>
			 <i class="fa fa-calendar text-maroon"></i> CÁLCULO DE VACACIONES: <?php echo date('d/m', strtotime('+'.$das.' day', strtotime($rec['FechaVac'])))."/".trim($periodovac[1]); ?></p>
		</div>
		<div class="col-sm-4 text-center"> <!--Nombre-->
			<h4 class="text-aqua"><i class="fa fa-black-tie text-gray"></i> <?php echo $rec['Denominacion'].($rec['CondicionCar']!="NINGUNO" ? " (".substr($rec['CondicionCar'],0,1).")" : ""); ?></h4>
		</div>
		<div class="col-sm-4 text-right"> <!--Botón Nuevo-->
			<?php if($reg_vacaciones) { ?>
				<button id="b_nuevac" class="btn btn-info" data-toggle="modal" data-target="#m_nvacaciones" onclick="nuevac(<?php echo $idec.",".$pervac; ?>)"><i class="fa fa-umbrella"></i>  Registrar vacaciones</button>
			<?php
				}
			?>
		</div>
	</div>
<?php
		}else{
			echo mensajewa("Sin cargo activo.");
		}
		mysqli_free_result($cec);

		if($can=="2"){
			$cvac=mysqli_query($cone,"SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones, v.Observaciones, c.Denominacion, cc.CondicionCar, ec.idEmpleadoCargo FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado = $per AND v.idPeriodoVacacional=$pervac ORDER BY v.FechaIni ASC" );
		}else{
			$cvac=mysqli_query($cone,"SELECT v.idProVacaciones, pv.PeriodoVacacional, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, v.FechaIni, v.FechaFin, v.Estado, v.Condicion, av.idAprVacaciones, v.Observaciones, c.Denominacion, cc.CondicionCar, ec.idEmpleadoCargo FROM provacaciones as v INNER JOIN periodovacacional AS pv ON v.idPeriodoVacacional = pv.idPeriodoVacacional INNER JOIN aprvacaciones as av ON v.idProVacaciones= av.idProVacaciones INNER JOIN doc AS d ON av.idDoc=d.idDoc INNER JOIN empleadocargo AS ec ON v.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado = $per AND v.idPeriodoVacacional=$pervac AND v.Estado!=2 ORDER BY v.FechaIni ASC");
		}

		if(mysqli_num_rows($cvac)>0){
			$pen=0;
	?>
			<table id="dtdir" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
				<thead>
					<tr>
						<th>CARGO</th>
						<th>PERÍODO</th>
						<th>RESOLUCIÓN</th>
						<th>PROGRAMACIÓN</th>
						<th>DÍAS</th>
						<th>FECHAS</th>
						<th>ESTADO</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($rvac=mysqli_fetch_assoc($cvac)){
						$dt=intervalo ($rvac['FechaFin'], $rvac['FechaIni']);
						if ($idec && $rvac['Estado']!='2' && $idec==$rvac['idEmpleadoCargo']) {
							$pen= $dt + $pen;
						}
					?>
					<tr <?php echo is_null($rvac['Observaciones']) ? "" : "data-toggle='tooltip' data-placement='top' title='".$rvac['Observaciones']."'" ?>> <!--Fila de vacaciones-->
						<td><?php echo $rvac['Denominacion'].($rvac['CondicionCar']!="NINGUNO" ? " (".substr($rvac['CondicionCar'],0,1).")" : ""); ?></td> <!--columna CARGO-->
						<td><?php echo $rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
						<td><?php echo $rvac['Resolucion']." <small>(".fnormal($rvac['FechaDoc']).")</small>"?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
						<td><?php echo condicionVac($rvac['Condicion']) ?></td> <!--columna CONDICIÓN-->
						<td><?php echo $dt ?></td> <!--columna CAMTIDAD DE DIAS-->
						<td><?php echo fnormal($rvac['FechaIni']).' - '.fnormal($rvac['FechaFin']) ?></td> <!--columna FECHAS-->
						<td><?php echo estadoVac($rvac['Estado']) ?></td> <!--columna ESTADO-->
						<td> <!--columna ACCIÓN-->
							<?php
							if ($rvac['Estado']!=2 && $rvac['Estado']!=1){
							?>
							<div class="btn-group">  <!--menu desplegable-->
								<button class="btn bg-orange btn-xs dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-cog"></i>&nbsp;
									<span class="caret"></span>
									<span class="sr-only">Desplegar menú</span>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
								<?php
								if($reg_vacaciones && $rvac['idEmpleadoCargo']==$idec){
								?>
									<li>
										<a href="#" data-toggle="modal" data-target="#m_evacaciones" onclick="edivac(<?php echo $rvac['idProVacaciones'] ?>)">Editar </a>
									</li>
								<?php
								}
								?>
									<li>
										<a href="#" data-toggle="modal" data-target="#m_cvacaciones" onclick="canvac(<?php echo $rvac['idProVacaciones']?>)">Cambiar estado</a>
									</li>
								</ul>
							</div>
							<?php
							}
							?>
						</td> <!--/columna ACCIÓN-->
					</tr>
<?php	
					}
?>
				</tbody>
			</table>
<?php
		}else{
			echo mensajewa("Sin vacaciones para el período seleccionado.");
			$re="programar ";
		}
		mysqli_free_result($cvac);
		$tot=0;
		if($reg_vacaciones){
			$tot=30-$pen; //Calculo de días de vacaciones pendientes de programar
?>
				<input type="hidden" name="df" id="df" value="<?php echo $tot; ?>">
<?php
			if($tot>0){
				echo mensajein("Tiene $tot día(s) pendiente(s) por programar.");
			}elseif($tot==0){
				echo mensajein("No tiene días pendientes por programar.");
?>
				<script>
					$("#b_nuevac").addClass("hide");
				</script>
<?php
			}else{
				echo mensajeda("Tiene ".abs($tot)." día(s) programado(s) en exceso.");
?>
				<script>
					$("#b_nuevac").addClass("hide");
				</script>
<?php
			}
		}
		
?>
		<?php
		
	}else{
		echo mensajewa("Error: No selecciono el personal o el periodo vacacional");
	}
}else{
  echo accrestringidoa();
}
?>
