<?php

//require_once('db_functions.php');

if(!session_id()){ session_start(); }

$action = $_REQUEST['action'];

switch($action){
	case "shipping":
		$address1 = $_REQUEST['address1'];
		$city = $_REQUEST['city'];
		$state = $_REQUEST['state'];
		$zip = $_REQUEST['zip'];
		$orderNum = $_REQUEST['ordernum'];
		$contact = $_REQUEST['contact'];
		$shipper = $_REQUEST['shipper'];
		$shippingMethod = $_REQUEST['shippingmethod'];
		$insurance = $_REQUEST['insurance'];
		$deviceList = $_REQUEST['devicelist'];
		
		$url = "https://www.netxusa.com/order2.php"; 
		//$url = "https://provisioning.netxusa.com/order2.php";
	
		$curl['action'] = "shippingquotes";
		$curl['loginname'] = "itaki";
		$curl['loginpass'] = "tg8z2rsb";
		$curl['address1'] = $address1;
		$curl['city'] = $city;
		$curl['state'] = $state;
		$curl['zip'] = $zip;
		$curl['country'] = "US";
		$curl['ordernumber'] = $orderNum;
		$curl['contact'] = $contact;
		$curl['phonenumber'] = "1234567890";  //default this to VoipLion number in case NetX has to call
		$curl['shipper'] = $shipper;
		$curl['shippingmethod'] = $shippingMethod;
		$curl['insurance'] = $insurance;
		$curl['devicelist'] = "@/var/www/quotes/temp/devicelist.csv";
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curl);
		$response = curl_exec($ch); //execute post and get results
        
		if ( $response === false ){
			//echo ('Error, cURL failed.<br>'.curl_errno($ch).': '.curl_error($ch));
			echo ('There was an error getting your quote.  Please try again.');
		}else{
			/*$resp = explode("\n", $response);
			for($i=0;$i<count($resp);$i++){
				echo $resp[$i]."<br>";
			}*/

			$resp = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $response));
			//print_r($resp);
            
			echo "<div class=netxQuoteRow><div class=netxSelect>&nbsp;</div>";  //header row
			for($h=0;$h<count($resp[0]);$h++){
				echo "<div class=netxQuoteHead>".$resp[0][$h]."</div>";
			}
			echo "</div><div class=clear></div>";

			for($c=1;$c<count($resp)-1;$c++){
				echo "<div class=netxQuoteRow>";
				echo "<div class=netxSelect><input type=radio name=selectNetxQuote value=".$resp[$c][0]." cost=".$resp[$c][1]."></div>";
				for($x=0;$x<count($resp[$c]);$x++){
					echo "<div class=netxQuoteItem>".$resp[$c][$x]."</div>";
				}
				echo "</div><div class=clear></div>";
			}

			echo "<a href=# onClick=saveNetxQuote()>Continue with selected Shipping Quote</a>";
		}

		/*echo "<br><br>Variables Sent<BR>";
		foreach($curl as $key => $value){
			echo $key." - ".$value."<br>";
		}*/

		curl_close ($ch);
		break;
}

?>