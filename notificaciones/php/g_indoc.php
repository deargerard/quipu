<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,3)){

	if(isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['ori']) && !empty($_POST['ori']) && isset($_POST['rem']) && !empty($_POST['rem']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['dest']) && !empty($_POST['dest']) && isset($_POST['guia']) && !empty($_POST['guia'])){
		$num=imseguro($cone,$_POST['num']);
		$tip=iseguro($cone,$_POST['tip']);
		$ori=imseguro($cone,$_POST['ori']);
		$rem=imseguro($cone,$_POST['rem']);
		$des=imseguro($cone,$_POST['des']);
		$dest=imseguro($cone,$_POST['dest']);
		$guia=imseguro($cone,$_POST['guia']);
		$dcar=iseguro($cone,$_POST['dcar'])=="si" ? 1 : 0;

		$c="INSERT INTO doc (Numero, idTipoDoc, Origen, Remitente, Destino, Destinatario, idGuia, idUsuario, Cargo) VALUES ('$num', $tip, '$ori', '$rem', '$des', '$dest', $guia, $idusu, $dcar);";
		if(mysqli_query($cone,$c)){
			$d['exito']=true;
			$d['mensaje']="<p class='text-success'><i class='fa fa-check-circle'></i> Documento ingresado.</p>";
		}else{
			$d['exito']=false;
			$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> Error, vuelva a intantarlo.</p>";
		}

	}else{
		$d['exito']=false;
		$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> No lleno todos los campos.</p>";
	}


}else{
	$d['exito']=false;
	$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> Acceso restringido.</p>";
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>