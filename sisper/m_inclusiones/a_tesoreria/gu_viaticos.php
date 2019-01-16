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
		if($acc=="agrcon"){
			if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['dia']) && !empty($_POST['dia']) && isset($_POST['mon']) && !empty($_POST['mon'])){
				$idcs=iseguro($cone,$_POST['idcs']);
				$con=iseguro($cone,$_POST['con']);
				$dia=iseguro($cone,$_POST['dia']);
				$mon=iseguro($cone,$_POST['mon']);
				$cc=mysqli_query($cone, "SELECT idtedetplanillav FROM tedetplanillav WHERE idComServicios=$idcs AND idteconceptov=$con AND dia=$dia;");
				if($rc=mysqli_fetch_assoc($cc)){
					$r['m']=mensajewa("Ya existe monto para el día y concepto seleccionado.");
				}else{
					if(mysqli_query($cone, "INSERT INTO tedetplanillav (dia, monto, idteconceptov, idComServicios, empleado) VALUES ($dia, $mon, $con, $idcs, $idu);")){
						$r['e']=true;
						$r['m']=mensajesu("Concepto registrado.");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}
				mysqli_free_result($cc);
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		}elseif($acc=="tipane"){
			if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['ane']) && !empty($_POST['ane'])){
				$idcs=iseguro($cone,$_POST['idcs']);
				$ane=iseguro($cone,$_POST['ane']);
				$ccs=mysqli_query($cone, "SELECT aneplanilla FROM comservicios WHERE idComServicios=$idcs;");
				if($rcs=mysqli_fetch_assoc($ccs)){
					if(!is_null($rcs['aneplanilla'])){
						if($rcs['aneplanilla']==$ane){
							$r['m']=mensajesu("Listo, tipo de anexo editado.");
							$r['e']=true;
						}else{
							$cdp=mysqli_query($cone, "SELECT idtedetplanillav FROM tedetplanillav WHERE idComServicios=$idcs;");
							if(mysqli_num_rows($cdp)>0){
								$r['m']=mensajewa("Error, elimine antes los conceptos ya registrados.");
							}else{
								if(mysqli_query($cone, "UPDATE comservicios SET aneplanilla=$ane WHERE idComServicios=$idcs;")){
									$r['m']=mensajesu("Listo, tipo de anexo editado.");
									$r['e']=true;
								}else{
									$r['m']=mensajewa("Error, vuelva a intentarlo.");
								}
							}
							mysqli_free_result($cdp);
						}
					}else{
						if(mysqli_query($cone, "UPDATE comservicios SET aneplanilla=$ane WHERE idComServicios=$idcs;")){
							$r['m']=mensajesu("Listo, tipo de anexo registrado");
							$r['e']=true;
						}else{
							$r['m']=mensajewa("Error, vuelva a intentarlo");
						}
					}
				}else{
					$r['m']=mensajewa("Datos inválidos");
				}
				mysqli_free_result($ccs);
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		}elseif($acc=="edicon"){
			if(isset($_POST['iddp']) && !empty($_POST['iddp']) && isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['dia']) && !empty($_POST['dia']) && isset($_POST['mon']) && !empty($_POST['mon'])){
				$iddp=iseguro($cone,$_POST['iddp']);
				$idcs=iseguro($cone,$_POST['idcs']);
				$con=iseguro($cone,$_POST['con']);
				$dia=iseguro($cone,$_POST['dia']);
				$mon=iseguro($cone,$_POST['mon']);
				$cc=mysqli_query($cone, "SELECT idtedetplanillav FROM tedetplanillav WHERE idComServicios=$idcs AND idteconceptov=$con AND dia=$dia AND idtedetplanillav!=$iddp;");
				if($rc=mysqli_fetch_assoc($cc)){
					$r['m']=mensajewa("Ya existe monto para el día y concepto seleccionado.");
				}else{
					if(mysqli_query($cone, "UPDATE tedetplanillav SET dia=$dia, monto=$mon, idteconceptov=$con, empleado=$idu WHERE idtedetplanillav=$iddp;")){
						$r['e']=true;
						$r['m']=mensajesu("Concepto editado.");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}
				mysqli_free_result($cc);
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		}elseif($acc=="elicon"){
			if(isset($_POST['v1']) && !empty($_POST['v1'])){
				$v1=iseguro($cone, $_POST['v1']);
				if(mysqli_query($cone, "DELETE FROM tedetplanillav WHERE idtedetplanillav=$v1;")){
					$r['e']=true;
					$r['m']=mensajesu("Concepto eliminado");
				}else{
					$r['m']=mensajewa("Error, vuelva a intentarlo");
				}
			}else{
				$r['m']=mensajewa("Faltan datos");
			}
		}elseif($acc=="estren"){
			if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['est']) && !empty($_POST['est'])){
				$idcs=iseguro($cone, $_POST['idcs']);
				$est=iseguro($cone, $_POST['est']);
				$obs=vacio(iseguro($cone, $_POST['obs']));
				if(mysqli_query($cone, "UPDATE comservicios SET estadoren=$est, observacion=$obs WHERE idComServicios=$idcs;")){
					$r['m']=mensajesu("Listo, se cambió el estado");
					$r['e']=true;
					if($est==4){
						$cco=mysqli_query($cone, "SELECT docrendicion FROM comservicios WHERE idComServicios=$idcs;");
						if($rco=mysqli_fetch_assoc($cco)){
							$dr=$rco['docrendicion'];
							if(mysqli_query($cone, "UPDATE comservicios SET docrendicion=NULL WHERE idComServicios=$idcs;")){
								if(file_exists("comp_escan/$dr")){
									if(unlink("comp_escan/$dr")){
										$r['m'].=mensajesu("Comprobantes eliminados del servidor");
									}else{
										$r['m'].=mensajewa("Error al eliminar comprobantes del servidor");
									}
								}
							}else{
								$r['m'].=mensajewa("Error al eliminar comprobantes de la BD");
							}
						}
						mysqli_free_result($cco);
					}
				}else{
					$r['m']=mensajewa("Error, vuelva a intentarlo");
				}
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		}elseif($acc=="numsiv"){
			if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['siv']) && !empty($_POST['siv'])){
				$idcs=iseguro($cone, $_POST['idcs']);
				$siv=iseguro($cone, $_POST['siv']);
				if(mysqli_query($cone, "UPDATE comservicios SET csivia='$siv' WHERE idComServicios=$idcs;")){
					$r['e']=true;
					$r['m']=mensajesu("# SIVIA registrado correctamente");
				}else{
					$r['m']=mensajewa("Error al registrar # SIVIA, vuelva a intentarlo");
				}
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
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