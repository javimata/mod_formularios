<?php
date_default_timezone_set("America/Mexico_City");

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ) . '');

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');
require_once (JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php');


function enviar_gracias($titulo_email,$email){

define('ruta','http://www.homeprice.com.mx/');
define('empresa','Dress For Home SAPI de C.V.');

define('ruta_facebook','https://www.facebook.com/dressforhome');
define('ruta_twitter','https://twitter.com/dressforhome');
define('ruta_google','https://plus.google.com/u/1/105728745873695170918/posts');

//if ($producto) { $donde = " AND id= " .$producto ; }
$db=JFactory::getDBO();
$sql = 'SELECT * FROM #__catalogo WHERE state=1 ORDER BY RAND() LIMIT 2';
$db->setQuery( $sql );
$productos = $db->loadObjectList();


$template_email = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>'.utf8_decode($titulo_email).'</title>
  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  .header {padding: 20px 20px 0 20px;}
  .innerpadding {padding: 30px 30px 30px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
  .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold;}
  .button a {color: #ffffff; text-decoration: none; font-weight:400; display:block; padding: 0 30px 0 30px;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}
  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }
  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col350 {width: 340px!important;}
    }*/
  </style>
</head>

<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td bgcolor="#f1f1f1" class="header">
          <table width="550" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
              <td width="250" height="107" style="padding: 0 0 20px 0;">
                <a href="'.ruta.'">
                  <img class="fix" src="'.ruta.'/images/logo.png" width="243" height="107" border="0" alt="" />
                </a>
              </td>

              <td height="107" style="padding: 0 20px 20px 0;">
                  <table>
                    <tr>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_facebook.'">
                        <img src="'.ruta.'images/ico_facebook_footer.png" width="28" height="26" alt="Facebook" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_twitter.'">
                        <img src="'.ruta.'images/ico_twitter_footer.png" width="28" height="26" alt="Twitter" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_google.'">
                        <img src="'.ruta.'images/ico_googleplus_footer.png" width="28" height="26" alt="Google+" border="0" />
                      </a>
                    </td>
                  </tr>
                </table>
              </td>

            </tr>
          </table>

        </td>
      </tr>
      <tr>
        <td bgcolor="#9fd1d2" align="center">

          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center">
              <h3>Atenci&oacute;n a clientes <strong>(01-55) 5292-4602 / 5292-4659</strong></h3>
              </td>
            </tr>
           </table>

        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="h2">
                Gracias por registrarte a nuestro boletin de Promociones!
              </td>
            </tr>
            <tr>
              <td class="bodycopy">
                Recibir&aacute;s con anticipaci&oacute;n todas nuestras ofertas!<br><br>
                Nos vemos en Home Price!
              </td>
            </tr>
          </table>
        </td>
      </tr>';

if (count($productos)):

  foreach($productos as $producto){

    $imagen_producto = $producto->imagen_descripcion;
    $titulo_producto = $producto->title;
    $descri_producto = $producto->introtext;

      $template_email .='<tr>
        <td class="innerpadding borderbottom">
          <table width="145" align="left" border="0" cellpadding="0" cellspacing="0">  
            <tr>
              <td height="145" style="padding: 0 10px 20px 0;">
                <img class="fix" src="'. ruta . $imagen_producto .'" width="145" height="auto" border="0" alt="" />
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
            <table width="340" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="col350" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 340px;">  
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="bodycopy">
                      <h2>'.utf8_decode($titulo_producto).'</h2>
                      '. utf8_decode($descri_producto) .'
                    </td>
                  </tr>
                  <tr>
                    <td style="padding: 20px 0 0 0;">
                      <table class="buttonwrapper" bgcolor="#f47020" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="button" height="45">
                            <a href="'.ruta.'">Ir a nuestro sitio!</a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
          </table>
          <![endif]-->
        </td>
      </tr>';

  };

endif;

      $template_email .='<tr>
        <td class="innerpadding borderbottom">
          <a href="'.ruta.'">
          <img class="fix" src="'.ruta.'images/slider/slider_casa.jpg" width="100%" border="0" alt="" />
          </a>
        </td>
      </tr>
      <tr>
        <td class="innerpadding bodycopy">
          Tel&eacute;fono de atenci&oacute;n a clientes <strong>(01-55) 5292-4602 / 5292-4659</strong><br>
          E-mail: <strong>info@homeprice.com.mx</strong>
        </td>
      </tr>
      <tr>
        <td class="footer" bgcolor="#9fd1d2">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="footercopy">
                &reg; ' . empresa . " " . date('Y') . '
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_facebook.'">
                        <img src="'.ruta.'images/ico_facebook_footer.png" width="28" height="26" alt="Facebook" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_twitter.'">
                        <img src="'.ruta.'images/ico_twitter_footer.png" width="28" height="26" alt="Twitter" border="0" />
                      </a>
                    </td>
                    <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="'.ruta_google.'">
                        <img src="'.ruta.'images/ico_googleplus_footer.png" width="28" height="26" alt="Google+" border="0" />
                      </a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>
</body>
</html>';



/*
define("DEFCALLBACKMAIL", "no-reply@".$_SERVER['SERVER_NAME']); // WIll be shown as "from".
$final_msg = preparehtmlmail($template_email); // give a function your html*

mail('javimata@gmail.com', $subject, $final_msg['multipart'], $final_msg['headers']); 
// send email with all images from html attached to letter


function preparehtmlmail($html) {

  preg_match_all('~<img.*?src=.([\/.a-z0-9:_-]+).*?>~si',$html,$matches);
  $i = 0;
  $paths = array();

  foreach ($matches[1] as $img) {
    $img_old = $img;

    if(strpos($img, "http://") == false) {
      $uri = parse_url($img);
      $paths[$i]['path'] = $_SERVER['DOCUMENT_ROOT'].$uri['path'];
      $content_id = md5($img);
      $html = str_replace($img_old,'cid:'.$content_id,$html);
      $paths[$i++]['cid'] = $content_id;
    }
  }

  $boundary = "--".md5(uniqid(time()));
  $headers .= "MIME-Version: 1.0\n";
  $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
  $headers .= "From: ".DEFCALLBACKMAIL."\r\n";
  $multipart = '';
  $multipart .= "--$boundary\n";
  $kod = 'utf-8';
  $multipart .= "Content-Type: text/html; charset=$kod\n";
  $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n";
  $multipart .= "$html\n\n";

  foreach ($paths as $path) {
    if(file_exists($path['path']))
      $fp = fopen($path['path'],"r");
      if (!$fp)  {
        return false;
      }

    $imagetype = substr(strrchr($path['path'], '.' ),1);
    $file = fread($fp, filesize($path['path']));
    fclose($fp);

    $message_part = "";

    switch ($imagetype) {
      case 'png':
      case 'PNG':
            $message_part .= "Content-Type: image/png";
            break;
      case 'jpg':
      case 'jpeg':
      case 'JPG':
      case 'JPEG':
            $message_part .= "Content-Type: image/jpeg";
            break;
      case 'gif':
      case 'GIF':
            $message_part .= "Content-Type: image/gif";
            break;
    }

    $message_part .= "; file_name = \"$path\"\n";
    $message_part .= 'Content-ID: <'.$path['cid'].">\n";
    $message_part .= "Content-Transfer-Encoding: base64\n";
    $message_part .= "Content-Disposition: inline; filename = \"".basename($path['path'])."\"\n\n";
    $message_part .= chunk_split(base64_encode($file))."\n";
    $multipart .= "--$boundary\n".$message_part."\n";

  }

  $multipart .= "--$boundary--\n";
  return array('multipart' => $multipart, 'headers' => $headers);  
}
*/




//echo $template_email;

    $email_from   = "no-reply@".$_SERVER['SERVER_NAME'];

    // HEADERS ANTI-SPAM
    $headers .= "Organization: Home Price\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . ">"."\r\n";
    $headers .= "X-Mailer: PHP v". phpversion() ."\r\n";
    $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR']."\r\n";

    $headers .= "From: ".utf8_decode($titulo_email)." < $email_from >\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    mail($email, utf8_decode($titulo_email), $template_email, $headers);

}




