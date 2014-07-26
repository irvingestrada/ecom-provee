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
<form class="form-horizontal" role="form" action="/scripts/proc_editproduct.php" method="post">
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
      <input type="text" class="form-control" id="product_description" name="product_description" placeholder="Descripción" value="<?php echo $pro_info["description"]; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="product_price" class="col-sm-2 control-label">Precio:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Precio" value="<?php echo $pro_info["price"]; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="product_quantity" class="col-sm-2 control-label">Cantidad:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="" value="<?php echo $pro_info["quantity"]; ?>" onkeypress="fKeyPress(event,'N');" required pattern="[0-9]*">
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
  <input type="hidden" value="<?php echo (count($arreglo_tallas)==0) ? '4' : '-1'; ?>" name="product_size_selected" id="product_size_selected" >
  <input type="hidden" name="vsize-chica" id="vsize-chica" value="<?php echo ($arreglo_tallas['S']['id']) ? $arreglo_tallas['S']['id'] : '' ?>">
  <input type="hidden" name="vsize-mediana" id="vsize-mediana" value="<?php echo ($arreglo_tallas['M']['id']) ? $arreglo_tallas['M']['id'] : '' ?>">
  <input type="hidden" name="vsize-grande" id="vsize-grande" value="<?php echo ($arreglo_tallas['L']['id']) ? $arreglo_tallas['L']['id'] : '' ?>">
  <div class="form-group">
    <label for="product_size" class="col-sm-2 control-label">Talla:</label>
    <div class="col-sm-10">
		<select id="product_size" name="product_size" style="width:20%;" onchange="fnChangeTallaSelect(this);">
			<option value="0">Seleccionar</option>
			<option value="4" <?php echo (count($arreglo_tallas)==0) ? 'selected' : ''; ?>>Unitalla</option>
			<option value="-1" <?php echo (count($arreglo_tallas)>=1) ? 'selected' : ''; ?>>Especificar</option>
		</select>
    </div>
  </div>
  <div class="form-group" style="display:none;" id="form-tallas-group">
    <div class="col-sm-5" >
    	<table class="table" style="margin-left:140px;">
    	<tr>
    		<th>Talla</th>
    		<th>Cantidad</th>
    	</tr>
    	<tr>
    		<td><input type="checkbox" name="size-chica" id="size-chica" value="<?php echo ($arreglo_tallas['S']['id']) ? $arreglo_tallas['S']['id'] : '' ?>"> Chica</td>
    		<td><input type="number" class="form-control" id="chk-size-chica" name="chk-size-chica" placeholder="" value="<?php echo ($arreglo_tallas['S']['cantidad']) ? $arreglo_tallas['S']['cantidad'] : '' ?>" onkeypress="fKeyPress(event,'N');" pattern="[0-9]*"></td>
    	</tr>
    	<tr>
    		<td><input type="checkbox" name="size-mediana" id="size-mediana" value="<?php echo ($arreglo_tallas['M']['cantidad']) ? $arreglo_tallas['M']['cantidad'] : '' ?>"> Mediana</td>
    		<td><input type="number" class="form-control" id="chk-size-mediana" name="chk-size-mediana" placeholder="" value="<?php echo ($arreglo_tallas['M']['cantidad']) ? $arreglo_tallas['M']['cantidad'] : '' ?>" onkeypress="fKeyPress(event,'N');" pattern="[0-9]*"></td>
    	</tr>
    	<tr>
    		<td><input type="checkbox" name="size-grande" id="size-grande" value="<?php echo ($arreglo_tallas['L']['cantidad']) ? $arreglo_tallas['L']['cantidad'] : '' ?>"> Grande</td>
    		<td><input type="number" class="form-control" id="chk-size-grande" name="chk-size-grande" placeholder="" value="<?php echo ($arreglo_tallas['L']['cantidad']) ? $arreglo_tallas['L']['cantidad'] : '' ?>" onkeypress="fKeyPress(event,'N');" pattern="[0-9]*"></td>
    	</tr>
    	</table>
    </div>
  </div>
  <?php
  	
	$id_image_detail = $product->getImages($id_lang);
	
	$product_link_rewrite = Db::getInstance()->getRow("select * from `". _DB_PREFIX_."product_lang` where `id_product`=".$id_product." and `id_lang`=1");
	$name = $product_link_rewrite['link_rewrite'];
	//var_dump($id_image_detail);
	$img_info = array();
	$link = new Link();
	echo '<div class="container">';
	echo '<div class="row">';
	foreach($id_image_detail as $id_image_info)
  	{
		$img_info[$i]['id_image'] = $id_image_info['id_image'];
		$ids = $id_product.'-'.$id_image_info['id_image'];
		$img_info[$i]['image_link'] = $link->getImageLink($name,$ids);
		$img_info[$i]['cover'] = $id_image_info['cover'];
		$img_info[$i]['position'] = $id_image_info['position'];?>
		<div class="col-sm-6 col-md-4">
		    	<div class="thumbnail">
		      		<img src="//<?php echo $img_info[$i]['image_link']; ?>" width="70%">
		      		<div class="caption">
		      				<?php 
		      				if ($img_info[$i]['cover']=="1"){
		      					?><p>Posicion : <?php echo $img_info[$i]['position']; ?>, Imagen principal</p><?php
		      				}else{
		      					?><p>Posicion : <?php echo $img_info[$i]['position']; ?></p> <?php
		      				}
		      				?>
		      		</div>
		    	</div>
		  	</div>
		<?php 
		$i++;
  	}
  	echo '</div>';	
  	echo '</div>';



  ?>
  <div class="form-group">
  	<label for="product_size" class="col-sm-2 control-label">Imagenes:</label>
  	<div class="col-sm-10">
		<button class="btn btn-warning btn-large fileSelect" name="product_image" style="	">Subir Imagen</button>
		
		<a href="javascript:;" onclick="showOtherImage();">
		<button class="btn btn-warning btn-large fileSelect"><i class="icon-white icon-heart"></i> Agregar otra imagen</button>
		</a>
		<div id="otherimages" style="margin-left:0px;"> </div>
	</div>

	<div id="preview-images" >
	</div>

  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	<input type="file" id="product_image" name="product_image" value="" class="account_input" size="chars" style="display:none;"  />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Actualizar</button>
    </div>
  </div>
</form>	
<script type="text/javascript">
function fnChangeTallaSelect(evento){
	if (evento.value==-1){
		$("#form-tallas-group").show();
		$("#chk-size-chica").focus();
	}else{
		$("#form-tallas-group").hide();
		$("#product_quantity").focus();
	}
}

</script>
<script language="javascript" type="text/javascript">

document.querySelector('.fileSelect').addEventListener('click', function(e) {
	e.preventDefault();
  	// Use the native click() of the file input.
  	document.querySelector('#product_image').click();
}, false);

	var contador_oficial_imagenes=1+<?php echo $i; ?>;

function showOtherImage() {
	if (contador_oficial_imagenes==3){
		alert("Máximo 3 imagenes por producto");
		return false;
	}	
	var newdiv = document.createElement('div');

	newdiv.setAttribute("id","childDiv"+contador_oficial_imagenes);

	newdiv.innerHTML = "&nbsp;<input type='file' id='images"+contador_oficial_imagenes+"' name='images[]'  class='btn btn-warning btn-large fileSelect' />&nbsp;&nbsp;<a class='btn btn-warning btn-large fileSelect' href=\"javascript:;\" onclick=\"removeEvent('childDiv"+contador_oficial_imagenes+"')\">Quitar</a>";

	var ni = document.getElementById('otherimages');

	ni.appendChild(newdiv);

	contador_oficial_imagenes++;

} 


function removeEvent(divNum){

	var d = document.getElementById('otherimages');

	var olddiv = document.getElementById(divNum);

	d.removeChild(olddiv);

	contador_oficial_imagenes--;

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
