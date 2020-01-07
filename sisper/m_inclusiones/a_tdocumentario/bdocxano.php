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
                        <td class="text-aqua"><b><?php echo $rd['numdoc'].'-'.$rd['Ano']; ?></b></td>
                        <td class="text-teal"><?php echo $rd['TipoDoc'].'<small class="text-yellow"> ('.($rd['cargo']==1 ? "Cargo" : "Original").')</small>'; ?></td>
                        <td class="text-orange"><b><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']; ?></b></td>
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
                    <?php
                    $v1=$rd['idDoc'];
                    $cca=mysqli_query($cone, "SELECT Ano, numdoc FROM doc WHERE idDocRel=$v1;");
                    if(mysqli_num_rows($cca)>0){
                        $ca="";
                        while($rca=mysqli_fetch_assoc($cca)){
                            $ca.=$rca['numdoc']."-".$rca['Ano']." ";
                        }
                    ?>
                    <tr>
                        <th><i class="fa fa-folder-open text-aqua"></i> CARGOS</th>
                        <td colspan="3" class="text-purple"><?php echo $ca; ?></td>
                    </tr>
                    <?php
                    }
                    mysqli_free_result($cca);
                    ?>
                    <?php
                    if(!is_null($rd['idDocRel'])){
                        $dr=$rd['idDocRel'];
                        $co=mysqli_query($cone, "SELECT Ano, numdoc FROM doc WHERE idDoc=$dr;");
                        if($ro=mysqli_fetch_assoc($co)){
                        ?>
                        <tr>
                            <th><i class="fa fa-folder-open text-aqua"></i> ORIGINAL</th>
                            <td colspan="3" class="text-purple"><?php echo $ro['numdoc']."-".$ro['Ano']; ?></td>
                        </tr>
                        <?php
                        }
                        mysqli_free_result($co);
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
                                <?php if(!is_null($re['idtdproveido'])){ ?>
                                <br><i class="fa fa-commenting text-orange"></i> <b class="text-muted"><?php echo $re['tipo']; ?>:</b> <?php echo $re['motivo']; ?> <br>
                                <?php } ?>
                                <?php if($re['idtdestado']==5){ ?>
                                <br><i class="fa fa-motorcycle text-orange"></i> <b class="text-muted"> <?php echo $re['estnotificacion']==1 ? "Notificado" : ($re['estnotificacion']==2 ? "Devuelto" : ""); ?></b> <?php echo $re['modnotificacion']; ?><br><i class="fa fa-calendar text-gray"></i> <?php echo fnormal($re['fecnotificacion']); ?> <br>
                                <?php } ?>
                                <?php
                                    if(!is_null($re['idtdguia'])){
                                        $ig=$re['idtdguia'];
                                        $cg=mysqli_query($cone, "SELECT numero, anio FROM tdguia WHERE idtdguia=$ig;");
                                        if($rg=mysqli_fetch_assoc($cg)){
                                            echo '<br><span class="text-purple">G: '.$rg['numero'].'-'.$rg['anio'].'</span>';
                                        }
                                        mysqli_free_result($cg);
                                    }
                                ?>
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