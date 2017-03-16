<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  $idamb=iseguro($cone,$_POST["idamb"]);
  if(isset($idamb) && !empty($idamb)){
    $camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, tl.Tipo, de.Denominacion, l.Direccion, p.Piso, dl.Oficina, dl.Estado  FROM dependencialocal dl INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN dependencia de ON dl.idDependencia=de.idDependencia INNER JOIN local l ON dl.idLocal=l.idLocal  WHERE idDependenciaLocal=$idamb ");
    $ramb=mysqli_fetch_assoc($camb);
  ?>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <?php
          if ($ramb['Estado']==1){
           ?>
          <th>¿Está seguro que desea desactivar el ambiente?</th>
          <?php
        } else {
          ?>
          <th>¿Está seguro que desea activar el ambiente?</th>
          <?php
        }
           ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><h5 class="text-fuchsia"><?php echo $ramb['Tipo'] ?></h5> </td>
          <td><h5 class="text-fuchsia"><?php echo $ramb['Oficina'] ?></h5></td>
        </tr>
        <tr>
          <td><?php echo $ramb['Denominacion'] ?></td>
        </tr>
        <tr>
          <td><?php echo $ramb['Direccion'] ?></td>
          <td><?php echo $ramb['Piso'] ?> </td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="idamb" id="idamb" value="<?php echo $idamb ?>">
  <?php
    mysqli_free_result($camb);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún ambiente.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>
