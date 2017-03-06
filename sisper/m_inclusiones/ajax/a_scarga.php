<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
if(isset($_GET['iddep'])){
	$iddep=iseguro($cone,$_GET['iddep']);
	if($iddep==""){
		echo '<option value="">PROVINCIA</option>';
	}else{
		$q1=mysqli_query($cone,"Select * From provincia Where idDepartamento=".$iddep);
		echo "<option value=''>PROVINCIA</option>\r\n";
		while($fila=mysqli_fetch_assoc($q1)){
			echo '<option value="'.$fila["idProvincia"].'">'.$fila["NombrePro"].'</option>'."\r\n";
		}
		mysqli_free_result($q1);
	}
}
if(isset($_GET['idpro'])){
	$idpro=iseguro($cone,$_GET['idpro']);
	if($idpro==""){
		echo '<option value="">DISTRITO</option>';
	}else{
		$q1=mysqli_query($cone,"Select * From distrito Where idProvincia=".$idpro);
		echo "<option value=''>DISTRITO</option>\r\n";
		while($fila=mysqli_fetch_assoc($q1)){
			echo '<option value="'.$fila["idDistrito"].'">'.$fila["NombreDis"].'</option>'."\r\n";
		}
		mysqli_free_result($q1);
	}
}
if(isset($_GET['gi'])){
	$gi=iseguro($cone,$_GET['gi']);
	if($gi==""){
		echo '<option value="">NIVEL</option>';
	}else{
		$q1=mysqli_query($cone,"Select idGradoInstruccion, Nivel From gradoinstruccion Where GradoInstruccion='".$gi."'");
		echo '<option value="">NIVEL</option>';
		while($fila=mysqli_fetch_assoc($q1)){
			echo '<option value="'.$fila["idGradoInstruccion"].'">'.$fila["Nivel"].'</option>';
		}
		mysqli_free_result($q1);
	}
}
if(isset($_GET['idslab'])){
	$idslab=iseguro($cone,$_GET['idslab']);
	if($idslab==""){
		echo '<option value="">CARGO</option>';
	}else{
		$q1=mysqli_query($cone,"SELECT idCargo, Denominacion FROM cargo WHERE idSistemaLab=$idslab AND Estado=1 ORDER BY Denominacion ASC");
		echo '<option value="">CARGO</option>';
		while($fila=mysqli_fetch_assoc($q1)){
			echo '<option value="'.$fila["idCargo"].'">'.$fila["Denominacion"].'</option>';
		}
		mysqli_free_result($q1);
	}
}
mysqli_close($cone);
}else{
	echo accrestringidoa();
}
?>