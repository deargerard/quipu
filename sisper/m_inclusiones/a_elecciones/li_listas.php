<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],18)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone, $_POST['id']);
    $idem=$_SESSION['identi'];
    $cb=mysqli_query($cone, "SELECT * FROM listas WHERE eleccione_id=$id ORDER BY id DESC;");
    if(mysqli_num_rows($cb)>0){
?>
      <div class="col-sm-12">
        <table class="table table-bordered table-hover" id="dt_listas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCIÓN</th>
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
                    <td width="5%"><?php echo $n; ?></td>
                    <td width="10%"><?php echo $rb['nombre']; ?></td>
                    <td><?php echo html_entity_decode($rb['descripcion']); ?></td>
                    <td class="text-center" width="10%">
                        <div class="btn-group btn-group-xs">
                            <button type="button" class="btn btn-info btn-xs" title="Editar" onclick="f_eleccionp('edilis',<?php echo $rb['eleccione_id'].",".$rb['id']; ?>)"><i class="fa fa-pencil"></i></button>
                            <button type="button" class="btn btn-danger btn-xs" title="Eliminar" onclick="f_eleccionp('elilis',<?php echo $rb['eleccione_id'].",".$rb['id']; ?>)"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
      </div>
        <script>
            $("#dt_listas").DataTable();
        </script>
<?php
    }else{
        echo mensajewa("No se encontraron listas registradas.");
    }
    mysqli_free_result($cb);
  }else{
    echo mensajewa("Faltan datos.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>