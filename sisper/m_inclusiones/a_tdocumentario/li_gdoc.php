<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
  if(isset($_POST['idmp']) && !empty($_POST['idmp'])){
    $idmp=iseguro($cone, $_POST['idmp']);
    $v1=iseguro($cone, $_POST['v1']);
    $idem=$_SESSION['identi'];

?>
<div class="col-sm-12">
  <br>
<?php
  $cg=mysqli_query($cone, "SELECT d.numdoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.remitenteext, d.destinatarioext, d.remitenteint, d.destinatarioint FROM tdestadodoc ed INNER JOIN doc d ON ed.idDoc=d.idDoc WHERE ISNULL(ed.idtdguia) AND ed.idtdmesapartes=$idmp AND ed.idtdestado=3 AND ed.estado=1 AND ed.mpasignador=$v1;");
  if(mysqli_num_rows($cg)>0){
?>
    <table class="table table-hover table-bordered" id="dt_gdoc">
      <thead>
        <tr>
          <th>NUM.</th>
          <th>DOCUMENTO</th>
          <th>FECHA</th>
          <th>REMITENTE</th>
          <th>DESTINATARIO</th>
        </tr>
      </thead>
<?php
    while($rg=mysqli_fetch_assoc($cg)){
?>
        <tr>
          <td><?php echo $rg['numdoc'].'-'.$rg['Ano']; ?></td>
          <td><?php echo $rg['Numero'].'-'.$rg['Ano'].'-'.$rg['Siglas']; ?></td>
          <td><?php echo fnormal($rg['FechaDoc']); ?></td>
          <td><?php echo is_null($rg['remitenteext']) ? nomempleado($cone, $rg['remitenteint']) : $rg['remitenteext']; ?></td>
          <td><?php echo is_null($rg['destinatarioext']) ? nomempleado($cone, $rg['destinatarioint']) : $rg['destinatarioext']; ?></td>
        </tr>
<?php
    }
?>
  </table>
  <script>
    $('#dt_gdoc').dataTable();
  </script>
<?php
  }else{
    echo mensajewa("Sin documentos.");
  }
  mysqli_free_result($cg);
?>
</div>
<?php
  }else{
    echo mensajewa("Error.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>