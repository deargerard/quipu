<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){

  if(isset($_POST['ns']) && !empty($_POST['ns']) && isset($_POST['as']) && !empty($_POST['as'])){

    $ns=iseguro($cone, $_POST['ns']);
    $as=iseguro($cone, $_POST['as']);

    $idem=$_SESSION['identi'];

    $idmp=NULL;
    $cm=mysqli_query($cone, "SELECT mp.idtdmesapartes, mp.denominacion FROM tdpersonalmp p INNER JOIN tdmesapartes mp ON p.idtdmesapartes=mp.idtdmesapartes WHERE p.idEmpleado=$idem AND p.estado=1 AND mp.estado=1;");
    if($rm=mysqli_fetch_assoc($cm)){
      $idmp=$rm['idtdmesapartes'];
    }

            $cd=mysqli_query($cone, "SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.Ano=$as AND d.numdoc=$ns;");
            if($rd=mysqli_fetch_assoc($cd)){
              $v1=$rd['idDoc'];
?>
            <br>
            <div class="col-sm-12">
                <table class="table table-bordered table-hover" style="font-size: 13px;">
                    <thead>
                    <tr>
                        <th><i class="fa fa-slack text-aqua"></i> NÚMERO</th>
                        <th><i class="fa fa-files-o text-aqua"></i> TIPO</th>
                        <th><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>
                    </tr>
                    </thead>
                    <tr>
                        <td class="text-aqua"><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                        <td class="text-primary"><?php echo $rd['TipoDoc'].'<small class="text-yellow"> ('.($rd['cargo']==1 ? "Cargo" : "Original").')</small>'; ?></td>
                        <td class="text-orange"><?php echo (!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>
                    </tr>
                    <tr>
                        <th colspan="2"><i class="fa fa-street-view text-aqua"></i> REMITENTE</th>
                        <th colspan="2"><i class="fa fa-street-view text-aqua"></i> DESTINATARIO</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo !is_null($rd['remitenteext']) ? ($rd['remitenteext'].'<br><small class="text-aqua">'.$rd['deporigenext'].'</small>') : (nomempleado($cone, $rd['remitenteint']).'<br><small class="text-aqua">'.nomdependencia($cone, $rd['deporigenint']).'</small>'); ?>       
                        </td>
                        <td colspan="2">
                            <?php echo !is_null($rd['destinatarioext']) ? ($rd['destinatarioext'].'<br><small class="text-aqua">'.$rd['depdestinoext'].'</small>') : (nomempleado($cone, $rd['destinatarioint']).'<br><small class="text-aqua">'.nomdependencia($cone, $rd['depdestinoint']).'</small>'); ?>
                        </td>
                    </tr>
                </table>
<?php
            $ce=mysqli_query($cone, "SELECT ed.*, modnotificacion, tipo, motivo FROM tdestadodoc ed LEFT JOIN tdmodnotificacion mn ON ed.idtdmodnotificacion=mn.idtdmodnotificacion LEFT JOIN tdproveido p ON ed.idtdproveido=p.idtdproveido WHERE ed.idDoc=$v1 ORDER BY ed.fecha DESC;");
            if(mysqli_num_rows($ce)>0){
?>
                <span class="text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-orange"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></span>
                <table class="table table-bordered table-hover" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ESTADO</th>
                            <th>FECHA</th>
                            <th>TIEMPO</th>
                            <th>ASIGNADO A / ASIGNADO POR</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                $n=0;
                $pre=false;
                while($re=mysqli_fetch_assoc($ce)){
                    $n++;
                    $ti="";

                    if($n==1 && $re['idtdestado']==3 && ($re['asignador']==$idem || $re['mpasignador']==$idmp)){
                      $pre=true;
                      $v2=$re['idtdestadodoc'];
                    }
                    
                        $fec=$re['fecha'];
                        $cs=mysqli_query($cone, "SELECT fecha FROM tdestadodoc WHERE idDoc=$v1 AND fecha>'$fec' ORDER BY fecha ASC LIMIT 1;");
                        if($rs=mysqli_fetch_assoc($cs)){
                            $ti=$rs['fecha'];
                        }else{
                            $ti=date('Y-m-d H:i:s');
                        }
                        mysqli_free_result($cs);

?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td>
                                <?php echo estadoDoc($re['idtdestado']); ?>
                                <?php if(!is_null($re['idtdproveido'])){ ?>
                                <br><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone, $re['cppara']); ?><br><i class="fa fa-commenting text-orange"></i> <b class="text-muted"><?php echo $re['tipo']; ?>:</b> <?php echo $re['motivo']; ?> <br>
                                <?php } ?>
                                <?php if($re['idtdestado']==5){ ?>
                                <br><i class="fa fa-motorcycle text-orange"></i> <b class="text-muted"> <?php echo $re['estnotificacion']==1 ? "Notificado" : ($re['estnotificacion']==2 ? "Devuelto" : ""); ?></b> <?php echo $re['modnotificacion']; ?><br><i class="fa fa-calendar text-gray"></i> <?php echo fnormal($re['fecnotificacion']); ?> <br>
                                <?php } ?>
                            </td>
                            <td><?php echo date('d/m/Y h:i:s A', strtotime($re['fecha'])); ?></td>
                            <td class="text-orange"><i class="fa fa-clock-o"></i> <?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></td>
                            <td>
                                <b>
                                <?php
                                if(!is_null($re['idtdmesapartes'])){
                                    if(!is_null($re['idEmpleado'])){
                                        echo nomempleado($cone, $re['idEmpleado']).' <small class="text-aqua">'.nommpartes($cone, $re['idtdmesapartes']).'</small>';
                                    }else{
                                        echo nommpartes($cone, $re['idtdmesapartes']);
                                    }
                                }else{
                                    echo nomempleado($cone, $re['idEmpleado']).' <small class="text-aqua">'.nomdependencia($cone, $re['idDependencia']).'</small>';
                                }
                                ?>
                                </b>
                                <br>
                                <?php
                                if($re['idtdestado']!=4 && $re['idtdestado']!=2){
                                    echo nomempleado($cone, $re['asignador'])." <small class='text-aqua'>".(!is_null($re['mpasignador']) ? nommpartes($cone, $re['mpasignador']) : nomdependencia($cone, $re['depasignador']))."</small>";
                                }
                                ?>
                            </td>
                        </tr>
                        <?php if(!is_null($re['observacion'])){ ?>
                        <tr>
                            <td colspan="5">
                                <i class="fa fa-info-circle text-yellow"></i> <b class="text-muted">OBSERVACIÓN:</b> <?php echo $re['observacion']; ?>
                            </td>
                        </tr>
                        <?php } ?>    
<?php
                }
?>
                    </tbody>
                </table>
                <?php if($pre){ ?>
                <div class="text-center">
                  <button type="button" class="btn bg-maroon" title="Recibirlo nuevamente" onclick="g_rec(<?php echo $v1.", ".$v2.", ".(!is_null($idmp) ? $idmp : 0); ?>)"><i class="fa fa-check"></i> Recibirlo Nuevamente</button>
                </div>
                <?php }else{ echo mensajewa("Ud. no puede recibir nuevamente este el documento."); }?>
<?php

            }
            mysqli_free_result($ce);
?>
            </div>

<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cd);
?>
<?php
  }else{
    echo mensajewa("Ingrese número de seguimiento y año.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>