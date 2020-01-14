<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"]) && isset($_POST["acc"]) && !empty($_POST["acc"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $acc=iseguro($cone,$_POST["acc"]);

   if($acc=='agrges'){
    $cs=mysqli_query($cone, "SELECT Sexo FROM empleado WHERE idEmpleado=$idp;");
    if($rs=mysqli_fetch_assoc($cs)){
      $se=$rs['Sexo'];
    

  ?>
      <div class="form-group">        
        <div class="col-sm-12" <?php echo $se=='F' ? 'style="display: none;"' : ''; ?>>
          <label for="ges" class="control-label">Gestante <small class="text-red">*</small></label>
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <select class="form-control" name="ges" id="ges" style="width: 100%;">
          <?php
          if($se=='M'){
            $cg=mysqli_query($cone, "SELECT idPariente, CONCAT_WS(' ', ApellidoPat, ApellidoMat, Nombres) nompar FROM pariente WHERE idEmpleado=$idp AND (idTipoPariente=4 OR idTipoPariente=5 OR idTipoPariente=8) ORDER BY ApellidoPat, ApellidoMat, Nombres ASC;");
            if(mysqli_num_rows($cg)>0){
              while($rg=mysqli_fetch_assoc($cg)){
          ?>
            <option value="<?php echo $rg['idPariente']; ?>"><?php echo $rg['nompar']; ?></option>
          <?php
              }
            }
            mysqli_free_result($cg);
          }
          ?>
          </select>
        </div>
        <div class="col-sm-6">
            <label for="fur">Fecha última regla <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fur" name="fur" placeholder="dd/mm/aaaa">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="fpp">Fecha probable parto <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fpp" name="fpp" placeholder="dd/mm/aaaa">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>

        <div class="col-sm-12">
          <label for="esa" class="control-label">Establecimiento de Salud</label>
          <input type="text" name="esa" id="esa" class="form-control" placeholder="Establecimiento de Salud">
        </div>

        <div class="col-sm-12">
          <label for="obs" class="control-label">Observaciones</label>      
          <textarea class="form-control" name="obs" id="obs"></textarea>
        </div>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
      <script>
        $('#fur, #fpp').datepicker({
          format: "dd/mm/yyyy",
          language: "es",
          autoclose: true,
          todayHighlight: true,
          maxViewMode: 2,
        });
      </script>
  <?php
    }else{
      echo mensajewa("Error, no se encontró al personal.");
    }
    mysqli_free_result($cs);
   }elseif($acc=='ediges'){
    $cge=mysqli_query($cone, "SELECT * FROM gestante WHERE idgestante=$idp;");
    if($rge=mysqli_fetch_assoc($cge)){
      $ide=$rge['idEmpleado'];
      $cs=mysqli_query($cone, "SELECT Sexo FROM empleado WHERE idEmpleado=$ide;");
      if($rs=mysqli_fetch_assoc($cs)){
        $se=$rs['Sexo'];
      }
      mysqli_free_result($cs);

  ?>
      <div class="form-group">        
        <div class="col-sm-12" <?php echo $se=='F' ? 'style="display: none;"' : ''; ?>>
          <label for="ges" class="control-label">Gestante <small class="text-red">*</small></label>
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <input type="hidden" name="ide" value="<?php echo $ide; ?>">
          <select class="form-control" name="ges" id="ges" style="width: 100%;">       
          <?php
          if($se=='M'){
            $cg=mysqli_query($cone, "SELECT idPariente, CONCAT_WS(' ', ApellidoPat, ApellidoMat, Nombres) nompar FROM pariente WHERE idEmpleado=$idp AND (idTipoPariente=4 OR idTipoPariente=5 OR idTipoPariente=8) ORDER BY ApellidoPat, ApellidoMat, Nombres ASC;");
            if(mysqli_num_rows($cg)>0){
              while($rg=mysqli_fetch_assoc($cg)){
          ?>
            <option value="<?php echo $rg['idPariente']; ?>" <?php echo $rg['idPariente']==$rge['idPariente'] ? "selected" : ""; ?>><?php echo $rg['nompar']; ?></option>
          <?php
              }
            }
            mysqli_free_result($cg);
          }
          ?>
          </select>
        </div>
        <div class="col-sm-6">
            <label for="fur">Fecha última regla <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fur" name="fur" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rge['fur']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>
        <div class="col-sm-6">
            <label for="fpp">Fecha probable parto <small class="text-red">*</small></label>
            <div class="has-feedback">
              <input type="text" class="form-control" id="fpp" name="fpp" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rge['fpp']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
        </div>

        <div class="col-sm-12">
          <label for="esa" class="control-label">Establecimiento de Salud</label>
          <input type="text" name="esa" id="esa" class="form-control" placeholder="Establecimiento de Salud" value="<?php echo $rge['estsalud']; ?>">
        </div>

        <div class="col-sm-12">
          <label for="obs" class="control-label">Observaciones</label>      
          <textarea class="form-control" name="obs" id="obs"><?php echo $rge['observaciones']; ?></textarea>
        </div>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
      <script>
        $('#fur, #fpp').datepicker({
          format: "dd/mm/yyyy",
          language: "es",
          autoclose: true,
          todayHighlight: true,
          maxViewMode: 2,
        });
      </script>
  <?php
    }else{
      echo mensajewa("Error, no se encontró al personal.");
    }
    mysqli_free_result($cge);
   }elseif($acc=='eliges'){
    $cg=mysqli_query($cone, "SELECT idEmpleado FROM gestante WHERE idgestante=$idp;");
    if($rg=mysqli_fetch_assoc($cg)){
      $ide=$rg['idEmpleado'];
?>
      <div class="form-group">
          <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <input type="hidden" name="ide" value="<?php echo $ide; ?>">
          <h4 class="text-center"><i class="fa fa-info-circle text-orange"></i> Eliminará el registro de gestante. Si está seguro presione <b class="text-aqua">guardar</b>.</h4>
      </div>
      <div class="form-group" id="d_frespuesta">
          
      </div>
<?php
    }else{
      echo mensajewa("Datos inválidos.");
    }
    mysqli_free_result($cg);
   }
  }else{
    echo "<h4 class='text-maroon'>Error: No se envio datos</h4>";
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>