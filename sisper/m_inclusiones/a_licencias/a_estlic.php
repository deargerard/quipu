<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $c=mysqli_query($cone,"SELECT FechaIni, FechaFin, TipoLic, MotivoLic, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idLicencia=$id;");
    if($r=mysqli_fetch_assoc($c)){
      $e=$r['Estado'];
?>
     <div class="row">
       <div class="col-sm-12 text-center">
        <h5>¿Seguro que deseas <?php echo $e==1 ? "<strong>cancelar</strong>" : "<strong>activar</strong>"; ?> la siguiente licencia?</h5>
         <h4 class="text-maroon"><strong><?php echo $r['MotivoLic']; ?></strong><small> (<?php echo $r['TipoLic']; ?>)</small></h4>
         <span><?php echo "Del ".fnormal($r['FechaIni'])." al ".fnormal($r['FechaFin']); ?></span>
         <input type="hidden" name="idl" id="idl" value="<?php echo $id; ?>">
       </div>
     </div>   
<?php
    }else{
      echo mensajewa("Error: No se enviaron datos válidos.");
    }
    mysqli_free_result($c);
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>
