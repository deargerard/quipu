<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if (accesocon($cone, $_SESSION['identi'], 17)) {

  if (isset($_POST['ns1']) && !empty($_POST['ns1']) && isset($_POST['as1']) && !empty($_POST['as1'])) {

    $ns = iseguro($cone, $_POST['ns1']);
    $as = iseguro($cone, $_POST['as1']);

    $idem = $_SESSION['identi'];

    $cm = mysqli_query($cone, "SELECT mp.idtdmesapartes, mp.denominacion FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
    if (mysqli_num_rows($cm) > 0) {
      while ($rm = mysqli_fetch_assoc($cm)) {
        $idmp = $rm['idtdmesapartes'];

?>
        <div class="col-sm-6">
          <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> PENDIENTE DE RECEPCIÓN DE <b><?php echo $rm['denominacion']; ?></b></h5>
          <input type="hidden" id="idmp" value="<?php echo $rm['idtdmesapartes']; ?>">
        </div>
        <div class="col-sm-6">
          <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
        </div>
        <div class="col-sm-12">

          <?php
          $cb = mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.numdoc, td.TipoDoc, ed.idtdestadodoc, g.numero numguia, g.anio, ed.idtdestado, ed.asignador FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc LEFT JOIN tdguia g ON ed.idtdguia=g.idtdguia WHERE d.numdoc='$ns' AND d.Ano='$as' AND ed.idtdmesapartes=$idmp AND ed.estado=1 AND ed.idtdestado=3;");
          if (mysqli_num_rows($cb) > 0) {
          ?>

            <table class="table table-bordered table-hover" id="dt_ban11">
              <thead>
                <tr>
                  <th><span class="text-aqua"># SEG.</span></th>
                  <th class="hidden">id</th>
                  <th>DOCUMENTO<br><span class="text-teal">TIPO</span></th>
                  <th>ESTADO</th>
                  <th><span class="text-primary">DERIVADO POR</span></th>
                  <th>GUÍA</th>
                  <th class="text-center">ACCIÓN</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($rb = mysqli_fetch_assoc($cb)) {
                ?>
                  <tr style="font-size: 12px;">
                    <td class="text-aqua"><?php echo $rb['numdoc'] . '-' . $rb['Ano']; ?></td>
                    <td class="hidden"><?php echo $rb['idDoc'] . " " . $rb['idtdestadodoc'] . " " . $idmp; ?></td>
                    <td><?php echo (is_null($rb['Numero']) ? "" : $rb['Numero'] . "-") . $rb['Ano'] . (is_null($rb['Siglas']) ? "" : "-" . $rb['Siglas']); ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                    <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                    <td>
                      <span class="text-primary"><?php echo nomempleado($cone, $rb['asignador']); ?></span>
                    </td>
                    <td><?php echo is_null($rb['numguia']) ? "-" : $rb['numguia'] . "-" . $rb['anio']; ?></td>
                    <td class="text-center">

                        <button type="button" class="btn btn-info btn-xs" id="btn-recibirmp" title="Recibir"><i class="fa fa-check"></i></button>
                      
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
                      <?php if($idmp==2 || $idmp==60 || $idmp==61) { ?>
                      <button type="button" class="btn btn-primary btn-xs" id="btn-enviargn" title="Enviar al Generador de Notificaciones"><i class="fa fa-share"></i></button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>

            <script>
              var table = $("#dt_ban11").DataTable();

              $('#dt_ban11 tbody').on('click', 'button#btn-recibirmp', function() {
                var d = table.row($(this).parents('tr')).data()[1];
                var da = d.split(' ');
                var ta = table.row($(this).parents('tr'));

                $.ajax({
                  type: "post",
                  url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
                  data: {
                    acc: 'recdoc',
                    v1: da[0],
                    v2: da[1],
                    mp: da[2]
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
              });

              $('#dt_ban11 tbody').on('click', 'button#btn-enviargn', function() {
                var d = table.row($(this).parents('tr')).data()[1];
                var da = d.split(' ');
                var ta = table.row($(this).parents('tr'));

                $.ajax({
                  type: "post",
                  url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
                  data: {
                    acc: 'envgn',
                    v1: da[0],
                    v2: da[1],
                    mp: da[2]
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
              });
            </script>
          <?php

          } else {
            echo mensajewa("El número de seguimiento es incorrecto o no está derivado a su mesa de partes.");
          }
          mysqli_free_result($cb);
          ?>
        </div>
    <?php


      }
    }
    mysqli_free_result($cm);
    ?>

    <!--mis documentos derivados-->
    <div class="col-sm-6">
      <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> PENDIENTES DE RECEPCIÓN DE <b><?php echo nomempleado($cone, $idem); ?></b></h5>
    </div>
    <div class="col-sm-6">
      <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
    </div>
    <div class="col-sm-12">

      <?php

      $cb = mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.numdoc, td.TipoDoc, ed.idtdestadodoc, ed.idtdestado, ed.asignador FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE d.numdoc='$ns' AND d.Ano='$as' AND ed.idEmpleado=$idem AND ed.estado=1 AND ed.idtdestado=3;");
      if (mysqli_num_rows($cb) > 0) {
      ?>

        <table class="table table-bordered table-hover" id="dt_ban12">
          <thead>
            <tr>
              <th><span class="text-aqua"># SEG.</span></th>
              <th class="hidden">id</th>
              <th>DOCUMENTO<br><span class="text-teal">TIPO</span></th>
              <th>ESTADO</th>
              <th><span class="text-primary">DERIVADO POR</span></th>
              <th class="text-center">ACCIÓN</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($rb = mysqli_fetch_assoc($cb)) {
            ?>
              <tr style="font-size: 12px;">
                <td class="text-aqua"><?php echo $rb['numdoc'] . '-' . $rb['Ano']; ?></td>
                <td class="hidden"><?php echo $rb['idDoc'] . " " . $rb['idtdestadodoc'] . " 0"; ?></td>
                <td><?php echo (is_null($rb['Numero']) ? "" : $rb['Numero'] . "-") . $rb['Ano'] . (is_null($rb['Siglas']) ? "" : "-" . $rb['Siglas']); ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                <td>
                  <span class="text-primary"><?php echo nomempleado($cone, $rb['asignador']); ?></span>
                </td>
                <td class="text-center">
                  <div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-info" id="btn-recibirpe" title="Recibir"><i class="fa fa-check"></i></button>
                  </div>
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
          var tablepe = $("#dt_ban12").DataTable();

          $('#dt_ban12 tbody').on('click', 'button#btn-recibirpe', function() {
            var d = tablepe.row($(this).parents('tr')).data()[1];
            var da = d.split(' ');
            var ta = tablepe.row($(this).parents('tr'));

            $.ajax({
              type: "post",
              url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
              data: {
                acc: 'recdoc',
                v1: da[0],
                v2: da[1],
                mp: da[2]
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
          });
        </script>
  <?php
      } else {
        echo mensajewa("El número de seguimiento es incorrecto o no está derivado a su persona.");
      }
      mysqli_free_result($cb);
    } else {
      echo mensajewa("Ingrese el número de seguimiento y el año");
    }
  } else {
    echo accrestringidoa();
  }
  mysqli_close($cone);

  ?>