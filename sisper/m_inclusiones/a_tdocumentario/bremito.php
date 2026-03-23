<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    if(isset($_POST['mprem']) && !empty($_POST['mprem']) && isset($_POST['mrem']) && !empty($_POST['mrem']) && isset($_POST['amb']) && !empty($_POST['amb'])){
        $mprem=iseguro($cone,$_POST['mprem']);
        $mrem=iseguro($cone,$_POST['mrem']);
        $amb=iseguro($cone,$_POST['amb']);
?>                
      <div class="text-blue"><h4><b><i class="fa fa-archive text-orange"></i> <?php echo nommpartes($cone, $mprem); ?></b></h4></div>
      <hr>
      <h4 class="text-center">REPORTE DE REMITOS CORRESPONDIENTE A CORREO <?php echo $amb==1 ? 'LOCAL' : 'NACIONAL'; ?> EMITIDAS EN EL MES DE <span class="text-uppercase"><?php echo nombremes($mrem); ?></span></h4>
<?php
        if($amb==1){
            //consultar la tabla  tdremitos asociado por a la tabla tdmesapartes a travez de su campo mp_destino.
            $q="SELECT r.idtdremito, r.num_remito, r.peso, r.fecha_remite, r.fecha_recepcion, r.fecha_cargo, r.num_acta, mp.denominacion, mp.plazo_recepcion, mp.plazo_cargo FROM tdremito r INNER JOIN tdmesapartes mp ON r.mp_destino=mp.idtdmesapartes WHERE r.mp_remite=$mprem AND DATE_FORMAT(r.fecha_remite, '%m/%Y')='$mrem' AND mp.ambito=$amb ORDER BY r.fecha_remite ASC;";

            $cb=mysqli_query($cone, $q);

            //echo $q;

            if(mysqli_num_rows($cb)>0){
?>

            <table class="table table-bordered table-hover" id="dt_ban6">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Remito</th>
                        <th>Destino</th>
                        <th>Fecha Entrega</th>
                        <th>Fecha Recepción</th>
                        <th>Días</th>                      
                        <th>Fecha Dev. Cargo</th>
                        <th>Días</th>
                        <th>N° Acta</th>
                        <th style="text-align: right;">Peso Inicial</th>
                        <th style="text-align: right;">Peso Adicional</th>
                        <th style="text-align: right;">Peso Total</th>
                    </tr>
                </thead>
                <tbody>
<?php
                    $n=0;
                    while($rb=mysqli_fetch_assoc($cb)){     
                        $n++;
                        if($rb['peso']>1){
                            $peso=1;
                            $peso_adicional=$rb['peso']-1;
                        }else{
                            $peso=$rb['peso'];
                            $peso_adicional=0;
                        }

?>
                    <tr style="font-size: 12px;">
                        <td class="text-aqua"><?php echo $n; ?></td>
                        <td><?php echo $rb['num_remito']; ?></td>
                        <td><?php echo $rb['denominacion']; ?></td>
                        <td><?php echo fnormal($rb['fecha_remite']); ?></td>
                        <td><?php echo $rb['fecha_recepcion'] ? fnormal($rb['fecha_recepcion']) : ''; ?></td>
                        <td>
                            <?php
                            if($rb['fecha_recepcion']) {
                                $diasHabilesRecepcion = diasHabiles($cone, $rb['fecha_remite'], $rb['fecha_recepcion']);
                                if($diasHabilesRecepcion > $rb['plazo_recepcion']) {
                                    echo '<span class="text-red">' . $diasHabilesRecepcion. '</span>';
                                } else {
                                    echo '<span class="text-green">' . $diasHabilesRecepcion. '</span>';
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $rb['fecha_cargo'] ? fnormal($rb['fecha_cargo']) : ''; ?></td>
                        <td>
                            <?php
                            if($rb['fecha_recepcion'] && $rb['fecha_cargo']) {
                                $diasHabilesCargo = diasHabiles($cone, $rb['fecha_recepcion'], $rb['fecha_cargo']);
                                if($diasHabilesCargo > $rb['plazo_cargo']) {
                                    echo '<span class="text-red">' . $diasHabilesCargo. '</span>';
                                } else {
                                    echo '<span class="text-green">' . $diasHabilesCargo. '</span>';
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $rb['num_acta'] ? $rb['num_acta'] : ''; ?></td>
                        <td align="right"><?php echo number_format($peso, 2); ?></td>
                        <td align="right"><?php echo number_format($peso_adicional, 2); ?></td>
                        <td align="right"><?php echo number_format($rb['peso'], 2); ?></td>
                    </tr>
<?php
                    }
?>
                </tbody>
            </table>

        <script>
            $("#dt_ban6").DataTable({
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
                echo mensajewa("Sin remitos.");
            }
            mysqli_free_result($cb);
        }elseif($amb==2){
            //consultar la tabla  tdremitos asociado por a la tabla tdmesapartes a travez de su campo mp_destino.
            $q="SELECT r.idtdremito, r.num_remito, r.peso, r.fecha_remite, r.fecha_recepcion, r.fecha_cargo, r.num_acta, mp.denominacion, mp.ambito FROM tdremito r INNER JOIN tdmesapartes mp ON r.mp_destino=mp.idtdmesapartes WHERE r.mp_remite=$mprem AND DATE_FORMAT(r.fecha_remite, '%m/%Y')='$mrem' AND mp.ambito=$amb ORDER BY r.fecha_remite ASC;";

            $cb=mysqli_query($cone, $q);

            //echo $q;

            if(mysqli_num_rows($cb)>0){
?>

            <table class="table table-bordered table-hover" id="dt_ban6">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Remito</th>
                        <th>Destino</th>
                        <th>Fecha Entrega</th>
                        <th>Fecha Recepción</th>  
                        <th>Días</th>                      
                        <th>Fecha Dev. Cargo</th>
                        <th>Días</th>
                        <th>N° Acta</th>
                        <th style="text-align: right;">Peso Inicial</th>
                        <th style="text-align: right;">Peso Adicional</th>
                        <th style="text-align: right;">Peso Total</th>
                    </tr>
                </thead>
                <tbody>
<?php
                    $n=0;
                    while($rb=mysqli_fetch_assoc($cb)){     
                        $n++;
                        if($rb['peso']>1){
                            $peso=1;
                            $peso_adicional=$rb['peso']-1;
                        }else{
                            $peso=$rb['peso'];
                            $peso_adicional=0;
                        }

?>
                    <tr style="font-size: 12px;">
                        <td class="text-aqua"><?php echo $n; ?></td>
                        <td><?php echo $rb['num_remito']; ?></td>
                        <td><?php echo $rb['denominacion']; ?></td>
                        <td><?php echo fnormal($rb['fecha_remite']); ?></td>
                        <td><?php echo $rb['fecha_recepcion'] ? fnormal($rb['fecha_recepcion']) : ''; ?></td>
                        <td><?php echo $rb['fecha_recepcion'] ? diasHabiles($cone, $rb['fecha_remite'], $rb['fecha_recepcion']) : ''; ?></td>
                        <td><?php echo $rb['fecha_cargo'] ? fnormal($rb['fecha_cargo']) : ''; ?></td>
                        <td><?php echo ($rb['fecha_cargo'] && $rb['fecha_recepcion']) ? diasHabiles($cone, $rb['fecha_recepcion'], $rb['fecha_cargo']) : ''; ?></td>
                        <td><?php echo $rb['num_acta'] ? $rb['num_acta'] : ''; ?></td>
                        <td align="right"><?php echo number_format($peso, 2); ?></td>
                        <td align="right"><?php echo number_format($peso_adicional, 2); ?></td>
                        <td align="right"><?php echo number_format($rb['peso'], 2); ?></td>
                    </tr>
<?php
                    }
?>
                </tbody>
            </table>

        <script>
            $("#dt_ban6").DataTable({
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
                echo mensajewa("Sin remitos.");
            }
            mysqli_free_result($cb);
        }
        
    }else{
        echo mensajewa("Error, faltan datos.");
    }  
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>