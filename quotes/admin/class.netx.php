<?php

class netx
{
	public $debug = array();

	private $orderURL = "https://provisioning.netxusa.com/order2.php";
	public $loginname = "voiplioncomm";
	public $loginpass = "g0th1c";

	private $orderInfo = array();
	private $deviceFile;
	private $deviceFileExists = 0;
	private $deviceFilePath;
	public $OrderID;

	public $arrProducts = array();
	public $arrUser = array();
	public $shipper;
	public $shipping_method;

	public $ftp_user = "*";
	public $ftp_pass = "*";
	public $ftp_server = "ftp://phones.voiplion.net";

	public $arrNoProvision = array(
		"WIP330", 
		"2200-44140-001", 
		"2200-17568-001", 
		"2200-17569-001", 
		"2200-11700-025", 
		"2200-07155-002", 
		"2215-07155-001", 
		"2200-12750-025", 
		"EM-5300-100", 
		"GXP2110",
		"__SPA508G_AC",
		"__SPA504G_AC",
		"SPA3102-NA",
		"MB100",
		"SPA500S-RO12",
		"SPA500S",
		"__SPA504G_AC-RO12",
		"__SPA525-G2_AC-RO12",
		"SLM224GT-NA"
	);

	private $types = array(
		'GND' => 'Ground',
		'3DS' => '3-day',
		'2DA' => '2-day',
		'1DP' => 'Overnight',
		'1DA' => 'Priority Overnight',
		'1DM' => 'Overnight Early AM',
		'1DML' => 'Next Day Air Early AM Letter',
		'1DAL' => 'Next Day Air Letter',
		'1DAPI' => 'Next Day Air Intra (Puerto Rico)',
		'1DPL' => 'Next Day Air Saver Letter',
		'2DM' => '2nd Day Air AM',
		'2DML' => '2nd Day Air AM Letter',
		'2DAL' => '2nd Day Air Letter',
		'GNDCOM' => 'Ground Commercial',
		'GNDRES' => 'Ground Residential',
		'STD' => 'Canada Standard',
		'XPR' => 'International Priority',
		'XPRL' => 'worldwide Express Letter',
		'XDM' => 'International Economy',
		'XDML' => 'Worldwide Express Plus Letter',
		'XPD' => 'Worldwide Expedited');

	private $reverse_types = array(
		'Ground' => 'GND',
		'3-day' => '3DS',
		'2-day' => '2DA',
		'Overnight' => '1DP',
		'Priority Overnight' => '1DA',
		'Overnight Early AM' => '1DM',
		'International Priority' => 'XPR',
		'International Economy' => 'XDM');

	public $order_values = array
		(
			"loginname"		=> "",
			"loginpass"		=> "",
			"action"		=> "",
			"ordernumber"		=> "",
			"company"		=> "",
			"contact"		=> "",
			"phonenumber"		=> "",
			"email"			=> "",
			"shipper"		=> "",
			"shippingmethod"	=> "",
			"insurance"		=> "Yes",
			"saturday"		=> "No",
			"address1"		=> "",
			"address2"		=> "",
			"city"			=> "",
			"state"			=> "",
			"zip"			=> "",
			"country"		=> "",
			"devicelist"		=> "",
			"instructions"		=> "",
			"serverip"		=> "",
			"vmcallback"		=> "",
			"sntpserver"		=> "",
			"offset"		=> "",
			"netmask"		=> "",
			"gateway"		=> "",
			"host"			=> "",
			"domain"		=> "",
			"dns1"			=> "",
			"dns2"			=> ""
		);


	function netx()
	{
		global $ROOT_PATH;
		$this->deviceFilePath = $ROOT_PATH."store/cache/";
	}

	function submitOrder($testing=0)
	{
		if($testing && $this->loginname == "voiplioncomm")
		{
			$this->loginname = "VOIPLION.COM TEST 2";
			$this->loginpass = "tffj0sfb";
		}

		$this->order_values['ordernumber'] = $testing ? time() : $this->OrderID;

		if($this->createDeviceFile())
		{
			$this->order_values['loginname'] = $this->loginname;
			$this->order_values['loginpass'] = $this->loginpass;
			$this->order_values['action'] = "submitorder";
			

			$this->order_values['shipper'] = $this->shipper;
			$this->order_values['shippingmethod'] = $this->shipping_method;

			$this->setOrderValues_user();

			$ch = curl_init($this->orderURL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->order_values); // use HTTP POST to send form data (array)...interpreted as multi-part form-data...tis is for sending the devicefile
			$resp = curl_exec($ch); //execute post and get results
			curl_close ($ch);

			$resp = explode(":", $resp);

			//If we get a positive response, update order status to Processing
			if($resp[0] == "000")
			{
				return "SUCCESS";
			}
			else
			{
				return "ERROR sending order to NetX. " . $resp[0] . ":" . $resp[2];
			}
		}
		else
		{
			return "Cannot get device list";
		}
	}

	function getQuote($method = '')
	{
		$shipper = $method == "UPS" ? 2 : 1;

		$this->OrderID = isset($this->arrUser['accountcode']) ? $this->arrUser['accountcode'] : "12345"; //this should be a QB quote number
		$this->order_values['ordernumber'] = $this->OrderID;

		if($this->createDeviceFile())
		{
			$this->order_values['loginname'] = $this->loginname;
			$this->order_values['loginpass'] = $this->loginpass;
			$this->order_values['action'] = "shippingquotes";

			$this->order_values['shipper'] = $shipper;
			$this->order_values['shippingmethod'] = "Ground";

			$this->setOrderValues_user();

			$tmp_debug = "";
			foreach($this->order_values as $key => $value)
			{
				if($key != "loginname" && $key != "loginpass")
				{
					$tmp_debug .= "$key:$value, ";
				}
			}
			codeLog("NETX order_values: $tmp_debug");


			$ch = curl_init($this->orderURL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->order_values); // use HTTP POST to send form data (array)...interpreted as multi-part form-data...this is for sending the devicefile
			$resp = curl_exec($ch); //execute post and get results

			$succeeded = (curl_errno($ch) == 0);
			if (!$succeeded)
			{
			        //echo curl_error($ch);
				codeLog("NETX Quote curl error: ".curl_error($ch));
				curl_close ($ch);
				return array("error:error:Unable to contact shipper");
			}

			curl_close ($ch);
			codeLog("NETX Quote result:$resp ");

			$resp = explode("\n", $resp);

			return $resp;
		}
		else
		{
			return array("error:error:Cannot get device list");
		}
	}

	function setOrderValues_user()
	{
		$this->order_values['company'] = $this->arrUser['company'];
		$this->order_values['contact'] = $this->arrUser['contact'];
		$this->order_values['phonenumber'] = $this->arrUser['phonenumber'];
		$this->order_values['address1'] = $this->arrUser['address1'];
		$this->order_values['address2'] = $this->arrUser['address2'];
		$this->order_values['city'] = $this->arrUser['city'];
		$this->order_values['state'] = $this->arrUser['state'];
		$this->order_values['zip'] = $this->arrUser['zip'];
		$this->order_values['country'] = $this->arrUser['country'];

		$tmp_debug = "";
		foreach($this->arrUser as $key => $value)
		{
			$tmp_debug .= "$key:$value, ";
		}
		codeLog("NETX arrUser: $tmp_debug");
	}

	function createDeviceFile()
	{
		if($this->deviceFileExists)
		{
			//return true;
		}
		$eol = PHP_EOL;

		$this->deviceFile = $this->deviceFilePath . $this->OrderID . "_".time()."_devicelist.txt";

		codeLog("NETX create device file ".$this->deviceFile);

		//array_push($this->debug, count($this->arrProducts));
		$devicelist = "";
		for($i=0; $i < count($this->arrProducts); $i++)
		{
			$products_model = $this->arrProducts[$i]['products_model'];
			$manufacturers_name = $this->arrProducts[$i]['manufacturers_name'];
			$qty = $this->arrProducts[$i]['qty'];
			codeLog("products_model:$products_model, manufacturers_name:$manufacturers_name, qty:$qty");

			for($j=0; $j < $this->arrProducts[$i]['qty']; $j++)
			{
				//Not all items can be provisioned...get a list of those and set $provision accordingly
				$provision = in_array($products_model, $this->arrNoProvision) ? "no" : "yes";

				if($manufacturers_name == "Cisco" || $manufacturers_name == "Linksys")
				{
					$Server = "http://phones.voiplion.net/cisco.php/spa\$MA.cfg";
					$S_User = "*";
					$S_Password = "*";
				}
				else
				{
					$Server = $this->ftp_server;		//isset($this->arrUser['ppt_settings']['ftp_server']) ? $this->arrUser['ppt_settings']['ftp_server'] : "";
					$S_User = $this->ftp_user;		//isset($this->arrUser['ppt_settings']['ftp_user']) && !empty($this->arrUser['ppt_settings']['ftp_user']) ? $this->arrUser['ppt_settings']['ftp_user'] : "*";
					$S_Password = $this->ftp_pass;		//isset($this->arrUser['ppt_settings']['ftp_pass']) && !empty($this->arrUser['ppt_settings']['ftp_pass']) ? $this->arrUser['ppt_settings']['ftp_pass'] : "*";
				}

				$devicelist .= $manufacturers_name . "," . $products_model . ",$provision,,,,,,,,$Server,$S_User,$S_Password$eol";
			}
		}

		//create a devicefile to send
		$Content = "Make,Part Number,Provision,User ID,Password,Full Name,Display Name,Num Line Keys,AddReg,IP Address,Server,S_User,S_Password$eol";
		$Content .= $devicelist;
	
		if (@!$handle = fopen($this->deviceFile, 'w+')) 
		{
			//die("Cannot create $this->deviceFile");
			return false;
		}

		// Write to our opened file.
		if (@fwrite($handle, $Content) === FALSE) 
		{
			//die("Cannot write to $this->deviceFile");
			return false;
		}
		fclose($handle);

		$deviceFile = $this->deviceFile;
		$this->deviceFileExists = 1;
		$this->order_values['devicelist'] = "@{$deviceFile}";

		return true;
	}

	function trackOrder($orderid)
	{
		global $MAIN_INCLUDE_PATH;
		require_once($MAIN_INCLUDE_PATH."code_tracker.php"); 

		$this->order_values['loginname'] = $this->loginname;
		$this->order_values['loginpass'] = $this->loginpass;
		$this->order_values['action'] = "ordertracking";
		$this->order_values['ordernumber'] = $orderid;

		$ch = curl_init($this->orderURL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->order_values); // use HTTP POST to send form data (array)...interpreted as multi-part form-data...this is for sending the devicefile
		$result = curl_exec($ch); //execute post and get results

		$succeeded = (curl_errno($ch) == 0);
		if (!$succeeded)
		{
			codeLog("[class.netx] trackOrder($orderid) curl failure ".curl_error($ch));
			return "Error=curl failure (trackOrder). ".curl_error($ch);
		}

		curl_close ($ch);

		codeLog("[class.netx] trackOrder($orderid) - Result: $result ");

		if(substr_count($result, "Error") > 0)
		{
			return "Error=unknown";
		}

		if(substr_count($result, "down for maintenance") > 0)
		{
			return "Error=down for maintenance";
		}

		$tmp = explode(":", $result);
//return $tmp;
		if($tmp[0] == "No tracking information available.")
		{
			return $tmp[0];
		}
		else
		{
			$tmp = explode(",", str_replace("\n", "", $tmp[0]));
			$shipper = $tmp[0];
			$tracking_number = $tmp[1];
			$trackURL = "http://wwwapps.ups.com/WebTracking/processInputRequest?HTMLVersion=5.0&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=en_US&InquiryNumber1={$tracking_number}&AgreeToTermsAndConditions=yes&track.x=27&track.y=11";
			if($shipper == "FedEx")
			{
				$trackURL = "http://www.fedex.com/Tracking?ascend_header=1&clienttype=dotcom&cntry_code=us&language=english&tracknumbers={$tracking_number}";
			}
			return "$shipper,$tracking_number,$trackURL";
		}
	}

	function getDeviceList($orderid)
	{
		$this->order_values['loginname'] = $this->loginname;
		$this->order_values['loginpass'] = $this->loginpass;
		$this->order_values['action'] = "devicelist";
		$this->order_values['ordernumber'] = $orderid;
		//$this->order_values['full'] = "Yes";

		$ch = curl_init($this->orderURL);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->order_values); // use HTTP POST to send form data (array)...interpreted as multi-part form-data...this is for sending the devicefile
		$result = curl_exec($ch); //execute post and get results

		$succeeded = (curl_errno($ch) == 0);
		if (!$succeeded)
		{
	     	   return "Error=curl failure (getDeviceList). ".curl_error($ch);
		}

		curl_close ($ch);

		//return $result;

		$result = explode("\n",$result);
		for($j=1; $j < count($result); $j++)
		{
			if($result[$j] != "")
			{
				$arrTemp = explode(",", $result[$j]);
				$result[$j] = $arrTemp;
			}
		}
		if(substr_count($result[0], "Not Found") > 0)
		{
			//print "Order Not Found";
			return "Error=".$result[0][0] . " Order# ". $orderid;
		}
		else
		{
			//start this at 1 because response contains a header row
			$arr = array();
			for($j=1; $j < count($result)-1; $j++)
			{
				$tmp = array(
					"Make"=>$result[$j][0],
					"Model"=>$result[$j][1],
					"MAC"=>$result[$j][2],
					"Serial Number"=>$result[$j][3]
				);
				array_push($arr, $tmp);
				$tmp_debug = "";
				foreach($result[$j] as $key => $value)
				{
					$tmp_debug .= "$key:$value<br>";
				}
				//codeLog("NETX getDeviceList: $tmp_debug");
			}
			return $arr;
		}
	}
}

/*
Array
(
    [0] => 8
    [address_book_id] => 8
    [1] => 9
    [customers_id] => 9
    [2] => m
    [entry_gender] => m
    [3] => VOIPLION.COM
    [entry_company] => VOIPLION.COM
    [4] => Dave
    [entry_firstname] => Dave
    [5] => Prisock
    [entry_lastname] => Prisock
    [6] => 514 Flat Shoals Ave SE
    [entry_street_address] => 514 Flat Shoals Ave SE
    [7] => Ste 840
    [entry_suburb] => Ste 840
    [8] => 30076
    [entry_postcode] => 30076
    [9] => Roswell
    [entry_city] => Roswell
    [10] => GA
    [entry_state] => GA
    [11] => 223
    [entry_country_id] => 223
    [12] => 19
    [entry_zone_id] => 19
    [entry_country] => US
    [phonenumber] => 404-666-2202
    [products] => Array
        (
            [0] => Array
                (
                    [qty] => 1
                    [products_model] => 2200-12320-025
                    [manufacturers_name] => Polycom
                )

        )
)
*/





?>