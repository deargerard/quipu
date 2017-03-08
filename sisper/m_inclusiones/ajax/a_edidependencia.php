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
                <select name="pad" id="pad" class="form-control">
                  <option value="">DEPENDENCIA SUPERIOR</option>
                  <?php
                    $cdep1=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY idDependencia ASC");
                    while($rdep1=mysqli_fetch_assoc($cdep1)){
                      if ($rdep1['idDependencia']==$rdep['idDependenciaPadre']){
                  ?>
                  <option value="<?php echo $rdep1['idDependencia'] ?>" selected><?php echo $rdep1['Denominacion'] ?></option>
                  <?php
                      }
                  ?>
                  <option value="<?php echo $rdep1['idDependencia'] ?>"><?php echo $rdep1['Denominacion'] ?></option>
                  <?php
                    }
                    mysqli_free_result($cdep1);
                  ?>
                </select>

                <input type="hidden" name="iddep" value="<?php echo $idd ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="sig" class="col-sm-3 control-label">Siglas</label>
              <div class="col-sm-6 valida">
                <input type="text" class="form-control" id="sig" name="sig" placeholder="Siglas" value="<?php echo $rdep['Siglas'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="loc" class="col-sm-3 control-label">Local</label>
              <div class="col-sm-9 valida">
                <select name="loc" id="loc" class="form-control">
                  <option value="">DISTRITO - DIRECCIÓN</option>
                  <?php
                    $cloc=mysqli_query($cone,"SELECT idLocal, Direccion, idDistrito FROM local WHERE Estado=1 ORDER BY idDistrito ASC");
                    while($rloc=mysqli_fetch_assoc($cloc)){
                      if($rdep['idLocal']==$rloc['idLocal']){
                  ?>
                  <option value="<?php echo $rloc['idLocal'] ?>" selected><?php echo nomdistrito($cone,$rloc['idDistrito'])." - ".$rloc['Direccion'] ?></option>
                  <?php
                      }else{
                  ?>
                  <option value="<?php echo $rloc['idLocal'] ?>"><?php echo nomdistrito($cone,$rloc['idDistrito'])." - ".$rloc['Direccion'] ?></option>
                  <?php
                      }
                    }
                    mysqli_free_result($cloc);
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
