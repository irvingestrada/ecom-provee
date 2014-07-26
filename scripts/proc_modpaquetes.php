<?php

	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;

    $market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
    $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

    $obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);	    
	
    $paquetes = "";

    if (isset($_POST['paquetes'])) {
        $paquetes = $_POST['paquetes'];
    }
    
    $obj_seller->paquete_comprado = $paquetes;
    $obj_seller->save();

    
	header("location: /index.php?nav=configuracion");
?>