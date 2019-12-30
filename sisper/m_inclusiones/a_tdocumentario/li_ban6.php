<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];

?>
<div class="col-sm-7">
    <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <b>NOTIFICACIONES PARA REPORTAR</b></h5>
    <input type="hidden" id="idmp" value="<?php echo $rm['idtdmesapartes']; ?>">
</div>
<div class="col-sm-5">
    <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
</div>
<div class="col-sm-12">
<?php
    $cb=mysqli_query($cone, "SELECT d.idDoc, d.numdoc, d.Numero, d.Ano, d.Siglas, d.destinatarioint, d.depdestinoint, d.destinatarioext, d.depdestinoext, td.TipoDoc, ed.idtdestadodoc, ed.idtdestado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idEmpleado=$idem AND ed.estado=1 AND ed.pnotificar=1 AND (ed.idtdestado=1 OR ed.idtdestado=2 OR ed.idtdestado=5) ORDER BY ed.fecha DESC;");
    if(mysqli_num_rows($cb)>0){
?>
        <table class="table table-bordered table-hover" id="dt_ban61">
            <thead>
                <tr>
                    <th class="text-maroon"># SEG.</th>
                    <th>DOCUMENTO<br><small class="text-teal">TIPO</small></th>
                    <th>ESTADO</th>
                    <th>DESTINO</th>
                    <th class="text-center">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($rb=mysqli_fetch_assoc($cb)){
?>
                <tr style="font-size: 12px;">
                    <td class="text-maroon"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                    <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                    <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                    <td class="text-aqua"><?php echo !is_null($rb['destinatarioint']) ? nomempleado($cone, $rb['destinatarioint'])."<br><small class='text-muted'>".nomdependencia($cone, $rb['depdestinoint'])."</small>" : $rb['destinatarioext']."<br><small class='text-muted'>".$rb['depdestinoext']."</small>"; ?></td>
                    <td class="text-center">
                          <div class="btn-group btn-group-xs">
                            <button type="button" class="btn btn-info btn-xs" title="Reportar Notificación" onclick="f_bandeja('repdoc', <?php echo $rb['idDoc'].", ".$rb['idtdestadodoc']; ?>)"><i class="fa fa-motorcycle"></i></button>
                          </div>
                          <div class="btn-group">
                            
                            <button class="btn bg-maroon btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-file"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <li><a href="#" onclick="f_bandeja('rutdoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-retweet text-maroon"></i> Seguimiento</a></li>
                              <li><a href="#" onclick="f_bandeja('detest',<?php echo $rb['idtdestadodoc'].",0"; ?>)"><i class="fa fa-tags text-maroon"></i> Estado</a></li>
                              <li class="divider"></li>
                              <li><a href="#" onclick="f_bandeja('detdoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-file-text text-maroon"></i> Detalle</a></li>
                              <?php if($rb['idtdestado']==1){ ?>
                              <li><a href="#" onclick="f_bandeja('edidoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-pencil text-maroon"></i> Editar</a></li>
                              <li><a href="#" onclick="f_bandeja('elidoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-trash text-maroon"></i> Eliminar</a></li>
                              <?php } ?>
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
            $("#dt_ban61").DataTable();
        </script>
<?php
    }else{
        echo mensajewa("Sin documentos pendientes.");
    }
    mysqli_free_result($cb);

    //reportados hoy
    $cb=mysqli_query($cone, "SELECT d.idDoc, d.numdoc, d.Numero, d.Ano, d.Siglas, td.TipoDoc, ed.idtdestado, ed.fecha FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idEmpleado=$idem AND DATE_FORMAT(ed.fecha, '%Y-%m-%d')=CURDATE() AND ed.idtdestado=5 ORDER BY ed.idtdestadodoc DESC;");
    if(mysqli_num_rows($cb)>0){
?>
        <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <b>NOTIFICACIONES REPORTADAS HOY <?php echo date('d/m/Y'); ?></b></h5>
        <table class="table table-bordered table-hover" id="dt_ban62">
            <thead>
                <tr>
                    <th class="text-maroon"># SEG.</th>
                    <th>DOCUMENTO <small class="text-teal">(TIPO)</small></th>
                    <th>ESTADO</th>
                    <th class="text-purple">FECHA</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($rb=mysqli_fetch_assoc($cb)){
?>
                <tr style="font-size: 12px;">
                    <td class="text-maroon"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                    <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?> <small class="text-teal">(<?php echo $rb['TipoDoc']; ?>)</small></td>
                    <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                    <td class="text-purple"><?php echo ftnormal($rb['fecha']); ?></td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_ban62").DataTable({
              dom: 'Bfrtip',
              buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Exportar a Excel'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Imprimir'
                },
              ]
            });
        </script>
<?php
    }
    mysqli_free_result($cb);
?>
</div>
<?php
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>