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
		if($acc=="agrren"){
			if(isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['anio']) && !empty($_POST['anio']) && isset($_POST['met']) && !empty($_POST['met']) && isset($_POST['tr']) && !empty($_POST['tr'])){
				$mes=iseguro($cone,$_POST['mes']);
				$anio=iseguro($cone,$_POST['anio']);
				$met=iseguro($cone,$_POST['met']);
				$tr=iseguro($cone,$_POST['tr']);
				$c1=mysqli_query($cone,"SELECT MAX(codigo) AS cod FROM terendicion WHERE anio=$anio;");
				if($r1=mysqli_fetch_assoc($c1)){
					$ncod=$r1['cod']+1;
				}else{
					$ncod=1;
				}
				if(mysqli_query($cone,"INSERT INTO terendicion (codigo, mes, anio, estado, idtemeta, empleado, trendicion) VALUES ($ncod, $mes, $anio, 1, $met, $idu, $tr)")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, rendición registrada");
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Ambos campos son obligatorios, vuelva a intentarlo");
			}
		}if($acc=="ediren"){
			$idr=iseguro($cone,$_POST['idr']);
			$met=iseguro($cone,$_POST['met']);
			$tr=iseguro($cone,$_POST['tr']);
			$po=iseguro($cone,$_POST['po']);
			if($po=="si"){
				if(isset($idr) && !empty($idr) && isset($met) && !empty($met) && isset($tr) && !empty($tr)){
					if(mysqli_query($cone,"UPDATE terendicion SET idtemeta=$met, empleado=$idu, trendicion=$tr WHERE idterendicion=$idr;")){
						$r['e']=true;
						$r['m']=mensajesu("Listo, rendición editada");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}else{
					$r['m']=mensajewa("Ambos campos son obligatorios, vuelva a intentarlo");
				}
			}elseif($po=="no"){
				if(isset($idr) && !empty($idr) && isset($met) && !empty($met)){
					if(mysqli_query($cone,"UPDATE terendicion SET idtemeta=$met, empleado=$idu WHERE idterendicion=$idr;")){
						$r['e']=true;
						$r['m']=mensajesu("Listo, rendición editada");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}else{
					$r['m']=mensajewa("No eligió una meta, vuelva a intentarlo");
				}
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