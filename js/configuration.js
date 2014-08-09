$("#paquetesform").submit(function() {
	if ($("#paquetes").val()=="" || $("#paquetes").val()==0){
		bootbox.alert("Ocupas seleccionar un paquete en el combo.", function() { 
			$("#paquetes").focus();
		});
		return false;
	}else{
		return true;
	}
});

$("#conektaform").submit(function() {
	var longitud_privada = $.trim($("#conekta_privada").val().length);
	var longitud_publica = $.trim($("#conekta_publica").val().length);

	if ($("#conekta_privada").val()=="" || $("#conekta_publica").val()=="" || $("#conekta_privada").val().length<20 || $("#conekta_publica").val().length<=20){
		bootbox.alert("La informacion de las llaves no es correcta, no cumple con el minimo de dígitos, favor de verificar.", function() { 
			if (longitud_privada<20){
				$("#conekta_privada").focus();
			}
			if (longitud_publica<20){
				$("#conekta_publica").focus();
			}
		});
		return false;
	}else{
		if ($("#conekta_privada").val().substring(0,4)!="key_"){
			bootbox.alert("La llave privada no tiene el formato correcto", function() { 
				$("#conekta_privada").focus();			
			});
			return false;
		}else if ($("#conekta_publica").val().substring(0,4)!="key_"){
			bootbox.alert("La llave publica no tiene el formato correcto", function() { 
				$("#conekta_publica").focus();			
			});
			return false;
		}else{
			return true;	
		}
	}
});


$( "#passwordform" ).submit(function( event ) {
  event.preventDefault();

  

  if ($("#currentpassword").val()=="" || $("#newpassword").val()=="" || $("#confirmpassword").val()==""){
  		bootbox.alert("Los campos de contraseña no pueden quedar vacios.", function() { 
			if ($("#currentpassword").val()==""){
				$("#currentpassword").focus(5000);
			}
			if ($("#newpassword").val()==""){
				$("#newpassword").focus();
			}
			if ($("#confirmpassword").val()==""){
				$("#confirmpassword").focus();
			}
		});
  		return false;
  }
  if ($("#newpassword").val()!=$("#confirmpassword").val()){
  	bootbox.alert("La nueva contraseña y la confirmación de contraseña no son iguales, favor de revisar.", function() { 
  		$("#newpassword").focus();
  	});
  	return false;
  }
  	$.ajax({
		type: 	'POST',
		url:	'/scripts/validar_password.php',
		async: 	false,
		data: 	'password='+$("#currentpassword").val(),
		cache: 	false,
		success: function(data){
		
			var json= $.parseJSON(data);
			if (json.status=="ok"){
				if (json.error != ""){
					bootbox.alert(json.error, function() { 
						
					});	
					return false;
				}else{
					var $form;
  					$form = $("#passwordform");
					$form.get(0).submit();
					return true;
				}
				
			}else if (json.status==-1){
				bootbox.alert("Error al consultar servicio", function() { });
				return false;
			}
		}
	});
  	return true;
  
});

$('.alert-danger').on('focus', function () {
	$('.alert-danger').hide();
});

function fnCerrarTienda(){
	bootbox.confirm("¿Estas seguro de cerrar la tienda, se perderan todos tus productos?", function(result) {
		if (result){
			$.ajax({
				type: 	'POST',
				url:	'/scripts/cerrar_tienda.php',
				async: 	true,
				data: 	'confirm=1',
				cache: 	false,
				success: function(data)
				{
					
					var json= $.parseJSON(data);
					if (json.status==1){
						bootbox.alert("La tienda fue cerrada, esperamos verte pronto.", function() { 
							window.location.href="/scripts/logout.php";	
						});
					}else if (json.status==-1){
						bootbox.alert("Error al cerrar la tienda", function() { });
					}
				}
			});	
		}

	});

}