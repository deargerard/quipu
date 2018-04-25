<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,3)){

	if(isset($_POST['mnum']) && !empty($_POST['mnum']) && isset($_POST['mtip']) && !empty($_POST['mtip']) && isset($_POST['mori']) && !empty($_POST['mori']) && isset($_POST['mrem']) && !empty($_POST['mrem']) && isset($_POST['mdes']) && !empty($_POST['mdes']) && isset($_POST['mdest']) && !empty($_POST['mdest']) && isset($_POST['idd']) && !empty($_POST['idd'])){
		$num=imseguro($cone,$_POST['mnum']);
		$tip=iseguro($cone,$_POST['mtip']);
		$ori=imseguro($cone,$_POST['mori']);
		$rem=imseguro($cone,$_POST['mrem']);
		$des=imseguro($cone,$_POST['mdes']);
		$dest=imseguro($cone,$_POST['mdest']);
		$idd=iseguro($cone,$_POST['idd']);
		$dcar=iseguro($cone,$_POST['mdcar'])=="si" ? 1 : 0;

		$c="UPDATE doc SET Numero='$num', idTipoDoc=$tip, Origen='$ori', Remitente='$rem', Destino='$des', Destinatario='$dest', idUsuario=$idusu, Cargo=$dcar WHERE idDoc=$idd;";
		if(mysqli_query($cone,$c)){
			$d['exito']=true;
			$d['mensaje']=mensajesu("Documento editado.");
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("Error, vuelva a intentarlo.");
		}

	}else{
		$d['exito']=false;
		$d['mensaje']=mensajewa("No lleno todos los campos.");
	}


}else{
	$d['exito']=false;
	$d['mensaje']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>