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
		if($acc=="agrpro"){
			if(isset($_POST['razsoc']) && !empty($_POST['razsoc']) && isset($_POST['ruc']) && !empty($_POST['ruc'])){
				$razsoc=iseguro($cone,$_POST['razsoc']);
				$ruc=iseguro($cone,$_POST['ruc']);
				$dir=iseguro($cone,$_POST['dir']);
				$tel=iseguro($cone,$_POST['tel']);
				if(strlen($ruc)==11){
					
						if(mysqli_query($cone,"INSERT INTO terendicion (codigo, mes, anio, estado, idtemeta, empleado, trendicion) VALUES ($ncod, $mes, $anio, 1, $met, $idu, $tr)")){
							$r['e']=true;
							$r['m']=mensajesu("Listo, rendición registrada");
						}else{
							$r['m']=mensajewa("Error, intentelo nuevamente");
						}
						
				}else{
					$r['r']=mensajewa("El RUC debe contener 11 caracteres");
				}
			}else{
				$r['m']=mensajewa("Ambos campos son obligatorios, vuelva a intentarlo");
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