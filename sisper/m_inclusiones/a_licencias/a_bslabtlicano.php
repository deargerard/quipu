<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){



if(isset($_POST['slab']) && !empty($_POST['slab']) && isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['est'])){
	$slab=$_POST['slab'];
	$tlic=$_POST['tlic'];
	$ano=iseguro($cone,$_POST['ano']);
	$est=$_POST['est'];

	$wca="(";
	for ($j=0; $j < count($est); $j++) {
		$wca.=$j==(count($est)-1) ? " l.Estado=$est[$j])" : "l.Estado=$est[$j] OR ";
	}

	$wtl="(";
	for ($l=0; $l < count($tlic); $l++) {
		$wtl.=$l==(count($tlic)-1) ? " tl.idTipoLic=$tlic[$l])" : "tl.idTipoLic=$tlic[$l] OR ";
	}


	for ($i=0; $i < count($slab); $i++) { 
		$isl=$slab[$i];
		$csl=mysqli_query($cone,"SELECT SistemaLab FROM sistemalab WHERE idSistemaLab=$isl;");
		if($rsl=mysqli_fetch_assoc($csl)){
			$sislab=$rsl['SistemaLab'];
		}
		$cl=mysqli_query($cone, "SELECT c.Denominacion, cc.CondicionCar, ec.idEmpleado, tl.TipoLic, tl.Motivolic, l.idLicencia, l.FechaIni, l.FechaFin, l.Estado, d.Numero, d.Ano, d.Siglas FROM sistemalab sl INNER JOIN cargo c ON sl.idSistemaLab=c.idSistemaLab INNER JOIN empleadocargo ec ON c.idCargo=ec.idCargo INNER JOIN licencia l ON ec.idEmpleadoCargo=l.idEmpleadoCargo INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE sl.idSistemaLab=$isl AND DATE_FORMAT(l.FechaIni,'%Y')='$ano' AND $wtl AND $wca ORDER BY tl.MotivoLic, l.FechaIni ASC;");
		if(mysqli_num_rows($cl)>0){
			?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr class="text-blue">
						<th colspan="9"> <i class="fa fa-cubes"></i> <?php echo $sislab; ?></th>
					</tr>
					<tr>
						<th>#</th>
						<th>PERSONAL</th>
						<th>CARGO</th>
						<th>DEPENDENCIA</th>
						<th>T. LICENCIA</th>
						<th>DESDE</th>
						<th>HASTA</th>
						<th># DÍAS</th>
						<th># DOC</th>
						<th>ESTADO</th>
					</tr>
				</thead>
				<tbody>
					

			<?php
			$nl=0;
			$dlt=0;
			$lc=0;
			while ($rl=mysqli_fetch_assoc($cl)) {
				$nl++;
				$dl=intervalo($rl['FechaFin'],$rl['FechaIni']);
				if($rl['Estado']==1){
					$dlt=$dlt+$dl;
				}else{
					$lc++;
				}

			?>
					<tr>
						<td><?php echo $nl; ?></td>
						<td><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $rl['idLicencia'] ?>)"><?php echo nomempleado($cone, $rl['idEmpleado']); ?></a></td>
						<td><?php echo cargoxiexfecha($cone, $rl['idEmpleado'], $rl['FechaIni']); ?></td>
						<td><?php echo dependenciaxiecxfecha($cone, idecxidexfecha($cone, $rl['idEmpleado'], $rl['FechaIni']), $rl['FechaIni']); ?></td>
						<td><?php echo $rl['TipoLic']." - ".$rl['Motivolic']; ?></td>
						<td><?php echo fnormal($rl['FechaIni']); ?></td>
						<td><?php echo fnormal($rl['FechaFin']); ?></td>
						<td><?php echo $dl; ?></td>
						<td><?php echo $rl['Numero']."-".$rl['Ano']."-".$rl['Siglas']; ?></td>
						<td><?php echo $rl['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
					</tr>
			<?php
			}
			?>
					<tr>
						<td colspan="9" class="text-olive"><strong><?php echo ($nl-$lc); ?> licencia(s),</strong> haciendo un total de <strong><?php echo $dlt; ?> día(s)</strong></td>
					</tr>
				</tbody>
			</table>
			<?php
		}
	}




}else{
	echo mensajewa("Error: Todos los campos son obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>