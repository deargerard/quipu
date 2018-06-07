<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
if(accesoadm($cone,$_SESSION['identi'],1)){
      $acc=iseguro($cone,$_POST['acc']);
      if($acc=="edat"){
            $id=iseguro($cone,$_POST['id']);
            $dep=iseguro($cone,$_POST['dep']);
            $tipdes=iseguro($cone,$_POST['tipdes']);
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            if(isset($dep) && !empty($dep) && isset($tipdes) && !empty($tipdes) && isset($numres) && !empty($numres) && isset($mot) && !empty($mot)){
                  $sql="UPDATE cardependencia SET idDependencia=$dep, idTipoDesplaza=$tipdes, NumResolucion='$numres', Motivo='$mot' WHERE idCarDependencia=$id;";
                  if(mysqli_query($cone,$sql)){
                        $r['m']=mensajesu("Listo: Datos actualizados.");
                        $r['e']=true;
                  }else{
                        $r['m']=mensajewa("Error: Vuelva a intentarlo.");
                        $r['e']=false;
                  }         
            }else{
                  $r['m']=mensajewa("Error: Todos los campos son obligatorios.");
                  $r['e']=false;
            }
      }elseif($acc=="eofi"){
            $id=iseguro($cone,$_POST['id']);
            $iec=iseguro($cone,$_POST['iec']);
            if(mysqli_query($cone,"UPDATE cardependencia SET Oficial=1 WHERE idCarDependencia=$id;")){
                  if(mysqli_query($cone,"UPDATE cardependencia SET Oficial=0 WHERE idCarDependencia!=$id AND idEmpleadoCargo=$iec;")){
                        $r['m']=mensajesu("Dependencia Oficializada");
                        $r['e']=true; 
                  }else{
                        $r['m']=mensajewa("Error: Se oficializó la dependencia, pero falta actualizar la dependencia oficial anterior. Contáctese con informática.");
                        $r['e']=false; 
                  }
            }else{
                  $r['m']=mensajewa("Error: Vuelva a intentarlo.");
                  $r['e']=false;
            }
      }elseif($acc=="efin"){
            $id=iseguro($cone,$_POST['id']);
            $iec=iseguro($cone,$_POST['iec']);
            $fini=fmysql(iseguro($cone,$_POST['fini']));
            $finise=fmysql(iseguro($cone,$_POST['finise']));
            if($fini==$finise){
                  $r['m']=mensajesu("Escogió la misma fecha.");
                  $r['e']=true;
            }else{
                  $finia=date('Y-m-d',strtotime('-1 day',strtotime($fini)));
                  if(mysqli_query($cone,"UPDATE cardependencia SET FecInicio='$fini' WHERE idCarDependencia=$id;")){
                        if($finise!=""){
                              $finisea=date('Y-m-d',strtotime('-1 day',strtotime($finise)));
                              if(mysqli_query($cone,"UPDATE cardependencia SET FecFin='$finia' WHERE idEmpleadoCargo=$iec AND FecFin='$finisea';")){
                                    $r['m']=mensajesu("Fecha de inicio actualizada. (Se actualizó la fecha fin del desplazamiento anterior).");
                                    $r['e']=true;
                              }else{
                                    $r['m']=mensajesu("Fecha de inicio actualizada. (No se actualizó la fecha fin del desplazamiento anterior).");
                                    $r['e']=true; 
                              }
                        }else{
                              $r['m']=mensajesu("Fecha de inicio actualizada.");
                              $r['e']=true;
                        }
                  }else{
                        $r['m']=mensajewa("Error: No se pudo editar, vuelva a intentarlo.");
                        $r['e']=false; 
                  }
            }
      }elseif($acc=="effi"){
            $id=iseguro($cone,$_POST['id']);
            $iec=iseguro($cone,$_POST['iec']);
            $ffin=fmysql(iseguro($cone,$_POST['ffin']));
            $ffinse=fmysql(iseguro($cone,$_POST['ffinse']));
            if($ffin==$ffinse){
                  $r['m']=mensajesu("Escogió la misma fecha.");
                  $r['e']=true;
            }else{
                  $ffinp=date('Y-m-d',strtotime('+1 day',strtotime($ffin)));
                  if(mysqli_query($cone,"UPDATE cardependencia SET FecFin='$ffin' WHERE idCarDependencia=$id;")){
                        if($ffinse!=""){
                              $ffinsep=date('Y-m-d',strtotime('+1 day',strtotime($ffinse)));
                              if(mysqli_query($cone,"UPDATE cardependencia SET FecInicio='$ffinp' WHERE idEmpleadoCargo=$iec AND FecInicio='$ffinsep';")){
                                    $r['m']=mensajesu("Fecha de fin actualizada. (Se actualizó la fecha inicio del desplazamiento posterior).");
                                    $r['e']=true;
                              }else{
                                    $r['m']=mensajesu("Fecha de inicio actualizada. (No se actualizó la fecha inicio del desplazamiento posterior).");
                                    $r['e']=true; 
                              }
                        }else{
                              $r['m']=mensajesu("Fecha de fin actualizada.");
                              $r['e']=true;
                        }
                  }else{
                        $r['m']=mensajewa("Error: No se pudo editar, vuelva a intentarlo.");
                        $r['e']=false; 
                  }
            }
      }
}else{
      $r['m']=mensajewa("Acceso restringido.");
      $r['e']=false;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>