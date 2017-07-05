<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['tlic']) && !empty($_POST['tlic']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['est'])){
	$per=iseguro($cone,$_POST['per']);
	$car=iseguro($cone,$_POST['car']);
	$tlic=$_POST['tlic'];
	$ano=iseguro($cone,$_POST['ano']);
	$est=$_POST['est'];

	$wca="(";
	for ($j=0; $j < count($est); $j++) {
		$wca.=$j==(count($est)-1) ? " l.Estado=$est[$j])" : "l.Estado=$est[$j] OR ";
	}

	$wtl="(";
	for ($l=0; $l < count($tlic); $l++) {
		$wtl.=$l==(count($tlic)-1) ? " idTipoLic=$tlic[$l])" : "idTipoLic=$tlic[$l] OR ";
	}

	$cc=mysqli_query($cone,"SELECT c.Denominacion, cc.CondicionCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN condicioncar cc ON ec.idCondicionCar=cc.idCondicionCar WHERE ec.idEmpleadoCargo=$car;");
	if($rc=mysqli_fetch_assoc($cc)){
		$co=$rc['CondicionCar']!="NINGUNO" ? "(".substr($rc['CondicionCar'],0,1).")" : "";
		$cargo=$rc['Denominacion']." ".$co;
	}else{
		$cargo="Error";
	}

?>
	<h4 class="text-aqua"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?></strong> | <small><i class="fa fa-black-tie"></i> <?php echo $cargo; ?></small></h4>
<?php

	$cl=mysqli_query($cone, "SELECT * FROM tipolic WHERE $wtl ORDER BY TipoLic;");
	$dt=0;
	$lt=0;
	while ($rl=mysqli_fetch_assoc($cl)){
		$tl=$rl['idTipoLic'];

		$sql="SELECT Motivo, Numero, Ano, Siglas, FechaIni, FechaFin, Estado FROM licencia l INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc WHERE idTipoLic=$tl AND DATE_FORMAT(FechaIni,'%Y')='$ano' AND idEmpleadoCargo=$car AND $wca;";
		//echo $sql;
		$clic=mysqli_query($cone,$sql);
		if(mysqli_num_rows($clic)>0){
?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="7" class="text-blue"><i class="fa  fa-stethoscope"></i> <?php echo $rl['TipoLic']." - ".$rl['MotivoLic']; ?></th>
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
			$j=0;
			$k=0;
			$nd=0;
			$nl=0;
			while ($rlic=mysqli_fetch_assoc($clic)) {
				$j++;
				$f1=$rlic['FechaFin'];
		        $f2=$rlic['FechaIni'];
		        $f1=date_create($f1);
		        $f2=date_create($f2);
		        $tie=date_diff($f1, $f2);
		        $dias=$tie->format('%a')+1;
		        if($rlic['Estado']==1){
		        	$nd=$nd+$dias;
		        }else{
		        	$k++;
		        }
?>
			<tr>
				<td><?php echo $j; ?></td>
				<td><?php echo $rlic['Motivo']; ?></td>
				<td><?php echo $rlic['Numero']."-".$rlic['Ano']."-".$rlic['Siglas']; ?></td>
				<td><?php echo fnormal($rlic['FechaIni']); ?></td>
				<td><?php echo fnormal($rlic['FechaFin']); ?></td>
				<td><?php echo $dias; ?></td>
				<td><?php echo $rlic['Estado']==0 ? "<span class='label label-danger'>Cancelada</span>" : "<span class='label label-success'>Activa</span>"; ?></td>
			</tr>
<?php
			}
			$nl=$j-$k;
?>
			<tr>
				<td colspan="7" class="text-olive"><strong><?php echo $nl; ?> Licencia(s)</strong>, haciendo un total de <strong><?php echo $nd ?> día(s) </strong></td>
			</tr>
		</tbody>
	</table>
<?php

		}else{
			$nd=0;
			$nl=0;
		}
		$dt=$dt+$nd;
		$lt=$lt+$nl;
	}

?>
	<table class="table table-bordered table-hover">
		<tr>
			<td class="text-maroon"><strong><?php echo $lt; ?> licencia(s)</strong>, haciendo un total de <strong> <?php echo $dt; ?> día(s)</strong>, para el cargo y licencias seleccionadas, correspondientes al <?php echo $ano; ?>.</td>
		</tr>
	</table>
<?php

}else{
	echo mensajewa("Error: Todos los campos son obligatorios.");
}
}else{
  echo accrestringidoa();
}
?>