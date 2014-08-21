<?php
session_start(); 
define('PRESTASHOP_INTEGRATION_VERSION', true);
define('BAZARINGA_PATH', '/var/www/bazaringa/');
//define('BAZARINGA_PATH', '/home1/tequila9/public_html/bazaringa_test/');
define('BAZARINGA_WWWPATH', 'http://prueba.bazaringa.com');

$image_url = "http://prueba.bazaringa.com";
$jsArray = Array();
include_once BAZARINGA_PATH."config/config.inc.php";
include_once BAZARINGA_PATH.'modules/marketplace/classes/MarketplaceClassInclude.php';

if (isset($_SESSION['id_customer']) && isset($_SESSION['logueado'])){


	$id_lang = 2;


	$customer_id     		= $_SESSION['id_customer'];
	$marketplace_seller_id  = $_SESSION['marketplace_seller_id'];
	$id_lang 				= $_SESSION['id_lang'];
	$nombre_sesion			= $_SESSION['nombre_sesion'];
	
}
function getListEstatus(){
    $array = array();
    $array[] = array ("id" => 2, "Texto" => "Pago Realizado");
    $array[] = array ("id" => 4, "Texto" => "Enviado");
    $array[] = array ("id" => 5, "Texto" => "Entregado");
    $array[] = array ("id" => 6, "Texto" => "Cancelado");
    $array[] = array ("id" => 7, "Texto" => "Devolución");
    return $array;
  }
  
function getRealStatus ($id){
    switch ($id) {
      case 'Payment accepted':
        return 'Pago Realizado';
        break;
      case 'Shipped':
        return 'Enviado';
        break;
      case 'Delivered':
        return 'Entregado';
        break;
      case 'Canceled':
        return 'Cancelado';
        break;
      case 'Refund':
        return 'Devolución';
        break;
      case 'Tarjeta de Credito / Debito':
        return 'Pago TC/Debito';
        break;
      case 'Esperando respuesta proveedor de pago':
        return 'Pago TC/Debito';
        break;
      case 'Pago con Oxxo':
        return 'Pago en Oxxo';
        break;
      default:
          $pago = "Error estatus";
        break;
      return $pago;
    }
  }


function getDetailRealStatus ($id){
    switch ($id) {
      case 'Payment accepted':
        return 'Pago Realizado';
        break;
      case 'Shipped':
        return 'Pago Realizado';
        break;
      case 'Delivered':
        return 'Pago Realizado';
        break;
      case 'Canceled':
        return 'Cancelado';
        break;
      case 'Refund':
        return 'Pago Realizado';
        break;
      case 'Tarjeta de Credito / Debito':
        return 'Pago TC/Debito';
        break;
      case 'Esperando respuesta proveedor de pago':
        return 'Pago TC/Debito';
        break;
      case 'Pago con Oxxo':
        return 'Pago en Oxxo';
        break;
      default:
          $pago = "Error estatus";
        break;
      return $pago;
    }
  }

  function getEnviado ($id){
    switch ($id) {
      case 'Payment accepted':
        return 'Sin enviar';
        break;
      case 'Shipped':
        return 'Enviado';
        break;
      case 'Delivered':
        return 'Entregado';
        break;
      case 'Canceled':
        return 'Sin enviar';
        break;
      case 'Refund':
        return 'Sin enviar';
        break;
      case 'Tarjeta de Credito / Debito':
        return 'Sin enviar';
        break;
      case 'Esperando respuesta proveedor de pago':
        return 'Sin enviar';
        break;
      case 'Pago con Oxxo':
        return 'Sin enviar';
        break;
      default:
          $pago = "Error estatus";
        break;
      return $pago;
    }
  }

?>