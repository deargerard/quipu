<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
	if(isset($_POST['gui']) && !empty($_POST['gui']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['mp']) && !empty($_POST['mp'])){
		$gui=iseguro($cone,$_POST['gui']);
        $ano=iseguro($cone,$_POST['ano']);
        $mp=iseguro($cone,$_POST['mp']);
                
            $cg=mysqli_query($cone, "SELECT idtdguia, numero, anio, idtdmesapartesg, idtdmesapartesd, generador FROM tdguia WHERE numero=$gui AND anio=$ano AND idtdmesapartesg=$mp;");            

            if($rg=mysqli_fetch_assoc($cg)){
                $v1=$rg['idtdguia'];
?>
                <div class="col-md-4 text-blue"><b><i class="fa fa-archive text-orange"></i> <?php echo nommpartes($cone, $rg['idtdmesapartesg']); ?></b></div>
                <div class="col-md-3 text-blue"><b><i class="fa fa-stack-overflow text-orange"></i> <?php echo nomempleado($cone, $rg['generador']);?></b></div>
                <div class="col-md-3 text-blue"><b><i class="fa fa-plane text-orange"></i> <?php echo nommpartes($cone, $rg['idtdmesapartesd']); ?></b></div>
                <div class="col-md-1 text-right text-blue"><b><i class="fa fa-slack text-orange"></i> <?php echo $rg['numero'].'-'.$rg['anio']; ?></b></div>
                <div class="col-md-1 text-right">  <button type="button" class="btn btn-info btn-xs" title="Guía PDF" onclick="guiapdf(<?php echo $v1; ?>)"><i class="fa fa-file-pdf-o"></i></button> </div>

                <div class="col-md-12"> <hr>
                </div>   


<?php
                    $cdg=mysqli_query($cone, "SELECT d.numdoc, d.Numero, d.Ano, d.Siglas, d.remitenteext, d.remitenteint, d.destinatarioext, d.destinatarioint, td.TipoDoc FROM tdestadodoc ed INNER JOIN doc d ON ed.idDoc=d.idDoc INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE ed.idtdguia=$v1 ORDER BY d.numdoc DESC, d.Ano DESC;");
                    if(mysqli_num_rows($cdg)>0){
?>                   

                        <table class="table table-hover table-bordered" id="dt_guia">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-aqua"># SEG.</th>
                                    <th class="text-blue">DOCUMENTO <small class="text-purple">(Tipo)</small></th>
                                    <th>REMITENTE</th>
                                    <th>DESTINATARIO</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
                            $n=0;
                            while($rdg=mysqli_fetch_assoc($cdg)){
                                $n++;
?>
                                <tr>
                                    <td><?php echo $n; ?></td>
                                    <td class="text-aqua"><?php echo $rdg['numdoc'].'-'.$rdg['Ano']; ?></td>
                                    <td class="text-blue"><?php echo (!is_null($rdg['Numero']) ? $rdg['Numero']."-" : "").$rdg['Ano'].(!is_null($rdg['Siglas']) ? $rdg['Siglas'] : ""); ?> <small class="text-purple">(<?php echo $rdg['TipoDoc']; ?>)</small></td>
                                    <td><?php echo !is_null($rdg['remitenteext']) ? $rdg['remitenteext'] : nomempleado($cone, $rdg['remitenteint']); ?></td>
                                    <td><?php echo !is_null($rdg['destinatarioext']) ? $rdg['destinatarioext'] : nomempleado($cone, $rdg['destinatarioint']); ?></td>
                                </tr>
<?php
                            }
?>
                            </tbody>
                        </table>
                        <script>
                            $('#dt_guia').dataTable();
                        </script>
<?php
                    }else{
                        echo mensajewa("No se encontraron documentos");
                    }
                    mysqli_free_result($cdg);
                }else{
                    echo mensajewa("No se encontró la guía.");
                }
                mysqli_free_result($cg);
            }else{
                echo mensajewa("Error, faltan datos.");
            }  
}else{
  echo accrestringidoa();
}
?>