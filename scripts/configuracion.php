<?php
	$market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
	$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");
	$categoria = new Category($market_place_seller_info["id_category"]);

	$pay_mode = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode`");
	
	$obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);

	loadjs('js/configuration.js');
?>

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
	      <input type="text" class="form-control" id="update_meta_title" name="update_meta_title" placeholder="" value="<?php echo $categoria->meta_title[2]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Meta description:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_description" name="update_meta_description" placeholder="" value="<?php echo $categoria->meta_description[2]; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_keywords" class="col-sm-2 control-label">Meta palabras clave:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="update_meta_keywords" name="update_meta_keywords" placeholder="" value="<?php echo $categoria->meta_keywords[2]; ?>" required>
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
  	<form class="form-horizontal" role="form" action="/scripts/proc_modconekta.php" method="post" enctype="multipart/form-data" id="conektaform">
	  <div class="form-group">
	    <label for="conekta_privada" class="col-sm-2 control-label">Clave Privada:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="conekta_privada" name="conekta_privada" placeholder="" value="<?php echo $obj_seller->conekta_privada; ?>" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="conekta_publica" class="col-sm-2 control-label">Clave Publica:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="conekta_publica" name="conekta_publica" placeholder="" value="<?php echo $obj_seller->conekta_publica; ?>" required>
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
  	<form class="form-horizontal" role="form" action="/scripts/proc_modpaquetes.php" method="post" enctype="multipart/form-data" id="paquetesform">
	  <div class="form-group">
	    <label for="paquetes" class="col-sm-2 control-label">Paquetes:</label>
	    <div class="col-sm-10">
	    	<select id="paquetes" name="paquetes">
	    		<option value="0">Paquetes</option>
	      <?php 
	      $paquete_actual = "";
	      foreach ($pay_mode as $key) {
	      		if ($obj_seller->paquete_comprado==$key["id"]){
	      			$paquete_actual = $key["payment_mode"];
	      		}
	      		echo '<option value="'.$key["id"].'">'.$key["payment_mode"].'</option>';
	      }
	      ?>
	      	</select>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Paquete actual:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="paquete_actual" name="paquete_actual" placeholder="" value="<?php echo $paquete_actual; ?>" readonly>
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