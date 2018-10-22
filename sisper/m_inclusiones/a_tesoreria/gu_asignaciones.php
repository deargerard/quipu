<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],16)){
	$idu=$_SESSION['identi'];
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);
		if($acc=="agrasig"){
			if(isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['med']) && !empty($_POST['med']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['met']) && !empty($_POST['met']) && isset($_POST['feca']) && !empty($_POST['feca'])){
				$mon=iseguro($cone,$_POST['mon']);
				$tip=iseguro($cone,$_POST['tip']);
				$med=iseguro($cone,$_POST['med']);
				$num=iseguro($cone,$_POST['num']);
				$met=iseguro($cone,$_POST['met']);
				$feca=fmysql(iseguro($cone,$_POST['feca']));
				if(mysqli_query($cone,"INSERT INTO teasignacion (fecha, monto, tipo, idtemeta, empleado, medio, nummedio) VALUES ('$feca', $mon, $tip, $met, $idu, $med, $num)")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, Asignación registrada");
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}

			}else{
				$r['m']=mensajewa("Todos los campos son obligatorios");
			}
		}if($acc=="ediasig"){
			if(isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['med']) && !empty($_POST['med']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['met']) && !empty($_POST['met']) && isset($_POST['feca']) && !empty($_POST['feca']) && isset($_POST['ida']) && !empty($_POST['ida'])){
				$mon=iseguro($cone,$_POST['mon']);
				$tip=iseguro($cone,$_POST['tip']);
				$med=iseguro($cone,$_POST['med']);
				$num=iseguro($cone,$_POST['num']);
				$met=iseguro($cone,$_POST['met']);
				$ida=iseguro($cone,$_POST['ida']);
				$feca=fmysql(iseguro($cone,$_POST['feca']));
				if(mysqli_query($cone,"UPDATE teasignacion SET fecha='$feca', monto=$mon, tipo=$tip, idtemeta=$met, empleado=$idu, medio=$med, nummedio=$med WHERE idteasignacion=$ida;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, asignación actualizada");
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}

			}else{
				$r['m']=mensajewa("Todos los campos son obligatorios");
			}
		}if($acc=="eliasig"){
			if(isset($_POST['ida']) && !empty($_POST['ida'])){				 
				$ida=iseguro($cone,$_POST['ida']);				 
				if(mysqli_query($cone,"DELETE FROM teasignacion WHERE idteasignacion=$ida;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, asignación eliminada");
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}

			}else{
				$r['m']=mensajewa("Elija la asignación que desea eliminar");
			}
		}//acafin
	}else{
		$r['m']=mensajewa("Faltan datos");
	}
}else{
  $r['m']=mensajewa("Acceso restringido");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>