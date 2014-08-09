<?php
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";

		$current_Password = Tools::getValue('password');
		if (!Validate::isPasswd($current_Password)){
			$array = array("status"=>"ok", "data" => "", "error" => "Formato nueva contraseña invalido.");			
			echo json_encode($array);
			die;
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
			$array = array("status"=>"ok", "error" => "La contraseña proporcionada es invalida.");			
		}else{
			$array = array("status"=>"ok", "error" => "");	
		}
		
		echo json_encode($array);
?>

