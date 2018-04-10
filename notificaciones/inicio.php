<?php
session_start();
include 'php/cone.php';
include 'php/func.php';
include 'const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  $tit="Inicio"
?>
<!DOCTYPE html>
<html>
  <?php
  include('estructura/head.php');
  ?>
  <body>
    <div class="page">
      <?php
      include('estructura/header.php');
      ?>
      <div class="page-content d-flex align-items-stretch"> 
        <?php
        include('estructura/nav.php');
        ?>
        <div class="content-inner">
          <?php
          include('estructura/breadcrumb.php');
          ?>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="card-header d-flex align-items-center">           
                <h2 class="h3">TOTAL HOY (<?php echo (date('d/m/Y')); ?>)</h2>
              </div>
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE Estado=1;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-violet"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Pendientes</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE DATE_FORMAT(FecNotificacion,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m') AND Estado=2;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-red"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Notificados</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE DATE_FORMAT(FecNotificacion,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m') AND Estado=3;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-green"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Devueltos</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE Estado=4;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-orange"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Reabiertos</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="card-header d-flex align-items-center">           
                <h2 class="h3">YO HOY (<?php echo (date('d/m/Y')); ?>)</h2>
              </div>
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE Estado=1 AND idResponsable=$idusu;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-violet"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Pendientes</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE DATE_FORMAT(FecNotificacion,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m') AND Estado=2 AND idResponsable=$idusu;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-red"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Notificados</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE DATE_FORMAT(FecNotificacion,'%Y-%m')=DATE_FORMAT(NOW(),'%Y-%m') AND Estado=3 AND idResponsable=$idusu;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-green"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Devueltos</span>
                    </div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <?php
                    $num=0;
                    $cd=mysqli_query($cone,"SELECT COUNT(idDocumento) as num FROM documento WHERE Estado=4 AND idResponsable=$idusu;");
                    if($rd=mysqli_fetch_assoc($cd)){
                      $num=$rd['num'];
                    }
                    mysqli_free_result($cd);
                    ?>
                    <div class="number"><strong><?php echo $num; ?></strong></div>
                    <div class="icon bg-orange"><i class="fa fa-file-text-o"></i></div>
                    <div class="title">
                      <span>Doc.<br>Reabiertos</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <br>
          <?php
          include('estructura/footer.php');
          ?>
        </div>
      </div>
    </div>
    <?php
    include('estructura/js.php');
    ?>
  </body>
</html>
<?php
  mysqli_close($cone);
}else{
  header('Location:'.URL);
}
?>