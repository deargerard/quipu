          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"><?php echo $tit; ?></h2>
            </div>
          </header>
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
              <?php if($tit!="Inicio"){ ?>
              <li class="breadcrumb-item active"><?php echo $tit; ?></li>
              <?php } ?>
            </ul>
          </div>