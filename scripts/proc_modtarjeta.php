<?php

	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;

    require_once(_PS_MODULE_DIR_.'conektapagos/lib/Conekta.php');

    define(API_URL, 'https://api.conekta.io/charges');
    define(CURRENCY, 'mxn');
    define(NombrePayment, 'Pago TC/Debito');
    Conekta::setApiKey(_CONEKTA_PRIVATE_KEY_);

    //relacionar al cliente con la mensualidad
    /*
    $error_cobro = 0;
    try{
        $customer_conekta = Conekta_Customer::create(array(
          "name"=> $person_name." ".$person_lastname,
          "email"=> $bussiness_email,
          "phone"=> $phone,
          "cards"=>  array($conektaTokenId)
        ));

        $subscription = $customer_conekta->createSubscription(array(
            "plan_id" => getPlanes($paquete_comprar)
        ));


    }catch (Conekta_Error $e){
        $error_cobro = 1;       
        echo $e->getMessage();
    }
    */
    //proceso de cambio
    //sacar todas las subscripciones del cliente
    //tener la referencia de las subscripcion-
    //eliminar el perfil actual del cliente
    //crear nuevo cliente con la nueva tarjeta
    //subscribir al cliente --ver el tema de las fechas
    
    
	header("location: /index.php?nav=configuracion");
?>