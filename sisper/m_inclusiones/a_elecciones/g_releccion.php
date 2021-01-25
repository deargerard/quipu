<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesocon($cone,$_SESSION['identi'],18)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		if($acc=="agrele"){
            if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['ini']) && !empty($_POST['ini']) && isset($_POST['fin']) && !empty($_POST['fin'])){

                $des=iseguro($cone, $_POST['des']);
                $ini=ftmysql(iseguro($cone, $_POST['ini']));
                $fin=ftmysql(iseguro($cone, $_POST['fin']));
                $idem=$_SESSION['identi'];

                if($fin>$ini){
                    if(mysqli_query($cone, "INSERT INTO elecciones (nombre, inicio, fin, estado, updated_by, updated_at) values ('$des', '$ini', '$fin', 1, $idem, now());")){
                        $r['e']=true;
                        $r['m']=mensajesu("Elección registrada.");
                    }else{
                        $r['m']=mensajewa("Error al registrar la elección.");
                    }
                }else{
                    $r['m']=mensajewa("La fecha de finalización no puede ser menor a la fecha que inicia.");
                }
                

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="ediele"){
            if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['ini']) && !empty($_POST['ini']) && isset($_POST['fin']) && !empty($_POST['fin']) && isset($_POST['id']) && !empty($_POST['id'])){

                $id=iseguro($cone, $_POST['id']);
                $des=iseguro($cone, $_POST['des']);
                $ini=ftmysql(iseguro($cone, $_POST['ini']));
                $fin=ftmysql(iseguro($cone, $_POST['fin']));
                $idem=$_SESSION['identi'];

                if($fin>$ini){
                    $q="UPDATE elecciones SET nombre='$des', inicio='$ini', fin='$fin', updated_by=$idem, updated_at=now() WHERE id=$id;";
                    if(mysqli_query($cone, $q)){
                        $r['e']=true;
                        $r['m']=mensajesu("Elección editada.");
                    }else{
                        $r['m']=mensajewa("Error al editar la elección.");
                    }
                }else{
                    $r['m']=mensajewa("La fecha de finalización no puede ser menor a la fecha que inicia.");
                }
                

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="estele"){
            if(isset($_POST['id']) && !empty($_POST['id'])){

                $id=iseguro($cone, $_POST['id']);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT estado FROM elecciones WHERE id=$id;");
                if($re=mysqli_fetch_assoc($ce)){
                        $e=$re['estado']==1 ? 0 : 1;

                        $q="UPDATE elecciones SET estado=$e, updated_by=$idem, updated_at=now() WHERE id=$id;";
                        if(mysqli_query($cone, $q)){
                            $r['e']=true;
                            $r['m']=mensajesu("Se cambió el estado.");
                        }else{
                            $r['m']=mensajewa("Error al cambiar el estado.");
                        }

                }else{
                    $r['m']=mensajewa("Datos inválidos");
                }

            }else{
                $r['m']=mensajewa("Faltan datos.");
            }
        }elseif($acc=="agrlis"){
            if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['id']) && !empty($_POST['id'])){

                $des=iseguro($cone, $_POST['des']);
                $nom=iseguro($cone, $_POST['nom']);
                $id=iseguro($cone, $_POST['id']);
                $idem=$_SESSION['identi'];


                    if(mysqli_query($cone, "INSERT INTO listas (nombre, descripcion, eleccione_id, updated_by, updated_at) values ('$nom', '$des', $id, $idem, now());")){
                        $r['e']=true;
                        $r['m']=mensajesu("Lista registrada.");
                    }else{
                        $r['m']=mensajewa("Error al registrar la lista.");
                    }
                

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="edilis"){
            if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['eleccione_id']) && !empty($_POST['eleccione_id'])){

                $des=iseguro($cone, $_POST['des']);
                $nom=iseguro($cone, $_POST['nom']);
                $id=iseguro($cone, $_POST['id']);
                $idem=$_SESSION['identi'];


                    if(mysqli_query($cone, "UPDATE listas SET nombre='$nom', descripcion='$des', updated_by=$idem, updated_at=now() WHERE id=$id;")){
                        $r['e']=true;
                        $r['m']=mensajesu("Lista editada.");
                    }else{
                        $r['m']=mensajewa("Error aleditar la lista.");
                    }
                

            }else{
                $r['m']=mensajewa("Los campos marcado con <span class='text-red'>*</span> son obligatorios.");
            }
        }elseif($acc=="elilis"){
            if(isset($_POST['id']) && !empty($_POST['id'])){

                $id=iseguro($cone, $_POST['id']);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT * FROM eleccione_empleado WHERE lista_id=$id;");
                if(mysqli_num_rows($ce)>0){

                    $r['m']=mensajewa("Ya existen votos para está lista, no se permite eliminar");

                }else{
                        

                        $q="DELETE FROM listas WHERE id=$id;";
                        if(mysqli_query($cone, $q)){
                            $r['e']=true;
                            $r['m']=mensajesu("Se eliminó la lista.");
                        }else{
                            $r['m']=mensajewa("Error al eliminar la lista.");
                        }

                }

            }else{
                $r['m']=mensajewa("Faltan datos.");
            }
        }elseif($acc=="eliele"){
            if(isset($_POST['id']) && !empty($_POST['id'])){

                $id=iseguro($cone, $_POST['id']);
                $idem=$_SESSION['identi'];

                $ce=mysqli_query($cone, "SELECT * FROM listas WHERE eleccione_id=$id;");
                if(mysqli_num_rows($ce)>0){

                    $r['m']=mensajewa("Ya existen listas para está elección, no se podrá eliminar");

                }else{
                        
                        $q="DELETE FROM elecciones WHERE id=$id;";
                        if(mysqli_query($cone, $q)){
                            $r['e']=true;
                            $r['m']=mensajesu("Se eliminó la elección.");
                        }else{
                            $r['m']=mensajewa("Error al eliminar la elección.");
                        }

                }

            }else{
                $r['m']=mensajewa("Faltan datos.");
            }
        }//acafin
	}else{
		$r['m']=mensajewa("Error: Ne envio la acción.");
	}
}else{
    $r['m']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>