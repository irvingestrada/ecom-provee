<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#seo" role="tab" data-toggle="tab">SEO</a></li>
  <li><a href="#payment" role="tab" data-toggle="tab">Medio de Pago</a></li>
  <li><a href="#packages" role="tab" data-toggle="tab">Paquetes</a></li>
  <li><a href="#orders" role="tab" data-toggle="tab">Listado de Pagos</a></li>
  <li><a href="#cerrar" role="tab" data-toggle="tab">Cierre</a></li>
</ul>

<br/>
<div class="tab-content">
  <div class="tab-pane active" id="seo">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modseo.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="update_meta_title" class="col-sm-2 control-label">Meta-titulo:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_title" name="update_meta_title" placeholder="" value="<?php echo $marketplace_seller_info["shop_name"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Meta description:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_description" name="update_meta_description" placeholder="" value="<?php echo $marketplace_seller_info["about_shop"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_keywords" class="col-sm-2 control-label">Meta palabras clave:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_keywords" name="update_meta_keywords" placeholder="" value="<?php echo $marketplace_seller_info["seller_name"]; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="submit" class="btn btn-default center">Actualizar</button>
	    </div>
	  </div>
	</form>	
  </div>
  
  <div class="tab-pane" id="payment">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modseo.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="update_meta_title" class="col-sm-2 control-label">Meta-titulo:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_title" name="update_meta_title" placeholder="" value="<?php echo $marketplace_seller_info["shop_name"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Meta description:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_description" name="update_meta_description" placeholder="" value="<?php echo $marketplace_seller_info["about_shop"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_keywords" class="col-sm-2 control-label">Meta palabras clave:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_keywords" name="update_meta_keywords" placeholder="" value="<?php echo $marketplace_seller_info["seller_name"]; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="submit" class="btn btn-default center">Actualizar</button>
	    </div>
	  </div>
	</form>
  </div>
  
  <div class="tab-pane" id="packages">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modseo.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="update_meta_title" class="col-sm-2 control-label">Meta-titulo:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_title" name="update_meta_title" placeholder="" value="<?php echo $marketplace_seller_info["shop_name"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Meta description:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_description" name="update_meta_description" placeholder="" value="<?php echo $marketplace_seller_info["about_shop"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_keywords" class="col-sm-2 control-label">Meta palabras clave:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_keywords" name="update_meta_keywords" placeholder="" value="<?php echo $marketplace_seller_info["seller_name"]; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="submit" class="btn btn-default center">Actualizar</button>
	    </div>
	  </div>
	</form>
  </div>
  
  <div class="tab-pane" id="orders">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modseo.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="update_meta_title" class="col-sm-2 control-label">Meta-titulo:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_title" name="update_meta_title" placeholder="" value="<?php echo $marketplace_seller_info["shop_name"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Meta description:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_description" name="update_meta_description" placeholder="" value="<?php echo $marketplace_seller_info["about_shop"]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_keywords" class="col-sm-2 control-label">Meta palabras clave:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_keywords" name="update_meta_keywords" placeholder="" value="<?php echo $marketplace_seller_info["seller_name"]; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="submit" class="btn btn-default center">Actualizar</button>
	    </div>
	  </div>
	</form>
  </div>

  <div class="tab-pane" id="cerrar">
  	<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="button" onclick="fnCerrarTienda(); return false;" class="btn btn-default center">Cerrar Tienda</button>
	    </div>
	  </div>
	</form>
  </div>


</div>
<script type="text/javascript">
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
</script>