<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST["idvac"]) && !empty($_POST["idvac"])){
    $idvac=iseguro($cone,$_POST["idvac"]);
    $cvac=mysqli_query($cone,"SELECT pv.Condicion, pv.FechaIni, pv.FechaFin, pv.Observaciones FROM provacaciones pv INNER JOIN empleadocargo ec ON pv.idEmpleadoCargo = ec.idEmpleadoCargo WHERE pv.idProVacaciones=$idvac and ec.idEstadoCar=1");
    if($rvac=mysqli_fetch_assoc($cvac)){
        $est= $rvac['Condicion']==1 ? "Programadas" : "Reprogramadas";
        ?>
          <table class="table">
            <tbody>
              <tr>
                <td>
                  <h4 class="text-orange text-center"><?php echo $est." del: ". fnormal($rvac['FechaIni'])." Al:  ".fnormal($rvac['FechaFin']) ?></h4>
                  <label for="estado">Estado <small class="text-danger">*</small></label>
                  <select name="estado" id="estado" class="form-control">
                    <option value="2">Cancelada</option>
                    <option value="9">Compensada</option>
                    <option value="1">Ejecutada</option>
                    <option value="3">Ejecutandose</option>
                    <option value="p">Pendiente</option>
                    <option value="4">Planificada</option>
                    <option value="5">Suspendida</option>
                  </select>
                  <label for="obse">Observaciones</label>
                  <textarea name="obse" id="obse" rows="4" class="form-control"><?php echo $rvac['Observaciones']; ?></textarea>
                </td>
              </tr>
            </tbody>
          </table>
          <input type="hidden" name="idvac" value="<?php echo $idvac; ?>">
          <div id="d_frespuesta"></div>
        <?php
        
    }else{
        echo mensajewa("Error: No se encontró las vacaciones o el cargo del trabajador no está activo.");
    }
    mysqli_free_result($cvac);  
  }else{
    echo mensajewa("Error: No se eligio vacaciones para eliminar.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>
