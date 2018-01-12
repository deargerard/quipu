<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id=iseguro($cone,$_POST['id']);
    $ca=mysqli_query($cone, "SELECT idEmpleado, Descripcion FROM maatencion WHERE idAtencion=$id;");
    if($ra=mysqli_fetch_assoc($ca)){
?>

        <div class="form-group valida">
              <div class="col-md-12">
                <table class="table table-bordered table-hover">
                  <tr>
                    <th><span class="text-aqua">Usuario</span></th>
                    <td><?php echo nomempleado($cone,$ra['idEmpleado']); ?></td>
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
                <label for="solu" class="control-label">Detalle lo realizado</label>
                <input type="hidden" name="ida" value="<?php echo $id; ?>">
                <textarea class="form-control" rows="3" name="solu" id="solu"></textarea>
              </div>
              <!--<div class="col-sm-6">
                <label for="fsol" class="control-label">Fecha Resolvió/Canceló</label>
                <input type="text" name="fsol" id="fsol" class="form-control" value="<?php echo date('d/m/Y H:i') ?>" readonly>
              </div>-->

              <div class="col-md-12">
                <br>
                <div id="resultado">
                  
                </div>
              </div>
        </div>


        <script>
          $(".select2med").select2();
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
