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
                        $cp=mysqli_query($cone,"SELECT ma.idAtencion, ma.Fecha, ma.idEmpleado, mp.Producto, ma.Registrador, mt.Tipo, msc.SubCategoria, mc.Categoria FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ms.idEmpleado=$ids AND ma.Estado=2 ORDER BY ma.Fecha ASC;");
                      ?>
                        <table id="dtpersonal" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>FECHA</th>
                              <th>TIEMPO</th>
                              <th>USUARIO</th>
                              <th>CATEGORIA</th>
                              <th>ASIGNADA POR</th>
                              <th>ACCIÓN</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                          $n=0;
                          while($rp=mysqli_fetch_assoc($cp)){
                            $n++;
                            $reg=explode(" ", nomempleado($cone,$rp["Registrador"]));
                      ?>
                            <tr>
                              <td><?php echo $n; ?></td>
                              <td><?php echo ftnormal($rp["Fecha"]) ?></td>
                              <td><?php echo diftiempo($rp["Fecha"],date('Y-m-d H:i')); ?></td>
                              <td><?php echo nomempleado($cone,$rp["idEmpleado"]) ?></td>
                              <td><?php echo $rp['Categoria']." - ".$rp['SubCategoria']." - ".$rp['Tipo']." - ".$rp['Producto'] ?></td>
                              <td><?php echo $reg[2]." ".$reg[0] ?></td>
                              <td>
                                
                                <div class="btn-group">
                                  <button class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>&nbsp;
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                  </button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" onclick="iatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_iatencion"><i class="fa fa-info-circle"></i> Info</a></li>
                                    <li><a href="#" onclick="eatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_eatencion"><i class="fa fa-pencil"></i> Editar</a></li>
                                    <li><a href="#" onclick="ratencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_ratencion"><i class="fa fa-share"></i> Reasignar</a></li>
                                    <li><a href="#" onclick="reatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_reatencion"><i class="fa fa-check"></i> Resolver</a></li>
                                    <li><a href="#" onclick="caatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_caatencion"><i class="fa fa-ban"></i> Cancelar</a></li>
                                  </ul>
                                </div>


                              </td>
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
	  $('#dtpersonal').DataTable();
</script>
<?php
}else{
  echo accrestringidoa();
}
?>