<?php
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");

$cn=mysqli_query($cone, "SELECT * FROM noticia WHERE idNoticia=1");
if($rn=mysqli_fetch_assoc($cn)){

?>
<h2><?php echo $rn['Titular']; ?></h2>
<?php echo html_entity_decode($rn['Cuerpo']); ?>
<?php

}
?>
