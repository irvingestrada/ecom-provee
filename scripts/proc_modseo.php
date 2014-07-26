<?php

	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;

	$market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
	
    $update_meta_title = "";
    $update_meta_description = "";
    $update_meta_keywords = "";

    if (isset($_POST['update_meta_title'])) {
        $update_meta_title = $_POST['update_meta_title'];
    }
    if (isset($_POST['update_meta_description'])) {
        $update_meta_description = $_POST['update_meta_description'];
    }
    if (isset($_POST['update_meta_keywords'])) {
        $update_meta_keywords = strtolower($_POST['update_meta_keywords']);
    }
    

    $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

    $categoria = new Category($market_place_seller_info["id_category"]);
    $categoria->meta_title = $update_meta_title;
    $categoria->meta_description = $update_meta_description;
    $categoria->meta_keywords = $update_meta_keywords;
    $categoria->save();

	header("location: /index.php?nav=store");
?>