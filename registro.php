<!DOCTYPE HTML>

<html>
	<head> 
	
	<title>Formulario de Registro</title>
	
	<style type="text/css">
	body {
    color: #3c464f;
    background-color: #8bbcea; }
	  .boton{
        font-size:10px;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:0px;
        width:80px;
        height:25px;
       }
	</style>
	<script src="http://swmiguel.esy.es/ProyectoQuiz/js/validaciones_cliente.js"></script>
	<meta name="author" content="Oscar y Miguel">
	<meta name="description" content="Formulario de registro de usuarios">
	
			
	</head>

	<body>
		<h2>Formulario de Registro</h2> 
		<form id='registro' name='formulario' onSubmit= "return validar()" action = "registro.php" method = "POST" > 
			<hr/>
			<table>
				<tr>
					<td>Nombre*: </td> <td>
					<input type="text" id = "nombre" name="nombre"> </td>
					<td>Nickname*: </td> <td>
					<input type="text" id = "nick" name="nick" size="10"> </td>
				</tr>				
				<tr>
					<td>Apellidos*: </td> <td>
					<input type="text" id = "apellidos" name="apellidos"> </td>
					<td>Contrase&ntildea*: </td> <td>
					<input type = "password"   id = "pass" name= "pass" > <!--onchange = "contrasenyaAJAX()"-->  </td>
				</tr>
				<tr>
					<td>Email*: </td> <td>
					<input type="text"  id = "mail" name="mail" > <!--onchange = "mailAJAX()"--> </td>
					<td>Confirmar contrase&ntildea*: </td> <td>
					<input type = "password" id = "pass2" name= "pass2"> </td>
				</tr>
				<tr>
					<td>Sexo: </td> <td>
					<select name="sexo" id = "sexo" size="1">
					<option>Hombre</option>
					<option>Mujer</option>
					<option>Otro</option>
					</select> </td>
					<td>N&uacutemero de tel&eacutefono*:</td> <td>
					<input type="number" id = "telf" name="telf" size="9"> </td>
				</tr>
				<tr>
				<td>Especialidad*: </td> <td>
					<select name="esp"  id = "esp" size="1">
					<option>Ing. del Software</option>
					<option>Ing. de Computadores</option>
					<option>Computaci&oacuten</option>
					</select> </td>
				</tr>
				<tr>
				</tr>
				<tr>
				</tr>	
				<tr><td>                      </td>
				<td><input type="submit" class = "boton" value="Registrarse" ></input></td>
				<tr><td>                      </td>
				<td><input type="reset" class="boton" value="Borrar" ></input></td>
				
				</tr>
		</table>
		</form>
		<!--DIV PARA LA RESPUESTA DEL AJAX!-->
		<div id = "divMail" ></div>
		<div id = "divContrasenya" ></div> 
	</body>
</html>



<?php

	require_once('lib/nusoap.php');
	
	require_once('lib/class.wsdlcache.php');

	//las comprobaciones se haran una vez rellenados los campos

	if( isset($_POST['nombre'])&& isset($_POST['apellidos']) && isset($_POST['nick'])&& isset($_POST['pass']) && isset($_POST['mail'])&& isset($_POST['telf']) && isset($_POST['sexo'])&& isset($_POST['esp']) ){
	
	include("./conexionbd.php");
	
	
	//extraemos los valores introducidos y los guardamos en variables para trabajar mas facil
	
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$nick = $_POST['nick'];
		$pass = $_POST['pass'];
		$mail = $_POST['mail'];
		$telf = $_POST['telf'];
		$sexo = $_POST['sexo'];
		$esp = $_POST['esp'];
	
	///////////////////////////////////quitar los onchange////////////////////
	
	
	$soapclient1 = new nusoap_client('http://cursodssw.hol.es/comprobarmatricula.php?wsdl',true);

	$result1 = $soapclient1->call('comprobar', array('x'=>$_POST['mail']));

	$soapclient2 = new nusoap_client("http://swmiguel.esy.es/ProyectoQuiz/ComprobarContrasenya.php?wsdl",true);

	$result2 = $soapclient2->call('passVal', array('password'=>$_POST['pass']));
	
	//NO HAREMOS COMPROBACIONES SI EL MAIL ES INCORRECTO
	
		if( $result1 != "SI" ){
		
		 echo "<script languaje='javascript'>alert('DEBES ESTAR MATRICULAD PARA REGISTRARTE ')</script>";
		 
		 die('');
		
		}
	
		if( $result2 != "VALIDA"){
		
		echo "<script languaje='javascript'>alert('INTRODUZCA UNA CNTRASEÑA MAS SEGURA')</script>";
		 
		die('');
		
		}

	//SI PASA DE AQUI COMENZAMOS A COMPROBAR EL RESTO
	
		function comprobarDatos(){
		
			$patron_mail = '/^[a-zA-Z]+[0-9]{3}@ikasle.ehu.(es|eus)$/';	
		
			$patron_telf = '/^[0-9]{9}$/';
		
			$patron_apellidos = '/^([a-zA-Z][a-zA-Z]*) ([a-zA-Z][a-zA-Z]*)$/';
		
			return preg_match( $patron_mail, $_POST['mail'] );
		
		}
		
		function comprobarPass(){
			
			$okay = true;
		
			if(strlen($_POST['pass']) <= 6  ){
			
				$okay = false;
			
				echo "<p><a id='parUsers'>Tu contraseña debe tener al menos 6 caracteres</a> ";	
			
			}if( $_POST['pass'] != $_POST['pass2']){
				
				$okay = false;
				
				echo "<p><a id='parUsers'>ERROR: Tus contraseñas no coinciden </a> ";	
				
			}
		
			return $okay;
		}
		
		
		//AHORA SEGUIREMOS CON LAS LINEAS QUE SE EJECUTAN PARA REALIZAR LAS VALIDACIONES
		
		//VAMS A COMENTAR --> AHRA LO HACE EL SW!!!!!!!!
		
		/*if( !comprobarDatos() ){ // EN CASO DE ERRORES
		
			echo "El correo utilizado no es valido";
		
			echo "<p> <a href='registro.php'> Volver al registro </a>";
			
			die('Se ha abortado la ejecucion del programa' );
		
		}*/if( !comprobarPass()){
		
			echo "<p> <a href='registro.php'> Volver al registro </a>";
			
			die('Se ha abortado la ejecucion de programa' );
			
			
		}
		//EN CASO DE QUE TODO HAYA IDO BIEN
			
			 $sql = "INSERT INTO usuario(Nombre,Apellidos,Nickname,Clave,Email,Telefono,Especialidad) VALUES('$nombre','$apellidos','$nick','$pass','$mail',$telf,'$esp')";
	
			if(!mysqli_query($mysqli ,$sql)){
		
				die('' . mysql_error());
				
			}
	
			echo "¡Usuario registrado con exito!";
		
			echo "<p> <a href='VerUsuarios.php'> VER USUARIOS </a>";
			
			echo "<p> <a href='layout.html'> INICIO </a>";
		
			mysqli_close($mysqli);
			
		
		
		} 	
?>