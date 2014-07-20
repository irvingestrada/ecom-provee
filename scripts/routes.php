<?php

$nav = ($_GET['nav'] ? $_GET['nav'] : 'home');

switch($nav){
	case 'home' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/home.php";
	break;
	case 'productos' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/productos.php";
	break;
	case 'editproduct' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/editproduct.php";
	break;
	case 'newproduct' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/nuevo_producto.php";
	break;
	default:
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/home.php";
	break;
}

?>