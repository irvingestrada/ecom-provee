<?php
	include "basic_include.php";
	$id_order = $_GET['id_order'];
	$id_status = $_GET['id_status'];
	$order = new Order((int)$id_order);
	$history = new OrderHistory();
	$history->id_order = (int)($id_order);
	$history->changeIdOrderState($id_status, $order);
	$history->addWithemail();
?>