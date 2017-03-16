<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  if(isset($_POST['idamb']) && !empty($_POST['idamb'])){
    $idamb=iseguro($cone,$_POST['idamb']);
    $camb=mysqli_query($cone,"SELECT * FROM dependencialocal WHERE idDependenciaLocal=$idamb");
    if($ramb=mysqli_fetch_assoc($camb)){
?>
<div class="form-group">
  <label for="dir" class="col-sm-3 control-label">Dependencia</label>
  <div class="col-sm-9 valida">
    <input type="hidden" name="amb" value="<?php echo $idamb ?>">
    <select name="dep" id="dep" class="form-control select2" style="width: 100%">
      <option value="">DEPENDENCIA</option>
      <?php
        $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY idDependencia ASC");
        while($rdep=mysqli_fetch_assoc($cdep)){
          if ($ramb['idDependencia']==$rdep['idDependencia']){
            ?>
            <option value="<?php echo $rdep['idDependencia'] ?>" selected="selected"><?php echo $rdep['Denominacion'] ?></option>
            <?php
          }else{
      ?>
      <option value="<?php echo $rdep['idDependencia'] ?>"><?php echo $rdep['Denominacion'] ?></option>
      <?php
                  }
        }
        mysqli_free_result($cdep);
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="den" class="col-sm-3 control-label">Tipo</label>
  <div class="col-sm-9 valida">
    <select name="den" id="den" class="form-control">
      <option value="">TIPO</option>
      <?php
        $ctip=mysqli_query($cone,"SELECT *  FROM tipolocal WHERE Estado=1 ORDER BY Tipo ASC");
        while($rtip=mysqli_fetch_assoc($ctip)){
          if ($ramb['idTipoLocal']==$rtip['idTipoLocal']){
            ?>
            <option value="<?php echo $rtip['idTipoLocal'] ?>" selected="selected"><?php echo $rtip['Tipo'] ?></option>
            <?php
          }else{
      ?>
      <option value="<?php echo $rtip['idTipoLocal'] ?>" ><?php echo $rtip['Tipo'] ?></option>
      <?php
                  }
        }
        mysqli_free_result($ctip);
      ?>
    </select>
  </div>
</div>
<div class="form-group">
  <label for="loc" class="col-sm-3 control-label">Local</label>
  <div class="col-sm-9 valida">
    <select name="loc" id="loc" class="form-control select2" style="width:100%">
      <option value="">DISTRITO-LOCAL</option>
      <?php
        $cloc=mysqli_query($cone,"SELECT idLocal, Direccion, idDistrito FROM local WHERE Estado=1 ORDER BY idDistrito ASC");
        while($rloc=mysqli_fetch_assoc($cloc)){
          if($ramb['idLocal']==$rloc['idLocal']){
            ?>
            <option value="<?php echo $rloc['idLocal'] ?>" selected="selected"><?php echo nomdistrito($cone,$rloc['idDistrito'])." - ".$rloc['Direccion'] ?></option>
            <?php
          } else {
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
  <label for="pis" class="col-sm-3 control-label">Piso</label>
  <div class="col-sm-3 valida">
    <select name="pis" id="pis" class="form-control">
      <option value="">PISO</option>
      <?php
        $cpis=mysqli_query($cone,"SELECT *  FROM piso WHERE Estado=1 ORDER BY IdPiso ASC");
        while($rpis=mysqli_fetch_assoc($cpis)){
          if ($ramb['idPiso']==$rpis['idPiso']){
            ?>
            <option value="<?php echo $rpis['idPiso'] ?>" selected="selected"><?php echo $rpis['Piso'] ?></option>
            <?php
          }else{
      ?>
      <option value="<?php echo $rpis['idPiso'] ?>" ><?php echo $rpis['Piso'] ?></option>
      <?php
                  }
        }
        mysqli_free_result($cpis);
      ?>
    </select>
  </div>
  <label for="ofi" class="col-sm-3 control-label">Oficina</label>
  <div class="col-sm-3 valida">
    <input type="text" class="form-control" id="ofi" name="ofi" value="<?php echo $ramb['Oficina'] ?>">
  </div>
</div>
<script>
$(".select2").select2({
dropdownParent: $('#m_ediambiente')
});
</script>

<?php
    }else{
      echo  mensajewa("error: No seleccionó ningún ambiente ");
    }
    mysqli_free_result($camb);
    mysqli_close($cone);
  }else{
    echo  mensajewa("error: No seleccionó ningún ambiente ");
  }
}else{
  echo accrestringidoa();
}
?>
