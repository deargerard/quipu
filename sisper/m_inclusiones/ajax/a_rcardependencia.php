<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_repcargos"){
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
                          <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>CARGO</th>
                            <th>DEPENDENCIA</th>
                          </tr>
                          <?php
                            $c1="SELECT en.idEmpleado, NombreCom, idCargo, idDependencia FROM enombre AS en INNER JOIN empleadocargo AS ec ON en.idEmpleado=ec.idEmpleado INNER JOIN cardependencia AS cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo WHERE ec.idEstadoCar=1 AND cd.Estado=1 $pccar $pcdep ORDER BY idCargo, idDependencia, NombreCom ASC";
                            $ccar=mysqli_query($cone,$c1);
                            if(mysqli_num_rows($ccar)>0){
                              $n=0;
                              while ($rcar=mysqli_fetch_assoc($ccar)) {
                                $n++;
                                $iemp=$rcar['idEmpleado'];
                          ?>
                          <tr>
                            <td><?php echo $n ?></td>
                            <td><?php echo $rcar["NombreCom"] ?></td>
                            <td><?php echo cargoe($cone,$iemp) ?></td>
                            <td><?php echo dependenciae($cone,$iemp) ?></td>
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