<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['iddep']) && !empty($_POST['iddep'])){
    $iddep=iseguro($cone,$_POST['iddep']);
?>
          <div class="form-group valida">
            <label for="amb" class="col-sm-3 control-label">Ambiente</label>
            <div class="col-sm-9">
              <select name="amb" id="amb" class="form-control">
                <option value="">AMBIENTE</option>
                <?php
                  $ctt=mysqli_query($cone,"SELECT dl.idDependenciaLocal, dl.Estado, t.Tipo, dl.Oficina, l.Direccion, p.Piso FROM dependencialocal as dl INNER JOIN local AS l ON dl.idLocal=l.idLocal INNER JOIN tipolocal AS t ON dl.idTipoLocal= t.idTipoLocal INNER JOIN piso AS p ON dl.idPiso=p.idPiso WHERE dl.idDependencia=$iddep and dl.Estado=1");
                  while($rtt=mysqli_fetch_assoc($ctt)){
                ?>
                <option value="<?php echo $rtt['idDependenciaLocal'] ?>"><?php echo $rtt['Tipo']?> - <?php echo $rtt['Oficina']?> - <?php echo $rtt['Piso']?> - <?php echo $rtt['Direccion']?></option>
                <?php
                  }
                  mysqli_free_result($ctt);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group valida">
            <label for="tiptel" class="col-sm-3 control-label">Tipo Teléfono</label>
            <div class="col-sm-9">
              <select name="tiptel" id="tiptel" class="form-control">
                <option value="">TIPO TELÉFONO</option>
                <?php
                  $ctt=mysqli_query($cone,"SELECT idTipoTelefono, TipoTelefono FROM tipotelefono WHERE Estado=1 ORDER BY TipoTelefono ASC");
                  while($rtt=mysqli_fetch_assoc($ctt)){
                ?>
                <option value="<?php echo $rtt['idTipoTelefono'] ?>"><?php echo $rtt['TipoTelefono'] ?></option>
                <?php
                  }
                  mysqli_free_result($ctt);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group valida">
            <label for="num" class="col-sm-3 control-label">Número</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="num" name="num" placeholder="Número">
            </div>
          </div>
<?php
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
