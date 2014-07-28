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

	if ($("#conekta_privada").val()=="" || $("#conekta_publica").val()=="" || $("#conekta_privada").val().length!=20 || $("#conekta_publica").val().length!=20){
		bootbox.alert("La informacion proporcionada no es correcta, favor de verificar.", function() { 
			if (longitud_privada!=20){
				$("#conekta_privada").focus();
			}
			if (longitud_publica!=20){
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
//