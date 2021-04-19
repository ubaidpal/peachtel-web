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


if($_REQUEST['address1'] != ""){$in_address1 = $_REQUEST['address1'];}else{$in_address1 = "";}
if($_REQUEST['address2'] != ""){$in_address2 = $_REQUEST['address2'];}else{$in_address2 = "";}
if($_REQUEST['city'] != ""){$in_city = $_REQUEST['city'];}else{$in_city = "";}
if($_REQUEST['state'] != ""){$in_state = $_REQUEST['state'];}else{$in_state = "";}
if($_REQUEST['zip'] != ""){$in_zip = $_REQUEST['zip'];}else{$in_zip = "";}


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

echo $usps_url_code;

//Next the fopen function is used to open the USPS DLL file.
//If the file can not be opened the script should die with some error message.
//Otherwise the script continues.
$open_url = fopen($usps_url_code,"r");

if(!$open_url){
	//die("Could not open $usps_url_code");
	$name_data = array();
	$name_data["error"] = "Could not connect with verification source";
} 
else {
	//echo "<!-- {$usps_url_code} <br> -->";
	$AddressValidateResponse_counter = 0;
	$address_counter = 0;
	
	$name_data = array();
	$xml_current_tag_state = '';
	
	//The XML_SET_ELEMENT_HANDLER and XML_SET_CHARACTER_DATA_HANDLER functions use three
	//arguments which come in the form of the StartElement, EndElement and CharacterDataHandle custom functions.
	//Notice that each function contains global variables.
	function startElement($parser, $element_name, $element_attribs){
		global $AddressValidateResponse_counter;
		global $address_counter;
		global $name_data;
		global $xml_current_tag_state;

		if(strtoupper($element_name) == "ADDRESSVALIDATERESPONSE"){
			if(isset($element_attribs["ID"])) $name_data[$AddressValidateResponse_counter]["id"] = $element_attribs["ID"];
		}
		elseif(strtoupper($element_name) == "ADDRESS"){
			$name_data[$address_counter]["id"] = $element_attribs["ID"];
		}
		elseif(strtoupper($element_name) == "ERROR"){
			$address_counter--;
			//die("ERROR: THE ADDRESS COULD NOT BE FOUND. CHECK THE ACCURACCY OF YOUR SUBMISSION.");
			$name_data["error"] = "That address could not be found. Please check the accuracy of your submission<br>";
			//$name_data["error"] = $element_attribs["ID"];
		}
		else{
			$xml_current_tag_state = $element_name;
		}
	}
	
	function endElement($parser, $element_name){
		global $AddressValidateResponse_counter;
		global $address_counter;
		
		global $name_data;
		global $xml_current_tag_state;
		
		$xml_current_tag_state = ''	;
		
		if(strtoupper($element_name) == "ADDRESSVALIDATERESPONSE"){
			$AddressValidateResponse_counter++;
		}
		if(strtoupper($element_name) == "ADDRESS"){
			$address_counter++;
		}
	}
	
	function CharacterDataHandler($parser, $data){
		global $AddressValidateResponse_counter;
		global $address_counter;
		
		global $name_data;
		global $xml_current_tag_state;
		
		if($xml_current_tag_state == ''){
			return;
		}
		
		$previous_data = array();
		
		if($xml_current_tag_state == "FIRMNAME"){
			$name_data[$address_counter]["company"] = $data;
		}
		if($xml_current_tag_state == "ADDRESS1"){
			$name_data[$address_counter]["address1"] = $data;
		}
		if($xml_current_tag_state == "ADDRESS2"){
			$name_data[$address_counter]["address2"] = $data;
		}
		if($xml_current_tag_state == "CITY"){
			$name_data[$address_counter]["city"] = $data;
		}
		if($xml_current_tag_state == "STATE"){
			$name_data[$address_counter]["state"] = $data;
		}
		if($xml_current_tag_state == "ZIP5"){
			$name_data[$address_counter]["zip5"] = $data;
		}
		if($xml_current_tag_state == "ZIP4"){
			$name_data[$address_counter]["zip4"] = $data;
		}
	}
	if(! $xml_parser = xml_parser_create()){
		die("Could not create XML parser");	
	}
	
	xml_set_element_handler($xml_parser, 'startElement', 'endElement');
	xml_set_character_data_handler($xml_parser, 'CharacterDataHandler');
	
	while($data = fread($open_url, strlen($open_url))){
		if(! xml_parse($xml_parser, $data, feof($open_url))){
			break;	
		}
	}
	
	//If the DLL file was opened the fclose and xml_parser_free functions are used to close the file and free the parser.
	fclose($open_url); 
	xml_parser_free($xml_parser);
	
	//Now that the XML data has been gathered it is time to put the data into usable strings.
	//print "<br>USPS Corrected data<BR>";
	/*
	for($i=0; $i < count($name_data); $i++)
	{
		foreach($name_data[$i] as $key => $value)
		{
			//print $key.": ".$value."<br>";
		}
	}
	*/
	/*
	if($address_counter)
	{
		for($i = 0; $i < $address_counter; $i++)
		{
			$usps_company = $name_data[$i]["company"];
			$usps_address1 = $name_data[$i]["address1"];
			$usps_address2 = $name_data[$i]["address2"];
			$usps_city = $name_data[$i]["city"];
			$usps_state = $name_data[$i]["state"];
			$usps_zip5 = $name_data[$i]["zip5"];
			$usps_zip4 = $name_data[$i]["zip4"];
		}
	}
	*/
}
//End USPS XML Domestic Rate Calculator.

?>