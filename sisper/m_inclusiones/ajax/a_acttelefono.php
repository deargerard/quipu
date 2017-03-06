<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idt"]) && !empty($_POST["idt"])){
    $idt=iseguro($cone,$_POST["idt"]);
    $cte=mysqli_query($cone,"SELECT TipoTelefono, Numero FROM telefonoemp AS te INNER JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idTelefonoEmp=$idt");
    $rte=mysqli_fetch_assoc($cte);
  ?>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Esta seguro que desea activar el siguiente teléfono:</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h4 class="text-maroon"><?php echo $rte['TipoTelefono'].": ".$rte['Numero'] ?></h4></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="idte" value="<?php echo $idt ?>">
  <?php
    mysqli_free_result($cte);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se eligio ningún teléfono.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>