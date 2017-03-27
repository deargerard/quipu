<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['idtd']) && !empty($_POST['idtd']) && isset($_POST['iddep']) && !empty($_POST['iddep'])){
    $idtel=iseguro($cone,$_POST['idtd']);
    $iddep=iseguro($cone,$_POST['iddep']);
    $ctel=mysqli_query($cone,"SELECT * FROM telefonodep WHERE idTelefonoDep=$idtel");
    if($rtel=mysqli_fetch_assoc($ctel)){
      ?>
          <div class="form-group valida">
            <label for="amb" class="col-sm-3 control-label">Ambiente</label>
            <div class="col-sm-9">
              <input type="hidden" name="idtd" value="<?php echo $idtel ?>">
              <select name="amb" id="amb" class="form-control">
                <option value="">Ambiente</option>
                <?php
                  $ctt=mysqli_query($cone,"SELECT dl.idDependenciaLocal, dl.Estado, t.Tipo, dl.Oficina, l.Direccion, p.Piso FROM dependencialocal as dl INNER JOIN local AS l ON dl.idLocal=l.idLocal INNER JOIN tipolocal AS t ON dl.idTipoLocal= t.idTipoLocal INNER JOIN piso AS p ON dl.idPiso=p.idPiso WHERE dl.idDependencia=$iddep and dl.Estado=1");
                  while($rtt=mysqli_fetch_assoc($ctt)){
                    if($rtt['idDependenciaLocal']==$rtel['idDependenciaLocal']){
                      ?>
                        <option value="<?php echo $rtt['idDependenciaLocal'] ?>" selected><?php echo $rtt['Tipo'] ."-".$rtt['Oficina']."-".$rtt['Piso']."-".$rtt['Direccion']; ?></option>
                      <?php
                    }else{
                ?>
                        <option value="<?php echo $rtt['idDependenciaLocal'] ?>" ><?php echo $rtt['Tipo'] ."-".$rtt['Oficina']."-".$rtt['Piso']."-".$rtt['Direccion']; ?></option>
                <?php
                          }
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
                    if($rtt['idTipoTelefono']==$rtel['idTipoTelefono']){
                      ?>
                      <option value="<?php echo $rtt['idTipoTelefono'] ?>" selected ><?php echo $rtt['TipoTelefono'] ?></option>
                      <?php
                  }else {

                      ?>
                      <option value="<?php echo $rtt['idTipoTelefono'] ?>"><?php echo $rtt['TipoTelefono'] ?></option>
                      <?php
                        }
                  }
                  mysqli_free_result($ctt);
                ?>
              </select>
            </div>
          </div>
          <div class="form-group valida">
            <label for="num" class="col-sm-3 control-label">Número</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="num" name="num" placeholder="Número" value="<?php echo $rtel['Numero'] ?>">
            </div>
          </div>
          <div class="form-group valida">
            <label for="Eqtra" class="col-sm-3 control-label">Equipo de trabajo</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="eqtra" name="eqtra" placeholder="Equipo de Trabajo" value="<?php echo $rtel['EquipoTra'] ?>">
            </div>
          </div>
<?php
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún teléfono.");
  }
}else{
  echo accrestringidoa();
}
}
?>
