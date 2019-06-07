<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],15)){
?>
    <!-- Cabecera -->
    <section class="content-header">
      <h1>
      Comisión de Servicios
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Comisión de Servicios</li>
        <li class="active">Registro</li>
      </ol>
    </section>
    <!-- /.Cabecera -->
    <!-- Sección de Busqueda -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Registro</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <!--Formulario-->
                    <form action="" id="f_comser" class="form-inline">
                      <div class="form-group">
                        <label for="per" class="sr-only">Personal</label>
                        <select name="per" id="per" class="form-control select2peract" style="width: 300px;">

                        </select>
                      </div>

                      <button type="submit" id="b_bcomser" class="btn btn-default">Buscar</button>

                </form>
                    <!--Fin Formulario-->
                    <!--div resultados-->
                    <div class="row">
                      <hr>
                      <div class="col-md-12" id="r_comser">

                      </div>
                    </div>
                    <!--fin div resultados-->
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">

              </div>
              <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.Sección de Busqueda -->
    <!--Modal Nueva Comisión de Servicios-->
    <div class="modal fade" id="m_ncomservicios" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nueva Comisión de Servicios</h4>
          </div>
          <div class="modal-body">
            <form id="f_ncomservicios" class="form-horizontal">

            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gncomser" form="f_ncomservicios">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal Nueva Comisión de Servicios-->
    <!--Modal editar Comisión de Servicios-->
    <div class="modal fade" id="m_ecomservicios" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Comisión de Servicios</h4>
          </div>
          <div class="modal-body" >
            <form id="f_ecomservicios" action="" class="form-horizontal">
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gecomser" form="f_ecomservicios">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal editar Comisión de Servicios-->
    <!--Modal Detalle Comisión de Servicios-->
    <div class="modal fade" id="m_dcomservicios" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detalle de la Comisión de Servicios</h4>
          </div>
          <div class="modal-body">
            <form id="f_dcomservicios" action="" class="form-horizontal">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal Detalle Comisión de Servicios-->
    <!--Modal Cancelar Comisión de Servicios-->
    <div class="modal fade" id="m_ccomservicios" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog modal-ls" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Cancelar Comisión de Servicios</h4>
          </div>
          <div class="modal-body">
            <form id="f_ccomservicios" action="" class="form-horizontal">
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_siccomser" form="f_ccomservicios">Sí</button>
            <button type="button" class="btn btn-default" id="b_noccomser" data-dismiss="modal" form="f_ccomservicios">Cancelar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal Cancelar Comisión de Servicios-->
    <!--Modal Nueva Encargatura-->
    <div class="modal fade" id="m_nencargatura" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog modal-ls" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Asignar Encargatura</h4>
          </div>
          <div class="modal-body">
            <form id="f_nencargatura" action="" class="form-horizontal">
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gnencarg" form="f_nencargatura">Guardar</button>
            <button type="button" class="btn btn-default" id="b_cnencarg" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal Nueva Encargatura-->

    <!--Modal editar eliminar Encargatura-->
    <div class="modal fade" id="m_encargatura" role="dialog" aria-labelledby="myModalLabel">

      <div class="modal-dialog modal-ls" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title titulo-enc" id="myModalLabel">Asignar Encargatura</h4>
          </div>
          <div class="modal-body">
            <form id="f_encargatura" action="" class="form-horizontal">
            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gencarg" form="f_encargatura">Guardar</button>
            <button type="button" class="btn btn-default" id="b_cencarg" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>

    </div>
    <!--Fin Modal editar eliminar Encargatura-->

    <!--Modal nuevo documento-->
    <div class="modal fade" id="m_nuedocu" role="dialog" aria-labelledby="myModalLabel">
      <form id="f_nuedocu" action="" class="form-horizontal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
          </div>
          <div class="modal-body" id="r_nuedocu">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-teal" id="b_gnuedocu">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
    <!--Fin Modal nuevo documento-->
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
