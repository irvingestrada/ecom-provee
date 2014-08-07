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
					console.log(data);
					
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