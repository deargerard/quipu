<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
	$idu=$_SESSION['identi'];
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);
		if($acc=="agrren"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
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
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="ediren"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$idr=iseguro($cone,$_POST['idr']);
			$met=iseguro($cone,$_POST['met']);
			$tr=iseguro($cone,$_POST['tr']);
			$po=iseguro($cone,$_POST['po']);
			if($po){
				if(isset($idr) && !empty($idr) && isset($met) && !empty($met) && isset($tr) && !empty($tr)){
					if(mysqli_query($cone,"UPDATE terendicion SET idtemeta=$met, empleado=$idu, trendicion=$tr WHERE idterendicion=$idr;")){
						$r['e']=true;
						$r['m']=mensajesu("Listo, rendición editada");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}else{
					$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
				}
			}else{
				if(isset($idr) && !empty($idr) && isset($met) && !empty($met)){
					if(mysqli_query($cone,"UPDATE terendicion SET idtemeta=$met, empleado=$idu WHERE idterendicion=$idr;")){
						$r['e']=true;
						$r['m']=mensajesu("Listo, rendición editada");
					}else{
						$r['m']=mensajewa("Error, intentelo nuevamente");
					}
				}else{
					$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
				}
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="agrdoc"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  $v1=iseguro($cone, $_POST['v1']);
		  $v2=iseguro($cone, $_POST['v2']);
		  if($v2==1){
			if(isset($_POST['esp']) && !empty($_POST['esp']) && isset($_POST['feccom']) && !empty($_POST['feccom']) && isset($_POST['tcom']) && !empty($_POST['tcom']) && isset($_POST['sercom']) && !empty($_POST['sercom']) && isset($_POST['numcom']) && !empty($_POST['numcom']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['imp']) && !empty($_POST['imp']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['dep']) && !empty($_POST['dep'])){				
					$esp=iseguro($cone, $_POST['esp']);
					$feccom=fmysql(iseguro($cone, $_POST['feccom']));
					$tcom=iseguro($cone, $_POST['tcom']);
					$numcom=ltrim(iseguro($cone, $_POST['numcom']),"0");
					$sercom=ltrim(iseguro($cone, $_POST['sercom']),"0");
					$des=imseguro($cone, $_POST['des']);
					$imp=iseguro($cone, $_POST['imp']);
					$can=vacio(iseguro($cone, $_POST['can']));
					$uni=vacio(iseguro($cone, $_POST['uni']));
					$codser=vacio(imseguro($cone, $_POST['codser']));
					$pro=iseguro($cone, $_POST['pro']);
					$dep=iseguro($cone, $_POST['dep']);
					$loc=vacio(iseguro($cone, $_POST['loc']));
					$nc=$sercom."-".$numcom;
					$q="INSERT INTO tegasto (fechacom, numerocom, glosacom, totalcom, cantidadcom, codservicio, idtetipocom, idteproveedor, idteespecifica, idterendicion, idDependencia, empleado, idteumedida, idLocal) VALUES ('$feccom', '$nc', '$des', $imp, $can, $codser, $tcom, $pro, $esp, $v1, $dep, $idu, $uni, $loc);";
					if(mysqli_query($cone, $q)){
						$r['m']=mensajesu("Listo, documento agregado.");
						$r['e']=true;
						$r['i']=$v1;
					}else{
						$r['m']=mensajewa("Error, vuelva a intentarlo. ".$q);
					}
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		  }elseif($v=2){
			$r['m']=mensajewa("Viáticos");
		  }
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="edidoc"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  $v1=iseguro($cone, $_POST['v1']);
		  $v2=iseguro($cone, $_POST['v2']);
		  if($v2==1){
			if(isset($_POST['esp']) && !empty($_POST['esp']) && isset($_POST['feccom']) && !empty($_POST['feccom']) && isset($_POST['tcom']) && !empty($_POST['tcom']) && isset($_POST['sercom']) && !empty($_POST['sercom']) && isset($_POST['numcom']) && !empty($_POST['numcom']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['imp']) && !empty($_POST['imp']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['dep']) && !empty($_POST['dep'])){			
					$esp=iseguro($cone, $_POST['esp']);
					$feccom=fmysql(iseguro($cone, $_POST['feccom']));
					$tcom=iseguro($cone, $_POST['tcom']);
					$numcom=ltrim(iseguro($cone, $_POST['numcom']),"0");
					$sercom=ltrim(iseguro($cone, $_POST['sercom']),"0");
					$des=imseguro($cone, $_POST['des']);
					$imp=iseguro($cone, $_POST['imp']);
					$can=vacio(iseguro($cone, $_POST['can']));
					$uni=vacio(iseguro($cone, $_POST['uni']));
					$codser=vacio(imseguro($cone, $_POST['codser']));
					$pro=iseguro($cone, $_POST['pro']);
					$dep=iseguro($cone, $_POST['dep']);
					$loc=vacio(iseguro($cone, $_POST['loc']));
					$idre=iseguro($cone, $_POST['idre']);
					$nc=$sercom."-".$numcom;
					$q="UPDATE tegasto SET fechacom='$feccom', numerocom='$nc', glosacom='$des', totalcom=$imp, idteumedida=$uni, cantidadcom=$can, codservicio=$codser, idtetipocom=$tcom, idteproveedor=$pro, idteespecifica=$esp, idDependencia=$dep, empleado=$idu, idLocal=$loc WHERE idtegasto=$v1;";
					if(mysqli_query($cone, $q)){
						$r['m']=mensajesu("Listo, documento editado.");
						$r['e']=true;
						$r['i']=$idre;
					}else{
						$r['m']=mensajewa("Error, vuelva a intentarlo. ".$q);
					}
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		  }elseif($v=2){
			$r['m']=mensajewa("Viáticos");
		  }
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="elidoc"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$v1=iseguro($cone, $_POST['v1']);
			$idre=iseguro($cone, $_POST['idre']);
			if(mysqli_query($cone, "DELETE FROM tegasto WHERE idtegasto=$v1")){
				$r['m']=mensajesu("Listo, documento eliminado");
				$r['e']=true;
				$r['i']=$idre;
			}else{
				$r['m']=mensajewa("Error, vuelva a intentarlo");
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="agrpro"){
		  if(accesoadm($cone,$_SESSION['identi'],9)){
			if(isset($_POST['razsoc']) && !empty($_POST['razsoc']) && isset($_POST['ruc']) && !empty($_POST['ruc'])){
				$razsoc=imseguro($cone, $_POST['razsoc']);
				$ruc=iseguro($cone, $_POST['ruc']);
				$dir=vacio(iseguro($cone, $_POST['dir']));
				$tel=vacio(iseguro($cone, $_POST['tel']));
				$ce=mysqli_query($cone, "SELECT idteproveedor FROM teproveedor WHERE ruc='$ruc';");
				if(mysqli_num_rows($ce)>0){
					$r['m']=mensajewa("El RUC ingresado ya existe.");
				}else{
					if(mysqli_query($cone, "INSERT INTO teproveedor (razsocial, ruc, direccion, telefono) VALUES ('$razsoc', '$ruc', $dir, $tel);")){
						$r['e']=true;
						$r['m']=mensajesu("Listo, proveedor registrado.");
					}else{
						$r['m']=mensajewa("Error, intentelo denuevo.");
					}
				}
				mysqli_free_result($ce);
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="estren"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$v1=iseguro($cone, $_POST['v1']);
			$es=iseguro($cone, $_POST['es'])==1 ? 0 : 1;
			if(mysqli_query($cone, "UPDATE terendicion SET estado=$es WHERE idterendicion=$v1")){
				$r['m']=mensajesu("Listo, estado de rendición cambiada");
				$r['e']=true;
			}else{
				$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="libvia"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
			$v1=iseguro($cone, $_POST['v1']);
			if(mysqli_query($cone, "UPDATE comservicios SET idterendicion=NULL WHERE idComServicios=$v1")){
				$r['m']=mensajesu("Listo, víatico liberado de la rendición");
				$r['e']=true;
			}else{
				$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="movdoc"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  	if(isset($_POST['idnr']) && !empty($_POST['idnr'])){
				$idg=iseguro($cone, $_POST['idg']);
				$idnr=iseguro($cone, $_POST['idnr']);
				if(mysqli_query($cone, "UPDATE tegasto SET idterendicion=$idnr WHERE idtegasto=$idg;")){
					$r['m']=mensajesu("Listo, documento movido");
					$r['e']=true;
				}else{
					$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
				}
			}else{
				$r['m']=mensajewa("Elija una rendición");
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}elseif($acc=="ordvia"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  	if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['ord']) && !empty($_POST['ord'])){
				$idcs=iseguro($cone, $_POST['idcs']);
				$ord=iseguro($cone, $_POST['ord']);
				if(mysqli_query($cone, "UPDATE comservicios SET orden=$ord WHERE idComServicios=$idcs")){
					$r['m']=mensajesu("Listo, número de orden asignado.");
					$r['e']=true;
				}else{
					$r['m']=mensajewa("Error, vuelva a intentarlo ".mysqli_error($cone));
				}
			}else{
				$r['m']=mensajewa("Los campos marcados con <b class='text-red'>*</b> son obligatorios.");
			}
		  }else{
		  	$r['m']=mensajewa("Acceso restringido");
		  }
		}//acafin
	}else{
		$r['m']=mensajewa("Faltan datos");
	}

header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>