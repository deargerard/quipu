<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    if(isset($_POST['mp']) && !empty($_POST['mp']) && isset($_POST['desmp']) && !empty($_POST['desmp']) && isset($_POST['hasmp']) && !empty($_POST['hasmp'])){
        $mp=iseguro($cone,$_POST['mp']);
        $desmp=fmysql(iseguro($cone,$_POST['desmp']));
        $hasmp=fmysql(iseguro($cone,$_POST['hasmp']));
?>                
      <div class="text-blue"><h4><b><i class="fa fa-archive text-orange"></i> <?php echo nommpartes($cone, $mp); ?></b></h4></div>
      <hr>
<?php   

        $q="SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, d.numdoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, ed.idtdestado, g.numero, g.anio FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc INNER JOIN tdmesapartes mp ON ed.idtdmesapartes=mp.idtdmesapartes LEFT JOIN tdguia g ON ed.idtdguia=g.idtdguia WHERE mp.idtdmesapartes=$mp AND (DATE_FORMAT(ed.fecha, '%Y-%m-%d') BETWEEN '$desmp' AND '$hasmp') AND ed.estado=1 AND ed.idtdestado in (2,3) ORDER BY ed.fecha DESC;";

        $cb=mysqli_query($cone, $q);

        //echo $q;

        if(mysqli_num_rows($cb)>0){
?>

            <table class="table table-bordered table-hover" id="dt_ban1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SEGUIMIENTO</th>
                        <th>DOCUMENTO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>
                        <th>FECHA ESTADO</th>
                        <th>GUÍA</th>                      
                    </tr>
                </thead>
                <tbody>
<?php
                    $n=0;
                    while($rb=mysqli_fetch_assoc($cb)){         
                        $n++;
?>
                    <tr style="font-size: 12px;">
                        <td><?php echo $n; ?></td>
                        <td class="text-aqua"><?php echo $rb['numdoc'].'-'.$rb['Ano']; ?></td>
                        <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?> <span class="text-teal">(<?php echo $rb['TipoDoc']; ?>)</span></td>
                        <td><?php echo fnormal($rb['FechaDoc']); ?></td>
                        <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($rb['fecha'])); ?></td>
                        <td><?php echo $rb['numero'] ? $rb['numero'].'-'.$rb['anio'] : ''; ?></td>
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