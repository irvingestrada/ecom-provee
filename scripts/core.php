<?php

include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/basic_include.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/scripts/routes.php";

function loadjs($js){
	global $jsArray;
	$jsArray[]['JS']=$js;
}

function loadEspecialJS(){
	global $jsArray;
	$return = "";
	foreach ($jsArray as $key) {
		$return.="<script src='".$key['JS']."'></script>";
	}
	echo $return;
}

?>