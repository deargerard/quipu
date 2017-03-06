<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$idp=$_SESSION['identi'];
?>
			<div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo mfotop($re['NumeroDoc']) ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $re['ApellidoPat']." ".$re['ApellidoMat'].", ".$re['Nombres'] ?></h3>

              <p class="text-muted text-center"><?php echo cargoe($cone,$idp) ?></p>
              <?php if(accesoadm($cone,$_SESSION['identi'],1)){ ?>
              <button class="btn btn-info btn-block btn-xs" data-toggle="modal" data-target="#m_camfoto" onclick="camfoto(<?php echo "'$numdoc'" ?>)">Cambiar foto</button>
              <?php } ?>
            </div>