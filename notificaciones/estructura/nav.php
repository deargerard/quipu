        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h5"><?php echo $_SESSION['nusu']; ?></h1>
            </div>
          </div>
          <!-- Sidebar Navidation Menus--><span class="heading">Menu</span>
          <ul class="list-unstyled">
                    <li id="documentop"><a href="#documentoh" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file-text"></i>Documento </a>
                      <ul id="documentoh" class="collapse list-unstyled ">
                      <?php if(acceso($cone, $idusu, 1)){ ?>
                        <li id="regasi"><a href="registrar.php">Registrar/Asignar</a></li>
                      <?php } ?>
                      <?php if(acceso($cone, $idusu, 2)){ ?>
                        <li id="reportar"><a href="reportar.php">Reportar</a></li>
                      <?php } ?>
                        <li id="reportes"><a href="reportes.php">Consultas</a></li>
                      </ul>
                    </li>
                    <?php if(acceso($cone, $idusu, 3)){ ?>
                    <li id="guiap"><a href="#guiah" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-archive"></i>Guía </a>
                      <ul id="guiah" class="collapse list-unstyled ">
                        <li id="reguia"><a href="reguia.php">Generar/Ingresar</a></li>
                        <li id="consultas"><a href="consultas.php">Consultas</a></li>
                      </ul>
                    </li>
                    <?php } ?>
          </ul>
          </ul><span class="heading">Extras</span>
          <ul class="list-unstyled">
            <li id="contrasena"> <a href="contrasena.php"> <i class="fa fa-lock"></i>Contraseña </a></li>
          </ul>
        </nav>