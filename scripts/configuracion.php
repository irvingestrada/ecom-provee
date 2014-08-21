<?php
	

	$market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
	$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");
	$categoria = new Category($market_place_seller_info["id_category"]);

	$pay_mode = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode`");

	$pagos = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_pagos_proveedor` where id_seller =" . $market_seller_id['marketplace_seller_id']);
	
	$obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);

	loadjs('js/configuration.js');

	require_once(_PS_MODULE_DIR_.'conektapagos/lib/Conekta.php');

	//Conekta::setApiKey($market_place_seller_info["conekta_privada"]);
	Conekta::setApiKey(_CONEKTA_PRIVATE_KEY_);

	try{

		$customer = Conekta_Customer::find($obj_seller->customer_token);

	}catch (Conekta_Error $e){
	    $error_cobro = 1;   	
		echo $e->getMessage();
	}
?>
<?php 
if (isset($_GET["error_msg"])){?>
	<div class="alert alert-danger" role="alert">
		<?php 
			switch ($_GET["error_msg"]) {
				case 'newpassword_syntax':
					echo "La contraseña nueva proporcionada no cumple con el formato de contraseña.";
				break;
				case 'currentpassword_syntax':
					echo "La contraseña actual proporcionada no cumple con el formato de contraseña.";
				break;
				case 'currentpassword_value':
					echo "La contraseña actual proporcionada no es la correcta.";
				break;
				
			}				

		?>
	</div>

<?php }
if (isset($_SESSION["mensaje_ajax"])){?>
	<div class="alert alert-success" role="alert" id="alert_message">
		<?php echo $_SESSION["mensaje_ajax"]; ?>
	</div>
<?php } ?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <!--<li class="active"><a href="#seo" role="tab" data-toggle="tab">SEO</a></li>-->
  <li><a href="#payment" role="tab" data-toggle="tab">Medio de Pago</a></li>
  <li><a href="#packages" role="tab" data-toggle="tab">Paquetes</a></li>
  <li><a href="#tarjeta" role="tab" data-toggle="tab">Cambiar Tarjeta</a></li>
  <li><a href="#tabcontrasena" role="tab" data-toggle="tab">Cambiar Contraseña</a></li>
  <li><a href="#cerrar" role="tab" data-toggle="tab">Cierre</a></li>

</ul>

<br/>
<div class="tab-content">
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
	    	<input type="hidden" value="<?php echo $obj_seller->paquete_comprado; ?>" id="paquete_actual_hidden">
	    	<select id="paquetes" name="paquetes" onchange="fnchangepaquete(this.value);">
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

	      	<div style="float: right; position: absolute; width: 200px; left: 345px; border: 2px solid; border-top-left-radius: 8px; border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; padding-left: 13px; padding-right: 13px;padding-top: 0px; box-shadow: rgb(136, 136, 136) 10px 10px 5px;margin-top: -18px;display:none;" id="paquete_caja">
				<span id="paquete_title" style="display: block; background: rgb(153, 255, 204);margin-top: 5px;border: 0px solid; border-top-left-radius: 8px; border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px;text-align: center;font-weight: bold;">Texti</span>
				<span id="paquete_precio"></span>
				<p id="paquete_descripcion"></p>
			</div>

	    </div>
	  </div>
	  <div class="form-group">
	    <label for="update_meta_description" class="col-sm-2 control-label">Paquete actual:</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="paquete_actual" name="paquete_actual" placeholder="" value="<?php echo $paquete_actual; ?>" readonly style="width:300px">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      	<button type="submit" class="btn btn-default center">Actualizar</button>
	    </div>
	  </div>
	</form>

  </div>
  <div class="tab-pane" id="tarjeta">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modtarjeta.php" method="post" enctype="multipart/form-data" id="tarjetaform">
	 	<div class="form-group">
			<label for="update_meta_description" class="col-sm-3 control-label">
				Tarjeta actual
            </label>
		 	<div class="col-sm-4">
				Tarjeta: <?php echo $customer->cards[0]->last4; ?> Tipo Tarjeta: <?php echo $customer->cards[0]->brand; ?>
         	</div>
		 	<span class="card-errors"></span>
		</div>
		<div class="form-group">
			<label for="update_meta_description" class="col-sm-3 control-label">
				Nombre del tarjetahabiente
            </label>
		 	<div class="col-sm-4">
				<input class="reg_sel_input" data-conekta="card[name]" type="text" name="cardname" id="cardname"/>
         	</div>
		 	<span class="card-errors"></span>
		</div>
		<div class="form-group">
			<label for="update_meta_description" class="col-sm-3 control-label">
					Número de tarjeta de crédito/debito
			</label>
			<div class="col-sm-4">
	      		<input type="text" size="20" data-conekta="card[number]" class="account_input" id="cardnumber" name="cardnumber" fnkeypress="fKeyPress(event,'N');" />
		    </div>
		</div>
	  	<div class="form-group">
			<label for="update_meta_description" class="col-sm-3 control-label">
	      			Código de seguridad - CVC
	      	</label>
	      	<div class="col-sm-4">
	      		<input type="text" data-conekta="card[cvc]" placeholder='' class="account_input" id="cardcvc" name="cardcvc" fnkeypress="fKeyPress(event,'N');" maxlength="3" size="3" style="width:4em !important;" />
    		</div>
		</div>
		<div class="form-group">
			<label for="update_meta_description" class="col-sm-3 control-label">
	      		Fecha de vencimiento (MM/AAAA)<sup>*</sup>
		    </label>
	      	<div class="col-sm-4">
    	  		<input type="text" data-conekta="card[exp_month]" placeholder='' class="account_input" id="cardexpmonth" name="cardexpmonth" fnkeypress="fKeyPress(event,'N');" style="width:4em !important;" maxlength="2" size="2" />
      			<span>/</span>
      			<input type="text" data-conekta="card[exp_year]" placeholder='' class="account_input" id="cardexpyear" name="cardexpyear" fnkeypress="fKeyPress(event,'N');" style="width:8em !important;" maxlength="4" size="4" />
	    	</div>
		</div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      	<button type="submit" class="btn btn-default center">Actualizar</button>
		    </div>
	  </div>	
	</form>
  </div>  

  <div class="tab-pane" id="tabcontrasena">
  	<form class="form-horizontal" role="form" action="/scripts/proc_modpassword.php" method="post" id="passwordform">
	 	<div class="form-group">
			<label for="currentpassword" class="col-sm-2 control-label">
				Contraseña actual
            </label>
		 	<div class="col-sm-10">
				<input class="reg_sel_input" type="password" name="currentpassword" id="currentpassword"/>
         	</div>
		</div>
		<div class="form-group">
			<label for="newpassword" class="col-sm-2 control-label">
					Nueva contraseña
			</label>
			<div class="col-sm-10">
	      		<input type="password" size="20" class="account_input" id="newpassword" name="newpassword"/>
		    </div>
		</div>
	  	<div class="form-group">
			<label for="update_meta_description" class="col-sm-2 control-label">
	      			Confirmar contraseña
	      	</label>
	      	<div class="col-sm-10">
	      		<input type="password" class="account_input" id="confirmpassword" name="confirmpassword"/>
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

var data_paquetes = <?php echo json_encode($pay_mode); ?>;
var simple_paquetes;

function fnchangepaquete(id){
	if (id!="0"){
		var actual = parseInt($("#paquete_actual_hidden").val());
		var nId = parseInt(id);
		if (nId>=actual){
			var t = eval(data_paquetes);
			$.each(t, function (key, data) {
			    if (data.id == id){
			    	$("#paquete_caja").css("background-color","white");
			    	$("#paquete_title").html(data.payment_mode);
			    	$("#paquete_descripcion").html(data.paquete_descripcion);
			    	$("#paquete_descripcion").css("font-size","1em");
			    	$("#paquete_precio").html("Costo $"+data.costo);
			    	$("#paquete_title").css("background",data.color);
			    	$("#paquete_caja").show();
			    }
			});	
		}else{
			bootbox.alert("El paquete que seleccionas es menor al que tienes actualmente, ¿estas seguro?.", function() { 
				$("#paquetes").focus();
			});
		}
		
	}else{
		$("#paquete_caja").hide();
	}
}


</script>
<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.0/js/conekta.js"></script>

<script type="text/javascript">
  // Conekta Public Key
  Conekta.setPublishableKey('<?php echo _CONEKTA_PUBLIC_KEY_; ?>');
  
</script>

<?php
	if (isset($_SESSION["mensaje_ajax"])){
		unset($_SESSION["mensaje_ajax"]);
	}
?>