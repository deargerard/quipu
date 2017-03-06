<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
	if(isset($_POST['NomForm']) && !empty($_POST['NomForm']) && isset($_POST['idm']) && !empty($_POST['idm']) && isset($_POST['cod']) && !empty($_POST['cod'])){
		if($_POST['NomForm']=="marcacion"){
			$idv=$_SESSION['iden'];
			$idm=iseguro($cone,$_POST['idm']);
			$cod=iseguro($cone,$_POST['cod']);
			$fec=@date("Y-m-d");
			$hor=@date("H:i:s");
			//echo "<h4>La fecha: $fec, la hora: $hor, el id de marcación: $idm y el código: $cod</h4>";
			$ce=mysqli_query($cone,"SELECT idEmpleado, NombreCom, NumeroDoc FROM enombre WHERE NumeroDoc=$cod");
			if($re=mysqli_fetch_assoc($ce)){
				$ide=$re['idEmpleado'];
				$nom=$re['NombreCom'];
				$cm=mysqli_query($cone,"SELECT idMarcacion FROM marcacion WHERE Fecha='$fec' AND idTipMarcacion=$idm AND idEmpleado=$ide");
				if($rm=mysqli_fetch_assoc($cm)){
					echo mensajeda("Error: Ya marco su asistencia.");
				}else{
					$q="INSERT INTO marcacion (idEmpleado, idVigilante, idTipMarcacion, Fecha, Hora) VALUES ($ide, $idv, $idm, '$fec', '$hor')";
					if(mysqli_query($cone,$q)){
						echo "<p class='text-center'>Bienvenido:</p>";
						echo mensajesu($nom);
						echo "<p class='text-center text-info'>$hor</p>";
					}
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Error: El código es incorrecto.");
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