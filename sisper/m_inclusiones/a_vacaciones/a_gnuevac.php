<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuevacaciones"){
		if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['peva']) && !empty($_POST['peva']) && isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac']) && isset($_POST['doc']) && !empty($_POST['doc'])&& isset($_POST['st'])){
			$peva=iseguro($cone,$_POST['peva']);
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));
			$fav=fmysql(iseguro($cone,$_POST['fav']));
			$doc=iseguro($cone,$_POST['doc']);
			$idec=iseguro($cone,$_POST['idec']);
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
			//Valida la condicion.
			$cvac=mysqli_query($cone, "SELECT Condicion FROM provacaciones WHERE idPeriodoVacacional=$peva and idEmpleadoCargo=$idec AND Condicion=1");
			if ($rvac=mysqli_fetch_assoc($cvac)){
				$c=0;
				}else {
					$c=1;
				}
			//Fin validación de la condición.
				$sql="INSERT INTO provacaciones (idEmpleadoCargo, idPeriodoVacacional, FechaIni, FechaFin, Condicion, Estado) VALUES ($idec, $peva, '$inivac', '$finvac', $c, $st)";

				if(mysqli_query($cone,$sql)){
					$idpv=mysqli_insert_id($cone);
					$sqlpv="INSERT INTO aprvacaciones (idProVacaciones, Aprobado, idDoc) VALUES ($idpv, 1, '$doc')";
					if(!mysqli_query($cone,$sqlpv)){
						echo mensajeda("Error: No se pudo aprovar las vacaciones. Consulte con Informática ".mysqli_error($cone));
					}
					echo mensajesu("Listo: se guardó correctamente las vacaciones");
				}else{
					echo mensajeda("Error: No se pudo guardar las vacaciones. ".mysqli_error($cone));
				}
				mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario 1.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
