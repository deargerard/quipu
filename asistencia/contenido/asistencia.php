        <!-- Page Content -->
        <div id="page-wrapper" class="contenido">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Asistencia</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row" id="ccontenido">
                    <div class="col-lg-12">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Tipo
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
								<div class="row">
									<?php
									$q=mysqli_query($cone,"SELECT * FROM tipmarcacion");
									while($r=mysqli_fetch_assoc($q)){
									?>
									<div class="col-sm-6">
										<br>
										<a href="marcacion.php?idm=<?php echo $r['idTipMarcacion']; ?>" class="btn btn-success btn-lg btn-block"><i class="fa fa-calendar-o"></i> <?php echo $r['TipMarcacion']; ?></a>
										<br>
									</div>
									<?php
									}
									?>
								</div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->