<?php

	include "basic_include.php";
	if (!defined('_PS_VERSION_'))
	exit;

    $id_order = Tools::getValue('id_order');
    $num_guia = Tools::getValue('num_guia');

    $Estatus_Envio = Tools::getValue('OrdenEnvioCambio');
    $Estatus_Orden = Tools::getValue('OrdenEstatusCambio');
    
    switch ($Estatus_Orden) {
        case 'Refund':
            $estatus_aplicar = Configuration::get('PS_OS_REFUND');        
        break;
        case 'Canceled':
            $estatus_aplicar = Configuration::get('PS_OS_CANCELED');        
        break;
        default:
            # code...
        break;
    }

    switch ($Estatus_Envio) {
        case 'Shipped':
            $estatus_aplicar = Configuration::get('PS_OS_SHIPPING');        
        break;
        case 'Delivered':
            $estatus_aplicar = Configuration::get('PS_OS_DELIVERED');        
        break;
        default:
            # code...
        break;
    }

    if ($estatus_aplicar>0){
        
        $order = new Order((int)$id_order);
        
        if ($Estatus_Envio=="Shipped"){
            $order->shipping_number = $num_guia;
            $order->save();
        }

        $history = new OrderHistory();
        $history->id_order = (int)($id_order);
        //var_dump($estatus_aplicar);
        $history->changeIdOrderState($estatus_aplicar, $order);
        $history->addWithemail();    
    }
    
    
	header("location: /index.php?nav=ventas");
?>