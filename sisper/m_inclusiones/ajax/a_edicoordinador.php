<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  if(isset($_POST['idco']) && !empty($_POST['idco'])){
    $idco=iseguro($cone,$_POST['idco']);
    $c1=mysqli_query($cone,"SELECT * FROM coordinador co INNER JOIN coordinacion coo ON co.idCoordinacion=coo.idCoordinacion WHERE idCoordinador=$idco");
    if($r1=mysqli_fetch_assoc($c1)){
?>
        
          <div class="form-group">
            <label for="coo" class="col-sm-3 control-label">Coordinación</label>
            <div class="col-sm-9 valida">
              <input type="hidden" name="idco" id="idco" value="<?php echo $idco; ?>">
              <input type="text" name="coo" id="coo" class="form-control" disabled value="<?php echo $r1['Denominacion']; ?>">
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
                    if($r1['idEmpleado']==$r['idEmpleado']){
                ?>
                <option value="<?php echo $r['idEmpleado']; ?>" selected><?php echo $r['ApellidoPat']." ".$r['ApellidoMat'].", ".$r['Nombres']; ?></option>
                <?php
                    }else{
                ?>
                <option value="<?php echo $r['idEmpleado']; ?>"><?php echo $r['ApellidoPat']." ".$r['ApellidoMat'].", ".$r['Nombres']; ?></option>
                <?php
                    }
                  }
                }
                mysqli_free_result($c);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="con" class="col-sm-3 control-label">Condición</label>
            <div class="col-sm-4 valida">
              <select name="con" id="con" class="form-control">
                <option value="">CONDICIÓN</option>
                <option value="1" <?php echo $r1['Condicion']==1 ? 'selected' : ''; ?>>OFICIAL</option>
                <option value="2" <?php echo $r1['Condicion']==2 ? 'selected' : ''; ?>>ENCARGADO</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="fecini" class="col-sm-3 control-label">Fecha Inicio</label>
            <div class="col-sm-3 valida">
              <input type="text" class="form-control" id="fecini" name="fecini" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r1['FecInicio']); ?>">
            </div>
          </div>
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
    }else{
      echo mensajewa("Error: No se encontró ningún registro con los datos enviados.");
    }
    mysqli_free_result($c1);
  }else{
    echo mensajewa("Error: No se enviaron datos correctamente.");
  }
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
        