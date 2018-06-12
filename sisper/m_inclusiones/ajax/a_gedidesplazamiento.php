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
                  $r['m']=mensajesu("Escogió la misma fecha, no se realizó cambios.");
                  $r['e']=true;
            }else{
                  if(mysqli_query($cone,"UPDATE cardependencia SET FecInicio='$fini' WHERE idCarDependencia=$id;")){
                        $r['m']=mensajesu("Fecha de inicio actualizada.");
                        $r['e']=true;
                        $cd=mysqli_query($cone,"SELECT idCarDependencia FROM cardependencia WHERE idEmpleadoCargo=$iec AND idCarDependencia<$id ORDER BY idCarDependencia DESC LIMIT 1;");
                        if($rd=mysqli_fetch_assoc($cd)){
                              $icd=$rd['idCarDependencia'];
                              $ff=date('Y-m-d',strtotime('-1 day',strtotime($fini)));
                              if(mysqli_query($cone,"UPDATE cardependencia SET FecFin='$ff' WHERE idCarDependencia=$icd;")){
                                    $r['m'].=mensajesu("Se actualizó la fecha fin del desplazamiento anterior.");
                              }else{
                                    $r['m'].=mensajesu("No se pudo actualizar la fecha fin del desplazamiento anterior.");
                              }
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
                  $r['m']=mensajesu("Escogió la misma fecha, no se realizó cambios.");
                  $r['e']=true;
            }else{
                  if(mysqli_query($cone,"UPDATE cardependencia SET FecFin='$ffin' WHERE idCarDependencia=$id;")){
                        $r['m']=mensajesu("Fecha de fin actualizada.");
                        $r['e']=true;
                        $cd=mysqli_query($cone,"SELECT idCarDependencia FROM cardependencia WHERE idEmpleadoCargo=$iec AND idCarDependencia>$id ORDER BY idCarDependencia ASC LIMIT 1;");
                        if($rd=mysqli_fetch_assoc($cd)){
                              $icd=$rd['idCarDependencia'];
                              $fi=date('Y-m-d',strtotime('+1 day',strtotime($ffin)));
                              if(mysqli_query($cone,"UPDATE cardependencia SET FecInicio='$fi' WHERE idCarDependencia=$icd;")){
                                    $r['m'].=mensajesu("Se actualizó la fecha inicio del desplazamiento posterior.");
                              }else{
                                    $r['m'].=mensajesu("No se pudo actualizar la fecha inicio del desplazamiento posterior.");
                              }
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