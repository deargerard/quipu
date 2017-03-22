<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['idtd']) && !empty($_POST['idtd'])){
    $idtel=iseguro($cone,$_POST['idtd']);
    $amb=iseguro($cone,$_POST['amb']);
?>
<input type="hidden" name="idtd" value="<?php echo $idtel; ?>">
<table class="table">
  <thead>
    <tr>
      <th>
        <p class="text-center text-maroon">¿Está seguro que desea eliminar el teléfono?</p>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center">
        <strong>
        <?php
          echo $amb;
         ?>
       </strong>
      </td>
    </tr>
  </tbody>
</table>

<?php
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún teléfono.");
  }
}else{
  echo accrestringidoa();
}
?>
