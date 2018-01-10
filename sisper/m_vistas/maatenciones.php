<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(solucionador($cone,$_SESSION['identi'])){
    $ids=$_SESSION['identi'];
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Atenciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Mesa de Ayuda</li>
        <li class="active">Atenciones</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Atenciones Pendientes</a></li>
              <li><a href="#tab_2" data-toggle="tab">Atendidas en <?php echo nombremes(date('m')); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <button class="btn bg-aqua" id="b_natencion" data-toggle="modal" data-target="#m_natencion">Nueva Atención</button>
                <!--Div resultados-->
                <hr>
                <div class="r_telefono">


                  <div class="row">
                    <div class="col-md-12" id="r_bpersonal">
                      <?php
                        $cp=mysqli_query($cone,"SELECT ma.idAtencion, ma.Fecha, ma.idEmpleado, mp.Producto, ma.Descripcion, ma.Registrador, mt.Tipo, msc.SubCategoria, mc.Categoria FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ms.idEmpleado=$ids AND ma.Estado=2 ORDER BY ma.Fecha DESC;");
                      ?>
                        <table id="dtpersonal" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>FECHA</th>
                              <th>USUARIO</th>
                              <th>CATEGORIA</th>
                              <th>DESCRIPCIÓN</th>
                              <th>ASIGNADA POR</th>
                              <th>ACCIÓN</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                          $n=0;
                          while($rp=mysqli_fetch_assoc($cp)){
                            $n++;
                      ?>
                            <tr>
                              <td><small class="hidden"><?php echo $n; ?></small><?php echo ftnormal($rp["Fecha"]) ?></td>
                              <td><?php echo nomempleado($cone,$rp["idEmpleado"]) ?></td>
                              <td><?php echo $rp['Categoria']." - ".$rp['SubCategoria']." - ".$rp['Tipo']." - ".$rp['Producto'] ?></td>
                              <td><?php echo $rp['Descripcion']; ?></td>
                              <td><?php echo nomempleado($cone,$rp["Registrador"]) ?></td>
                              <td>
                                
                                <div class="btn-group">
                                  <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-cog"></i>&nbsp;
                                    <span class="caret"></span>
                                    <span class="sr-only">Desplegar menú</span>
                                  </button>
                                  <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="#" onclick="eatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_eatencion">Editar</a></li>
                                    <li><a href="#" onclick="ratencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_aadjunto">Reasignar</a></li>
                                    <li><a href="#" onclick="ratención(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_dcomunicado">Resolver</a></li>
                                    <li><a href="#" onclick="catencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_acomunicado">Cancelar</a></li>
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


                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Div resultados-->
                <hr>
                <div class="r_correo">


                  <div class="row">
                    <div class="col-md-12" id="r_bpersonal">
                      <?php
                        $ma=date('Y-m');
                        $cp=mysqli_query($cone,"SELECT ma.Fecha, ma.idEmpleado, ma.FecSolucion, ma.Estado, mp.Producto, ma.Solucion, ma.Registrador, mt.Tipo, msc.SubCategoria, mc.Categoria FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ms.idEmpleado=$ids AND ma.Estado!=2 AND DATE_FORMAT(ma.FecSolucion,'%Y-%m')='$ma' ORDER BY ma.FecSolucion DESC;");
                      ?>
                        <table id="dtatendidas" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>FEC. ATENDIDA</th>
                              <th>FEC. REPORTE</th>
                              <th>USUARIO</th>
                              <th>CATEGORIA</th>
                              <th>DETALLE ANTENCIÓN</th>
                              <th>ASIGNADA POR</th>
                              <th>ESTADO</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php
                          $m=0;
                          while($rp=mysqli_fetch_assoc($cp)){
                            $m++;
                      ?>
                            <tr>
                              <td><?php echo $m; ?></td>
                              <td><?php echo ftnormal($rp["FecSolucion"]) ?></td>
                              <td><?php echo ftnormal($rp["Fecha"]) ?></td>
                              <td><?php echo nomempleado($cone,$rp["idEmpleado"]) ?></td>
                              <td><?php echo $rp['Categoria']." - ".$rp['SubCategoria']." - ".$rp['Tipo']." - ".$rp['Producto'] ?></td>
                              <td><?php echo $rp['Solucion']; ?></td>
                              <td><?php echo nomempleado($cone,$rp["Registrador"]) ?></td>
                              <td><?php echo ateestado($rp['Estado']); ?></td>
                            </tr>
                      <?php
                          }
                          mysqli_free_result($cp);
                      ?>
                          </tbody>
                        </table>
                    </div>
                  </div>


                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>

    </section>
    <!-- /.content -->


<!--Modal nuevo telefono personal-->
<div class="modal fade" id="m_natencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Atención</h4>
      </div>
      <div class="modal-body" id="r_nuetel">
        <form id="f_natencion" action="" class="form-horizontal">

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnatencion" form="f_natencion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>
<!--Fin Modal nuevo telefono personal-->

<!--Modal nuevo telefono personal-->
<div class="modal fade" id="m_eatencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Atención</h4>
      </div>
      <div class="modal-body">
        <form id="f_eatencion" action="" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_geatencion" form="f_eatencion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>
<!--Fin Modal nuevo telefono personal-->

<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>