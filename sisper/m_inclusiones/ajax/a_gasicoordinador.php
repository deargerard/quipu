<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_asicoordinador"){
		if(isset($_POST['coo']) && !empty($_POST['coo']) && isset($_POST['cood']) && !empty($_POST['cood']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['fecini']) && !empty($_POST['fecini'])){
			$coo=iseguro($cone,$_POST['coo']);
			$cood=iseguro($cone,$_POST['cood']);
			$con=iseguro($cone,$_POST['con']);
			$fecini=fmysql(iseguro($cone,$_POST['fecini']));

			$fecfin=strtotime('-1 day', strtotime($fecini));
			$fecfin=date('Y-m-d', $fecfin);

			$sql="INSERT INTO coordinador (FecInicio, FecFin, Condicion, idEmpleado, idCoordinacion) VALUES ('$fecini', NULL, $con, '$cood', '$coo')";
			$c=mysqli_query($cone,"SELECT idCoordinador FROM coordinador WHERE idCoordinacion=$coo AND FecFin='1969-12-31'");
			$idco=0;
			if($r=mysqli_fetch_assoc($c)){
				$idco=$r['idCoordinador'];
			}
			mysqli_free_result($c);
			if(mysqli_query($cone, $sql)){
				echo mensajesu("Listo: Coordinador asignado correctamente.");
				if($idco!=0){
					$s="UPDATE coordinador SET FecFin='$fecfin' WHERE idCoordinador=$idco";
					if(mysqli_query($cone, $s)){
						echo mensajesu("Listo: Coordinador anterior deshabilitado.");
					}else{
						echo mensajewa("Error: No se pudo deshabilitar coordinador anterior. Comuníquese con informática. ".mysqli_error($cone));
					}
				}

			}else{
				echo mensajewa("Error: " . mysqli_error($cone));
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