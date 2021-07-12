<?php
include ("conec.php");
$cs=mysqli_query($con, "SELECT id, nombre FROM participantes WHERE inscrito=1 AND gano IS NULL ORDER BY rand() LIMIT 1;");
if($rs=mysqli_fetch_assoc($cs)){
?>
    <h3 class="text-danger"><?php echo $rs['nombre']; ?></h3>
    <input type="hidden" name="id" value="<?php echo $rs['id']; ?>">
<?php
}else{
?>
    <h2 class="text-danger">Error, vuelva a intentarlo.</h2>
<?php
}
mysqli_free_result($cs);
mysqli_close($con);
?>