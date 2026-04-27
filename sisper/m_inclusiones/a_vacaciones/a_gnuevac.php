<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],3)){

		if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['peva']) && !empty($_POST['peva']) && isset($_POST['convac']) && !empty($_POST['convac']) && isset($_POST['inivac']) && !empty($_POST['inivac']) && isset($_POST['finvac']) && !empty($_POST['finvac']) && isset($_POST['doc']) && !empty($_POST['doc'])){
			$peva=iseguro($cone,$_POST['peva']);
			$inivac=fmysql(iseguro($cone,$_POST['inivac']));
			$finvac=fmysql(iseguro($cone,$_POST['finvac']));
			$doc=iseguro($cone,$_POST['doc']);
			$idec=iseguro($cone,$_POST['idec']);
			$convac=iseguro($cone,$_POST['convac']);
			$obsvac=iseguro($cone,$_POST['obsvac']);

			$convac = ($convac == "r") ? 0 : $convac; //si es reprogramado, se guarda como 0 en la base de datos

			//consultar si el empleadocargo esta activo y obtener la fecha de vacaciones
			$cv=mysqli_query($cone,"SELECT FechaVac FROM empleadocargo WHERE idEmpleadoCargo=$idec AND idEstadoCar=1");
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
					
					$sql="INSERT INTO provacaciones (idEmpleadoCargo, idPeriodoVacacional, FechaIni, FechaFin, Condicion, Estado, Observaciones) VALUES ($idec, $peva, '$inivac', '$finvac', $convac, $st, '$obsvac')";

					if(mysqli_query($cone,$sql)){
						$idpv=mysqli_insert_id($cone);
						$sqlpv="INSERT INTO aprvacaciones (idProVacaciones, Aprobado, idDoc) VALUES ($idpv, 1, $doc)";
						if(mysqli_query($cone,$sqlpv)){
							 $r['e'] = true;
							 $r['m'] = "¡Hecho! Se guardó correctamente las vacaciones";
						}else{
							 $r['m'] = mensajeda("Error: No se pudo aprobar las vacaciones. Consulte con Informática ");
						}
					}else{
						$r['m'] = mensajeda("Error: No se pudo guardar las vacaciones.");
					}
				}else{
					$r['m'] = mensajewa("Error: La fecha de inicio de vacaciones no puede ser menor a la fecha de vacaciones registrada.");
				}
			}else{
				$r['m'] = mensajeda("Error: El personal no tiene cargo activo. No se puede registrar vacaciones.");
			}
			mysqli_free_result($cv);
		}else{
			$r['m'] = mensajewa("Error: los campos marcados con * son obligatorios.");
		}
	
}else{
  $r['m'] = mensajeda("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>
