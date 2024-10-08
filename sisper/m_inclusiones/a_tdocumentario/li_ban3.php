<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if (accesocon($cone, $_SESSION['identi'], 17)) {

  if (isset($_POST['ns3']) && !empty($_POST['ns3']) && isset($_POST['as3']) && !empty($_POST['as3'])) {

    $ns = iseguro($cone, $_POST['ns3']);
    $as = iseguro($cone, $_POST['as3']);

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
      <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <b>DOCUMENTOS PARA DERIVAR</b></h5>
    </div>
    <div class="col-sm-5">
      <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
    </div>
    <div class="col-sm-12">
      <?php
      $cb = mysqli_query($cone, "SELECT d.idDoc, d.numdoc, d.Numero, d.Ano, d.Siglas, d.destinatarioint, d.depdestinoint, d.destinatarioext, d.depdestinoext, td.TipoDoc, ed.idtdestadodoc, ed.idtdestado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE d.numdoc='$ns' AND d.Ano='$as' AND $cq AND ed.estado=1 AND (ed.idtdestado=1 OR ed.idtdestado=2 OR ed.idtdestado=5);");
      if (mysqli_num_rows($cb) > 0) {
      ?>
        <table class="table table-bordered table-hover" id="dt_ban3">
          <thead>
            <tr>
              <th>NUM.</th>
              <th class="hidden">id</th>
              <th>DOCUMENTO<br>TIPO</th>
              <th>ESTADO</th>
              <th>DESTINATARIO</th>
              <th class="text-center">ACCIÓN</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($rb = mysqli_fetch_assoc($cb)) {
            ?>
              <tr style="font-size: 12px;">
                <td class="text-aqua"><?php echo $rb['numdoc'] . '-' . $rb['Ano']; ?></td>
                <td class="hidden"><?php echo $rb['idDoc'] . " " . $rb['idtdestadodoc']; ?></td>
                <td><?php echo (!is_null($rb['Numero']) ? $rb['Numero'] . "-" : "") . $rb['Ano'] . "-" . $rb['Siglas']; ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                <td class="text-aqua"><?php echo !is_null($rb['destinatarioint']) ? nomempleado($cone, $rb['destinatarioint']) . "<br><small class='text-muted'>" . nomdependencia($cone, $rb['depdestinoint']) . "</small>" : $rb['destinatarioext'] . "<br><small class='text-muted'>" . $rb['depdestinoext'] . "</small>"; ?></td>
                <td class="text-center">
                  <?php if (!$tmp && $rb['idtdestado'] != 5) { ?>
                    <button type="button" class="btn btn-info btn-xs" title="Derivar a Mesa de Partes con proveído" onclick="f_bandeja('dermpp', <?php echo $rb['idDoc'] . ", " . $rb['idtdestadodoc']; ?>)"><i class="fa fa-reply-all"></i></button>
                  <?php } ?>
                  <?php if ($tmp) { ?>
                    <button type="button" class="btn btn-info btn-xs" id="btn-derivarmp" title="Derivar a Mesa de Partes"><i class="fa fa-share-square-o"></i></button>
                  <?php } ?>
                  <?php if ($rb['idtdestado'] == 5) { ?>
                    <button type="button" class="btn btn-info btn-xs" title="Derivar" onclick="f_bandeja('derrep', <?php echo $rb['idDoc'] . ", " . $rb['idtdestadodoc']; ?>)"><i class="fa fa-level-up"></i></button>
                  <?php } ?>
                  <div class="btn-group">

                    <button class="btn bg-maroon btn-xs dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-file"></i>&nbsp;
                      <span class="caret"></span>
                      <span class="sr-only">Desplegar menú</span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="#" onclick="f_bandeja('rutdoc',<?php echo $rb['idDoc'] . ",0"; ?>)"><i class="fa fa-retweet text-maroon"></i> Seguimiento</a></li>
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
          var table3 = $("#dt_ban3").DataTable();

          $('#dt_ban3 tbody').on('click', 'button#btn-derivarmp', function() {
            var d = table3.row($(this).parents('tr')).data()[1];
            var da = d.split(' ');
            var ta = table3.row($(this).parents('tr'));

            var v3 = $('#smpar').val();
            if (v3 != null) {
              $.ajax({
                type: "post",
                url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
                data: {
                  acc: 'dermpa',
                  v1: da[0],
                  v2: da[1],
                  v3: v3
                },
                dataType: "json",
                success: function(a) {
                  if (a.e) {
                    alertify.success(a.m);
                    ta.remove().draw();
                  } else {
                    alertify.error(a.m);
                  }
                }
              });
            } else {
              alertify.error('Elija la mesa de partes a donde derivará el documento.');
            }

          });
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