<?php

require_once('db_functions.php');

$action = $_REQUEST['action'];

switch($action){
	case "updateProduct":
		//check all needed variables submitted

		//submit changes to database
		$result = updateProduct($_REQUEST['id'],$_REQUEST['wid'],$_REQUEST['visible'],$_REQUEST['category']);
		echo $result;
		break;
	case "updateCategory":
		//check all needed variables submitted

		//submit changes to database
		$result = updateCategory($_REQUEST['id'],$_REQUEST['wid'],$_REQUEST['description'],$_REQUEST['visible'],$_REQUEST['order'],$_REQUEST['displayType']);
		echo $result;
		break;
}

?>