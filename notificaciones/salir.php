<?php
	session_start();
	session_unset();
	session_destroy();
	include 'const.php';
	header('Location:'.URL);
?>