<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],18)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="verres"){
            $idem=$_SESSION['identi'];
            if(isset($v1) && !empty($v1)){
                $ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE id=$v1;");
                if($re=mysqli_fetch_assoc($ce)){
?>
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th class="text-orange"><h4><i class="fa fa-archive text-gray"></i> <?php echo $re['nombre'] ?></h4></th>
                            <td><?php echo ftnormal($re['inicio']) ?><br><?php echo ftnormal($re['fin']) ?></td>
                            <td>
                                <button class="btn bg-teal btn-sm" onclick="relecciones(<?php echo $v1; ?>);"><i class="fa fa-file-pdf-o"></i></button>
                            </td>
                        </tr>
                    </table>
<?php
                    $cr=mysqli_query($cone, "SELECT l.nombre, COUNT(l.id) AS votos FROM listas l INNER JOIN eleccione_empleado ee ON l.id=ee.lista_id WHERE ee.eleccione_id=$v1 GROUP BY l.id;");
                    if(mysqli_num_rows($cr)>0){
?>
                        <table class="table table-hover table-bordered text-muted">
                            <thead>
                                <tr>
                                    <th>LISTA</th>
                                    <th>VOTOS</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
                            $nv=0;
                            while($rr=mysqli_fetch_assoc($cr)){
                                $nv=$nv+$rr['votos'];
?>
                                <tr>
                                    <td class="text-primary"><?php echo $rr['nombre'] ?></td>
                                    <td class="text-maroon"><?php echo $rr['votos'] ?></td>
                                </tr>
<?php
                            }
?>
                                <tr>
                                    <th>TOTAL VOTOS</th>
                                    <td><?php echo $nv; ?></td>
                                </tr>
                                <tr>
                                    <th>TOTAL OMISOS</th>
                                    <td><?php echo $re['numvotantes']-$nv; ?></td>
                                </tr>
                                <tr>
                                    <th>TOTAL ELECTORES</th>
                                    <td><?php echo $re['numvotantes']; ?></td>
                                </tr>
                            </tbody>
                        </table>
<?php
                        $cv=mysqli_query($cone, "SELECT empleado_id FROM eleccione_empleado WHERE eleccione_id=$v1;");
?>
                        <table class="table table-bordered table-hover text-muted" id="dtvotantes">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DNI</th>
                                    <th>NOMBRE</th>
                                    <th>CARGO</th>
                                    <th>DEPENDENCIA</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
                        $nv=0;
                        while ($rv=mysqli_fetch_assoc($cv)) {
                            $nv++;
?>
                                <tr>
                                    <td><?php echo $nv; ?></td>
                                    <td><?php echo docidentidad($cone, $rv['empleado_id']); ?></td>
                                    <td><?php echo nomempleado($cone, $rv['empleado_id']); ?></td>
                                    <td><?php echo cargoe($cone, $rv['empleado_id']); ?></td>
                                    <td><?php echo dependenciae($cone, $rv['empleado_id']); ?></td>
                                </tr>       
<?php
                        }
?>
                            </tbody>
                        </table>
                        <script>
                            $('#dtvotantes').dataTable();
                        </script>
<?php
                        mysqli_free_result($cv);
                    }else{
                        echo mensajewa("Aún no hay votos.");
                    }
                    mysqli_free_result($cr);
                }else{
                    echo mensajewa("Datos inválidos.");
                }
                mysqli_free_result($ce);
            }else{
                echo mensajewa("Faltan datos.");
            }
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>