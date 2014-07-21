<table class="table">	
  <thead>
    <tr>
      <th class="col-md-3">#orden</th>
      <th class="col-md-3">Fecha</th>
      <th class="col-md-3">Dirección</th>
      <th class="col-md-3">Nombre cliente</th>
      <th class="col-md-3">Monto</th>
      <th class="col-md-3">Estatus pago</th>
      <th class="col-md-3">Estatus envio</th>
    </tr>
  </thead>
  <tbody>
<?php

$dashboard      = Db::getInstance()->executeS("SELECT ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,cus.`firstname` as name, date(ord.`date_add`) as date_add,ords.`name`as order_status,ord.`id_currency` as `id_currency`, ad.address1, ad.city from `" . _DB_PREFIX_ . "marketplace_shop_product` msp join `" . _DB_PREFIX_ . "order_detail` ordd on (ordd.`product_id`=msp.`id_product`) join `"._DB_PREFIX_."orders` ord on (ordd.`id_order`=ord.`id_order`) join `"._DB_PREFIX_."address` ad on (ad.`id_address` = ord.`id_address_delivery`) join `"._DB_PREFIX_."marketplace_seller_product` msep on (msep.`id` = msp.`marketplace_seller_id_product`) join `"._DB_PREFIX_."marketplace_customer` mkc on (mkc.`marketplace_seller_id` = msep.`id_seller`) join `" . _DB_PREFIX_ . "customer` cus on (mkc.`id_customer`=cus.`id_customer`) join `" . _DB_PREFIX_ . "order_state_lang` ords on (ord.`current_state`=ords.`id_order_state`) where ords.id_lang=".$id_lang." and cus.`id_customer`=" . $customer_id . "  GROUP BY ordd.`id_order` order by ordd.`id_order` desc");

foreach ($dashboard as $key => $obje) { ?>	
	<tr>
      <td><?php echo $obje['id_order_detail']; ?></td>
      <td><?php echo $obje['date_add']; ?></td>
      <td><?php echo $obje['address1']; ?></td>
      <td><?php echo $obje['name']; ?></td>
      <td><?php echo $obje['total_price']; ?></td>
      <td><?php echo $obje['order_status']; ?></td>
      <td></td>
    </tr>
<?php } ?>
  </tbody>
</table>	