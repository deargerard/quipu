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
		$tra=iseguro($cone,$_POST['tra']);
		if($acc=="agrent"){
			if(isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['tra']) && !empty($_POST['tra'])){
				$mot=iseguro($cone,$_POST['mot']);				
				if(mysqli_query($cone,"INSERT INTO teentrega (motivo, idEmpleado, empleado) VALUES ('$mot', $tra, $idu);")){
					$r['i']=mysqli_insert_id($cone);
					$r['e']=true;
					$r['m']=mensajesu("Listo, Adelanto de dinero registrado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Todos los campos son obligatorios");
			}
		}if($acc=="edient"){
			if(isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['ide']) && !empty($_POST['ide']) ){
				$mot=iseguro($cone,$_POST['mot']);
				$ide=iseguro($cone,$_POST['ide']);				
				if(mysqli_query($cone,"UPDATE teentrega SET motivo='$mot', empleado=$idu WHERE idteentrega=$ide;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, Adelanto de dinero actualizado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Todos los campos son obligatorios");
			}
		}if($acc=="elient"){
			if(isset($_POST['ide']) && !empty($_POST['ide'])){				 
				$ide=iseguro($cone,$_POST['ide']);				 
				if(mysqli_query($cone,"DELETE FROM teentrega WHERE idteentrega=$ide;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, Adelanto de dinero eliminado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}
			}else{
				$r['m']=mensajewa("Elija el Adelanto que desea eliminar");
			}
		}elseif($acc=="agrdent"){
			if(isset($_POST['ide']) && !empty($_POST['ide']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['mov']) && !empty($_POST['mov']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['fecc']) && !empty($_POST['fecc'])){				
				$ide=iseguro($cone,$_POST['ide']);
				$tip=iseguro($cone,$_POST['tip']);
				$num=iseguro($cone,$_POST['num']);
				$mov=iseguro($cone,$_POST['mov']);
				$mon=iseguro($cone,$_POST['mon']);
				$fecc=fmysql(iseguro($cone,$_POST['fecc']));
				$ben=vacio(imseguro($cone,$_POST['ben']));
				if(mysqli_query($cone,"INSERT INTO tedocentrega (tipo, numero, monto, fecha, idteentrega, tipmov, empleado, beneficiario) VALUES ($tip, '$num', $mon, '$fecc', $ide, $mov, $idu, $ben);")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, comprobante registrado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}

			}else{
				$r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
			}
		}if($acc=="edident"){
			if(isset($_POST['idce']) && !empty($_POST['idce']) && isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['mov']) && !empty($_POST['mov']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['fecc']) && !empty($_POST['fecc']) ){
				$ide=iseguro($cone,$_POST['ide']);
				$idce=iseguro($cone,$_POST['idce']);
				$tip=iseguro($cone,$_POST['tip']);
				$num=iseguro($cone,$_POST['num']);
				$mov=iseguro($cone,$_POST['mov']);
				$mon=iseguro($cone,$_POST['mon']);
				$fecc=fmysql(iseguro($cone,$_POST['fecc']));
				$ben=vacio(imseguro($cone,$_POST['ben']));
				$q="UPDATE tedocentrega SET fecha='$fecc', monto=$mon, tipo=$tip, tipmov=$mov, empleado=$idu, numero='$num', beneficiario=$ben WHERE idtedocentrega=$idce;";
				if(mysqli_query($cone,$q)){
					$r['e']=true;
					$r['m']=mensajesu("Listo, comprobante editado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente ");
				}

			}else{
				$r['m']=mensajewa("Los campos marcados con <span class='text-red'>*</span> son obligatorios");
			}
		}if($acc=="elident"){
			if(isset($_POST['idce']) && !empty($_POST['idce'])){				 
				$ide=iseguro($cone,$_POST['ide']);
				$idce=iseguro($cone,$_POST['idce']);				 
				if(mysqli_query($cone,"DELETE FROM tedocentrega WHERE idtedocentrega=$idce;")){
					$r['e']=true;
					$r['m']=mensajesu("Listo, comprobante eliminado");					
				}else{
					$r['m']=mensajewa("Error, intentelo nuevamente");
				}

			}else{
				$r['m']=mensajewa("Elija el comprobante que desea eliminar");
			}
		}elseif($acc=="libcomp"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$v2=iseguro($cone, $_POST['v2']);
			if(mysqli_query($cone, "UPDATE tegasto SET idteentrega=NULL WHERE idtegasto=$v2")){
				$r['m']=mensajesu("Listo, comprobante liberado de la entrega");
				$r['e']=true;
			}else{
				$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="libviat"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$v2=iseguro($cone, $_POST['v2']);
			if(mysqli_query($cone, "UPDATE comservicios SET idteentrega=NULL WHERE idComServicios=$v2")){
				$r['m']=mensajesu("Listo, víatico liberado de la entrega");
				$r['e']=true;
			}else{
				$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
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