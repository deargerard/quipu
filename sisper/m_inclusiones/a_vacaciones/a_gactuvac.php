<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
	$cev=mysqli_query($cone,"SELECT pv.idProVacaciones FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo where date_format (ec.FechaVac, '%m-%d')=date_format(now(),'%m-%d') AND pv.estado=4");
	while ($rev=mysqli_fetch_assoc($cev)) {
		$idpv=$rev['idProVacaciones'];
		$sql="UPDATE provacaciones SET Estado = 0 WHERE idProVacaciones =$idpv";
		if(mysqli_query($cone,$sql)){
			$msg= date('d/m/Y H:i:s')." -- Se actualizó el estado de las vacaciones con id $idpv";
		}else{
			$msg=date('d/m/Y H:i:s')." -- Error: No se pudo actualizar el estado de las vacaciones. ".mysqli_error($cone);
		}
	$archivo=fopen("../../logs/log_cambio_plan_pend.txt", "a") or die("Problemas al crear");
	fwrite($archivo,$msg);
	fwrite($archivo,"\n");
	fclose($archivo);
	}
	mysqli_close($cone);
?>
