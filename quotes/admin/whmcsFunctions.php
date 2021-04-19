 <?php
 /* *** WHMCS XML API Sample Code *** */

function whmcsCall($action){
 $url = "http://devweb.peachtel.net/clients/includes/api.php"; # URL to WHMCS API file goes here
 $username = "vladmin"; # Admin username goes here
 $password = "cde$33MC"; # Admin password goes here

 $postfields = array();
 $postfields["username"] = $username;
 $postfields["password"] = md5($password);

 switch($action){
   case "getproducts":
	$postfields["action"] = "getproducts";
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
	if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.
	'<message>Connection Error</message><curlerror>'.
	curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
	curl_close($ch);

	$arr = whmcsapi_xml_parser($xml); # Parse XML


	//Debug Output - Uncomment if needed to troubleshoot problems
	//echo "<textarea rows=50 cols=100>";/*Request: ".print_r($postfields,true);*/
	//echo "\nArray: ".print_r($arr,true);
	//echo "</textarea>";

	return($arr); # Output XML Response as Array

   break;
   case "addclient":

   break;
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
