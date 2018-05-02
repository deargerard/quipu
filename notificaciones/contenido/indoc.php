<?php
if(acceso($cone,$idusu,3)){
  if(isset($_GET['guia']) && !empty($_GET['guia'])){
    $guia=iseguro($cone,$_GET['guia']);
    $cg=mysqli_query($cone, "SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino WHERE idGuia=$guia");
    if($rg=mysqli_fetch_assoc($cg)){
?>
          <!-- Forms Section-->
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                <!-- Formulario Documento-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4 text-primary">Guía: <?php echo $rg['Numero']."-".date('Y',strtotime($rg['Fecha'])); ?> Destino: <?php echo $rg['Destino']; ?></h3>
                    </div>
                    <div class="card-body" id="f_guia">        

                      <form id="f_indoc">
                        <div class="form-group row">
                          <div class="col-3">
                            <select class="form-control" id="tip" name="tip">
                              <option value="">TIPO</option>
                              <?php
                              $ctd=mysqli_query($cone,"SELECT * FROM tipodoc WHERE Estado=1 ORDER BY Tipo ASC;");
                              if(mysqli_num_rows($ctd)>0){
                                while ($rtd=mysqli_fetch_assoc($ctd)) {
                              ?>
                              <option value="<?php echo $rtd['idTipoDoc']; ?>"><?php echo $rtd['Tipo']; ?></option>
                              <?php
                                }
                              }
                              mysqli_free_result($ctd);
                              ?>
                            </select>
                          </div>
                          <div class="col-3">
                            <input type="hidden" name="guia" id="guia" value="<?php echo $guia; ?>">
                            <input class="form-control" type="text" id="num" name="num" placeholder="Número">
                          </div>
                          <div class="col-3">
                            <input class="form-control" type="text" id="ori" name="ori" placeholder="Origen">
                          </div>
                          <div class="col-3">
                            <input class="form-control" type="text" id="rem" name="rem" placeholder="Remitente">
                          </div>
                          <div class="col-3">
                            <input class="form-control" type="text" id="des" name="des" placeholder="Destino">
                          </div>
                          <div class="col-3">
                            <input class="form-control" type="text" id="dest" name="dest" placeholder="Destinatario">
                          </div>
                          <div class="col-3">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="dcar" name="dcar" value="si"> Devolución cargo
                              </label>
                            </div>
                          </div>
                          <div class="col-3">
                            <button type="button" class="btn btn-primary btn-sm" id="b_indoc">Ingresar</button>
                            <a href="php/e_guia.php?guia=<?php echo $guia; ?>" class="btn btn-secondary btn-sm" title="Exportar excel"> <i class="fa fa-file-excel-o"></i> </a>
                            <a href="php/e_guiapdf.php?guia=<?php echo $guia; ?>" class="btn btn-secondary btn-sm" title="Exportar pdf" target="_blank"> <i class="fa fa-file-pdf-o"></i> </a>
                            <a href="reguia.php" class="btn btn-secondary btn-sm" title="Regresar a guías"><i class="fa fa-chevron-circle-left"></i></a>
                          </div>
                        </div>
                      </form>
                      <div id="r_indoc">
                              
                      </div>

                    </div>
                  </div>
                </div>
                <!-- Resultado documentos registrados-->
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Documentos</h3>
                    </div>
                    <div class="card-body" id="d_doc">
            
                      <?php
                      $cd=mysqli_query($cone, "SELECT idDoc, Numero, Origen, Destino, Tipo, Cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idGuia=$guia ORDER BY idDoc DESC;");
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Tipo</th>
                            <th>Número</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Dev. Cargo</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>

                      <?php
                        $n=0;
                        while($rd=mysqli_fetch_assoc($cd)){
                          $n++;
                      ?>
                          <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $rd['Tipo']; ?></td>
                            <td><?php echo $rd['Numero']; ?></td>
                            <td><?php echo $rd['Origen']; ?></td>
                            <td><?php echo $rd['Destino']; ?></td>
                            <td><?php echo $rd['Cargo']==1 ? "Si" : "No"; ?></td>
                            <td>

                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eddoc" onclick="eddoc(<?php echo $rd['idDoc']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_dedoc" onclick="dedoc(<?php echo $rd['idDoc']; ?>)" title="Detalle"><i class="fa fa-info-circle"></i></button>
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_eldoc" onclick="eldoc(<?php echo $rd['idDoc']; ?>)" title="Eliminar"><i class="fa fa-trash"></i></button>
                              </div>

                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
                      <?php
                      }else{
                        echo mensajewa("Aún no ha resgistrado ningún documento");
                      }
                      mysqli_free_result($cd);
                      ?>


                    </div>
                  </div>
                </div>

              </div>
            </div>
          </section>


<?php
    }else{
      echo mensajewa("Datos incorrectos");
    }
  }else{
    echo mensajewa("No envio datos");
  }
}else{
 echo mensajewa("Acceso restringido");
}
?>