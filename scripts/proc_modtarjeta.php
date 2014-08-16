<?php

	include "basic_include.php";
	if (!defined('_PS_VERSION_'))
	exit;
    
    $conektaTokenId = Tools::getValue('conektaTokenId');
    var_dump($conektaTokenId);
    if (!empty($conektaTokenId)){
        require_once(_PS_MODULE_DIR_.'conektapagos/lib/Conekta.php');
        var_dump($_POST);
        Conekta::setApiKey(_CONEKTA_PRIVATE_KEY_);

        //relacionar al cliente con la mensualidad
        $market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
        $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

        $obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);     

        $error_cobro = 0;
        try{
            $customer = Conekta_Customer::find($obj_seller->customer_token);
            $card = $customer->cards[0]->update(array('token' => $conektaTokenId, 'active' => true));
            $obj_seller->tokentarjeta = $conektaTokenId;
            $obj_seller->save();
            $_SESSION["mensaje_ajax"] = "Tarjeta de crédito actualizada.";

        }catch (Conekta_Error $e){
            $error_cobro = 1;       
            echo $e->getMessage();
        }
    
    
    }
	header("location: /index.php?nav=configuracion");
?>