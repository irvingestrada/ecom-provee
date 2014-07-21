<?php

if ($_SESSION['logueado']==true){
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/core.php";
}else{
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/core.php";
	include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/logueate.php";
}
?>