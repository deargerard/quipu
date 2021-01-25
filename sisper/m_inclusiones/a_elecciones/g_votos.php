<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;

	if(isset($_POST['eleccione_id']) && !empty($_POST['eleccione_id'])){
        $id=iseguro($cone, $_POST['eleccione_id']);
        $ele='ele'.$id;
        if(isset($_POST[$ele]) && !empty($_POST[$ele])){
            $vot=iseguro($cone, $_POST[$ele]);
            $idem=$_SESSION['identi'];

            $cv=mysqli_query($cone, "SELECT * FROM eleccione_empleado WHERE eleccione_id=$id AND empleado_id=$idem;");
            if(mysqli_num_rows($cv)>0){
                $r['m']=mensajewa("Usted, ya emitio su voto.");
            }else{

                if(mysqli_query($cone, "INSERT INTO eleccione_empleado (eleccione_id, lista_id, empleado_id, updated_at) VALUES ($id, $vot, $idem, now());")){
                    $r['e']=true;
                    $r['m']=mensajesu("Voto registrado, gracias por participar");
                }else{
                    $r['m']=mensajewa("Error al registrar su voto, vuelva a intentarlo.");
                }
            }
        }else{
            $r['m']=mensajewa("No ha elegido una lista, vuelva a intentarlo.");
        }
		
	}else{
		$r['m']=mensajewa("Error: Faltan datos.");
	}

header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>