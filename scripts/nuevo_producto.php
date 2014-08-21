<?php

	//var_dump($_POST);
	//var_dump($_REQUEST);
	//var_dump($_GET);
	$obj_seller = new SellerInfoDetail($_SESSION["marketplace_seller_id"]);
	$pay_mode = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode` where id = ".$obj_seller->paquete_comprado);
	$tope_articulos = $pay_mode[0]["paquete_cantidad"];
	$obj_mp_seller_product = new SellerProductDetail();
	$productList = $obj_mp_seller_product->getProductList($_SESSION["marketplace_seller_id"],$orderby,$orderway,1, 300);

	if ((count($productList)+1)>$tope_articulos){
		header("location: /index.php?nav=productos&error_msg=maximo_productos_publicados");
	}

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
	
	loadjs('js/newproduct.js');
	//loadjs('js/uploader_preview.js');

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
	span .text-danger{
		width: 100px !important;
	}
	.nota{
		font-size: 10px;
		font-style: italic;
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
      <input type="text" class="form-control" id="product_name" name="product_name" placeholder="" value="<?php echo $pro_info["product_name"]; ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="product_description" class="col-sm-2 control-label">Descripción del producto:</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="product_description" name="product_description"><?php echo $pro_info["description"]; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="product_price" class="col-sm-2 control-label">Precio:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="product_price" name="product_price" placeholder="" value="<?php echo $pro_info["price"]; ?>" pattern="[0-9.]*" onkeypress="fKeyPress(event,'NP');" required>
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
  <!--
  <div class="form-group">
    <label for="product_size" class="col-sm-2 control-label">Talla:</label>
    <div class="col-sm-10">
		<select id="product_size" name="product_size" style="width:20%;" onchange="fnChangeTallaSelect(this);">
			<option value="0">Seleccionar</option>
			<option value="4">Unitalla</option>
			<option value="-1">Especificar</option>
		</select>
    </div>
  </div>-->
  <input type="hidden" name="product_size" id="product_size" value="4" >
  
  <div class="form-group">
  
  </div>
  <br/>
<center><span class="nota">El tamaño de las imagenes sugerido es de 500px de ancho por 500px de alto.</span></center><br/>
<table class="table">
<tr>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 1</span>
        	<input id="fileupload-1" type="file" name="files">
        	<input type="hidden" name="image-1" id="image-1" value="">
    	</span>
	</td>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 2</span>
        	<input id="fileupload-2" type="file" name="files">
        	<input type="hidden" name="image-2" id="image-2" value="">
    	</span>
	</td>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 3</span>
        	<input id="fileupload-3" type="file" name="files">
        	<input type="hidden" name="image-3" id="image-3" value="">
    	</span>
	</td>
</tr>
<tr>
	<td style="width:33%;text-align:center;">
		<div id="file-1" class="files"></div>
	</td>
	<td style="width:33%;text-align:center;">
		<div id="file-2" class="files"></div>
	</td>
	<td style="width:33%;text-align:center;">
		<div id="file-3" class="files"></div>
	</td>
</tr>
</table>
  	
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    	
      	<button type="submit" class="btn btn-default">Dar de alta</button>
    </div>
  </div>
</form>	
<script language="javascript" type="text/javascript">

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


