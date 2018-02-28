<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if(isset($_POST['idcs']) && !empty($_POST['idcs'])){
    $idcs=iseguro($cone,$_POST['idcs']);
    ?>
      <table class="table table-bordered">
      <?php
        $cen=mysqli_query($cone, "SELECT * FROM encargatura where idComServicios=$idcs;");
        if(mysqli_num_rows($cen)>0){
      ?>
      <tr>
        <th><span class="text-<?php echo $color;?>">Encargado</span></th>
        <th><span class="text-<?php echo $color;?>">Inicio</span></th>
        <th><span class="text-<?php echo $color;?>">Fin </span></th>
        <th><span class="text-<?php echo $color;?>">Tipo </span></th>
      </tr>
      <?php
          while ($ren=mysqli_fetch_assoc($cen)){
            if ($ren['Tipo']==1) {
              $t="Des/Coor";
            }elseif ($ren['Tipo']==2) {
              $t="Coordinación";
            }elseif ($ren['Tipo']==3) {
              $t="Despacho";
            }
      ?>
            <tr>
              <td><?php echo nomempleado($cone,$ren['idEmpleado']);?></th>
              <td><?php echo date('d/m/Y H:i', strtotime($ren['Inicio'])); ?></th>
              <td><?php echo date('d/m/Y H:i', strtotime($ren['Fin'])); ?></th>
              <td><?php echo $t ?></th>
            </tr>
        <?php
          }
        }else {
          ?>
          <tr>
            <td> <?php echo mensajewa("No se han registrado encargaturas")?></td>
          </tr>
          <?php
        }
         ?>
      </table>
    <?php
        mysqli_close($cone);
    }else{
      echo mensajewa("Error: No se selecciono ninguna comisión.");
  }
}else{
  echo accrestringidoa();
}
?>
