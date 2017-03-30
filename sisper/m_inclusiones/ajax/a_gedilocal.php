<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edilocal"){
		if(isset($_POST['ali']) && !empty($_POST['ali']) && isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['disubi']) && !empty($_POST['disubi'])){
			$idlo=imseguro($cone,$_POST['idlo']);
			$ali=imseguro($cone,$_POST['ali']);
			$dir=imseguro($cone,$_POST['dir']);
			$urb=imseguro($cone,$_POST['urb']);
			$disubi=iseguro($cone,$_POST['disubi']);
			$tel=imseguro($cone,$_POST['tel']);
			$con=iseguro($cone,$_POST['con']);
			$pro=iseguro($cone,$_POST['pro']);
			$atot=iseguro($cone,$_POST['atot'])=="" ? 0 : iseguro($cone,$_POST['atot']);
			$acon=iseguro($cone,$_POST['acon'])=="" ? 0 : iseguro($cone,$_POST['acon']);
			$mat=iseguro($cone,$_POST['mat']);
			$npis=iseguro($cone,$_POST['npis'])=="" ? 0 : iseguro($cone,$_POST['npis']);
			$malq=iseguro($cone,$_POST['malq'])=="" ? 0 : iseguro($cone,$_POST['malq']);
			$mman=iseguro($cone,$_POST['mman'])=="" ? 0 : iseguro($cone,$_POST['mman']);
			$san=iseguro($cone,$_POST['san']);
			$ftsan=fmysql(iseguro($cone,$_POST['ftsan']));
			$ftsan=$ftsan=="" ? "NULL" : "'$ftsan'";
			$acons=iseguro($cone,$_POST['acons']);
			$finsp=fmysql(iseguro($cone,$_POST['finsp']));
			$finsp=$finsp=="" ? "NULL" : "'$finsp'";
			$upla=iseguro($cone,$_POST['upla']);
			$urea=iseguro($cone,$_POST['urea']);
			$sql="UPDATE local SET Alias='$ali', Direccion='$dir', Urbanizacion='$urb', idDistrito=$disubi, Telefono='$tel', idCondicionLoc=$con, Propietario='$pro', AreaTot=$atot, AreaCons=$acon, Material='$mat', NumPisos=$npis, MonAlquiler=$malq, MonMantenimiento=$mman, Saneamiento='$san', FecTraSaneamiento=$ftsan, AnoConstruccion='$acons', UsoPlanificado='$upla', UsoReal='$urea', FecInspeccion=$finsp WHERE idLocal=$idlo";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El local fue editado correctamente.");
			}else{
				echo mensajeda("Error: " . mysqli_error($cone));
			}
			mysqli_close($cone);			
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>