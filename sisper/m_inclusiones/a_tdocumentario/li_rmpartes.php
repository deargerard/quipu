<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
    if(isset($_POST['v1']) && !empty($_POST['v1'])){
        $v1=iseguro($cone, $_POST['v1']);
                $cr=mysqli_query($cone, "SELECT * FROM tdpersonalmp WHERE idtdmesapartes=$v1;");
                if(mysqli_num_rows($cr)>0){
?>
                <table class="table table-bordered table-hover" id="dt_rmpartes">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>DEPENDENCIA</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                    $n=0;
                    while($rr=mysqli_fetch_assoc($cr)){
                        $n++;
?>
                        <tr style="font-size: 12px;">
                            <td><?php echo $n; ?></td>
                            <td><?php echo nomempleado($cone, $rr['idEmpleado']); ?></td>
                            <td><?php echo dependenciae($cone, $rr['idEmpleado']); ?></td>
                            <td><?php echo estado($rr['estado']); ?></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm btn-xs" title="Cambiar estado" onclick="f_mpartesp('estres', <?php echo $rr['idtdpersonalmp'].', '.$v1; ?>);"><i class="fa fa-toggle-on"></i></button>
                            </td>
                        </tr>
<?php
                    }
?>
                    </tbody>
                </table>
                <script>
                    $("#dt_rmpartes").dataTable();
                </script>
<?php
                }else{
                    echo mensajewa("Aún no se asignó personal a esta mesa de partes.");
                }
                mysqli_free_result($cr);
    }else{
        echo mensajewa("Faltan datos para listas responsables");
    }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>