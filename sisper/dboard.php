<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Inicio";
  include("m_estructura/e_up.php");
  include("m_vistas/dboard.php");
  include("m_estructura/e_down.php");
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>