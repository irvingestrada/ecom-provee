<?php
	include "core.php";
	if (!defined('_PS_VERSION_'))
    	exit;

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
	
	$product_size_chica = (Tools::getValue('chk-size-chica')>0) ? Tools::getValue('chk-size-chica') : 0;
	$product_size_mediana = (Tools::getValue('chk-size-mediana')>0) ? Tools::getValue('chk-size-mediana') : 0;
	$product_size_grande = (Tools::getValue('chk-size-grande')>0) ? Tools::getValue('chk-size-grande') : 0;
	$product_costo_envio = Tools::getValue('product_costo_envio');
	
	$size_chica = Tools::getValue('vsize-chica');
	$size_mediana = Tools::getValue('vsize-mediana');
	$size_grande = Tools::getValue('vsize-grande');

	$old_image_0 = Tools::getValue('old_image-0');
	$old_image_1 = Tools::getValue('old_image-1');
	$old_image_2 = Tools::getValue('old_image-2');


	$obj_seller_product = new SellerProductDetail($id);
			
	$obj_seller_product->price = $product_price;
	$obj_seller_product->quantity = $product_quantity;
	$obj_seller_product->product_name = $product_name;
	$obj_seller_product->description = $product_description;
	$obj_seller_product->short_description = $product_description;
	$obj_seller_product->id_size = $product_size;
	$obj_seller_product->costo_envio = $product_costo_envio;
	$obj_seller_product->save();

	$obj_mpshop_pro = new MarketplaceShopProduct();
	$product_deatil = $obj_mpshop_pro->findMainProductIdByMppId($id);
	$main_product_id = $product_deatil['id_product'];
	$seller_product_id = $id;
	$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
	
	$obj_mp_shopproduct = new MarketplaceShopProduct();
  	$id_product_info = $obj_mp_shopproduct->findMainProductIdByMppId($id);
  	$id_product = $id_product_info['id_product'];
  	
  	$product = new Product($id_product);
  	
  	$id_image_detail = $product->getImages(2);

  	$obj_mp_pro_image = new MarketplaceProductImage();
	$count = (int)$obj_mp_pro_image->findAndCountProductImageByMpProId($id);

	
	if(isset($_POST["image-1"])  && strlen($_POST["image-1"])>0) {
		$file_exists = urldecode($_SERVER["DOCUMENT_ROOT"].'/scripts/files/'.$_POST["image-1"]);
		if (file_exists($file_exists)){
			$length     = 6;
			$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
			$u_other_id = "";
			for ($p = 0; $p < $length; $p++) {
				$u_other_id .= $characters[mt_rand(0, strlen($characters))];
			}
			
			if ($old_image_0){
				$delete =  Db::getInstance()->delete('marketplace_product_image','position=0  AND real_image_product_id = '.$old_image_0);	
				$image = new Image($old_image_0);
				$status = $image->delete();
				//Product::cleanPositions($_POST['id_product']);
				
			}
			
			$result2    = Db::getInstance()->insert('marketplace_product_image', array(
				'seller_product_id' => (int) $id,
				'seller_product_image_id' => pSQL($u_other_id),
				'position' => 0
			));
			$image_name = $u_other_id . ".jpg";
			$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
			
			//move_uploaded_file($file_exists, $address . $image_name);
			rename ($file_exists, $address . $image_name);
		}

	}
	
	if(isset($_POST["image-2"])  && strlen($_POST["image-2"])>0) {
		$file_exists = urldecode($_SERVER["DOCUMENT_ROOT"].'/scripts/files/'.$_POST["image-2"]);
		if (file_exists($file_exists)){
			$length     = 6;
			$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
			$u_other_id = "";
			for ($p = 0; $p < $length; $p++) {
				$u_other_id .= $characters[mt_rand(0, strlen($characters))];
			}
			if ($old_image_1){
				$delete =  Db::getInstance()->delete('marketplace_product_image','position=1 AND real_image_product_id = '.$old_image_1);	
				$image = new Image($old_image_1);
				$status = $image->delete();
			}
			$result2    = Db::getInstance()->insert('marketplace_product_image', array(
				'seller_product_id' => (int) $id,
				'seller_product_image_id' => pSQL($u_other_id),
				'position' => 1
			));
			$image_name = $u_other_id . ".jpg";
			$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
			
			//move_uploaded_file($file_exists, $address . $image_name);
			rename ($file_exists, $address . $image_name);
		}

	}

	if(isset($_POST["image-3"])  && strlen($_POST["image-3"])>0) {
		$file_exists = urldecode($_SERVER["DOCUMENT_ROOT"].'/scripts/files/'.$_POST["image-3"]);
		if (file_exists($file_exists)){
			$length     = 6;
			$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
			$u_other_id = "";
			for ($p = 0; $p < $length; $p++) {
				$u_other_id .= $characters[mt_rand(0, strlen($characters))];
			}
			if ($old_image_2){
				$delete =  Db::getInstance()->delete('marketplace_product_image','position=2 AND real_image_product_id = '.$old_image_2);
				$image = new Image($old_image_2);
				$status = $image->delete();
			}
			$result2    = Db::getInstance()->insert('marketplace_product_image', array(
				'seller_product_id' => (int) $id,
				'seller_product_image_id' => pSQL($u_other_id),
				'position' => 2
			));
			$image_name = $u_other_id . ".jpg";
			$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
			
			//move_uploaded_file($file_exists, $address . $image_name);
			rename ($file_exists, $address . $image_name);
		}

	}
	
	

	$image_dir = BAZARINGA_PATH.'modules/marketplace/img/product_img';
					
	if($id){
						// if active, then entry of a product in ps_product table...
			$obj_seller_product = new SellerProductDetail();
			$image_dir = BAZARINGA_PATH."modules/marketplace/img/product_img";
			// creating ps_product when admin setting is default
			$ps_product_id = $obj_seller_product->updatePsProductByMarketplaceProduct($id, $image_dir, 1, $main_product_id);
				
			if($ps_product_id){
				// mapping of ps_product and mp_product id
				$mps_product_obj = new MarketplaceShopProduct();
				//$mps_product_obj->active = 1; //nuevo
				$mps_product_obj->active = 1;
				$mps_product_obj->id_shop = $mp_id_shop;
				$mps_product_obj->marketplace_seller_id_product = $id;
				$mps_product_obj->id_product = $ps_product_id;
				$mps_product_obj->update();

			}
		//}
				
	}
	
	Hook::exec('actionAddproductExtrafield', array('marketplace_product_id' => $id));
	//sacar primero si existe en cada talla
	/*
	#si el producto ya existe solo se updatea la cantidad.
	if ($size_chica>0){
        $result &= Db::getInstance()->update('product_attribute', array(
				'quantity' => pSQL($product_size_chica),
		), 'id_product = '.pSQL($main_product_id));

		$result  = Db::getInstance()->update('stock_available', array(
		        'quantity' => pSQL($product_size_chica),
		), 'id_product = '.pSQL($main_product_id). ' AND id_product_attribute = '. $size_chica);

		$key = 'StockAvailable::getQuantityAvailableByProduct_'.(int)$main_product_id.'-'.(int)$size_chica.'-1';
		Cache::store($key, (int)$product_size_chica);
		

	#si el producto no existe, se hacen los inserts
	}else if ($product_size_chica>0){
		//hacer el insert
		$result  = Db::getInstance()->insert('product_attribute', array(
            'id_product' => pSQL($main_product_id),
            'quantity' => pSQL($product_size_chica),
            'minimal_quantity' => 1,
        ));
		if($result) {
			$id_product_attribute_combination_chica = Db::getInstance()->Insert_ID();
			$result  = Db::getInstance()->insert('product_attribute_combination', array(
		        'id_attribute' => pSQL(1),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_chica),
		    ));
		    $result  = Db::getInstance()->insert('product_attribute_shop', array(
		        'id_shop' => pSQL(1),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_chica),
		        'minimal_quantity' => pSQL(1), 
		    ));
		    $result  = Db::getInstance()->insert('stock_available', array(
		        'id_product' => pSQL($main_product_id),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_chica),
		        'id_shop' => pSQL(1),
		        'quantity' => pSQL($product_size_chica),
		    ));
			
		}
	}

	#si el producto ya existe solo se updatea la cantidad.
	if ($size_mediana>0){
        $result &= Db::getInstance()->update('product_attribute', array(
				'quantity' => pSQL($product_size_mediana),
		), 'id_product = '.pSQL($main_product_id));

	    $result  = Db::getInstance()->update('stock_available', array(
		        'quantity' => pSQL($product_size_mediana),
	    ), 'id_product = '.pSQL($main_product_id). ' AND id_product_attribute = '. $size_mediana);

	    $key = 'StockAvailable::getQuantityAvailableByProduct_'.(int)$main_product_id.'-'.(int)$size_mediana.'-1';
		Cache::store($key, (int)$product_size_mediana);
	#si el producto no existe, se hacen los inserts
	}else if ($product_size_mediana>0){
		$result  = Db::getInstance()->insert('product_attribute', array(
            'id_product' => pSQL($main_product_id),
            'quantity' => pSQL($product_size_mediana),
            'minimal_quantity' => 1,
        ));
		
		if($result) {
			$id_product_attribute_combination_mediana = Db::getInstance()->Insert_ID();
			$result  = Db::getInstance()->insert('product_attribute_combination', array(
		        'id_attribute' => pSQL(2),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_mediana),
		    ));
			$result  = Db::getInstance()->insert('product_attribute_shop', array(
		        'id_shop' => pSQL(1),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_mediana),
		        'minimal_quantity' => pSQL(1), 
		    ));
		    $result  = Db::getInstance()->insert('stock_available', array(
		        'id_product' => pSQL($main_product_id),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_mediana),
		        'id_shop' => pSQL(1),
		        'quantity' => pSQL($product_size_mediana),
		    ));
		}
	}


	#si el producto ya existe solo se updatea la cantidad.
	if ($size_grande>0){
        $result &= Db::getInstance()->update('product_attribute', array(
				'quantity' => pSQL($product_size_grande),
		), 'id_product = '.pSQL($main_product_id));

	    $result  = Db::getInstance()->update('stock_available', array(
	        'quantity' => pSQL($product_size_grande),
	    ), 'id_product = '.pSQL($main_product_id). ' AND id_product_attribute = '. $size_grande);

	    $key = 'StockAvailable::getQuantityAvailableByProduct_'.(int)$main_product_id.'-'.(int)$size_grande.'-1';
		Cache::store($key, (int)$product_size_grande);
	#si el producto no existe, se hacen los inserts
	}else if ($product_size_grande>0){
		$result  = Db::getInstance()->insert('product_attribute', array(
            'id_product' => pSQL($main_product_id),
            'quantity' => pSQL($product_size_grande),
            'minimal_quantity' => 1,
        ));
		if($result) {
			$id_product_attribute_combination_grande = Db::getInstance()->Insert_ID();
			$result  = Db::getInstance()->insert('product_attribute_combination', array(
		        'id_attribute' => pSQL(3),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_grande),
		    ));
			$result  = Db::getInstance()->insert('product_attribute_shop', array(
		        'id_shop' => pSQL(1),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_grande),
		        'minimal_quantity' => pSQL(1), 
		    ));
		    $result  = Db::getInstance()->insert('stock_available', array(
		        'id_product' => pSQL($main_product_id),
		        'id_product_attribute' => pSQL($id_product_attribute_combination_grande),
		        'id_shop' => pSQL(1),
		        'quantity' => pSQL($product_size_grande),
		    ));
		}
	}
	*/

	header("location: /index.php?nav=productos");

?>