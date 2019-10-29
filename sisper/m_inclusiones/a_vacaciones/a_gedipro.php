<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],9) || escoordinador($cone,$_SESSION['identi'])){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ediprogramacion"){
		if(isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac'])  && isset($_POST['idvac']) && !empty($_POST['idvac'])){
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));
			$idvac=iseguro($cone,$_POST['idvac']);

			//consultamos el idempleadocargo
			$ci=mysqli_query($cone, "SELECT idEmpleadoCargo FROM provacaciones WHERE idProVacaciones=$idvac;");
			if($ri=mysqli_fetch_assoc($ci)){
				$idec=$ri['idEmpleadoCargo'];

				$cvs=mysqli_query($cone, "SELECT idProVacaciones FROM provacaciones WHERE idEmpleadoCargo=$idec AND Estado=6 AND idProVacaciones!=$idvac AND (('$inivac' BETWEEN FechaIni AND FechaFin) OR ('$finvac' BETWEEN FechaIni AND FechaFin));");
				if(mysqli_num_rows($cvs)>0){
					echo mensajewa("No, no, no. Estas incluyendo días que ya programaste.<br>Vuelve a intentarlo.");
				}else{

					$sql="UPDATE provacaciones SET FechaIni='$inivac', FechaFin='$finvac' WHERE idProVacaciones=$idvac";
					if(mysqli_query($cone,$sql)){
						echo mensajesu("Listo: Se actualizó correctamente las vacaciones");
					}else{
						echo mensajeda("Error: No se pudo actualizar las vacaciones. ".mysqli_error($cone));
					}
				}
				mysqli_free_result($cvs);

			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($ci);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
	mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
