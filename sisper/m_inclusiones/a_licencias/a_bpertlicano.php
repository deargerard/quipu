<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['ano']) && !empty($_POST['ano'])){
	$per=iseguro($cone,$_POST['per']);
	$tlic=iseguro($cone,$_POST['tlic']);
	$ano=iseguro($cone,$_POST['ano']);
	$vcan=iseguro($cone,$_POST['vcan']);
	$bcan=$vcan=="c" ? "" : "AND li.Estado=1";
	$ctl=mysqli_query($cone,"SELECT TipoLic, MotivoLic FROM tipolic WHERE idTipoLic=$tlic;");
	if($rtl=mysqli_fetch_assoc($ctl)){
		$cc=mysqli_query($cone,"SELECT idEmpleadoCargo, Denominacion, Tipo, idEstadoCar, CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicionlab cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleado=$per ORDER BY idEmpleadoCargo DESC;");
		if(mysqli_num_rows($cc)>0){
			?>
			<div class="row">
				<div class="col-md-7">
					<h4 class="text-aqua"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?></strong></h4>
				</div>
				<div class="col-md-5">
					<h4 class="text-teal"><?php echo "<strong><i class='fa fa-stethoscope'></i> ".$rtl['MotivoLic']."</strong> (".$rtl['TipoLic'].")"; ?></h4>
				</div>
			</div>
			<?php
			$dat=false;
			while ($rc=mysqli_fetch_assoc($cc)) {
				$idec=$rc['idEmpleadoCargo'];
				$cond=$rc['CondicionCar']=="NINGUNO" ? "" : " (".substr($rc['CondicionCar'], 0, 1).")";

			?>

			<?php
				$c=mysqli_query($cone,"SELECT li.idLicencia, li.idTipoLic, FechaIni, FechaFin, li.Motivo, Numero, Ano, Siglas, li.Estado FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc INNER JOIN tipdoclicencia tdl ON li.idTipDocLicencia=tdl.idTipDocLicencia INNER JOIN tipolic tl ON li.idTipoLic=tl.idTipoLic INNER JOIN espmedica em ON li.idEspMedica=em.idEspMedica INNER JOIN empleadocargo ec ON li.idEmpleadoCargo=ec.idEmpleadoCargo WHERE ec.idEmpleadoCargo=$idec AND tl.idTipoLic=$tlic $bcan AND DATE_FORMAT(FechaIni,'%Y')='$ano' ORDER BY FechaIni DESC;");

				if(mysqli_num_rows($c)>0){
					$dat=true;
			?>
				<br>
				<table class="table table-hover table-bordered">
					<thead>
						<tr class="text-blue">
							<th colspan="5"><i class="fa fa-black-tie"></i> <?php echo $rc['Denominacion'].$cond; ?></th>
							<th colspan="2"><i class="fa fa-suitcase"></i> <?php echo substr($rc['Tipo'],0,9); ?></th>
						</tr>
						<tr>
							<th>#</th>
							<th>MOTIVO</th>
							<th># DOC.</th>
							<th>DESDE</th>
							<th>HASTA</th>
							<th># DÍAS</th>
							<th>ESTADO</th>
						</tr>
					</thead>
					<tbody>
			<?php

					$nd=0;
					$co=0;
					while ($r=mysqli_fetch_assoc($c)) {
						$co++;
				        $f1=$r['FechaFin'];
				        $f2=$r['FechaIni'];
				        $f1=date_create($f1);
				        $f2=date_create($f2);
				        $tie=date_diff($f1, $f2);
				        $dias=$tie->format('%a')+1;
				        if($r['Estado']==1){
				        	$nd=$nd+$dias;
				        }
					
			?>
						<tr>
							<td><?php echo $co; ?></td>
							<td><?php echo strlen($r['Motivo'])>120 ? substr($r['Motivo'],0,120)."..." : $r['Motivo']; ?></td>
							<td><?php echo $r['Numero']."-".$r['Ano']."-".$r['Siglas']; ?></td>
							<td><?php echo fnormal($r['FechaIni']); ?></td>
							<td><?php echo fnormal($r['FechaFin']); ?></td>
							<td><?php echo $dias; ?></td>
							<td><?php echo $r['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>
						</tr>
			<?php
					}
			?>
						<tr>
							<td class="text-olive" colspan="7">Total: <strong class="text-green"><?php echo $nd; ?></strong> día(s)</td>
						</tr>
					</tbody>
				</table>
			<?php
				}

			}

			if (!$dat) {
				echo mensajewa("Para el $ano, no registra licencias del tipo seleccionado.");
			}

				mysqli_free_result($c);

		}else{
			mensajewa("Error: El personal seleccionado no tiene asigando ningún cargo.");
		}
		mysqli_free_result($cc);
		mysqli_close($cone);
	}else{
		echo mensajewa("Error: No se recibieron datos válidos");
	}
}else{
	echo mensajewa("Error: Personal y año, son campos obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>