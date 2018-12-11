<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],9)){
$idu=$_SESSION['identi'];
  if(isset($_POST['acc']) && !empty($_POST['acc'])){    
      $acc=iseguro($cone,$_POST['acc']);      
      if($acc=="agrdr"){
        if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['fecg']) && !empty($_POST['fecg'])){

          $idcs=iseguro($cone,$_POST['idcs']);
          $con=iseguro($cone,$_POST['con']);
          $doc=iseguro($cone,$_POST['doc']);
          $num=iseguro($cone,$_POST['num'])=="sd" ? vacio('') : vacio(iseguro($cone,$_POST['num']));         
          $mon=iseguro($cone,$_POST['mon']);
          $glo=iseguro($cone,$_POST['glo']);
          $pro=iseguro($cone,$_POST['pro'])=="sd" ? vacio('') : vacio(iseguro($cone,$_POST['pro']));
          $fecg=fmysql(iseguro($cone,$_POST['fecg']));
          $ces=mysqli_query($cone,"SELECT idteespecifica FROM teconceptov WHERE idteconceptov=$con;");
          $cen=mysqli_query($cone,"SELECT idEmpleado FROM comservicios  WHERE idComServicios=$idcs;");
            if ($res=mysqli_fetch_assoc($ces)) {              
              $ides=$res['idteespecifica'];
            }
            mysqli_free_result($ces); 
            if ($ren=mysqli_fetch_assoc($cen)) {
              $idde=iddependenciae($cone,$ren['idEmpleado']);              
            }
            mysqli_free_result($cen);          
            if(mysqli_query($cone,"INSERT INTO tegasto (fechacom, numerocom, glosacom, totalcom, idtetipocom, idteproveedor, idteespecifica, idDependencia, idComServicios, idteconceptov ) VALUES ('$fecg', $num, '$glo', '$mon', $doc, $pro, $ides, $idde, $idcs, $con);")){
              $r['i']=mysqli_insert_id($cone);
              $r['e']=true;
              $r['m']=mensajesu("Listo, comprobante registrado");          
            }else{
              $r['m']=mensajewa("Error, intentelo nuevamente");
            }
        }else{
            $r['m']=mensajewa("Todos los campos son obligatorios");
        }
      }if($acc=="edidr"){
        
        if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['idg']) && !empty($_POST['idg']) && isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['num']) && !empty($_POST['num']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['mon']) && !empty($_POST['mon']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['fecg']) && !empty($_POST['fecg'])){

          $idcs=iseguro($cone,$_POST['idcs']);
          $idg=iseguro($cone,$_POST['idg']);
          $con=iseguro($cone,$_POST['con']);
          $doc=iseguro($cone,$_POST['doc']);
          $num=iseguro($cone,$_POST['num'])=="sd" ? vacio('') : vacio(iseguro($cone,$_POST['num']));         
          $mon=iseguro($cone,$_POST['mon']);
          $glo=iseguro($cone,$_POST['glo']);
          $pro=iseguro($cone,$_POST['pro'])=="sd" ? vacio('') : vacio(iseguro($cone,$_POST['pro']));
          $fecg=fmysql(iseguro($cone,$_POST['fecg']));
          $ces=mysqli_query($cone,"SELECT idteespecifica FROM teconceptov WHERE idteconceptov=$con;");
          $cen=mysqli_query($cone,"SELECT idEmpleado FROM comservicios  WHERE idComServicios=$idcs;");
            if ($res=mysqli_fetch_assoc($ces)) {              
              $ides=$res['idteespecifica'];
            }
            mysqli_free_result($ces); 
            if ($ren=mysqli_fetch_assoc($cen)) {
              $idde=iddependenciae($cone,$ren['idEmpleado']);              
            }
            mysqli_free_result($cen);         
            if(mysqli_query($cone,"UPDATE tegasto SET fechacom='$fecg', numerocom=$num, glosacom='$glo', totalcom='$mon', idtetipocom=$doc, idteproveedor=$pro, idteespecifica=$ides, idDependencia=$idde, idteconceptov=$con WHERE idtegasto=$idg;")){
              $r['e']=true;
              $r['m']=mensajesu("Listo, comprobante actualizado");
            }else{
            $r['m']=mensajewa("SELECT cs.idEmpleado, c.idteespecifica FROM tegasto g INNER JOIN teconceptov c ON g.idteconceptov=c.idteconceptov INNER JOIN comservicios cs ON g.idComServicios=cs.idComServicios WHERE g.idteconceptov=$con");
            }
        }else{
          $r['m']=mensajewa("Todos los campos son obligatorios");
        }        

      }if($acc=="elidr"){
        if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['idg']) && !empty($_POST['idg'])){         
          $idcs=iseguro($cone,$_POST['idcs']);
          $idg=iseguro($cone,$_POST['idg']);         
          if(mysqli_query($cone,"DELETE FROM tegasto WHERE idtegasto=$idg;")){
            $r['e']=true;
            $r['m']=mensajesu("Listo, comprobante eliminado");         
          }else{
            $r['m']=mensajewa("Error, intentelo nuevamente");
          }
        }else{
          $r['m']=mensajewa("Elija el comprobante que desea eliminar");
        }
      }//acafin
    }else{
      $r['m']=mensajewa("Faltan datos");
    }
  }else{
  echo accrestringidoa();
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>