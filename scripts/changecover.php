<?php
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";
		$id_product = Tools::getValue('id_product');
		$id_image = Tools::getValue('id_image');

		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image_shop` image_shop, `'._DB_PREFIX_.'image` i
			SET image_shop.`cover` = 0 
			WHERE i.`id_product` = '.(int)$id_product.' AND i.id_image = image_shop.id_image
			AND image_shop.id_shop='.(int)$context->shop->id);
		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image` i
			SET `cover` = 0 
			WHERE `id_product` = '.(int)$id_product);
		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image_shop`
			SET `cover` = 1 WHERE `id_image` = '.(int)$id_image);
		Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'image`
			SET `cover` = 1 WHERE `id_image` = '.(int)$id_image);
		Product::cleanPositions($id_product);
?>
