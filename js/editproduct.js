
$("#product_size").val($("#product_current_size").val());

$("#chk-size-chica").blur(function() {
	if ($("#chk-size-chica").val()>=1){
		$("#size-chica").attr("checked","checked");
	}else{
		$("#size-chica").removeAttr( "checked" );
	}
	var s = ($("#chk-size-chica").val() >=1) ? $("#chk-size-chica").val() : 0;	
	var m = ($("#chk-size-mediana").val() >= 1) ? $("#chk-size-mediana").val() : 0;	
	var l = ($("#chk-size-grande").val() >=1) ? $("#chk-size-grande").val() : 0;
	var total = parseInt(s) + parseInt(m) + parseInt(l);
	$("#product_quantity").val(total);
});

$("#chk-size-mediana").blur(function() {
	if ($("#chk-size-mediana").val()>=1){
		$("#size-mediana").attr("checked","checked");
	}else{
		$("#size-mediana").removeAttr( "checked" );
	}
	var s = $("#chk-size-chica").val() > 1 ? $("#chk-size-chica").val() : 0;	
	var m = $("#chk-size-mediana").val() > 1 ? $("#chk-size-mediana").val() : 0;	
	var l = $("#chk-size-grande").val() > 1 ? $("#chk-size-grande").val() : 0;
	var total = parseInt(s) + parseInt(m) + parseInt(l);
	$("#product_quantity").val(total);
});

$("#chk-size-grande").blur(function() {
	if ($("#chk-size-grande").val()>=1){
		$("#size-grande").attr("checked","checked");
	}else{
		$("#size-grande").removeAttr( "checked" );
	}
	var s = $("#chk-size-chica").val() > 1 ? $("#chk-size-chica").val() : 0;	
	var m = $("#chk-size-mediana").val() > 1 ? $("#chk-size-mediana").val() : 0;	
	var l = $("#chk-size-grande").val() > 1 ? $("#chk-size-grande").val() : 0;
	var total = parseInt(s) + parseInt(m) + parseInt(l);
	$("#product_quantity").val(total);
});

$("#product_size option").filter(function() {
    //may want to use $.trim in here
    if ($(this).val() == $("#product_size_selected").val()){
    	if ($("#product_size_selected").val()=="4"){
    		$("#form-tallas-group").hide();
    	}else{
    		$("#form-tallas-group").show();	
    	}
    	
    }
    return $(this).val() == $("#product_size_selected").val(); 
}).prop('selected', true);