<?php
	
		include "core.php";
		if (!defined('_PS_VERSION_'))
    	exit;

		$id = Tools::getValue('form_product_id');

		$obj_seller_product = new SellerProductDetail();
		$prod_detail = $obj_seller_product->getMarketPlaceProductInfo($id);
		
		$obj_mpshop_pro = new MarketplaceShopProduct();
		$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
		$main_product_id = $product_deatil['id_product'];
		$obj_ps_prod = new Product($main_product_id);
		$obj_ps_prod->delete();
		
		$is_delete = $obj_seller_product->deleteMarketPlaceSellerProduct($id);

		
		$result1    = Db::getInstance()->executeS('delete from `'._DB_PREFIX_.'marketplace_product_image` where seller_product_id = '.$id);

		header("location: /index.php?nav=productos");
?>