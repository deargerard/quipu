<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['f1']) && !empty($_POST['f1']) && isset($_POST['f2']) && !empty($_POST['f2']) && isset($_POST['est'])){
	$per=iseguro($cone,$_POST['per']);
	$tlic=$_POST['tlic'];
	$f1=fmysql(iseguro($cone,$_POST['f1']));
	$f2=fmysql(iseguro($cone,$_POST['f2']));
	$est=$_POST['est'];

	$wca="(";
	for ($j=0; $j < count($est); $j++) {
		$wca.=$j==(count($est)-1) ? " li.Estado=$est[$j])" : "li.Estado=$est[$j] OR ";
	}

	$wtl="(";
	for ($l=0; $l < count($tlic); $l++) {
		$wtl.=$l==(count($tlic)-1) ? " idTipoLic=$tlic[$l])" : "idTipoLic=$tlic[$l] OR ";
	}

?>
	<h4 class="text-aqua"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?></strong></h4>

<?php
	$ql="SELECT idTipoLic, TipoLic, MotivoLic FROM tipolic WHERE $wtl;";
	$ctl=mysqli_query($cone,$ql);
	$cli=false;
	$ndt=0;
	$nlt=0;
	while($rtl=mysqli_fetch_assoc($ctl)) {
		$idtl=$rtl['idTipoLic'];

		$cc=mysqli_query($cone,"SELECT idEmpleadoCargo FROM empleadocargo WHERE idEmpleado=$per;");
		$cca=false;

		if (mysqli_num_rows($cc)>0) {
			$cca=true;

			$cw=0;
			$nw=mysqli_num_rows($cc);
			$wcargo="(";
			while ($rc=mysqli_fetch_assoc($cc)) {
				$cw++;
				$wcargo.=$cw==$nw ? "idEmpleadoCargo=".$rc['idEmpleadoCargo'].")" : "idEmpleadoCargo=".$rc['idEmpleadoCargo']." OR ";
			}
					$nl=0;
					$nc=0;
					$ndias=0;
				$cl=mysqli_query($cone,"SELECT li.idLicencia, li.FechaIni, li.FechaFin, li.Motivo, li.Estado, li.idEmpleadoCargo, do.Numero, do.Ano, do.Siglas FROM licencia li INNER JOIN aprlicencia al ON li.idLicencia=al.idLicencia INNER JOIN doc do ON al.idDoc=do.idDoc WHERE idTipoLic=$idtl AND $wcargo AND $wca AND (li.FechaIni BETWEEN '$f1' AND '$f2') ORDER BY li.FechaIni ASC;");
				if(mysqli_num_rows($cl)>0){
					$cli=true;
?>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th colspan="8" class="text-blue"><i class="fa fa-stethoscope"></i> <?php echo $rtl['MotivoLic']." (".$rtl['TipoLic'].")"; ?></th>
								</tr>
								<tr>
									<th>#</th>
									<th>CARGO</th>
									<th>MOTIVO</th>
									<th>INICIO</th>
									<th>FINAL</th>
									<th># DÍAS</th>
									<th># DOC.</th>
									<th>ESTADO</th>
								</tr>
							</thead>
							<tbody>
<?php

					while ($rl=mysqli_fetch_assoc($cl)) {
						$nl++;
						if($rl['Estado']==1){
							$ndias=$ndias+intervalo($rl['FechaFin'],$rl['FechaIni']);
						}elseif($rl['Estado']==0){
							$nc++;
						}
?>
								<tr>
									<td><?php echo $nl; ?></td>
									<td><?php echo cargoiec($cone, $rl['idEmpleadoCargo']); ?></td>
									<td><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $rl['idLicencia'] ?>)"><?php echo strlen($rl['Motivo'])>30 ? substr($rl['Motivo'],0,30)."..." : ($rl['Motivo']=="" ? "Ninguna" : $rl['Motivo']); ?></a></td>
									<td><?php echo fnormal($rl['FechaIni']); ?></td>
									<td><?php echo fnormal($rl['FechaFin']); ?></td>
									<td><?php echo intervalo($rl['FechaFin'],$rl['FechaIni']); ?></td>
									<td><?php echo $rl['Numero']."-".$rl['Ano']."-".$rl['Siglas']; ?></td>
									<td><?php echo $rl['Estado']==1 ? "<span class='label label-success'>Activo</span>" : "<span class='label label-danger'>Cancelado</span>"; ?></td>
								</tr>
<?php
					}
					$nlv=$nl-$nc
?>
								<tr>
									<td colspan="8" class="text-olive"><strong><?php echo $nlv; ?> licencia(s)</strong> con un total de <strong><?php echo $ndias; ?> día(s)</strong>.</td>
								</tr>
							</tbody>
						</table>
<?php
				}else{
					$nlv=0;
				}
		

		}
				$nlt=$nlt+$nlv;
				$ndt=$ndt+$ndias;
	}

?>

<?php
	if(!$cca){
		echo mensajewa("Error: No tiene registrado ningún cargo.");
	}else{
		if(!$cli){
			echo mensajewa("Error: No se encontró ninguna licencia para los criterios de búsqueda seleccionados.");
		}else{
?>
						<table class="table table-bordered table-hover">
							<tr>
								<td class="text-maroon"><strong><?php echo $nlt; ?> licencia(s)</strong> con un total de <strong><?php echo $ndt; ?> día(s)</strong></td>
							</tr>
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