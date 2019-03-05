<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mesano']) && !empty($_POST['mesano']) && isset($_POST['emp']) && !empty($_POST['emp'])){
    $emp=iseguro($cone,$_POST['emp']);
    $mesanoj=iseguro($cone,$_POST['mesano']);
    $mesano=explode("/", $mesanoj);
    if(strlen($mesano[0])==2 && strlen($mesano[1])==4){
?>
<br>
<div class="row">
  <div class="col-md-7">
    <h4><i class='fa fa-user text-gray'></i> <span class="text-orange"><?php echo nomempleado($cone,$emp); ?></span></h4>
  </div>
  <div class="col-md-3">
    <h4><i class='fa fa-calendar text-gray'></i> <span class="text-orange"><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></span></h4>
  </div>
  <div class="col-md-2">
    <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
    <button class="btn btn-sm bg-aqua" data-toggle="modal" data-target="#m_amarcacion" onclick="amarcacion(<?php echo $emp.", '".$mesano[0]."','".$mesano[1]."'"; ?>)"><i class="fa fa-plus"></i> Agregar</button>
    <?php } ?>
  </div>
</div>
<?php
  $cm=mysqli_query($cone,"SELECT * FROM marcacion WHERE idEmpleado=$emp AND DATE_FORMAT(Marcacion,'%m/%Y')='$mesanoj' ORDER BY Marcacion ASC;");
      if(mysqli_num_rows($cm)>0){
?>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>DÍA</th>
      <th>FECHA</th>
      <th>HORA</th>
      <th>RESPONSABLE</th>
      <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
      <th>ACCIÓN</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
<?php
        $n=0;
        while ($rm=mysqli_fetch_assoc($cm)) {
          $n++;
?>
    <tr>
      <td><?php echo $n; ?></td>
      <td><?php echo nombredia($rm['Marcacion']); ?></td>
      <td><?php echo date('d/m/Y', strtotime($rm['Marcacion'])); ?></td>
      <td><?php echo date('h:i:s A', strtotime($rm['Marcacion'])); ?></td>
      <td><?php echo nomvigilante($cone,$rm['idVigilante']); ?></td>
      <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
      <td>
        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#m_emarcacion" onclick="edimar(<?php echo $rm['idMarcacion'].",'".$mesano[0]."','".$mesano[1]."'"; ?>);"><i class="fa fa-pencil"></i> Editar</button>
        <button class="btn bg-red btn-xs" data-toggle="modal" data-target="#m_elmarcacion" onclick="elimar(<?php echo $rm['idMarcacion'].",'".$rm['Marcacion']."'"; ?>);"><i class="fa fa-trash"></i> Eliminar</button>
      </td>
      <?php } ?>
    </tr>
<?php
        }
?>
  </tbody>
</table>
<?php
      }else{
        echo mensajewa("No se encontraron marcaciones.");
      }
      mysqli_free_result($cm);
    }else{
      echo mensajewa("Error: El mes/año no es válido.");
    }
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>