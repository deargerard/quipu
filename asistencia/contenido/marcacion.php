<?php
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
    if(isset($_GET['idm']) && !empty($_GET['idm'])){
        $idm=iseguro($cone,$_GET['idm']);
        $c=mysqli_query($cone,"SELECT * FROM tipmarcacion WHERE idTipMarcacion=$idm");
        if($r=mysqli_fetch_assoc($c)){
?>        
        <!-- Page Content -->
        <div id="page-wrapper" class="contenido">
            <div class="container-fluid" id="contenido">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $r['TipMarcacion']; ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-lg-4">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Marcación
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                    <form role="form" id="fmarcacion">
                                        <div class="form-group">
                                            <label for="cod"><i class="fa fa-barcode"></i> Código</label>
                                            <input type="hidden" name="idm" value="<?php echo $idm; ?>">
                                            <input type="password" id="cod" name="cod" class="form-control" autofocus>
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
                                        </div>
                                        <button type="submit" class="btn btn-default" id="bmarcacion">Registrar</button>
                                    </form>

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>

                    <div class="col-lg-4">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Resultado
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body" id="resultado">
                                <h1 class="text-center text-danger">Aún nadie ha marcado.</h1>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>

                    <div class="col-lg-4">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Reloj
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <br>
                                <h1 class="text-primary text-center" id="reloj"></h1>
                                <br>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                    </div>
                    <div class="col-lg-12">
                        <a href="asistencia.php" class="btn btn-info"><i class="fa fa-arrow-circle-left"></i> Regresar</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

<?php
        }else{
            echo mensajeda("Error: Dato erroneo.");
        }
        mysqli_free_result($c);
    }else{
        echo mensajeda("Error: No se envio datos.");
    }
}else{
    header('Location: index.html');
}
?>