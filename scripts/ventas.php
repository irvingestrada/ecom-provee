<?php
  include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/core.php";
  include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/menu.php";
  
  function getListEstatus(){
    $array = array();
    $array[] = array ("id" => 2, "Texto" => "Pago Realizado");
    $array[] = array ("id" => 4, "Texto" => "Enviado");
    $array[] = array ("id" => 5, "Texto" => "Entregado");
    $array[] = array ("id" => 6, "Texto" => "Cancelado");
    $array[] = array ("id" => 7, "Texto" => "Devolución");
    return $array;
  }

  function getRealStatus ($id){
    switch ($id) {
      case 'Payment accepted':
        return 'Pago Realizado';
        break;
      case 'Shipped':
        return 'Enviado';
        break;
      case 'Delivered':
        return 'Entregado';
        break;
      case 'Canceled':
        return 'Cancelado';
        break;
      case 'Refund':
        return 'Devolución';
        break;
      case 'Tarjeta de Credito / Debito':
        return 'Pago TC/Debito';
        break;
      case 'Esperando respuesta proveedor de pago':
        return 'Pago TC/Debito';
        break;
      case 'Pago con Oxxo':
        return 'Pago en Oxxo';
        break;
      default:
          $pago = "Error estatus";
        break;
      return $pago;
    }
  }
?>
<table class="table">	
  <thead>
    <tr>
      <th class="col-md-3">#orden</th>
      <th class="col-md-3">Fecha</th>
      <th class="col-md-3">Dirección</th>
      <th class="col-md-3">Nombre cliente</th>
      <th class="col-md-3">Monto</th>
      <th class="col-md-3">Estatus pago</th>
      <th class="col-md-3">Cambiar Estatus</th>
    </tr>
  </thead>
  <tbody>
<?php

$dashboard      = Db::getInstance()->executeS("SELECT ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as customer_name, date(ord.`date_add`) as date_add,ords.`name`as order_status,ord.`id_currency` as `id_currency`, ad.address1, ad.city, ords.* from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."address` ad on (ad.`id_address` = ord.`id_address_delivery`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$_SESSION['id_lang']." and cus.`id_customer`=" . $_SESSION['id_customer'] . "  GROUP BY ordd.`id_order` order by ordd.`id_order` desc");

foreach ($dashboard as $key => $obje) { ?>	
	<tr>
      <td><a href="#" class="btn btn-sm btn-success"
   data-toggle="modal"
   data-target="#detalle_modal" onclick="loadorderinfo(<?php echo $obje['id_order']; ?>);return false;"><?php echo $obje['id_order']; ?> </a></td>
      <td><?php echo $obje['date_add'];?></td>
      <td><?php echo $obje['address1']; ?></td>
      <td><?php echo $obje['customer_name']; ?></td>
      <td><?php echo number_format($obje['total_price'],2,'.',','); ?></td>
      <td><?php echo getRealStatus ($obje['order_status']); ?></td>
      <td><select id="estatus-<?php echo $obje['id_order']; ?>">
        <option value = ''>Seleccionar</option>
        <?php 
          $estatus = getListEstatus();
          foreach ($estatus as $key) {
            echo "<option value = '".$key['id']."'>".$key['Texto']."</option>";
          }

        ?>
      </select>
      &nbsp;&nbsp;
      <button type="button" class="btn btn-small" onclick="fnCambiarEstatus(<?php echo $obje['id_order']; ?>);">Cambiar</button>
    </td>
    </tr>
<?php } ?>
  </tbody>
</table>
<div class="modal fade" id="detalle_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <h3>Información de la Orden <span id="det-order-id"></h3>
                <div id="ajax_content"></div>
            </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function loadorderinfo(id_order){
    
    $.ajax({
      url: '/scripts/loadOrderDetail.php?id_order='+id_order,
        success: function(data) {
          $("#ajax_content").html(data);
        }
    });


  }


  function fnCambiarEstatus(id_order){
    var estatus = $("#estatus-"+id_order).val();
    if (id_order!=''){
      $.ajax({
        url: '/scripts/ajax-update-status.php?id_order='+id_order+'&id_status='+estatus,
          success: function(data) {
            window.location.reload();
          }
      });
    }
  }
</script>