<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_reppersonal"){
    if(isset($_POST['depen']) && !empty($_POST['depen']) && isset($_POST['cargo']) && !empty($_POST['cargo'])){
      $depen=iseguro($cone,$_POST['depen']);
      $cargo=iseguro($cone,$_POST['cargo']);
      if($depen=="t"){
        $pcdep="";
      }else{
        $pcdep="AND idDependencia=".$depen;
      }
      if($cargo=="t"){
        $pccar="";
      }else{
        $pccar="AND ec.idCargo=".$cargo;
      }

?>
                      <table id="dtpersonal" class="table table-bordered table-striped">
                        <?php
                          $c1="SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 $pcdep ORDER BY Denominacion ASC";
                          $cdep=mysqli_query($cone,$c1);
                          while ($rdep=mysqli_fetch_assoc($cdep)) {
                            $idde=$rdep['idDependencia'];                      
                        ?>
                          <tr>
                            <th colspan="5"><span class="text-orange"><?php echo $rdep['Denominacion'] ?></span></th>
                          </tr>
                          <tr>
                            <th>N° DOC.</th>
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                            <th>ESTADO</th>
                            <th>DEP. OFICIAL</th>
                          </tr>
                            <?php
                              $c2="SELECT en.idEmpleado, NombreCom, NumeroDoc, ec.idCargo, ec.idEmpleadoCargo, Oficial FROM enombre AS en INNER JOIN empleadocargo AS ec ON en.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo WHERE cd.idDependencia=$idde AND ec.idEstadoCar=1 AND cd.Estado=1 $pccar ORDER BY ec.idCargo, NombreCom ASC";
                                //echo $c2;
                              $cper=mysqli_query($cone,$c2);
                              if(mysqli_num_rows($cper)>0){
                                while($rper=mysqli_fetch_assoc($cper)){
                                  $idemp=$rper['idEmpleado'];
                                  if($rper['Oficial']!=1){
                                    $emca=$rper['idEmpleadoCargo'];
                                    $cdo=mysqli_query($cone,"SELECT Denominacion FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia WHERE cd.idEmpleadoCargo=$emca AND cd.Oficial=1");
                                    $rdo=mysqli_fetch_assoc($cdo);
                                    $do=$rdo['Denominacion'];
                                    mysqli_free_result($cdo);
                                  }else{
                                    $do="--";
                                  }
                            ?>
                          <tr>
                            <td><?php echo $rper["NumeroDoc"] ?></td>
                            <td><?php echo $rper["NombreCom"] ?></td>
                            <td><?php echo cargoe($cone,$idemp) ?></td>
                            <td><?php echo modacce($cone,$idemp) ?></td>
                            <td><?php echo $do ?></td>
                          </tr>
                            <?php
                                }
                              }else{
                            ?>
                          <tr>
                            <td colspan="4">NO SE ENCONTRÓ PERSONAL.</td>
                          </tr>
                        <?php
                            }
                            mysqli_free_result($cper);
                          }
                          mysqli_free_result($cdep);
                        ?>
                      </table>
<?php
    }else{
      echo "no se enviaron datos";
    }
  }else{
    echo "No es el formulario";
  }
}else{
  echo accrestringidoa();
}
?>