<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],9) || escoordinador($cone,$_SESSION['identi'])){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_provacaciones"){
		if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['peva']) && !empty($_POST['peva']) && isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac'])){
			$peva=iseguro($cone,$_POST['peva']);
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));
			$idec=iseguro($cone,$_POST['idec']);

			$cvs=mysqli_query($cone, "SELECT idProVacaciones FROM provacaciones WHERE idEmpleadoCargo=$idec AND Estado=6 AND (('$inivac' BETWEEN FechaIni AND FechaFin) OR ('$finvac' BETWEEN FechaIni AND FechaFin));");
			if(mysqli_num_rows($cvs)>0){
				echo mensajewa("No, no, no. Estas incluyendo días que ya programaste.<br>Vuelve a intentarlo.");
			}else{
				$sql="INSERT INTO provacaciones (idEmpleadoCargo, idPeriodoVacacional, FechaIni, FechaFin, Condicion, Estado) VALUES ($idec, $peva, '$inivac', '$finvac', 1, 6)";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: se guardó correctamente la programación");
				}else{
					echo mensajeda("Error: No se pudo guardar la programación. ".mysqli_error($cone));
				}
			}
			mysqli_free_result($cvs);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}

	}
	mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
