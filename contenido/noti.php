        <?php
          $id=iseguro($cone,$_GET['not']);
          $cnot=mysqli_query($cone, "SELECT * FROM noticia WHERE idNoticia=$id;");
          if($rnot=mysqli_fetch_assoc($cnot)){
        ?>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="row news">
              <div class="col-md-12">

              </div>

              <div class="col-md-3 col-sm-3">
                <h2>Últimas</h2>
                <?php
                  $cn=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular FROM noticia WHERE Estado=1 AND idNoticia!=$id ORDER BY Fecha DESC, idNoticia DESC LIMIT 8;");
                  if(mysqli_num_rows($cn)>0){
                    while ($rn=mysqli_fetch_assoc($cn)) { 
                ?>
                <div class="row noti">
                  <div class="col-md-12"><span class="fecnot"><i class="fa fa-calendar"></i> <?php echo fnormal($rn['Fecha']); ?></span> | <span class="notit"><a href="noti.php?not=<?php echo $rn['idNoticia']; ?>"><?php echo $rn['Titular']; ?></a></span></div>
                </div>
                <?php
                    }
                  }
                ?>
              </div>

              <div class="col-md-9 col-sm-9 newsb">

                <h3><?php echo $rnot['Titular']; ?></h3>
                <p class="text-primary"><i class="fa fa-calendar"></i> <?php echo data_text(fnormal($rnot['Fecha'])); ?></p>
                <img src="sisper/files_intranet/<?php echo $rnot['Imagen']; ?>" alt="<?php echo $rnot['Titular']; ?>" class="img-responsive">
                <br>
                <?php echo html_entity_decode($rnot['Cuerpo']); ?>
                <br>

              </div>

            </div>
        </div>
        <?php
          }else{
            echo mensajeda("Error");
          }
        ?>