<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
	if(isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['ano']) && !empty($_POST['ano'])){
		$doc=iseguro($cone,$_POST['doc']);
    $ano=iseguro($cone,$_POST['ano']);		

    $cd=mysqli_query($cone, "SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.numdoc=$doc AND d.Ano=$ano;");
    if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th><i class="fa fa-slack text-aqua"></i> NÚMERO</th>
                        <th><i class="fa fa-files-o text-aqua"></i> TIPO</th>
                        <th><i class="fa fa-file text-aqua"></i> DOCUMENTO</th>
                        <th><i class="fa fa-calendar text-aqua"></i> FECHA</th>                        
                    </tr>
                    <tr>
                        <td class="text-aqua"><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></td>
                        <td class="text-teal"><?php echo $rd['TipoDoc']; ?></td>
                        <td class="text-orange"><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']; ?></td>
                        <td><?php echo fnormal($rd['FechaDoc']); ?></td>                        
                    </tr>
                    <tr>
                        <th colspan="4"><i class="fa fa-info-circle text-aqua"></i> ASUNTO</th>
                        
                    </tr>
                    <tr>
                        <td colspan="4"><?php echo $rd['asunto']; ?></td>
                        
                    </tr>
<?php
                    if ($rd['remitenteint']!=null || $rd['remitenteext']!=null) {
?>     
                        <tr>
                            <th colspan="3"><i class="fa fa-user text-aqua"></i> <?php echo !is_null($rd['remitenteext']) ? 'REMITENTE EXTERNO' : 'REMITENTE'; ?></th>
                            <th colspan="3"><i class="fa fa-university text-aqua"></i> DEPENDENCIA ORIGEN</th>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo !is_null($rd['remitenteext']) ? $rd['remitenteext'] : nomempleado($cone, $rd['remitenteint']); ?></td>
                            <td colspan="3"><?php echo !is_null($rd['deporigenext']) ? $rd['deporigenext'] : nomdependencia($cone, $rd['deporigenint']); ?></td>
                        </tr>
<?php
                     }
                     if ($rd['destinatarioint']!==null || $rd['destinatarioext']!==null) {
?>
                        <tr>
                            <th colspan="3"><i class="fa fa-user text-aqua"></i> <?php echo !is_null($rd['remitenteext']) ? 'DESTINATARIO EXTERNO' : 'DESTINATARIO'; ?></th>
                            <th colspan="3"><i class="fa fa-university text-aqua"></i> DEPENDENCIA DESTINO</th>
                        </tr>
                        <tr>
                            <td colspan="3"><?php echo !is_null($rd['destinatarioext']) ? $rd['destinatarioext'] : nomempleado($cone, $rd['destinatarioint']); ?></td>
                            <td colspan="3"><?php echo !is_null($rd['depdestinoext']) ? $rd['depdestinoext'] : nomdependencia($cone, $rd['depdestinoint']); ?></td>
                        </tr>
<?php
                   } 
 ?>
                </table>
            </div>

        <div class="col-sm-12">
                
<?php
            $v1=$rd['idDoc'];
            $ce=mysqli_query($cone, "SELECT ed.*, modnotificacion, tipo, motivo FROM tdestadodoc ed LEFT JOIN tdmodnotificacion mn ON ed.idtdmodnotificacion=mn.idtdmodnotificacion LEFT JOIN tdproveido p ON ed.idtdproveido=p.idtdproveido WHERE ed.idDoc=$v1 ORDER BY ed.fecha DESC;");            

            if(mysqli_num_rows($ce)>0){

                ?>
                <span class="text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-orange"></i> Actualizado al <?php echo date('d/m/Y h:i:s A'); ?></span>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ESTADO</th>
                            <th>FECHA</th>
                            <th>TIEMPO</th>
                            <th>RESPONSABLE</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                $n=0;
                while($re=mysqli_fetch_assoc($ce)){
                    $n++;
                    $ti="";

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
                                <?php if($re['idtdestado']==3){ ?>
                                <br><i class="fa fa-commenting text-orange"></i> <b class="text-muted"><?php echo $re['tipo']; ?>:</b> <?php echo $re['motivo']; ?> <br>
                                <?php } ?>
                                <?php if($re['idtdestado']==5){ ?>
                                <br><i class="fa fa-motorcycle text-orange"></i> <b class="text-muted"> <?php echo $re['estnotificacion']==1 ? "Notificado" : ($re['estnotificacion']==2 ? "Devuelto" : ""); ?></b> <?php echo $re['modnotificacion']; ?><br><i class="fa fa-calendar text-gray"></i> <?php echo fnormal($re['fecnotificacion']); ?> <br>
                                <?php } ?>
                            </td>
                            <td><?php echo date('d/m/Y h:i:s A', strtotime($re['fecha'])); ?></td>
                            <td class="text-orange"><i class="fa fa-clock-o"></i> <?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></td>
                            <td>
                                <?php
                                if(!is_null($re['idEmpleado'])){
                                    echo nomempleado($cone, $re['idEmpleado']).'<br><small class="text-aqua">'.nomdependencia($cone, $re['idDependencia']).'</small>';
                                }else{
                                    if(!is_null($re['idtdmesapartes'])){
                                        echo nommpartes($cone, $re['idtdmesapartes']).(!is_null($re['asignador']) ? '<br><small class="text-aqua">'.nomempleado($cone, $re['asignador']).'</small>' : '');
                                    }
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
<?php

            }
            mysqli_free_result($ce);
?>
            </div>


        </div>
<?php     
            }else{
                echo mensajewa("No existe el documento");
            }
            mysqli_free_result($cd);
       
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>