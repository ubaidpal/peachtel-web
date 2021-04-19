<?php

require_once('db_functions.php');

if(!session_id()){ session_start(); }

$action = $_REQUEST['action'];

  //WHMCS API info
$url = "localhost/clients/includes/api.php"; # URL to WHMCS API file goes here
$username = "vlapi"; # Admin username goes here
$password = "cde$33MC"; # Admin password goes here

switch($action){

	case "account":
		  //check all needed variables submitted
		$email = $_REQUEST['email'];
		  //send user to WHMCS
		if(isset($email)){
			$whmcsurl = "localhost/clients/dologin.php";
			$autoauthkey = "yhjkFH5FH";
			$timestamp = time(); # Get current timestamp
			$goto = "clientarea.php";

			$hash = sha1($email.$timestamp.$autoauthkey); # Generate Hash

			# Generate AutoAuth URL & Redirect
			$url = $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
			header("Location: $url");
		}else{
			echo "Transfer Failed";
		}
		break;

	case "saveQuote":
		$date = date('m-d-Y');
		$postfields["action"] = "createquote";
		$postfields["username"] = $username;
		$postfields["password"] = md5($password);
		$postfields["userid"] = $_SESSION['uid'];
		$postfields["subject"] = "Quote Builder";
		$postfields["stage"] = "Draft";
		$postfields["validuntil"] = date('m/d/Y', strtotime("+12 months $date"));
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
		  //if quote created, add line items manually (needed so we can add PID which is not added with API)
		  //set some default variables applied to all line items
		$quoteID = $arr['WHMCSAPI']['QUOTEID'];
		$quantity = "1";
		$taxable = "1";
		$discount = "0.00";
		if($arr['WHMCSAPI']['RESULT'] == "success"){
			$lineItems = explode("|",$_REQUEST['items']);
			for($y=0;$y<count($lineItems);$y++){
				$itemsArr = explode("+",$lineItems[$y]);
				$arr = array();
				for ($z=0;$z<count($itemsArr);$z++){
					$item = explode("=",$itemsArr[$z]);
					$arr[$item[0]] = $item[1];
				}
				$status = addQuoteItemWHMCS($quoteID.",'".$arr['description']."',".$quantity.",".$arr['unitprice'].",".$discount.",".$taxable.",".$arr['PID']);
				  //if successfully added items to quote, resave quote to update price
				if($status == 1){
					$postfields["action"] = "updatequote";
					$postfields["username"] = $username;
					$postfields["password"] = md5($password);
					$postfields["quoteid"] = $quoteID;
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
				
					echo "Quote Saved";
				}else{
					echo "ERROR Saving Quote";
				}
			}
			
		}else{
			echo "ERROR Saving Quote";
		}
		break;

	case "saveQuote":
		
		break;
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