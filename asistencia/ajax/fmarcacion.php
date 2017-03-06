<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
    if(isset($_POST['idm']) && !empty($_POST['idm'])){
        $idm=iseguro($cone,$_POST['idm']);
        $c=mysqli_query($cone,"SELECT * FROM tipmarcacion WHERE idTipMarcacion=$idm");
        if($r=mysqli_fetch_assoc($c)){
?>        

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
                                            <label for="cod">Código</label>
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