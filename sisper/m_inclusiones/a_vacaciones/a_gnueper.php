<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nperiodo"){
		if(isset($_POST['atrab']) && !empty($_POST['atrab'])){
			$atrab=imseguro($cone,$_POST['atrab']);
			$aejec= $atrab+1;
			$pervac= $atrab." - ".$aejec;
			$cpv=mysqli_query($cone,"SELECT PeriodoVacacional FROM periodovacacional WHERE PeriodoVacacional='$pervac'");
			if($rpv=mysqli_fetch_assoc($cpv)){
				echo mensajewa("Error: Ya existe el Período Vacacional.");
			}else{
				$sql="INSERT INTO periodovacacional (PeriodoVacacional, Estado) VALUES ('$pervac', 1)";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: Fue creado correctamente el Período Vacacional");
				}else{
					echo mensajewa("Error: No se pudo crear el Período Vacacional. ".mysqli_error($cone));
				}
			}
			mysqli_free_result($cpv);
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
