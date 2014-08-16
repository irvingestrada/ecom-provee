<?php
		include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";
		$id_product = Tools::getValue('id_product');
		$product = new Product($id_product);
		$id_lang = 2;
		$id_image_detail = $product->getImages($id_lang);

		$product_link_rewrite = Db::getInstance()->getRow("select * from `". _DB_PREFIX_."product_lang` where `id_product`=".$id_product." and `id_lang`=2");
		$name = $product_link_rewrite['link_rewrite'];

		$img_info = array();
		$link = new Link();

		$i = 0;
		foreach($id_image_detail as $id_image_info)
	  	{
			$img_info[$i]['id_image'] = $id_image_info['id_image'];
			$ids = $id_product.'-'.$id_image_info['id_image'];
			$img_info[$i]['image_link'] = $link->getImageLink($name,$ids);
			$img_info[$i]['cover'] = $id_image_info['cover'];
			$img_info[$i]['position'] = $id_image_info['position'];?>
			<input type="hidden" name="old_image-<?php echo $i; ?>" value="<?php echo $id_image_info['id_image']; ?>">
			<?php 
			$i++;
	  	}


?>

<table class="table">
<tr>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 1</span>
        	<input id="fileupload-1" type="file" name="files">
        	<input type="hidden" name="image-1" id="image-1" value="">
    	</span>
	</td>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 2</span>
        	<input id="fileupload-2" type="file" name="files">
        	<input type="hidden" name="image-2" id="image-2" value="">
    	</span>
	</td>
	<td style="width:33%;text-align:center;">
		<span class="btn btn-success fileinput-button">
        	<i class="glyphicon glyphicon-plus"></i>
        	<span>Imagen 3</span>
        	<input id="fileupload-3" type="file" name="files">
        	<input type="hidden" name="image-3" id="image-3" value="">
    	</span>
	</td>
</tr>
<tr>
	<td style="width:33%;text-align:center;">
		<div id="file-1" class="files" style='text-align:center;'>
			<?php if (isset($img_info[0]['image_link'])){ ?>
			<img src="//<?php echo $img_info[0]['image_link']; ?>" width="70%" id="preview-<?php echo $img_info[0]['id_image']; ?>">
			<div class="caption" style='text-align:center;margin-top:5px;'>
  				<a href="javascript:;" onclick="deleteImageGallery(<?php echo $id_product; ?>,<?php echo $img_info[0]['id_image']; ?>);" class="btn btn-danger" role="button">Eliminar Imagen</a> 
  				<!--<a href="javascript:;" onclick="fnChangeCoverImage(<?php echo $id_product; ?>,<?php echo $img_info[0]['id_image']; ?>);" class="btn btn-primary" role="button">Cover</a> -->
  				
  			</div>
  			<?php } ?>
		</div>
	</td>
	<td style="width:33%;text-align:center;">
		<div id="file-2" class="files" style='text-align:center;'>
			<?php if (isset($img_info[1]['image_link'])){ ?>
			<img src="//<?php echo $img_info[1]['image_link']; ?>" width="70%" id="preview-<?php echo $img_info[1]['id_image']; ?>">
			<div class="caption" style='text-align:center;'>
      			<a href="javascript:;" onclick="deleteImageGallery(<?php echo $id_product; ?>,<?php echo $img_info[1]['id_image']; ?>);" class="btn btn-danger" role="button">Eliminar Imagen</a> 
      			<!--<a href="javascript:;" onclick="fnChangeCoverImage(<?php echo $id_product; ?>,<?php echo $img_info[1]['id_image']; ?>);" class="btn btn-primary" role="button">Cover</a> -->
      		</div>
      		<?php } ?>
		</div>
	</td>
	<td style="width:33%;text-align:center;">
		<div id="file-3" class="files" style='text-align:center;'>
			<?php if (isset($img_info[2]['image_link'])){ ?>
			<img src="//<?php echo $img_info[2]['image_link']; ?>" width="70%" id="preview-<?php echo $img_info[2]['id_image']; ?>">
			<div class="caption" style='text-align:center;'>
  				<a href="javascript:;" onclick="deleteImageGallery(<?php echo $id_product; ?>,<?php echo $img_info[2]['id_image']; ?>);" class="btn btn-danger" role="button">Eliminar Imagen</a> 
  				<!--<a href="javascript:;" onclick="fnChangeCoverImage(<?php echo $id_product; ?>,<?php echo $img_info[2]['id_image']; ?>);" class="btn btn-primary" role="button">Cover</a> -->
  			</div>
  			<?php } ?>
		</div>
	</td>
</tr>
</table>