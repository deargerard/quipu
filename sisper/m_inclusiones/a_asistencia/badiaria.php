<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['fec']) && !empty($_POST['fec'])){
    $fecn=iseguro($cone,$_POST['fec']);
    $fec=fmysql($fecn);
    $casi=mysqli_query($cone,"SELECT * FROM marcacion WHERE DATE_FORMAT(Marcacion, '%Y-%m-%d')='$fec' ORDER BY Marcacion ASC");
    if(mysqli_num_rows($casi)>0){

      echo "<h3><i class='fa fa-calendar-check-o text-gray'></i> <span class='text-orange'>Marcaciones del $fecn</span></h3>";
?>
    <table class="table table-bordered table-hover" id="dtasistencia">
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
          <td><?php echo date("h:m:i A",strtotime($rasi['Marcacion'])); ?></td>
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