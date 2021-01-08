<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
	if(isset($_POST['tip']) && !empty($_POST['tip']) && isset($_POST['ano']) && !empty($_POST['ano'])){
		$doc=iseguro($cone,$_POST['ndoc']);
        $ano=iseguro($cone,$_POST['ano']);
        $tip=iseguro($cone,$_POST['tip']);
        $per=iseguro($cone,$_POST['per']);
        $dext=iseguro($cone,$_POST['dext']);
        $dint=iseguro($cone,$_POST['dint']);

        $wdoc="";    
        if ($doc==""){
            $wdoc="";
        }else{
            $wdoc=" d.Numero LIKE '%$doc%' AND ";
        }
        
        $wdes="";    
        if ($tip=='2'){
            $wdes=" d.destinatarioext LIKE '%$dext%' AND ";
        }elseif($dint==""){
            $wdes="";
        }else {
            $wdes=" d.destinatarioint=$dint AND ";
        
        }

        $cd=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, d.destinatarioext, d.destinatarioint, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE $wdoc $wdes d.ano=$ano");

        //echo "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, g.numero numguia, g.anio, ed.idtdestado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc LEFT JOIN tdguia g ON ed.idtdguia=g.idtdguia WHERE $wdoc $wdes d.ano=$ano ORDER BY ed.fecha DESC";
        if(mysqli_num_rows($cd)>0){
?>
            <table class="table table-bordered table-hover" id="dt_bd">
                <thead>
                    <tr>
                        <th>NUM.</th>
                        <th>DOCUMENTO<br>TIPO</th>
                        <th>FECHA DOCUMENTO<br>TIEMPO</th>
                        <th>DESTINATARIO</th>                        
                        <th class="text-center">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
<?php
                    while($rb=mysqli_fetch_assoc($cd)){

                        $ti="";
                        $v1=$rb['idDoc'];
                        //$fec=$rb['fecha'];
                        // $cs=mysqli_query($cone, "SELECT fecha FROM tdestadodoc WHERE idDoc=$v1 AND fecha>'$fec' ORDER BY fecha ASC LIMIT 1;");
                        // if($rs=mysqli_fetch_assoc($cs)){
                        //     $ti=$rs['fecha'];
                        // }else{
                        //     $ti=date('Y-m-d H:i:s');
                        // }
                        // mysqli_free_result($cs);

                        $dest="";
                        if($rb['destinatarioint']){
                            $iddei=$rb['destinatarioint'];
                            $cdei=mysqli_query($cone, "SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado WHERE idEmpleado=$iddei;");
                            if($rdei=mysqli_fetch_assoc($cdei)){
                                $dest=$rdei['ApellidoPat']." ".$rdei['ApellidoMat']." ".$rdei['Nombres'];
                            }else{
                                $dest="";
                            }
                            mysqli_free_result($cdei);
                        }else{
                            $dest=$rb['destinatarioext'];
                        }



    ?>
                        <tr style="font-size: 12px;">
                            <td class="text-aqua"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                            <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                            <td><?php echo fnormal($rb['FechaDoc']); ?><br><span class="text-yellow"><?php echo diftiempo($rb['FechaDoc'], date('Y-m-d H:i:s')); ?></span></td>
                            <td><?php echo $dest; ?></td>
                            <td class="text-center">
                                  
                                  <div class="btn-group">
                                    
                                    <button class="btn bg-maroon btn-xs dropdown-toggle" data-toggle="dropdown">
                                      <i class="fa fa-file"></i>&nbsp;
                                      <span class="caret"></span>
                                      <span class="sr-only">Desplegar menú</span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                      <li><a href="#" onclick="f_bandeja('rutdoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-retweet text-maroon"></i> Ruta</a></li>
                                      <li><a href="#" onclick="f_bandeja('detest',<?php echo $rb['idtdestadodoc'].",0"; ?>)"><i class="fa fa-tags text-maroon"></i> Estado</a></li>
                                      <li class="divider"></li>
                                      <li><a href="#" onclick="f_bandeja('detdoc',<?php echo $rb['idDoc'].",0"; ?>)"><i class="fa fa-file-text text-maroon"></i> Detalle</a></li>
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
            $("#dt_bd").DataTable();
        </script>    
<?php 
        }else{
            echo mensajewa("No existen resultados para la búsqueda");
        }
        mysqli_free_result($cd);
       
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>