<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

date_default_timezone_set("America/Monterrey");

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ) . '');

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
//require_once (JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php');

//$template = JFactory::getApplication()->getTemplate(true)->params;
$config      = JFactory::getConfig();
$nombreSitio = $config->get( 'sitename' );
$emailAdmin  = $config->get( 'mailfrom' );

//create application
$mainframe = JFactory::getApplication('site');
$db        = JFactory::getDbo();
$servidor  = str_replace("www.","",$_SERVER['SERVER_NAME']);

$modulo_id = $_REQUEST["module_id"];

// Agregar fecha
$fecha = date('d-m-Y H:i:s');

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

	//Datos para TEST
	$modoTest		= $params->modoTest;
	$email_test     = $params->email_test;

	$envia_gracias			= $params->enviar_gracias;
	$titulo_email_gracias 	= $params->titulo_email_gracias;
	$mailchimp 				= $params->mailchimp;
	$mailchimp_key			= $params->mailchimp_key;
	$mailchimp_id_list		= $params->mailchimp_id_list;

	if ($mailchimp==1 && $modoTest==0){
		require_once ('Mailchimp.php');
		$MailChimp = new \Drewm\MailChimp($mailchimp_key);
	}

	if ($params->descargar_archivo==1){
		$archivo_descargable = JPATH_BASE . "/images/" . $params->archivo_descargable;
		$verifica_cookie     = $params->verifica_cookie;
		$archivo_descarga    = ( $params->url_file != "" ? $params->url_file : 'images/'.$params->archivo_descargable );

		if ($archivo_descarga != "" ){
			$archivo = 1;
			//$archivo_descarga = $urlArchivo;
		}else{
			$archivo = 2;
		}

	}else {
		$archivo = 0;
	}

}

	$seccion = $_REQUEST["seccion"];
	if ( !$seccion ){ $seccion=1; }

	if ( $seccion == 1 && ($_REQUEST["email"] != "" && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) ){

        $campos_lista = $params->campo_nombre;

        if ($campos_lista){

            $campos = explode(PHP_EOL, $campos_lista);

        }

        $body = "";
        foreach ($campos as $campo) {

			$cada 		= explode("|", $campo);
			$nombre 	= $cada[0];
			$tipo		= $cada[1];
			$valor  	= $cada[2];
			$clase  	= $cada[3];
			$obliga 	= (int)$cada[4];

			if (isset($cada[5])):
				$placeholder = $cada[5];
			else:
				$placeholder = "";
			endif;

			$campoId	= JFilterOutput::stringURLSafe($nombre);
			$campoId    = str_replace("-", "_", $campoId);

			if (!$placeholder) { $placeholder = $nombre; }

			if ( $tipo !== "title" ){

				$body .= "<strong>".$placeholder.": </strong> " . $_REQUEST[$campoId] . "<br>"; 

			};

        }
        $body .= "<strong>Area: </strong> " . $_REQUEST["area"] . "<br>";
        $body .= "<strong>Fecha: </strong> " . $fecha;

		// $datos_mailchimp = array('FNAME'=>$nombre, 'PHONE'=>$telefono);

	}

	if ( $enviar == 1 || $email_test != "" && ($_REQUEST["email"] != "" && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) ){

		$mailer = JFactory::getMailer();
		$sender = array( $emailAdmin, $nombreSitio );
		$mailer->setSender( $sender );
		// $recipient = $_REQUEST["email"];

		if ($modoTest==0){
		
			$email_from = "no-reply@".$servidor;
			$to         = $email_envio;

			if ($_REQUEST["nombre"]){
				$fromNombre = $_REQUEST["nombre"];
			}else{
				$fromNombre = "Envio desde " . $nombreSitio;
			}

		}else{

			$email_from = $email_test;
			$to         = $email_test;
			$fromNombre = "Envio de prueba";

		}

		// Configura los To, CC & BCC
		$to = str_replace(" ", "", $to);
		$to_send = explode(",",str_replace(" ", "", $to));
		foreach ($to_send as $send) {
			$mailer->addRecipient( $send );
		}

		if( $cc != "" ) { 
			$cc = str_replace(" ", "", $cc);
			$to_cc = explode(",",str_replace(" ", "", $cc));
			foreach ($to_cc as $tocc) {
				$mailer->addCc( $tocc );
			}
		}

		if( $bcc != "" ) { 
			$bcc = str_replace(" ", "", $bcc);
			$to_bcc = explode(",",str_replace(" ", "", $bcc));
			foreach ($to_bcc as $tobcc) {
				$mailer->addBcc( $tobcc );
			}
		}

		//Agrega subject
		if($titulo_email){
			$subject = $titulo_email;
		}else{
			$subject = "Envio desde " . $nombreSitio;
		}

		$mailer->addReplyTo($_REQUEST["email"]);
		$mailer->setSubject($subject);
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);


		// Envio del email
		$send = $mailer->Send();
		if ( $send !== true ) {

			$responder = 2;
			$texto_respuesta = $texto_error . "\n" . $recipient . "\n" . $mailer->ErrorInfo;

		} else {

			$responder = 1;
			$texto_respuesta = $texto_ok;

			// Crea Cookie
			$cookie_name = md5($modulo_id);
			if ( $params->verifica_cookie == 1 && !isset($_COOKIE[$cookie_name]) ) {
				
				if ( $params->texto_descarga != "" ) { $texto_respuesta = $params->texto_descarga; }
				setcookie($cookie_name, 1, time()+300, "/","",0);

			}

			if ($envia_gracias==1){
				include_once ("template.php");
				$titulo_gracias = $titulo_email_gracias;
				$email_gracias	= $email;
				enviar_gracias($titulo_gracias,$email_gracias);
			}

		}
		
	}else{
		$responder = 3;
		$texto_respuesta = "No se ha enviado el correo" . $enviar ;
	};



	if ($responder == 1 && $mailchimp==1){

		$result = $MailChimp->call('lists/subscribe', array(
		                'id'                => $mailchimp_id_list,
		                'email'             => array('email'=>$_REQUEST["email"]),
		                'merge_vars'        => $datos_mailchimp, //array('FNAME'=>'JAM', 'LNAME'=>'Jones'),
		                'double_optin'      => false,
		                'update_existing'   => true,
		                'replace_interests' => false,
		                'send_welcome'      => false,
		            ));
		//print_r($result);

		if ($result["status"]=="error"){
			// echo "Error";
			$mailchimp_respuesta = "Error " . $result["code"] . " " . $result["name"] . " " . $result["error"];
			$subject_mailchimp 	 = "Error en envio a MailChimp - " . $nombreSitio;

			$email_from = "no-reply@".$servidor;
			$fecha = date('Y-m-d H:i:s');
			$body = "
				Email: $email
				Info: $mailchimp_respuesta
				Fecha: $fecha";

			// HEADERS ANTI-SPAM
			$header  = "";
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$header  = "Reply-To: ".$email."\r\n";
			}

			$header .= "MIME-Version: 1.0" . "\r\n";
			$header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$header .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . ">"."\r\n";
			$header .= "X-Mailer: PHP v". phpversion() ."\r\n";
			$header .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR']."\r\n";

			$header .= "From: $subject_mailchimp < $email_from >\r\n";
			$header .= "Content-type: text/plain; charset=iso-8859-1\r\n";

			mail($emailAdmin, $subject_mailchimp, utf8_decode($body), $header);

		}else{
			// echo "OK";
			$mailchimp_respuesta = "Ok";
			$subject_mailchimp = "Envio a MailChimp - " . $nombreSitio;

		}


	}

// Crea array de respuesta
$resp = array(
	'respuesta' => $responder,
	'texto_respuesta' => $texto_respuesta,
	'mailchimp' => $mailchimp,
	'mailchimp_respuesta' => $mailchimp_respuesta,
	'archivo' => $archivo,
	'archivo_descarga' => $archivo_descarga
);

echo json_encode($resp);