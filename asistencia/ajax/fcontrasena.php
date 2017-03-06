<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
?>
                        <div class="form-group">
                            <label for="con">Contraseña actual</label>
                            <input type="password" class="form-control" id="con" name="con">
                        </div>
                        <div class="form-group">
                            <label for="ncon">Nueva contraseña</label>
                            <input type="password" class="form-control" id="ncon" name="ncon">
                        </div>
                        <div class="form-group">
                            <label for="rncon">Repita la nueva contraseña</label>
                            <input type="password" class="form-control" id="rncon" name="rncon">
                        </div>
<?php
}else{
    header('Location: index.html');
}
?>