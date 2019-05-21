<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];
    $cb=mysqli_query($cone, "SELECT d.idDoc, d.Numero, d.Ano, d.Siglas, d.FechaDoc, td.TipoDoc, ed.idtdestadodoc, ed.fecha, e.nombre, g.numero numguia, g.anio FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc INNER JOIN tdestado e ON ed.idtdestado=e.idtdestado LEFT JOIN tdguia g ON ed.idtdguia=g.idtdguia WHERE ed.idEmpleado=$idem AND ed.estado=1;");
    if(mysqli_num_rows($cb)>0){
?>
        <table class="table table-bordered table-hover" id="dt_bandeja">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DOC.</th>
                    <th>T. DOC.</th>
                    <th>F. DOC.</th>
                    <th>F. DERIVADO</th>
                    <th>F. CREADO/RECIBIDO</th>
                    <th>GUÍA</th>
                    <th>ESTADO</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
<?php
        $n=0;
        while($rb=mysqli_fetch_assoc($cb)){
            $n++;
?>
                <tr>
                    <td><?php echo $n; ?></td>
                    <td><?php echo $rb['Numero']."-".$rb['Ano']."-".$rb['Siglas']; ?></td>
                    <td><?php echo $rb['TipoDoc']; ?></td>
                    <td><?php echo $rb['FechaDoc']; ?></td>
                    <td><?php  ?></td>
                    <td><?php echo $rb['fecha']; ?></td>
                    <td><?php echo $rb['numguia']; ?></td>
                    <td><?php echo $rb['nombre']; ?></td>
                    <td></td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_bandeja").addClass("active");
        </script>
<?php
    }else{
        echo mensajewa("Bandeja vacia.");
    }
    mysqli_free_result($cb);
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>