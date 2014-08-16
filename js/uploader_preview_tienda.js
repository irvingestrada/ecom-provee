function template_image(id,src){
	var r = 0;
	//if($("#"+id).length == 0) {
		var template = '<li style="margin-top:5px;margin-bottom:5px;text-decoration:none;list-style-type: none;"><div class="preview">'+
                    '<span class="imageHolder">'+
                        '<img id="Prev_'+id+'" src="" width="20%" />'+
                    '</span>'+
                '</div></li>'; 
    	$("#"+id).html(template); 
    	r = 1;
	//}
    return r;
}


var contador_imagenes=1;

$("document").ready(function(){
	$('input[type=file]').change(function () {
	    readURL(this);
	});

    
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var t;
            if (input.id=="update_shop_logo"){
			     t = template_image("preview-images",e.target.result);
            }else{
                t = template_image("preview-images-banner",e.target.result);
            }
			if (t==1){
                if (input.id=="update_shop_logo"){
				   $('#Prev_preview-images').hide();
            	   $('#Prev_preview-images').attr('src', e.target.result);
            	   $('#Prev_preview-images').show();
                }else{
                   $('#Prev_preview-images-banner').hide();
                   $('#Prev_preview-images-banner').attr('src', e.target.result);
                   $('#Prev_preview-images-banner').show();
                }

            }
            //contador_imagenes++;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

