<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    if(isset($_POST['mp']) && !empty($_POST['mp']) && isset($_POST['vig']) && !empty($_POST['vig']) && isset($_POST['est']) && !empty($_POST['est'])){
        $mp=iseguro($cone,$_POST['mp']);
        $est=iseguro($cone,$_POST['est']);
        $vig=iseguro($cone,$_POST['vig']);       
?>                
      <div class="text-blue"><h4><b><i class="fa fa-archive text-orange"></i> <?php echo nommpartes($cone, $mp); ?></b></h4></div>
      <hr>
<?php   

    $wvig="";    
    if ($vig=='2'){
        $wvig="ed.estado=0 AND ";
    }elseif($vig=='1'){
        $wvig=" ed.estado=1 AND ";
    }
        $q="SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, ed.idtdestado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc INNER JOIN tdmesapartes mp ON ed.idtdmesapartes=mp.idtdmesapartes WHERE mp.idtdmesapartes=$mp AND $wvig ed.idtdestado=$est ORDER BY ed.fecha DESC;";

        $cb=mysqli_query($cone, $q);

        //echo $q;

        if(mysqli_num_rows($cb)>0){
?>

            <table class="table table-bordered table-hover" id="dt_ban1">
                <thead>
                    <tr>
                        <th>NUM.</th>
                        <th>DOCUMENTO<br>TIPO</th>
                        <th>FECHA DOCUMENTO<br>TIEMPO</th>
                        <th>ESTADO</th>
                        <th>FECHA ESTADO<br>TIEMPO</th>                        
                        <th class="text-center">ACCIÓN</th>
                    </tr>
                </thead>
                <tbody>
<?php
                    while($rb=mysqli_fetch_assoc($cb)){

                    $ti="";
                    $v1=$rb['idDoc'];
                    $fec=$rb['fecha'];
                    $cs=mysqli_query($cone, "SELECT fecha FROM tdestadodoc WHERE idDoc=$v1 AND fecha>'$fec' ORDER BY fecha ASC LIMIT 1;");
                    if($rs=mysqli_fetch_assoc($cs)){
                        $ti=$rs['fecha'];
                    }else{
                        $ti=date('Y-m-d H:i:s');
                    }
                    mysqli_free_result($cs);                    

?>
                    <tr style="font-size: 12px;">
                        <td class="text-aqua"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                        <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?><br>|<span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                        <td><?php echo fnormal($rb['FechaDoc']); ?><br>|<span class="text-yellow"><?php echo diftiempo($rb['FechaDoc'], date('Y-m-d H:i:s')); ?></span></td>
                        <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($rb['fecha'])); ?><br>|<span class="text-orange"><?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></span></td>
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
            $("#dt_ban1").DataTable({
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
        }else{
            echo mensajewa("Sin documentos.");
        }
        mysqli_free_result($cb);
?>
        
<?php
 
        
    }else{
        echo mensajewa("Error, faltan datos.");
    }  
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>