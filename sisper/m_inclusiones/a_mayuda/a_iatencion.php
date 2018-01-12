<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id=iseguro($cone,$_POST['id']);
    $ca=mysqli_query($cone, "SELECT ma.Fecha, ma.idEmpleado, ma.idProducto, ma.Descripcion, ma.Medio, ma.Solucion, ma.FecSolucion, ma.Estado, ma.Registrador, ms.idEmpleado as idSolucionador FROM maatencion ma INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE idAtencion=$id;");
    if($ra=mysqli_fetch_assoc($ca)){
?>

        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-hover">
              <tr>
                <td colspan="4">
                  <div class="row">
                    <div class="col-md-3">
                      <img src="<?php echo mfotom(DNI($cone,$ra['idEmpleado'])) ?>" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-9">
                      <table class="table table-bordered table-hover">
                        <tr>
                          <th><span class="text-aqua">Usuari@</span></th>
                          <th><?php echo nomempleado($cone,$ra['idEmpleado']); ?></th>
                        </tr>
                        <tr>
                          <th><span class="text-aqua">Cargo</span></th>
                          <td><?php echo cargoe($cone,$ra['idEmpleado']); ?></td>
                        </tr>
                        <tr>
                          <th><span class="text-aqua">Dependencia</span></th>
                          <td><?php echo dependenciae($cone,$ra['idEmpleado']); ?></td>
                        </tr>
                        <tr>
                          <th><span class="text-aqua"># Contacto</span></th>
                          <td><?php echo telefonose($cone,$ra['idEmpleado']); ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <th colspan="4"><span class="text-aqua">Descripción</span></th>
              </tr>
              <tr>
                <td colspan="4"><?php echo $ra['Descripcion']; ?></td>
              </tr>
              <?php
              $idp=$ra['idProducto'];
              $cc=mysqli_query($cone,"SELECT mp.Producto, mt.Tipo, ms.SubCategoria, mc.Categoria FROM maproducto mp INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria ms ON mt.idSubCategoria=ms.idSubCategoria INNER JOIN macategoria mc ON ms.idCategoria=mc.idCategoria WHERE mp.idProducto=$idp;");
              if($rc=mysqli_fetch_assoc($cc)){
                $cat=$rc['Categoria']." - ".$rc['SubCategoria']." - ".$rc['Tipo']." - ".$rc['Producto'];
              }else{
                $cat='No se hallo la categoria.';
              }
              ?>
              <tr>
                <th colspan="4"><span class="text-aqua">Categoria</span></th>
              </tr>
              <tr>
                <td colspan="4"><?php echo $cat; ?></td>
              </tr>
              <tr>
                <th><span class="text-aqua">Asignada a</span></th>
                <?php
                $asi=explode(" ", nomempleado($cone, $ra['idSolucionador']));
                ?>
                <td><?php echo $asi[2]." ".$asi[0]; ?></td>
                <th><span class="text-aqua">Asignada por</span></th>
                <?php
                $asig=explode(" ", nomempleado($cone, $ra['Registrador']));
                ?>
                <td><?php echo $asig[2]." ".$asig[0]; ?></td>
              </tr>
              <tr>
                <th><span class="text-aqua">Fec. Reporte</span></th>
                <td><?php echo ftnormal($ra['Fecha']); ?></td>
                <th><span class="text-aqua">Estado</span></th>
                <td><?php echo ateestado($ra['Estado']); ?></td>
              </tr>
              <?php
              if($ra['Estado']!=2){
              ?>
              <tr>
                <th colspan="4"><span class="text-aqua">Trabajo realizado</span></th>
              </tr>
              <tr>
                <td colspan="4"><?php echo $ra['Solucion']; ?></td>
              </tr>
              <tr>
                <th><span class="text-aqua">Fec. Resv./Canc.</span></th>
                <td><?php echo ftnormal($ra['FecSolucion']); ?></td>
                <th><span class="text-aqua">Medio Solucion</span></th>
                <td><?php echo atemedio($ra['Medio']); ?></td>
              </tr>
              <?php
              }
              ?>
            </table>
          </div>
        </div>


        <script>
          $(".select2med").select2();
        </script>
<?php
    }else{
      echo mensajeda("No envió datos válidos.");
    }
    mysqli_free_result($ca);
  }else{
    echo mensajeda("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
