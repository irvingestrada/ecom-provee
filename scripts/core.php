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
include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/routes.php";

if (isset($_SESSION['id_customer']) && isset($_SESSION['logueado'])){

	$customer_id     = 15;
	//$customer_id     = 16;
	$marketplace_seller_id = 12;
	//$marketplace_seller_id = 13;
	$id_lang = 2;


	$customer_id     		= $_SESSION['id_customer'];
	$marketplace_seller_id  = $_SESSION['marketplace_seller_id'];
	$id_lang 				= $_SESSION['id_lang'];
	$nombre_sesion			= $_SESSION['nombre_sesion'];

}





function loadjs($js){
	global $jsArray;
	$jsArray[]['JS']=$js;
}

function loadEspecialJS(){
	global $jsArray;
	$return = "";
	foreach ($jsArray as $key) {
		$return.="<script src='".$key['JS']."'></script>";
	}
	echo $return;
}

?>