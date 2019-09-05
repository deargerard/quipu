<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];
    $cb=mysqli_query($cone, "SELECT mp.*, l.Direccion, l.idDistrito FROM tdmesapartes mp INNER JOIN local l ON mp.idLocal=l.idLocal;");
    if(mysqli_num_rows($cb)>0){
?>
        <br>
        <table class="table table-bordered table-hover" id="dt_bandeja">
            <thead>
                <tr>
                    <th>#</th>
                    <th>DENOMINACIÓN</th>
                    <th>LOCAL</th>
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
                    <td><?php echo $rb['denominacion']; ?></td>
                    <td><?php echo $rb['Direccion']." [".disprodep($cone, $rb['idDistrito'])."]"; ?></td>
                    <td><?php echo estado($rb['estado']); ?></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <?php if(accesoadm($cone,$_SESSION['identi'],17)){ ?>
                            <button type="button" class="btn btn-info btn-xs" title="Editar Mesa de Partes" onclick="f_mpartes('edimpar',<?php echo $rb['idtdmesapartes'].",0"; ?>)"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-info btn-xs" title="Cambiar Estado" onclick="f_mpartes('estmpar',<?php echo $rb['idtdmesapartes'].",0"; ?>)"><i class="fa fa-toggle-on"></i></button>
                            <button type="button" class="btn btn-info btn-xs" title="Responsables" onclick="f_mpartes('resmpar',<?php echo $rb['idtdmesapartes'].",0"; ?>)"><i class="fa fa-users"></i></button>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_bandeja").DataTable();
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