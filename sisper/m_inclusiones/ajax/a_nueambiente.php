<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
?>
          <div class="form-group">
            <label for="dir" class="col-sm-3 control-label">Dependencia</label>
            <div class="col-sm-9 valida">
              <select name="dep" id="dep" class="form-control select2" style="width: 100%">
                <option value="">DEPENDENCIA</option>
                <?php
                  $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY idDependencia ASC");
                  while($rdep=mysqli_fetch_assoc($cdep)){
                ?>
                <option value="<?php echo $rdep['idDependencia'] ?>"><?php echo $rdep['Denominacion'] ?></option>
                <?php
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
                <option value="">TIPO AMBIENTE</option>
                <?php
                  $ctip=mysqli_query($cone,"SELECT * FROM tipolocal WHERE Estado=1 ORDER BY Tipo ASC");
                  while($rtip=mysqli_fetch_assoc($ctip)){
                ?>
                <option value="<?php echo $rtip['idTipoLocal'] ?>"><?php echo $rtip['Tipo'] ?></option>
                <?php
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
                <option value="">DISTRITO - DIRECCIÓN</option>
                <?php
                  $cloc=mysqli_query($cone,"SELECT idLocal, Direccion, idDistrito FROM local WHERE Estado=1 ORDER BY idDistrito ASC");
                  while($rloc=mysqli_fetch_assoc($cloc)){
                ?>
                <option value="<?php echo $rloc['idLocal'] ?>"><?php echo nomdistrito($cone,$rloc['idDistrito'])." - ".$rloc['Direccion'] ?></option>
                <?php
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
                  $cpis=mysqli_query($cone,"SELECT * FROM piso WHERE Estado=1 ORDER BY Piso ASC");
                  while($rpis=mysqli_fetch_assoc($cpis)){
                ?>
                <option value="<?php echo $rpis['idPiso'] ?>"><?php echo $rpis['Piso'] ?></option>
                <?php
                  }
                  mysqli_free_result($cpis);
                ?>
              </select>
            </div>
            <label for="ofi" class="col-sm-3 control-label">Oficina</label>
            <div class="col-sm-3 valida">
              <input type="text" class="form-control" id="ofi" name="ofi" placeholder="Oficina">
            </div>
          </div>
<script>
$(".select2").select2();
</script>
<?php
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
