<?php
include("conect.php");
$link=conect();
$link1=conect();
$sql=conect();
//Comprobamos que los campos nick, pass y pass1 se han rellenado en el form de user_personal.php, sino volvemos al form 
if(($_POST['nick'] =='') or ($_POST['pass'] =='') or ($_POST['pass1'] =='') )
{
header("Location: user_personal.php"); //enviamos al form de registro que esta en reg.php
}
else
{
	//Comprobamos que la pass y pass1 son iguales, sino, volvemos a reg.php
	if($_POST['pass']!=$_POST['pass1'])
	{
		echo "Las passwords no son iguales.<br>";
		echo "<a href=user_personal.php>Volver</a>";
	}
	else
	{
		if(strlen($_POST['pass'])<8)
		{
			$cant=strlen($_POST['pass']);
			echo "El password tiene :".$cant." caracteres, no es una contrasena segura. <br>";
			echo "<a href=user_personal.php>Volver</a>";
		}
		else
		{
			$lib= mysqli_query($sql,"select max(id) as ultimo_id from user");
			$rs_lib = mysqli_fetch_assoc($lib);
			$id= $rs_lib['ultimo_id'] + 1;
			//quitamos el codigo malicioso de $_POST[nick] y $_POST[pass]
			$user = stripslashes($_POST["nick"]);
			$user = strip_tags($user);
			$pass = stripslashes($_POST["pass"]);
			$pass = strip_tags($pass);
			//comprobamos que el usuario no existe en la db
			$usuarios=mysqli_query($link,"select * from user where user='$user'");
			if(mysqli_num_rows($usuarios)!=0) //si existe comenzamos con la sesion, si no, al index
			{
				echo 'El usuario ya esta registrado <br>';
				mysqli_free_result($usuarios); //liberamos la memoria del query a la db
				echo "<a href=user_personal.php>Volver</a>";
			}
			else
			{
			//quitamos todo el codigo malicioso de las demas variables del form de registro
				$cargo = stripslashes($_POST['tipo']);
				$cargo = strip_tags($cargo);
			//introducimos el nuevo registro en la tabla users
				mysqli_query($link1,"INSERT INTO user values ($id,'$user','$pass','$cargo')");
				echo "Usuario registrado con exito. <br>"; 
				echo '<a href="user_personal.php">Volver</a>';
			}
		}
	}
} 
?>
