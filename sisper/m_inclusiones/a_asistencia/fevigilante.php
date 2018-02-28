<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $cv=mysqli_query($cone,"SELECT * FROM vigilante WHERE idVigilante=$id");
    if($rv=mysqli_fetch_assoc($cv)){
?>
        <div class="form-group valida">
          <label for="ape" class="col-sm-2 control-label">Apellidos</label>
          <div class="col-sm-10">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="ape" id="ape" class="form-control" value="<?php echo $rv['Apellidos']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="nom" class="col-sm-2 control-label">Nombres</label>
          <div class="col-sm-10">
            <input type="text" name="nom" id="nom" class="form-control" value="<?php echo $rv['Nombres']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="dni" class="col-sm-2 control-label">DNI</label>
          <div class="col-sm-5">
            <input type="text" name="dni" id="dni" class="form-control" value="<?php echo $rv['DNI']; ?>">
          </div>
        </div>
<?php
    }else{
      echo mensajeda("Error: Los datos enviados no son válidos.");
    }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
