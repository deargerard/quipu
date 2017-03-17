<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
?>
        
          <div class="form-group">
            <label for="coo" class="col-sm-3 control-label">Coordinación</label>
            <div class="col-sm-9 valida">
              <select name="coo" id="coo" class="form-control select2" style="width: 100%;">
                <option value="">COORDINACIÓN</option>
                <?php
                $c=mysqli_query($cone,"SELECT idCoordinacion, Denominacion FROM coordinacion WHERE Estado=1 ORDER BY Denominacion ASC");
                if(mysqli_num_rows($c)>0){
                  while($r=mysqli_fetch_assoc($c)){
                ?>
                <option value="<?php echo $r['idCoordinacion']; ?>"><?php echo $r['Denominacion']; ?></option>
                <?php
                  }
                }
                mysqli_free_result($c);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="cood" class="col-sm-3 control-label">Coordinador</label>
            <div class="col-sm-9 valida">
              <select name="cood" id="cood" class="form-control select2" style="width: 100%;">
                <option value="">COORDINADOR</option>
                <?php
                $c=mysqli_query($cone,"SELECT idEmpleado, ApellidoPat, ApellidoMat, Nombres FROM empleado WHERE Estado=1 ORDER BY ApellidoPat ASC, ApellidoMat ASC, Nombres ASC");
                if(mysqli_num_rows($c)>0){
                  while($r=mysqli_fetch_assoc($c)){
                ?>
                <option value="<?php echo $r['idEmpleado']; ?>"><?php echo $r['ApellidoPat']." ".$r['ApellidoMat'].", ".$r['Nombres']; ?></option>
                <?php
                  }
                }
                mysqli_free_result($c);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="con" class="col-sm-3 control-label">Condición</label>
            <div class="col-sm-3 valida">
              <select name="con" id="con" class="form-control">
                <option value="">CONDICIÓN</option>
                <option value="1">OFICIAL</option>
                <option value="2">ENCARGADO</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="fecini" class="col-sm-3 control-label">Fecha Inicio</label>
            <div class="col-sm-3 valida">
              <input type="text" class="form-control" id="fecini" name="fecini" placeholder="dd/mm/aaaa">
            </div>
          </div>
          <!-- <div class="form-group">
            <label for="fecfin" class="col-sm-3 control-label">Fecha Fin</label>
            <div class="col-sm-3 valida">
              <input type="text" class="form-control" id="fecfin" name="fecfin" placeholder="dd/mm/aaaa">
            </div>
          </div> -->
          <script>
            $('#fecini').datepicker({
              format: "dd/mm/yyyy",
              language: "es",
              todayHighlight: true,
              autoclose: true
            });
            $(".select2").select2();
          </script>
<?php
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
        