<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edicoordinador"){
		if(isset($_POST['cood']) && !empty($_POST['cood']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['fecini']) && !empty($_POST['fecini'])){
			$idcoo=iseguro($cone,$_POST['idco']);
			$cood=iseguro($cone,$_POST['cood']);
			$con=iseguro($cone,$_POST['con']);
			$fecini=fmysql(iseguro($cone,$_POST['fecini']));

			$fecfin=strtotime('-1 day', strtotime($fecini));
			$fecfin=date('Y-m-d', $fecfin);

			
			$c1=mysqli_query($cone,"SELECT FecInicio, idCoordinacion FROM coordinador WHERE idCoordinador=$idcoo");
			if($r1=mysqli_fetch_assoc($c1)){
				$fa=$r1['FecInicio'];
				$fa=strtotime('-1 day', strtotime($fa));
				$fa=date('Y-m-d', $fa);
				$ca=$r1['idCoordinacion'];


					$sql="UPDATE coordinador SET FecInicio='$fecini', Condicion=$con, idEmpleado='$cood' WHERE idCoordinador=$idcoo";
					if(mysqli_query($cone, $sql)){
						echo mensajesu("Listo: Coordinación editada correctamente.");

						$c2=mysqli_query($cone,"SELECT idCoordinador FROM coordinador WHERE idCoordinacion=$ca AND FecFin='$fa'");
						if($r2=mysqli_fetch_assoc($c2)){

							$s="UPDATE coordinador SET FecFin='$fecfin' WHERE idCoordinacion=$ca AND FecFin='$fa'";
							if(mysqli_query($cone,$s)){
								echo mensajesu("Listo: Se actualizó la fecha final de la coordinación anterior");
							}else{
								echo mensajewa("Error: No se pudo actualizar la fecha fin de la coordinación anterior. Contáctese con informática.");
							}

						}else{
							echo mensajewa("Error: No se hallo la coordinación anterior");
						}
						mysqli_free_result($c2);


					}else{
						echo mensajewa("Error: " . mysqli_error($cone));
					}

			}else{
				echo mensajewa("Error: la coordinación seleccionada no existe.");
			}
			mysqli_free_result($c1);


			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>