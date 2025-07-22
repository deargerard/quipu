<?php
if (isset($_SESSION['identi']) && !empty($_SESSION['identi'])) {
  if (accesocon($cone, $_SESSION['identi'], 17)) {
    $ide = $_SESSION['identi'];
    $nom=nomempleado($cone, $ide);

    $cm = mysqli_query($cone, "SELECT mp.idtdmesapartes, mp.tipo, mp.denominacion FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$ide AND pm.estado=1 AND mp.estado=1;");
    if ($rm = mysqli_fetch_assoc($cm)) {
      $tmp = $rm['tipo'];
      $imp = $rm['idtdmesapartes'];
      $nmp=$rm['denominacion'];

      //consultar el número de documentos derivados pendientes a la mesa de partes
      // $nddmp = 0;
      // $cnddmp = mysqli_query($cone, "SELECT COUNT(*) AS ndd FROM tdestadodoc WHERE idtdmesapartes=$imp AND estado=1 AND idtdestado=3;");
      // if ($rnddmp = mysqli_fetch_assoc($cnddmp)) {
      //   $nddmp = $rnddmp['ndd'];
      // }
      // mysqli_free_result($cnddmp);
      //consultar el número de documentos recibidos pendientes a la mesa de partes
      // $ndrmp = 0;
      // $cndrmp = mysqli_query($cone, "SELECT COUNT(*) AS ndr FROM tdestadodoc WHERE idtdmesapartes=$imp AND estado=1 AND idtdestado=2;");
      // if ($rndrmp = mysqli_fetch_assoc($cndrmp)) {
      //   $ndrmp = $rndrmp['ndr'];
      // }
      // mysqli_free_result($cndrmp);
    }
    mysqli_free_result($cm);
    //consulta si el usuario pertenece a una dependencia de notificaciones
    $en = false;
    $cn = mysqli_query($cone, "SELECT ec.idEmpleadoCargo FROM empleadocargo ec INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN dependencia d ON cd.idDependencia=d.idDependencia WHERE ec.idEmpleado=$ide AND ec.idEstadoCar=1 AND cd.Estado=1 AND (d.Denominacion LIKE '%NOTIFICACIONES%');");
    if (mysqli_num_rows($cn) > 0) {
      $en = true;
    }
    mysqli_free_result($cn);
    //consulta si el usuario es asistente administrativo de notificador
    $eno = false;
    if (cargoe($cone, $ide) == 'ASISTENTE ADMINISTRATIVO - NTF') {
      $eno = true;
    }
    //consulta si el usuario es supervisor
    $cs = mysqli_query($cone, "SELECT supervisor FROM empleado WHERE idEmpleado=$ide;");
    if ($rs = mysqli_fetch_assoc($cs)) {
      $su = $rs['supervisor'];
    }
    mysqli_free_result($cs);

    //consultar el número de documentos derivados pendientes del empleado
    // $nder = 0;
    // $cndd = mysqli_query($cone, "SELECT COUNT(*) AS ndd FROM tdestadodoc WHERE idEmpleado=$ide AND estado=1 AND idtdestado=3;");
    // if ($rndd = mysqli_fetch_assoc($cndd)) {
    //   $nder = $rndd['ndd'];
    // }
    // mysqli_free_result($cndd);
    //consultar el número de documentos recibidos pendientes del empleado
    // $nrec = 0;
    // $cndr = mysqli_query($cone, "SELECT COUNT(*) AS ndr FROM tdestadodoc WHERE idEmpleado=$ide AND estado=1 AND idtdestado=2;");
    // if ($rndr = mysqli_fetch_assoc($cndr)) {
    //   $nrec = $rndr['ndr'];
    // }
    // mysqli_free_result($cndr);
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bandeja
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Trámite Doc.</li>
        <li class="active">Bandeja</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs no-print">
              <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Recibir</a></li>
              <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Registrar</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar <?php echo $tmp ? "a MP" : ""; ?> </a></li>
              <?php if ($tmp == 1 || $su) { ?>
                <li><a href="#tab_9" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar a Per.</a></li>
              <?php } ?>
              <?php if ($tmp == 2) { ?>
                <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Derivar Ntf.</a></li>
              <?php } ?>
              <li><a href="#tab_5" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Atender</a></li>
              <?php if ($en || $eno) { ?>
                <li><a href="#tab_6" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Reportar Ntf.</a></li>
              <?php } ?>
              <li><a href="#tab_7" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Retornar Derivado</a></li>
              <?php if (!is_null($tmp)) { ?>
                <li><a href="#tab_8" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Guías</a></li>
                <li><a href="#tab_10" data-toggle="tab"><i class="fa fa-circle-o text-blue"></i> Asignaciones</a></li>
              <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <!-- <button type="button" class="btn bg-yellow" onclick="li_ban1();"><i class="fa fa-refresh"></i> Actualizar Datos</button> -->
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_rep1">
                      <div class="form-group">
                        <input type="text" class="form-control" id="ns1" name="ns1" placeholder="# Seguimiento" onkeydown="if(event.key==='Enter'){li_ban1();}">
                      </div>
                      <div class="form-group">
                        <div class="input-group date" id="d_dano1">
                          <input type="text" name="as1" id="as1" class="form-control" value="<?php echo date('Y'); ?>" onkeydown="if(event.key==='Enter'){li_ban1();}">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                      </div>
                      <button type="button" class="btn btn-info" onclick="li_ban1();"><i class="fa fa-search"></i> Buscar </button>
                    </form>
                    <!--Fin formulario busqueda-->
                  </div>
                </div>
                <div class="row" id="r_ban1">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban2();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                    <button type="button" class="btn bg-teal" onclick="f_bandeja('agrdoc',0,0);"><i class="fa fa-file-text-o"></i> Registrar/Derivar</button>
                    <?php if ($tmp) { ?>
                      <?php if ($tmp == 2 || $imp == 1) { ?>
                        <button type="button" class="btn bg-green" onclick="f_bandeja('agrdoa',0,0);"><i class="fa fa-file-text-o"></i> Registrar/Asignar</button>
                      <?php } ?>
                      <button type="button" class="btn bg-purple" onclick="f_bandeja('gencar',0,0);"><i class="fa fa-files-o"></i> Generar Cargo</button>
                      <?php if ($imp == 1 || $imp == 16) { ?>
                        <button type="button" class="btn bg-blue" onclick="f_bandeja('dercar',0,0);"><i class="fa fa-reply-all"></i> Derivar Cargo</button>
                      <?php } ?>
                      <?php if ($imp == 1 || $imp == 2) { ?>
                        <button type="button" class="btn bg-aqua" onclick="f_bandeja('carori',0,0);"><i class="fa fa-toggle-on"></i> Cargo/Original</button>
                        <button type="button" class="btn bg-maroon" onclick="f_bandeja('edidocu',0,0);"><i class="fa fa-edit"></i> Editar</button>
                      <?php } ?>
                      <button type="button" class="btn btn-default" onclick="f_bandeja('movdia',0,0);"><i class="fa fa-exchange"></i> Mov. Diario</button>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" id="r_ban2">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-md-6">
                    <!-- <button type="button" class="btn bg-yellow" onclick="li_ban3();"><i class="fa fa-refresh"></i> Actualizar Datos</button> -->
                    <!--Formulario busqueda-->
                    <form class="form-inline" id="f_rep3">
                        <div class="form-group">
                          <input type="text" class="form-control" id="ns3" name="ns3" placeholder="# Seguimiento">
                        </div>
                        <div class="form-group">
                          <div class="input-group date" id="d_dano3">
                            <input type="text" name="as3" id="as3" class="form-control" value="<?php echo date('Y'); ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <button type="button" class="btn btn-info" onclick="li_ban3();"><i class="fa fa-search"></i> Buscar </button>
                      </form>
                      <!--Fin formulario busqueda-->
                  </div>
                  <div class="col-md-6">
                    <?php if ($tmp) { ?>
                      <form class="form-inline pull-right">
                        <div class="form-group">
                          <label for="smpar">Derivar a</label>
                          <select class="form-control" name="smpar" id="smpar" style="width: 350px;">

                          </select>
                        </div>
                        <button type="button" class="btn bg-orange" id="b_lim3"><i class="fa fa-eraser"></i> Limpiar</button>
                      </form>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" id="r_ban3">

                </div>
                <!--Fin div resultados-->

              </div>
              <!-- /.tab-pane -->
              <?php if ($tmp == 1 || $su) { ?>
                <div class="tab-pane" id="tab_9">
                  <!--Div resultados-->
                  <div class="row">
                    <div class="col-md-5">
                      <button type="button" class="btn bg-yellow" onclick="li_ban9();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                    </div>
                    <div class="col-md-7">
                      <form class="form-inline pull-right">
                        <div class="form-group">
                          <label for="sper1">Derivar a</label>
                          <select class="form-control" name="sper1" id="sper1" style="width: 350px;">

                          </select>
                        </div>
                        <button type="button" class="btn bg-orange" id="b_lim9"><i class="fa fa-eraser"></i> Limpiar</button>
                      </form>
                    </div>
                  </div>
                  <div class="row" id="r_ban9">

                  </div>
                  <!--Fin div resultados-->

                </div>
                <!-- /.tab-pane -->
              <?php } ?>
              <?php if ($tmp == 2) { ?>
                <div class="tab-pane" id="tab_4">
                  <!--Div resultados-->
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- <button type="button" class="btn bg-yellow" onclick="li_ban4();"><i class="fa fa-refresh"></i> Actualizar Datos</button> -->
                      <!--Formulario busqueda-->
                      <form class="form-inline" id="f_rep4">
                        <div class="form-group">
                          <input type="text" class="form-control" id="ns4" name="ns4" placeholder="# Seguimiento">
                        </div>
                        <div class="form-group">
                          <div class="input-group date" id="d_dano4">
                            <input type="text" name="as4" id="as4" class="form-control" value="<?php echo date('Y'); ?>">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          </div>
                        </div>
                        <button type="button" class="btn btn-info" onclick="li_ban4();"><i class="fa fa-search"></i> Buscar </button>
                      </form>
                      <!--Fin formulario busqueda-->
                    </div>
                    <div class="col-sm-6">
                      <form class="form-inline pull-right">
                        <div class="form-group">
                          <label for="sper">Derivar a</label>
                          <select class="form-control" name="sper" id="sper" style="width: 350px;">

                          </select>
                        </div>
                        <button type="button" class="btn bg-orange" id="b_lim4"><i class="fa fa-eraser"></i> Limpiar</button>
                      </form>
                    </div>
                  </div>
                  <div class="row" id="r_ban4">

                  </div>
                  <!--Fin div resultados-->
                </div>
              <?php } ?>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_5">
                <!--Div resultados-->
                <div class="row">
                  <div class="col-sm-12">
                    <button type="button" class="btn bg-yellow" onclick="li_ban5();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                  </div>
                </div>
                <div class="row" id="r_ban5">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php if ($en || $eno) { ?>
                <div class="tab-pane" id="tab_6">
                  <!--Div resultados-->
                  <div class="row">
                    <div class="col-sm-12">
                      <button type="button" class="btn bg-yellow" onclick="li_ban6();"><i class="fa fa-refresh"></i> Actualizar Datos</button>
                    </div>
                  </div>
                  <div class="row" id="r_ban6">

                  </div>
                  <!--Fin div resultados-->
                </div>
              <?php } ?>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_7">
                <!--Formulario busqueda-->
                <form class="form-inline" id="f_rep7">
                  <div class="form-group">
                    <input type="text" class="form-control" id="ns" name="ns" placeholder="# Seguimiento">
                  </div>
                  <div class="form-group">
                    <div class="input-group date" id="d_dano">
                      <input type="text" name="as" id="as" class="form-control" value="<?php echo date('Y'); ?>">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                  <button type="button" class="btn btn-info" onclick="li_ban7();"><i class="fa fa-search"></i> Buscar </button>
                </form>
                <!--Fin formulario busqueda-->
                <div class="row" id="r_ban7">

                </div>
                <!--Fin div resultados-->
              </div>
              <!-- /.tab-pane -->
              <?php if (!is_null($tmp)) { ?>
                <div class="tab-pane" id="tab_8">
                  <!--Div resultados-->
                  <div class="row" id="r_ban8">

                  </div>
                  <!--Fin div resultados-->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_10">
                  <!--Formulario busqueda-->
                  <form class="form-inline no-print" id="f_asig">
                    <div class="form-group">
                      <select class="form-control" name="pasi" id="pasi" style="width: 350px;">

                      </select>
                    </div>
                    <div class="form-group">
                      <div class="input-group date" id="d_fasi">
                        <input type="text" name="fasi" id="fasi" class="form-control" value="<?php echo date('d/m/Y'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                    <button type="button" class="btn btn-info" onclick="li_ban10();"><i class="fa fa-search"></i> Buscar </button>
                  </form>
                  <!--Fin formulario busqueda-->
                  <div class="row" id="r_ban10">

                  </div>
                  <!--Fin div resultados-->
                </div>
                <!-- /.tab-pane -->
              <?php } ?>

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>

    </section>
    <!-- /.content -->

    <!--Modal-->
    <div class="modal fade" id="m_modal" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" id="m_tamano" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Titulo</h4>
          </div>
          <div class="modal-body">
            <form id="f_modal" autocomplete="off">

            </form>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn bg-green" id="b_guardar" form="f_modal"><i class="fa fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!--Fin Modal Detalle Dependencia-->


<?php
  } else {
    echo accrestringidop();
  }
} else {
  header('Location: ../index.php');
}
?>