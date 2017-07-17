        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="box box-info collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Directorio Institucional</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="form-group">
                          <label for="per">Personal</label>
                          <select id="per" name="per" class="form-control select2peract" style="width: 100%;">

                          </select>
                        </div>

                        <button class="btn btn-info btn-xs pull-right" id="dirper" data-toggle="modal" data-target="#mdirectorio"><i class="fa fa-search"></i></button>

                      <div class="clearfix"></div>

                        <div class="form-group">
                          <label for="dep">Dependencia</label>
                          <select id="dep" name="dep" class="form-control select2depact" style="width: 100%;">

                          </select>
                        </div>

                        <button class="btn btn-info btn-xs pull-right" id="dirdep" data-toggle="modal" data-target="#mdirectorio"><i class="fa fa-search"></i></button>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Comunicados</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                            <?php
                            $fecha=@date('Y-m-d');
                            $cco=mysqli_query($cone,"SELECT idComunicado, Descripcion FROM comunicado WHERE Estado=1 AND Fecha<='$fecha' ORDER BY Fecha DESC, idComunicado DESC LIMIT 10");
                            if(mysqli_num_rows($cco)>0){
                                while($rco=mysqli_fetch_assoc($cco)){
                            ?>
                            <tr>
                                <td><i class="fa fa-bullhorn cwarning"></i></td>
                                <td><a href="#" data-toggle="modal" data-target="#mcomunicado" onclick="vcomunicado(<?php echo $rco["idComunicado"] ?>)"><?php echo $rco['Descripcion'] ?></a></td>
                            </tr>
                            <?php
                                }
                            }else{
                            ?>
                            <tr>
                                <td><i class="fa fa-bell-o cwarning"></i></td>
                                <td>No hay comunicados</td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($cco);
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">¡Feliz Cumpleaños!</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                            <?php
                            $ccum=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres FROM empleado AS e INNER JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEstadoCar=1 AND date_format(FechaNac, '%m') = date_format(now(), '%m') AND date_format(FechaNac, '%d') = date_format(now(), '%d') ORDER BY ApellidoPat, ApellidoMat ASC");
                            if(mysqli_num_rows($ccum)>0){
                                while($rcum=mysqli_fetch_assoc($ccum)){
                            ?>
                            <tr>
                                <td><i class="fa fa-birthday-cake cdanger"></i></td>
                                <td><?php echo $rcum['ApellidoPat']." ".$rcum['ApellidoMat'].", ".$rcum['Nombres'] ?></td>
                            </tr>
                            <?php
                                }
                            }else{
                            ?>
                            <tr>
                                <td><i class="fa fa-meh-o cdanger"></i></td>
                                <td>Hoy nadie cumple años</td>
                            </tr>
                            <?php
                            }
                            mysqli_free_result($ccum);
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="box box-success collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Boletines</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <tbody>
                          <?php
                            $cbol=mysqli_query($cone,"SELECT Descripcion, Adjunto FROM boletin WHERE Estado=1 AND Fecha<='$fecha' ORDER BY Fecha DESC LIMIT 12");
                            if(mysqli_num_rows($cbol)){
                                while($rbol=mysqli_fetch_assoc($cbol)){
                          ?>
                            <tr>
                                <td><i class="fa fa-newspaper-o csuccess"></i></td>
                                <td><a href="sisper/files_intranet/<?php echo $rbol['Adjunto'] ?>" target="_blank"><?php echo $rbol['Descripcion']; ?></a></td>
                            </tr>
                          <?php
                                }
                            }else{
                          ?>
                            <tr>
                                <td><i class="fa fa-newspaper-o csuccess"></i></td>
                                <td>No hay boletines</td>
                            </tr>
                          <?php
                            }
                            mysqli_free_result($cbol);
                          ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div>
                    <!-- /.box-footer -->
                  </div>
                </div>
            </div>
        </div>