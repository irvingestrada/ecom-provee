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

$("#tarjetaform").submit(function(event) {
		var $form;
		$form = $(this);
		$form.find("button").prop("disabled", true);
		Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
		return false;
});

  var conektaSuccessResponseHandler;
  conektaSuccessResponseHandler = function(token) {
  	var $form;
  	$form = $("#tarjetaform");
  	$form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));
 	$form.get(0).submit();
  };

  var conektaErrorResponseHandler;
  conektaErrorResponseHandler = function(response) {
  	var $form;
  	$form = $("#tarjetaform");
  	$form.find(".card-errors").text(response.message);
  	$form.find("button").prop("disabled", false);
  };

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

function fKeyPress(e,tipo){
	//FUNCION PARA VALIDAR CAMPOS
	var evt = (e) ? e : event
	var dKey = (evt.which) ? evt.which : evt.keyCode;
	if(dKey==13) return;

	switch(tipo){
		case "NP": //Numeros - Acepta �nicamente numeros
			var arreglo="0123456789.";
			if(dKey==8 || dKey==9)return; //Permite pulsacion de Backspace y Tab
			break;
		case "N": //Numeros - Acepta �nicamente numeros
			var arreglo="0123456789";
			if(dKey==8 || dKey==9)return; //Permite pulsacion de Backspace y Tab
			break;
		case "F": //Fecha - Acepta �nicamente numeros y Diagonal
			var arreglo="0123456789/";
			if(dKey==8)return; //Permite pulsacion de Backspace y Tab
			break;
		case "A": //Alfanumerico - Acepta alfanumerico
			var arreglo='ABCDEFGHIJGKLMN�OPQRSTUVWXYZabcdefghijklmn�opqrstuvwxyz0123456789 ';
			if(dKey==8 || dKey==9 || dKey==44 || dKey==45 || dKey==46)return; //Permite pulsacion de Backspace, Tab, Coma, Punto y Guion
			break;
		case "S": //Alfabetico - Acepta letras y signos especificos
			var arreglo="A�BCDE�FGHI�JGKLMN�O�PQRSTU�VWXYZa�bcde�fghi�jklmn�o�pqrstu�vwxyz,.-/ ";	
			if(dKey==8 || dKey==9 || dKey==44 || dKey==45 || dKey==46)return; //Permite pulsacion de Backspace, Tab, Coma, Punto y Guion
			break;
		case "L": //ABC - Acepta �nicamente letras y espacio
			var arreglo="ABCDEFGHIJGKLMN�OPQRSTUVWXYZabcdefghijklmn�opqrstuvwxyz ";
			if(dKey==8 || dKey==9)return; //Permite pulsacion de Backspace y Tab
			break;
		case "R": //Alfabetico - Acepta letras y numeros
			var arreglo="ABCDEFGHIJGKLMNOPQRSTUVWXYZabcdefghijklmn�opqrstuvwxyz1234567890,.-/ ";	
			if(dKey==8 || dKey==9 || dKey==44 || dKey==45 || dKey==46)return; //Permite pulsacion de Backspace, Tab, Coma, Punto y Guion
			break;
		case "D": //Alfabetico - Acepta letras y numeros
			var arreglo=" ABCDEFGHIJGKLMNOPQRSTUVWXYZabcdefghijklmn�opqrstuvwxyz1234567890";	
			if(dKey==8 || dKey==9 || dKey==44 || dKey==45 || dKey==46)return; //Permite pulsacion de Backspace, Tab, Coma, Punto y Guion
			break;
	}

	if (document.all) { //IE
		if(arreglo.indexOf(String.fromCharCode(dKey),0)!=-1){ event.returnValue = true;	}
		else{ event.returnValue = false; }
	}else { //Mozilla
		if(arreglo.indexOf(String.fromCharCode(dKey),0)==-1){ if (e.cancelable) { e.preventDefault(); }	}
	}
}

$('#alert_message').show(0).delay(3400).hide(0);