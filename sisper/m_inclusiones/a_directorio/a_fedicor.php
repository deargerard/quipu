<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['tc']) && !empty($_POST['tc'])){
    $id=iseguro($cone,$_POST['id']);
    $tc=iseguro($cone,$_POST['tc']);
    if($tc==1){
      $c=mysqli_query($cone,"SELECT CorreoIns FROM empleado WHERE idEmpleado=$id");
      $r=mysqli_fetch_assoc($c);
      $cor=$r['CorreoIns'];
    }elseif($tc==2){
      $c=mysqli_query($cone,"SELECT CorreoPer FROM empleado WHERE idEmpleado=$id");
      $r=mysqli_fetch_assoc($c);
      $cor=$r['CorreoPer'];
    }
?>
          <h4 class="text-aqua text-center"><strong><?php echo $tc==1 ? "Institucional" : "Personal"; ?></strong></h4>
          <div class="form-group valida">
            <label for="cor" class="col-sm-2 control-label">Correo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="cor" name="cor" placeholder="Correo" value="<?php echo $cor; ?>">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="hidden" name="tc" value="<?php echo $tc; ?>">
            </div>
          </div>
<?php

    mysqli_free_result($c);
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
        