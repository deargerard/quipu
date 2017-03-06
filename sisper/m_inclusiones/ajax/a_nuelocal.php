<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
?>
        
          <div class="form-group">
            <label for="dir" class="col-sm-3 control-label">Dirección</label>
            <div class="col-sm-9 valida">
              <input type="text" class="form-control" id="dir" name="dir" placeholder="Dirección del local">
            </div>
          </div>
          <div class="form-group">
            <label for="urb" class="col-sm-3 control-label">Urbanización</label>
            <div class="col-sm-9 valida">
              <input type="text" class="form-control" id="urb" name="urb" placeholder="Urbanización">
            </div>
          </div>
          <div class="form-group">
            <label for="depubi" class="col-sm-3 control-label">Ubicación</label>
            <div class="col-sm-3 valida">
              <select name="depubi" id="depubi" class="form-control" onChange="cprovinciad(this.value)">
                <option value="">DEPARTAMENTO</option>
                <?php echo listadep($cone) ?>
              </select>
            </div>
            <div class="col-sm-3 valida">
              <select name="proubi" id="proubi" class="form-control" onChange="cdistritod(this.value)">
                <option value="">PROVINCIA</option>
              </select>
            </div>
            <div class="col-sm-3 valida">
              <select name="disubi" id="disubi" class="form-control">
                <option value="">DISTRITO</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tel" class="col-sm-3 control-label">N° Teléfono</label>
            <div class="col-sm-9 valida">
              <input type="text" class="form-control" id="tel" name="tel" placeholder="N° Teléfono">
            </div>
          </div>
          <div class="form-group">
            <label for="obs" class="col-sm-3 control-label">Observación</label>
            <div class="col-sm-9 valida">
              <input type="text" class="form-control" id="obs" name="obs" placeholder="Observación">
            </div>
          </div>
<?php
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
        