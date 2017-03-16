<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_deslocal"){
		if(isset($_POST['idlo']) && !empty($_POST['idlo'])){
			$idlo=iseguro($cone,$_POST['idlo']);
			$c=mysqli_query($cone, "SELECT Estado FROM local WHERE idLocal=$idlo");
			$r=mysqli_fetch_array($c);
			if($r['Estado']== 1){
			$sql="UPDATE local SET Estado=0 WHERE idLocal=$idlo";
			$m="desactivado";
			}else {
			$sql="UPDATE local SET Estado=1 WHERE idLocal=$idlo";
			$m="activado";
			}
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El local fue $m.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No se seleciono un local.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>
