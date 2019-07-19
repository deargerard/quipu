<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['est']) && !empty($_POST['est']) && isset($_POST['vig']) && !empty($_POST['vig']) && isset($_POST['fini']) && !empty($_POST['fini']) && isset($_POST['ffin']) && !empty($_POST['ffin'])){
        $idem=$_SESSION['identi'];     
        $per=iseguro($cone,$_POST['per']);
        $est=iseguro($cone,$_POST['est']);
        $vig=iseguro($cone,$_POST['vig']);
        $fini=fmysql(iseguro($cone,$_POST['fini']));
        $ffin=fmysql(iseguro($cone,$_POST['ffin']));
?>                
      <div class="text-blue"><h4><b><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone, $per);?></b></h4></div>
      <hr>
<?php
    $west="";    
    if ($est=='t'){
        $west="";
    }else{
        $west=" ed.idtdestado=$est AND ";
    }

    $wvig="";    
    if ($vig=='2'){
        $wvig="ed.estado=0 AND ";
    }elseif($vig=='1'){
        $wvig=" ed.estado=1 AND ";
    }

        $cb=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, g.numero numguia, g.anio, ed.idtdestado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc LEFT JOIN tdguia g ON ed.idtdguia=g.idtdguia WHERE ed.idEmpleado=$per AND $wvig $west (FechaDoc between '$fini' AND '$ffin') ORDER BY ed.fecha DESC;");

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
                        <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?><br><span class="text-teal"><?php echo $rb['TipoDoc']; ?></span></td>
                        <td><?php echo fnormal($rb['FechaDoc']); ?><br><span class="text-yellow"><?php echo diftiempo($rb['FechaDoc'], date('Y-m-d H:i:s')); ?></span></td>
                        <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($rb['fecha'])); ?><br><span class="text-orange"><?php echo $ti!="" ? diftiempo($fec, $ti) : ""; ?></span></td>
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
            $("#dt_ban1").DataTable();
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