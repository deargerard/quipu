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
              <td>
                <h4 class="text-maroon text-center"><?php echo " Del: ". fnormal($rvac['FechaIni'])." Al:  ".fnormal($rvac['FechaFin']) ?></h4>
                <label for="estado">Elija el estado a cambiar</label>
                <select name="estado" id="estado" class="form-control">
                  <option value="2">Cancelada</option>
                  <option value="5">Suspendida</option>
                  <option value="1">Ejecutada</option>
                  <option value="3">Ejecutandose</option>
                  <option value="9">Compensada</option>
                </select>
                <label for="obse">Observaciones</label>
                <textarea name="obse" id="obse" rows="4" class="form-control"></textarea>
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
