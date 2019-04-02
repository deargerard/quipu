<?php
  include ("../sisper/m_inclusiones/php/conexion_sp.php");
  include ("../sisper/m_inclusiones/php/funciones.php");
  $id=iseguro($cone,$_POST['idn']);
  $cnot=mysqli_query($cone, "SELECT * FROM noticia WHERE idNoticia=$id;");
  if($rnot=mysqli_fetch_assoc($cnot)){
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


        <table class="table text-left">
          <thead>
            <tr>
              <th>
                <span class="text-info" style="font-size: 18px;"><?php echo $rnot['Titular']; ?></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <small class="text-muted"><i class="fa fa-calendar text-primary"></i> <?php echo data_text(fnormal($rnot['Fecha'])); ?></small>
                <img src="sisper/files_intranet/<?php echo $rnot['Imagen']; ?>" alt="<?php echo $rnot['Titular']; ?>" class="img-fluid">
                <?php echo html_entity_decode($rnot['Cuerpo']); ?>
              </td>
            </tr>
          </tbody>
          </table>
          <table class="table table-sm">
          <thead>
            <tr>
              <th style="text-align: left;">
                <span class="text-info" style="font-size: 15px;">Más noticias</span>
              </th>
            </tr>
          </thead>
          <tbody>

            <?php
              $cn=mysqli_query($cone,"SELECT idNoticia, Fecha, Titular FROM noticia WHERE Estado=1 AND idNoticia!=$id ORDER BY Fecha DESC, idNoticia DESC LIMIT 5;");
              if(mysqli_num_rows($cn)>0){
                while ($rn=mysqli_fetch_assoc($cn)) { 
            ?>
            <tr>
              <td style="text-align: left;">
                <span style="font-size: 12px; line-height: normal;" class="text-muted"><i class="fa fa-calendar text-info"></i> <?php echo fnormal($rn['Fecha']); ?> | <a href="#" onclick="noticia(<?php echo $rn['idNoticia']; ?>);"><?php echo $rn['Titular']; ?></a></span>
              </td>
            </tr>         
            <?php
                }
              }
            ?>
          </tbody>
        </table>
  <button class="btn btn-primary" data-dismiss="modal" type="button">
  <i class="fas fa-times"></i>
  Cerrar</button>

</div>
<?php
  }else{
    echo mensajeda("Error");
  }
?>