<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuelocal"){
		if(isset($_POST['ali']) && !empty($_POST['ali']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['disubi']) && !empty($_POST['disubi'])){
			$ali=imseguro($cone,$_POST['ali']);
			$dir=imseguro($cone,$_POST['dir']);
			$urb=imseguro($cone,$_POST['urb']);
			$disubi=iseguro($cone,$_POST['disubi']);
			$tel=imseguro($cone,$_POST['tel']);
			$con=iseguro($cone,$_POST['con']);
			$pro=iseguro($cone,$_POST['pro']);
			$atot=iseguro($cone,$_POST['atot']);
			$acon=iseguro($cone,$_POST['acon']);
			$mat=iseguro($cone,$_POST['mat']);
			$npis=iseguro($cone,$_POST['npis']);
			$malq=iseguro($cone,$_POST['malq']);
			$mman=iseguro($cone,$_POST['mman']);
			$san=iseguro($cone,$_POST['san']);
			$ftsan=iseguro($cone,$_POST['ftsan'])=="" ? "0000-00-00" : fmysql(iseguro($cone,$_POST['ftsan']));
			$acons=iseguro($cone,$_POST['acons']);
			$finsp=iseguro($cone,$_POST['finsp'])=="" ? "0000-00-00" : fmysql(iseguro($cone,$_POST['finsp']));
			$upla=iseguro($cone,$_POST['upla']);
			$urea=iseguro($cone,$_POST['urea']);

			$cloc=mysqli_query($cone,"SELECT Direccion FROM local WHERE Direccion='$dir'");
			if($rloc=mysqli_fetch_assoc($cloc)){
				echo mensajewa("Error: Ya existe un local con la dirección ingresada.");
			}else{
				$sql="INSERT INTO local (Alias, Direccion, Urbanizacion, idDistrito, Telefono, idCondicionLoc, Propietario, AreaTot, AreaCons, Material, NumPisos, MonAlquiler, MonMantenimiento, Saneamiento, FecTraSaneamiento, AnoConstruccion, UsoPlanificado, UsoReal, FecInspeccion, Estado) VALUES ('$ali', '$dir', '$urb', $disubi, '$tel', $con, '$pro', $atot, $acon, '$mat', $npis, $malq, $mman, '$san', '$ftsan', '$acons', '$upla', '$urea', '$finsp', 1);";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: El local fue creado correctamente.");
				}else{
					echo mensajeda("Error: " . mysqli_error($cone));
				}
			}
			mysqli_free_result($cloc);
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>