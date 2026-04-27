<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],3)){
		if(isset($_POST['idvac']) && !empty($_POST['idvac']) && isset($_POST['convac']) && !empty($_POST['convac']) && isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac']) && isset($_POST['doc']) && !empty($_POST['doc'])){
			$idvac=iseguro($cone,$_POST['idvac']);
			$convac=iseguro($cone,$_POST['convac']);
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));	
			$doc=iseguro($cone,$_POST['doc']);
			$obsvac=iseguro($cone,$_POST['obsvac']);

			//Verificamos que el personal tiene cargo activo y obtenemos el la fecha de vacaciones
			$cv=mysqli_query($cone,"SELECT idEmpleadoCargo, FechaVac FROM empleadocargo WHERE idEmpleadoCargo=(SELECT idEmpleadoCargo FROM provacaciones WHERE idProVacaciones=$idvac) AND idEstadoCar=1");
			if($rv=mysqli_fetch_assoc($cv)){
				if(strtotime($inivac)>strtotime($rv['FechaVac'])){
					
					$convac = ($convac == "r") ? 0 : $convac; //si es reprogramado, se guarda como 0 en la base de datos

					//Valida el estado.
					$st=0;
					if(strtotime(date('Y-m-d')) > strtotime($finvac)){
						$st=1;
					}elseif(strtotime(date('Y-m-d')) >= strtotime($inivac) && strtotime(date('Y-m-d')) <= strtotime($finvac)){
						$st=3;
					}elseif (strtotime(date('Y-m-d'))<strtotime($inivac)) {
						$st=4;
					}
					//Fin validación del estado

					$sql="UPDATE provacaciones SET FechaIni='$inivac', FechaFin='$finvac', Estado=$st, Condicion=$convac, Observaciones='$obsvac' WHERE idProVacaciones=$idvac";
					if(mysqli_query($cone,$sql)){
						$sqlpv="UPDATE aprvacaciones SET idDoc=$doc WHERE idProVacaciones=$idvac";
						if(mysqli_query($cone,$sqlpv)){
							$r['e']=true;
							$r['m']="¡Hecho! Se editó correctamente las vacaciones";
						}else{
							$r['m']=mensajeda("Error: No se pudo actualizar el documento. Consulte con Informática.");
						}
					}else{
						$r['m']=mensajeda("Error: No se pudo actualizar las vacaciones.");
					}
				}else{
					$r['m']=mensajewa("Error: La fecha de inicio de vacaciones no puede ser menor a la fecha de vacaciones registrada.");
				}
			}else{
				$r['m']=mensajewa("Error: Las vacaciones no pertenecen a un cargo activo. No se puede actualizar las vacaciones.");
			}
			mysqli_free_result($cv);
		}else{
			$r['m']=mensajewa("Error: Los campos marcados con * son obligatorios.");
		}
}else{
  $r['m']="Acceso restringido.";
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>
