<?php
session_start();
include ("conec.php");
function iseguro($conex,$val)
{
    $input = htmlentities($val);
    $seguro = trim(mysqli_real_escape_string ($conex,$input));
    return $seguro;
}


?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ministerio Público - Sorteos</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top">Feliz día Papá <small>(Sorteo)</small></a>
                <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="salir.php">Salir</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Portfolio Section-->
        <section class="prin page-section portfolio" id="portfolio">
            <div class="container">
                <!-- Portfolio Grid Items-->
                <div class="row justify-content-center">
                    <!-- Portfolio Item 1-->
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="card mb-3">
                            <div class="card-header text-secondary">
                                BIENVENIDO
                            </div>
                            <div class="card-body">
                                <?php
                                if(isset($_POST["dni"]) && !empty($_POST['dni'])){
                                    $dni=iseguro($con, $_POST["dni"]);
                                    $cp=mysqli_query($con, "SELECT * FROM participantes WHERE dni='$dni';");
                                    if($rp=mysqli_fetch_assoc($cp)){
                                        if(is_null($rp['inscrito'])){
                                            mysqli_query($con,"UPDATE participantes SET inscrito=1 WHERE dni='$dni';");
                                        }
                                        $_SESSION['nombre']=$rp['nombre'];
                                        $_SESSION['id']=$rp['id'];
                                    }else{
                                        echo "<br><span class='text-danger'>DNI no registrado, por favor solicite su registro al 961627980. Gracias</span>";
                                    }
                                }

                                if(isset($_SESSION['nombre'])){
                                ?>
                                <h3 class="text-info"><i class="fas fa-user-tie text-muted"></i> <?php echo $_SESSION['nombre']; ?></h3>
                                <button class="btn btn-sm btn-primary" type="button" onclick="document.location.reload();">Actualizar</button>
                                <?php
                                }else{
                                ?>
                                <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST">
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="dni" name="dni" type="text" placeholder="Ingrese su DNI" data-sb-validations="required" />
                                        <label for="name">DNI</label>
                                    </div>

                                    <button class="btn btn-primary" id="submitButton" type="submit">Registrarse e ingresar</button>
                                </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <img src="assets/img/FelizDiaPapap.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <!-- Portfolio Item 1-->
                    <div class="col-md-6 col-lg-4 mb-2">
                        <?php
                        if(isset($_SESSION['id']) && $_SESSION['id']==115){
                        ?>
                        <div class="card mb-3">
                            <div class="card-header text-secondary">
                                SORTEO
                            </div>
                            <div class="card-body text-center">
                                <button class="btn btn-primary" id="b_sortear" type="button" onclick="sortear();">Sortear</button>
                                <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST" autocomplete="off">
                                    <div id="d_sorteo">
                                    </div> 
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="premio" name="premio" type="text" placeholder="Ingrese su DNI" required />
                                        <label for="name">Premio</label>
                                    </div>

                                    <button class="btn btn-primary" id="submitButton" type="submit">Registrar ganador</button>
                                    <?php
                                    if(isset($_POST["id"]) && !empty($_POST['id']) && isset($_POST["premio"]) && !empty($_POST['premio'])){
                                        $id=iseguro($con, $_POST["id"]);
                                        $premio=iseguro($con, $_POST["premio"]);
                                        $c=mysqli_query($con, "SELECT * FROM participantes WHERE id=$id AND gano=1;");
                                        if(mysqli_num_rows($c)>0){
                                            echo "<br><span class='text-danger'> Ya tiene premio.</span>";
                                        }else{
                                            mysqli_query($con, "UPDATE participantes SET gano=1 WHERE id=$id;");
                                            mysqli_query($con, "INSERT INTO ganadores (premio, participante_id) VALUES ('$premio', $id);");
                                            echo "<br><span class='text-success'> Premio registrado.</span>";
                                        }
                                    }
                                    ?>
                                </form>
                                
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="card mb-3">
                            <div class="card-header text-secondary">
                                PAPÁS SUERTUDOS
                            </div>
                            <div class="card-body">
                            <?php
                            $cg=mysqli_query($con, "SELECT p.nombre, g.premio FROM participantes p INNER JOIN ganadores g ON p.id=g.participante_id WHERE p.gano=1 ORDER BY g.id DESC;");
                            if(mysqli_num_rows($cg)>0){
                                while($rg=mysqli_fetch_assoc($cg)){
                            ?>
                                <span class="text-muted"><i class="fas fa-child text-info"></i> <?php echo $rg['nombre']; ?></span><br><small class="text-muted"><i class="fas fa-gift text-warning"></i> <?php echo $rg['premio'] ?></small><br>
                            <?php
                                }
                            }else{
                            ?>
                                <h6 class="text-warning">Aún no tenemos suertudos</h6>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    <!-- Portfolio Item 1-->
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="card">
                            <div class="card-header text-secondary">
                                PAPÁS REGISTRADOS
                            </div>
                            <div class="card-body">
                                <?php
                                $cpa=mysqli_query($con, "SELECT * FROM participantes WHERE inscrito=1 ORDER BY nombre ASC;");
                                if(mysqli_num_rows($cpa)>0){
                                    while($rpa=mysqli_fetch_assoc($cpa)){
                                ?>
                                <span class="text-muted"><i class="fas fa-user-tie text-info"></i> <?php echo $rpa['nombre']; ?></span><br>
                                <?php
                                    }
                                }else{
                                ?>
                                <h6 class="text-info">Aún nadie se registra</h6>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Ministerio Público - Área de Informática - 2021</small></div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script src="js/jquery-3.6.0.min.js"></script>
        <?php
            if(isset($_SESSION['id']) && $_SESSION['id']==115){
        ?>
        <script>
            function sortear(){
                $.ajax({
                    type: "post",
                    url: "sortear.php",
                    beforeSend: function () {
                        $("#d_sorteo").html("Sorteando...");
                        $("#b_sortear").hide();
                    },
                    success:function(a){
                        $("#b_sortear").show();
                        $("#d_sorteo").html(a);
                    }
                });
            };
        </script>
        <?php
            }
        ?>

    </body>
</html>
