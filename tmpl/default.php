<?php
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
// $document->addStylesheet(JURI::base(true) . "/modules/".$module->module."/css/style.css");
$document->addScript(JURI::base(true) . "/modules/".$module->module."/js/scripts.js");

//URL de procesamiento del envio del form
$link_proceso = JURI::base() . "modules/".$module->module."/bin/process.php";

//Obtiene el valor de ID si el modulo es insertado en sitios internos
$modulo_id      = $module->id;
$module_attribs = $attribs;

//Obtener parametros
$titulo                 = $params->get("titulo");
$texto                  = $params->get("texto");
$subtexto               = $params->get("subtexto");
$texto_btn              = $params->get("texto_btn");
$container_btn_class    = $params->get("container_btn_class");
$btn_class              = $params->get("btn_class");
$imagen                 = $params->get("imagen");
$UsaJQuery              = $params->get("UsaJQuery",0);
$texto_btn              = $params->get("texto_btn");
$className              = $params->get("className");
$idName                 = $params->get("idName");
$texto_aviso            = $params->get("texto_aviso");
$texto_requerido		= $params->get("texto_requerido","*");
$link_aviso             = $params->get("link_aviso");
$header_tag             = $params->get("header","h3");
$descargar_archivo      = $params->get("descargar_archivo",0);
$requiere_aviso         = $params->get("requiere_aviso",0);
$agrega_captcha			= $params->get("agrega_captcha",0);
$muestra_error          = $params->get("muestra_error",0);
$fields_container_class = $params->get("fields_container_class");
$verifica_cookie        = $params->get("verifica_cookie",0);
$integra_analytics		= $params->get("integra_analytics",0);
$analytics_categoria    = $params->get("analytics_categoria");
$analytics_accion		= $params->get("analytics_accion");
$analytics_etiqueta     = $params->get("analytics_etiqueta");

//Agrega jQuery al header, no verifica si ya fue agregado
if($UsaJQuery==1){
	$document->addScript("http://code.jquery.com/jquery-1.9.1.js");
}

// Si se agrega Captcha agrega scripts necesarios
if ( $agrega_captcha == 1 ) {
	$document->addScript("https://www.google.com/recaptcha/api.js");	
}

//CAMPOS
$tipo_etiqueta= $params->get("tipo_etiqueta");

//Agregar script para placeholder
if( $tipo_etiqueta==2 || $tipo_etiqueta==3 ){
	$document->addScript(JURI::base(true) . "/modules/".$module->module."/js/placeholders.min.js");
}

// obtener seccion o sitio actual
$app     			= JFactory::getApplication();
$menu 	 			= $app->getMenu();
$seccion 			= $menu->getActive()->title;


// Checa si exiten atributos para el nombre del producto y sustituye el shortcode
if ( isset($attribs['producto']) && $attribs['producto'] ) {
	$producto = $attribs['producto'];
} else {
	$producto = $seccion;
}

//Cambio de tags
$arreglo_cambia 	= array("[PRODUCTO]","[CATEGORIA]","[","]");
$arreglo_cambia_por = array("<span>".$producto."</span>","<span>".$seccion."</span>","<",">");

$titulo_form 		= str_replace($arreglo_cambia,$arreglo_cambia_por,$titulo);
$texto       		= str_replace($arreglo_cambia,$arreglo_cambia_por,$texto);
$subtexto    		= str_replace($arreglo_cambia,$arreglo_cambia_por,$subtexto);
$texto_aviso 		= str_replace($arreglo_cambia,$arreglo_cambia_por,$texto_aviso);
$texto_btn   		= str_replace($arreglo_cambia,$arreglo_cambia_por,$texto_btn);


// Checa si se debe descargar un archivo
if ( $descargar_archivo == 1 ) {
	
	$urlArchivo = ( $params->get("url_file") != "" ? $params->get("url_file") : 'images/'.$params->get("archivo_descargable") );

}

// Crea nombre de Cookie
if ( $verifica_cookie == 1 && $urlArchivo != "" ) {

	$cookie_name = md5($modulo_id);

} else {

	$cookie_name = "";

}


echo "<div class='".$className."' id='".$idName."'>";

	echo "<div class='contenido_form'>";


	// Checa cookie, si existe se muestra el enlace para la descarga del archivo
	if( (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == 1) && $urlArchivo != "" ):

		echo "<div class='header-form'>\n";
		echo "<div class='titulo'><$header_tag>".$titulo_form."</$header_tag></div>"."\n";

		if ( $params->get("texto_descarga") != "" ){
			echo "<div class='texto'>".$params->get("texto_descarga")."</div>"."\n";
		}

		$textoBoton = ( $params->get("texto_btn_descarga") != "" ? $params->get("texto_btn_descarga") : JText::_('MOD_FORMULARIOS_FIELD_TEXT_BTN_DOWNLOAD_VALUE') );

		echo '<a href="'.$urlArchivo.'" class="btn btn-primary btn-full">'.$textoBoton.'</a>';
		echo "</div>\n";

	else: // Muestra el formulario si no se ha llenado (verificado con cookie)

		//Agrega imagen seleccionada
		if ($imagen) { echo "<div class='imagen_boletin'><img src='". JURI::BASE() . $imagen ."'></div>"; }

		echo "<form action='".$link_proceso."' name='form_".$className."' role='form' id='form_".$idName."' data-id='".$idName."' ";

		// Verifica si requiere captcha
		if( $agrega_captcha == 1 && JPluginHelper::isEnabled('captcha', 'recaptcha') == true ):
			echo "data-captcha=1 ";
		endif;

		// Verifica si se debe agregar seguimiento de Analytics
		if ( $integra_analytics == 1 ) :
			echo "data-analytics='1' ";

			if ($analytics_categoria) { echo "data-analytics-category='".$analytics_categoria."' "; }
			if ($analytics_accion) { echo "data-analytics-action='".$analytics_accion."' "; }
			if ($analytics_etiqueta) { echo "data-analytics-label='".$analytics_etiqueta."' "; }

		endif;
		
		echo ">"."\n";
		echo "<div id='caja_resultado_".$idName."'>"."\n";

		if ( $titulo_form != "" || $texto != "" ):
		echo "<div class='header-form'>\n";
		echo "<div class='titulo'><$header_tag>".$titulo_form."</$header_tag></div>"."\n";

		//Agrega texto
		if ($texto) { echo "<div class='texto'>".$texto."</div>"."\n" ;}

		if ($subtexto) { echo "<div class='subtexto'>".$subtexto."</div>"."\n" ;}

		echo "</div>\n";
		endif;

		echo "<div class='box-campos $fields_container_class'>";
		// recorrido de campos
		foreach ($campos as $campo) {
			$cada        = explode("|", $campo);
			$nombre      = $cada[0];
			$tipo        = $cada[1];
			$valor       = $cada[2];
			$class       = $cada[3];
			$obliga      = (int)$cada[4];
			if (isset($cada[5])):
				$placeholder = $cada[5];
			else:
				$placeholder = "";
			endif;

			if (isset($cada[6])):
				$errMsg = $cada[6];
			else:
				$errMsg = "";
			endif;

			// Limpia el nombre del campo
			$campoId     = JFilterOutput::stringURLSafe($nombre);
			$campoId     = str_replace("-", "_", $campoId);

			$clases = explode(",",$class);
			$clase  = $clases[0];

			if (!$placeholder) { $placeholder = $nombre; }

			$muestra_obliga = "";
			if ($obliga == 1) {
				$muestra_obliga = "required"; 
				$placeholder = $placeholder . " " . $texto_requerido;
			}

			$placeholder = str_replace($arreglo_cambia,$arreglo_cambia_por,$placeholder);

			if ( $tipo == "text" || $tipo == "email" || $tipo == "date" || $tipo == "time" ):

				echo "<div class='form-group ".$clase."'>";

				if ($tipo_etiqueta==1 || $tipo_etiqueta==3):
					echo "<label for='".$idName."_$campoId'>$placeholder";
					echo "</label>";
				endif;

				echo "<input type='$tipo' class='form-control'";
				if ( $errMsg != "" ){
					echo " data-error='$errMsg' ";
				}
				echo "name='".$idName."_$campoId' id='".$idName."_$campoId' ";
				if($tipo_etiqueta==2 || $tipo_etiqueta==3){
					echo " placeholder='$placeholder'";
				}

				if($valor!=""){
					echo " value='$valor'";
				}

				echo $muestra_obliga;

				echo "></div>"."\n";

			//Si el tipo de campo es textarea
			elseif ($tipo=="textarea"):

				echo "<div class='form-group ".$clase."'>";

				if ($tipo_etiqueta==1 || $tipo_etiqueta==3){
					echo "<label for='".$idName."_$campoId'>$placeholder</label>\n";
				}

				echo "<$tipo class='form-control' name='".$idName."_$campoId' id='".$idName."_$campoId' ";
				if($tipo_etiqueta==2 || $tipo_etiqueta==3){
					echo " placeholder='$placeholder'";
				}
				if ( $errMsg != "" ){
					echo " data-error='$errMsg' ";
				}

				echo $muestra_obliga;

				echo ">";
				if($valor!=""){
					echo " value='$valor'";
				}

				echo "</$tipo></div>"."\n";


			/**
			* Si el tipo de campo es select
			* Agrega las opciones en valor separadas por comas
			* Agrega como valor del option el texto limpio, sin espacios
			*/
			elseif ($tipo=="select"):

				echo "<div class='form-group ".$clase."'>";

				if ($tipo_etiqueta==1 || $tipo_etiqueta==3){
					echo "<label for='".$idName."_$campoId'>$placeholder</label>\n";
				}

				echo "<select class='form-control'";

				if ( $errMsg != "" ){
					echo " data-error='$errMsg' ";
				}

				echo " name='".$idName."_$campoId' id='".$idName."_$campoId'>"."\n";
				echo "<option value=''>";
				
				if ($tipo_etiqueta==2):
					echo $placeholder;
				else:
					echo JTEXT::_("JGLOBAL_SELECT_AN_OPTION");
				endif;
				echo "</option>"."\n";

				// Obtiene el valor de las opciones del campo valor separado por comas (,)
				$posVal = strrpos($valor, ",");
				if ($posVal === false) {
					if ($valor!=""):
					echo "<option value='".JFilterOutput::stringURLSafe($valor)."'>$valor</option>"."\n";
					endif;

				}else{
					$valores = explode(",", $valor);
					foreach ($valores as $valor_select) {
						echo "<option value='".$valor_select."'>$valor_select</option>"."\n";
					}			
				}

				echo "</select>"."\n";
				echo "</div>"."\n";



			/**
			* Si el tipo de campo es estado 
			* Se agregan los estados automaticamente como un select
			*/
			elseif ( $tipo == "estados" ):
				$estados = "Aguascalientes,Baja California,Baja California Sur,Campeche,Chiapas,Chihuahua,Coahuila,Colima,Durango,Estado de México,Guanajuato,Guerrero,Hidalgo,Jalisco,Michoacán,Morelos,Nayarit,Nuevo León,Oaxaca,Puebla,Querétaro,Quintana Roo,San Luis Potosí,Sinaloa,Sonora,Tabasco,Tamaulipas,Tlaxcala,Veracruz,Yucatán,Zacatecas";

				echo "<div class='form-group ".$clase."'>";

				if ($tipo_etiqueta==1 || $tipo_etiqueta==3){
					echo "<label for='".$idName."_$campoId'>$placeholder</label>\n";
				}

				echo "<select class='form-control' name='".$idName."_$campoId' id='".$idName."_$campoId'";

				if ( $errMsg != "" ){
					echo " data-error='$errMsg' ";
				}

				echo ">"."\n";
				echo "<option value=''>";

				if ($tipo_etiqueta==2):
					echo $placeholder;
				else:
					echo JTEXT::_("JGLOBAL_SELECT_AN_OPTION");
				endif;
				echo "</option>"."\n";

				// Obtiene el valor de las opciones del campo valor separado por comas (,)
				$valores = explode(",", $estados);
				foreach ($valores as $valor_select) {
					echo "<option value='".$valor_select."'>$valor_select</option>"."\n";
				}

				echo "</select>"."\n";
				echo "</div>"."\n";


			/**
			* Si el tipo de campo es component
			* Agrega las opciones en valor separadas por comas
			* Agrega como valor del option el texto limpio, sin espacios
			*/
			elseif ($tipo=="component"):

				$valores = explode(":", $valor);
				$valor_component = $valores[0];
				$valor_categoria = $valores[1];
				$valor_orden     = $valores[2];
				$sql = "";

				if ( $valor_component!="" ):

					$dbm=JFactory::getDBO();

					if ( $valor_component == "k2" ){
						$componente = "k2_items";
						$catfield   = "catid";
						$published  = "published";
						$orden      = "ordering";
						$idItem     = JRequest::getInt('id');

						if ( $valor_orden !="" ){ $orden = $valor_orden; }
						if ( $valor_categoria ){ $whereCat = " AND ".$catfield.'='.$valor_categoria; }
						$sql = 'SELECT * FROM #__'.$componente.' WHERE ( publish_down = "0000-00-00 00:00:00" OR publish_down >= NOW() ) AND '.$published.' = 1 '.$whereCat.' ORDER BY ' . $orden . ' ASC';

					}elseif ($valor_component == "content"){
						$componente = "content";
						$catfield   = "catid"; 
						$published  = "state";
						$orden      = "state";
						$idItem     = JRequest::getInt('id');

					}elseif ($valor_component == "contacts"){
						$componente = "contact_details";
						$catfield   = "catid"; 
						$published  = "published";
						$orden      = "ordering";
						$field      = 'name';

					}elseif ($valor_component == "categorias"){
						$componente = "categories";
						$catfield   = "parent_id";
						$published  = "published";
						$orden      = "lft";
						$field      = "title";

						if ( $valor_orden !="" ){ $orden = $valor_orden; }
						if ( $valor_categoria ){ $whereCat = " AND ".$catfield.'='.$valor_categoria; }
						$sql = 'SELECT * FROM #__'.$componente.' WHERE '.$published.' = 1 '.$whereCat.' ORDER BY ' . $orden . ' ASC';

					};

					if ( $sql == "" ):

						if ( $valor_orden !="" ){
							$orden = $valor_orden;
						}

						if ( $valor_categoria ){
							$whereCat = " AND ".$catfield.'='.$valor_categoria;
						}

						$sql = 'SELECT * FROM #__'.$componente.' WHERE '.$published.' = 1 '.$whereCat.' ORDER BY ' . $orden . ' ASC';
					endif;
					$dbm->setQuery( $sql );
					$lista = $dbm->loadObjectList(); 

				endif;

				echo "<div class='form-group ".$clase."'>";

				if ($tipo_etiqueta==1 || $tipo_etiqueta==3){
					echo "<label for='".$idName."_$campoId'>$placeholder</label>";
				}

				echo "<select class='form-control' name='".$idName."_$campoId' id='".$idName."_$campoId'";

				if ( $errMsg != "" ){
					echo " data-error='$errMsg' ";
				}

				echo ">"."\n";
				echo "<option value=''>";
				
				if ($tipo_etiqueta==2):
					echo $placeholder;
				else:
					echo JTEXT::_("JGLOBAL_SELECT_AN_OPTION");
				endif;
				echo "</option>"."\n";

				foreach ($lista as $valor_select) {
					if ( $field == "name" ){
						$title_show = $valor_select->name;
					}else{
						$title_show = $valor_select->title;
					}

					if ( $idItem == $valor_select->id ) { $actualItem = "selected"; } else { $actualItem = ""; }

					echo "<option value='".$title_show."' $actualItem>".$title_show."</option>"."\n";
				}
			
				echo "</select>"."\n";
				echo "</div>"."\n";


			/**
			* Si el tipo de campo es checkbox
			* Agrega las opciones en valor separadas por comas
			* Agrega como valor del option el texto limpio, sin espacios
			*/
			elseif ($tipo=="checkbox"):

				$valores = explode(",", $valor);

				echo "<div class='form-group ".$clase."'>";

				echo $placeholder . "<br>";
				foreach ( $valores as $valor ):

					echo "<div class='checkbox ".$clases[1]."'>";
					echo "<label for='".JFilterOutput::stringURLSafe($nombre).$valor."'>";
					echo "<input type='checkbox' value='".JFilterOutput::stringURLSafe($valor)."' id='".JFilterOutput::stringURLSafe($nombre).$valor."' name='".$idName."_$nombre'>";
					echo $valor . "</label></div>";


				endforeach;

				echo "</div>";




			/**
			* Si el tipo de campo es radio
			* Agrega las opciones en valor separadas por comas
			* Agrega como valor del option el texto limpio, sin espacios
			*/
			elseif ($tipo=="radio"):

				$valores = explode(",", $valor);

				echo "<div class='form-group ".$clase."'>";

				echo $placeholder . "<br>";
				foreach ( $valores as $valor ):

					echo "<div class='radio-inline'>";
					echo "<label for='".JFilterOutput::stringURLSafe($nombre).$valor."'>";
					echo "<input type='radio' value='".JFilterOutput::stringURLSafe($valor)."' id='".JFilterOutput::stringURLSafe($nombre).$valor."' name='".$idName."_$nombre'>";
					echo $valor . "</label></div>";


				endforeach;
				echo "</div>";




			/**
			* Si el tipo de campo es title
			* El valor se toma como la etiqueta que contendra el titulo
			*/
			elseif ($tipo=="title"):

				( $valor != "" ) ? $tag = $valor : $tag = "p";

				echo "<div class='title-section ".$clase."'>";

				echo "<" . $tag . " class='form-title'>" . $placeholder . "</" . $tag . ">";

				echo "</div>";


			/**
			* Si el tipo de campo es hidden
			*/
			elseif ($tipo=="hidden"):

				echo "<input type='$tipo' name='".$idName."_$campoId' id='".$idName."_$campoId' ";

				if($valor!=""){

					if ( $valor == "userid" ){

						$user       = JFactory::getUser();
						$valor     = $user->get('id');

					}elseif ( $valor == "username" ){

						$user       = JFactory::getUser();
						$valor     = $user->get('name');

					}elseif ( $valor == "useruser" ){

						$user       = JFactory::getUser();
						$valor     = $user->get('username');

					}
					echo " value='$valor'";
				}

				echo ">"."\n";


			/**
			* Tipo de campo Boton (El boton Submit se agrega automaticamente)	
			*/
			elseif( $tipo == "boton" ):

				echo "<div class='form-group ".$clase."'>";
				echo "<button type='button' class='btn btn-".$valor."'>".$placeholder."</button>\n";	
				echo "</div>"."\n";

			endif;
		}


		/*
		* Agrega reCaptcha, debe estar activo el plugin Captcha - ReCaptcha y con las claves necesarias
		*/
		if ( $agrega_captcha == 1 && JPluginHelper::isEnabled('captcha', 'recaptcha') == true ) {

			$container_captcha_class = $params->get("container_captcha_class");

			echo "<div class='captcha_container ".$container_captcha_class."'>";
			$pcaptcha = JPluginHelper::getPlugin('captcha', 'recaptcha');
			$pcaptchaParams = new JRegistry($pcaptcha->params);

			echo "<div class='g-recaptcha'";
			echo " data-sitekey='" . $pcaptchaParams->get('public_key','') . "'";
			echo " data-theme='" . $pcaptchaParams->get('theme2', 'light') . "'";
			echo " data-size='" . $pcaptchaParams->get('size', 'normal') . "'";
			echo ">";
			echo "</div>";
			echo "</div>";

		}


		echo "<div class='form-group ".$container_btn_class."'>";
		echo "<div class='loading'><span class=\"fa fa-spinner fa-spin\"></span></div>";
		echo "<input type='hidden' name='module_id' value='".$modulo_id."' id='".$idName."_form_modulo'>"."\n";

		if ($seccion!=""){
			echo "<input type='hidden' name='area' value='".$seccion."' id='".$idName."_form_area'>"."\n";
		}

		echo "<div class='btn_container'>";
		echo "<button class='btn btn_".$idName." " . $btn_class. "' id='btn_id_".$idName."' type='submit'>".$texto_btn."</button>";
		echo "</div>";

		echo "</div>";

		if ($requiere_aviso==1):
		echo "<div class='checkbox checkbox-aviso'><label><input type='checkbox'>"; 
			if ($link_aviso!="") { echo "<a href='$link_aviso'>"; }
		echo $texto_aviso;
			if ($link_aviso!="") { echo "</a>"; }
		echo "</label></div>";
		endif;

		if ($muestra_error==1):
		echo "<div class='". $idName ."_form_error'></div>\n";
		endif;

		echo "</div>";

		if ($descargar_archivo==1):
			echo "<div class='link-descarga'><a href='#' class='btn btn-primary btn-full' target='_blank'>Descargar folleto</a></div>";
		endif;


		echo "</div>";
		echo "</form>";

	endif;

	echo "</div>"."\n";

echo "</div>";
