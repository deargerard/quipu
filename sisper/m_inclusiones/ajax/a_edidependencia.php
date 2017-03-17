<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  $idd=iseguro($cone,$_POST["idd"]);
  if(isset($idd) && !empty($idd)){
    $cdep=mysqli_query($cone,"SELECT * FROM dependencia WHERE idDependencia=$idd");
    $rdep=mysqli_fetch_assoc($cdep);
  ?>
            <div class="form-group">
              <label for="den" class="col-sm-3 control-label">Denominación</label>
              <div class="col-sm-9 valida">
                <input type="text" class="form-control" id="den" name="den" placeholder="Denominación de la dependencia" value="<?php echo $rdep['Denominacion'] ?>">
                <input type="hidden" name="iddep" value="<?php echo $idd ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="pad" class="col-sm-3 control-label">Dependencia Superior</label>
              <div class="col-sm-9 valida">
                <select name="pad" id="pad" class="form-control select2" style="width:100%">
                  <option value="">DEPENDENCIA SUPERIOR</option>
                  <?php
                    $cdep1=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY idDependencia ASC");
                    while($rdep1=mysqli_fetch_assoc($cdep1)){
                      if ($rdep1['idDependencia']==$rdep['idDependenciaPadre']){
                  ?>
                  <option value="<?php echo $rdep1['idDependencia'] ?>" selected><?php echo $rdep1['Denominacion'] ?></option>
                  <?php
                      }else{
                  ?>
                  <option value="<?php echo $rdep1['idDependencia'] ?>"><?php echo $rdep1['Denominacion'] ?></option>
                  <?php
                      }
                    }
                    mysqli_free_result($cdep1);
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="sig" class="col-sm-3 control-label">Siglas</label>
              <div class="col-sm-6 valida">
                <input type="text" class="form-control" id="sig" name="sig" placeholder="Siglas" value="<?php echo $rdep['Siglas'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="jef" class="col-sm-3 control-label">Responsable</label>
              <div class="col-sm-9 valida">
                <select name="jef" id="jef" class="form-control select2" style="width:100%">
                  <option value="">RESPONSABLE</option>
                  <?php
                    $cemp=mysqli_query($cone,"SELECT idEmpleado, concat(ApellidoPat, ' ', ApellidoMat, ', ', Nombres) AS nombre FROM empleado  ORDER BY nombre ASC");
                    while($remp=mysqli_fetch_assoc($cemp)){
                      if($rdep['Jefe']==$remp['idEmpleado']){
                  ?>
                  <option value="<?php echo $remp['idEmpleado'] ?>" selected><?php echo $remp['nombre'] ?></option>
                  <?php
                      }else{
                  ?>
                  <option value="<?php echo $remp['idEmpleado'] ?>" ><?php echo $remp['nombre'] ?></option>
                  <?php
                      }
                    }
                    mysqli_free_result($cemp);
                  ?>
                </select>
              </div>
            </div>
          <div class="form-group">
            <label for="coo" class="col-sm-3 control-label">Coordinación</label>
            <div class="col-sm-9 valida">
              <select name="coo" id="coo" class="form-control select2" style="width:100%">
                <option value="">COORDINACIÓN</option>
                <?php
                  $ccoo=mysqli_query($cone,"SELECT idCoordinacion, Denominacion FROM coordinacion WHERE Estado=1 ORDER BY Denominacion ASC");
                  while($rcoo=mysqli_fetch_assoc($ccoo)){
                    if($rdep['idCoordinacion']==$rcoo['idCoordinacion']){
                ?>
                <option value="<?php echo $rcoo['idCoordinacion'] ?>" selected><?php echo $rcoo['Denominacion'] ?></option>
                <?php
                    }else{
                ?>
                <option value="<?php echo $rcoo['idCoordinacion'] ?>"><?php echo $rcoo['Denominacion'] ?></option>
                <?php
                    }
                  }
                  mysqli_free_result($ccoo);
                ?>
              </select>
            </div>
          </div>
            <div class="form-group">
              <label for="disfis" class="col-sm-3 control-label">Distrito Fiscal</label>
              <div class="col-sm-9 valida">
                <select name="disfis" id="disfis" class="form-control">
                  <option value="">DISTRITO FISCAL</option>
                  <?php
                    $cdisfis=mysqli_query($cone,"SELECT idDistritoFiscal, Denominacion FROM distritofiscal WHERE Estado=1 ORDER BY idDistritoFiscal ASC");
                    while($rdisfis=mysqli_fetch_assoc($cdisfis)){
                      if($rdep['idDistritoFiscal']==$rdisfis['idDistritoFiscal']){
                  ?>
                  <option value="<?php echo $rdisfis['idDistritoFiscal'] ?>" selected><?php echo $rdisfis['Denominacion'] ?></option>
                  <?php
                      }else{
                  ?>
                  <option value="<?php echo $rdisfis['idDistritoFiscal'] ?>"><?php echo $rdisfis['Denominacion'] ?></option>
                  <?php
                      }
                    }
                    mysqli_free_result($cdisfis);
                  ?>
                </select>
              </div>
            </div>
            <script>
            $(".select2").select2();
            </script>
  <?php
    mysqli_free_result($cdep);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna dependencia.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>
