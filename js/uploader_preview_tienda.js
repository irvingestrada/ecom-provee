function template_image(id,src,exist){
	var r = 0;
	if($("#"+id).length == 0) {
		var template = '<li style="margin-top:5px;margin-bottom:5px;"><div class="preview">'+
                    '<span class="imageHolder">'+
                        '<img id="'+id+'" src="'+src+'" width="20%" />'+
                    '</span>'+
                '</div></li>'; 
    	$("#preview-images").append(template); 
    	r = 1;
	}
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
			var t = template_image("preview-image",e.target.result);
			if (t==0){
				$('#preview-image').hide();
            	$('#preview-image').attr('src', e.target.result);
            	$('#preview-image').show();
            }
            //contador_imagenes++;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

