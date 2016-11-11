<!DOCTYPE html>

<html>

  <head>
  
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Gestión Preguntas</title>
    <link rel='stylesheet' type='text/css' href='estilos/style.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (min-width: 530px) and (min-device-width: 481px)'
		   href='estilos/wide.css' />
	<link rel='stylesheet' 
		   type='text/css' 
		   media='only screen and (max-width: 480px)'
		   href='estilos/smartphone.css' />	
		   <style type="text/css">
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
			
  </head>
  
  
  <body>

  
  <?php
	
	session_start();
	
	if( !empty($_SESSION['user']) ){ //en caso de que tengamos algo ahi guardado todo va bien
	
	}
  
	?>
	
  
  <div id='page-wrap'>
	<header class='main' id='h1'>
		<span class="right"><a href="formulario.html">Registrarse</a></span>	
      		<span class="right"><a href="">Logout</a></span>
		<br></br>
		<p>
		<?php
		echo "Has iniciado sesion como: " ;
		echo $_SESSION['user'];
		?>
		</p>
		<br></br>
		<h2>Quiz: el juego de las preguntas</h2>
    </header>
	<nav class='main' id='n1' role='navigation'>
		<span><a href='layout.html'>Inicio</a></span>
		<span><a href='VerPreguntas.php'>Preguntas</a></span>
		<span><a href='creditos.html'>Creditos</a></span>
	</nav>
    <section class="main" id="s1">
    
	<div>
	<form id = "form_pregunta" name = "form_pregunta" action = "InsertarAJAX.php" method="post">
	<legend><h3>A&ntildeade tu pregunta</h3></legend>
	<fieldset>
	<center>
	<table>
		
		<tr>
		<td>Pregunta : </td> <td> <TEXTAREA rows="3" cols="30" maxlength="50" id = "pregunta" name="pregunta" required ></TEXTAREA></td>
		</tr>
		<td></td><td></td>
		<tr>
		<td>Respuesta: </td> <td> <input type="text" id = "respuesta" name="respuesta" required></td>
		</tr>
		<td></td><td></td>
		<tr>
		<td>Tema: </td> <td> <input type="text" id = "tema" name="tema" required></td>
		</tr>
		<td></td><td></td>
		<tr>
		<td>Elige un grado de dificultad : </td> <td> 
		<select name="dificultad" id = "dificultad" size="1" required>
							<option value="0">Seleccione dificultad</option>
						  	<option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						    <option value="5">5</option>
		</select></td>
		</tr>
		<td></td><td> </td><td> </td>
		
	</table>
	</form>
	
	<div id = "insercion"></div> <!-- EN ESTE TROZO DEBERIA APARECER LO DE AJAX-->
	<div id = "visualizacion" ></div>
	
	</div>
    </section>
	<form>
		<input type="button" name="insertar" value="Insertar pregunta" onClick=" insertarDatos()">
		<input type="button" name="visualizar" value="Ver Preguntas" onClick="mostrarDatos()">
	</form>

	<footer class='main' id='f1'>
		<p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>

<script language="javascript">
   
    
function mostrarDatos(){
    
 xmlhttp = new XMLHttpRequest();
 xmlhttp.onreadystatechange=function()
 {
 if (xmlhttp.readyState==4 && xmlhttp.status==200)
 {document.getElementById("visualizacion").innerHTML=xmlhttp.responseText; }
 }
 xmlhttp.open("GET","VerPreguntasXML.php",true); 
 xmlhttp.send();
}
   
     
function insertarDatos(){
    
  var email = "<? echo $_SESSION['usuario'] ?>";
  var pregunta = document.getElementById("pregunta").value;
  var respuesta = document.getElementById("respuesta").value;
  var dificultad = document.getElementById("dificultad").value;
  var tema = document.getElementById("tema").value;
  var parametros= "email="+email+"&pregunta="+pregunta+"&respuesta="+respuesta+"&dificultad="+dificultad+"&tema="+tema;
        
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
	{
	if(xmlhttp.readyState==4 && xmlhttp.status==200){
	document.getElementById('insercion').innerHTML=xmlhttp.responseText; }
	}
	xmlhttp.open("POST","InsertarAJAX.php",true);
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	xmlhttp.send(parametros);
 
}
</script>