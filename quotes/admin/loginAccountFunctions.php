<?php

require_once('db_functions.php');

if(!session_id()){ session_start(); }

$action = $_REQUEST['action'];

switch($action){
	case "check":
		if(isset($_SESSION['uid'])){
			echo $_SESSION['WHMCSemail'];
		}else{
			echo 0;
		}
		break;
	case "login":
		//check all needed variables submitted

		//verify account and return true or false
		$result = verifyUser($_REQUEST['username'],$_REQUEST['password']);
		//print_r($result);
		if($result['RESULT'] == "success"){
			echo $result['USERID'];
			setSessionCookies($result['USERID'],$result['PASSWORDHASH'],$_REQUEST['username']);
		}else{
			echo "error";//"Login Failed";
		}
		break;
	case "logout":
		unset($_COOKIE['WHMCSUID']);
		unset($_COOKIE['WHMCSPW']);
		unset($_SESSION['uid']);
		unset($_SESSION['upw']);
		echo "Logged Out";	
		break;
	case "createAccount":
		//check all needed variables submitted

		//Create account
		$result = addClient($_REQUEST['firstName'],$_REQUEST['lastName'],$_REQUEST['company'],$_REQUEST['email'],$_REQUEST['phone'],$_REQUEST['password']);
		if($result == 1){
			echo "Success";
		}else{
			echo "Account Creation Failed - ".$result;
		}
		break;
	case "getShipping":
		$result = getClientDetails($_REQUEST['uid']);
		if($result){
			echo "email=".$result['EMAIL']."&address1=".$result['ADDRESS1']."&address2=".$result['ADDRESS2']."&city=".$result['CITY']."&state=".$result['STATE']."&zip=".$result['POSTCODE'];
		}else{
			echo "error";
		}
		break;
	case "updateShipping":
		  //check all needed variables submitted
		if(isset($_REQUEST['address1'])){$address1 = $_REQUEST['address1'];}else{$address1 = "";}
		if(isset($_REQUEST['address2'])){$address2 = $_REQUEST['address2'];}else{$address2 = "";}
		if(isset($_REQUEST['city'])){$city = $_REQUEST['city'];}else{$city = "";}
		if(isset($_REQUEST['state'])){$state = $_REQUEST['state'];}else{$state = "";}
		if(isset($_REQUEST['zip'])){$zip = $_REQUEST['zip'];}else{$zip = "";}
		  //update shipping information - user,address1,address2,city,state,zip
		$result = updateShipping($_REQUEST['uid'],$address1,$address2,$city,$state,$zip);
		if($result == 1){
			echo "Success";
		}else{
			echo "Failed to update shipping information";
		}
		break;
	case "getPayment":
		  //
		$result = getClientDetails($_REQUEST['uid']);
		if($result){
			echo "cctype=".$result['CCTYPE']."&cclastfour=".$result['CCLASTFOUR'];
		}else{
			echo "error";
		}
		break;
	case "updatePayment":
		  //
		$result = updatePayment($_REQUEST['uid'],$_REQUEST['cctype'],$_REQUEST['ccnum'],$_REQUEST['ccvv'],$_REQUEST['expdate']);
		if($result == 1){
			echo "Success";
		}else{
			echo "Failed to update payment information";
		}
		break;
}

function setSessionCookies($uid,$pass,$email){
	setcookie('WHMCSUID',$uid);
	setcookie('WHMCSPW',$pass);
	$_SESSION['uid'] = $uid;
	$_SESSION['upw'] = $pass;
	$_SESSION['WHMCSemail'] = $email;
}

function verifyUser($user,$pass){
	//WHMCS API info
	$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
	$username = "vlapi"; # Admin username goes here
	$password = "cde$33MC"; # Admin password goes here

	$postfields["action"] = "validatelogin";
	$postfields["email"] = $user;
	$postfields["username"] = $username;
	$postfields["password"] = md5($password);
	$postfields["password2"] = $pass;
	$postfields["responsetype"] = "xml";

	$query_string = "";
	foreach ($postfields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$xml = curl_exec($ch);
	if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.'<message>Connection Error</message><curlerror>'.curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
	curl_close($ch);
 
	$arr = whmcsapi_xml_parser($xml); # Parse XML
	return $arr['WHMCSAPI'];
	/*if($arr['result'] = "success"){
		return 1;
	}else{
		return 0;
	}*/
}

function addClient($first,$last,$company,$email,$phone,$userpassword){
	//WHMCS API info
	$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
	$username = "vlapi"; # Admin username goes here
	$password = "cde$33MC"; # Admin password goes here

	$postfields["username"] = $username;
	$postfields["password"] = md5($password);
	$postfields["action"] = "addclient"; 
	$postfields["firstname"] = $first;
	$postfields["lastname"] = $last;
	$postfields["companyname"] = $company;
	$postfields["email"] = $email;
	$postfields["phonenumber"] = $phone;
	$postfields["password2"] = $userpassword;
	$postfields["skipvalidation"] = "true";
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = explode(";",$data);
	foreach ($data AS $temp) {
		$temp = explode("=",$temp);
		$results[$temp[0]] = $temp[1];
	}
	 
	if ($results["result"]=="success") {
		# Result was OK!
		return 1;
	} else {
		# An error occured
		return $results["message"];
	}
}

function getClientDetails($user){
	//WHMCS API info
	$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
	$username = "vlapi"; # Admin username goes here
	$password = "cde$33MC"; # Admin password goes here

	$postfields["username"] = $username;
	$postfields["password"] = md5($password);
	$postfields["action"] = "getclientsdetails";
	$postfields["clientid"] = $user;
	$postfields["responsetype"] = "xml";

	$query_string = "";
	foreach ($postfields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$xml = curl_exec($ch);
	if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.'<message>Connection Error</message><curlerror>'.curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
	curl_close($ch);
 
	$arr = whmcsapi_xml_parser($xml); # Parse XML
	return $arr['WHMCSAPI']['CLIENT'];
}

function updateShipping($user,$address1,$address2,$city,$state,$zip){
	//WHMCS API info
	$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
	$username = "vlapi"; # Admin username goes here
	$password = "cde$33MC"; # Admin password goes here

	$postfields["username"] = $username;
	$postfields["password"] = md5($password);
	$postfields["action"] = "updateclient";
	$postfields["clientid"] = $user;
	if($address1 != ""){$postfields["address1"] = $address1;}
	if($address2 != ""){$postfields["address2"] = $address2;}
	if($city != ""){$postfields["city"] = $city;}
	if($state != ""){$postfields["state"] = $state;}
	if($zip != ""){$postfields["postcode"] = $zip;}
	$postfields["responsetype"] = "xml";
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	 
	if ($data) {
		# Result was OK!
		return 1;
	} else {
		# An error occured
		return 0;
	}
}

function updatePayment($user,$cctype,$ccnum,$ccvv,$expdate){
	//WHMCS API info
	$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
	$username = "vlapi"; # Admin username goes here
	$password = "cde$33MC"; # Admin password goes here

	$postfields["username"] = $username;
	$postfields["password"] = md5($password);
	$postfields["action"] = "updateclient";
	$postfields["clientid"] = $user;
	$postfields["cardtype"] = $cctype;
	$postfields["cardnum"] = $ccnum;
	$postfields["cvv"] = $ccvv;
	$postfields["expdate"] = $expdate;
	$postfields["responsetype"] = "xml";
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);
	 
	if ($data) {
		# Result was OK!
		return 1;
	} else {
		# An error occured
		return 0;
	}
}

 function whmcsapi_xml_parser($rawxml) {
 	$xml_parser = xml_parser_create();
 	xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
 	xml_parser_free($xml_parser);
 	$params = array();
 	$level = array();
 	$alreadyused = array();
 	$x=0;
 	foreach ($vals as $xml_elem) {
 	  if ($xml_elem['type'] == 'open') {
 		 if (in_array($xml_elem['tag'],$alreadyused)) {
 		 	$x++;
 		 	$xml_elem['tag'] = $xml_elem['tag'].$x;
 		 }
 		 $level[$xml_elem['level']] = $xml_elem['tag'];
 		 $alreadyused[] = $xml_elem['tag'];
 	  }
 	  if ($xml_elem['type'] == 'complete') {
 	   $start_level = 1;
 	   $php_stmt = '$params';
 	   while($start_level < $xml_elem['level']) {
 		 $php_stmt .= '[$level['.$start_level.']]';
 		 $start_level++;
 	   }
 	   $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
 	   @eval($php_stmt);
 	  }
 	}
 	return($params);
 }

?>