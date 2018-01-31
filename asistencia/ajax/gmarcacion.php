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
			$ce=mysqli_query($cone,"SELECT idEmpleado, NombreCom FROM enombre WHERE NumeroDoc='$cod';");
			if($re=mysqli_fetch_assoc($ce)){
				$ide=$re['idEmpleado'];
				$nom=$re['NombreCom'];
				$cm=mysqli_query($cone,"SELECT idMarcacion, Marcacion FROM marcacion WHERE idEmpleado=$ide AND (Marcacion BETWEEN '$amar' AND '$mar');");
				if($rm=mysqli_fetch_assoc($cm)){
					echo "<p class='text-center text-primary'>Ya marcó</p>";
					echo mensajewa($nom);
					echo "<h4 class='text-center text-primary'>".date("h:i:s A", strtotime($rm['Marcacion']))."</h4>";
					echo "<h6 class='text-center text-warning'>* Se consideran las marcaciones de hasta hace 15 min.</h6>";
				}else{
					$q="INSERT INTO marcacion (idEmpleado, idVigilante, Marcacion) VALUES ($ide, $idv, '$mar')";
					if(mysqli_query($cone,$q)){
						echo "<p class='text-center text-primary'>Bienvenido:</p>";
						echo mensajesu($nom);
						echo "<h4 class='text-center text-primary'>".date("h:i:s A", strtotime($mar))."</h4>";
					}
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Error: El código no existe.");
			}
			mysqli_free_result($ce);
		}else{
			echo mensajeda("Error: Datos incorrectos.");
		}
	}else{
		echo mensajeda("Error: No se enviaron todos los datos.");
	}
}else{
    header('Location: index.html');
}
?>