<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/core.php";
	if (!defined('_PS_VERSION_'))
	exit;

	$obj_mp_seller = new SellerInfoDetail();
	$obj_mp_customer = new MarketplaceCustomer();

	$seller_active = $obj_mp_seller->isStoreActiveByCustomerId($_SESSION["id_customer"]);
	$already_request = $obj_mp_customer->findMarketPlaceCustomer($_SESSION["id_customer"]);

	$marketplace_seller_id   = $already_request['marketplace_seller_id'];
					
	$marketplace_seller_info = $obj_mp_seller->sellerDetail($marketplace_seller_id);

	$logo_path = BAZARINGA_WWWPATH._MODULE_DIR_. 'marketplace/img/shop_img/'.$marketplace_seller_id . '-' . $marketplace_seller_info['shop_name'] . '.jpg';

	loadjs('js/uploader_preview_tienda.js');

?>
<style>
	#product_image
	{
	  visibility: hidden;
	  width: 0;
	  height: 0;
	}
	.fileSelect
	{
		/*
	  -moz-border-bottom-colors: none;
	    -moz-border-left-colors: none;
	    -moz-border-right-colors: none;
	    -moz-border-top-colors: none;
		background: none repeat scroll 0 0 #FFCC00;
	    border-color: #FFCC00 #FFCC00 #9F9F9F;
	    border-image: none;
	    border-radius: 2px 2px 2px 2px;
	    border-style: solid;
	    border-width: 1px;
	    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
	    color: #08233E;
	    cursor: pointer;
	    padding: 4px;
	    text-shadow: 0 1px #FFFFFF;
	    */
	}
	.fileSelect:hover:before {
	  /*border-color: black;*/
	}
	.fileSelect:active:before {
	  /*background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);*/
	}
	.list_content li span a {
	    color: #000000 !important;
	}

</style>
<?php 
   if (isset($_REQUEST["error_msg"])){
 	if ($_REQUEST["error_msg"]=="prod_name"){ ?>
	<div class="alert alert-danger" role="alert">
		el campo nombre del producto es requerido
	</div>
<?php }else if ($_REQUEST["error_msg"]=="prod_desc"){ ?>
	<div class="alert alert-danger" role="alert">
		el campo descripción del producto es requerido
	</div>
<?php }else if ($_REQUEST["error_msg"]=="prod_price"){ ?>
	<div class="alert alert-danger" role="alert">
		el campo precio es requerido
	</div>
<?php }else if ($_REQUEST["error_msg"]=="prod_qty"){ ?>
	<div class="alert alert-danger" role="alert">
		el campo cantidad es requerido
	</div>
<?php }else if ($_REQUEST["error_msg"]=="prod_size"){ ?>
	<div class="alert alert-danger" role="alert">
		el campo talla es requerido
	</div>
<?php }} ?>
<form class="form-horizontal" role="form" action="/scripts/proc_modtienda.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="update_shop_name" class="col-sm-2 control-label">Nombre de la tienda:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="update_shop_name" name="update_shop_name" placeholder="" value="<?php echo $marketplace_seller_info["shop_name"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="update_about_shop" class="col-sm-2 control-label">Descripción de la tienda:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="update_about_shop" name="update_about_shop" placeholder="" value="<?php echo $marketplace_seller_info["about_shop"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="update_seller_name" class="col-sm-2 control-label">Nombre del proveedor:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="update_seller_name" name="update_seller_name" placeholder="" value="<?php echo $marketplace_seller_info["seller_name"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="update_phone" class="col-sm-2 control-label">Telefono:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="update_phone" name="update_phone" placeholder="" value="<?php echo $marketplace_seller_info["phone"]; ?>" onkeypress="fKeyPress(event,'N');" required pattern="[0-9]*">
    </div>
  </div>
  <div class="form-group">
    <label for="update_address" class="col-sm-2 control-label">Dirección:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="update_address" name="update_address"><?php echo $marketplace_seller_info["address"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="update_business_email" class="col-sm-2 control-label">Email:</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="update_business_email" name="update_business_email" placeholder="" value="<?php echo $marketplace_seller_info["business_email"]; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="update_polenvio" class="col-sm-2 control-label">Politica de envio:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="update_polenvio" name="update_polenvio"><?php echo $marketplace_seller_info["politica_envio"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="update_poldevol" class="col-sm-2 control-label">Politica de devoluciones:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="update_poldevol" name="update_poldevol"><?php echo $marketplace_seller_info["politica_devolucion"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="update_polgaran" class="col-sm-2 control-label">Politica de garantia:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="update_polgaran" name="update_polgaran" ><?php echo $marketplace_seller_info["politica_garantia"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="update_infoadic" class="col-sm-2 control-label">Información adicional:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="update_infoadic" name="update_infoadic"><?php echo $marketplace_seller_info['informacion_adicional'];?></textarea>
    </div>
  </div>
  <div class="form-group">
  	<label for="product_size" class="col-sm-2 control-label">Logo:</label>
  	<div class="col-sm-10">
		<!--<button class="btn btn-warning btn-large fileSelect" name="product_image" style="	">Subir Imagen</button>
		-->
		<!--<input class="btn btn-warning btn-large" type="file" name="update_shop_logo" id="update_shop_logo"/>-->
		<?php
			if (isset($logo_path)){
				?><img src="<?php echo $logo_path;?>" alt="<?php echo $marketplace_seller_info['shop_name']; ?>" width="200" height="200"><?php
			}
		?>
		<input class="required" type="file" name="update_shop_logo" id="update_shop_logo" style="display:none;"/>
		<button id="fileSelect" name="update_shop_logo" class="btn btn-warning btn-large">Subir Logo</button>
		<div class="info_description" style="margin-left:146px;text-align: center;">Logo Size Must Be 200*200</div>

		<!--<a href="javascript:;" onclick="showOtherImage();">
			<button class="btn btn-warning btn-large fileSelect"><i class="icon-white icon-heart"></i> Agregar otra imagen</button>
		</a>-->


		<div id="otherimages" style="margin-left:0px;"> </div>
	</div>

	<div id="preview-images" >
	</div>
	
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      	<button type="submit" class="btn btn-default center">Actualizar tienda</button>
    </div>
  </div>
</form>	
<script language="javascript" type="text/javascript">

document.querySelector('#fileSelect').addEventListener('click', function(e) {
	e.preventDefault();
  	// Use the native click() of the file input.
  	document.querySelector('#update_shop_logo').click();
}, false);

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

</script>

<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>


