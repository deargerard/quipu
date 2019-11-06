<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];

    $cu=mysqli_query($cone, "SELECT l.idDistrito FROM empleadocargo ec INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia INNER JOIN dependencialocal dl ON d.idDependencia=dl.idDependencia INNER JOIN local l ON dl.idLocal=l.idLocal WHERE ec.idEstadoCar=1 AND cd.Estado=1 AND ec.idEmpleado=$idem;");
    if($ru=mysqli_fetch_assoc($cu)){
      $du=$ru['idDistrito'];
    }
?>
<div class="col-sm-6">
    <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <b>DOCUMENTOS REGISTRADOS</b></h5>
    <input type="hidden" id="idmp" value="<?php echo $rm['idtdmesapartes']; ?>">
</div>
<div class="col-sm-6">
    <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
</div>
<div class="col-sm-12">
<?php
    $cb=mysqli_query($cone, "SELECT d.idDoc, d.numdoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.destinatarioint, d.depdestinoint, d.destinatarioext, d.depdestinoext, td.TipoDoc, ed.idtdestadodoc, ed.fecha, ed.idtdestado, ed.idEmpleado, ed.idtdmesapartes FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE d.regpor=$idem AND ed.estado=1 AND (ed.idtdestado=3 OR ed.idtdestado=2) LIMIT 60;");
    if(mysqli_num_rows($cb)>0){
?>
        <table class="table table-bordered table-hover" id="dt_ban2">
            <thead>
                <tr>
                    <th>NUM.</th>
                    <th>DOCUMENTO<br>TIPO</th>
                    <th>FECHA DOCUMENTO<br>TIEMPO</th>
                    <th>ESTADO</th>
                    <th>FECHA ESTADO<br>TIEMPO</th>
                    <th>DESTINATARIO</th>
                    <th class="text-center">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($rb=mysqli_fetch_assoc($cb)){
          
?>
                <tr style="font-size: 12px;">
                    <td class="text-aqua"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                    <td><?php echo (!is_null($rb['Numero']) ? $rb['Numero']."-" : "").$rb['Ano'].(!is_null($rb['Siglas']) ? "-".$rb['Siglas'] : ""); ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                    <td><?php echo fnormal($rb['FechaDoc']); ?><br><span class="text-yellow"><?php echo diftiempo($rb['FechaDoc'], date('Y-m-d H:i:s')); ?></span></td>
                    <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                    <td><?php echo date('d/m/Y h:i:s A', strtotime($rb['fecha'])); ?><br><span class="text-orange"><?php echo diftiempo($rb['fecha'], date('Y-m-d H:i:s')); ?></span></td>
                    <td class="text-aqua"><?php echo !is_null($rb['destinatarioint']) ? nomempleado($cone, $rb['destinatarioint'])."<br><small class='text-muted'>".nomdependencia($cone, $rb['depdestinoint'])."</small>" : $rb['destinatarioext']."<br><small class='text-muted'>".$rb['depdestinoext']."</small>"; ?></td>
                    <td class="text-center">
                          <!-- <div class="btn-group btn-group-xs">
                            <button type="button" class="btn btn-info btn-xs" title="Derivar" onclick="f_bandeja('derper', <?php //echo $rb['idDoc'].", ".$rb['idtdestadodoc']; ?>)"><i class="fa fa-share"></i></button>
                          </div> -->
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
                              <?php
                                $idd=$rb['idDoc'];
                                $ne=mysqli_query($cone, "SELECT idtdestadodoc FROM tdestadodoc WHERE idDoc=$idd;");
                                if(mysqli_num_rows($ne)==1){
                                  if($rb['idtdestado']==3){
                              ?>
                              <li><a href="#" onclick="f_bandeja('cammp',<?php echo $rb['idDoc'].", ".$rb['idtdestadodoc']; ?>)"><i class="fa fa-random text-maroon"></i> Cambiar MP</a></li>
                              <?php
                                  }
                              ?>
                              <li><a href="#" onclick="f_bandeja('edidoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-pencil text-maroon"></i> Editar</a></li>
                              <li><a href="#" onclick="f_bandeja('elidoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-trash text-maroon"></i> Eliminar</a></li>
                              <?php
                                }
                              ?>
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
            $("#dt_ban2").DataTable({
              "order": [[ 0, "desc" ]]
            });
        </script>
<?php
    }else{
        echo mensajewa("Sin documentos pendientes.");
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