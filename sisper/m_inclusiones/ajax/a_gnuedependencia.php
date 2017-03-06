<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuedependencia"){
		if(isset($_POST['den']) && !empty($_POST['den']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['loc']) && !empty($_POST['loc']) && isset($_POST['disfis']) && !empty($_POST['disfis'])){
			$den=imseguro($cone,$_POST['den']);
			$sig=imseguro($cone,$_POST['sig']);
			$loc=iseguro($cone,$_POST['loc']);
			$disfis=iseguro($cone,$_POST['disfis']);
			$cdep=mysqli_query($cone,"SELECT Denominacion FROM dependencia WHERE Denominacion='$den'");
			if($rdep=mysqli_fetch_assoc($cdep)){
				echo "<h4 class='text-maroon'>Error: Ya existe una dependencia con el mismo nombre.</h4>";
			}else{
				$sql="INSERT INTO dependencia (idDistritoFiscal, idLocal, Denominacion, Siglas, Observacion, Estado) VALUES ($disfis, $loc, '$den', '$sig', 'Ninguna', 1)";
				if(mysqli_query($cone,$sql)){
					echo "<h4 class='text-olive'>Listo: La dependencia fue creada correctamente.</h4>";
				}else{
					echo "<h4 class='text-maroon'>Error: " . $sql . "<br>" . mysqli_error($cone)."</h4>";
				}
			}
			mysqli_free_result($cdep);
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>