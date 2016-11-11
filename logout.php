<?php

//SIMPLEMENTE DESTRUIMOS LA SESION Y REDIRIGIMOS

	session_destroy();
	
	header("location: layout.php");


?>