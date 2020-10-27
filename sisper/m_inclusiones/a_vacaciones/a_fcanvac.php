<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST["idvac"]) && !empty($_POST["idvac"])){
    $idvac=iseguro($cone,$_POST["idvac"]);
    $cvac=mysqli_query($cone,"SELECT * FROM provacaciones WHERE idProVacaciones=$idvac");
    $rvac=mysqli_fetch_assoc($cvac);
    $est="";
    $est= $rvac['Condicion']==1 ? "PROGRAMADAS" : "REPROGRAMADAS";
    if ($_POST['perm']==0){
      echo mensajewa("No tiene permiso para cancelar el registro");
?>
      <script>
      $("#b_sicvacaciones").hide();
      $("#b_nocvacaciones").html("Cerrar");
      </script>
      <form class="form-group" id="f_permc">
        <div class="col-sm-4 col-md-offset-4">
          <input type="password" class="form-control" id="clave" name="clave" placeholder="Ingese su clave">
          <input type="hidden" name="perm" id="perm" value="<?php echo "1" ?>">
          <input type="hidden" name="idvac" id="idvac" value="<?php echo $idvac ?>">
        </div>
        <button class="btn btn-info" type="button" id="b_gclave" name="b_gclave" onclick="validarc()">Cambiar estado</button>
      </form>
<?php
    }else{
      ?>
        <table class="table">
          <thead>
            <tr>
              <th class="text-center"><?php echo "Desea cambiar el estado de las vacaciones ". $est; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">
                <h4 class="text-maroon text-center"><?php echo " Del: ". fnormal($rvac['FechaIni'])." Al:  ".fnormal($rvac['FechaFin']) ?></h4>
                <h5 class="text-info">Elija el estado a cambiar</h5>
                <label class="radio-inline">
                  <input type="radio" name="estado" id="inlineRadio1" value="2"> Cancelar
                </label>
                <label class="radio-inline">
                  <input type="radio" name="estado" id="inlineRadio2" value="5"> Suspender
                </label>
              </td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="idvac" value="<?php echo $idvac?>">
      <?php
        mysqli_free_result($cvac);
        mysqli_close($cone);
}
  }else{
    echo mensajewa("Error: No se eligio vacaciones para eliminar.");
  }
}else{
  echo accrestringidoa();
}
?>
