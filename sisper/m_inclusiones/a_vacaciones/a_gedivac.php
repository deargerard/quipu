<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_evacaciones"){
		if(isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac']) && isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['idvac']) && !empty($_POST['idvac']) && isset($_POST['idav']) && !empty($_POST['idav']) && isset($_POST['st']) && isset($_POST['fav']) && !empty($_POST['fav'])){
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));
			$fav=fmysql(iseguro($cone,$_POST['fav']));
			$doc=iseguro($cone,$_POST['doc']);
			$idvac=iseguro($cone,$_POST['idvac']);
			$idav=iseguro($cone,$_POST['idav']);
			$st=iseguro($cone,$_POST['st']);
			//Valida el estado.
			if($finvac<=date('Y-m-d')){
				$st=1;
			}elseif($inivac<=date('Y-m-d')){
				$st=3;
			}elseif ($inivac>date('Y-m-d')) {
				if (date('Y-m-d') < $fav) {
			    $st=4;
			  }else{
 					$st=0;
			 }
			}
			//Fin validación del estado

				$sql="UPDATE provacaciones SET FechaIni='$inivac', FechaFin='$finvac', Estado=$st WHERE idProVacaciones=$idvac";
				if(mysqli_query($cone,$sql)){
					$sqlpv="UPDATE aprvacaciones SET idDoc=$doc WHERE idAprVacaciones=$idav";
					if(!mysqli_query($cone,$sqlpv)){
						echo mensajeda("Error: No se pudo actualizar la aprobación de las vacaciones. Consulte con Informática ".mysqli_error($cone));
					}
					echo mensajesu("Listo: Se actualizó correctamente las vacaciones");
				}else{
					echo mensajeda("Error: No se pudo actualizar las vacaciones. ".mysqli_error($cone));
				}
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
