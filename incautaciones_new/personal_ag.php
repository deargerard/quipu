<?php
include("conect.php");
$link=conect();
$link1=conect();
$nombre=$_POST["nombre"];
$apellido=$_POST["apellido"];
$cargo=$_POST["cargo"];
//Comprobamos que los campos nick, pass y pass1 se han rellenado en el form de user_personal.php, sino volvemos al form 
	//Comprobamos que la pass y pass1 son iguales, sino, volvemos a reg.php
			//$lib= mysqli_query($sql,"select max(id) as ultimo_id from user");
			//$rs_lib = mysqli_fetch_assoc($lib);
			//$id= $rs_lib['ultimo_id'] + 1;
			//quitamos el codigo malicioso de $_POST[nick] y $_POST[pass]
			$dni = stripslashes($_POST["dni"]);
			$dni = strip_tags($dni);
			//comprobamos que el usuario no existe en la db
			$usuarios=mysqli_query($link,"select * from empleados where dni='$dni'");
			if(mysqli_num_rows($usuarios)!=0) //si existe comenzamos con la sesion, si no, al index
			{
				echo 'Este personal ya esta registrado <br>';
				mysqli_free_result($usuarios); //liberamos la memoria del query a la db
				echo "<a href=personal.php>Volver</a>";
			}
			else
			{
			//quitamos todo el codigo malicioso de las demas variables del form de registro
				$movil = stripslashes($_POST['movil']);
				$movil = strip_tags($movil);
			//introducimos el nuevo registro en la tabla users
				mysqli_query($link1,"INSERT INTO empleados values ('$dni','$nombre','$apellido','$cargo','$movil')");
				echo "Empelado registrado con exito. <br>"; 
				echo '<a href="personal.php">Volver</a>';
			}
?>
