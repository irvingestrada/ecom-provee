<?php
	include "basic_include.php";
	
	$id_order = $_GET['id_order'];

	$ord_obj = new Order($id_order);

	$currency_detail = Currency::getCurrency($ord_obj->id_currency);

	$dashboard   = Db::getInstance()->executeS("SELECT cntry.`name` as `country`,stat.`name` as `state`,ads.`postcode` as `postcode`,ads.`city` as `city`,ads.`phone` as `phone`,ads.`phone_mobile` as `mobile`,ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,ord.`current_state` as current_state,cus.`firstname` as name,cus.`lastname` as lastname,ord.`date_add` as `date`,ords.`name`as order_status,ads.`address1` as `address1`,ads.`address2` as `address2`, ordd.*, `ord`.shipping_number from  `"._DB_PREFIX_."order_detail` ordd join `"._DB_PREFIX_."orders` ord ON (ord.`id_order` = ordd.`id_order`) join `"._DB_PREFIX_."customer` cus on (cus.`id_customer`= ord.`id_customer`) join `"._DB_PREFIX_."order_state_lang` ords on (ord.`current_state`= ords.`id_order_state`) join `"._DB_PREFIX_."address` ads on (ads.`id_customer`= cus.`id_customer`) join `"._DB_PREFIX_."state` stat on (stat.`id_state`= ads.`id_state`) join `"._DB_PREFIX_."country_lang` cntry on (cntry.`id_country`= ads.`id_country`) where ordd.`id_order`=".$id_order." and cntry.`id_lang`=".$id_lang);  

	if(empty($dashboard)) {
		$dashboard   = Db::getInstance()->executeS("SELECT cntry.`name` as `country`,ads.`postcode` as `postcode`,ads.`city` as `city`,ads.`phone` as `phone`,ads.`phone_mobile` as `mobile`,ordd.`id_order_detail` as `id_order_detail`,ordd.`product_name` as `ordered_product_name`,ordd.`product_price` as total_price,ordd.`product_quantity` as qty, ordd.`id_order` as id_order,ord.`id_customer` as order_by_cus,ord.`payment` as payment_mode,ord.`current_state` as current_state,cus.`firstname` as name,cus.`lastname` as lastname,ord.`date_add` as `date`,ords.`name`as order_status,ads.`address1` as `address1`,ads.`address2` as `address2` from  `"._DB_PREFIX_."order_detail` ordd join `"._DB_PREFIX_."orders` ord ON (ord.`id_order` = ordd.`id_order`) join `"._DB_PREFIX_."customer` cus on (cus.`id_customer`= ord.`id_customer`) join `"._DB_PREFIX_."order_state_lang` ords on (ord.`current_state`= ords.`id_order_state`) join `"._DB_PREFIX_."address` ads on (ads.`id_customer`= cus.`id_customer`) join `"._DB_PREFIX_."country_lang` cntry on (cntry.`id_country`= ads.`id_country`) where ordd.`id_order`=".$id_order." and cntry.`id_lang`=".$id_lang);  
		
		$dashboard_state = "N/A";
	} else {
		$dashboard_state = $dashboard[0]['state'];
	}
	$a=0;
	foreach($dashboard as $dashboard1)
	{
		$dash_price[] = number_format($dashboard1['total_price'], 2, '.', '');
		$a++;
	}
	$param = array('flag'=>$_GET['flag'],'shop'=>$_GET['shop'],'l'=>$_GET['l'],'id_order'=>$_GET['id_order']);

	$current_state = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow("SELECT `current_state` from `"._DB_PREFIX_."orders` where id_order=".$id_order);
	
	$order_info = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SELECT * FROM `'._DB_PREFIX_.'order_detail` od JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id) JOIN `'._DB_PREFIX_.'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop) join `'._DB_PREFIX_.'marketplace_shop_product` msp ON (msp.`id_product`=p.`id_product`) WHERE od.`id_order` = '.$id_order);

	$retorno = array();
	$retorno['detail_order'] = $order_info;
	$retorno['order_info'] = $dashboard;
	//$retorno['precios'] = $dash_price;
	$retorno['dashboard_state'] = $dashboard_state;

	//echo json_encode($retorno);
  //var_dump($dashboard);
	?>
<form id="frmEditOrder" method="post" action="/scripts/proc_modorderestatus.php">
  <input type="hidden" name="id_order" id="id_order" value="<?php echo $id_order; ?>">
<table width="100%" class="table">
  <tr>
    <td>
      <h4>Detalle cliente</h4>
      Nombre : <?php echo $dashboard[0]['name']; ?><br/>
      Dirección : <?php echo $dashboard[0]['address1']." ".$dashboard[0]['address2']; ?><br/>
      Codigo Postal : <?php echo $dashboard[0]['postcode']; ?><br/>
      Ciudad : <?php echo $dashboard[0]['city']; ?><br/>
      Estado : <?php echo $dashboard_state; ?><br/>
      Pais : <?php echo $dashboard[0]['country']; ?><br/>
      Telefono contacto : <?php echo $dashboard[0]['mobile']; ?>
    </td>
    <td>
      <h4>Orden</h4>
      Estatus de pago : <?php echo getDetailRealStatus ($dashboard[0]['order_status']); ?><br/>
      Dirección envio : <?php echo $dashboard[0]['address1']; ?><br/>
      Codigo Postal : <?php echo $dashboard[0]['postcode']; ?><br/>
      Ciudad : <?php echo $dashboard[0]['city']; ?><br/>
      Estado : <?php echo $dashboard[0]['state']; ?><br/>
      Pais : <?php echo $dashboard[0]['country']; ?><br/>
      Metodo de pago : <?php echo $dashboard[0]['payment_mode']; ?>    
    </td>
  </tr>
</table>
<table width="100%" class="table">
  	<tr>
   		<th>Producto</th>
   		<th>Cantidad</th>
   		<th>Precio</th>
  	</tr>
<?php foreach ($order_info as $ord_info) {?>
	<tr>
			<td><?php echo $ord_info['product_name']; ?></td>
			<td><?php echo $ord_info['product_quantity']; ?></div>
			<td><?php echo number_format($ord_info['total_price_tax_incl'],2,'.',','); ?></div>
	</tr>
<?php } ?>
</table>
<table width="100%" class="table">
  <tr>
      <th colspan="2"><Strong>Cambiar Estatus</Strong></th>
  </tr>
  <tr>
      <td>Estatus de pago</td>
      <td>
        <select id="OrdenEstatusCambio" name="OrdenEstatusCambio">
          <option value="0">seleccionar</option>
          <?php 
          if ($dashboard[0]['order_status']=="Payment accepted" || $dashboard[0]['order_status']=="Shipped" || $dashboard[0]['order_status']=="Delivered"  || 1==1){
          ?>
            <option value="Refund">Devolución Producto</option>
            <option value="Refund">Devolución Dinero</option>
            <option value="Canceled">Cancelado</option>
          <?php } ?>
        </select>
      </td>
    </tr>
  <tr>
      <td>Estatus de envio</td>
      <td>
        <select id="OrdenEnvioCambio" name="OrdenEnvioCambio" onchange="fnChangeShipped(this.value);">

          <option value="0">seleccionar</option>
          <?php 
          $display="";
          if ($dashboard[0]['order_status']=="Payment accepted" || $dashboard[0]['order_status']=="Shipped" || $dashboard[0]['order_status']=="Delivered"  || 1==1){
            if (strlen($dashboard[0]['shipping_number'])==0){
              $display="style='display:none'";
          ?>
          <option value="">Sin enviar</option>
            <?php } ?>
          <option value="Shipped">Enviado</option>
          <option value="Delivered">Entregado</option>
          <?php } ?>
        </select>

      </td>
  </tr>
  <tr <?php echo $display; ?> id="show_guia">
      <td>Número de guia:</td>
      <td>
        <input name="num_guia" id="num_guia" value="<?php echo $dashboard[0]['shipping_number']; ?>" />
      </td>
  <tr>

  <tr>
    <td colspan="2">
      <a class="btn btn-success" href="/index.php?nav=ventas">Regresar</a>
      <input type="submit" value="Actualizar" class="btn btn-success">
    </td>
  </tr>

</table>
</form>