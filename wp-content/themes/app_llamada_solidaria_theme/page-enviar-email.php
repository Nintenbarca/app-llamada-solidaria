<?php
/*
	Template Name: Enviar Email
*/
?>

<?php 
//session_start();

if (is_user_logged_in() && is_admin_user()){
	$destinatario = $_POST['user_email'];
	$asunto = "Este mensaje es de prueba"; 
	$cuerpo = ' 
	<html> 
	<head> 
	   <title>Prueba de correo</title> 
	</head> 
	<body> 
	<h1>¡Hola amigos!</h1> 
	<p> 
	<b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
	</p> 
	</body> 
	</html> 
	'; 
	
	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

	/*
	//dirección del remitente 
	$headers .= "From: Miguel Angel Alvarez <esal.web.sj@afalevante.ong>\r\n"; 

	//dirección de respuesta, si queremos que sea distinta que la del remitente 
	$headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 
	
	//ruta del mensaje desde origen a destino 
	$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

	//direcciones que recibián copia 
	$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

	//direcciones que recibirán copia oculta 
	$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 
	*/
	
	wp_mail($destinatario, $asunto, $cuerpo, $headers);
	wp_redirect(get_home_url());
}else{
	wp_redirect(get_home_url());
}
?>