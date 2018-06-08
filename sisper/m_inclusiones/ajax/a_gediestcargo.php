<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
if(accesoadm($cone,$_SESSION['identi'],1)){
      $acc=iseguro($cone,$_POST['acc']);

      if($acc=="edidat"){
            $idec=iseguro($cone,$_POST['idec']);
            $numres=imseguro($cone,$_POST['numres']);
            $mot=iseguro($cone,$_POST['mot']);
            $ven=vacio(fmysql(iseguro($cone,$_POST['ven'])));

            if(isset($idec) && !empty($idec) && isset($numres) && !empty($numres) && isset($mot) && !empty($mot)){
                  
                  $sql="UPDATE estadocargo SET Vence=$ven, NumResolucion='$numres', Motivo='$mot' WHERE idEstadoCargo=$idec";
                  if(mysqli_query($cone,$sql)){
                        $r['m']=mensajesu("Listo: datos del estado editados correctamente.");
                        $r['e']=true;
                  }else{
                        $r['m']=mensajewa("Error: No se pudo editar, vuelva a intentarlo. ".mysqli_error($cone));
                        $r['e']=false;
                  }

            }else{
                  $r['m']=mensajewa("Error: El N° Documento y Motivo son campos obligatorios.");
                  $r['e']=false;
            }
      }elseif($acc=="edifin"){
            $idec=iseguro($cone,$_POST['idec']);
            $idemca=iseguro($cone,$_POST['idemca']);
            $finise=fmysql(iseguro($cone,$_POST['finise']));
            $fini=fmysql(iseguro($cone,$_POST['fini']));
            $ec=iseguro($cone,$_POST['ec']);
            if(isset($fini) && !empty($fini)){
                  if($finise!=$fini){
                        if(mysqli_query($cone,"UPDATE estadocargo SET FechaIni='$fini' WHERE idEstadoCargo=$idec;")){
                              $cea=mysqli_query($cone,"SELECT idEstadoCargo FROM estadocargo WHERE idEmpleadoCargo=$idemca AND idEstadoCargo<$idec ORDER BY idEstadoCargo DESC LIMIT 1;");
                              if($rea=mysqli_fetch_assoc($cea)){
                                    $iea=$rea['idEstadoCargo'];
                                    if($ec==3){
                                          $ff=$fini;
                                    }else{
                                          $ff=date("Y-m-d",strtotime("-1 day", strtotime($fini)));
                                    }
                                    if(mysqli_query($cone,"UPDATE estadocargo SET FechaFin='$ff' WHERE idEstadoCargo=$iea;")){
                                          $r['m']=mensajesu("Se cambio la fecha inicio del estado junto con la fecha fin del estado anterior.");
                                          $r['e']=true;
                                    }else{
                                          $r['m']=mensajesu("Se cambio la fecha inicio del estado pero no la fecha fin del estado anterior.");
                                          $r['e']=true;
                                    }
                              }else{
                                    $r['m']=mensajesu("Se cambio la fecha inicio del estado pero no la fecha fin del estado anterior.");
                                    $r['e']=true;
                              }
                        }else{
                              $r['m']=mensajewa("Error: No se pudo editar, vuelva a intentarlo.");
                              $r['e']=false;  
                        }
                  }else{
                        $r['m']=mensajesu("No se realizaron cambios, eligió la misma fecha.");
                        $r['e']=true;
                  }
            }else{
                  $r['m']=mensajewa("Error: Ingrese la fecha inicio.");
                  $r['e']=false;
            }
      }elseif($acc=="ediffi"){
            $idec=iseguro($cone,$_POST['idec']);
            $idemca=iseguro($cone,$_POST['idemca']);
            $ffinse=fmysql(iseguro($cone,$_POST['ffinse']));
            $ffin=fmysql(iseguro($cone,$_POST['ffin']));
            if(isset($ffin) && !empty($ffin)){
                  if($ffinse!=$ffin){
                        if(mysqli_query($cone,"UPDATE estadocargo SET FechaFin='$ffin' WHERE idEstadoCargo=$idec;")){
                              if($ffinse!=""){

                                    $ffinp=date("Y-m-d", strtotime("+1 day", strtotime($ffin)));
                                    $ffinsep=date("Y-m-d", strtotime("+1 day", strtotime($ffinse)));
                                    if(mysqli_query($cone,"UPDATE estadocargo SET FechaIni='$ffinp' WHERE idEmpleadoCargo=$idemca AND FechaIni='$ffinsep';")){
                                          $r['m']=mensajesu("Se actualizó la fecha de fin junto con la fecha inicio del estado posterior.");
                                          $r['e']=true;
                                    }else{
                                          $r['m']=mensajesu("Se actualizó la fecha de inicio, pero no la fecha inicio del estado posterior.");
                                          $r['e']=true;
                                    }
                              }else{
                                    $r['m']=mensajesu("Se actualizó la fecha de inicio.");
                                    $r['e']=true;
                              }
                        }else{
                              $r['m']=mensajewa("Error: No se pudo editar, vuelva a intentarlo.");
                              $r['e']=false;  
                        }
                  }else{
                        $r['m']=mensajesu("No se realizaron cambios, eligió la misma fecha.");
                        $r['e']=true;
                  }
            }else{
                  $r['m']=mensajewa("Error: Ingrese la fecha fin.");
                  $r['e']=false;
            }
      }

}else{
      $r['m']=mensajewa("Acceso restringido");
      $r['e']=false;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>