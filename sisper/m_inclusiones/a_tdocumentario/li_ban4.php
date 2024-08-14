<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if (accesocon($cone, $_SESSION['identi'], 17)) {

  if (isset($_POST['ns4']) && !empty($_POST['ns4']) && isset($_POST['as4']) && !empty($_POST['as4'])) {

    $ns = iseguro($cone, $_POST['ns4']);
    $as = iseguro($cone, $_POST['as4']);

    $idem = $_SESSION['identi'];

    $cm = mysqli_query($cone, "SELECT mp.tipo, mp.idtdmesapartes FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.estado=1 AND mp.estado=1;");
    if ($rm = mysqli_fetch_assoc($cm)) {
      $tmp = $rm['tipo'];
      $imp = $rm['idtdmesapartes'];
      $cq = "(ed.idtdmesapartes=$imp OR ed.idEmpleado=$idem)";
    } else {
      $cq = "ed.idEmpleado=$idem";
    }
?>
    <div class="col-sm-7">
      <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <b>DOCUMENTOS PARA DERIVAR A NOTIFICADOR</b></h5>
      <input type="hidden" id="idmp" value="<?php echo $rm['idtdmesapartes']; ?>">
    </div>
    <div class="col-sm-5">
      <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
    </div>
    <div class="col-sm-12">
      <?php
      $cb = mysqli_query($cone, "SELECT d.idDoc, d.numdoc, d.Numero, d.Ano, d.Siglas, td.TipoDoc, ed.idtdestadodoc, ed.idtdestado, d.destinatarioint, d.depdestinoint, d.destinatarioext, d.depdestinoext FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE d.numdoc='$ns' AND d.Ano='$as' AND $cq AND ed.estado=1 AND (ed.idtdestado=1 OR ed.idtdestado=2) ORDER BY ed.fecha DESC;");
      if (mysqli_num_rows($cb) > 0) {
      ?>
        <table class="table table-bordered table-hover" id="dt_ban4">
          <thead>
            <tr>
              <th class="text-maroon"># SEG.</th>
              <th>DOCUMENTO<br>TIPO</th>
              <th>ESTADO</th>
              <th>DESTINO</th>
              <th class="text-center">ACCIÓN</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($rb = mysqli_fetch_assoc($cb)) {
            ?>
              <tr style="font-size: 12px;">
                <td class="text-maroon"><?php echo $rb['numdoc'] . '-' . $rb['Ano']; ?></td>
                <td><?php echo (!is_null($rb['Numero']) ? $rb['Numero'] . "-" : "") . $rb['Ano'] . "-" . $rb['Siglas']; ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                <td class="text-aqua"><?php echo !is_null($rb['destinatarioint']) ? nomempleado($cone, $rb['destinatarioint']) . "<br><small class='text-muted'>" . nomdependencia($cone, $rb['depdestinoint']) . "</small>" : $rb['destinatarioext'] . "<br><small class='text-muted'>" . $rb['depdestinoext'] . "</small>"; ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-info btn-xs" title="Derivar para Notificar" onclick="g_dernot(<?php echo $rb['idDoc'] . ", " . $rb['idtdestadodoc']; ?>)"><i class="fa fa-share-square-o"></i></button>
                  </div>
                  <div class="btn-group">

                    <button class="btn bg-maroon btn-xs dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-file"></i>&nbsp;
                      <span class="caret"></span>
                      <span class="sr-only">Desplegar menú</span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="#" onclick="f_bandeja('rutdoc',<?php echo $rb['idDoc'] . ",0"; ?>)"><i class="fa fa-retweet text-maroon"></i> Ruta</a></li>
                      <li><a href="#" onclick="f_bandeja('detest',<?php echo $rb['idtdestadodoc'] . ",0"; ?>)"><i class="fa fa-tags text-maroon"></i> Estado</a></li>
                      <li class="divider"></li>
                      <li><a href="#" onclick="f_bandeja('detdoc',<?php echo $rb['idDoc'] . ",0"; ?>)"><i class="fa fa-file-text text-maroon"></i> Detalle</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <script>
          $("#dt_ban4").DataTable();
        </script>
      <?php
      } else {
        echo mensajewa("El número de seguimiento no es el correcto o posiblemente no este en estado de recibido por su mesa de partes.");
      }
      mysqli_free_result($cb);
      ?>
    </div>
<?php
  } else {
    echo mensajewa("Ingrese el número de seguimiento y el año");
  }
} else {
  echo accrestringidoa();
}
mysqli_close($cone);

?>