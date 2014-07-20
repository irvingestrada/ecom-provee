<?php
	include "core.php";
	//var_dump($_POST);

	$obj_marketplace_product = new SellerProductDetail();

	$pro_info = $obj_marketplace_product->getMarketPlaceProductInfo($_POST["product_id"]);
	$checked_product_cat = $obj_marketplace_product->getMarketPlaceProductCategories($_POST["product_id"]);
	Hook::exec('actionBeforeUpdateproduct');
			
	$id = Tools::getValue('product_id');
	$product_name = Tools::getValue('product_name');
	$product_description = Tools::getValue('product_description');
	$product_price = Tools::getValue('product_price');
	$product_quantity = Tools::getValue('product_quantity');
	$product_size = Tools::getValue('product_size');
	

	$obj_seller_product = new SellerProductDetail($id);
			
	$obj_seller_product->price = $product_price;
	$obj_seller_product->quantity = $product_quantity;
	$obj_seller_product->product_name = $product_name;
	$obj_seller_product->description = $product_description;
	$obj_seller_product->short_description = $product_description;
	$obj_seller_product->id_size = $product_size;
	$obj_seller_product->save();

	$obj_mpshop_pro = new MarketplaceShopProduct();
	$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
	$main_product_id = $product_deatil['id_product'];

	$image_dir = 'modules/marketplace/img/product_img';
					
	$is_update = $obj_seller_product->updatePsProductByMarketplaceProduct($id, $image_dir,1,$main_product_id);
	//var_dump($is_update);

	header("location: /index.php?nav=productos");

?>