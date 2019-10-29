<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],4)){

if(isset($_POST['car1']) && !empty($_POST['car1'])){
	$idec=iseguro($cone,$_POST['car1']);
	$ide=iseguro($cone,$_POST['per1']);

	$cec=mysqli_query($cone,"SELECT idEstadoCar FROM empleadocargo WHERE idEmpleadoCargo=$idec;");
	if($rec=mysqli_fetch_assoc($cec)){
		$ec=$rec['idEstadoCar'];
	}else{
		$rec=0;
	}
?>
	<h4 class="<?php echo $ec==1 ? 'text-aqua' : 'text-gray'; ?>"><strong><?php echo nomempleado($cone,$ide); ?></strong><small> | <?php echo cargocu($cone,$idec); ?></small></h4>
<?php

	$clic=mysqli_query($cone,"SELECT l.idLicencia, FechaIni, FechaFin, MotivoLic, Numero, Ano, Siglas FROM licencia l INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idEmpleadoCargo=$idec AND l.Estado=1 AND (tl.idTipoLic=12 OR tl.idTipoLic=13);");
	if(mysqli_num_rows($clic)>0){
?>
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>TIPO LICENCIA</th>
				<th>DESDE</th>
				<th>HASTA</th>
				<th># DÍAS</th>
				<th>DOCUMENTO</th>
			</tr>
			</thead>
			<tbody>
<?php
		$n=0;
		$nd=0;
		while ($rlic=mysqli_fetch_assoc($clic)) {
			$n++;
			$d=intervalo($rlic['FechaFin'],$rlic['FechaIni']);
?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><a href="#" data-toggle="modal" data-target="#m_detlic" onclick="detlic(<?php echo $rlic['idLicencia'] ?>)"><?php echo $rlic['MotivoLic']; ?></a></td>
				<td><?php echo fnormal($rlic['FechaIni']); ?></td>
				<td><?php echo fnormal($rlic['FechaFin']); ?></td>
				<td><?php echo $d; ?></td>
				<td><?php echo $rlic['Numero']."-".$rlic['Ano']."-".$rlic['Siglas']; ?></td>
			</tr>	
<?php
			$nd=$nd+$d;
		}
?>
			<tr>
				<td colspan="6" class="text-maroon"><strong><?php echo $n; ?> licencia(s)</strong>, haciendo un total de <strong><?php echo $nd; ?> día(s)</strong> para el cargo seleccionado.</td>
			</tr>
			</tbody>
		</table>
<?php
	}else{
		echo mensajewa("No presenta licencias sin goce registradas.");
	}
}else{
	echo mensajewa("Error: No seleccionó un cargo.");
}
}else{
  echo accrestringidoa();
}
?>