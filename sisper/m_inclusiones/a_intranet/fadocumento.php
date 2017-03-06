<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id=$_POST['id'];
        $c=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$id");
        if($r=mysqli_fetch_assoc($c)){

?>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<p class="text-center">Seguro que desea activar el documento:</p>
<h3 class="text-maroon text-center"><?php echo $r['Descripcion']; ?></h3>
<?php
        }else{
            echo mensajeda("Error: No se encontró el registro.");
        }
        mysqli_free_result($c);
    }else{
        echo mensajeda("Error: No envió datos.");
    }
}else{
  echo accrestringidoa();
}
?>