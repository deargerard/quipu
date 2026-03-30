<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['fini']) && !empty($_POST['fini']) && isset($_POST['ffin']) && !empty($_POST['ffin'])){
        $idem=$_SESSION['identi'];     
        $per=iseguro($cone,$_POST['per']);
        $fini=fmysql(iseguro($cone,$_POST['fini']));
        $ffin=fmysql(iseguro($cone,$_POST['ffin']));
?>                
      <div class="text-blue"><h4><b><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone, $per);?></b></h4></div>
      <hr>
<?php
        $q="SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.numdoc, d.FechaDoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, ed.idtdestado, ed.estado FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idEmpleado=$per AND ed.idtdmesapartes IS NULL AND (DATE_FORMAT(ed.fecha, '%Y-%m-%d') BETWEEN '$fini' AND '$ffin') AND ed.idtdestado in (2,3) AND ed.estado=1 ORDER BY ed.fecha DESC;";
        $cb=mysqli_query($cone, $q);

        if(mysqli_num_rows($cb)>0){
?>

            <table class="table table-bordered table-hover" id="dt_dtra">
                <thead>
                    <tr>
                        <td>#</td>
                        <th># SEG.</th>
                        <th>DOCUMENTO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>
                        <th>FECHA ESTADO</th>               
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
                        <td><?php echo (!is_null($rb['Numero']) ? $rb['Numero']."-" : "").$rb['Ano']."-".(!is_null($rb['Siglas']) ? "-".$rb['Siglas'] : ""); ?> <span class="text-teal">(<?php echo $rb['TipoDoc']; ?>)</span></td>
                        <td><?php echo date('d/m/Y', strtotime($rb['FechaDoc'])); ?></td>
                        <td><?php echo estadoDoc($rb['idtdestado']); ?></td>
                        <td><?php echo date('d/m/Y h:i:s A', strtotime($rb['fecha'])); ?></td>
                    </tr>
<?php
                    }
?>
                </tbody>
            </table>

        <script>
            $("#dt_dtra").DataTable({
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