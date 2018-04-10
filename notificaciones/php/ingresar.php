<?php
session_start();
include 'cone.php';
include 'func.php';
$d=array();
if(isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['pas']) && !empty($_POST['pas'])){
	$usu=iseguro($cone, $_POST['usu']);
	$pas=iseguro($cone, $_POST['pas']);
	$c=mysqli_query($cone,"SELECT * FROM usuario WHERE Dni='$usu' AND Estado=1;");
	if ($r=mysqli_fetch_assoc($c)) {
			if($r['Contrasena']==$pas){
				if($r['Estado']==1){
					$d['exito']=true;
					$d['mensaje']="<span class='text-success'>Bienvenido...</span>";
					$_SESSION['nusu']=$r['Apellidos'].", ".$r['Nombres'];
					$_SESSION['idusu']=$r['idUsuario'];
				}else{
					$d['exito']=false;
					$d['mensaje']="<span class='text-warning'>Usuario desactivado</span>";
				}
			}else{
				$d['exito']=false;
				$d['mensaje']="<span class='text-warning'>DNI o contraseña incorrecta</span>";
			}
	}else{
		$d['exito']=false;
		$d['mensaje']="<span class='text-warning'>DNI o contraseña incorrecta</span>";
	}
	mysqli_free_result($c);
}else{
	$d['exito']=false;
	$d['mensaje']="<span class='text-warning'>No ingreso el DNI y/o la contraseña</span>";
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>