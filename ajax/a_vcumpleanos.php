<?php
  include ("../sisper/m_inclusiones/php/conexion_sp.php");
  include ("../sisper/m_inclusiones/php/funciones.php");
  $id=iseguro($cone,$_POST['idm']);
  $cd=mysqli_query($cone, "SELECT e.idEmpleado, e.ApellidoPat, e.ApellidoMat, e.Nombres, DATE_FORMAT(e.FechaNac, '%d') dia FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE DATE_FORMAT(e.FechaNac, '%m')=$id AND ec.idEstadoCar=1 ORDER BY dia, e.ApellidoPat, e.ApellidoMat, e.Nombres ASC;");
  if(mysqli_num_rows($cd)>0){
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <select class="form-control" onchange="cumpleanos(this.value);">
          <option value="01" <?php echo $id== '01' ? 'selected' : ''; ?>>ENERO</option>
          <option value="02" <?php echo $id== '02' ? 'selected' : ''; ?>>FEBRERO</option>
          <option value="03" <?php echo $id== '03' ? 'selected' : ''; ?>>MARZO</option>
          <option value="04" <?php echo $id== '04' ? 'selected' : ''; ?>>ABRIL</option>
          <option value="05" <?php echo $id== '05' ? 'selected' : ''; ?>>MAYO</option>
          <option value="06" <?php echo $id== '06' ? 'selected' : ''; ?>>JUNIO</option>
          <option value="07" <?php echo $id== '07' ? 'selected' : ''; ?>>JULIO</option>
          <option value="08" <?php echo $id== '08' ? 'selected' : ''; ?>>AGOSTO</option>
          <option value="09" <?php echo $id== '09' ? 'selected' : ''; ?>>SEPTIEMBRE</option>
          <option value="10" <?php echo $id== '10' ? 'selected' : ''; ?>>OCTUBRE</option>
          <option value="11" <?php echo $id== '11' ? 'selected' : ''; ?>>NOVIEMBRE</option>
          <option value="12" <?php echo $id== '12' ? 'selected' : ''; ?>>DICIEMBRE</option>
        </select>
        <hr>
        <h4 class="text-muted"><i class="fa fa-birthday-cake text-primary"></i> Cumpleañeros en <?php echo ucfirst(nombremes($id)); ?></h4>
        <table class="table table-bordered table-hover table-sm" id="dt_cumples">
          <thead>
            <tr>
              <th>Día</th>
              <th>Nombre</th>
              <th>Cargo</th>
              <th>Dependencia</th>
            </tr>
          </thead>
          <tbody>
<?php
    $n=0;
    while($rd=mysqli_fetch_assoc($cd)){
      $n++;
?>
            <tr>
              <td style="font-size: 12px;"><?php echo $rd['dia']; ?></td>
              <td style="font-size: 12px;"><?php echo $rd['ApellidoPat']." ".$rd['ApellidoMat']." ".$rd['Nombres']; ?></td>
              <td style="font-size: 10px;"><?php echo cargoe($cone, $rd['idEmpleado']); ?></td>
              <td style="font-size: 10px;"><?php echo dependenciae($cone, $rd['idEmpleado']); ?></td>
            </tr>
<?php
    }
?>
          </tbody>
        </table>
  <hr>
  <button class="btn btn-primary" data-dismiss="modal" type="button">
  <i class="fas fa-times"></i>
  Cerrar</button>
</div>
<script>
  $('#dt_cumples').DataTable();
</script>
<?php
  }else{
    echo mensajeda("No se encontraron cumpleañeros $id");
  }
  mysqli_free_result($cd);
  mysqli_close($cone);
?>