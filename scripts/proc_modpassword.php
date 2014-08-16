<?php
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";

		$current_Password = Tools::getValue('currentpassword');
		$newpassword = Tools::getValue('newpassword');
		$confirmpassword = Tools::getValue('confirmpassword');

		if (!Validate::isPasswd($current_Password)){
			header("location: /index.php?nav=configuracion&error_msg=currentpassword_syntax");
			exit;
		}

		if (!Validate::isPasswd($newpassword)){
			header("location: /index.php?nav=configuracion&error_msg=newpassword_syntax");
			exit;
		}

		$obj_seller_info = new SellerInfoDetail();
		
		$validate_marketplace = $obj_seller_info->sellerDetail($_SESSION["marketplace_seller_id"]);
		
		$customer = new Customer();
		
		$authentication = $customer->getByEmail(trim($validate_marketplace["business_email"]), trim($current_Password));
		if (!$authentication || !$customer->id)
			$error_contrasena = false;
		else
			$error_contrasena = true;

		if ($error_contrasena==false){
			header("location: /index.php?nav=configuracion&error_msg=currentpassword_value");
			exit;
		}else{
			$customer_mod = new Customer($customer->id);
			$customer_mod->passwd = Tools::encrypt($newpassword);
			$customer_mod->save();
			$_SESSION["mensaje_ajax"] = "Contraseña cambiada.";
		}
		
		header("location: /index.php?nav=configuracion");
?>

