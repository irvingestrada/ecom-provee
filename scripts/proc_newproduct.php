<?php
		include "core.php";
		if (!defined('_PS_VERSION_'))
    	exit;
		$obj_seller_product = new SellerProductDetail();
        $obj_mpshop = new MarketplaceShop();
		$obj_mp_customer = new MarketplaceCustomer();

		$marketplace_shop = $obj_mpshop->getMarketPlaceShopInfoByCustomerId($customer_id);
      	$mp_id_shop       = $marketplace_shop['id'];
		
		$marketplace_customer = $obj_mp_customer->findMarketPlaceCustomer($customer_id);

		$id_seller = $marketplace_customer['marketplace_seller_id'];
        
		$product_name = Tools::getValue('product_name');
		$short_description = Tools::getValue('short_description');
		$product_description = Tools::getValue('product_description');
		$product_price = Tools::getValue('product_price');
		$product_quantity = Tools::getValue('product_quantity');
		$product_category = Tools::getValue('product_category');
		$product_size = Tools::getValue('product_size');

		if ($product_name==""){
			header("location: /index.php?nav=newproduct&error_msg=prod_name");
			exit;
		}

		if ($product_description==""){
			header("location: /index.php?nav=newproduct&error_msg=prod_desc");
			exit;
		}

		if ($product_price==""){
			header("location: /index.php?nav=newproduct&error_msg=prod_price");
			exit;
		}

		if ($product_quantity==""){
			header("location: /index.php?nav=newproduct&error_msg=prod_qty");
			exit;
		}

		if ($product_size==""){
			header("location: /index.php?nav=newproduct&error_msg=prod_size");
			exit;
		}

		$obj_seller_info_detail = new SellerInfoDetail();

		$buscando_categoria = $obj_seller_info_detail->sellerDetail($id_seller);

		Hook::exec('actionBeforeAddproduct', array('mp_seller_id' => $id_seller));
		$approve_type = Configuration::getGlobalValue('PRODUCT_APPROVE');
		
		$obj_seller_product->id_seller = $id_seller;
		$obj_seller_product->price = $product_price;
		$obj_seller_product->quantity = $product_quantity;
		$obj_seller_product->product_name = $product_name;
		$obj_seller_product->description = $product_description;
		$obj_seller_product->short_description = $short_description;
		$obj_seller_product->id_category = $buscando_categoria['id_category'];
		$obj_seller_product->ps_id_shop = $context->shop->id;
		$obj_seller_product->id_shop = $mp_id_shop;

		$obj_seller_product->active = 1;
		
		$obj_seller_product->save();	
		
		$seller_product_id = $obj_seller_product->id;
		//Add into category tablef
		$obj_seller_product_category = new SellerProductCategory();
		$obj_seller_product_category->id_seller_product = $seller_product_id;
		$obj_seller_product_category->is_default = 1;
		$obj_seller_product_category->id_category = $buscando_categoria['id_category'];
		$obj_seller_product_category->add();
		$i=0;
		/*	
		foreach($product_category as $p_category){
			$obj_seller_product_category->id_category = $p_category;
			if($i != 0)
				$obj_seller_product_category->is_default = 0;
			$obj_seller_product_category->add();
			$i++;
		}*/
		
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
												'seller_product_id' => (int) $seller_product_id,
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
				'seller_product_id' => (int) $seller_product_id,
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
		
		$active = "1";

		if($seller_product_id){
					// if active, then entry of a product in ps_product table...
			if($active){
				//$obj_seller_product = new SellerProductDetail();
				$image_dir = BAZARINGA_PATH."modules/marketplace/img/product_img";
				// creating ps_product when admin setting is default
				
				$ps_product_id = $obj_seller_product->createPsProductByMarketplaceProduct($seller_product_id,$image_dir, $active);
				
				if($ps_product_id){
					// mapping of ps_product and mp_product id
					$mps_product_obj = new MarketplaceShopProduct();
					
					$mps_product_obj->id_shop = $mp_id_shop;
					$mps_product_obj->marketplace_seller_id_product = $seller_product_id;
					$mps_product_obj->id_product = $ps_product_id;
					$mps_product_obj->active = $active;
					$mps_product_obj->add();
				}
			}
					
		}

		Hook::exec('actionAddproductExtrafield', array('marketplace_product_id' => $seller_product_id));

		header("location: /index.php?nav=productos");
?>