<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['vig']) && !empty($_POST['vig'])){
    $vig=iseguro($cone,trim($_POST['vig']));
    if(strlen($vig)>=3){
                        $cv=mysqli_query($cone,"SELECT * FROM vigilante WHERE CONCAT(TRIM(Apellidos),', ',TRIM(Nombres)) LIKE '%$vig%' ORDER BY Apellidos, Nombres ASC;");
                        $nr=mysqli_num_rows($cv);
                        if($nr>0){
                      ?>
                      <br>
                      <h4><i class="fa fa-user-secret text-gray"></i> <span class="text-orange">Resultados de la busqueda</span></h4>
                      <table class="table table-bordered table-hover" id="tvigilantes">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>DNI</th>
                            <th>ULT. INGRESO</th>
                            <th>ESTADO</th>
                            <th>ACCIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                      <?php
                          $p=0;
                          while($rv=mysqli_fetch_assoc($cv)){
                            $p++;
                            if(is_null($rv['UltIngreso'])){
                              $ui="Aún no ingresa";
                            }else{
                              $date = date_create($rv['UltIngreso']);
                              $ui=date_format($date, 'd/m/Y H:i:s');
                            }
                      ?>
                          <tr>
                            <td><?php echo $p; ?></td>
                            <td><?php echo $rv['Apellidos'].', '.$rv['Nombres']; ?></td>
                            <td><?php echo $rv['DNI']; ?></td>
                            <td><?php echo $ui; ?></td>
                            <td><?php echo estado($rv['Estado']); ?></td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="#" onclick="edivig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_evigilante"><i class="fa fa-pencil"></i> Editar</a></li>
                                  <li><a href="#" onclick="convig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_ccontrasena"><i class="fa fa-lock"></i> Cambiar contraseña</a></li>
                                  <?php if($rv['Estado']==1){ ?>
                                  <li><a href="#" onclick="estvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_estvigilante"><i class="fa fa-toggle-on"></i> Desactivar</a></li>
                                  <?php }else{ ?>
                                  <li><a href="#" onclick="estvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_estvigilante"><i class="fa fa-toggle-on"></i> Activar</a></li>
                                  <?php } ?>
                                </ul>
                              </div>
                            </td>
                          </tr>
                      <?php
                          }
                      ?>
                        </tbody>
                      </table>
                      <?php
                      if($nr>10){
                      ?>
<script>
  $("#tvigilantes").DataTable();
</script>
                      <?php
                      }
                        }else{
                          echo mensajewa("No se encontraron resultados.");
                        }
                      
      }else{
        echo mensajewa("Ingrese 4 caracteres como mínimo.");
      }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>