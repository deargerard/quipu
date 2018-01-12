<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $ids=$_SESSION['identi'];
?>

                  <div class="row">
                    <div class="col-md-12" id="r_bpersonal">
                      <?php
                        $ma=date('Y-m');
                        $cp=mysqli_query($cone,"SELECT ma.idAtencion, ma.Fecha, ma.idEmpleado, ma.FecSolucion, ma.Estado, mp.Producto, ma.Registrador, mt.Tipo, msc.SubCategoria, mc.Categoria FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ms.idEmpleado=$ids AND ma.Estado!=2 AND DATE_FORMAT(ma.FecSolucion,'%Y-%m')='$ma' ORDER BY ma.FecSolucion DESC;");
                      ?>
                        <table id="dtatendidas" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>FEC. ATENDIDA</th>
                              <th>FEC. REGISTRO</th>
                              <th>TIEMPO</th>
                              <th>USUARIO</th>
                              <th>CATEGORIA</th>
                              <th>ASIGNADA POR</th>
                              <th>ESTADO</th>
                              <th>ACCIÓN</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                          $m=0;
                          while($rp=mysqli_fetch_assoc($cp)){
                            $m++;
                            $reg=explode(" ", nomempleado($cone,$rp["Registrador"]));
                      ?>
                            <tr>
                              <td><?php echo $m; ?></td>
                              <td><?php echo ftnormal($rp["FecSolucion"]) ?></td>
                              <td><?php echo ftnormal($rp["Fecha"]) ?></td>
                              <td><?php echo diftiempo($rp["Fecha"],$rp["FecSolucion"]); ?></td>
                              <td><?php echo nomempleado($cone,$rp["idEmpleado"]) ?></td>
                              <td><?php echo $rp['Categoria']." - ".$rp['SubCategoria']." - ".$rp['Tipo']." - ".$rp['Producto'] ?></td>
                              <td><?php echo $reg[2]." ".$reg[0] ?></td>
                              <td><?php echo ateestado($rp['Estado']); ?></td>
                              <td><button type="button" class="btn btn-info btn-xs" onclick="iatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_iatencion"><i class="fa fa-info-circle"></i> Info</button></td>
                            </tr>
                      <?php
                          }
                          mysqli_free_result($cp);
                      ?>
                          </tbody>
                        </table>
                    </div>
                  </div>
<script>
	  $('#dtatendidas').DataTable();
</script>
<?php
}else{
  echo accrestringidoa();
}
?>