<?php
session_start();
//include("../php/conexion_sp.php");
include("/var/www/html/sisper/m_inclusiones/php/conexion_sp.php");
//include("../php/funciones.php");
include("/var/www/html/sisper/m_inclusiones/php/conexion_sp.php");
	$cpla=mysqli_query($cone,"SELECT pv.idProVacaciones FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo=ec.idEmpleadoCargo where date_format (ec.FechaVac, '%m-%d')=date_format(now(),'%m-%d') AND pv.estado=4");
	while ($rpla=mysqli_fetch_assoc($cpla)) {
		$idpv=$rpla['idProVacaciones'];
		$sqlplapen="UPDATE provacaciones SET Estado = 0 WHERE idProVacaciones =$idpv";
		if(mysqli_query($cone,$sqlplapen)){
			$msg= date('d/m/Y H:i:s')." -- Se actualizó el estado de PLANIFICADO a PENDIENTE de las vacaciones con id $idpv";
		}else{
			$msg=date('d/m/Y H:i:s')." -- Error: No se pudo actualizar el estado de PLANIFICADO a PENDIENTE de las vacaciones. ".mysqli_error($cone);
		}
	$archivo=fopen("/var/www/html/sisper/logs/log_cambio_estado.txt", "a") or die("Problemas al crear");
	//$archivo=fopen("../../logs/log_cambio_estado.txt", "a") or die("Problemas al crear");
	fwrite($archivo,$msg);
	fwrite($archivo,"\n");
	fclose($archivo);
	}

	$ceje=mysqli_query($cone,"SELECT idProVacaciones FROM provacaciones where date_add(date_format (FechaFin, '%Y-%m-%d'), interval 1 day)=date_format(now(),'%Y-%m-%d') AND Estado=3");
	while ($reje=mysqli_fetch_assoc($ceje)) {
		$idpv=$reje['idProVacaciones'];
		$sqleje="UPDATE provacaciones SET Estado = 1 WHERE idProVacaciones =$idpv";
		if(mysqli_query($cone,$sqleje)){
			$msg1= date('d/m/Y H:i:s')." -- Se actualizó el estado de EJECUTANDOSE A EJECUTADO de las vacaciones con id $idpv";
		}else{
			$msg1=date('d/m/Y H:i:s')." -- Error: No se pudo actualizar el estado de EJECUTANDOSE A EJECUTADO de las vacaciones. ".mysqli_error($cone);
		}
	$archivo=fopen("/var/www/html/sisper/logs/log_cambio_estado.txt", "a") or die("Problemas al crear");
	//$archivo=fopen("../../logs/log_cambio_estado.txt", "a") or die("Problemas al crear");
	fwrite($archivo,$msg1);
	fwrite($archivo,"\n");
	fclose($archivo);
	}
	mysqli_close($cone);
?>
