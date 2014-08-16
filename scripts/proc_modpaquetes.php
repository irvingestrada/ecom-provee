<?php

	include "basic_include.php";
	if (!defined('_PS_VERSION_'))
	exit;

    $paquetes = 0;

    if (isset($_POST['paquetes'])) {
        $paquetes = $_POST['paquetes'];
    }

    if ($paquetes>0){

        $market_seller_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select `marketplace_seller_id` from `" . _DB_PREFIX_ . "marketplace_customer` where id_customer =" . $_SESSION['id_customer'] . "");
        $market_place_seller_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("select * from `" . _DB_PREFIX_ . "marketplace_seller_info` where id =" . $market_seller_id['marketplace_seller_id'] . "");

        $obj_seller = new SellerInfoDetail($market_seller_id['marketplace_seller_id']);	    
    	
        $paquete_anterior= $obj_seller->paquete_comprado;

        $pay_mode = Db::getInstance()->ExecuteS("SELECT * from `"._DB_PREFIX_."marketplace_payment_mode` where id = ".$paquetes);
        $nuevo_paquete = $pay_mode[0]['id_paquete'];

        require_once(_PS_MODULE_DIR_.'conektapagos/lib/Conekta.php');

        Conekta::setApiKey(_CONEKTA_PRIVATE_KEY_);

        $customer = Conekta_Customer::find($obj_seller->customer_token);

        if ($customer){
            $subscription = $customer->subscription->update(array(
                    'plan' => $nuevo_paquete
            ));
            $obj_seller->paquete_comprado = $paquetes;
            $obj_seller->save();
            $_SESSION["mensaje_ajax"] = "Paquete actualizado.";
        }

        //proceso de cambio
        //sacar todas las subscripciones del cliente
        //tener la referencia de las subscripcion-
        //eliminar el perfil actual del cliente
        //crear nuevo cliente con la nueva tarjeta
        //subscribir al cliente --ver el tema de las fechas

    }
	header("location: /index.php?nav=configuracion");
?>