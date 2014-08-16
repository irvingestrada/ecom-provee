<?php

	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;
    unset($_SESSION["ERROR"]);
	$market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
	if (isset($_POST['update_seller_name'])) {
        $seller_name = $_POST['update_seller_name'];
    }
    if (isset($_POST['update_about_shop'])) {
        $about_shop = $_POST['update_about_shop'];
    }
    if (isset($_POST['update_shop_name'])) {
        $shop_name = $_POST['update_shop_name'];
    }
    if (isset($_POST['update_business_email'])) {
        $business_email = $_POST['update_business_email'];
    }
    if (isset($_POST['update_phone'])) {
        $phone = $_POST['update_phone'];
    }
    if (isset($_POST['update_fax'])) {
        $fax = $_POST['update_fax'];
    }
    if (isset($_POST['update_address'])) {
        $address = $_POST['update_address'];
    }
    if (isset($_POST['update_about_shop'])) {
        $about_us = trim($_POST['update_about_shop']);
    }
    if (isset($_POST['update_twitter_id'])) {
        $twitter_id = trim($_POST['update_twitter_id']);
    }
    if (isset($_POST['update_facbook_id'])) {
        $facebook_id = trim($_POST['update_facbook_id']);
    }
    if (isset($_POST['update_shop_logo'])) {
        $shop_logo = $_FILES['update_shop_logo']["tmp_name"];
    }

    if (isset($_POST['update_polenvio'])) {
        $update_polenvio = trim($_POST['update_polenvio']);
    }
    if (isset($_POST['update_poldevol'])) {
        $update_poldevol = trim($_POST['update_poldevol']);
    }
    if (isset($_POST['update_polgaran'])) {
        $update_polgaran = trim($_POST['update_polgaran']);
    }
    if (isset($_POST['update_infoadic'])) {
        $update_infoadic = trim($_POST['update_infoadic']);
    }

    if (isset($_POST['store_category'])) {
        $store_category = trim($_POST['store_category']);
    }


    $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

    if (isset($_FILES['update_seller_logo'])){
        if ($_FILES['update_shop_logo']["size"] != 0)
    	{
    		list($shop_width, $shop_height) = getimagesize($_FILES['update_shop_logo']['tmp_name']);
    	}
    	if ($_FILES['update_seller_logo']["size"] != 0)
    	{
    		list($seller_width, $seller_height) = getimagesize($_FILES['update_seller_logo']['tmp_name']);
    		
    		if ($_FILES['update_seller_logo']['error'] == 0) {
    		    $validExtensions1 = array(
    		        '.jpg',
    		        '.jpeg',
    		        '.gif',
    		        '.png'
    		    );
    			
    		    $fileExtension1   = strrchr($_FILES['update_seller_logo']['name'], ".");
    		    if (in_array($fileExtension1, $validExtensions1)) {
    		        $manipulator1        = new ImageManipulator($_FILES['update_seller_logo']['tmp_name']);
    		        $newSellerImage           = $manipulator1->resample(200, 200);
    		        $seller_new_logo_name = $market_seller_id['marketplace_seller_id'] . ".jpg";
    		        $manipulator1->save(BAZARINGA_PATH.'modules/marketplace/img/seller_img/' . $seller_new_logo_name);
    		    }
            }
                			
    	}
    }
	
    $market_place_shop_name   = $market_place_seller_info['shop_name'];
    if (isset($_FILES['update_shop_logo'])){
        if ($_FILES['update_shop_logo']["size"] == 0) {
            if ($market_place_shop_name!=$shop_name) {
                $shop_prev_logo_name=$market_seller_id['marketplace_seller_id']."-".$market_place_shop_name;
                $shop_prev_logo_name1=glob(BAZARINGA_PATH.'modules/marketplace/img/shop_img/'.$shop_prev_logo_name.'.*');
                $shop_image_path=BAZARINGA_PATH.'modules/marketplace/img/shop_img/';
                $is_shop_image_exist=$shop_prev_logo_name1[0];
                if (file_exists($is_shop_image_exist)) {
                    $shop_new_logo_name = $market_seller_id['marketplace_seller_id']."-".$shop_name.".jpg";
                    rename($shop_image_path.$shop_prev_logo_name.'.jpg',$shop_image_path.$shop_new_logo_name);
                }
            }
        } else {
            $shop_image_path      = BAZARINGA_PATH.'modules/marketplace/img/shop_img/';
            $shop_prev_logo_name  = $market_seller_id['marketplace_seller_id']."-".$market_place_shop_name;
            $shop_prev_logo_name1 = glob($shop_image_path . $shop_prev_logo_name.'.*');
            $is_shop_image_exist  = $shop_prev_logo_name1[0];
            if (file_exists($is_shop_image_exist)) {
                unlink($shop_prev_logo_name1[0]);
            }
            if ($_FILES['update_shop_logo']['error'] == 0) {
                $validExtensions = array(
                    '.jpg',
                    '.jpeg',
                    '.gif',
                    '.png'
                );
                $fileExtension   = strrchr($_FILES['update_shop_logo']['name'], ".");
                if (in_array($fileExtension, $validExtensions)) {
                    $newNamePrefix      = time() . '_';
                    $manipulator        = new ImageManipulator($_FILES['update_shop_logo']['tmp_name']);
                    $newImage           = $manipulator->resample(200, 200, false);
                    $shop_new_logo_name = $market_seller_id['marketplace_seller_id'] . "-" . $shop_name . ".jpg";
                    $manipulator->save(BAZARINGA_PATH.'modules/marketplace/img/shop_img/' . $shop_new_logo_name);

                }
            }else{
       
            }
        }
    }

    $obj_seller = new SellerInfoDetail($_SESSION['marketplace_seller_id']);
    if ($_FILES['update_banner']['error'] == 0) {
        //img/c/60-category_default.jpg
        list($shop_width, $shop_height) = getimagesize($_FILES['update_banner']['tmp_name']);
        $banner_image_path      = BAZARINGA_PATH.'img/c/'.$obj_seller->id_category.'-category_default.jpg';
        if (file_exists($banner_image_path)) {
            unlink($banner_image_path);
        }
        
        $validExtensions = array(
                '.jpg',
                '.jpeg',
                '.gif',
                '.png'
            );
        $fileExtension   = strrchr($_FILES['update_banner']['name'], ".");
        if (in_array($fileExtension, $validExtensions)) {
            $newNamePrefix      = time() . '_';
            $manipulator        = new ImageManipulator($_FILES['update_banner']['tmp_name']);
            $newImage           = $manipulator->resample(715, 250, false);
            $manipulator->save(BAZARINGA_PATH.'img/c/'.$obj_seller->id_category.'-category_default.jpg');
            $manipulator->save(BAZARINGA_PATH.'img/c/'.$obj_seller->id_category.'.jpg');

        }
        
    }

    
    
    $obj_seller->business_email = $business_email;
    $obj_seller->seller_name = $seller_name;
    $obj_seller->shop_name = $shop_name;
    $obj_seller->phone = $phone;
    $obj_seller->address = $address;
    $obj_seller->active = "1";
    $obj_seller->about_shop = $about_shop;


    $obj_seller->politica_envio = $update_polenvio;
    $obj_seller->politica_devolucion = $update_poldevol;
    $obj_seller->politica_garantia = $update_polgaran;
    $obj_seller->informacion_adicional = $update_infoadic;
    
    $obj_seller->save();

    if ($shop_name){
        $categoria_obj = new Category($market_place_seller_info["id_category"]);
        $categoria_obj->description = $shop_name;
        $categoria_obj->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $shop_name);
        $categoria_obj->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') =>  Tools::link_rewrite($shop_name));    
        $categoria_obj->save();
    }

    
    $is_update     = Db::getInstance()->update('marketplace_shop', array(
        'shop_name' => $shop_name,
        'about_us' => $about_us
    ), 'id_customer=' . $_SESSION['id_customer']);
	
	Hook::exec('actionUpdateshopExtrafield', array('marketplace_seller_id' => $market_seller_id['marketplace_seller_id']));

	header("location: /index.php");
?>
