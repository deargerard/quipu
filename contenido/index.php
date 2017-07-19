        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                <?php
                $csli=mysqli_query($cone,"SELECT * FROM slider WHERE Estado=1 ORDER BY idSlider DESC");
                $nr=mysqli_num_rows($csli);
                if($nr>0){
                ?>
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                          <?php
                          for($i=0;$i<$nr;$i++){
                            if($i==0){
                          ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="active"></li>
                          <?php
                            }else{
                          ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
                          <?php
                            }
                          }
                          ?>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                          <?php
                          $j=0;
                          while($rsli=mysqli_fetch_assoc($csli)){
                            if($j==0){
                          ?>
                            <div class="item active">
                                <img src="sisper/files_intranet/<?php echo $rsli['Imagen']; ?>">
                            </div>
                          <?php
                            }else{
                          ?>
                            <div class="item">
                                <img src="sisper/files_intranet/<?php echo $rsli['Imagen']; ?>">
                            </div>
                          <?php
                            }
                            $j++;
                          }
                          ?>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                  <?php
                  }
                  ?>
                </div>
            </div>
            <div class="row news">
              <div class="col-md-12"><h2><small><i class="fa fa-angle-double-right"></i></small> Noticias</h2></div>

              <div class="col-md-7 col-sm-7 newsb">
                <?php
                  $cn1=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular, Imagen FROM noticia WHERE Estado=1 ORDER BY Fecha DESC, idNoticia DESC LIMIT 3;");
                  if(mysqli_num_rows($cn1)>0){
                ?>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <?php for ($i=0; $i < mysqli_num_rows($cn1); $i++) { ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" <?php echo $i==0 ? 'class="active"' : ""; ?>></li>
                    <?php } ?>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                  <?php
                    $nu=0;
                    while ($rn1=mysqli_fetch_assoc($cn1)) {
                      $nu++;
                  ?>
                    <div class="item <?php echo $nu==1 ? "active" : ""; ?>">
                      <img src="sisper/files_intranet/<?php echo $rn1['Imagen']; ?>" alt="<?php echo $rn1['Titular']; ?>">
                      <div class="carousel-caption">
                        <p><span class="fecnot"><i class="fa fa-calendar"></i> <?php echo fnormal($rn1['Fecha']); ?></span> | <a href="noti.php?not=<?php echo $rn1['idNoticia']; ?>"><?php echo $rn1['Titular']; ?></a></span></p>
                      </div>
                    </div>
                  <?php
                    }
                  ?>
                  </div>
                </div>
                <?php
                  }else{
                    echo mensajewa("Aún no hay noticias.");
                  }
                ?>
              </div>
              <div class="col-md-5 col-sm-5">
                <?php
                  $cn2=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular, Imagen FROM noticia WHERE Estado=1 ORDER BY Fecha DESC, idNoticia DESC LIMIT 3,3;");
                  if(mysqli_num_rows($cn2)>0){
                    while ($rn2=mysqli_fetch_assoc($cn2)) { 
                ?>
                <div class="row noti">
                  <div class="col-md-5"><img src="sisper/files_intranet/<?php echo $rn2['Imagen']; ?>" class="img-responsive"></div>
                  <div class="col-md-7"><span class="fecnot"><i class="fa fa-calendar"></i> <?php echo fnormal($rn2['Fecha']); ?></span> | <span class="notit"><a href="noti.php?not=<?php echo $rn2['idNoticia']; ?>"><?php echo $rn2['Titular']; ?></a></span></div>
                </div>
                <?php
                    }
                  }else{
                    echo mensajewa("Aún no hay muchas noticias.");
                  }
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12"><h2><small><i class="fa fa-angle-double-right"></i></small> Documentos y formatos</h2></div>
            <?php
                $ccat=mysqli_query($cone,"SELECT idCatDocumento, CatDocumento FROM catdocumento WHERE Estado=1");
                if(mysqli_num_rows($ccat)>0){
                    while($rcat=mysqli_fetch_assoc($ccat)){
                        $idcd=$rcat['idCatDocumento'];
            ?>
                <div class="col-md-6 col-sm-6">
                  <div class="box box-info collapsed-box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?php echo $rcat['CatDocumento'] ?></h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="table-responsive pscroll">
                        <table class="table no-margin">
                          <tbody>
                          <?php
                            $cdoc=mysqli_query($cone,"SELECT idDocumento, Descripcion, Adjunto FROM documento WHERE idCatDocumento=$idcd AND Estado=1 ORDER BY Descripcion ASC");
                            if(mysqli_num_rows($cdoc)>0){
                                while ($rdoc=mysqli_fetch_assoc($cdoc)) {                             
                          ?>
                          <tr>
                            <td><i class="fa fa-file-text-o cinfo"></i></td>
                            <td><a href="sisper/files_intranet/<?php echo $rdoc['Adjunto']; ?>" target="_blank"><?php echo $rdoc['Descripcion'] ?></a></td>
                          </tr>
                          <?php
                                }
                            }else{
                          ?>
                          <tr>
                            <td><i class="fa fa-file-text-o cinfo"></i></td>
                            <td>No hay documentos</td>
                          </tr>
                          <?php
                            }
                            mysqli_free_result($cdoc);
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
            <?php
                    }
                }
                mysqli_free_result($ccat);
            ?>
            </div>
        </div>