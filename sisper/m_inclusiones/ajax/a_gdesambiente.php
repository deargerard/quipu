<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_desambiente"){
		if(isset($_POST['idamb']) && !empty($_POST['idamb'])){
			$idamb=iseguro($cone,$_POST['idamb']);
			$c=mysqli_query($cone, "SELECT Estado FROM dependencialocal WHERE idDependenciaLocal=$idamb");
			$r=mysqli_fetch_array($c);
			if($r['Estado']== 1){
			$sql="UPDATE dependencialocal SET Estado=0 WHERE idDependenciaLocal=$idamb";
			$m="desactivado";
			}else {
				$sql="UPDATE dependencialocal SET Estado=1 WHERE idDependenciaLocal=$idamb";
				$m="activado";
			}
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El Ambiente fue $m.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No se seleciono ningun Ambiente.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>
