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
              <li class="active"><a href="#tab_1" data-toggle="tab">Mis atenciones pendientes</a></li>
              <li><a href="#tab_2" data-toggle="tab">Atendidas en <?php echo nombremes(date('m')); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <button class="btn bg-aqua" id="b_natencion" data-toggle="modal" data-target="#m_natencion"><i class="fa fa-user-md"></i> Nueva Atención</button>
                <button class="btn bg-orange" id="b_natencion" onclick="amatenciones();"><i class="fa fa-refresh"></i> Actualizar</button>
                <!--Div resultados-->
                <hr>
                <div class="r_matenciones">


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


                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Div resultados-->
                <div class="r_matencionesma">


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


<div class="modal fade" id="m_natencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-md"></i> Nueva Atención</h4>
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

<div class="modal fade" id="m_iatencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info-circle"></i> Info de la Atención</h4>
      </div>
      <div class="modal-body" id="r_iatencion">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>

<div class="modal fade" id="m_eatencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil"></i> Editar Atención</h4>
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

<div class="modal fade" id="m_ratencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share"></i> Reasignar Atención</h4>
      </div>
      <div class="modal-body">
        <form id="f_ratencion" action="" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gratencion" form="f_ratencion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>

<div class="modal fade" id="m_reatencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check"></i> Resolver Atención</h4>
      </div>
      <div class="modal-body">
        <form id="f_reatencion" action="" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_greatencion" form="f_reatencion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>

<div class="modal fade" id="m_caatencion" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ban"></i> Cancelar Atención</h4>
      </div>
      <div class="modal-body">
        <form id="f_caatencion" action="" class="form-horizontal">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcaatencion" form="f_caatencion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>  
</div>

<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>