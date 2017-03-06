<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['tip']) && !empty($_POST['tip'])){
    $fec=fmysql(iseguro($cone,$_POST['fec']));
    $fecn=iseguro($cone,$_POST['fec']);
    $tip=iseguro($cone,$_POST['tip']);
    $casi=mysqli_query($cone,"SELECT * FROM marcacion WHERE Fecha='$fec' AND idTipMarcacion=$tip ORDER BY Hora ASC");
    if(mysqli_num_rows($casi)>0){
      $ctm=mysqli_query($cone,"SELECT * FROM tipmarcacion WHERE idTipMarcacion=$tip");
      $rtm=mysqli_fetch_assoc($ctm);
      $tm=$rtm['TipMarcacion'];
      mysqli_free_result($ctm);
      echo "<h3 class='text-maroon'>Registros de $tm del $fecn.</h3>";
?>
    <table class="table" id="dtasistencia">
      <thead>
        <tr>
          <th>#</th>
          <th>HORA</th>
          <th>EMPLEADO</th>
          <th>VIGILANTE</th>
        </tr>
      </thead>
      <tbody>
<?php
      $j=0;
      while($rasi=mysqli_fetch_assoc($casi)){
        $j++;
?>
        <tr>
          <td><?php echo $j; ?></td>
          <td><?php echo $rasi['Hora']; ?></td>
          <td><?php echo nomempleado($cone,$rasi['idEmpleado']); ?></td>
          <td><?php echo nomvigilante($cone,$rasi['idVigilante']); ?></td>
        </tr>
<?php
      }
?>
      </tbody>
    </table>
    <script>
      $('#dtasistencia').DataTable();
    </script>
<?php
    }else{
      echo mensajeda("Error: No se encontraron registros.");
    }
    mysqli_free_result($casi);
  }else{
    echo mensajeda("Error: No envio datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>