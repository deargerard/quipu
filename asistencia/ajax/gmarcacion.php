<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
	if(isset($_POST['NomForm']) && !empty($_POST['NomForm']) && isset($_POST['cod']) && !empty($_POST['cod'])){

		function desdni($dni){
			$adni=array("X"=>0, "e"=>1, "D"=>2, "c"=>3, "R"=>4, "f"=>5, "V"=>6, "t"=>7, "G"=>8, "b"=>9);
			$dni=substr($dni,2,8);
			$arrdni=str_split($dni);
			$ndni="";
			for ($i=0; $i < 8; $i++) { 
				$ndni.=$adni[$arrdni[$i]];
			}
			return $ndni;
		}

		if($_POST['NomForm']=="marcacion"){
			$idv=$_SESSION['iden'];
			$cod=iseguro($cone,$_POST['cod']);
			$mar=@date("Y-m-d H:i:s");
			$lim1=date("Y-m-d")." 18:06:00";
			$lim2=date("Y-m-d")." 19:45:00";
			if($mar>=$lim1 && $mar<=$lim2){
				echo mensajeda("Error: <br><br>Fuera de Horario.");
				echo "<h6 class='text-center text-primary'>* No se permite registrar su marcación. Favor converse con el responsable de la asistencia.</h6>";
			}else{
				$amar=strtotime('-15 minute', strtotime($mar));
				$amar=date("Y-m-d H:i:s", $amar);
				$cod=desdni($cod);

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
								echo "<p class='text-center text-primary'>¡Registro correcto!</p>";
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
					echo mensajeda("Error: El código no existe o el personal no se encuentra activo. El afectado deberá comunicarse con el responsable de la asistencia.");
				}
				mysqli_free_result($ce);
			}
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