<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_desdependencia"){
		if(isset($_POST['iddep']) && !empty($_POST['iddep'])){
			$iddep=iseguro($cone,$_POST['iddep']);
			$c=mysqli_query($cone, "SELECT Estado FROM dependencia WHERE idDependencia=$iddep");
			$r=mysqli_fetch_array($c);
			if($r['Estado']== 1){
				$sql="UPDATE dependencia SET Estado=0 WHERE idDependencia=$iddep";
				$m="desactivada";
			}else {
				$sql="UPDATE dependencia SET Estado=1 WHERE idDependencia=$iddep";
				$m="activada";
			}
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: La dependencia fue $m. </h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No se selecionó una dependencia.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>
