<?php
/*
WHAT IT IS:
This script is a PHP (Hypertext Preprocessor) script that is designed to Validate Postal Address in locations ware the United States of America has Jurisdiction over and 
output the Verified Address Information from the United States Postal Service.

TITLE: USPS XML Address Verification PHP Script.

VERSION: 1.0.

AUTHOR:
Eric-Dana:Williams (A.K.A Sulaiman Aleem), Founder of FreshSoftware.net. A Rah Technologies company. 

REQUIREMENTS:
1) An HTTP Server (Perpherably Apache).
2) PHP version 5.0 or later configured with the following options:
   --with-xml, --with-expat-dir.  
3) A USPS (United States Postal Service) Web Tools user account and password for the Address Information API. 
   Note: Permissions for access to the Address Information API is seperate from access permission for other USPS API's.
   Visit http://usps.com/webtools or http://usps.com for more information
4) USPS Web Tools Administrative/Technical Guides. Available at http://usps.com/webtools.
5) An internet connection.

DISCLAIMER:
THIS PHP SCRIPT IS A PRODUCTION OF RAH TECHNOLOGIES INC THAT IS PROVIDED ON AN "AS IS" BASIS. RAH TECHNOLOGIES INC 
MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, AS TO THE OPERATION OF THIS PHP SCRIPT, THE
INFORMATION, CONTENT, MATERIALS OR ITEMS WITH IN THIS SCRIPT. TO THE FULL EXTENT ALLOWABLE BY LAW, RAH TECHNOLOGIES INC
DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE. RAH TECHNOLOGIES INC WILL NOT BE LIABLE FOR ANY DAMAGES OF ANY KIND ARISING FROM THE USE OF THIS PHP SCRIPT,
INCLUDING BUT NOT LIMITED TO DIRECT, INDIRECT, INCIDENTAL PUNITIVE AND CONSEQUENTIAL DAMAGES. ANY MATERIAL DOWNLOADED 
OR OTHERWISE OBTAINED THROUGH THE USE OF THIS PHP SCRIPT IS DONE AT YOUR OWN DISCRETION AND RISK AND THAT YOU WILL BE SOLELY 
RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM(S) OR LOSS OF DATA THAT RESULTS FROM THE DOWNLOAD OR PURCHASE OF ANY SUCH MATERIAL.
NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM Rah TECHNOLOGIES INC AND OR AFFILIATES OF RAH TECHNOLOGIES INC
WILL CREATE ANY WARRANTY NOT EXPRESSLY STATED IN THE TERMS OF PURCHASE.

LICENSE:
This PHP script can be modified to suit the needs of a single web site shopping cart.
This PHP script can not be redistirbuted by any means and or condition.

*/

//The following lines of text contains PHP code needed to make this script work.
//Perform any editing with care.

//Obtain a valid USPS USER ID and Password from http://usps.com/webtools or http://usps.com.
$usps_user_id = "199ARETT5175";
$usps_passwd = "120OQ88ZM416";


if(isset($_REQUEST['address1'])){$in_address1 = $_REQUEST['address1'];}else{$in_address1 = "";}
if(isset($_REQUEST['address2'])){$in_address2 = $_REQUEST['address2'];}else{$in_address2 = "";}
if(isset($_REQUEST['city'])){$in_city = $_REQUEST['city'];}else{$in_city = "";}
if(isset($_REQUEST['state'])){$in_state = $_REQUEST['state'];}else{$in_state = "";}
if(isset($_REQUEST['zip'])){$in_zip = $_REQUEST['zip'];}else{$in_zip = "";}


//Empty spaces must be removed from the all XML input or XML will issue an error.
//Change the actual postal codes to the correct postal code.
$company = "";//rawurlencode(trim("$company"));
$address1 = rawurlencode(trim("$in_address1"));
$address2 = rawurlencode(trim("$in_address2"));
$city = rawurlencode(trim("$in_city"));
$state = rawurlencode(trim("$in_state"));
$zip5 = trim("$in_zip");
$zip4 = "";//trim("$zip4");

$usps_url_code = "http://production.shippingapis.com/";
$usps_url_code .= "ShippingAPI.dll?";

$usps_url_code .= "API=Verify&";
$usps_url_code .= "XML=<AddressValidateRequest%20USERID=\"{$usps_user_id}\"%20PASSWORD=\"{$usps_passwd}\">";
$usps_url_code .= "<Address%20ID=\"0\">";
$usps_url_code .= "<FirmName>$company</FirmName>";
$usps_url_code .= "<Address1>$address2</Address1>";
$usps_url_code .= "<Address2>$address1</Address2>";
$usps_url_code .= "<City>$city</City>";
$usps_url_code .= "<State>$state</State>";
$usps_url_code .= "<Zip5>$zip5</Zip5>";
$usps_url_code .= "<Zip4>$zip4</Zip4>";
$usps_url_code .= "</Address>";
$usps_url_code .= "</AddressValidateRequest>";


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $usps_url_code);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$xml = curl_exec($ch);
	if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.'<message>Connection Error</message><curlerror>'.curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
	curl_close($ch);
 
	$arr = whmcsapi_xml_parser($xml); # Parse XML
	//print_r($arr['ADDRESSVALIDATERESPONSE']);
	//echo "<br>";
	if(isset($arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ERROR'])){
		echo "ERROR";
	}else{
		$returnVar = "address1=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS2']."&";
		if(isset($arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS1'])){
			$returnVar .= "address2=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS1']."&";
		}else{
			$returnVar .= "address2=&";
		}
		$returnVar .= "city=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['CITY']."&";
		$returnVar .= "state=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['STATE']."&";
		$returnVar .= "zip=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ZIP5'];
		echo $returnVar;
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