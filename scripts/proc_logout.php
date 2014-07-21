<?php
	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;
	
	if (isset($_SESSION['logueado']))
		unset($_SESSION['logueado']);

	if (isset($_SESSION['id_customer']))
		unset($_SESSION['id_customer']);

	if (isset($_SESSION['id_lang']))
		unset($_SESSION['id_lang']);

	if (isset($_SESSION['marketplace_seller_id']))
		unset($_SESSION['marketplace_seller_id']);
	
	if (isset($_SESSION['nombre_sesion']))
		unset($_SESSION['nombre_sesion']);

	header("location: /index.php");

?>