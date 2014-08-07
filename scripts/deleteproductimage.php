<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";

	if(isset($_POST['id_image'])) {
		$image = new Image($_POST['id_image']);
		$status = $image->delete();
		$delete =  Db::getInstance()->delete('image','id_image='.$_POST['id_image'].' and id_product='.$_POST['id_pro']);
		$delete =  Db::getInstance()->delete('marketplace_product_image','real_image_product_id='.$_POST['id_image']);
		Product::cleanPositions($_POST['id_pro']);
		if($status) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 0;
	}

?>