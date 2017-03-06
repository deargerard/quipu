<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $cb=mysqli_query($cone,"SELECT * FROM boletin WHERE idBoletin=$id");
    if($rb=mysqli_fetch_assoc($cb)){
?>
        <div class="form-group valida">
          <label for="des" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            <input type="hidden" name="idbol" value="<?php echo $id; ?>">
            <input type="text" name="des" id="des" class="form-control" value="<?php echo $rb['Descripcion']; ?>">
          </div>
        </div>
        <div class="form-group has-feedback valida">
          <label for="fecb" class="col-sm-2 control-label">Fecha</label>
          <div class="col-sm-4">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fecb" id="fecb" class="form-control" value="<?php echo fnormal($rb['Fecha']); ?>">
          </div>
            <script>
          //fecha intranet
          $('#fecb').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true
          });
          //fin fecha intranet
          </script>
        </div>
<?php
    }else{
      echo mensajeda("Error: No se encontro ningún registro con los datos enviados.");
    }
  }else{
    echo mensajeda("Error: No se enviarón datos.");
  }
}else{
  echo accrestringidoa();
}
?>
