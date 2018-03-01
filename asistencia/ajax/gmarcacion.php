<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
	if(isset($_POST['NomForm']) && !empty($_POST['NomForm']) && isset($_POST['cod']) && !empty($_POST['cod'])){
		if($_POST['NomForm']=="marcacion"){
			$idv=$_SESSION['iden'];
			$cod=iseguro($cone,$_POST['cod']);
			$mar=@date("Y-m-d H:i:s");
			$amar=strtotime('-15 minute', strtotime($mar));
			$amar=date("Y-m-d H:i:s", $amar);
			//echo "<h4>La fecha: $fec, la hora: $hor, el id de marcación: $idm y el código: $cod</h4>";
			$ce=mysqli_query($cone,"SELECT e.idEmpleado, ApellidoPat, ApellidoMat, Nombres, ec.idEmpleadoCargo FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE e.NumeroDoc='$cod' AND ec.idEstadoCar=1;");
			if($re=mysqli_fetch_assoc($ce)){
				$ide=$re['idEmpleado'];
				$nom=$re['Nombres']." ".$re['ApellidoPat']." ".$re['ApellidoMat'];
				$idec=$re['idEmpleadoCargo'];
				$cv=mysqli_query($cone, "SELECT idProVacaciones FROM provacaciones WHERE idEmpleadoCargo=$idec AND estado!=2 AND (NOW() BETWEEN FechaIni AND FechaFin);");
				if($rv=mysqli_fetch_assoc($cv)){
					echo "<h4 class='text-center text-primary'>¡Ud. está de Vacaciones!</h4>";
					echo mensajeda($nom);
					echo "<h6 class='text-center text-primary'>* No se le permitirá registrar su marcación, vaya y disfrute de sus vacaciones.</h6>";
				}else{
					$cm=mysqli_query($cone,"SELECT idMarcacion, Marcacion FROM marcacion WHERE idEmpleado=$ide AND (Marcacion BETWEEN '$amar' AND '$mar');");
					if($rm=mysqli_fetch_assoc($cm)){
						echo "<p class='text-center text-primary'>¡Ya marcó!</p>";
						echo mensajeda($nom);
						echo "<h4 class='text-center text-primary'>".date("h:i:s A", strtotime($rm['Marcacion']))."</h4>";
						echo "<h6 class='text-center text-primary'>* Se consideran las marcaciones de hace 15 minutos atras.</h6>";
					}else{
						$q="INSERT INTO marcacion (idEmpleado, idVigilante, Marcacion) VALUES ($ide, $idv, '$mar')";
						if(mysqli_query($cone,$q)){
							echo "<p class='text-center text-primary'>¡Bienvenido!</p>";
							echo mensajesu($nom);
							echo "<h3 class='text-center text-primary'>".date("h:i:s A", strtotime($mar))."</h3>";
						}else{
							echo "<p class='text-center text-danger'>Error:</p>";
							echo mensajeda($nom);
							echo "<h4 class='text-center text-primary'>No se pudo registrar su marcación.</h4>";
						}
					}
					mysqli_free_result($cm);
				}
				mysqli_free_result($cv);
			}else{
				echo mensajeda("Error: El código no existe o el personal no se encuentra activo. Estimado personal favor, llamar al 365577 anexo 1003.");
			}
			mysqli_free_result($ce);
		}else{
			echo mensajeda("Error: Formulario incorrecto.");
		}
	}else{
		echo mensajeda("Error: No se enviaron todos los datos.");
	}
}else{
    header('Location: index.html');
}
?>