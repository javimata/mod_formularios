<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

date_default_timezone_set("America/Mexico_City");

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ) . '');

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
require_once (JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php');

//LIMPIEZA DE CAMPOS
require_once ('class.inputfilter.php');

$filter 	= new InputFilter();
$_REQUEST 	= $filter->process($_REQUEST);

//create application
$mainframe  = &JFactory::getApplication('site');
$db     	= JFactory::getDbo();

$modulo_id 	= $_REQUEST["module_id"];
if ($modulo_id){

	$query = "SELECT * FROM #__modules WHERE id=" . $modulo_id;  
	$db->setQuery($query); 
	$modulo = $db->loadObject(); 
	$params = json_decode($modulo->params);

	$enviar 		= $params->enviar_email;
	$email_envio 	= $params->email_envio;
	$cc 			= $params->email_cc;
	$bcc 			= $params->email_bcc;
	$titulo_email 	= $params->titulo_email;
	$texto_ok 		= $params->texto_ok;
	$texto_error 	= $params->texto_error;
	$titulo_seccion	= $params->titulo_seccion;

	$envia_gracias			= $params->enviar_gracias;
	$titulo_email_gracias 	= $params->titulo_email_gracias;

}

	$seccion = $_REQUEST["seccion"];
	if ( !$seccion ){ $seccion=1; }

	if ( $seccion == 1 ){

		$nombre      = $_REQUEST['bolsa-trabajo_nombre'];
		$telefono    = $_REQUEST['bolsa-trabajo_telefono'];
		$movil       = $_REQUEST['bolsa-trabajo_movil'];
		$domicilio   = $_REQUEST['bolsa-trabajo_domicilio'];
		$email       = $_REQUEST['bolsa-trabajo_email'];
		$escolaridad = $_REQUEST['bolsa-trabajo_escolaridad'];
		$experiencia = $_REQUEST['bolsa-trabajo_experiencia'];
		$puesto      = $_REQUEST['bolsa-trabajo_puesto'];
		$ciudad      = $_REQUEST['bolsa-trabajo_ciudad'];
		$estado      = $_REQUEST['bolsa-trabajo_estado'];
		$area        = $_REQUEST['area'];

		//SEND EMAIL
		$to = $email_envio; 
		$subject = $titulo_email; 
		$fecha = date('Y-m-d H:i:s');
		
		$body = "
		Nombre: $nombre
		Telefono: $telefono
		Movil: $movil
		Domicilio: $domicilio
		Ciudad: $ciudad
		Estado: $estado
		E-Mail: $email
		Escolaridad: $escolaridad
		Experiencia: $experiencia
		Puesto de interes: $puesto
		Area: $area 
		Fecha: $fecha ";

	}

	if ($enviar==1){


		$url_redirect = $_POST["url_redirect"];


        include('class.phpmailer.php');
        // include("class.smtp.php");

        $mail = new PHPMailer();
        // $email->IsHTML(true);
        $mail->From      = $email;
        $mail->FromName  = $nombre;
        $mail->Subject   = $subject;
        $mail->Body      = $body;
        $mail->AddAddress( $to, "Igartua Yamaha" );
        $mail->addReplyTo($email, $nombre);      
        $mail->setFrom($email, $nombre);

        $mail->AddAttachment( $_FILES['bolsa-trabajo_cv']['tmp_name'], $_FILES['bolsa-trabajo_cv']['name'] );
        
 		// Envio del email
		if (!$mail->send()){

			$url = $url_redirect . "?s=no&e=".$mail->ErrorInfo;

		} else {

			$url = $url_redirect . "?s=ok";

		}

	}

	header('Location: ' . $url);
	exit;


?>