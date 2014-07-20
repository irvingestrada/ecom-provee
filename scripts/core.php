<?php
define('PRESTASHOP_INTEGRATION_VERSION', true);
define('BAZARINGA_PATH', '/var/www/bazaringa/');
$jsArray = Array();
$customer_id     = 15;
$marketplace_seller_id = 12;
$image_url = "http://prueba.bazaringa.com";

include_once BAZARINGA_PATH."config/config.inc.php";
include_once BAZARINGA_PATH.'modules/marketplace/classes/MarketplaceClassInclude.php';

include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/routes.php";

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