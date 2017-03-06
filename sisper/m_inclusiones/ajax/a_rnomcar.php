<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
$idp=$_SESSION['idperper'];
$cper=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, NumeroDoc FROM empleado WHERE idEmpleado=$idp");
$rper=mysqli_fetch_assoc($cper);
$numdoc=$rper['NumeroDoc'];
?>
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo mfotom($rper['NumeroDoc']) ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $rper['ApellidoPat']." ".$rper['ApellidoMat'].", ".$rper['Nombres'] ?></h3>

              <p class="text-muted text-center"><strong><?php echo cargoe($cone,$idp) ?></strong></p>
              <p class="text-muted text-center"><small><?php echo dependenciae($cone,$idp) ?></small></p>
              <?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
              <button class="btn btn-info btn-block btn-xs" data-toggle="modal" data-target="#m_camfoto" onclick="camfoto(<?php echo "'$numdoc'" ?>)">Cambiar foto</button>
              <?php } ?>
            </div>
<?php
}else{
  echo accrestringidoa();
}
?>