<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/menu.php";
$obj_seller = new SellerInfoDetail($_SESSION["marketplace_seller_id"]);
	//
$cat = new Category($obj_seller->id_category);
$url_tienda = BAZARINGA_WWWPATH."/".$obj_seller->id_category."-".$cat->link_rewrite[2];
loadjs('js/proveedores.js');
?>
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-body">
	      <!-- content dynamically inserted -->
	    </div>
	  </div>
	</div>
</div>

<a data-toggle="modal" data-width="1024px" data-height="900" class="btn btn-success" href="<?php echo $url_tienda; ?>" data-target="#myModal">Previsualizar Tienda</a>