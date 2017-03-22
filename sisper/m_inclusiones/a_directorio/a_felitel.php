<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=iseguro($cone,$_POST["id"]);
    $c=mysqli_query($cone,"SELECT TipoTelefono, Numero FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idTelefonoEmp=$id;");
    $r=mysqli_fetch_assoc($c);
  ?>
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">¿Está seguro que desea eliminar el número de teléfono?</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="text-maroon text-center"><?php echo $r['TipoTelefono'].": ".$r['Numero'] ?></h4></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="id" value="<?php echo $id ?>">
  <?php
    mysqli_free_result($c);
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se eligio ningún teléfono.");
  }
}else{
  echo accrestringidoa();
}
?>