<?php
			include "basic_include.php";
			if (!defined('_PS_VERSION_'))
	    	exit;

			$json_respuesta = array();

			if(isset($_POST['confirm'])) {
				$customer_id     = $_SESSION['id_customer'];
				//obtener el seller
				
							
				$QuerySeller =  Db::getInstance()->executeS("SELECT `marketplace_seller_id`  from `" . _DB_PREFIX_ . "marketplace_customer` where `id_customer`=" . $customer_id );
				$seller_id = 0;
				foreach ($QuerySeller as $key) {
					$seller_id = $key["marketplace_seller_id"];
				}

				$mkt_pd = new SellerInfoDetail();
				$seller_info = $mkt_pd->sellerDetail($seller_id);
				//var_dump($seller_info["id_category"]);
				
				//die;

				$QuerySellerProducts =  Db::getInstance()->executeS("SELECT `id` from `" . _DB_PREFIX_ . "marketplace_seller_product` where `id_seller`=" . $seller_id );
				foreach ($QuerySellerProducts as $key) {
					$product_id = $key["id"];
					
					//borrar las categorias
					$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_seller_product_category","id_seller_product=".$product_id);
		

					$QuerySellerShopProducts =  Db::getInstance()->executeS("SELECT `id_product`, `marketplace_seller_id_product` from `" . _DB_PREFIX_ . "marketplace_shop_product` where `marketplace_seller_id_product`=" . $product_id );
					
					foreach ($QuerySellerShopProducts as $keyProducts) {
						$id_real_product = $keyProducts["id_product"];

						$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "product","id_product=".$id_real_product);

						$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "product_lang","id_product=".$id_real_product);

						$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "product_shop","id_product=".$id_real_product);

					}

					//borrar del marketplace_shop_product
					$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_shop_product","marketplace_seller_id_product=".$product_id);

					//borrar las imagenes
					$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_product_image","seller_product_id=".$product_id);

					//borrar de la tabla products
				}
				//borrar todos los productos marketplace_shop_product
				$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_seller_product","id_seller=".$seller_id);

				//borrar de la tabla marketplace_customer
				$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_customer","id_customer=".$customer_id);

				//borrar de la tabla marketplace_customer_payment_detail
				$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_customer_payment_detail","id_customer=".$customer_id);

				//borrar de la tabla marketplace_seller_info
				$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_seller_info","id=".$seller_id);

				//borrar de la tabla marketplace_shop
				$delete =  Db::getInstance()->delete(_DB_PREFIX_ . "marketplace_shop","id_customer=".$customer_id);
				
				//borrar la categoria para la tienda
				$categoria = new Category($seller_info["id_category"]);
				$categoria->delete();

				$json_respuesta['status'] = 1;


			
			} else {
				$json_respuesta['status'] = -1;
			}
			echo json_encode($json_respuesta);

?>