$("#login").submit(function(event){
			event.preventDefault();
			var parametros = new FormData($('#login')[0]);
			$.ajax({
				type:'POST',
				datatype:'json',
				data:parametros,
				url:"functions/PHP_login.php",
				contentType:false,
				processData:false,
				beforeSend:function(objeto){
					$("#datos_ajax").html("Enviando datos....");
				},
				success:function(datos){
					$("#datos_ajax").show();
					var valor = datos.toString();
					var busc =valor.indexOf('Error');
					if(busc != -1){
						$("#datos_ajax").html(datos);
						setTimeout("jQuery('#datos_ajax').hide();",5000);
					}else{
						$("#datos_ajax").html(datos);
					}
				},
				error:function(datos){
					$("#datos_ajax").html(datos);
					setTimeout("jQuery('#datos_ajax').hide();",8000);
				}
			});
		}
		);