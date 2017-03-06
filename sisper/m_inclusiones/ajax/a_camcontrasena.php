<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],7)){
  if(isset($_POST['idd']) && !empty($_POST['idd'])){
  $idd=iseguro($cone,$_POST['idd']);
  $ce=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, NumeroDoc FROM empleado WHERE idEmpleado=$idd");
    if($re=mysqli_fetch_assoc($ce)){
  ?>
            <div class="row">
              <div class="col-sm-2">
                <img src="<?php echo mfotom($re['NumeroDoc']) ?>" alt="Personal" class="img-thumbnail">
              </div>
              <div class="col-sm-10">
                <h3 class="text-maroon"><?php echo $re['ApellidoPat']." ".$re['ApellidoMat'].", ".$re['Nombres'] ?></h3>
              </div>
              <div class="col-sm-12">
                <br>
              </div>
            </div>
            <div id="r_gcamcontrasena">
              <div class="form-group valida">
                <label for="nuecon" class="col-sm-3 control-label">Nueva Contraseña</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" id="nuecon" name="nuecon" placeholder="Nueva contraseña">
                  <input type="hidden" id="idemp" name="idemp" value="<?php echo $idd ?>">
                </div>
              </div>
              <div class="form-group valida">
                <label for="rnuecon" class="col-sm-3 control-label">Repetir Contraseña</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" id="rnuecon" name="rnuecon" placeholder="Repetir contraseña">
                </div>
              </div>
            </div>
  <?php
    }else{
  ?>
    <div class="row">
      <div class="col-sm-12">
        <h3 class="text-maroon">Error: No se encontró personal.</h3>
      </div>
    </div>
  <?php
    }
    mysqli_free_result($ce);
    mysqli_close($cone);
  }else{
  ?>
  <div class="row">
    <div class="col-sm-12">
      <h3 class="text-maroon">Error: No se eligió a ningún personal.</h3>
    </div>
  </div>
<?php
  }
}else{
  echo accrestringidoa();
}
?>  