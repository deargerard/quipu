<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
  if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_rephijos"){
    if(isset($_POST['pers']) && !empty($_POST['pers'])){
      $pers=iseguro($cone,$_POST['pers']);

?>
  <h4 class="text-maroon"><strong><?php echo nomempleado($cone,$pers); ?></strong><small> (<?php echo cargoe($cone,$pers) ?>)</small></h4>
<?php
  $c=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, Sexo, FechaNac, NumeroDoc, TelefonoFij, TelefonoMov, ContactoEme, TipoPariente FROM pariente p INNER JOIN tipopariente tp ON p.idTipoPariente=tp.idTipoPariente WHERE idEmpleado=$pers ORDER BY TipoPariente, ApellidoPat, ApellidoMat, Nombres ASC;");
?>
    <table class="table table-bordered table-hover">
<?php
    if(mysqli_num_rows($c)>0){

      echo '<tr>
        <th>#</th>
        <th>T. PARIENTE</th>
        <th>NOMBRE</th>
        <th>SEXO</th>
        <th>DNI</th>
        <th>EDAD</th>
        <th>C. EMERG.</th>
        <th>TELÉFONO</th>
      </tr>';

      $n=0;
      while($r=mysqli_fetch_assoc($c)){
        $n++;
        $f1=date("Y-m-d");
        $f2=$r['FechaNac'];
        $f1=date_create($f1);
        $f2=date_create($f2);
        $tie=date_diff($f1, $f2);
?>
      <tr>
        <td><?php echo $n; ?></td>
        <td><?php echo $r['TipoPariente']; ?></td>
        <td><?php echo $r['ApellidoPat']." ".$r['ApellidoMat'].", ".$r['Nombres']; ?></td>
        <td><?php echo $r['Sexo']; ?></td>
        <td><?php echo $r['NumeroDoc']; ?></td>
        <td><?php echo $tie->format('%y año(s), %m mes(es)'); ?></td>
        <td><?php echo $r['ContactoEme']==1 ? "<span class='label label-success'>Sí</span>" : "<span class='label label-default'>No</span>"; ?></td>
        <td><?php echo $r['TelefonoFij']." ".$r['TelefonoMov']; ?></td>
      </tr>
<?php
      }
    }else{
?>
      <tr>
        <td>No tiene parientes registrados</td>
      </tr>
<?php
    }
    mysqli_free_result($c);
?>
    </table>
<?php
    }else{
      echo mensajewa("no se enviaron datos.");
    }
  }else{
    echo mensajeda("No es el formulario.");
  }
}else{
  echo accrestringidoa();
}
?>