<?php

	$obj_marketplace_product = new SellerProductDetail();
	$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($_POST["form_product_id"]);
	$pro_info["price"] = number_format($pro_info["price"],2,'.','');

	$root = Category::getRootCategory();
	$id_lang = 2;
	$category =  Db::getInstance()->ExecuteS("SELECT a.`id_category`,l.`name` from `"._DB_PREFIX_."category` a LEFT  JOIN `"._DB_PREFIX_."category_lang` l  ON (a.`id_category`=l.`id_category`) where a.id_parent=".$root->id." and l.id_lang=".$id_lang." and l.`id_shop`=1 order by a.`id_category`");
		
	$checked_product_cat = $obj_marketplace_product->getMarketPlaceProductCategories($id);
	$obj_seller_product_category = new SellerProductCategory();

	$tree = "<ul id='tree1'>";
	$tree .= "<li><input type='checkbox'";
	if($checked_product_cat){     					//For old products which have uploded
		foreach($checked_product_cat as $product_cat){
			if($product_cat['id_category'] == $root->id)
				$tree .= "checked";
		}
	}
	else{
		if($defaultcatid == $root->id)
			$tree .= "checked";
	}
	$tree .= " name='product_category[]' value='".$root->id."'><label>".$root->name."</label>";
	$depth = 1;
	$top_level_on = 1;
	$exclude = array();
	array_push($exclude, 0);
	
	loadjs('js/editproduct.js');

	foreach($category as $cat) {
		$goOn = 1;             
		$tree .= "<ul>" ;
		 for($x = 0; $x < count($exclude); $x++ )   
		 {
			  if ( $exclude[$x] == $cat['id_category'] )
			  {
				   $goOn = 0;
				   break;                   
			  }
		 }
		 if ( $goOn == 1 )
		 {
			$tree .= "<li><input type='checkbox'";
			if($checked_product_cat){       					//For old products which have uploded
				foreach($checked_product_cat as $product_cat){
					if($product_cat['id_category'] == $cat['id_category'])
						$tree .= "checked";
				}
			}
			else{
				if($defaultcatid == $cat['id_category'])
					$tree .= "checked";
			}
			$tree .= " name='product_category[]' value='".$cat['id_category']."'><label>".$cat['name']."</label>";  
			
			array_push($exclude, $cat['id_category']);          
				/*if ( $cat['id_category'] < 6 )
				{ $top_level_on = $cat['id_category']; } */
			$tree .= $obj_seller_product_category->buildChildCategoryRecursive($cat['id_category'],$id_lang,$checked_product_cat);        
		 }
		 $tree .= "</ul>";
	}
?>
<style>
.nota{
		font-size: 10px;
		font-style: italic;
	}
</style>
<form class="form-horizontal" role="form" action="/scripts/proc_editproduct.php" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?php echo $pro_info["id_size"]; ?>" id="product_current_size" name="product_current_size">
  <input type="hidden" value="<?php echo $_POST["form_product_id"]; ?>" id="product_id" name="product_id">
  <div class="form-group">
    <label for="product_name" class="col-sm-2 control-label">Nombre del producto:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nombre producto" value="<?php echo $pro_info["product_name"]; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="product_description" class="col-sm-2 control-label">Descripción del producto:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="product_description" name="product_description" ><?php echo $pro_info["description"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="product_price" class="col-sm-2 control-label">Precio:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Precio" value="<?php echo $pro_info["price"]; ?>" onkeypress="fKeyPress(event,'NP');" required>
    </div>
  </div>
  <div class="form-group">
    <label for="product_quantity" class="col-sm-2 control-label">Cantidad:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="" value="<?php echo $pro_info["quantity"]; ?>" onkeypress="fKeyPress(event,'N');" required pattern="[0-9]*">
    </div>
  </div>
  <div class="form-group">
    <label for="product_costo_envio" class="col-sm-2 control-label">Costo de envio:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_costo_envio" name="product_costo_envio" placeholder="" value="<?php echo $pro_info["costo_envio"]; ?>" onkeypress="fKeyPress(event,'NP');" required>
    </div>
  </div>
  <?php

  	$obj_mp_shopproduct = new MarketplaceShopProduct();
  	$id_product_info = $obj_mp_shopproduct->findMainProductIdByMppId($_POST["form_product_id"]);
  	$id_product = $id_product_info['id_product'];
  	$product = new Product($id_product);


	$attributes = $product->getAttributesResume(2);
	if (empty($attributes))
		$attributes[] = array(
			'id_product_attribute' => 0,
			'attribute_designation' => ''
		);
	
	// Get available quantities
	$available_quantity = array();
	$product_designation = array();
	$arreglo_tallas = array();
	foreach ($attributes as $attribute)
	{

		$available_quantity[$attribute['id_product_attribute']] = StockAvailable::getQuantityAvailableByProduct((int)$product->id,
																												$attribute['id_product_attribute']);

		if ($attribute['attribute_designation']=='Size - S'){
			$arreglo_tallas['S'] = array('id' => $attribute['id_product_attribute'], 'cantidad' => $available_quantity[$attribute['id_product_attribute']]);
		}else if ($attribute['attribute_designation']=='Size - M'){
			$arreglo_tallas['M'] = array('id' => $attribute['id_product_attribute'], 'cantidad' => $available_quantity[$attribute['id_product_attribute']]);
		}else if ($attribute['attribute_designation']=='Size - L'){
			$arreglo_tallas['L'] = array('id' => $attribute['id_product_attribute'], 'cantidad' => $available_quantity[$attribute['id_product_attribute']]);
		}
		// Get available quantity for the current product attribute in the current shop
		
		// Get all product designation
		$product_designation[$attribute['id_product_attribute']] = rtrim(
			$product->name[2].' - '.$attribute['attribute_designation'],
			' - '
		);
	}
	//var_dump($arreglo_tallas);
	$haytallas = count($arreglo_tallas);
  ?>
  <input type="hidden" value="<?php echo $id_product; ?>" id="id_product_gallery">  
  <input type="hidden" value="<?php echo (count($arreglo_tallas)==0) ? '4' : '-1'; ?>" name="product_size_selected" id="product_size_selected" >
  <input type="hidden" name="vsize-chica" id="vsize-chica" value="<?php echo ($arreglo_tallas['S']['id']) ? $arreglo_tallas['S']['id'] : '' ?>">
  <input type="hidden" name="vsize-mediana" id="vsize-mediana" value="<?php echo ($arreglo_tallas['M']['id']) ? $arreglo_tallas['M']['id'] : '' ?>">
  <input type="hidden" name="vsize-grande" id="vsize-grande" value="<?php echo ($arreglo_tallas['L']['id']) ? $arreglo_tallas['L']['id'] : '' ?>">
  <input type="hidden" value="4" name="product_size" id="product_size">
  <?php
  	
	$id_image_detail = $product->getImages($id_lang);

	$product_link_rewrite = Db::getInstance()->getRow("select * from `". _DB_PREFIX_."product_lang` where `id_product`=".$id_product." and `id_lang`=1");
	$name = $product_link_rewrite['link_rewrite'];
	//var_dump($id_image_detail);
	$img_info = array();
	$link = new Link();

	$i = 0;
	foreach($id_image_detail as $id_image_info)
  	{
		$img_info[$i]['id_image'] = $id_image_info['id_image'];
		$ids = $id_product.'-'.$id_image_info['id_image'];
		$img_info[$i]['image_link'] = $link->getImageLink($name,$ids);
		$img_info[$i]['cover'] = $id_image_info['cover'];
		$img_info[$i]['position'] = $id_image_info['position'];?>
		<input type="hidden" name="old_image-<?php echo $i; ?>" value="<?php echo $id_image_info['id_image']; ?>">
		<?php 
		$i++;
  	}

  ?>
<br/>
<center><span class="nota">El tamaño de las imagenes sugerido es de 500px de ancho por 500px de alto.</span></center><br/>
<span id="imagenes_tabla">

</span>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Actualizar</button>
    </div>
  </div>
</form>	
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins : "link image paste pagebreak table contextmenu table code textcolor",
	toolbar1 : "code,|,bold,italic,underline,strikethrough,|,formatselect,|,blockquote,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|",
	toolbar2: "",
	lang : "es",
	theme : "modern",
	menubar : false,
	width: 606

 });

</script>
<script language="javascript" type="text/javascript">

function fnChangeTallaSelect(evento){
	if (evento.value==-1){
		$("#form-tallas-group").show();
		$("#chk-size-chica").focus();
	}else{
		$("#form-tallas-group").hide();
		$("#product_quantity").focus();
	}
}
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