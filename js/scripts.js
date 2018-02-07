(function($)
{

	$(document).ready(function () {


		$("#form_contacto-home").on("submit",function(e){
			e.preventDefault();

			var url         = $(this).attr("action");
			var id          = $(this).attr("data-id");
			var caja_error  = "." + id + "_form_error";
			var analyticsAd = $(this).attr("data-analytics");
			var errores     = 0;

			if ( analyticsAd == 1 ) {

				var analyticsCat = $(this).attr("data-analytics-category");
				var analyticsAct = $(this).attr("data-analytics-action");
				var analyticsLab = $(this).attr("data-analytics-label");

			}

			var dataCaptcha = $(this).attr("data-captcha");
			
			var fnombre      = $('#' + id + '_nombre').val();
			var femail       = $('#' + id + '_email').val();
			var ftelefono    = $('#' + id + '_telefono').val();
			var fciudad      = $('#' + id + '_ciudad').val();
			var fcomentarios = $('#' + id + '_comentarios').val();


			$('label i',this).remove();
			$(caja_error).empty();
			$('input',this).removeClass('resalta');

			// Verifica si se debe checar el Captcha
			if ( dataCaptcha == 1 ){

				var get_captcha_response = grecaptcha.getResponse();
	            if (get_captcha_response.length == 0) {
	            	$(caja_error).empty().prepend("<span class=\"fa fa-exclamation-triangle\"></span> Tenemos la ligera sospecha de que no eres un robot, pero debemos confirmarlo :-D");
	            	errores = 1;
	            }

			}

			if ( errores != 1 ) {

				$("#" + id + " .loading").show();

				var fmodule 	= $('#' + id + '_form_modulo').val();
				var farea 		= $('#' + id + '_form_area').val();
				
				$("input", this).removeClass('resalta');

				$.post( url , {
					nombre:fnombre,
					email:femail,
					telefono:ftelefono,
					ciudad:fciudad,
					comentarios:fcomentarios,
					module_id:fmodule,
					area:farea,
					seccion:1
					},
					function(data){
					if (parseInt(data.respuesta)==1){

						$("#" + id + " .loading").hide();
						// $("#" + id + " .texto").hide();
						// $("#" + id + " #caja_resultado_" + id).animate({opacity:1}).empty().append(data.texto_respuesta);
						$("#" + id + " #caja_resultado_" + id).addClass("ok").animate({opacity:1});
						// $("#" + id + " #caja_resultado_" + id).animate({opacity:1}).empty().append(data.texto_respuesta);
						alert(data.texto_respuesta);
						$("#form_contacto-home")[0].reset();

						if ( analyticsAd == 1 ){

							ga('send', 'event', analyticsCat, analyticsAct, analyticsLab);

						}

					}else{

						$("#" + id + " #btn_id_" + id).show();
						$("#" + id + " #caja_resultado_" + id).animate({opacity:1});
						$("#" + id + " .loading").hide();
						alert(data.texto_respuesta+data.respuesta);

					}
				},"json");

			}

		});



	});

})(jQuery);
