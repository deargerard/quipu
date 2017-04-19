<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ubipersonal"){
    if(isset($_POST['dis']) && !empty($_POST['dis']) && isset($_POST['carg']) && !empty($_POST['carg'])){
      $dis=iseguro($cone,$_POST['dis']);
      $carg=iseguro($cone,$_POST['carg']);
      $pca=$carg=="t" ? "" : "AND ec.idCargo=".$carg;
      $pco=$dis=="t" ? "" : "AND d.idDistrito=".$dis;
      $cdi=mysqli_query($cone,"SELECT DISTINCT d.idDistrito, NombreDis, NombrePro FROM local l INNER JOIN distrito d ON l.idDistrito=d.idDistrito INNER JOIN provincia p ON d.idProvincia=p.idProvincia WHERE l.Estado=1 $pco ORDER BY NombrePro, NombreDis ASC;");
      if(mysqli_num_rows($cdi)>0){
        $tt=0;
        while($rdi=mysqli_fetch_assoc($cdi)){
          $iddi=$rdi['idDistrito'];
?>
        <table id="dtpersonal" class="table table-bordered table-hover">     
<?php
      $c=mysqli_query($cone, "SELECT DISTINCT d.idDependencia, Denominacion FROM local l INNER JOIN dependencialocal dl ON l.idLocal=dl.idLocal INNER JOIN dependencia d ON dl.idDependencia=d.idDependencia WHERE l.idDistrito=$iddi ORDER BY Denominacion DESC;");
?>
          <tr>
            <th colspan="3"><h4 class="text-maroon"><strong><?php echo $rdi['NombreDis']." - ".$rdi['NombrePro']; ?></strong></h4></th>
          </tr>
<?php
      if(mysqli_num_rows($c)>0){
?>
        <?php
        $s=0;
        while ($r=mysqli_fetch_assoc($c)) {
          $idde=$r['idDependencia'];
        ?>
          <tr>
            <th>DEPENDENCIA</th>
            <th class="text-aqua" colspan="2"><?php echo $r['Denominacion']; ?></th>
          </tr>
        <?php
          $cl=mysqli_query($cone,"SELECT DISTINCT Direccion, Telefono FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE idDependencia=$idde;");
          if(mysqli_num_rows($cl)>0){
            $l=0;
            while ($rl=mysqli_fetch_assoc($cl)) {
              $l++;
        ?>
          <tr>
            <th>LOCAL <?php echo $l; ?></th>
            <td class="text-primary" colspan="2"><?php echo $rl['Direccion']." | ".$rl['Telefono']; ?></td>
          </tr>
        <?php
            }
          }
          $cp=mysqli_query($cone,"SELECT e.idEmpleado, ApellidoPat, ApellidoMat, Nombres FROM cardependencia cd INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN empleado e ON ec.idEmpleado=e.idEmpleado INNER JOIN cargo c ON ec.idCargo=c.idCargo WHERE cd.idDependencia=$idde AND cd.Estado=1 AND ec.idEstadoCar=1 $pca ORDER BY c.Orden, ApellidoPat, ApellidoMat ASC;");
          if(mysqli_num_rows($cp)>0){
        ?>
          <tr>
            <th>#</th>
            <th>NOMBRE</th>
            <th>CARGO</th>
          </tr>
        <?php
            $n=0;
            while($rp=mysqli_fetch_assoc($cp)){
              $n++;
        ?>
          <tr>
            <td><?php echo $n; ?></td>
            <td><?php echo $rp['ApellidoPat']." ".$rp['ApellidoMat'].", ".$rp['Nombres']; ?></td>
            <td><?php echo cargoe($cone,$rp['idEmpleado']); ?></td>
          </tr>
        <?php
            }
          }else{
            $n=0;
        ?>
          <tr>
            <td colspan="3">Sin personal según el criterio de búsqueda.</td>
          </tr>
        <?php
          }
          $s=$s+$n;
        }
        ?>
          <tr>
            <th>TOTAL</th>
            <td colspan="2" class="text-orange"><?php echo $s; ?> Servidores públicos</td>
          </tr>

<?php
      }else{
        $s=0;
?>
          <tr>
            <td colspan="3">No se encontraron datos</td>
          </tr>
<?php
      }
?>
        </table>
<?php
          $tt=$tt+$s;
        }
?>
        <table class="table table-bordered table-hover">
          <tr>
            <th class="text-orange"><h4><strong><?php echo $tt; ?> SERVIDORES PÚBLICOS EN TOTAL</strong></h4></th>
          </tr>
        </table>
<?php
      }
    }else{
      echo "no se enviaron datos";
    }
  }else{
    echo "No es el formulario";
  }
}else{
  echo accrestringidoa();
}
?>