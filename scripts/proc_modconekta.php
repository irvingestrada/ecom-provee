<?php

	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;

	$market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
	$market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

    $obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);

    $conekta_privada = "";
    $conekta_publica = "";

    if (isset($_POST['conekta_privada'])) {
        $conekta_privada = $_POST['conekta_privada'];
    }
    if (isset($_POST['conekta_publica'])) {
        $conekta_publica = $_POST['conekta_publica'];
    }

    $obj_seller->conekta_privada = $conekta_privada;
    $obj_seller->conekta_publica = $conekta_publica;
    $obj_seller->save();
    
	header("location: /index.php?nav=configuracion");
?>