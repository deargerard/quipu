<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];
    $cm=mysqli_query($cone, "SELECT mp.* FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1;");
    if($rm=mysqli_fetch_assoc($cm)){
      $idmp=$rm['idtdmesapartes'];

?>
<div class="col-sm-12">
  <button type="button" class="btn bg-teal" onclick="f_bandeja('gengui', <?php echo $idmp; ?>, 0)"><i class="fa fa-stack-overflow"></i> Generar Guía</button>
  <button type="button" class="btn bg-yellow" onclick="li_ban6();"><i class="fa fa-refresh"></i> Actualizar</button>
</div>
<div class="col-sm-6">
  <h4 class="text-blue"><i class="fa fa-archive text-orange"></i> <b><?php echo $rm['denominacion']; ?></b></h4>
</div>
<div class="col-sm-6">
    <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
</div>
<div class="col-sm-12">
<?php
  $cg=mysqli_query($cone, "SELECT * FROM tdguia WHERE idtdmesapartesg=$idmp ORDER BY numero DESC, anio DESC LIMIT 400;");
  if(mysqli_num_rows($cg)>0){
?>
    <table class="table table-hover table-bordered" id="dt_ban6">
      <thead>
        <tr>
          <th>#</th>
          <th>NUM. GUÍA</th>
          <th>FECHA</th>
          <th>DESTINO</th>
          <th>GENERADA POR</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
<?php
    $n=0;
    while($rg=mysqli_fetch_assoc($cg)){
      $n++;
?>
        <tr>
          <td><?php echo $n; ?></td>
          <td><?php echo $rg['numero'].'-'.$rg['anio']; ?></td>
          <td><?php echo fnormal($rg['fecenvio']); ?></td>
          <td><?php echo nommpartes($cone, $rg['idtdmesapartesd']); ?></td>
          <td><?php echo nomempleado($cone, $rg['generador']); ?></td>
          <td>
            <div class="btn-group btn-group-xs">
              <button type="button" class="btn btn-info btn-xs" title="Guía PDF" onclick="guiapdf(<?php echo $rg['idtdguia']; ?>)"><i class="fa fa-file-pdf-o"></i></button>
              <!--<button type="button" class="btn btn-info btn-xs" title="Documento a guía" onclick="f_bandeja('docgui', <?php //echo $rg['idtdguia']; ?>, 0)"><i class="fa fa-stack-overflow"></i></button>-->
              <button type="button" class="btn btn-info btn-xs" title="Listar guía" onclick="f_bandeja('lisgui', <?php echo $rg['idtdguia']; ?>, 0)"><i class="fa fa-files-o"></i></button>
            </div>
          </td>
        </tr>
<?php
    }
?>
  </table>
  <script>
    $('#dt_ban6').dataTable();
  </script>
<?php
  }else{
    echo mensajewa("Sin guías.");
  }
  mysqli_free_result($cg);
?>
</div>
<?php
  }else{
    echo mensajewa("No pertenece a ninguna mesa de partes.");
  }
  mysqli_free_result($cm);
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>