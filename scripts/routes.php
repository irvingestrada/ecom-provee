<?php

$nav = ($_GET['nav'] ? $_GET['nav'] : 'inicio');
 
 if ($_SESSION['logueado']==false){
 	$nav = "";
 }

switch($nav){
	case 'home' :
		header("location: /index.php?nav=inicio");
		die;
		//include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/home.php";
	break;
	case 'inicio' :
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
	case 'ventas' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/ventas.php";
	break;
	case 'store' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/modificar_tienda.php";
	break;
	case 'configuracion' :
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/configuracion.php";
	break;
	default:
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/logueate.php";
	break;
}

?>