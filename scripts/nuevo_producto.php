<?php

	//var_dump($_POST);
	//var_dump($_REQUEST);
	//var_dump($_GET);

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
	loadjs('js/uploader_preview.js');

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
<form class="form-horizontal" role="form" action="/scripts/proc_newproduct.php" method="post" enctype="multipart/form-data">
  <input type="hidden" value="<?php echo $pro_info["id_size"]; ?>" id="product_current_size" name="product_current_size">
  <input type="hidden" value="<?php echo $_POST["form_product_id"]; ?>" id="product_id" name="product_id">
  <div class="form-group">
    <label for="product_name" class="col-sm-2 control-label">Nombre del producto:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nombre producto" value="<?php echo $pro_info["product_name"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="product_description" class="col-sm-2 control-label">Descripción del producto:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_description" name="product_description" placeholder="Descripción" value="<?php echo $pro_info["description"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="product_price" class="col-sm-2 control-label">Precio:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="product_price" name="product_price" placeholder="Precio" value="<?php echo $pro_info["price"]; ?>" pattern="[0-9]*" onkeypress="fKeyPress(event,'NP');" required>
    </div>
  </div>
  <div class="form-group">
    <label for="product_quantity" class="col-sm-2 control-label">Cantidad:</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="Cantidad" value="<?php echo $pro_info["quantity"]; ?>" onkeypress="fKeyPress(event,'N');" required pattern="[0-9]*">
    </div>
  </div>
  <div class="form-group">
    <label for="product_size" class="col-sm-2 control-label">Talla:</label>
    <div class="col-sm-10">
		<select id="product_size" name="product_size" style="width:20%;">
			<option value="0">Sin Talla</option>
			<option value="1">Chica</option>
			<option value="2">Mediana</option>
			<option value="3">Grande</option>
		</select>
    </div>
  </div>
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
    	<input type="file" id="product_image" name="product_image" value="" class="account_input"   size="chars"  />
      	<button type="submit" class="btn btn-default">Dar de alta</button>
    </div>
  </div>
</form>	
<script language="javascript" type="text/javascript">

document.querySelector('.fileSelect').addEventListener('click', function(e) {
	e.preventDefault();
  	// Use the native click() of the file input.
  	document.querySelector('#product_image').click();
}, false);

	var contador_oficial_imagenes=1;

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


