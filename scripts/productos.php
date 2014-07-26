<?php
	
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/core.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/menu.php";

	$obj_mp_customer = new MarketplaceCustomer();
	$obj_mp_seller = new SellerInfoDetail();
	$obj_mp_shop = new MarketplaceShop();
	$obj_mp_seller_product = new SellerProductDetail();
	$productList = $obj_mp_seller_product->getProductList($_SESSION["marketplace_seller_id"],$orderby,$orderway,1, 100);
	
	?>
	<script type="text/javascript">
		function fnEditProduct(product_id){
			$("#form_product_id").val(product_id);
			$("#tbl_tmpfrm").submit();
		}

		function fnDeleteProduct(product_id){
			var r = confirm("Desea eliminar el producto?");
			if (r){
				$("#tbl_tmpfrm").attr("action", "scripts/proc_deleteproduct.php");
				$("#form_product_id").val(product_id);
				$("#tbl_tmpfrm").submit();
			}
		}
	</script>
	<div style="float:left;margin-bottom:20px;">
		<a href="/index.php?nav=newproduct">
		<button class="btn btn-warning btn-large"><i class="icon-white icon-heart"></i> Agregar Producto</button></a>
	</div>


	<form method = "post" action="/index.php?nav=editproduct" id="tbl_tmpfrm">
		<input type="hidden" value="0" id="form_product_id" name="form_product_id" >
	</form>
	<div class="container"> <?php
	$contador = 0;

	if ($productList){
		foreach ($productList as $key) {
			$contador++;
			if ($contador==1){
				?> </div><div class="row"><?php
			}
			
			if ($contador==4){
				$contador=1;
				?> </div><div class="row"><?php
			}
			?>
				<div class="col-sm-6 col-md-4">
			    	<div class="thumbnail">
			      		<img src="<?php echo $image_url.$key["id_image"]; ?>" width="70%">
			      		<div class="caption">
			        		<h3><?php echo $key["product_name"]; ?></h3>
			        		<p><?php echo $key["description"]; ?></p>
			        		<p><?php echo number_format($key["price"], 2, '.', ''); ?></p>
			        		<p>
			        			<a href="javascript:;" onclick="fnEditProduct(<?php echo $key["id"];?>);" class="btn btn-primary" role="button">Editar</a> 
			        			<a href="javascript:;" onclick="fnDeleteProduct(<?php echo $key["id"];?>);" class="btn btn-danger" role="button">Eliminar</a></p>
			      		</div>
			    	</div>
			  	</div>
			
			<?php
		}
	}
?>
	</div>
</div>	
	