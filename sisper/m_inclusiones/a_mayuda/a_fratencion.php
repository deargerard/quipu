<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $ida=iseguro($cone,$_POST['id']);
    $ca=mysqli_query($cone,"SELECT ms.idEmpleado, ma.idEmpleado as usu, ma.Descripcion FROM maatencion ma INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ma.idAtencion=$ida;");
    if($ra=mysqli_fetch_assoc($ca)){
      $ids=$ra['idEmpleado'];
?>
        <div class="form-group valida">
              <div class="col-md-12">
                <table class="table table-bordered table-hover">
                  <tr>
                    <th><span class="text-aqua">Usuario</span></th>
                    <td><?php echo nomempleado($cone,$ra['usu']); ?></td>
                  </tr>
                  <tr>
                    <th colspan="2"><span class="text-aqua">Descripción</span></th>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $ra['Descripcion']; ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-sm-12">
                <label for="sol" class="control-label">Reasignar a</label>
                <input type="hidden" name="ida" value="<?php echo $ida; ?>">
                <select class="form-control select2sol" id="sol" name="sol" style="width: 100%;">
                  <?php
                    $csol=mysqli_query($cone,"SELECT ms.idEmpleado, idSolucionador, ApellidoPat, ApellidoMat, Nombres FROM masolucionador ms INNER JOIN empleado e ON ms.idEmpleado=e.idEmpleado WHERE ms.Estado=1 ORDER BY ApellidoPat, ApellidoMat, Nombres ASC;");
                    if(mysqli_num_rows($csol)>0){
                      while($rsol=mysqli_fetch_assoc($csol)){
                  ?>
                        <option value="<?php echo $rsol['idSolucionador']; ?>" <?php echo $ids==$rsol['idEmpleado'] ? "selected" : ""; ?>><?php echo $rsol['ApellidoPat']." ".$rsol['ApellidoMat'].", ".$rsol['Nombres']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN SOLUCIONADORES</option>
                  <?php
                    }
                    mysqli_free_result($csol);
                  ?>
                </select>
              </div>
              <div class="col-md-12">
                <br>
                <div id="resultado">
                  
                </div>
              </div>
        </div>
        <script>
          $(".select2sol").select2();
        </script>
<?php
    }else{
      echo mensajeda("No envió datos válidos.");
    }
    mysqli_free_result($ca);
  }else{
    echo mensajeda("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
