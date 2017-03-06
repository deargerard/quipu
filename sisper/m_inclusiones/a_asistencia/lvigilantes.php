<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){

                        $cv=mysqli_query($cone,"SELECT * FROM vigilante ORDER BY idVigilante DESC LIMIT 10");
                        if(mysqli_num_rows($cv)>0){
                      ?>
                      <h3 class="text-maroon">Últimos 10 vigilantes registrados.</h3>
                      <table class="table" id="dtvigilante">
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
                            if($rv['UltIngreso']=="0000-00-00 00:00:00"){
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
                                <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-cog"></i>&nbsp;
                                  <span class="caret"></span>
                                  <span class="sr-only">Desplegar menú</span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                  <li><a href="#" onclick="edivig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_evigilante">Editar</a></li>
                                  <li><a href="#" onclick="convig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_ccontrasena">Cambiar contraseña</a></li>
                                  <?php if($rv['Estado']==1){ ?>
                                  <li><a href="#" onclick="desvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_dvigilante">Desactivar</a></li>
                                  <?php }else{ ?>
                                  <li><a href="#" onclick="actvig(<?php echo $rv['idVigilante']; ?>)" data-toggle="modal" data-target="#m_avigilante">Activar</a></li>
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
                        }else{
                          mensajeda("Error: No existen vigilantes registrados.");
                        }

}else{
  echo accrestringidoa();
}
?>