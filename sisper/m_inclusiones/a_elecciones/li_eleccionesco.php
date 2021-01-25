<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],18)){
    $idem=$_SESSION['identi'];
    $cb=mysqli_query($cone, "SELECT * FROM elecciones WHERE estado=1 ORDER BY id DESC;");
    if(mysqli_num_rows($cb)>0){
?>
        <br>
        <table class="table table-bordered table-hover" id="dt_elecciones">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DESCRIPCIÓN</th>
                    <th>INICIA</th>
                    <th>FINALIZA</th>
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
                    <td><?php echo $rb['nombre']; ?></td>
                    <td><?php echo ftnormal($rb['inicio']); ?></td>
                    <td><?php echo ftnormal($rb['fin']); ?></td>
                    <td><?php echo estado($rb['estado']); ?></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <button type="button" class="btn btn-info btn-xs" title="Ver Resultados" onclick="f_eleccionco('verres',<?php echo $rb['id'].",0"; ?>)"><i class="fa fa-pie-chart"></i></button>
                        </div>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_elecciones").DataTable();
        </script>
<?php
    }else{
        echo mensajewa("No se encontraron mesas de partes registradas.");
    }
    mysqli_free_result($cb);
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>