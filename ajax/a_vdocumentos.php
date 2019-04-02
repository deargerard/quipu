<?php
  include ("../sisper/m_inclusiones/php/conexion_sp.php");
  include ("../sisper/m_inclusiones/php/funciones.php");
  $id=iseguro($cone,$_POST['idd']);
  $cd=mysqli_query($cone, "SELECT * FROM documento WHERE idCatDocumento=$id AND Estado=1 ORDER BY idDocumento DESC;");
  if(mysqli_num_rows($cd)>0){
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
    $cc=mysqli_query($cone, "SELECT CatDocumento FROM catdocumento WHERE idCatDocumento=$id");
    if($rc=mysqli_fetch_assoc($cc)){
?>
      <h4 class="text-muted"><i class="fa fa-file-pdf text-primary"></i> <?php echo $rc['CatDocumento']; ?></h4>
      <hr>
<?php
    }
    mysqli_free_result($cc);
?>
        <table class="table table-bordered table-hover table-sm" id="dt_documentos">
          <thead>
            <tr>
              <th>#</th>
              <th>Documentos</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
<?php
    $n=0;
    while($rd=mysqli_fetch_assoc($cd)){
      $n++;
?>
            <tr>
              <td style="font-size: 12px;"><?php echo $n; ?></td>
              <td style="font-size: 12px; text-align: left;"><?php echo $rd['Descripcion']; ?></td>
              <td><a href="sisper/files_intranet/<?php echo $rd['Adjunto']; ?>" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="fas fa-cloud-download-alt"></i></a></td>
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
  $('#dt_documentos').DataTable();
</script>
<?php
  }else{
    echo mensajeda("No se encontraron documentos");
  }
  mysqli_free_result($cd);
  mysqli_close($cone);
?>