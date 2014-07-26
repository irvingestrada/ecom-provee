<?php
	include "core.php";
	if (!defined('_PS_VERSION_'))
	exit;
	
	$email = trim(Tools::getValue('form_username'));
	$passwd = trim(Tools::getValue('form_pass'));

	$errors = array();
	if (empty($email))
		$errors[] = Tools::displayError('An email address required.');
	elseif (!Validate::isEmail($email))
		$errors[] = Tools::displayError('Invalid email address.');
	elseif (empty($passwd))
		$errors[] = Tools::displayError('Password is required.');
	elseif (!Validate::isPasswd($passwd))
		$errors[] = Tools::displayError('Invalid password.');
	
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

	if (count($errors)==0){
		try{
			$customer = new Customer();
			$authentication = $customer->getByEmail(trim($email), trim($passwd));
			if (!$authentication || !$customer->id)
				$errors[] = Tools::displayError('El correo no esta registrado.');
			else{
				//Validar que el usuario tenga marketplace aceptado
				$obj_seller_info = new SellerInfoDetail();
				//var_dump($authentication->id);
				$validate_marketplace = $obj_seller_info->getMarketPlaceSellerIdByCustomerId($authentication->id);
				if ($validate_marketplace){
					if ($validate_marketplace['is_seller']=="1"){
						//asignar a sesion
						$_SESSION['logueado'] = true;
						$_SESSION['id_customer'] = $authentication->id;
						$_SESSION['id_lang'] = 2;
						$_SESSION['marketplace_seller_id'] = $validate_marketplace['marketplace_seller_id'];
						$_SESSION['nombre_sesion'] = $customer->firstname.' '.$customer->lastname;

					}else{
						$errors[] = Tools::displayError('La cuenta no esta asignada a un proveedor.');
					}
				}else{
					$errors[] = Tools::displayError('La cuenta no esta asignada a un proveedor.');
				}
			}
		}catch(Exception $e){
			$errors[] = Tools::displayError('error inesperado en la cuenta.['.$e->getMessage().']');
		}
	}

	header("location: /index.php");

?>