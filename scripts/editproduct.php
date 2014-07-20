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
      <input type="text" class="form-control" id="product_quantity" name="product_quantity" placeholder="Cantidad" value="<?php echo $pro_info["quantity"]; ?>">
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

  <?php
  	$obj_mp_shopproduct = new MarketplaceShopProduct();
  	$id_product_info = $obj_mp_shopproduct->findMainProductIdByMppId($_POST["form_product_id"]);
  	$id_product = $id_product_info['id_product'];
  	$product = new Product($id_product);

  	var_dump($id_image_detail);

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
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Actualizar</button>
    </div>
  </div>
</form>	
