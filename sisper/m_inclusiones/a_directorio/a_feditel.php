<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $c=mysqli_query($cone,"SELECT idTipoTelefono, Numero FROM telefonoemp WHERE idTelefonoEmp=$id");
    if($r=mysqli_fetch_assoc($c)){
?>
          <div class="form-group valida">
            <label for="tiptel" class="col-sm-5 control-label">Tipo Teléfono</label>
            <div class="col-sm-7">
              <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
              <select name="tiptel" id="tiptel" class="form-control">
                <option value="">TIPO TELÉFONO</option>
                <?php
                  $ctt=mysqli_query($cone,"SELECT idTipoTelefono, TipoTelefono FROM tipotelefono WHERE Estado=1 ORDER BY TipoTelefono ASC");
                  while($rtt=mysqli_fetch_assoc($ctt)){
                    if($rtt['idTipoTelefono']==$r['idTipoTelefono']){
                ?>
                <option value="<?php echo $rtt['idTipoTelefono'] ?>" selected><?php echo $rtt['TipoTelefono'] ?></option>
                <?php
                    }else{
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
            <label for="num" class="col-sm-5 control-label">Número</label>
            <div class="col-sm-7">
              <input type="text" class="form-control" id="num" name="num" placeholder="Número" value="<?php echo $r['Numero']; ?>">
            </div>
          </div>
<?php
    }else{
      echo mensajewa("Error: No se eligio un teléfono válido.");
    }
    mysqli_free_result($c);
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
        