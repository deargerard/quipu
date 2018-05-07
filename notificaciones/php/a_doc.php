<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,3)){
  if(isset($_POST['guia']) && !empty($_POST['guia'])){
    $guia=iseguro($cone,$_POST['guia']);

                      $cd=mysqli_query($cone, "SELECT idDoc, Numero, Origen, Destino, Tipo, Cargo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idGuia=$guia ORDER BY idDoc DESC;");
                      if(mysqli_num_rows($cd)>0){
                      ?>
                      <table class="table table-bordered table-hover" id="dt_gdoc">
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
                      <script>
                        $("#dt_gdoc").DataTable({
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
                        echo mensajewa("Aún no ha resgistrado ningún documento");
                      }
                      mysqli_free_result($cd);

  }
}else{
  echo mensajewa("Acceso restingido.");
}
?>