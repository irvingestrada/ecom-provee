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

	$size_chica = Tools::getValue('vsize-chica');
	$size_mediana = Tools::getValue('vsize-mediana');
	$size_grande = Tools::getValue('vsize-grande');


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

	$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
		
	if(isset($_FILES["product_image"])) {
		if($_FILES["product_image"]['size']>0) {
			$length     = 6;
			$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
			$u_id       = "";
			for ($p = 0; $p < $length; $p++) {
				$u_id .= $characters[mt_rand(0, strlen($characters))];
			}
			
			$result1    = Db::getInstance()->insert('marketplace_product_image', 
									array(
											'seller_product_id' => (int) $main_product_id,
											'seller_product_image_id' => pSQL($u_id)
									));

			//var_dump( array( 'seller_product_id' => (int) $seller_product_id, 'seller_product_image_id' => pSQL($u_id) ));
			$image_name = $u_id . ".jpg";
			//var_dump($_FILES["product_image"]["tmp_name"]);
			//var_dump($address);
			//var_dump($image_name);
			move_uploaded_file($_FILES["product_image"]["tmp_name"], $address . $image_name);
		}
	}
				
	if (isset($_FILES['images'])) {
		$other_images = $_FILES["images"]['tmp_name'];
		$count = count($other_images);
	} else {
		$count = 0;
	}
	
	
	for ($i = 0; $i < $count; $i++) {
		$length     = 6;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		$u_other_id = "";
		for ($p = 0; $p < $length; $p++) {
			$u_other_id .= $characters[mt_rand(0, strlen($characters))];
		}
		$result2    = Db::getInstance()->insert('marketplace_product_image', array(
			'seller_product_id' => (int) $main_product_id,
			'seller_product_image_id' => pSQL($u_other_id)
		));
		//var_dump( array( 'seller_product_id' => (int) $seller_product_id, 'seller_product_image_id' => pSQL($u_other_id) ));
		
		$image_name = $u_other_id . ".jpg";
		$address    = BAZARINGA_PATH."modules/marketplace/img/product_img/";
		
		//echo "<br/>segunda parte<br/>";
		//var_dump($other_images);
		//var_dump($address);
		//var_dump($image_name);
		
		move_uploaded_file($other_images[$i], $address . $image_name);
	}

	$image_dir = BAZARINGA_PATH.'modules/marketplace/img/product_img';
					
	$is_update = $obj_seller_product->updatePsProductByMarketplaceProduct($id, $image_dir,1,$main_product_id);
	
	//sacar primero si existe en cada talla

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
		echo "aki esta entrando grande ;S";
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
		echo "aki esta entrando grande";
		$result  = Db::getInstance()->insert('product_attribute', array(
            'id_product' => pSQL($main_product_id),
            'quantity' => pSQL($product_size_grande),
            'minimal_quantity' => 1,
        ));
		var_dump($result);
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


	header("location: /index.php?nav=productos");

?>