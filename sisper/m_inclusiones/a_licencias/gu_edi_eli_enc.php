<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],4)){
	$idu=$_SESSION['identi'];
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);
		$enc=iseguro($cone,$_POST['enc']);
		if($acc=="edienc"){
			if(isset($_POST['encar']) && !empty($_POST['encar']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['inienc']) && !empty($_POST['inienc']) && isset($_POST['finenc']) && !empty($_POST['finenc'])){
				$encar=iseguro($cone,$_POST['encar']);
				$tip=iseguro($cone,$_POST['tip']);
				$inienc= ftmysql(iseguro($cone,$_POST['inienc']));
				$finenc= ftmysql(iseguro($cone,$_POST['finenc']));				
				if(mysqli_query($cone,"UPDATE encargatura SET Inicio='$inienc', Fin='$finenc', Tipo=$tip, idEmpleado=$encar WHERE idEncargatura=$enc;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, se actualizó la encargatura");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Todos los campos son obligatorios");
			}
		}if($acc=="elienc"){
			if(isset($_POST['enc']) && !empty($_POST['enc'])){				 
				$enc=iseguro($cone,$_POST['enc']);				 
				if(mysqli_query($cone,"DELETE FROM encargatura WHERE idEncargatura=$enc;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, se eliminó la encargatura");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Elija la encargatura que desea eliminar");
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