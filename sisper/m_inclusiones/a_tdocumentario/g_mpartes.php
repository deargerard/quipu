<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		if($acc=="agrmpar"){
            if(isset($_POST['mpar']) && !empty($_POST['mpar']) && isset($_POST['loc']) && !empty($_POST['loc'])){
                $mpar=imseguro($cone, $_POST['mpar']);
                $loc=iseguro($cone, $_POST['loc']);
                if(mysqli_query($cone, "INSERT INTO tdmesapartes (denominacion, estado, idLocal) VALUES ('$mpar', 1, $loc);")){
                    $r['m']=mensajesu("¡Listo! mesa de partes registrada.");
                    $r['e']=true;
                }else{
                    $r['m']=mensajewa("Error, vuelva a intentarlo.");
                }
            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="edimpar"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['mpar']) && !empty($_POST['mpar']) && isset($_POST['loc']) && !empty($_POST['loc'])){
                $v1=iseguro($cone, $_POST['v1']);
                $mpar=imseguro($cone, $_POST['mpar']);
                $loc=iseguro($cone, $_POST['loc']);
                if(mysqli_query($cone, "UPDATE tdmesapartes SET denominacion='$mpar', idLocal=$loc WHERE idtdmesapartes=$v1;")){
                    $r['m']=mensajesu("¡Listo! mesa de partes editada.");
                    $r['e']=true;
                }else{
                    $r['m']=mensajewa("Error, vuelva a intentarlo.");
                }
            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="estmpar"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $v1=iseguro($cone, $_POST['v1']);
                $cm=mysqli_query($cone, "SELECT estado FROM tdmesapartes WHERE idtdmesapartes=$v1;");
                if($rm=mysqli_fetch_assoc($cm)){
                    $nest=$rm['estado']==1 ? 0 : 1;
                    if(mysqli_query($cone, "UPDATE tdmesapartes SET estado=$nest WHERE idtdmesapartes=$v1;")){
                        $r['e']=true;
                        $r['m']=mensajesu("¡Listo! Se cambio el estado.");
                    }else{
                        $r['m']=mensajewa("Error, vuelva a intentarlo.");
                    }
                }else{
                    $r['m']=mensajewa("Error, datos inválidos.");
                }
                mysqli_free_result($cm);
            }else{
                $r['m']=mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="agrres"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['per']) && !empty($_POST['per'])){
                $v1=iseguro($cone, $_POST['v1']);
                $per=iseguro($cone, $_POST['per']);
                $cr=mysqli_query($cone, "SELECT * FROM tdpersonalmp WHERE idtdmesapartes=$v1 AND idEmpleado=$per;");
                if($rr=mysqli_fetch_assoc($cr)){
                    $r['m']=mensajewa("Error, el personal ya se encuentra agregado como responsable en está mesa de partes.");
                }else{
                    $cra=mysqli_query($cone, "SELECT * FROM tdpersonalmp WHERE idEmpleado=$per AND idtdmesapartes!=$v1 AND estado=1;");
                    if($rra=mysqli_fetch_assoc($cra)){
                        $r['m']=mensajewa("Error, el personal se encuentra activo en otra mesa de partes.");
                    }else{
                        if(mysqli_query($cone, "INSERT INTO tdpersonalmp (estado, idtdmesapartes, idEmpleado) VALUES (1, $v1, $per);")){
                            $r['e']=true;
                            $r['m']=mensajesu("Responsable registrado.");
                            $r['i']=$v1;
                        }else{
                            $r['m']=mensajewa("Error, vuelva a intentarlo.");
                        }
                    }
                }
                mysqli_free_result($cr);
            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="estres"){
            if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2'])){
                $v1=iseguro($cone, $_POST['v1']);
                $v2=iseguro($cone, $_POST['v2']);
                $cm=mysqli_query($cone, "SELECT estado FROM tdpersonalmp WHERE idtdpersonalmp=$v1;");
                if($rm=mysqli_fetch_assoc($cm)){
                    $nest=$rm['estado']==1 ? 0 : 1;
                    if(mysqli_query($cone, "UPDATE tdpersonalmp SET estado=$nest WHERE idtdpersonalmp=$v1;")){
                        $r['e']=true;
                        $r['m']=mensajesu("¡Listo! Se cambio el estado.");
                        $r['i']=$v2;
                    }else{
                        $r['m']=mensajewa("Error, vuelva a intentarlo.");
                    }
                }else{
                    $r['m']=mensajewa("Error, datos inválidos.");
                }
                mysqli_free_result($cm);
            }else{
                $r['m']=mensajewa("Error, faltan datos.");
            }
        }//acafin
	}else{
		$r['m']=mensajewa("Error: Ne envio la acción.");
	}
}else{
    $r['m']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>