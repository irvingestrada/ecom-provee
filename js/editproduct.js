reload_image($("#id_product_gallery").val());

$("#product_size").val($("#product_current_size").val());

	
function fnChangeCoverImage(id_product,id_image){
     $.ajax({
            type: 'POST',
            url:    '/scripts/changecover.php',
            async: true,
            data: 'id_product=' + id_product + '&id_image='+id_image,
            cache: false,
            success: function(data)
            {
                bootbox.alert("Portada de producto actualizada", function() { 
                    reload_image($("#id_product_gallery").val());
                });
                
            }
        });
}


function deleteImageGallery(id_product, id_image){
    bootbox.confirm("¿Deseas borrar la imagen?", function(result) {
        if (result){
        
            $.ajax({
                type: 'POST',
                url:    '/scripts/deleteproductimage.php',
                async: true,
                data: 'id_image=' + id_image + '&id_pro=' + id_product,
                cache: false,
                success: function(data)
                {
                    reload_image(id_product);
                }
            });
        }
    });
} 

function reload_image(id_product){
    $.ajax({
            type: 'POST',
            url:    '/scripts/reloadimages.php',
            async: false,
            data: 'id_product=' + id_product ,
            cache: false,
            success: function(data)
            {
                $("#imagenes_tabla").html(data);
            }
        });
    $.getScript( "/js/reload_uploader_config.js" )
      .done(function( script, textStatus ) {
      })
      .fail(function( jqxhr, settings, exception ) {
    });

}
