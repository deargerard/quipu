<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,3)){

                      $cd=mysqli_query($cone, "SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino ORDER BY idGuia DESC LIMIT 400;");
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover" id="dt_guia">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Guía</th>
                            <th>Destino</th>
                            <th>Fecha</th>
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
                            <td><?php echo $rd['Numero']."-".date("Y", strtotime($rd['Fecha'])); ?></td>
                            <td><?php echo $rd['Destino']; ?></td>
                            <td><?php echo fnormal($rd['Fecha']); ?></td>
                            <td>

                              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_edguia" onclick="edguia(<?php echo $rd['idGuia']; ?>)" title="Editar"><i class="fa fa-edit"></i></button>
                                <a href="indoc.php?guia=<?php echo $rd["idGuia"]; ?>" class="btn btn-secondary" title="Ver/Ingresar documentos"><i class="fa fa-chevron-circle-right"></i></a>
                              </div>

                            </td>
                          </tr>
                      <?php
                        }
                      ?>
                        </tbody>
                      </table>
                      <script>
                        $("#dt_guia").DataTable({
                          dom: 'Bfrtip',
                          buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fa fa-copy"></i>',
                                titleAttr: 'Copiar'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fa fa-file-text-o"></i>',
                                titleAttr: 'CSV'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fa fa-file-excel-o"></i>',
                                titleAttr: 'Excel'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fa fa-file-pdf-o"></i>',
                                titleAttr: 'PDF'
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i>',
                                titleAttr: 'Imprimir'
                            }
                          ]
                        });
                      </script>
                      <?php
                      }else{
                        echo mensajewa("Aún no ha resgistrado ninguna guía");
                      }
                      mysqli_free_result($cd);
}else{
  echo mensajewa("Acceso restingido.");
}
?>