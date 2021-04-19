<?php


require_once("../../includes/_getpaths.php");

//need this? too paranoid? ;-)
if(!isset($_SERVER['HTTP_REFERER']))
{
	exit;
}
if(substr_count($_SERVER['HTTP_REFERER'], "/quotebuilder/") == 0 && substr_count($_SERVER['HTTP_REFERER'], "/admin2/") == 0 && substr_count($_SERVER['HTTP_REFERER'], "/agent/") == 0)
{
	exit;
}

if(!isset($_GET['action']))
{
	exit;
}

$NetPBX_LimitedGroupID = 17;
$NetPBX_Limited_grandfather_date = $isDev ? "1317441600" : "1318305600"; //timestamp for 10-11-2011 00:00:00 = "1318305600"

require_once($MAIN_INCLUDE_PATH."code_tracker.php"); 
require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
require_once($MYACCOUNT_PATH."classes/class.store.php");
require_once($MAIN_INCLUDE_PATH."classes/class.error.php"); 
require_once($MAIN_INCLUDE_PATH."classes/class.quote.php");
require_once($MYACCOUNT_PATH."classes/class.customer.php");

require_once($MAIN_INCLUDE_PATH."adminActivity.php");

$isVoiplion = isset($_SESSION['voiplion']) ? 1 : 0;
$isCCSAgent = isset($_SESSION['ccs_agent']) ? 1 : 0;

$isAdmin = isset($_SESSION['adminloggedinstatus']) || $isVoiplion ? 1 : 0;
$adminParam = $isAdmin && !$isVoiplion ? "&p=quote_single_qb2" : "";
$adminusername = isset($_SESSION['adminusername']) ? $_SESSION['adminusername'] : "unknown";

$adminusername = $adminusername == "unknown" && $isVoiplion ? $_SESSION['voiplion']['user'] : $adminusername;

$action = isset($_GET['action']) ? $_GET['action'] : "";

$userid = isset($_SESSION['Quote_uid']) ? $_SESSION['Quote_uid'] : 0;
$userid = !$userid && isset($_GET['uid']) ? $_GET['uid'] : $userid;
echo "userid=".$userid;

$quote_id = isset($_SESSION['Quote']['id']) ? $_SESSION['Quote']['id'] : 0;
$quote_id = !$quote_id && isset($_GET['qid']) ? $_GET['qid'] : $quote_id;

$zoho_lead = 0;//not using
if(isset($_SESSION['zoho_record_id']) && isset($_SESSION['zoho_email']))
{
	$zoho_lead = 1;
}
if(!isset($_SESSION['google_lead_tracked']))
{
	$_SESSION['google_lead_tracked'] = 0;
}

$ignoredActions = array("delete_quote", "processed", "resend_confirmation", "resend_confirmation_admin");

if(!$quote_id && !in_array($action, $ignoredActions))
{
	$quote = new quote();
	if($isVoiplion)
	{
		$quote->qbC = 1;
	}
	else if($isCCSAgent)
	{
		$quote->qbA = 1;
	}
	$result = $quote->newQuote($userid);
	$quote_id = $_SESSION['Quote']['id'] = $quote->quote_id;

	/*BYE BYE ZOHO
	if(isset($_SESSION['zoho_record_id']) && isset($_SESSION['zoho_email']))
	{
		$zoho_lead = 1;
		require_once($MAIN_INCLUDE_PATH."classes/class.zoho.php");
		$zoho = new zoho();

		$zoho->action = "updateLeadStatus";
		$lead_status = 0;
		$lead_priority = "Partial";
		$zoho->updateLeadStatus($_SESSION['zoho_record_id'], $lead_status, $lead_priority);

		$zoho->action = "insertNote";
		$subject = "Started Quote Number {$quote_id}";
		$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
		$zoho->insertNote($_SESSION['zoho_record_id'], $subject, $note);
	}
	*/
}

$quote = new quote($quote_id,$userid);

//$quote_details = $quote->getQuote($quote_id);

$accountcode = isset($_SESSION['uid']) && !$isVoiplion ? $_SESSION['uid'] : 0;
$loggedin = 0;
if($accountcode)
{
	/*
		had a case where we obviously had an accountcode but the user somehow used a different email when creating a quote.

		HOW DOES THIS EVEN HAPPEN!?!

		we need to check both emails (if we have them here). if different...unset customer, unset _SESSION['uid']
	*/
	$customer = new customer($accountcode);
	$loggedin = 1;
	if(!$userid)
	{
		$cardnumber = "";
		$cardtype = "";
		$exp = "";
		$cvv = "";
		//can't get cc info from whmcs...go to voiplionweb
		$row_cc = $customer->details_cc;
		$hasCC = $customer->hasCC;
		$CCverified = $customer->CCverified;
		if($hasCC)
		{
			$cardnumber = $customer->details_cc['cardnumber'];
			$cardtype = $customer->details_cc['cardtype'];
			$exp = str_replace("/", "", $customer->details_cc['exp']);
			$cvv = $customer->details_cc['cvv'];
		}

		$checkaba = "";
		$checkaccount = "";
		$account_type = "";
		$account_holder_type = "";

		if($customer->hasACH)
		{
			$checkaba = $customer->details_ach['checkaba'];
			$checkaccount = $customer->details_ach['checkaccount'];
			$account_type = $customer->details_ach['account_type'];
			$account_holder_type = $customer->details_ach['account_holder_type'];
		}

		//use original whmcs password encryption
		require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
		$whmcs = new whmcs();

		$get_password = $whmcs->getClientsPassword($accountcode);
		$password = $get_password['password'];

		//check if they have a quote record
		if(!$quote->userExists($customer->details['email']))
		{
			$userid = 0;
			$ip = $_SERVER['REMOTE_ADDR'];
			$host = gethostbyaddr("$ip");
			$arrUser = array(
				"userid" => 0,
				"isClient" => 1,
				"accountcode" => $accountcode,
				"email" => $customer->details['email'],
				"password" => $password,
				"firstname" => $customer->details['firstname'],
				"lastname" => $customer->details['lastname'],
				"companyname" => $customer->details['companyname'],
				"address1" => $customer->details['address1'],
				"address2" => $customer->details['address2'],
				"city" => $customer->details['city'],
				"state" => $customer->details['state'],
				"postcode" => $customer->details['postcode'],
				"country" => $customer->details['country'],
				"phonenumber" => $customer->details['phonenumber'],
				"firstname_billing" => $customer->details_billing['firstname'],
				"lastname_billing" => $customer->details_billing['lastname'],
				"companyname_billing" => $customer->details_billing['company'],
				"address1_billing" => $customer->details_billing['address1'],
				"address2_billing" => $customer->details_billing['address2'],
				"city_billing" => $customer->details_billing['city'],
				"state_billing" => $customer->details_billing['state'],
				"postcode_billing" => $customer->details_billing['zip'],
				"country_billing" => $customer->details_billing['country'],
				"phonenumber_billing" => $customer->details_billing['phone'],
				"firstname_shipping" => $customer->details['firstname'],
				"lastname_shipping" => $customer->details['lastname'],
				"companyname_shipping" => $customer->details['companyname'],
				"address1_shipping" => $customer->details['address1'],
				"address2_shipping" => $customer->details['address2'],
				"city_shipping" => $customer->details['city'],
				"state_shipping" => $customer->details['state'],
				"postcode_shipping" => $customer->details['postcode'],
				"country_shipping" => $customer->details['country'],
				"phonenumber_shipping" => $customer->details['phonenumber'],
				"cardnumber" => $cardnumber,
				"cardtype" => $cardtype,
				"exp" => $exp,
				"cvv" => $cvv,
				"checkaba" => $checkaba,
				"checkaccount" => $checkaccount,
				"account_type" => $account_type,
				"account_holder_type" => $account_holder_type,
				"ip" => $ip,
				"host" => $host
			);
			$result = $quote->addUser($arrUser);
			if($result == "SUCCESS")
			{
				$userid = $_SESSION['Quote_uid'] = $quote->userid;
			}
		}
		else
		{
			//make sure isClient and accountcode get set (added current cc info as well)
			if(empty($cardnumber))
			{
				$cardnumber = $quote->user['cardnumber'];
				$cardtype = $quote->user['cardtype'];
				$exp = str_replace("/", "", $quote->user['exp']);
				$cvv = $quote->user['cvv'];
			}
			$arrUser = array(
				"userid" => $quote->userid,
				"isClient" => 1,
				"email" => $customer->details['email'],
				"accountcode" => $accountcode,
				"companyname" => $customer->details['companyname'],
				"address1" => $customer->details['address1'],
				"address2" => $customer->details['address2'],
				"city" => $customer->details['city'],
				"state" => $customer->details['state'],
				"postcode" => $customer->details['postcode'],
				"country" => $customer->details['country'],
				"phonenumber" => $customer->details['phonenumber'],
				"firstname_billing" => $customer->details_billing['firstname'],
				"lastname_billing" => $customer->details_billing['lastname'],
				"companyname_billing" => $customer->details_billing['company'],
				"address1_billing" => $customer->details_billing['address1'],
				"address2_billing" => $customer->details_billing['address2'],
				"city_billing" => $customer->details_billing['city'],
				"state_billing" => $customer->details_billing['state'],
				"postcode_billing" => $customer->details_billing['zip'],
				"country_billing" => $customer->details_billing['country'],
				"phonenumber_billing" => $customer->details_billing['phone'],
				"firstname_shipping" => $customer->details['firstname'],
				"lastname_shipping" => $customer->details['lastname'],
				"companyname_shipping" => $customer->details['companyname'],
				"address1_shipping" => $customer->details['address1'],
				"address2_shipping" => $customer->details['address2'],
				"city_shipping" => $customer->details['city'],
				"state_shipping" => $customer->details['state'],
				"postcode_shipping" => $customer->details['postcode'],
				"country_shipping" => $customer->details['country'],
				"phonenumber_shipping" => $customer->details['phonenumber'],
				"cardnumber" => $cardnumber,
				"cardtype" => $cardtype,
				"exp" => $exp,
				"cvv" => $cvv,
				"checkaba" => $checkaba,
				"checkaccount" => $checkaccount,
				"account_type" => $account_type,
				"account_holder_type" => $account_holder_type
			);
			$result = $quote->updateUser($arrUser);
			$userid = $_SESSION['Quote_uid'] = $quote->userid;
		}

		//set paymentmethod for this quote if not cc
		if(!$hasCC || !$CCverified)
		{
			$arr = array("paymentmethod" => "mailin");
			$result = $quote->updateQuoteMain($arr);
		}
	}
	//TODO: Not logged in -> added phones to quote -> logged in thru My Account -> came back to quote...tax not reflected if GA...non-issue?
}
$loggedin_quote = isset($_SESSION['Quote_uid']) ? $_SESSION['Quote_uid'] : 0;

switch($action)
{
	case "new_quote":
		if(isset($_SESSION['Quote']['id']))
		{
			unset($_SESSION['Quote']['id']);
		}

		if($isVoiplion && isset($_SESSION['Quote_uid']))
		{
			//not sure we want this...
			//unset($_SESSION['Quote_uid']);
		}
		print "newquote";
	break;

	case "show_phones_list":
		$quote_details = $quote->getQuote($quote->quote_id,$userid);
		include("qb_phones_list.php");
	break;

	case "get_channel_list":
		$selected_channels = $_GET['channels'];
		$plantype = $_GET['plantype'];
		$minimum = $plantype == "Pro" ? 5 : 3; //changing PRO Complete from 2 to 3 ch min?
		if($isVoiplion || $quote->qbC == 1)
		{
			$minimum = $plantype == "Pro" ? 1 : 3;
		}

		$selectChannels = "<!--channel_list - $minimum--><select id=channels class=formElement style=\"width:50px;\" onchange=\"setChannels()\">";
		for($i=$minimum; $i < 31; $i++)
		{
			$selected = $i == $selected_channels ? "selected" : "";
			$selectChannels .= "<option value=$i $selected>$i";
		}
		$selectChannels .= "<option value=0>30+";
		//$selectChannels .= $isVoiplion ? "<option value=40>40<option value=52>52<option value=100>100" : "";
		$selectChannels .= "</select>";
		print $selectChannels;
	break;

	case "set_addons":
		//added for sip options...no need to refresh total_totals (except for init deposit)
		//print "<pre>";
		//print_r($_POST);
		//print "</pre>";
		//exit;
		$products = new products();
		$netsip_monthly = 0;
		$one_time = 0;
				
		$netsip_purchase = array();

		$initial_deposit = isset($_POST['initial_deposit']) ? $_POST['initial_deposit'] : 0;
		$one_time += $initial_deposit;
		foreach($_POST as $key => $value)
		{
			if(substr_count($key, "package") > 0)
			{
						if(substr_count($value, "unlimited") > 0)
						{
							$_tmp = explode("_", $value);
							$_idx = $products->getPackageIndexByChannels($_tmp[1]);
							$tmp = $products->getPackageDetail($_idx);
							$netsip_monthly += $tmp['price'];
						}
						else
						{
							$tmp = $products->getPackageDetail($value);//explode("_", $value);
							$netsip_monthly += $tmp['price'];//$tmp[3];
						}
				//$tmp = explode("_", $value);
				//$netsip_monthly += $tmp[3];
				if(!isset($netsip_purchase['packages']))
				{
					$netsip_purchase['packages'] = array();
				}
						$arr = array(
							"index" => $tmp['idx'],
							"name" => $tmp['name'],
							"price" => $tmp['price'],
							"type" => $tmp['type']
						);
				array_push($netsip_purchase['packages'], $arr);
			}
			else if(substr_count($key, "did_") > 0)
			{
				$tmp = explode("_", $key);
				$didPrice = $tmp[2].".".$tmp[3];
				$netsip_monthly += ($didPrice * $value);
				$one_time += ($value * 5);
				if(!isset($netsip_purchase['dids']))
				{
					$netsip_purchase['dids'] = array();
				}
				$arr = array(
					"quantity" => $value,
					"premium" => 5,
					"price" => $didPrice,
					"type" => $tmp[1]
				);
				array_push($netsip_purchase['dids'], $arr);
			}
		}
		$netsip_purchase['options'] = array(
			"is_notify" => $_POST['is_notify'],
			"cancallintl" => $_POST['cancallintl'],
			"initial_deposit" => $_POST['initial_deposit'],
			"autodebit" => $_POST['autodebit'],
			"replenishamount" => $_POST['replenishamount'],
			"replenishto" => $_POST['replenishto'],
			"notifyamt" => $_POST['notifyamt']
		);

		$arr = array("netsip_purchase" => $netsip_purchase);
		$result = $quote->saveQuote_section("netsip", $arr);
	break;

	case "get_dedicated_cost":
		//print_r($_POST);
		//exit;
		$retValue = "<table width=370 cellspacing=0 border=0>";
		$distro = $_POST['distro'];
		$datacenter = $_POST['datacenter'];
		$capacity = $_POST['capacity'];
		$plantype = $_POST['plantype'] == "enhanced" ? "Enhanced Dedicated" : "Dedicated";
		$ha = $_POST['ha'];
		$backup = 0;//$_POST['backup']; //01-10-2011...now included
		$init_config = isset($_POST['init_config']) ? $_POST['init_config'] : 0;

		//derive the product name
		$productname = "NetPBX$capacity $plantype";

		require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
		$products = new products();
		$dedicatedPlans = $products->netpbxProducts(14);
		foreach($dedicatedPlans as $key => $value)
		{
			if($value['name'] == $productname)
			{
				$product = $products->netpbxProduct($value['relid']);
				$price = $value['monthly'];
				$setup = $value['msetupfee'];

				$retValue .= "<tr><td align=center style=\"width:150px;\"><b>\$$setup</b><br>one time setup</td><td width=50% align=center><b>\$$price</b><br>per month</td></tr>";

				$ha_monthly = "";
				if($ha)
				{
					$ha_products = $products->netpbxProducts(10);
					//print_r($ha_products);
					foreach($ha_products as $key => $value)
					{
						if($value['name'] == "NetPBX$capacity Dedicated HA")
						{
							$ha_monthly = number_format($value['monthly'],0);
							break;
						}
					}
				}
				$backup_monthly = "";
				if($backup)
				{
					foreach($product['addons'] as $key => $value)
					{
						if(substr_count($value['name'], "Backup") > 0)
						{
							//$backup_monthly = number_format($value['monthly'],0);
							break;
						}
					}
				}
				$init_config_cost = "";
				if($init_config)
				{
					foreach($product['addons'] as $key => $value)
					{
						if(substr_count($value['name'], "Initial Config") > 0)
						{
							$init_config_cost = number_format($value['monthly'],0);
							break;
						}
					}
				}
				if($ha || $backup || $init_config)
				{
					$retValue .= "<tr><td colspan=2 class=listTextBold>Options:</td></tr><tr><td colspan=2 class=listText> ";
					if($ha)
					{
						$retValue .= "<div style=\"padding-left:10px;\">High Availability: \$$ha_monthly mo.</div>";
					}
					if($backup)
					{
						$retValue .= "<div style=\"padding-left:10px;\">Nightly Backup: \$$backup_monthly mo.</div>";
					}
					if($init_config)
					{
						$retValue .= "<div style=\"padding-left:10px;\">Initial Configuration: \$$init_config_cost one time</div>";
					}
					$retValue .= "</td></tr>";
				}

				$retValue .= "</table>";

				break;
			}
		}
		print $retValue;
		//print_r($_POST);
		//print_r($product);
		//exit;
	break;

	case "get_ha_cost":
		//print_r($_POST);
		//exit;
		$capacity = $_POST['capacity'];
		$plantype = $_POST['plantype'] == "enhanced" ? "Enhanced Dedicated" : "Dedicated";
		$ha = $_POST['ha'];
		if(!$ha)
		{
			print "&nbsp;";
			exit;
		}
		$retValue  = "";

		require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
		$products = new products();
		$ha_products = $products->netpbxProducts(10);
		foreach($ha_products as $key => $value)
		{
			if($value['name'] == "NetPBX$capacity Dedicated HA")
			{
				$retValue  = "$".$value['monthly']." Monthly";
				break;
			}
		}
		print $retValue;
	break;

	case "get_backup_cost":
		$capacity = $_POST['capacity'];
		$plantype = $_POST['plantype'] == "enhanced" ? "Enhanced Dedicated" : "Dedicated";
		$backup = 0;//$_POST['backup']; //01-10-2011...now included
		if(!$backup)
		{
			print "&nbsp;";
			exit;
		}
		$retValue  = "";
		//derive the product name
		$productname = "NetPBX$capacity $plantype";

		require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
		$products = new products();
		$dedicatedPlans = $products->netpbxProducts(14);
		foreach($dedicatedPlans as $key => $value)
		{
			if($value['name'] == $productname)
			{
				$product = $products->netpbxProduct($value['relid']);
				$price = $value['monthly'];
				$setup = $value['msetupfee'];

				//$retValue .= "$price : $setup";
				$retValue .= "<tr><td width=50% align=center><b>\$$setup</b><br>one time setup</td><td width=50% align=center><b>\$$price</b><br>per month</td></tr>";
				$retValue .= "</table>";

				break;
			}
		}
		print $retValue;
	break;

	case "get_totals":
		//print "<pre>";
		//print_r($_POST);
		//print "</pre>";
		//exit;
		$section = isset($_POST['plantype']) && ($_POST['plantype'] == "dedicated" || $_POST['plantype'] == "enhanced") ? "netpbx_dedicated" : $_GET['qb_section'];
		$accountcode = isset($_GET['accountcode']) ? $_GET['accountcode'] : 0;
		$quote_details = $quote->getQuote($quote_id,$userid);
		$retValue = "";
		switch($section)
		{
			case "netpbx_dedicated":
				$backup = 0;//isset($_POST['backup']) ? $_POST['backup'] : 0;
				$high_availability = isset($_POST['ha']) ? $_POST['ha'] : 0;
				$distro = $_POST['distro'];
				$datacenter = $_POST['datacenter'];
				$datacenter_name = explode("_", $datacenter);
				$datacenter_name = $datacenter_name[1];
				$capacity = $_POST['capacity'];
				$plantype = $_POST['plantype'] == "enhanced" ? "Enhanced Dedicated" : "Dedicated";
				//derive the product name
				$productname = "NetPBX$capacity $plantype";

				$init_config = isset($_POST['init_config']) ? $_POST['init_config'] : 0;
				$netpbx_purchase = array();

				require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
				$products = new products();
				$dedicatedPlans = $products->netpbxProducts(14);
				foreach($dedicatedPlans as $key => $value)
				{
					if($value['name'] == $productname)
					{
						$productid = (int)$value['relid'];
						$product = $products->netpbxProduct($value['relid']);
						break;
					}
				}
				if(!isset($product))
				{
					exit;
				}
//print_r($product);
//exit;
				$init_total = 0;
				$pbx_monthly = $product['product']['monthly'];
				$init_total += $product['product']['msetupfee'];
				$netpbx_purchase = array(
					"productid" => $productid,
					"product_name" => $productname,
					"groupname" => $product['product']['groupname'],
					"paytype" => "recurring",
					"pay_option" => "monthly",
					"setup" => $init_total,
					"price" => $pbx_monthly
				);

				//look in $product to get id's/configid's for distro and datacenter
				$netpbx_purchase['configoptions'] = array();
				foreach($product['configoptions'] as $key => $value)
				{
					if($value['optiontype'] == "distro")
					{
						foreach($value['sub'] as $keySub => $valueSub)
						{
							if($valueSub['optionname'] == $distro)
							{
								$tmp = array(
								"type" => "distro",
								"configid" => (int)$value['sub'][$keySub]['configid'],
								"id" => (int)$value['sub'][$keySub]['id'],
								"name" => $value['sub'][$keySub]['optionname']
								);
								array_push($netpbx_purchase['configoptions'], $tmp);
							}
						}
					}
					else if($value['optiontype'] == "datacenter")
					{
						foreach($value['sub'] as $keySub => $valueSub)
						{
							if($valueSub['optionname'] == $datacenter_name)
							{
								$tmp = array(
									"type" => "datacenter",
									"configid" => (int)$valueSub['configid'],
									"id" => (int)$valueSub['id'],
									"name" => $valueSub['optionname']
								);
								array_push($netpbx_purchase['configoptions'], $tmp);
							}
						}
					}
				}

				$netpbx_purchase['addons'] = array();
				if($backup)
				{
					foreach($product['addons'] as $key => $value)
					{
						if(substr_count($value['name'], "Backup") > 0)
						{
							$tmp = array(
								"id" => $value['relid'],
								"name" => $value['name'],
								"billingcycle" => $value['billingcycle'],
								"price" => $value['monthly'],
								"setup" => $value['msetupfee']
							);
							$pbx_monthly += $value['monthly'];
							array_push($netpbx_purchase['addons'], $tmp);
						}
					}
				}

				if($init_config)
				{
					foreach($product['addons'] as $key => $value)
					{
						if(substr_count($value['name'], "Initial Configuration") > 0)
						{
							$tmp = array(
								"id" => $value['relid'],
								"name" => $value['name'],
								"billingcycle" => $value['billingcycle'],
								"price" => $value['monthly'],
								"setup" => $value['msetupfee']
							);
							$init_total += $value['monthly'];
							array_push($netpbx_purchase['addons'], $tmp);
						}
					}
				}

				if(count($netpbx_purchase['addons']) == 0)
				{
					unset($netpbx_purchase['addons']);
				}

				if($high_availability)
				{
					$ha_products = $products->netpbxProducts(10);
//print_r($ha_products);
//exit;
					foreach($ha_products as $key => $value)
					{
						if($value['name'] == "NetPBX$capacity Dedicated HA")
						{
							$productid = (int)$value['relid'];
							$netpbx_purchase['ha_id'] = $productid;
							$netpbx_purchase['ha_price'] = $value['monthly'];
							$pbx_monthly += $value['monthly'];
						}
					}
				}

//print_r($netpbx_purchase);
//exit;

				$arr = array("netpbx_purchase" => $netpbx_purchase);
				$result = $quote->saveQuote_section("netpbx", $arr);

				updateMain();

				if($pbx_monthly == 0 && $init_total == 0)
				{
					$retValue .= "<div style=\"font-size:16px; font-weight:bold; color:#C0C0C0; text-align:center; padding-top:15px;\">EMPTY</div>";
				}
				else
				{
					$pbx_monthly = number_format($pbx_monthly, 2);
					$init_total = number_format($init_total, 2);

					//$retValue .= "<div class=listTextBold style=\"text-align:center;\">$productname</div>";
					$retValue .= "<table width=100% cellspacing=0 border=0>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>Monthly Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$pbx_monthly</td>";
					$retValue .= "</tr>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>One Time Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$init_total</td>";
					$retValue .= "</tr>";
					$retValue .= empty($quote_details['main']['processed']) ? "<tr><td colspan=2><div style=\"float:right; padding-top:5px;\" class=listText><a href=\"javascript:void(0)\" onclick=\"removeCart('netpbx')\">remove all</a></div></td></tr>" : "";
					$retValue .= "</table>";
				}
				print $retValue;
			break;

			case "netpbx":
//print_r($_POST);
				$netpbx_purchase = array();
				$plantype = $_POST['plantype'];
				if($plantype == "unknown")
				{
					exit;
				}
				$channels = $_POST['channels'];
				$datacenter = $_POST['datacenter'];
				$datacenter_name = $_POST['datacenter_name'];

				$bluebox = isset($_POST['bluebox']) ? $_POST['bluebox'] : 0;

				$backup = 0;//isset($_POST['backup']) ? $_POST['backup'] : 0;
				$high_availability = isset($_POST['ha']) ? $_POST['ha'] : 0;

				$init_config = $plantype == "Pro" && isset($_POST['init_config']) ? $_POST['init_config'] : 0;
				$init_total = 0;
				if(!$channels)
				{
					//javascript SHOULD HAVE handled this
					exit;
				}
				//for PRO "Limited" (C quotes only), we should have a different group...should we grandfather existing quotes (by quote_date)?
				//$groupid = $plantype == "Pro" ? 11 : 12;
				if($quote->qbC == 1 && $quote->quote_details['quote_date'] > $NetPBX_Limited_grandfather_date)
				{
					$groupid = $plantype == "Pro" ? $NetPBX_LimitedGroupID : 12;
				}
				else
				{
					$groupid = $plantype == "Pro" ? 11 : 12;
				}

				$pbx_monthly = 0;
				$productid = 0;
				$productname = "";

				require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
				$products = new products();
				$arr = $products->netpbxProducts($groupid);

				foreach($arr as $key => $value)
				{
					$product_channels = explode(" ", $value['name']);
					$product_channels = $product_channels[2];
					if($product_channels == $channels)
					{
						$productid = (int)$value['relid'];
						$productname = $value['name'];
						$product = $products->netpbxProduct($productid);
//print "$productid<BR>";
//print_r($product);
						$pbx_monthly = $product['product']['monthly'];
						//$init_total += $groupid == 12 ? $product['product']['msetupfee'] : 0;
						$init_total += isset($product['product']['msetupfee']) ? $product['product']['msetupfee'] : 0;
						$netpbx_purchase = array(
							"productid" => $productid,
							"product_name" => $productname,
							"groupname" => $product['product']['groupname'],
							"paytype" => "recurring",
							"pay_option" => "monthly",
							"setup" => $init_total,
							"price" => $pbx_monthly,
							"bluebox" => $bluebox
						);
						//look in $product to get id's/configid's for distro and datacenter
						$netpbx_purchase['configoptions'] = array();
						foreach($product['configoptions'] as $key => $value)
						{
//print_r($product['configoptions']);
							if($value['optiontype'] == "distro")
							{
								$tmp = array(
									"type" => "distro",
									"configid" => (int)$value['sub'][0]['configid'],
									"id" => (int)$value['sub'][0]['id'],
									"name" => $value['sub'][0]['optionname']
								);
								array_push($netpbx_purchase['configoptions'], $tmp);
							}
							else if($value['optiontype'] == "datacenter")
							{
								foreach($value['sub'] as $keySub => $valueSub)
								{
									if($valueSub['optionname'] == $datacenter_name)
									{
										$tmp = array(
											"type" => "datacenter",
											"configid" => (int)$valueSub['configid'],
											"id" => (int)$valueSub['id'],
											"name" => $valueSub['optionname']
										);
										array_push($netpbx_purchase['configoptions'], $tmp);
//print_r($netpbx_purchase);
										break;
									}
								}
							}
						}

						$netpbx_purchase['addons'] = array();
//print_r($product['addons']);
						foreach($product['addons'] as $key => $value)
						{
							if(substr_count($value['name'], "Configuration") > 0 && $init_config)
							{
								$tmp = array(
									"id" => $value['relid'],
									"name" => $value['name'],
									"billingcycle" => $value['billingcycle'],
									"price" => $value['monthly'],
									"setup" => $value['msetupfee']
								);
								$init_total += $value['monthly'];
								array_push($netpbx_purchase['addons'], $tmp);
							}
							else if(substr_count($value['name'], "Backup") > 0 && $backup)
							{
								$tmp = array(
									"id" => $value['relid'],
									"name" => $value['name'],
									"billingcycle" => $value['billingcycle'],
									"price" => $value['monthly'],
									"setup" => $value['msetupfee']
								);
								$pbx_monthly += $value['monthly'];// + $value['msetupfee'];
								array_push($netpbx_purchase['addons'], $tmp);
							}
						}
						if(count($netpbx_purchase['addons']) == 0)
						{
							unset($netpbx_purchase['addons']);
						}
						break;
					}
				}
//print_r($netpbx_purchase['addons']);
				if($high_availability)
				{
					$arr = $products->netpbxProducts(13);
					foreach($arr as $key => $value)
					{
						$product_channels = explode(" ", $value['name']);
						$product_channels = $product_channels[2];
						if($product_channels == $channels)
						{
							$productid = (int)$value['relid'];
							$netpbx_purchase['ha_id'] = $productid;
							$netpbx_purchase['ha_price'] = $value['monthly'];
							$pbx_monthly += $value['monthly'];
						}
					}
				}

				//if this is a Complete, we need to add $netpbx_purchase['customfields'] for DID and Package
				//this is side-stepping the way QB1 was done...that had 'customfields' associated with each WHMCS product
				$modified = false;
				if($groupid == 12)
				{
					$netpbx_purchase['customfields'] = array();
					$tmp = array(
						"id" => 1,
						"name" => "did",
						"index" => "NA",
						"type" => "did"
					);
					array_push($netpbx_purchase['customfields'], $tmp);

					//now we gotta find the right package
					$packages = $products->netsipPackages(5);
					foreach($packages as $key => $value)
					{
						if(substr_count($value['name'], "NetPBX") > 0)
						{
							$package_channels = str_replace("NetPBX", "", $value['name']);
							$package_channels = str_replace("ch SIP Complete", "", $package_channels);
							if($package_channels == $channels)
							{
								$tmp = array(
									"id" => "NA",
									"name" => $value['name'],
									"index" => $value['idx'],
									"type" => "package"
								);
								array_push($netpbx_purchase['customfields'], $tmp);
							}
						}
					}

					//If user had a US48 pkg selected, we need to drop it...and let them know?					
					if(isset($quote_details['netsip_packages']))
					{
						
						foreach($quote_details['netsip_packages'] as $key => $value)
						{
							if($value['type'] == 1 || substr_count($value['name'], "PRO Unlimited") > 0)
							{
								$modified = true;
								unset($quote_details['netsip_packages'][$key]);
							}
						}
						if(count($quote_details['netsip_packages']) == 0)
						{
							unset($quote_details['netsip_packages']);
						}

						if($modified)
						{
							$netsip_purchase = array();
							if(isset($quote_details['netsip_options']))
							{
								$netsip_purchase['options'] = $quote_details['netsip_options'];
							}
							if(isset($quote_details['netsip_packages']))
							{
								$netsip_purchase['packages'] = $quote_details['netsip_packages'];
							}
							if(isset($quote_details['netsip_dids']))
							{
								$netsip_purchase['dids'] = $quote_details['netsip_dids'];
							}
							if(count($netsip_purchase))
							{
								$arr = array("netsip_purchase" => $netsip_purchase);
								$result = $quote->saveQuote_section("netsip", $arr);
							}
						}
					}
				}
				$arr = array("netpbx_purchase" => $netpbx_purchase);
//print_r($arr);
				$result = $quote->saveQuote_section("netpbx", $arr);


				updateMain();

				if($pbx_monthly == 0 && $init_total == 0)
				{
					$retValue .= "<div style=\"font-size:16px; font-weight:bold; color:#C0C0C0; text-align:center; padding-top:15px;\">EMPTY</div>";
				}
				else
				{
					$pbx_monthly = number_format($pbx_monthly, 2);
					$init_total = number_format($init_total, 2);

					//$retValue .= "<div class=listTextBold style=\"text-align:center;\">$productname</div>";
					$retValue .= "<table width=100% cellspacing=0 border=0>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>Monthly Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$pbx_monthly</td>";
					$retValue .= "</tr>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>One Time Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$init_total</td>";
					$retValue .= "</tr>";
					$retValue .= empty($quote_details['main']['processed']) ? "<tr><td colspan=2><div style=\"float:right; padding-top:5px;\" class=listText><a href=\"javascript:void(0)\" onclick=\"removeCart('netpbx')\">remove all</a></div></td></tr>" : "";
					$retValue .= "</table>";
				}

				if($modified)
				{
					print "go";
					exit;
				}
				print $retValue;
			break;

			case "netsip":
				//print "<pre>";
				//print_r($_POST);
				//print_r($quote_details);
				//print "</pre>";
				//exit;
				$products = new products();
				$netsip_monthly = 0;
				$one_time = 0;
				
				$netsip_purchase = array();

				$initial_deposit = isset($_POST['initial_deposit']) ? $_POST['initial_deposit'] : 0;
				foreach($_POST as $key => $value)
				{
					if(substr_count($key, "package") > 0)
					{
						if(substr_count($value, "unlimited") > 0)
						{
							$_tmp = explode("_", $value);
							$_idx = $products->getPackageIndexByChannels($_tmp[1]);
							$tmp = $products->getPackageDetail($_idx);
							$netsip_monthly += $tmp['price'];
						}
						else
						{
							$tmp = $products->getPackageDetail($value);//explode("_", $value);
							$netsip_monthly += $tmp['price'];//$tmp[3];
						}
						if(!isset($netsip_purchase['packages']))
						{
							$netsip_purchase['packages'] = array();
						}
						$arr = array(
							"index" => $tmp['idx'],
							"name" => $tmp['name'],
							"price" => $tmp['price'],
							"type" => $tmp['type']
						);
						array_push($netsip_purchase['packages'], $arr);
					}
					else if(substr_count($key, "did_") > 0)
					{
						$tmp = explode("_", $key);
						$didPrice = $tmp[2].".".$tmp[3];
						$netsip_monthly += ($didPrice * $value);
						$one_time += ($value * 5);
						if(!isset($netsip_purchase['dids']))
						{
							$netsip_purchase['dids'] = array();
						}
						$arr = array(
							"quantity" => $value,
							"premium" => 5,
							"price" => $didPrice,
							"type" => $tmp[1]
						);
						array_push($netsip_purchase['dids'], $arr);
					}
				}
				if((isset($netsip_purchase['packages']) && count($netsip_purchase['packages'])) || (isset($netsip_purchase['dids']) && count($netsip_purchase['dids'])))
				{
					$initial_deposit = $initial_deposit == "select..." ? 50 : $initial_deposit;
				}
				$initial_deposit = $initial_deposit == "select..." ? 0 : $initial_deposit;
				$one_time += is_numeric($initial_deposit) ? $initial_deposit : 0;

				if((is_numeric($initial_deposit) && $initial_deposit > 0) || $one_time > 0)
				{
					$netsip_purchase['options'] = array(
						"is_notify" => $_POST['is_notify'],
						"cancallintl" => $_POST['cancallintl'],
						"initial_deposit" => $initial_deposit,
						"autodebit" => $_POST['autodebit'],
						"replenishamount" => $_POST['replenishamount'],
						"replenishto" => $_POST['replenishto'],
						"notifyamt" => $_POST['notifyamt']
					);
				}

				//print "<pre>";
				//print_r($netsip_purchase);
				//print "</pre>";

				$arr = array("netsip_purchase" => $netsip_purchase);
				$result = $quote->saveQuote_section("netsip", $arr);

				updateMain();

				if(isset($quote_details['netsip_credit']))
				{
					foreach($quote_details['netsip_credit'] as $key => $value)
					{
						$one_time -= $value['amount'];
					}
				}
				if($netsip_monthly == 0 && $one_time == 0)
				{
					$retValue .= "<div style=\"font-size:16px; font-weight:bold; color:#C0C0C0; text-align:center; padding-top:15px;\">EMPTY</div>";
				}
				else
				{
					$netsip_monthly = number_format($netsip_monthly,2);
					$one_time = number_format($one_time,2);

					$retValue .= "<table width=100% cellspacing=0 border=0>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>Monthly Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$netsip_monthly</td>";
					$retValue .= "</tr>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>One Time Charges</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$one_time</td>";
					$retValue .= "</tr>";
					$retValue .= empty($quote_details['main']['processed']) ? "<tr><td colspan=2><div style=\"float:right; padding-top:5px;\" class=listText><a href=\"javascript:void(0)\" onclick=\"removeCart('netsip')\">remove all</a></div></td></tr>" : "";

					$retValue .= "</table>";
				}

				print $retValue;
			break;

			case "phones":
				//print "<pre>";
				//print_r($_POST);
				//print "</pre>";
				$arr = array();
				
				$products_subtotal = 0;
				$products_subtotal_taxable = 0;

				//do not set $store_purchase['shipping'] in here...force re-calculation of shippping if anything gets posted here
				$store_purchase = array("cart" => array());
				$products = new products();
				$category_id = -1;
				$taxrate = $products->taxrate;
				//we're only taxing orders going to GA
				$taxrate = isset($quote_details['user']['state_shipping']) && !empty($quote_details['user']['state_shipping']) && $quote_details['user']['state_shipping'] == "GA" ? $taxrate : 0;

				if(count($_POST))
				{
					$arrProducts = $products->storeDisplay();
					//print "<pre>";
					//print_r($arrProducts);
					//print "</pre>";

					//$store_purchase = array("cart" => array());
					foreach($_POST as $key => $value)
					{
						if($key == "handsets")
						{
							if($value > 0)
							{
								$products_subtotal += $quote->handset_price_base;
								$subtotal = $products_subtotal;
								if($value > 10)
								{
									$products_subtotal += ($value - 10) * $quote->handset_price_each;
									$subtotal += ($value - 10) * $quote->handset_price_each;
								}
								$tmp = array(
									"products_id" => "handsets",
									"products_qty" => $value,
									"products_name" => "",
									"products_price" => "",
									"subtotal" => $subtotal
								);
								array_push($store_purchase['cart'], $tmp);
							}
							continue;
						}
						$split_key = explode("_",$key);
						$category_id = $split_key[0];
						$productid = $split_key[1];
						
						foreach($arrProducts as $keyP => $valueP)
						{
							if($valueP['products_id'] == $productid)
							{
								$tmp = array(
									"products_id" => $productid,
									"products_qty" => $value,
									"products_name" => $valueP['description'][0]['products_name'],
									"products_price" => $valueP['products_price'],
									"subtotal" => $valueP['products_price'] * $value
								);
								$products_subtotal += $valueP['products_price'] * $value;
								array_push($store_purchase['cart'], $tmp);

								if($valueP['products_tax_class_id'] > 0)
								{
									$products_subtotal_taxable += $valueP['products_price'] * $value;
								}
								break;
							}
						}	
					}
					$arr = array("store_purchase" => $store_purchase);
				}

				$result = $quote->saveQuote_section("phones", $arr);

				$tax = $products_subtotal > 0 ? $products_subtotal_taxable * $taxrate : 0;
				$arr = array("tax" => $tax);
				$result = $quote->updateQuoteMain($arr);


				if($products_subtotal == 0)
				{
					$retValue .= "<div style=\"font-size:16px; font-weight:bold; color:#C0C0C0; text-align:center; padding-top:15px;\">EMPTY</div>";
				}
				else
				{
					$products_subtotal = number_format($products_subtotal,2);
					$shipping_total = 0;//number_format($shipping_total,2);

					$retValue .= "<table width=100% cellspacing=0 border=0>";
					$retValue .= "<tr>";
					$retValue .= "<td class=listTextBold>Subtotal</td>";
					$retValue .= "<td class=pageSubTitle align=right>\$$products_subtotal</td>";
					$retValue .= "</tr>";
					$retValue .= "<tr>";
					$retValue .= $shipping_total == 0 ? "<td colspan=2 align=right class=listText><i>Shipping calculated at checkout</i></td>" : "<td class=listTextBold>Shipping</td><td class=pageSubTitle align=right>$shipping_total</td>";
					$retValue .= "</tr>";
					if($tax != 0)
					{
						$tax = number_format($tax, 2);
						$retValue .= "<tr>";
						$retValue .= "<td class=listTextBold>Tax</td><td class=pageSubTitle align=right>\$$tax</td>";
						$retValue .= "</tr>";
					}
					$retValue .= empty($quote_details['main']['processed']) ? "<tr><td colspan=2><div style=\"float:right; padding-top:5px;\" class=listText><a href=\"javascript:void(0)\" onclick=\"removeCart('phones')\">remove all</a></div></td></tr>" : "";
					$retValue .= "</table>";
				}

				print $retValue;
			break;
		}
	break;

	case "all_totals":
		$retValue = "";
		
		if($_SESSION['google_lead_tracked'] == 0)
		{
			$_SESSION['google_lead_tracked'] = 1;
			$retValue = "<div style=\"display:inline;\"><img height=1 width=1 style=\"border-style:none;\" alt=\"\" src=\"http://www.googleadservices.com/pagead/conversion/1054947361/?label=OsItCN-_0wEQofCE9wM&amp;guid=ON&amp;script=0\"/></div>";
		}
		

		$quote_details = $quote->getQuote($quote_id,$userid);
		$total_monthly = 0;
		$total_one_time = $quote_details['main']['tax'];
		$account_balance = 0;
		if(isset($quote_details['main']['handsets']) && $quote_details['main']['handsets'] > 0)
		{
			$total_one_time += $quote->handset_price_base;
			if($quote_details['main']['handsets'] > 10)
			{
				$total_one_time += ($quote_details['main']['handsets'] - 10) * $quote->handset_price_each;
			}
		}
		if(isset($quote_details['netpbx']))
		{
			$total_monthly += $quote_details['netpbx']['price'];
			$total_monthly += $quote_details['netpbx']['ha_price'];
			$total_one_time += $quote_details['netpbx']['init_config'];
			$total_one_time += $quote_details['netpbx']['setup'];
			if(isset($quote_details['netpbx']['addons']))
			{
				foreach($quote_details['netpbx']['addons'] as $key => $value)
				{
					switch($value['billingcycle'])
					{
						case "Monthly":
						$total_monthly += $value['price'];
						break;
						case "One Time":
						$total_one_time += $value['price'];
						break;
					}
					$total_one_time += $value['setup'];
				}
			}
			$account_balance += $quote_details['netpbx']['groupname'] == "NetPBX PRO Complete" ? 30 : 0;

			if(isset($quote_details['netpbx']['promo_code']) && !empty($quote_details['netpbx']['promo_code']))
			{
				//only gonna look for One Time and (Money Value || Fixed Amount)
				$total_one_time -= $quote_details['netpbx']['discount_value'];
			}
		}

		if(isset($quote_details['netsip_options']))
		{
			$total_one_time += $quote_details['netsip_options']['initial_deposit'];
			$account_balance += $quote_details['netsip_options']['initial_deposit'];
		}
		if(isset($quote_details['netsip_packages']))
		{
			foreach($quote_details['netsip_packages'] as $key => $value)
			{
				$total_monthly += $value['price'];
			}
		}
		if(isset($quote_details['netsip_dids']))
		{
			foreach($quote_details['netsip_dids'] as $key => $value)
			{
				$total_monthly += $value['price'] * $value['quantity'];
				$total_one_time += $value['premium'] * $value['quantity'];
				//$account_balance += ($value['price'] * $value['quantity']) + ($value['premium'] * $value['quantity']);
			}
		}
		if(isset($quote_details['netsip_credit']))
		{
			foreach($quote_details['netsip_credit'] as $key => $value)
			{
				$total_one_time -= $value['amount'];
			}
		}

		if(isset($quote_details['netsip_options']) && ((!isset($quote_details['netsip_packages']) || !count($quote_details['netsip_packages'])) && (!isset($quote_details['netsip_dids']) || !count($quote_details['netsip_dids']))))
		{
			unset($quote_details['netsip_options']);
		}




		if(isset($quote_details['store']))
		{
			foreach($quote_details['store'] as $key => $value)
			{
				if(is_numeric($key))
				{
					$total_one_time += $value['subtotal'];
				}
				else if($key == "shipping")
				{
					$total_one_time += $value[0]['cost'];
				}
			}
		}
		$total_total = $total_monthly + $total_one_time;

		$arr = array(
			"userid" => $userid,
			"AccountBalance" => $account_balance,
			"total" => $total_total,
			"total_onetime" => $total_one_time,
			"total_monthly" => $total_monthly,
			"update_date" => time(),
			"process_all" => 1
		);
		$result = $quote->updateQuoteMain($arr);

		$total_monthly = number_format($total_monthly,2);
		$total_one_time = number_format($total_one_time,2);
		$total_total = number_format($total_total,2);

		if($total_total > 0)
		{
			$retValue .= $total_total > 0 ? "<!--SHOWORDERNOW-->" : "";
			$retValue .= "<table width=100% cellspacing=0 border=0>";
			$retValue .= "<tr>";
			$retValue .= "<td class=listTextBold>Total Monthly</td>";
			$retValue .= "<td class=pageSubTitle align=right>\$$total_monthly</td>";
			$retValue .= "</tr>";
			$retValue .= "<tr>";
			$retValue .= "<td class=listTextBold>Total One Time</td>";
			$retValue .= "<td class=pageSubTitle align=right>\$$total_one_time</td>";
			$retValue .= "</tr>";
			$retValue .= "<tr><td colspan=2><div style=\"padding-top:10px; text-align:center;\" class=pageSubTitle>Total Due Today:</div><div style=\"text-align:center;\" class=pageSubTitle>\$$total_total</div></td></tr>";
			$retValue .= "</table><!--$result-->";
		}

		print $retValue;
	break;

	case "remove_cart":
		$section = $_GET['section'];
		$quote_details = $quote->getQuote($quote->quote_id,$userid);
		$arr = array();
		$result = $quote->saveQuote_section($section, $arr);

		//if anything has been removed, we need to update "main"
		updateMain();

		print "go";
	break;

	case "selected_packages":
		//print_r($_POST);
		//exit;
		$retValue = "<!--PACKAGELIST-->";
		if(count($_POST) == 0)
		{
			$retValue .= "<div style=\"background:#ffffcc; padding:5px;\" class=listTextBold>No packages selected.<br>Calls billed at the standard rate.</div>";
		}
		$products = new products();
		$arrPackages = $products->netsipPackages();
		//print_r($arrPackages);
		foreach($_POST as $key => $value)
		{
			if(substr_count($value, "unlimited") > 0)
			{
				$tmp = explode("_", $value);
				$value = $products->getPackageIndexByChannels($tmp[1]);
			}
			else
			{
				//$value = $tmp[0];
			}

			foreach($arrPackages as $keyP => $valueP)
			{
				if($value == $valueP['idx'])
				{
					$idx = $valueP['idx'];
					$name = $valueP['name'];
					$description = $valueP['description'];
					$retValue .= "<div class=listText><b>$name</b><br>$description<br><a href='javascript:void(0)' onclick='removePackage($idx)'>remove</a></div><br>";
					break;
				}
			}
		}
		print $retValue;
	break;

	case "order_button":
		$confirm = isset($_POST['confirm']) ? $_POST['confirm'] : 0;
		$hasCC = 0;
		if($loggedin)
		{
			$cardnumber = "";
			$cardtype = "";
			$exp = "";
			$cvv = "";
			//can't get cc info from whmcs...go to voiplionweb
			$row_cc = $customer->details_cc;
			$hasCC = $customer->hasCC;
			$CCverified = $customer->CCverified;
			if($hasCC)
			{
				$cardnumber = $row_cc['cardnumber'];
				$cardtype = $row_cc['cardtype'];
				$exp = str_replace("/", "", $row_cc['exp']);
				$cvv = $row_cc['cvv'];
			}

			//use original whmcs password encryption
			require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
			$whmcs = new whmcs();

			$get_password = $whmcs->getClientsPassword($accountcode);
			$password = $get_password['password'];

			//check if they have a quote record
			if(!$quote->userExists($customer->details['email']))
			{
				$userid = 0;
				$ip = $_SERVER['REMOTE_ADDR'];
				$host = gethostbyaddr("$ip");
				$arrUser = array(
					"userid" => 0,
					"isClient" => 1,
					"accountcode" => $accountcode,
					"email" => $customer->details['email'],
					"password" => $password,
					"firstname" => $customer->details['firstname'],
					"lastname" => $customer->details['lastname'],
					"companyname" => $customer->details['companyname'],
					"address1" => $customer->details['address1'],
					"address2" => $customer->details['address2'],
					"city" => $customer->details['city'],
					"state" => $customer->details['state'],
					"postcode" => $customer->details['postcode'],
					"country" => $customer->details['country'],
					"phonenumber" => $customer->details['phonenumber'],
					"firstname_billing" => $customer->details_billing['firstname'],
					"lastname_billing" => $customer->details_billing['lastname'],
					"companyname_billing" => $customer->details_billing['company'],
					"address1_billing" => $customer->details_billing['address1'],
					"address2_billing" => $customer->details_billing['address2'],
					"city_billing" => $customer->details_billing['city'],
					"state_billing" => $customer->details_billing['state'],
					"postcode_billing" => $customer->details_billing['zip'],
					"country_billing" => $customer->details_billing['country'],
					"phonenumber_billing" => $customer->details_billing['phone'],
					"cardnumber" => $cardnumber,
					"cardtype" => $cardtype,
					"exp" => $exp,
					"cvv" => $cvv,
					"ip" => $ip,
					"host" => $host
				);
				$result = $quote->addUser($arrUser);
				if($result == "SUCCESS")
				{
					$_SESSION['Quote_uid'] = $quote->userid;
				}
			}
			/*else
			{
				if(!isset($_SESSION['QuotePro']))
				{
					//make sure isClient and accountcode get set (added current cc info as well)
					if(empty($cardnumber))
					{
						$cardnumber = $quote->user['cardnumber'];
						$cardtype = $quote->user['cardtype'];
						$exp = str_replace("/", "", $quote->user['exp']);
						$cvv = $quote->user['cvv'];
					}
					$arrUser = array(
						"userid" => $quote->userid,
						"isClient" => 1,
						"email" => $customer->details['email'],
						"accountcode" => $accountcode,
						"cardnumber" => $cardnumber,
						"cardtype" => $cardtype,
						"exp" => $exp,
						"cvv" => $cvv
					);
					$result = $quote->updateUser($arrUser);

					$_SESSION['QuotePro'] = array();
					$_SESSION['QuotePro']['uid'] = $quote->userid;
				}
			}*/
		}

		$orderButtonText = $confirm ? "Confirm Order" : "Order Now";
		$buttonClick = $loggedin ? "location.href=?step=order" : "getSignIn()"; //confirmOrder()
		if($buttonClick == "location.href=?step=order" && !$hasCC)
		{
			$buttonClick = "getSignUp('billing',0)";
		}
		$retValue = "";
		if(!$confirm)
		{
			$retValue .= "<div id=order_button align=center style=\"padding:0px;\"><input type=button style=\"cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffffcc;\" value=\" {$orderButtonText} \" onclick=\"{$buttonClick}\"></div>";
			$retValue .= "<div id=order_button_confirm align=center style=\"padding:10px; display:none;\">";
			$retValue .= "<input type=\"checkbox\" id=\"accepttos\"> &nbsp;I have read and agree to the <a href=\"http://www.voiplion.com/tos.php\" target=\"_new\">Terms of Service</a>.<br><br>";
			$retValue .= "<input type=button id=process_button style=\"cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\" Confirm Order \" onclick=\"processOrder()\"></div>";
		}
		else
		{
			$retValue .= "<div id=order_button_confirm align=center style=\"padding:10px;\">";
			$retValue .= "<input type=\"checkbox\" id=\"accepttos\"> &nbsp;I have read and agree to the <a href=\"http://www.voiplion.com/tos.php\" target=\"_new\">Terms of Service</a>.<br><br>";
			$retValue .= "<input type=button id=process_button style=\"cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\" Confirm Order \" onclick=\"processOrder()\"></div>";
		}

		print $retValue;		
	break;

	case "get_signin":
		$accountcode = isset($_SESSION['uid']) && !$isVoiplion ? $_SESSION['uid'] : 0;
		if(isset($_SESSION['Quote_uid']))
		{
			print "signedin";
			exit;
		}
		$retValue = signinTable($accountcode);
		print $retValue;
	break;

	case "signin":
		require_once($MYACCOUNT_INCLUDE_PATH."functions/functions_general.php");
		$email = zen_db_prepare_input($_POST['username']);
		$password = zen_db_prepare_input($_POST['password']);
		require($MAIN_INCLUDE_PATH."config.php");
		$query = "select * from voiplion_whmcs.tblclients where `email` = '$email' limit 1";
		$result = mysql_query($query);
		if(@mysql_num_rows($result))
		{
			$row = mysql_fetch_assoc($result);
			if($row['status'] != "Active")
			{
				$_SESSION['LoginErrorMessage'] = "Your account is currently inactive or closed. Please contact VOIPLION.COM Customer Service at +1-404-777-5555";
				print signinTable(0,$email);
				exit;
			}

			//use original whmcs password encryption
			require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
			$whmcs = new whmcs();

			$get_password = $whmcs->getClientsPassword($row['id']);
			$get_password = $get_password['password'];
			if($password != $get_password)
			{
				$_SESSION['LoginErrorMessage'] = "Email/Password combination not recognized. Please try again.";
				print signinTable(0,$email);
				exit;
			}
			$accountcode = $row['id'];
			if(!$isVoiplion)
			{
				$_SESSION['uid'] = $accountcode;
			}

			require_once($ROOT_PATH."myaccount/classes/class.customer.php");
			$customer = new customer($accountcode);

			$cardnumber = "";
			$cardtype = "";
			$exp = "";
			$cvv = "";
			//can't get cc info from whmcs...go to voiplionweb
			$row_cc = $customer->details_cc;
			$hasCC = $customer->hasCC;
			$CCverified = $customer->CCverified;

			if($hasCC)
			{
				$cardnumber = $customer->details_cc['cardnumber'];
				$cardtype = $customer->details_cc['cardtype'];
				$exp = str_replace("/", "", $customer->details_cc['exp']);
				$cvv = $customer->details_cc['cvv'];
			}

			$checkaba = "";
			$checkaccount = "";
			$account_type = "";
			$account_holder_type = "";

			if($customer->hasACH)
			{
				$checkaba = $customer->details_ach['checkaba'];
				$checkaccount = $customer->details_ach['checkaccount'];
				$account_type = $customer->details_ach['account_type'];
				$account_holder_type = $customer->details_ach['account_holder_type'];
			}

			$ip = $_SERVER['REMOTE_ADDR'];
			$host = gethostbyaddr("$ip");

			//check if they have a quote record
			if(!$quote->userExists($email))
			{
				$userid = 0;
				$arrUser = array(
					"userid" => 0,
					"isClient" => 1,
					"accountcode" => $accountcode,
					"email" => $row['email'],
					"password" => $password,
					"firstname" => $row['firstname'],
					"lastname" => $row['lastname'],
					"companyname" => $row['companyname'],
					"address1" => $row['address1'],
					"address2" => $row['address2'],
					"city" => $row['city'],
					"state" => $row['state'],
					"postcode" => $row['postcode'],
					"country" => $row['country'],
					"phonenumber" => $row['phonenumber'],
					"firstname_billing" => $row['firstname'],
					"lastname_billing" => $row['lastname'],
					"companyname_billing" => $row['companyname'],
					"address1_billing" => $row['address1'],
					"address2_billing" => $row['address2'],
					"city_billing" => $row['city'],
					"state_billing" => $row['state'],
					"postcode_billing" => $row['postcode'],
					"country_billing" => $row['country'],
					"phonenumber_billing" => $row['phonenumber'],
					"firstname_shipping" => $row['firstname'],
					"lastname_shipping" => $row['lastname'],
					"companyname_shipping" => $row['companyname'],
					"address1_shipping" => $row['address1'],
					"address2_shipping" => $row['address2'],
					"city_shipping" => $row['city'],
					"state_shipping" => $row['state'],
					"postcode_shipping" => $row['postcode'],
					"country_shipping" => $row['country'],
					"phonenumber_shipping" => $row['phonenumber'],
					"cardnumber" => $cardnumber,
					"cardtype" => $cardtype,
					"exp" => $exp,
					"cvv" => $cvv,
					"checkaba" => $checkaba,
					"checkaccount" => $checkaccount,
					"account_type" => $account_type,
					"account_holder_type" => $account_holder_type,
					"ip" => $ip,
					"host" => $host
				);
				$result = $quote->addUser($arrUser);
				if($result == "SUCCESS")
				{
					$_SESSION['Quote_uid'] = $quote->userid;
					$arr = array("userid" => $quote->userid);
					$result = $quote->updateQuoteMain($arr);
					updateMain();
				}
			}
			else
			{
				//make sure isClient and accountcode get set
				if(empty($cardnumber))
				{
					$cardnumber = $quote->user['cardnumber'];
					$cardtype = $quote->user['cardtype'];
					$exp = str_replace("/", "", $quote->user['exp']);
					$cvv = $quote->user['cvv'];
				}
				$arrUser = array(
					"userid" => $quote->userid,
					"isClient" => 1,
					"email" => $email,
					"accountcode" => $accountcode,
					"firstname" => $customer->details['firstname'],
					"lastname" => $customer->details['lastname'],
					"companyname" => $customer->details['companyname'],
					"address1" => $customer->details['address1'],
					"address2" => $customer->details['address2'],
					"city" => $customer->details['city'],
					"state" => $customer->details['state'],
					"postcode" => $customer->details['postcode'],
					"country" => $customer->details['country'],
					"phonenumber" => $customer->details['phonenumber'],
					"firstname_billing" => $customer->details_billing['firstname'],
					"lastname_billing" => $customer->details_billing['lastname'],
					"companyname_billing" => $customer->details_billing['company'],
					"address1_billing" => $customer->details_billing['address1'],
					"address2_billing" => $customer->details_billing['address2'],
					"city_billing" => $customer->details_billing['city'],
					"state_billing" => $customer->details_billing['state'],
					"postcode_billing" => $customer->details_billing['zip'],
					"country_billing" => $customer->details_billing['country'],
					"phonenumber_billing" => $customer->details_billing['phone'],
					"firstname_shipping" => $customer->details['firstname'],
					"lastname_shipping" => $customer->details['lastname'],
					"companyname_shipping" => $customer->details['companyname'],
					"address1_shipping" => $customer->details['address1'],
					"address2_shipping" => $customer->details['address2'],
					"city_shipping" => $customer->details['city'],
					"state_shipping" => $customer->details['state'],
					"postcode_shipping" => $customer->details['postcode'],
					"country_shipping" => $customer->details['country'],
					"phonenumber_shipping" => $customer->details['phonenumber'],
					"cardnumber" => $cardnumber,
					"cardtype" => $cardtype,
					"exp" => $exp,
					"cvv" => $cvv,
					"checkaba" => $checkaba,
					"checkaccount" => $checkaccount,
					"account_type" => $account_type,
					"account_holder_type" => $account_holder_type,
					"ip" => $ip,
					"host" => $host
				);
				$result = $quote->updateUser($arrUser);
				
				$_SESSION['Quote_uid'] = $quote->userid;
				$arr = array("userid" => $quote->userid);
				$result = $quote->updateQuoteMain($arr);
				updateMain();
			}

			if(!$hasCC && !$customer->hasACH && !$customer->isPayByCheck)
			{
				print "nocc";
				exit;
			}
			else
			{
				//set paymentmethod for this quote if not cc
				if(!$hasCC || !$CCverified || $customer->isPayByCheck)
				{
					$arr = array("paymentmethod" => "mailin");
					$result = $quote->updateQuoteMain($arr);
				}
				print "signedin";
				exit;
			}
		}
		else
		{
			//check if they have a quote record
			if($quote->userExists($email))
			{
				$result = $quote->signin($email,$password);
				if($result != "SUCCESS")
				{
					$_SESSION['LoginErrorMessage'] = $result;
					print signinTable(0,$email);
					exit;
				}

				//NOW WHAT?
				$_SESSION['Quote_uid'] = $quote->userid;
				$arr = array("userid" => $quote->userid);
				$result = $quote->updateQuoteMain($arr);
				updateMain();


				//If they are only signing in, why are we forcing signup_billing (below)??? May be a reason but I don't see it. Is this a legacy issue?


				print "signedin";
				exit;

				/*
				//CAUTION: User may have a QB record but no CC!
				if(!empty($quote->user['cardnumber']))
				{
					print "signedin";
					exit;
				}
				else
				{
					//oddball case: user has QB record without any billing info
					if(empty($quote->user['firstname_billing']))
					{
						print "nocc";
						exit;
					}
					else
					{
						include("signup_billing.php");
					}
				}
				*/
			}
			else
			{
				$_SESSION['LoginErrorMessage'] = "Email/Password combination not recognized. Please try again.";
				print signinTable(0,$email);
				exit;
			}
		}
	break;

	case "get_signup":
		$type = $_GET['type'];
		$edit = $_GET['edit'];
		switch($type)
		{
			case "service":
				include("signup_service.php");
			break;

			case "billing":
				//hmmm...we send current clients here if they have no cc on file. 
				//	Problem is, we KEEP sending them here if they change the order while on confirm page (Order Now button still thinks they have no cc)
				if(isset($_SESSION['Quote_uid']) && !$edit)
				{
					$havePaymentInfo = !empty($quote->user['cardnumber']) || !empty($quote->user['checkaccount']) ? true : false;
					if($havePaymentInfo)
					{
						print "signedin";
						exit;
					}
					else
					{
						include("signup_billing.php");
					}
				}
				else
				{
					include("signup_billing.php");
				}
			break;
		}
	break;

	case "signup":
		//print_r($_POST);
		//print_r($_SERVER);
		//print_r($_SESSION);
		//print_r($quote->user);
		//print "$userid : $quote_id";
		//include("signup_service.php");
		//exit;
		$type = $_GET['type'];

		foreach($_POST as $key => $value)
		{
			if(is_string($value))
			{
				$_POST[$key] = stripslashes($value);
			}
		}
		//print_r($_POST);
		//include("signup_service.php");
		//exit;

		$email = isset($_POST['email']) ? $_POST['email'] : "";
		$firstname_posted = isset($_POST['firstname']) ? $_POST['firstname'] : "";
		$lastname_posted = isset($_POST['lastname']) ? $_POST['lastname'] : "";
		$companyname_posted = isset($_POST['companyname']) ? $_POST['companyname'] : "";
		$address1_posted = isset($_POST['address1']) ? $_POST['address1'] : "";
		$address2_posted = isset($_POST['address2']) ? $_POST['address2'] : "";
		$city_posted = isset($_POST['city']) ? $_POST['city'] : "";
		$state_posted = isset($_POST['state']) ? $_POST['state'] : "";
		$postcode_posted = isset($_POST['postcode']) ? $_POST['postcode'] : "";
		$country_posted = isset($_POST['country']) ? $_POST['country'] : "";
		$phonenumber_posted = isset($_POST['phonenumber']) ? cleanPhone($_POST['phonenumber']) : "";
		$pr_posted = isset($_POST['pr']) ? $_POST['pr'] : ""; //province/region
		$statetouse =  $country_posted == "US" ? $state_posted : $pr_posted;
		$password = isset($_POST['password']) ? $_POST['password'] : "";
		$password2 = isset($_POST['password2']) ? $_POST['password2'] : "";
		switch($type)
		{
			case "service":
			$serviceError = "";
			//required fields will be different if isVoiplion
			//$required_fields = $isVoiplion ? array("firstname" => $firstname_posted, "lastname" => $lastname_posted, "email" => $email, "password" => $password, "password2" => $password2) : $_POST;
			if($isVoiplion)
			{
				if(isset($_SERVER['HTTP_REFERER']) && substr_count($_SERVER['HTTP_REFERER'], "order") > 0)
				{
					$required_fields = $_POST;
				}
				else
				{
					if($_SESSION['voiplion']['roleid'] == 6)
					{
						if(!empty($email) && $quote->userExists($email) && ($quote->user_salesrep != $_SESSION['voiplion']['user']))
						{
							$serviceError = "&#42; This email address is assigned to another Rep.";
						}
					}

					$statetouse = $statetouse == "Select..." ? "" : $statetouse;
					$required_fields = array();
					/*
					//$required_fields = array("firstname" => $firstname_posted, "lastname" => $lastname_posted, "email" => $email);
					$required_fields = array();//array("email" => $email);
					if(count($quote->user) == 0)
					{
						$required_fields['password'] = $password;
						$required_fields['password2'] = $password2;
					}
					else if(empty($quote->user['password']))
					{
						$required_fields['password'] = $password;
						$required_fields['password2'] = $password2;
					}
					*/
				}
			}
			else
			{
				$required_fields = $_POST;
			}
			$serviceError = empty($serviceError) ? checkRequiredFields($required_fields) : $serviceError;
			if(!empty($serviceError))
			{
				//curiousity will be the death of me
				if($isVoiplion)
				{
					codelog("QB2 signup by $adminusername");
					$strDebug = "";
					foreach($_POST as $key => $value)
					{
						$strDebug .= "$key:$value, ";
					}
					codelog("Posted values: $strDebug");
					codelog("serviceError: $serviceError");
				}
				include("signup_service.php");
				exit;
			}
			else
			{
				$cardnumber_enc = "";
				$cardtype = "";
				$exp = "";
				$cvv = "";
				$account_type = "checking";
				$account_holder_type = "business";
				$checkaba_enc = "";
				$checkaccount_enc = "";

				$isClient = $quote->isClient($email);
				if($isClient)
				{
					//use original whmcs password encryption
					require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
					$whmcs = new whmcs();

					$get_password = $whmcs->getClientsPassword($quote->accountcode);
					$get_password = $get_password['password'];

					if($isVoiplion)
					{
						if(isset($_SESSION['uid'])) {unset($_SESSION['uid']);}

						if($quote->userExists($email) && ($quote->user_salesrep != $_SESSION['voiplion']['user']))
						{
							$serviceError = "This email address belongs to an existing customer.";
							include("signup_service.php");
							exit;
						}

						$quote->userExists($email);
						$userid = $quote->userid;

						$password = $get_password; //use existing client password in case we need to create a quote user record
					}
					else
					{
						if($password != $get_password)
						{
							$serviceError = "The email address you provided is already registered.<br>However, the password was not recognized. Please try again.";
							include("signup_service.php");
							exit;
						}
						$_SESSION['uid'] = $quote->accountcode;
					}

					//disregard the info submitted and use what we have on file

					require_once($ROOT_PATH."myaccount/classes/class.customer.php");
					$customer = new customer($quote->accountcode);

					$firstname_posted = $customer->details['firstname'];
					$lastname_posted = $customer->details['lastname'];
					$companyname_posted = $customer->details['companyname'];
					$address1_posted = $customer->details['address1'];
					$address2_posted = $customer->details['address2'];
					$city_posted = $customer->details['city'];
					$state_posted = $customer->details['state'];
					$postcode_posted = $customer->details['postcode'];
					$country_posted = $customer->details['country'];
					$phonenumber_posted = $customer->details['phonenumber'];
					$statetouse = $state_posted;

					if($customer->hasCC)
					{
						//why do we need this decrypted?
						require_once($MAIN_INCLUDE_PATH."functions/creditcard.php");
						$cyph = explode("|", $customer->details_cc['cardnumber']);
						$cardnumber = easy_decrypt($cyph);

						$cardnumber_enc = $customer->details_cc['cardnumber'];
						$cardtype = $customer->details_cc['cardtype'];
						$exp = $customer->details_cc['exp'];
						$cvv = $customer->details_cc['cvv'];
					}
					if($customer->hasACH)
					{
						$checkaba_enc = $customer->details_ach['checkaba'];
						$checkaccount_enc = $customer->details_ach['checkaccount'];
						$account_type = $customer->details_ach['account_type'];
						$account_holder_type = $customer->details_ach['account_holder_type'];
					}
				}

				if(!$quote->userExists($email) || !$userid || ($isVoiplion && empty($email)))
				{
					$userid = 0;
					$ip = $_SERVER['REMOTE_ADDR'];
					$host = gethostbyaddr("$ip");
					$arrUser = array(
						"userid" => 0,
						"email" => $email,
						"password" => $password,
						"firstname" => $firstname_posted,
						"lastname" => $lastname_posted,
						"companyname" => $companyname_posted,
						"address1" => $address1_posted,
						"address2" => $address2_posted,
						"city" => $city_posted,
						"state" => $statetouse,
						"postcode" => $postcode_posted,
						"country" => $country_posted,
						"phonenumber" => $phonenumber_posted,
						"firstname_shipping" => $firstname_posted,
						"lastname_shipping" => $lastname_posted,
						"companyname_shipping" => $companyname_posted,
						"address1_shipping" => $address1_posted,
						"address2_shipping" => $address2_posted,
						"city_shipping" => $city_posted,
						"state_shipping" => $statetouse,
						"postcode_shipping" => $postcode_posted,
						"country_shipping" => $country_posted,
						"phonenumber_shipping" => $phonenumber_posted,
						"ip" => $ip,
						"host" => $host,
						"cardnumber" => $cardnumber_enc,
						"cardtype" => $cardtype,
						"exp" => $exp,
						"cvv" => $cvv,
						"account_type" => $account_type,
						"account_holder_type" => $account_holder_type,
						"checkaba" => $checkaba_enc,
						"checkaccount" => $checkaccount_enc
					);

					if($isVoiplion)
					{
						$arrUser['salesrep'] = isset($_SESSION['voiplion']['user']) ? $_SESSION['voiplion']['user'] : "";
						$arrUser['cbey_bv_user'] = isset($_POST['cbey_bv_user']) ? $_POST['cbey_bv_user'] : 0;
						$arrUser['cbey_account_id'] = isset($_POST['cbey_account_id']) ? $_POST['cbey_account_id'] : "";
						$arrUser['cbey_direct_rep'] = isset($_POST['cbey_direct_rep']) ? $_POST['cbey_direct_rep'] : "";

						$arrUser['cbey_sales_engineer'] = isset($_POST['cbey_sales_engineer']) ? $_POST['cbey_sales_engineer'] : "";
						$arrUser['cbey_solutions_advisor'] = isset($_POST['cbey_solutions_advisor']) ? $_POST['cbey_solutions_advisor'] : "";

						$arrUser['tech_contact_name'] = isset($_POST['tech_contact_name']) ? $_POST['tech_contact_name'] : "";
						$arrUser['tech_contact_email'] = isset($_POST['tech_contact_email']) ? $_POST['tech_contact_email'] : "";
						$arrUser['tech_contact_phone'] = isset($_POST['tech_contact_phone']) ? $_POST['tech_contact_phone'] : "";

						$arrUser['cbey_dispatch'] = isset($_POST['cbey_dispatch']) ? $_POST['cbey_dispatch'] : "";
					}

					$result = $quote->addUser($arrUser);
					if($result == "SUCCESS")
					{
						$_SESSION['Quote_uid'] = $quote->userid;
						$arr = array("userid" => $quote->userid);
						$result = $quote->updateQuoteMain($arr);

						//regen the quote user to use billing info if !empty
						$quote = new quote($quote_id,$quote->userid);
						$firstname = !empty($quote->user['firstname_billing']) ? $quote->user['firstname_billing'] : $firstname_posted;
						$lastname = !empty($quote->user['lastname_billing']) ? $quote->user['lastname_billing'] : $lastname_posted;
						$companyname = !empty($quote->user['companyname_billing']) ? $quote->user['companyname_billing'] : $companyname_posted;
						$address1 = !empty($quote->user['address1_billing']) ? $quote->user['address1_billing'] : $address1_posted;
						$address2 = !empty($quote->user['address2_billing']) ? $quote->user['address2_billing'] : $address2_posted;
						$city = !empty($quote->user['city_billing']) ? $quote->user['city_billing'] : $city_posted;
						$state = !empty($quote->user['state_billing']) ? $quote->user['state_billing'] : $state_posted;
						$postcode = !empty($quote->user['postcode_billing']) ? $quote->user['postcode_billing'] : $postcode_posted;
						$country = !empty($quote->user['country_billing']) ? $quote->user['country_billing'] : $country_posted;
						$phonenumber = !empty($quote->user['phonenumber_billing']) ? $quote->user['phonenumber_billing'] : $phonenumber_posted;
	
						$cardnumber = !empty($quote->user['cardnumber']) ? $quote->user['cardnumber'] : "";
						$cardtype = !empty($quote->user['cardtype']) ? $quote->user['cardtype'] : "";
						$exp = !empty($quote->user['exp']) ? $quote->user['exp'] : "";
						$cvv = !empty($quote->user['cvv']) ? $quote->user['cvv'] : "";

						if(!empty($cardnumber))
						{
							require_once($MAIN_INCLUDE_PATH."functions/creditcard.php");
							$cyph = explode("|", $cardnumber);
							$cardnumber = easy_decrypt($cyph);
							$cc_lastfour = substr(easy_decrypt($cyph), -4) == "iner" ? "9999" : substr(easy_decrypt($cyph), -4);
							$visibleCardNum = "XXXX-XXXX-XXXX-".$cc_lastfour;
						}
	
						if($isClient)
						{
							$arrUser = array(
							"userid" => $quote->userid,
							"email" => $email,
							"accountcode" => $quote->accountcode,
							"isClient" => 1
							);
							$result = $quote->updateUser($arrUser);
						}

						if($isVoiplion)
						{
							if(isset($_POST['email_quote']) && $_POST['email_quote'] == 1)
							{
								//$quote->emailQuote();
								$quote_details = $quote->getQuote($quote->quote_id,$quote->userid);
								sendQuoteEmail($quote_details);
							}
							if(isset($_SERVER['HTTP_REFERER']) && substr_count($_SERVER['HTTP_REFERER'], "order") == 0)
							{
								include("cbey_saved.php");
							}
							else
							{
								include("signup_billing.php");
							}
						}
						else
						{
							include("signup_billing.php");
						}
					}
					else
					{
						$serviceError = $result;
						include("signup_service.php");
					}
				}
				else
				{
					$_SESSION['Quote_uid'] = $quote->userid;

					$ip = $_SERVER['REMOTE_ADDR'];
					$host = gethostbyaddr("$ip");
					$arrUser = array(
						"userid" => $userid,
						"email" => $email,
						"firstname" => $firstname_posted,
						"lastname" => $lastname_posted,
						"companyname" => $companyname_posted,
						"address1" => $address1_posted,
						"address2" => $address2_posted,
						"city" => $city_posted,
						"state" => $statetouse,
						"postcode" => $postcode_posted,
						"country" => $country_posted,
						"phonenumber" => $phonenumber_posted,
						"firstname_shipping" => $firstname_posted,
						"lastname_shipping" => $lastname_posted,
						"companyname_shipping" => $companyname_posted,
						"address1_shipping" => $address1_posted,
						"address2_shipping" => $address2_posted,
						"city_shipping" => $city_posted,
						"state_shipping" => $statetouse,
						"postcode_shipping" => $postcode_posted,
						"country_shipping" => $country_posted,
						"phonenumber_shipping" => $phonenumber_posted,
						"ip" => $ip,
						"host" => $host,
						"cardnumber" => $cardnumber_enc,
						"cardtype" => $cardtype,
						"exp" => $exp,
						"cvv" => $cvv,
						"account_type" => $account_type,
						"account_holder_type" => $account_holder_type,
						"checkaba" => $checkaba_enc,
						"checkaccount" => $checkaccount_enc
					);

					if($isVoiplion)
					{
						//$arrUser['salesrep'] = isset($_SESSION['voiplion']['user']) ? $_SESSION['voiplion']['user'] : "voiplion";
						$arrUser['cbey_bv_user'] = isset($_POST['cbey_bv_user']) ? $_POST['cbey_bv_user'] : 0;
						$arrUser['cbey_account_id'] = isset($_POST['cbey_account_id']) ? $_POST['cbey_account_id'] : "";
						$arrUser['cbey_direct_rep'] = isset($_POST['cbey_direct_rep']) ? $_POST['cbey_direct_rep'] : "";
						$arrUser['cbey_sales_engineer'] = isset($_POST['cbey_sales_engineer']) ? $_POST['cbey_sales_engineer'] : "";
						$arrUser['cbey_solutions_advisor'] = isset($_POST['cbey_solutions_advisor']) ? $_POST['cbey_solutions_advisor'] : "";

						$arrUser['tech_contact_name'] = isset($_POST['tech_contact_name']) ? $_POST['tech_contact_name'] : "";
						$arrUser['tech_contact_email'] = isset($_POST['tech_contact_email']) ? $_POST['tech_contact_email'] : "";
						$arrUser['tech_contact_phone'] = isset($_POST['tech_contact_phone']) ? $_POST['tech_contact_phone'] : "";

						$arrUser['cbey_dispatch'] = isset($_POST['cbey_dispatch']) ? $_POST['cbey_dispatch'] : "";
					}

					$result = $quote->updateUser($arrUser);

					$arr = array("userid" => $quote->userid);
					$result = $quote->updateQuoteMain($arr);

					if($isVoiplion)
					{
						if(isset($_POST['email_quote']) && $_POST['email_quote'] == 1)
						{
							//$quote->emailQuote();
							$quote_details = $quote->getQuote($quote->quote_id,$quote->userid);
							sendQuoteEmail($quote_details);
						}
						if(isset($_SERVER['HTTP_REFERER']) && substr_count($_SERVER['HTTP_REFERER'], "order") == 0)
						{
							include("cbey_saved.php");
						}
						else
						{
							include("signup_billing.php");
						}
					}
					else
					{
						include("signup_billing.php");
					}
				}
			}
			break;

			case "billing":
			//print "<!--";
			//print "<pre>";
			//print_r($_POST);
			//print "</pre>";
			//print "-->";
			//exit;
			$cardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : "";
			$exp = isset($_POST['exp']) ? $_POST['exp'] : "";
			$exp = str_replace(" ", "", $exp);
			$exp = str_replace("-", "", $exp);
			$exp = str_replace("/", "", $exp);
			$cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";
			$cardnum_enc = "";
			$cardtype = "";

			//NEW...watch for ach info (currently only coming from ccs agent orders OR admins)

			$account_type = isset($_POST['account_type']) ? $_POST['account_type'] : "";
			$account_holder_type = isset($_POST['account_holder_type']) ? $_POST['account_holder_type'] : "";
			$checkaba = isset($_POST['checkaba']) ? $_POST['checkaba'] : "";
			$checkaccount = isset($_POST['checkaccount']) ? $_POST['checkaccount'] : "";
			$checkaba_enc = "";
			$checkaccount_enc = "";

			//unset POST vars depending on payment type
			$payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : "cc";

			if($payment_type == "pbc")
			{
				if(isset($_POST['cardnumber'])) unset($_POST['cardnumber']);
				if(isset($_POST['exp'])) unset($_POST['exp']);
				if(isset($_POST['cvv'])) unset($_POST['cvv']);
				if(isset($_POST['checkaba'])) unset($_POST['checkaba']);
				if(isset($_POST['checkaccount'])) unset($_POST['checkaccount']);

				//if we have a quote_id here. set paymentmethod to "mailin"
				if($quote_id)
				{
					$arr = array("paymentmethod" => "mailin", "is_paybycheck" => 1);
					$result = $quote->updateQuoteMain($arr);
				}
			}
			else if($using_usbank)
			{
				if(isset($_POST['cardnumber'])) unset($_POST['cardnumber']);
				if(isset($_POST['exp'])) unset($_POST['exp']);
				if(isset($_POST['cvv'])) unset($_POST['cvv']);
				if(isset($_POST['checkaba'])) unset($_POST['checkaba']);
				if(isset($_POST['checkaccount'])) unset($_POST['checkaccount']);

				//if we have a quote_id here. set paymentmethod to "mailin"
				if($quote_id)
				{
					$arr = array("paymentmethod" => "mailin", "is_paybycheck" => 0);
					$result = $quote->updateQuoteMain($arr);
				}
			}
			else if($payment_type == "cc")
			{
				if(isset($_POST['checkaba'])) unset($_POST['checkaba']);
				if(isset($_POST['checkaccount'])) unset($_POST['checkaccount']);

				//if we have a quote_id here. set paymentmethod to "authorize"
				if($quote_id)
				{
					$arr = array("paymentmethod" => "authorize", "is_paybycheck" => 0);
					$result = $quote->updateQuoteMain($arr);
				}
			}
			else if($payment_type == "ach")
			{
				if(isset($_POST['cardnumber'])) unset($_POST['cardnumber']);
				if(isset($_POST['exp'])) unset($_POST['exp']);
				if(isset($_POST['cvv'])) unset($_POST['cvv']);

				//if we have a quote_id here. set paymentmethod to "mailin"
				if($quote_id)
				{
					$arr = array("paymentmethod" => "mailin", "is_paybycheck" => 0);
					$result = $quote->updateQuoteMain($arr);
				}
			}
			//print "<pre>";
			//print_r($_POST);
			//print "</pre>";
			//exit;

			$billingError = $isCCSAgent || $isVoiplion ? "" : checkRequiredFields($_POST);
			if(!empty($billingError))
			{
				include("signup_billing.php");
				//print_r($_POST);
				exit;
			}
			else
			{
				if($quote->isClient($email))
				{
					require_once($ROOT_PATH."myaccount/classes/class.customer.php");
					$customer = new customer($quote->accountcode);

					$firstname_posted = $customer->details_billing['firstname'];
					$lastname_posted = $customer->details_billing['lastname'];
					$companyname_posted = $customer->details_billing['company'];
					$address1_posted = $customer->details_billing['address1'];
					$address2_posted = $customer->details_billing['address2'];
					$city_posted = $customer->details_billing['city'];
					$state_posted = $customer->details_billing['state'];
					$postcode_posted = $customer->details_billing['zip'];
					$country_posted = $customer->details_billing['country'];
					$phonenumber_posted = $customer->details_billing['phone'];
					$statetouse = $state_posted;

					if($customer->hasCC)
					{
						$cardnum_enc = $customer->details_cc['cardnumber'];
						$cardtype = $customer->details_cc['cardtype'];
						$exp = $customer->details_cc['exp'];
						$cvv = $customer->details_cc['cvv'];
					}
					if($customer->hasACH)
					{
						$checkaba_enc = $customer->details_ach['checkaba'];
						$checkaccount_enc = $customer->details_ach['checkaccount'];
						$account_type = $customer->details_ach['account_type'];
						$account_holder_type = $customer->details_ach['account_holder_type'];
					}
				}
				else
				{
					if(!empty($checkaba))
					{
						require_once($ROOT_PATH."myaccount/includes/functions/password_funcs.php");
						$checkaba_enc = voiplion_encrypt($checkaba);
						$checkaccount_enc = voiplion_encrypt($checkaccount);
					}

					if(!empty($cardnumber))// && !$isVoiplion)
					{
						require_once($MAIN_INCLUDE_PATH."functions/creditcard.php");
						$cardnumber = str_replace(" ", "", $cardnumber);
						$cardnumber = str_replace("-", "", $cardnumber);
						$tmpccarr = easy_crypt($cardnumber);
						$cardnum_enc = $tmpccarr[0]."|".$tmpccarr[1];
						$cardtype = findCCtype($cardnumber); 
						if($cardtype == "Unknown/Invalid")
						{
							$billingError = "&#42; Unknown or invalid credit card number. Please try again.<br>";
						}					
						if(!empty($billingError))
						{
							include("signup_billing.php");
							exit;
						}
					}
				}

				$userid = isset($_SESSION['Quote_uid']) ? $_SESSION['Quote_uid'] : 0;

				$arrUser = array(
					"userid" => $userid,
					"email" => $email,
					"firstname_billing" => $firstname_posted,
					"lastname_billing" => $lastname_posted,
					"companyname_billing" => $companyname_posted,
					"address1_billing" => $address1_posted,
					"address2_billing" => $address2_posted,
					"city_billing" => $city_posted,
					"state_billing" => $statetouse,
					"postcode_billing" => $postcode_posted,
					"country_billing" => $country_posted,
					"phonenumber_billing" => $phonenumber_posted,
					"cardnumber" => $cardnum_enc,
					"cardtype" => $cardtype,
					"exp" => $exp,
					"cvv" => $cvv,
					"account_type" => $account_type,
					"account_holder_type" => $account_holder_type,
					"checkaba" => $checkaba_enc,
					"checkaccount" => $checkaccount_enc
				);
//print_r($arrUser);
//exit;
				$result = $quote->updateUser($arrUser);
				if($result != "SUCCESS")
				{
					$billingError = "An error has occurred. Unable to update Billing Information. <!-- $result -->";
					include("signup_billing.php");
					exit;
				}

				print "gotoorder";
			}
			break;
		}
	break;

	case "confirm_order":
		//still used?
		$quote_details = $quote->getQuote($quote_id,$userid);
		if(empty($quote->user['firstname_billing']))
		{
			include("signup_billing.php");
		}
		else if(isset($quote_details['store']))
		{
			include("confirm_shipping.php");
		}
		else
		{
			include("confirm_order.php");
		}
	break;

	case "get_options_box":
		$quote_details = $quote->getQuote($quote_id,$userid);
		require_once($MAIN_INCLUDE_PATH."_boxes.php");
		$boxTopOptions = boxTop(220, "<div style=\"float:left; color:#454545; font-weight:bold;\">Options</div><div class=listTextBold style=\"float:right;\"><a href=\"javascript:void(0)\" onclick=\"location.href='?unset'\" style=\" text-decoration:none;\">&nbsp;&nbsp;&nbsp;</a></div>"); 
		$boxBottomOptions = boxBottom(220);

		$optionsList = $boxTopOptions;

		$optionsList .= "<div class=listText style=\"padding-top:5px;\">";

		$optionsList .= isset($quote_details['main']) && $quote_details['main']['total'] > 0 && (!$isAdmin && !$isCCSAgent) ? "<div class=listTextBold id=\"quoteSideBar\">&#8226; <a href=\"javascript:void(0)\" onclick=\"newQuote()\">Begin a New Quote</a></div>" : "";

		$optionsList .= isset($quote_details['main']) && $quote_details['main']['total'] > 0 ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226; <a href=\"?step=review{$adminParam}\">Review</a></div>" : "";

		//PRINT
		$optionsList .= isset($quote_details['main']) && $quote_details['main']['total'] > 0 ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  <a href=\"/quotebuilder/print.php\" target=\"_new\">Print</a></div>" : "";

		//EMAIL
		if(!$isVoiplion && !$isCCSAgent && substr($quote_id, 0, 1) == "Q")
		{
			$optionsList .= $userid ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  <a href=\"javascript:void(0)\" onclick=\"emailQuote('{$quote_id}', '{$userid}')\">Email Quote</a></div>" : "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  Email Quote</div><div style=\"padding-left:8px; font-style:italic; color:#454545;\">please save before emailing</i></div>";
			$optionsList .= $userid ? "<div id=\"email_resp\" style=\"padding-left:5px;\"></div>" : "";
		}

		//NOTES
		if(!$isCCSAgent)
		{
			$optionsList .= $userid && empty($quote_details['main']['processed']) ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  <a href=\"javascript:void(0)\" onclick=\"addNotes_form('{$quote_id}', '{$userid}')\">Add Notes</a></div>" : "";
			$optionsList .= $userid && empty($quote_details['main']['processed']) ? "<div id=\"notes_resp\" style=\"padding-left:5px;\"></div>" : "";
		}

		if($isVoiplion)
		{
			$optionsList .= $userid ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  <a href=\"javascript:void(0)\" onclick=\"createPDF('{$quote_id}', '{$userid}')\">Create PDF</a></div>" : "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  Create PDF</div><div style=\"padding-left:8px; font-style:italic; color:#454545;\">please save first</i></div>";
			$optionsList .= $userid ? "<div id=\"pdf_resp\" style=\"padding-left:5px;\"></div>" : "";

			if(empty($quote_details['main']['purchase_date']))
			{
				//if(substr_count($_SERVER['HTTP_REFERER'], "cbey_save") == 0)
				//{
					$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"Save Quote\" onclick=\"location.href='?step=cbey_save'\"></div><div id=order_resp></div>";

					if(substr_count($_SERVER['HTTP_REFERER'], "order") == 0)
					{
						$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"Submit Order\" onclick=\"location.href='?step=order'\"></div><div id=order_resp></div>";
					}
				//}
			}
			else
			{
				$optionsList .= "<div style=\"margin:10px 0 10px 0;\" class=listTextBold>Purchased on ".date("m-d-Y", $quote_details['main']['purchase_date'])."</div>";
			}
			if(!empty($quote_details['main']['processed']))
			{
				$optionsList .= "<div style=\"margin:10px 0 10px 0;\" class=listTextBold>Processed on ".date("m-d-Y", $quote_details['main']['processed'])."</div>";
			}

			$optionsList .= $boxBottomOptions;

			/*
			if($quote_details['main']['paymentmethod'] == "mailin")
			{
				$optionsList .= "<br><br><div class=listText>ACH Order - cannot run MaxMind</div>";
			}
			else
			{
				$fraudoutput = str_replace("\n", "<br>", $quote_details['main']['fraudoutput']);
				$optionsList .= $userid ? "<br><br><div class=listText>Fraud Output - <a href=\"javascript:void(0)\" onclick=\"runMM()\">run MaxMind</a></div>" : "<br><br><div class=listText>Fraud Output - NO USER</div>";
				$optionsList .= "<div id=fraudoutput class=listText style=\"width:200px; text-align:left;\"><blockquote>$fraudoutput</blockquote></div>";
			}
			*/
		}
		else if($isCCSAgent)
		{
			$optionsList .= $userid ? "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  <a href=\"javascript:void(0)\" onclick=\"createPDF('{$quote_id}', '{$userid}')\">Create PDF</a></div>" : "<div class=listTextBold style=\"padding-top:10px;\" id=\"quoteSideBar\">&#8226;  Create PDF</div><div style=\"padding-left:8px; font-style:italic; color:#454545;\">please save first</i></div>";
			$optionsList .= $userid ? "<div id=\"pdf_resp\" style=\"padding-left:5px;\"></div>" : "";

			if(empty($quote_details['main']['purchase_date']))
			{
				if(substr_count($_SERVER['HTTP_REFERER'], "order") == 0)
				{
					//$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"Save Quote\" onclick=\"location.href='?step=ccsagent_save'\"></div><div id=order_resp></div>";
					$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"Place Order\" onclick=\"location.href='?step=order'\"></div><div id=order_resp></div>";
				}
			}
			$optionsList .= $boxBottomOptions;
		}
		else
		{
			$hasCC = 0;
			if($loggedin)
			{
				$hasCC = $customer->hasCC;
			}

			$buttonLabel = $isAdmin ? "Process Order" : "Order Now";

			$buttonClick = $loggedin || $loggedin_quote ? "location.href='?step=order{$adminParam}'" : "getSignIn()";
			if($buttonClick == "confirmOrder()" && !$hasCC)
			{
				$buttonClick = "getSignUp('billing',0)";
			}

			if(empty($quote_details['main']['purchase_date']))
			{
				if($isAdmin)
				{
					$optionsList .= "<div class=alertsmall style=\"margin:10px 0 10px 0;\"><b>NOT ORDERED by customer</b></div>";
					/*CANNOT SPINUP BEFORE WE HAVE AN ORDER!
					if(isset($quote_details['netpbx']))
					{
						$optionsList .= "<div style=\"margin:10px 0 10px 0;\">";
						$optionsList .= "<input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"Attempt Spinup\" onclick=\"\">";
						$optionsList .= "<div id=spinup_resp></div>";
						$optionsList .= "</div>";
					}
					*/
				}
				$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"{$buttonLabel}\" onclick=\"{$buttonClick}\"></div><div id=order_resp></div>";
			}
			else
			{
				$optionsList .= "<div style=\"margin:10px 0 10px 0;\" class=listTextBold>Purchased on ".date("m-d-Y", $quote_details['main']['purchase_date'])."</div>";
				if(!empty($quote_details['main']['processed']))
				{
					$optionsList .= "<div style=\"margin:10px 0 10px 0;\" class=listTextBold>Processed on ".date("m-d-Y", $quote_details['main']['processed'])."</div>";
				}
				else
				{
					if($isAdmin)
					{
						$optionsList .= "<div id=order_button style=\"margin:10px 0 10px 0;\"><input type=button style=\"width:auto; padding:0 3px 0 3px; cursor:pointer; font-size:14px; font-weight:bold; border-color:#c30c3e; color:#c30c3e; background-color:#ffcc00;\" value=\"{$buttonLabel}\" onclick=\"{$buttonClick}\"></div>";
						$optionsList .= "<div id=order_resp></div>";

						//TODO: Need a way to empty the payment method info and resend email to customer
					}
				}
			}

			if(!$userid)
			{
				$email_value = isset($_SESSION['zoho_email']) ? $_SESSION['zoho_email'] : "";
				$optionsList .= "<fieldset style=\"margin-top:10px;\"><legend class=listTextBold>Save Your Quote</legend><div id=saveBox class=listText>";
				$optionsList .= "<div>Your email address</div>";
				$optionsList .= "<div><input type=text name=\"save_username\" id=\"save_username\" class=formElement style=\"width:175px; margin-bottom:10px;\" value=\"{$email_value}\"></div>";
				$optionsList .= "<div align=right style=\"padding-right:5px;\"><input type=button id=\"savebutton\" style=\"cursor:pointer;\" value=\"SAVE\" onclick=\"saveQuote('u', document.getElementById('save_username').value)\"></div>";
				$optionsList .= "</div></fieldset>";
			}

			$optionsList .= "</div>";

			$optionsList .= $boxBottomOptions;

			if($isAdmin)
			{
				if($quote_details['main']['paymentmethod'] == "mailin")
				{
					$optionsList .= "<br><br><div class=listText>ACH or PBC Order - cannot run MaxMind</div>";
				}
				else
				{
					$fraudoutput = str_replace("\n", "<br>", $quote_details['main']['fraudoutput']);
					$optionsList .= $userid ? "<br><br><div class=listText>Fraud Output - <a href=\"javascript:void(0)\" onclick=\"runMM()\">run MaxMind</a></div>" : "<br><br><div class=listText>Fraud Output - NO USER</div>";
					$optionsList .= "<div id=fraudoutput class=listText style=\"width:200px; text-align:left;\"><blockquote>$fraudoutput</blockquote></div>";
				}
			}
		}
		//print_r($quote_details);
		print $optionsList;
	break;

	case "create_pdf":
		$userid = isset($_GET['uid']) ? $_GET['uid'] : 0;
		$quote_id = isset($_GET['qid']) ? $_GET['qid'] : 0;
		$quote = new quote($quote_id,$userid);
		$result = $quote->createPDF();
		require_once($MYACCOUNT_INCLUDE_PATH."functions/password_funcs.php");
		$quoteid_enc = urlencode(voiplion_encrypt($quote_id));
		print "<div style=\"margin-left:10px;\" class=listTextBold><a href=\"/quotebuilder/pdf/?id=$quoteid_enc\" target=\"_new\">GET PDF</a></div>";
	break;

	case "email_quote":
		$quote_details = $quote->getQuote($quote_id,$userid);
		if(isset($quote_details['user']['email']))
		{
			$result = $quote->emailQuote();
			if($result == "SUCCESS")
			{
				print "your quote has been sent";
			}
			else
			{
				print "<span class=alertsmall><i>unable to send quote</i></span><!--$result-->";
			}
		}
		else
		{
			print "No email address";
		}
	break;

	case "delete_quote":
		$retValue = "";
		$userid = isset($_GET['uid']) ? $_GET['uid'] : 0;
		$quote_id = isset($_GET['qid']) ? $_GET['qid'] : 0;
		$quote = new quote($quote_id,$userid);
		$result = $quote->setStatus(1);//1=deleted
		if($result == "SUCCESS")
		{
			unset($_SESSION['Quote']['id']);
			print "go";
		}
		else
		{
			print $result;
		}
	break;

	case "save_quote":
		$retValue = "";
		$error = 0;
		$param = isset($_GET['param']) ? $_GET['param'] : "";
		switch($param)
		{
			case "u":
			require_once($MYACCOUNT_INCLUDE_PATH."functions/functions_general.php");
			$email = isset($_GET['val']) ? str_replace(" " , "", $_GET['val']) : "";
			if(!empty($email))
			{
				if(substr_count($email, "@") == 0)
				{
					$error = 1;
					$retValue .= "<span class=alertsmall>Please provide a valid Email Address</span><br>";
				}
				else
				{
					$tmp = explode("@", $email);
					if(strtolower($tmp[1]) == "hotmail.com")
					{
						$error = 1;
						$retValue .= "<span class=alertsmall>We're sorry, we cannot accept email addresses from Hotmail.  Please use another email address.</span><br>";
					}
				}

				if($error)
				{
					$retValue .= "Your email address<br>";
					$retValue .= "<input type=text name=\"save_username\" id=\"save_username\" class=formElement style=\"width:140px; margin-bottom:10px;\" value=\"$email\"><br>";
					$retValue .= "<input type=button id=\"savebutton\" value=\"SAVE\" onclick=\"saveQuote('u', document.getElementById('save_username').value)\"><br>";
				}
				else
				{
					$email = zen_db_prepare_input($email);
					$isClient = $quote->isClient($email);
					$userExists = $quote->userExists($email);
					$newuser = $userExists ? 0 : 1;
					if(!$isClient)
					{
						if($userExists)
						{
							$retValue = "Your password<br>";
							$retValue .= "<input type=password name=\"save_p\" id=\"save_p\" class=formElement style=\"width:140px; margin-bottom:10px;\"><br>";
							$retValue .= "<input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('p', document.getElementById('save_p').value + '`$email')\"><br>";
						}
						else if($newuser)
						{
							$fname_value = isset($_SESSION['zoho_fname']) ? $_SESSION['zoho_fname'] : "";
							$lname_value = isset($_SESSION['zoho_lname']) ? $_SESSION['zoho_lname'] : "";
							$retValue = "First Name:<br><input type=\"text\" name=\"save_firstname\" id=\"save_firstname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\" value=\"{$fname_value}\"><br>";
							$retValue .= "Last Name:<br><input type=\"text\" name=\"save_lastname\" id=\"save_lastname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\" value=\"{$lname_value}\"><br>";
							$retValue .= "Password<br><input type=\"password\" name=\"password\" id=\"save_p1\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\"><br>";
							$retValue .= "Confirm Password<br><input type=\"password\" name=\"password2\" id=\"save_p2\" class=\"formElement\" style=\"width:140px; margin-bottom:10px;\"><br>";
							$retValue .= "<input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('new', '$email', 1)\"><br>";
							$retValue .= $isAdmin ? "<div style=\"float:right; width:10px; height:10px; cursor:pointer; margin-top:5px; border:1px solid #454545;\" onclick=\"saveQuote('new', '$email', 0)\"></div>" : "";
						}
					}
					else
					{
						//the difference here is we're gonna email this quote to a brand new user
						if($userExists)
						{
							$retValue = "Your password<br>";
							$retValue .= "<input type=password name=\"save_p\" id=\"save_p\" class=formElement style=\"width:140px; margin-bottom:10px;\"><br>";
							$retValue .= "<input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('p', document.getElementById('save_p').value + '`$email')\"><br>";
						}
						else if($isClient)
						{
							//generate quote user record based on WHMCS data...then get password
							$userid = 0;
							$ip = $_SERVER['REMOTE_ADDR'];
							$host = gethostbyaddr("$ip");

							require_once($MYACCOUNT_PATH."classes/class.customer.php");
							require_once($MYACCOUNT_INCLUDE_PATH."functions/password_funcs.php");
							$customer = new customer();
							if($customer->hasWHMCSRecord($email))
							{
								$row_cc = $customer->netSIP_ccInfo();
								$cardnumber = isset($row_cc['cardnumber']) ? $row_cc['cardnumber'] : "";
								$cardtype = isset($row_cc['cardtype']) ? $row_cc['cardtype'] : "";
								$exp = isset($row_cc['exp']) ? $row_cc['exp'] : "";
								$cvv = isset($row_cc['cvv']) ? $row_cc['cvv'] : "";

								$pass_enc = $customer->details_billing['password'];
								$pass_decrypt = voiplion_decrypt(explode("|",$pass_enc));

								$arrUser= array(
									"userid" => 0,
									"isClient" => 1,
									"accountcode" => $customer->accountcode,
									"email" => $email,
									"password" => $pass_decrypt,
									"firstname" => $customer->details['firstname'],
									"lastname" => $customer->details['lastname'],
									"companyname" => $customer->details['companyname'],
									"address1" => $customer->details['address1'],
									"address2" => $customer->details['address2'],
									"city" => $customer->details['city'],
									"state" => $customer->details['state'],
									"postcode" => $customer->details['postcode'],
									"country" => $customer->details['country'],
									"phonenumber" => $customer->details['phonenumber'],
									"firstname_billing" => $customer->details_billing['firstname'],
									"lastname_billing" => $customer->details_billing['lastname'],
									"companyname_billing" => $customer->details_billing['company'],
									"address1_billing" => $customer->details_billing['address1'],
									"address2_billing" => $customer->details_billing['address2'],
									"city_billing" => $customer->details_billing['city'],
									"state_billing" => $customer->details_billing['state'],
									"postcode_billing" => $customer->details_billing['zip'],
									"country_billing" => $customer->details_billing['country'],
									"phonenumber_billing" => $customer->details_billing['phone'],
									"firstname_shipping" => $customer->details['firstname'],
									"lastname_shipping" => $customer->details['lastname'],
									"companyname_shipping" => $customer->details['companyname'],
									"address1_shipping" => $customer->details['address1'],
									"address2_shipping" => $customer->details['address2'],
									"city_shipping" => $customer->details['city'],
									"state_shipping" => $customer->details['state'],
									"postcode_shipping" => $customer->details['postcode'],
									"country_shipping" => $customer->details['country'],
									"phonenumber_shipping" => $customer->details['phonenumber'],
									"cardnumber" => $cardnumber,
									"cardtype" => $cardtype,
									"exp" => $exp,
									"cvv" => $cvv,
									"ip" => $ip,
									"host" => $host
								);
								$result = $quote->addUser($arrUser);
							}

							$retValue = "Your password<br>";
							$retValue .= "<input type=password name=\"save_p\" id=\"save_p\" class=formElement style=\"width:140px; margin-bottom:10px;\"><br>";
							$retValue .= "<input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('p', document.getElementById('save_p').value + '`$email')\"><br>";
						}
						else if($newuser)
						{
							$fname_value = isset($_SESSION['zoho_fname']) ? $_SESSION['zoho_fname'] : "";
							$lname_value = isset($_SESSION['zoho_lname']) ? $_SESSION['zoho_lname'] : "";
							$retValue = "First Name:<br><input type=\"text\" name=\"save_firstname\" id=\"save_firstname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\" value=\"{$fname_value}\"><br>";
							$retValue .= "Last Name:<br><input type=\"text\" name=\"save_lastname\" id=\"save_lastname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\" value=\"{$lname_value}\"><br>";
							$retValue .= "Password<br><input type=\"password\" name=\"password\" id=\"save_p1\" class=\"formElement\" style=\"width:140px; margin-bottom:5px;\"><br>";
							$retValue .= "Confirm Password<br><input type=\"password\" name=\"password2\" id=\"save_p2\" class=\"formElement\" style=\"width:140px; margin-bottom:10px;\"><br>";
							$retValue .= "<input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('new', '$email', 1)\"><br>";
							$retValue .= $isAdmin ? "<div style=\"float:right; width:10px; height:10px; cursor:pointer; margin-top:5px; border:1px solid #454545;\" onclick=\"saveQuote('new', '$email', 0)\"></div>" : "";
						}
					}
				}
			}
			else
			{
				$retValue .= "Your email address<br>";
				$retValue .= "<input type=text name=\"save_username\" id=\"save_username\" class=formElement style=\"width:140px; margin-bottom:10px;\" value=\"$email\"><br>";
				$retValue .= "<input type=button id=\"savebutton\" value=\"SAVE\" onclick=\"saveQuote('u', document.getElementById('save_username').value)\"><br>";
			}
			break;

			case "p":
			$tmp = isset($_GET['val']) ? explode("`", $_GET['val']) : array();
			$password = $tmp[0];
			$email = $tmp[1];
			$result = $quote->signin($email,$password);
			if($result == "SUCCESS")
			{
				$_SESSION['Quote_uid'] = $quote->userid;

				$quote_details = $quote->getQuote($quote_id,$userid);
				if(isset($quote_details['netpbx']))
				{
					$arr = array("netpbx_purchase" => $quote_details['netpbx']);
					$result = $quote->saveQuote_section("netpbx", $arr);
				}

				$netsip_purchase = array();
				if(isset($quote_details['netsip_options']))
				{
					$netsip_purchase['options'] = $quote_details['netsip_options'];
				}
				if(isset($quote_details['netsip_packages']))
				{
					$netsip_purchase['packages'] = $quote_details['netsip_packages'];
				}
				if(isset($quote_details['netsip_dids']))
				{
					$netsip_purchase['dids'] = $quote_details['netsip_dids'];
				}
				if(count($netsip_purchase))
				{
					$arr = array("netsip_purchase" => $netsip_purchase);
					$result = $quote->saveQuote_section("netsip", $arr);
				}

				if(isset($quote_details['store']))
				{
					$store_purchase = array("cart" => array());
					foreach($quote_details['store'] as $key => $value)
					{
						if(is_numeric($key))
						{
							$tmp = array(
								"products_id" => $value['products_id'],
								"products_qty" => $value['products_qty'],
								"products_name" => $value['products_name'],
								"products_price" => $value['products_price'],
								"subtotal" => $value['subtotal']
							);
							array_push($store_purchase['cart'], $tmp);
						}
					}
					$arr = array("store_purchase" => $store_purchase);
					$result = $quote->saveQuote_section("phones", $arr);
				}

				$arr = array("userid" => $quote->userid);
				$result = $quote->updateQuoteMain($arr);

				if($result == "SUCCESS")
				{
					$retValue = "gotoq";
				}
				else
				{
					$retValue = "An error has occurred.<!--$result-->";
				}
			}
			else
			{
				$retValue = "<span class=alertsmall>$result Try again.</span><br>";
				$retValue .= "Your email address<br>";
				$retValue .= "<input type=text name=\"save_username\" id=\"save_username\" class=formElement style=\"width:140px; margin-bottom:10px;\" value=\"$email\"><br>";
				$retValue .= "<input type=button id=\"savebutton\" value=\" Save Quote \" onclick=\"saveQuote('u', document.getElementById('save_username').value)\">";
			}
			break;

			case "new":
			$err = "";
			$sendemail = isset($_GET['sendem']) ? $_GET['sendem'] : 0;
			$tmp = isset($_GET['val']) ? explode("`", $_GET['val']) : array();
			$email = $tmp[0];
			$firstname = $tmp[1];
			$lastname = $tmp[2];
			$firstname_check = str_replace(" " , "", $tmp[1]);
			$lastname_check = str_replace(" " , "", $tmp[2]);

			$password = str_replace(" " , "", $tmp[3]);
			$password2 = isset($tmp[4]) ? str_replace(" " , "", $tmp[4]) : "";

			$fnamebg = "";
			$lnamebg = "";
			$p1bg = "";
			$p2bg = "";
			if(empty($firstname_check))
			{
				$fnamebg = "background:#ffcc00;";
				$err .= "No first name<br>";
			}
			if(empty($lastname_check))
			{
				$lnamebg = "background:#ffcc00;";
				$err .= "No last name<br>";
			}
			$p1bg = empty($password) ? "background:#ffcc00;" : "";
			$err .= empty($password) ? "No password<br>" : $err;
			$p2bg = empty($password2) || ($password != $password2) ? "background:#ffcc00;" : "";
			$p1bg = !empty($p2bg) ? "background:#ffcc00;" : "";
			$err .= empty($password2) || ($password != $password2) ? "Passwords did not match<br>" : $err;

			if(substr_count($password, "@") > 0)
			{
				$err .= "Invalid character in password (@)<br>";
			}
			if(substr_count($password, "&") > 0)
			{
				$err .= "Invalid character in password (&)<br>";
			}

			if(!empty($err))
			{
				$retValue = "<span class=alertsmall>$err</span>";
				$retValue .= "<br>First Name:<br><input type=\"text\" name=\"save_firstname\" id=\"save_firstname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px; $fnamebg\" value=\"$firstname\">";
				$retValue .= "<br>Last Name:<br><input type=\"text\" name=\"save_lastname\" id=\"save_lastname\" class=\"formElement\" style=\"width:140px; margin-bottom:5px; $lnamebg\" value=\"$lastname\">";
				$retValue .= "<br>Password<br><input type=\"password\" name=\"password\" id=\"save_p1\" class=\"formElement\" style=\"width:140px; margin-bottom:5px; $p1bg\">";
				$retValue .= "<br>Confirm Password<br><input type=\"password\" name=\"password2\" id=\"save_p2\" class=\"formElement\" style=\"width:140px; margin-bottom:10px; $p2bg\">";
				$retValue .= "<br><input type=button id=\"savebutton\" value=\" Submit \" onclick=\"saveQuote('new', '$email', 1)\">";
				$retValue .= $isAdmin ? "<div style=\"float:right; width:10px; height:10px; cursor:pointer; margin-top:5px; border:1px dashed #000000;\" onclick=\"saveQuote('new', '$email', 0)\"></div>" : "";
			}
			else
			{
				$userid = 0;
				$ip = $_SERVER['REMOTE_ADDR'];
				$host = gethostbyaddr("$ip");
				$arrUser= array(
					"userid" => $userid,
					"email" => $email,
					"password" => $password,
					"firstname" => $firstname,
					"lastname" => $lastname,
					"ip" => $ip,
					"host" => $host
				);
				$result = $quote->addUser($arrUser);
				if($result == "SUCCESS")
				{
					$quote = new quote($quote_id,$quote->userid);

					$result = $quote->signin($email,$password);
					if($result == "SUCCESS")
					{
						$_SESSION['Quote_uid'] = $userid = $quote->userid;
						//$result = $quote->saveQuote($quote->userid, $quote_details);
						//stick userid into quote_main for this quote
						$arr = array("userid" => $userid);
						$result = $quote->updateQuoteMain($arr);
						if($sendemail)
						{
							//User gets an email ONLY THE FIRST TIME A QUOTE IS SAVED
							//	Email should contain quote details (whatever state it may be in!)
							$newUser = 1;
							$quote->emailQuote($newUser);

							/*BYE BYE ZOHO
							//NEW! NEW! NEW! ZOHO...

							//send email to sales@voiplion on failure
							require_once($MAIN_INCLUDE_PATH."classes/class.zoho.php");
							$zoho = new zoho();
							$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
							$headers .= "Return-Path: <sales@voiplion.com>\r\n";
							$eol = PHP_EOL;

							//come from lander?
							if(isset($_SESSION['zoho_record_id']) && isset($_SESSION['zoho_email']))
							{
								$zoho->action = "updateLeadStatus";
								$lead_status = 0;
								$lead_priority = "Completed";
								$zoho->updateLeadStatus($_SESSION['zoho_record_id'], $lead_status, $lead_priority);
								if($zoho->arrResponse['response'] == "SUCCESS")
								{
									$zoho->action = "insertNote";
									$subject = "Saved Quote Number {$quote_id}";
									$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
									$zoho->insertNote($_SESSION['zoho_record_id'], $subject, $note);
									if($zoho->arrResponse['response'] != "SUCCESS")
									{
										$subject = "FAILED Zoho New Note Attempt from QB2";
										$message = "Quote Number {$quote_id} $eol$eol ";
										$message .= "User: {$_SESSION['zoho_email']} $eol$eol ";
										$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
										@mail("sales@voiplion.com", $subject, $message, $headers);
									}
								}
								else
								{
									$subject = "FAILED Zoho Lead Update from QB2";
									$message = "Quote Number {$quote_id} $eol$eol ";
									$message .= "User: {$_SESSION['zoho_email']} $eol$eol ";
									$message .= "Lead Priority: Completed $eol$eol ";
									@mail("sales@voiplion.com", $subject, $message, $headers);
								}
							}
							else
							{
								$zoho->search_column = "email";
								$zoho->search_value = $email;
								$zoho->action = "getSearchRecordsByPDC";

								$result = $zoho->doAction();
								if($zoho->arrResponse['response'] == "SUCCESS")
								{
									$email_found = false;
									$row = 0;
									$leadid = 0;
									$email_zoho = "";
									if(isset($zoho->arrResponse['leads']) && count($zoho->arrResponse['leads']))
									{
										foreach($zoho->arrResponse['leads'] as $key => $value)
										{
											$row = $value['row'];
											$record_id = $value['leadid'];
											$email_zoho = $value['email'];
											if($email_zoho == $email)
											{
												$email_found = true;
												break;
											}
										}
									}
									if($email_found)
									{
										$zoho->action = "updateLeadStatus";
										$lead_status = 0;
										$lead_priority = "Completed";
										$zoho->updateLeadStatus($record_id, $lead_status, $lead_priority);
										if($zoho->arrResponse['response'] != "SUCCESS")
										{
											$subject = "FAILED Zoho Lead Update from QB2";
											$message = "Quote Number {$quote_id} $eol$eol ";
											$message .= "User: {$email} $eol$eol ";
											$message .= "Lead Priority: Completed $eol$eol ";
											@mail("sales@voiplion.com", $subject, $message, $headers);
										}

										$zoho->action = "insertNote";
										$subject = "Saved Quote Number {$quote_id}";
										$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
										$zoho->insertNote($record_id, $subject, $note);
										if($zoho->arrResponse['response'] != "SUCCESS")
										{
											$subject = "FAILED Zoho New Note Attempt from QB2";
											$message = "Quote Number {$quote_id} $eol$eol ";
											$message .= "User: {$email} $eol$eol ";
											$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
											@mail("sales@voiplion.com", $subject, $message, $headers);
										}
									}
								}
								else if($zoho->arrResponse['response'] == "NODATA")
								{
									$zoho->action = "insertRecords";
									$name = $firstname." ".$lastname;
									$fname = $firstname;
									$lname = $lastname;
									$arr = array("name"=>$name, "fname"=>$fname, "lname"=>$lname, "email"=>$email);
									$zoho->insertRecord($arr);
									if($zoho->arrResponse['response'] == "SUCCESS")
									{
										$record_id = $zoho->arrResponse['record_id'];
										$zoho->action = "updateLeadStatus";
										$lead_status = 0;
										$lead_priority = "Completed";
										$zoho->updateLeadStatus($record_id, $lead_status, $lead_priority);

										$zoho->action = "insertNote";
										$subject = "Saved Quote Number {$quote_id}";
										$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
										$zoho->insertNote($record_id, $subject, $note);
										if($zoho->arrResponse['response'] != "SUCCESS")
										{
											$subject = "FAILED Zoho New Note Attempt from QB2";
											$message = "Quote Number {$quote_id} $eol$eol ";
											$message .= "User: $email $eol$eol ";
											$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
											@mail("sales@voiplion.com", $subject, $message, $headers);
										}
									}
									else
									{
										$subject = "FAILED Zoho New Lead Attempt from QB2";
										$message = "Quote Number {$quote_id} $eol$eol ";
										$message .= "User: {$email} $eol$eol ";
										$message .= "Lead Priority: Completed $eol$eol ";
										@mail("sales@voiplion.com", $subject, $message, $headers);
									}
								}
							}
							*/
						}
						//$retValue = "gotoq";
						//trying to account for users coming from lander and inserting google ad noscript code to review code
						$retValue = $newUser == 1 ? "gotoq_google" : "gotoq";
					}
					else
					{
						$retValue = $result;
					}
				}
				else
				{
					$retValue = $result;
				}
			}
			break;
		}
		print $retValue;
	break;

	case "add_note_form":
		$userid = isset($_GET['uid']) ? $_GET['uid'] : 0;
		$quote_id = isset($_GET['qid']) ? $_GET['qid'] : 0;
		$retValue = "<table>";
		$retValue .= "<tr><td><textarea id=quote_note style=\"width:180px; height:50px;\" class=formElement></textarea></td></tr>";
		$retValue .= "<tr><td align=right><input type=button value=\" submit \" onclick=\"addNotes('{$quote_id}', '{$userid}')\"></td></tr>";
		$retValue .= "</table>";

		print $retValue;		
	break;

	case "add_note":
		$note = $_POST['note'];		
		$arr = array(
			"quote_id" => $quote_id,
			"note" => $note,
			"user" => $isAdmin ? $adminusername : "user"
		);
		$result = $quote->addNote($arr);
		if($result == "SUCCESS")
		{
			print "note added";
		}
		else
		{
			print "Unable to add note <!--$result-->";
		}
	break;

	case "set_channel_price":
		//for sip unlimited packages
		$channels = $_GET['channels'];
		$netsip_monthly = getPerChannelPrice($channels);
		print "\$$netsip_monthly";
	break;

	case "get_shipping_quotes":
		$quote_details = $quote->getQuote($quote_id,$userid);

		//ensure user has $quote_details['user']['x_shipping'] info
		if(empty($quote_details['user']['address1_shipping']))
		{
			$arrUser = array(
				"userid" => $userid,
				"email" => $quote_details['user']['email'],
				"firstname_shipping" => $quote_details['user']['firstname'],
				"lastname_shipping" => $quote_details['user']['lastname'],
				"companyname_shipping" => $quote_details['user']['companyname'],
				"address1_shipping" => $quote_details['user']['address1'],
				"address2_shipping" => $quote_details['user']['address2'],
				"city_shipping" => $quote_details['user']['city'],
				"state_shipping" => $quote_details['user']['state'],
				"postcode_shipping" => $quote_details['user']['postcode'],
				"country_shipping" => $quote_details['user']['country'],
				"phonenumber_shipping" => $quote_details['user']['phonenumber']
			);
			$result = $quote->updateUser($arrUser);

			$quote_details = $quote->getQuote($quote_id,$userid);
		}


		$products = new products();
		$arrProducts = $products->storeDisplay();

		$taxrate = $products->taxrate;
		//we're only taxing orders going to GA
		$taxrate = isset($quote_details['user']['state_shipping']) && $quote_details['user']['state_shipping'] == "GA" ? $taxrate : 0;
		$products_subtotal_taxable = 0;

		//BUILD ARRAY FOR NETX QUOTE
		$arrUserNetX = array(
			"accountcode" => $quote_details['main']['quote_id'],
			"company" => $quote_details['user']['companyname_shipping'],
			"contact" => $quote_details['user']['firstname_shipping']." ".$quote_details['user']['lastname_shipping'],
			"phonenumber" => $quote_details['user']['phonenumber_shipping'],
			"address1" => $quote_details['user']['address1_shipping'],
			"address2" => $quote_details['user']['address2_shipping'],
			"city" => $quote_details['user']['city_shipping'],
			"state" => $quote_details['user']['state_shipping'],
			"zip" => $quote_details['user']['postcode_shipping'],
			"country" => $quote_details['user']['country_shipping']
		);
		$arrOrderInfo['products'] = array();
		$arrNonNetXShipProducts = array();
//print_r($arrProducts);
		foreach($quote_details['store'] as $key => $value)
		{
			for($i=0; $i < count($arrProducts); $i++)
			{
				if($value['products_id'] == $arrProducts[$i]['products_id'])
				{
					$qty = $value['products_qty'];
					$products_category = $arrProducts[$i]['master_categories_id'];
					$products_model = $arrProducts[$i]['products_model'];
					$manufacturers_name = $arrProducts[$i]['manufacturers_name'];
					if($qty > 0)
					{
						$tmp = array(
							"qty" => $qty,
							"products_model" => $products_model,
							"manufacturers_name" => $manufacturers_name
						);
						//category 73 = Networking Gear, category 75 = Misc. // && $manufacturers_name != "Cisco"
						if($products_category != 73 && $products_category != 75 && substr_count($products_model, "Open Box") == 0)
						{
							array_push($arrOrderInfo['products'], $tmp);
						}
						if($products_category == 73 || substr_count($products_model, "Open Box") > 0)
						{
							array_push($arrNonNetXShipProducts, $value);
						}
					}

					if($arrProducts[$i]['products_tax_class_id'] > 0)
					{
						$products_subtotal_taxable += $arrProducts[$i]['products_price'] * $qty;
					}
				}
			}
		}

		//we need to update tax here as this may be the first time we get state_shipping...watch total as well
		//$tax = count($arrOrderInfo['products']) > 0 ? $products_subtotal_taxable * $taxrate : 0;
		$tax = $products_subtotal_taxable > 0 ? $products_subtotal_taxable * $taxrate : 0;
		$arr = array("tax" => $tax);
		$result = $quote->updateQuoteMain($arr);
//print_r($arrNonNetXShipProducts);
		if(count($arrOrderInfo['products']) == 0)
		{
			$upsItems = "";
			$fedexItems = "";
			$shipMethod = "<table width=\"100%\" cellspacing=\"0\" border=0 style=\"margin-top:20px;\"><tr><td>\n";
			//$shipMethod .= "<tr><td><span class=pageSubTitle>Shipping Method:</span></td></tr>\n";
			if(count($arrNonNetXShipProducts))
			{
				$shiptotal = 15;
				$total_NonNetX_products = 0;
				foreach($arrNonNetXShipProducts as $key => $value)
				{
					//$shiptotal += $value['products_qty'] * 15;
					$total_NonNetX_products += $value['products_qty'];
				}
				$shiptotal += ($total_NonNetX_products - 1) * 7.5;
				$shiptotalLabel = number_format($shiptotal, 2);
				$shipMethod .= "<fieldset><legend><span class=listTextBold>United Parcel Service</span></legend>\n";
				$shipMethod .= "<table width=\"100%\" cellspacing=\"0\" border=0>\n";
				$shipMethod .= "<tr>";
				$shipMethod .= "<td style=\"width:20px;\"><input type=\"radio\" name=\"shipping\" id=\"UPS_Ground_{$shiptotal}\" value=\"UPS_Ground_{$shiptotal}\" checked></td>";
				$shipMethod .= "<td>Ground</td>";
				$shipMethod .= "<td align=right>\$$shiptotalLabel</td></tr>\n";
				$shipMethod .= "</table></fieldset>";
			}
			else
			{
				$shipMethod .= "<tr><td class=listText>There are no items that require shipping.</td></tr>\n";
			}
			$shipMethod .= "</td></tr>\n";
			$shipMethod .= "<tr><td colspan=2 align=right style=\"padding:10px 10px 0 0;\"><input type=button style=\"cursor:pointer;\" value=\"Continue\" onclick=\"saveShipping()\"></td></tr>\n";
			$shipMethod .= "</table>\n<div id=shipping_resp></div>";
		}
		else
		{
			$ups_shippable = 0;
			$fedex_shippable = 0;
			
			$shipMethod = "<table width=\"100%\" cellspacing=\"0\" border=0 style=\"margin-top:0px;\">\n";
			$shipMethod .= "<tr><td valign=top>";
			$shipAdd = 0;
			if(count($arrNonNetXShipProducts))
			{
				$shipAdd += 15;
				$total_NonNetX_products = 0;
				foreach($arrNonNetXShipProducts as $key => $value)
				{
					//$shiptotal += $value['products_qty'] * 15;
					$total_NonNetX_products += $value['products_qty'];
				}
				$shipAdd += ($total_NonNetX_products - 1) * 7.5;
			}
			require_once($MAIN_INCLUDE_PATH."classes/class.netx.php");
			$netx = new netx();
			$netx->arrUser = $arrUserNetX;
			$netx->arrProducts = $arrOrderInfo['products'];
			$quoteUPS = $netx->getQuote("UPS");

			$upsItems = "<fieldset style=\"width:330px;\"><legend><span class=listTextBold>United Parcel Service</span></legend>\n";
			$upsItems .= "<table width=\"100%\" cellspacing=\"0\" border=0 style=\"margin-top:0px;\">\n";
			if(substr_count($quoteUPS[0], "method") > 0)
			{
				$validShippingFound = 0;
				for($i=1; $i < count($quoteUPS); $i++)
				{
					if($quoteUPS[$i] != "")
					{
						$tmp = explode(",", $quoteUPS[$i]);
						$method = $tmp[0];
						$cost = $tmp[1] + ($tmp[1] * .2) + $shipAdd;
						$cost = number_format($cost,2);
						if(isset($quote_details['store']['shipping']))
						{
							$storedMethod = $quote_details['store']['shipping']['shipper'] ."_".$quote_details['store']['shipping']['method'];
							$thisMethod = "UPS_".$method;
							if($thisMethod == $storedMethod)
							{
								$checked = "checked";
							}
							else
							{
								$checked = "";
							}
						}
						else
						{
							$checked = $i == 1 ? "checked" : "";
						}
						if($tmp[1] > 0)
						{
							$validShippingFound = 1;
							$ups_shippable = 1;
							$upsItems .= "<tr onmouseover='this.style.backgroundColor = \"#f1f1f1\";' onmouseout='this.style.backgroundColor = \"#FFFFFF\";' onclick=\"document.getElementById('UPS_{$method}_{$cost}').checked = true;\">";
							$upsItems .= "<td><input type=\"radio\" name=\"shipping\" id=\"UPS_{$method}_{$cost}\" value=\"UPS_{$method}_{$cost}\" $checked></td>";
							$upsItems .= "<td>$method</td>";
							$upsItems .= "<td align=right>\$$cost</td>";
							$upsItems .= "</tr>\n";
						}
					}
				}
				if(!$validShippingFound)
				{
					$formShippingSubmit = "";
					$upsItems .= "<tr><td class=alert>Unable to calculate shipping for some items. Please contact VOIPLION.COM Customer Care.</td></tr>\n";
				}
			}
			else
			{
				$tmp = explode(":",$quoteUPS[0]);
				$unexpected_error = isset($tmp[2]) ? $tmp[2] : "";
				$upsItems .= "<tr><td class=alert>$unexpected_error<!--" . implode(":",$tmp) . "--></td></tr>\n";
			}
			$upsItems .= "</table></fieldset>";

			$shipMethod .= "$upsItems</td><td valign=top>\n";

			$quoteFedEx = $netx->getQuote("FedEx");
			$fedexItems = "<fieldset style=\"width:330px;\"><legend><span class=listTextBold>Federal Express</span></legend>\n";
			$fedexItems .= "<table width=\"100%\" cellspacing=\"0\" border=0 style=\"margin-top:0px;\">\n";
			if(substr_count($quoteFedEx[0], "method") > 0)
			{
				$validShippingFound = 0;
				for($i=1; $i < count($quoteFedEx); $i++)
				{
					if($quoteFedEx[$i] != "")
					{
						$tmp = explode(",", $quoteFedEx[$i]);
						$method = $tmp[0];
						$cost = $tmp[1] + ($tmp[1] * .2) + $shipAdd;
						$cost = number_format($cost,2);
						$checked = "";
						if(isset($quote_details['store']['shipping']))
						{
							$storedMethod = $quote_details['store']['shipping']['shipper'] . "_" . $quote_details['store']['shipping']['method'];
							$thisMethod = "FEDEX_".$method;
							if($thisMethod == $storedMethod)
							{
								$checked = "checked";
							}
							else
							{
								$checked = "";
							}
						}
						if($tmp[1] > 0)
						{
							$validShippingFound = 1;
							$fedex_shippable = 1;
							$fedexItems .= "<tr onmouseover='this.style.backgroundColor = \"#f1f1f1\";' onmouseout='this.style.backgroundColor = \"#FFFFFF\";' onclick=\"document.getElementById('FEDEX_{$method}_{$cost}').checked = true;\">";
							$fedexItems .= "<td><input type=\"radio\" name=\"shipping\" id=\"FEDEX_{$method}_{$cost}\" value=\"FEDEX_{$method}_{$cost}\" $checked></td>";
							$fedexItems .= "<td>$method</td><td align=right>\$$cost</td>";
							$fedexItems .= "</tr>\n";
						}
					}
				}
				if(!$validShippingFound)
				{
					$formShippingSubmit = "";
					$fedexItems .= "<tr><td class=alert>Unable to calculate shipping for some items. Please contact VOIPLION.COM Customer Care.</td></tr>\n";
				}
			}
			else
			{
				$tmp = explode(":",$quoteFedEx[0]);
				$unexpected_error = isset($tmp[2]) ? $tmp[2] : "";
				$fedexItems .= "<tr><td class=alert>$unexpected_error<!--" . implode(":",$tmp) . "--></td></tr>\n";
			}
			$fedexItems .= "</table></fieldset>";

			$shipMethod .= "$fedexItems</td></tr>\n";

			$save_shipping_btn_enabled = $ups_shippable || $fedex_shippable ? "" : "disabled";
			$save_shipping_btn_class = $ups_shippable || $fedex_shippable ? "button_submit" : "button_submit_disabled";

			$shipMethod .= "<tr><td colspan=2 align=right style=\"padding:10px 10px 0 0;\"><input type=button class=\"{$save_shipping_btn_class}\" value=\"Continue\" onclick=\"saveShipping()\" $save_shipping_btn_enabled></td></tr>\n";
			$shipMethod .= "</table>\n<div id=shipping_resp></div>";
		}
		print $shipMethod;
	break;

	case "save_shipping":
		$quote_details = $quote->getQuote($quote_id,$userid);
		$tmp = explode("_", $_POST['val']);
		$store_purchase = array("cart" => array(), "shipping" => array("shipper" => $tmp[0],"method" => $tmp[1],"cost" => $tmp[2]));
		foreach($quote_details['store'] as $key => $value)
		{
			if(is_numeric($key))
			{
				$tmp = array(
					"products_id" => $value['products_id'],
					"products_qty" => $value['products_qty'],
					"products_name" => $value['products_name'],
					"products_price" => $value['products_price'],
					"subtotal" => $value['subtotal']
				);
				array_push($store_purchase['cart'], $tmp);
			}
		}
		if(count($store_purchase['cart']) == 0)
		{
			unset($store_purchase['shipping']);
		}
		$arr = array("store_purchase" => $store_purchase);
		$result = $quote->saveQuote_section("phones", $arr);

		updateMain();

		print "gotoorder";
	break;

	case "change_shipping":
		$quote_details = $quote->getQuote($quote_id,$userid);
		$store_purchase = array("cart" => array());
		foreach($quote_details['store'] as $key => $value)
		{
			if(is_numeric($key))
			{
				$tmp = array(
					"products_id" => $value['products_id'],
					"products_qty" => $value['products_qty'],
					"products_name" => $value['products_name'],
					"products_price" => $value['products_price'],
					"subtotal" => $value['subtotal']
				);
				array_push($store_purchase['cart'], $tmp);
			}
		}
		$arr = array("store_purchase" => $store_purchase);
		$result = $quote->saveQuote_section("phones", $arr);
		print "gotoorder";
	break;

	case "change_shipping_address":
		//print_r($_POST);
		//exit;
		$quote_details = $quote->getQuote($quote_id,$userid);
		$statetouse = $_POST['country'] == "US" ? $_POST['state'] : $_POST['pr'];
		$arr = array(
			"email" => $quote_details['user']['email'],
			"firstname" => $_POST['firstname'],
			"lastname" => $_POST['lastname'],
			"companyname" => $_POST['companyname'],
			"address1" => $_POST['address1'],
			"address2" => $_POST['address2'],
			"city" => $_POST['city'],
			"state" => $statetouse,
			"postcode" => $_POST['postcode'],
			"country" => $_POST['country'],
			"phonenumber" => $_POST['phonenumber']
		);
		$err = checkRequiredFields($arr);
		if(!empty($err))
		{
			print "<span class=alertsmall>$err</span>";
			exit;
		}
		$arrUser = array(
			"userid" => $userid,
			"email" => $quote_details['user']['email'],
			"firstname_shipping" => $_POST['firstname'],
			"lastname_shipping" => $_POST['lastname'],
			"companyname_shipping" => $_POST['companyname'],
			"address1_shipping" => $_POST['address1'],
			"address2_shipping" => $_POST['address2'],
			"city_shipping" => $_POST['city'],
			"state_shipping" => $statetouse,
			"postcode_shipping" => $_POST['postcode'],
			"country_shipping" => $_POST['country'],
			"phonenumber_shipping" => $_POST['phonenumber']
		);
		$result = $quote->updateUser($arrUser);
		if($result == "SUCCESS")
		{
			print "gotoorder";
			exit;
		}
		print "An error has occurred.<!--\n$result\n-->";
	break;

	case "process_order_ccsagent":
		//print_r($_POST);
		//print_r($quote->user);
		//exit;

		/*
		//with implementation of USBank, we need to create a "Pending" WHMCS record
		$result = $quote->createPendingClient($quote->user);
		if($result != "SUCCESS")
		{
			print $result;
			exit;
		}
		*/
		if(isset($_POST['comments']) && !empty($_POST['comments']))
		{
			$arr = array("comments" => $_POST['comments']);
			$result = $quote->updateQuoteMain($arr);
		}

		$quote_details = $quote->getQuote($quote_id,$userid);
		//print_r($quote_details);

		$quote_total = $quote_details['main']['total'];
		$quote_total_mrr = $quote_details['main']['total_monthly'];

		$quote->createPDF("ORDER CONFIRMATION");

		$name = $quote_details['user']['firstname']." ".$quote_details['user']['lastname'];
		$email = $quote_details['user']['email'];

		$havePaymentInfo = empty($quote_details['user']['cardnumber']) && empty($quote_details['user']['checkaccount']) ? false : true;
		if($using_usbank)
		{
			//cannot use the above to determine havePaymentInfo...
			require_once($MAIN_INCLUDE_PATH."classes/class.usbank.php");
			$usbank = new usbank();
		}

		$ccs_agent_name = "";
		$ccs_agent_email = "";
		$channel_mgr_email = "";

		$salesrep = $quote->user['salesrep'];
		$tmp = array("firstname", "lastname", "email", "channel_mgr_email");
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_main.ccs_agent", "`agent_code` = '$salesrep'");
		if(count($tmp_info))
		{
			$ccs_agent_name = $tmp_info['firstname']." ".$tmp_info['lastname'];
			$ccs_agent_email = $tmp_info['email'];
			$channel_mgr_email = $tmp_info['channel_mgr_email'];
		}

		if(sendConfirmationEmail($quote_details, "agent"))
		{
			$arr = array("customer_notified" => time());
			$result = $quote->updateQuoteMain($arr);

			$path = $ROOT_PATH."cache/";
			$filename = "quote_".$quote->quote_id.".pdf";
			$fileatt = $path.$filename; // Path to the file 
			$fileatt_type = "application/pdf"; // File Type 
			$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
			$file = fopen($fileatt,'rb'); 
			$data = fread($file,filesize($fileatt)); 
			fclose($file); 

			$data = chunk_split(base64_encode($data)); 
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

			// a random hash will be necessary to send mixed content
			$separator = md5(time());
			$eol = PHP_EOL;

			$subject = "VOIPLION.COM Order Verification [$quote_id]";
			$to = "$ccs_agent_name <$ccs_agent_email>";

			//hide password from agent?
			if($havePaymentInfo)
			{
				$message = "This order has been submitted. $name [$email] has been sent an email with further instructions on how to confirm this order. $eol$eol";
				$message .= "We cannot process the order without their confirmation.  You may want to reach out to your customer and make sure they received the email. ";
			}
			else
			{
				$message = "This order has been submitted. $name [$email] has been sent an email with further instructions on how to submit their payment information and complete the order process. $eol$eol";
				$message .= "We cannot process the order without their payment information.  You may want to reach out to your customer and make sure they received the email and enter their payment information.";
			}

			$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
			$headers .= "Return-Path: <sales@voiplion.com>\r\n";
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
			$headers .= "Content-Transfer-Encoding: 7bit".$eol;
			$headers .= "This is a MIME encoded message.".$eol.$eol;
			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $message.$eol.$eol;
			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $data.$eol.$eol;
			$headers .= "--".$separator."--";
			
			@mail($to, $subject, $message, $headers);

			if(!empty($channel_mgr_email))
			{
				$message = "Your agent, $ccs_agent_name, has created a quote ($quote_id) for $name in the amount of \$$quote_total and an MRR of \$$quote_total_mrr. $eol$eol ";

				$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
				$headers .= "Return-Path: <sales@voiplion.com>\r\n";
				$headers .= "MIME-Version: 1.0".$eol;
				$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
				$headers .= "Content-Transfer-Encoding: 7bit".$eol;
				$headers .= "This is a MIME encoded message.".$eol.$eol;
				// message
				$headers .= "--".$separator.$eol;
				$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
				$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
				$headers .= $message.$eol.$eol;
				// attachment
				$headers .= "--".$separator.$eol;
				$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
				$headers .= "Content-Transfer-Encoding: base64".$eol;
				$headers .= "Content-Disposition: attachment".$eol.$eol;
				$headers .= $data.$eol.$eol;
				$headers .= "--".$separator."--";

				@mail($channel_mgr_email, $subject, $message, $headers);
			}
		}
		else
		{
			$tmp = array(
				"Where" => "QB2 Failed to send email. qb_fn->process_order_ccsagent",
				"Quote ID" => $quote_id,
				"User ID" => $userid,
				"Message" => $message,
			);
			$error = new error();
			$error->arrError = $tmp;
			$error->logError();
		}
		print "<!--cssagentordered-->";

		//if we have cc or ach info, need to display a different message
		if($havePaymentInfo)
		{
			print "<div>Your order has been submitted. Your customer has been sent an email with further instructions on how to confirm this order.  ";
			print "We cannot process the order without their confirmation.  You may want to reach out to your customer and make sure they received the email.</div>";
		}
		else
		{
			print "<div>Your order has been submitted. Your customer has been sent an email with further instructions on how to submit their payment information and complete the order process.  ";
			print "We cannot process the order without their payment information.  You may want to reach out to your customer and make sure they received the email and enter their payment information.</div>";
		}

		print "<div style=\"padding-top:20px;\"><a href=\"/agent/\">Return to Agent Admin</a></div>";
	break;

	case "process_order_ccsdirect":
		//print_r($_POST);
		//print_r($quote->user);
		//exit;

		/*
		//with implementation of USBank, we need to create a "Pending" WHMCS record
		$result = $quote->createPendingClient($quote->user);
		if($result != "SUCCESS")
		{
			print $result;
			exit;
		}
		*/

		if(isset($_POST['comments']) && !empty($_POST['comments']))
		{
			$arr = array("comments" => $_POST['comments']);
			$result = $quote->updateQuoteMain($arr);
		}

		//If delayed billing...
		$delay_billing = isset($_POST['delay_billing']) && $_POST['delay_billing'] == 1 ? 1 : 0;
		$delay_date = isset($_POST['delay_date']) ? $_POST['delay_date'] : "";
		if($delay_billing)
		{
			//ID10T
			if(empty($delay_date))
			{
				print "Please select a date for delayed billing.";
				exit;
			}
			if(strtotime($delay_date) < mktime(0,0,0,date("m"),date("d"),date("Y")))
			{
				print "The date for delayed billing has already passed. Please select another date.";
				exit;
			}

			//new field in quote_main to hold delayed billing date?
			$arr = array("delayed_billing" => strtotime($delay_date));
			$result = $quote->updateQuoteMain($arr);
		}
		else
		{
			//in case of editing and they changed their mind
			$arr = array("delayed_billing" => "");
			$result = $quote->updateQuoteMain($arr);
		}

		$quote_details = $quote->getQuote($quote_id,$userid);
		//print_r($quote_details);

		$quote->createPDF("ORDER CONFIRMATION");

		$havePaymentInfo = empty($quote_details['user']['cardnumber']) && empty($quote_details['user']['checkaccount']) ? false : true;
		if($using_usbank)
		{
			//cannot use the above to determine havePaymentInfo...
			require_once($MAIN_INCLUDE_PATH."classes/class.usbank.php");
			$usbank = new usbank();
		}

		if(sendConfirmationEmail($quote_details, "direct"))
		{
			$arr = array("customer_notified" => time());
			$result = $quote->updateQuoteMain($arr);


			$name = $quote_details['user']['firstname']." ".$quote_details['user']['lastname'];
			$email = $quote_details['user']['email'];

			$ccs_rep_name = "our sales team";
			$ccs_rep_email = "";
			$salesrep = $quote_details['user']['salesrep'];
			$tmp = array("firstname", "lastname", "email");
			$tmp_info = $quote->getFieldValues($tmp, "voiplion_whmcs.tbladmins", "`username` = '$salesrep' limit 1");
			if(count($tmp_info))
			{
				$ccs_rep_name = $tmp_info['firstname']." ".$tmp_info['lastname'];
				$ccs_rep_email = $tmp_info['email'];
			}

			$path = $ROOT_PATH."cache/";
			$filename = "quote_".$quote->quote_id.".pdf";
			$fileatt = $path.$filename; // Path to the file 
			$fileatt_type = "application/pdf"; // File Type 
			$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
			$file = fopen($fileatt,'rb'); 
			$data = fread($file,filesize($fileatt)); 
			fclose($file); 

			$data = chunk_split(base64_encode($data)); 

			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

			// a random hash will be necessary to send mixed content
			$separator = md5(time());
			$eol = PHP_EOL;

			$subject = "VOIPLION.COM Order Verification [$quote_id]";
			$to = "$ccs_rep_name <$ccs_rep_email>";

			if($havePaymentInfo)
			{
				$message = "This order has been submitted. $name [$email] has been sent an email with further instructions on how to confirm this order. $eol$eol";
				$message .= "We cannot process the order without their confirmation.  You may want to reach out to your customer and make sure they received the email. ";
			}
			else
			{
				$message = "This order has been submitted. $name [$email] has been sent an email with further instructions on how to submit their payment information and complete the order process. $eol$eol";
				$message .= "We cannot process the order without their payment information.  You may want to reach out to your customer and make sure they received the email and enter their payment information.";
			}

			$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
			$headers .= "Return-Path: <sales@voiplion.com>\r\n";
			$headers .= "MIME-Version: 1.0".$eol;
			$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
			$headers .= "Content-Transfer-Encoding: 7bit".$eol;
			$headers .= "This is a MIME encoded message.".$eol.$eol;
			// message
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
			$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
			$headers .= $message.$eol.$eol;
			// attachment
			$headers .= "--".$separator.$eol;
			$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
			$headers .= "Content-Transfer-Encoding: base64".$eol;
			$headers .= "Content-Disposition: attachment".$eol.$eol;
			$headers .= $data.$eol.$eol;
			$headers .= "--".$separator."--";

			@mail($to, $subject, $message, $headers);
		}
		else
		{
			$tmp = array(
				"Where" => "QB2 Failed to send email. qb_fn->process_order_ccsdirect",
				"Quote ID" => $quote_id,
				"User ID" => $userid,
				"Message" => $message,
			);
			$error = new error();
			$error->arrError = $tmp;
			$error->logError();
		}
		print "<!--cssagentordered-->"; //reuse this...triggers js

		//if we have cc or ach info, need to display a different message
		if($havePaymentInfo)
		{
			print "<div>Your order has been submitted. Your customer has been sent an email with further instructions on how to confirm this order.  ";
			print "We cannot process the order without their confirmation.  You may want to reach out to your customer and make sure they received the email.</div>";
		}
		else
		{
			print "<div>Your order has been submitted. Your customer has been sent an email with further instructions on how to submit their payment information and complete the order process.  ";
			print "We cannot process the order without their payment information.  You may want to reach out to your customer and make sure they received the email and enter their payment information.</div>";
		}

		print "<div style=\"padding-top:20px;\"><a href=\"/quotebuilder/admin/\">Return to QuoteBuilder Admin</a></div>";
	break;

	case "process_order":
		if($_GET['accepted'] != 1)
		{
			print "You must agree to the Terms of Service.";
			exit;
		}

		//NEW OPTION for voiplion qb admins...delayed billing. If delayed billing, do not ding OR auth CC
		$delay_billing = isset($_POST['delay_billing']) && $_POST['delay_billing'] == 1 ? 1 : 0;
		$delay_date = isset($_POST['delay_date']) ? $_POST['delay_date'] : "";
		if($delay_billing)
		{
			//ID10T
			if(empty($delay_date))
			{
				print "Please select a date for delayed billing.";
				exit;
			}
			if(strtotime($delay_date) < mktime(0,0,0,date("m"),date("d"),date("Y")))
			{
				print "The date for delayed billing has already passed. Please select another date.";
				exit;
			}
		}
		//print_r($_POST);
		//exit;

		codeLog("QB2:$quote_id - Begin order process. [qb_fn->process_order]");

		if(isset($_POST['comments']) && !empty($_POST['comments']))
		{
			$arr = array("comments" => $_POST['comments']);
			$result = $quote->updateQuoteMain($arr);
		}

		$quote_details = $quote->getQuote($quote_id,$userid);

		$accountcode = isset($quote_details['user']['accountcode']) && $quote_details['user']['accountcode'] > 0 ? $quote_details['user']['accountcode'] : 0;

		$total_total = $quote_details['main']['total'];

		if($delay_billing)
		{
			$total_total -= $quote_details['netpbx']['price'];
			codeLog("QB2:$quote_id - Delayed Billing. Deduct PBX price ".$quote_details['netpbx']['price']." from total");
			if($quote_details['netpbx']['ha_price'] > 0)
			{
				$total_total -= $quote_details['netpbx']['ha_price'];
				codeLog("QB2:$quote_id - Delayed Billing. Deduct HA price".$quote_details['netpbx']['ha_price']." from total");
			}
		}

		$paymentmethod = $quote_details['main']['paymentmethod']; //NEW...for agent orders, if user selects ACH, all user quotes should be changed to "mailin"

		//TODO: allow existing clients to use ach...CLUSTER!!!

		//COMING SOON...BV customers WILL NOT GET DINGED (PBC customers also?)

		//if using_usbank, ALL paymentmethod's should be "mailin"!!!

		if($paymentmethod == "mailin")
		{
			$cardnumber = "";
			$auth_type = "";
			if($quote_details['main']['txid'] == "FA78BC88-4988-4A5A-930A-CEDED5A860AD")
			{
				codeLog("QB2:$quote_id - SKIPPED DING : $total_total. [qb_fn->process_order]");
				$response_code = 1;
				$response_reason = "";
				$approval_code = "";
				$txid = $quote_details['main']['txid'];
				$t = time();
			}
			else if(isset($quote_details['main']['is_paybycheck']) && $quote_details['main']['is_paybycheck'] == 1)
			{
				codeLog("QB2:$quote_id - PayByCheck : $total_total. [qb_fn->process_order]");
				$response_code = 1;
				$response_reason = "";
				$approval_code = "";
				$txid = "";
				$t = time();
			}
			else if($using_usbank)
			{
				require_once($MAIN_INCLUDE_PATH."classes/class.usbank.php");
				$usbank = new usbank();

				//do we need to set $auth_type here?
				$auth_type = "";

				/*
				$response_code = isset($result[0]) ? $result[0] : -1;
				$response_reason_code = isset($result[2]) ? $result[2] : -1;
				$response_reason = isset($result[3]) ? $result[3] : "";
				$approval_code = isset($result[4]) ? $result[4] : "";
				$auth_code = isset($result[5]) ? $result[5] : "";
				$txid = isset($result[6]) ? $result[6] : $t;

				$response_code = 1;
				$response_reason = "";
				$approval_code = "";
				$txid = "";
				$t = time();
				*/
			}
			else
			{
				$t = time();
				$details_ach = array(
					"checkaba" => $quote_details['user']['checkaba'],
					"checkaccount" => $quote_details['user']['checkaccount'],
					"account_holder_type" => $quote_details['user']['account_holder_type'],
					"account_type" => $quote_details['user']['account_type']
				);
				$details_billing = array(
					"accountcode" => $accountcode,
					"email" => $quote_details['user']['email'],
					"firstname" => $quote_details['user']['firstname_billing'],
					"lastname" => $quote_details['user']['lastname_billing'],
					"company" => $quote_details['user']['companyname_billing'],
					"address1" => $quote_details['user']['address1_billing'],
					"city" => $quote_details['user']['city_billing'],
					"state" => $quote_details['user']['state_billing'],
					"country" => $quote_details['user']['country_billing'],
					"phone" => $quote_details['user']['phonenumber_billing'],
					"zip" => $quote_details['user']['postcode_billing']
				);

				//NOTE: We may have to ding account here rather than auth only...unsure of how to capture after auth

				require_once($MAIN_INCLUDE_PATH."classes/class.ach.php");
				$ach = new ach();
				$auth_type = "sale";//"auth";

				/*
				if($isAdmin && !empty($quote_details['main']['txid']))
				{
					$auth_type = "capture";
					//which???
					//$ach->pg_authorization_code = $quote_details['main']['txid'];
					//$ach->pg_trace_number = $quote_details['main']['txid'];
				}
				*/

				$ach->pg_transaction_type = $auth_type;
				$arr = array(
					"orderid" => $quote_id,
					"amount" => $total_total,
					"achinfo" => $details_ach,
					"user" => $details_billing
				);
				$ach->setOrderValues($arr);
				$result = $ach->dingit();

				$response_code = isset($result[0]) ? $result[0] : -1;
				$response_reason_code = isset($result[2]) ? $result[2] : -1;
				$response_reason = isset($result[3]) ? $result[3] : "";
				$approval_code = isset($result[4]) ? $result[4] : "";
				$auth_code = isset($result[5]) ? $result[5] : "";
				$txid = isset($result[6]) ? $result[6] : $t;
	
				if($response_code != 1)
				{
					codeLog("QB2:$quote_id - auth failed. $response_reason. [qb_fn->process_order]");
		
					print "Error: We're sorry. We could not authorize these charges on your ACH Direct Debit Account. The reason given is:<br>\"{$response_reason}\"";
					exit;
				}
				$tmp = array("txid" => $txid);
				$quote->updateQuoteMain($tmp);
			}
		}
		else
		{
			require_once($MAIN_INCLUDE_PATH."functions/creditcard.php");
			$cyph = explode("|", $quote_details['user']['cardnumber']);
			$cardnumber = easy_decrypt($cyph);
			$cardtype = findCCtype($cardnumber);

			//run maxmind
			$tmp = explode("@", $quote_details['user']['email']);
			$domain = $tmp[1];
			// Area-code and local prefix of customer phone number
			$custPhone = str_replace(" ", "", $quote_details['user']['phonenumber']);
			$custPhone = str_replace("-", "", $custPhone);
			$custPhone = str_replace("/", "", $custPhone);
			if(substr($custPhone, 0, 1) == "1")
			{
				$custPhone = substr($custPhone, 1, strlen($custPhone));
			}
			$npa = substr($custPhone, 0, 3);
			$nxx = substr($custPhone, 3, 3);
			$custPhone = $npa ."-".$nxx;

			$bin = substr($cardnumber, 0, 6);

			$arrMM = array(
				"i" => $quote_details['user']['ip'],
				"city" => $quote_details['user']['city_billing'],
				"region" => $quote_details['user']['state_billing'],
				"postal" => $quote_details['user']['postcode_billing'],
				"country" => $quote_details['user']['country_billing'],
				"domain" => $domain,
				"emailMD5" => $quote_details['user']['email'],
				"custPhone" => $custPhone,
				"shipAddr" => $quote_details['user']['address1'],
				"shipCity" => $quote_details['user']['city'],
				"shipRegion" => $quote_details['user']['state'],
				"shipPostal" => $quote_details['user']['postcode'],
				"shipCountry" => $quote_details['user']['country']
			);

			if($cardnumber != "beau5Diner")
			{
				$arrMM['bin'] = $bin;
			}

			if(empty($quote_details['main']['fraudoutput']))
			{
				require_once($MAIN_INCLUDE_PATH."maxmind/maxmind.php");

				codeLog("QB2:$quote_id - Run MaxMind. [qb_fn->process_order]");

				//update quote_main with fraudoutput
				$arr = array("fraudoutput" => addslashes($strMM));
				$result = $quote->updateQuoteMain($arr);
			}

			//ding it!
			//01-08-2011...switching back to authorize...may still have users that PREAUTHed on linkpoint...set all values for BOTH

			//AUTHORIZE
			require_once($MAIN_INCLUDE_PATH."classes/class.authnet.php");
			$authnet = new authnet();

			//FIRST DATA
			require_once($MAIN_INCLUDE_PATH."classes/class.firstdata.php");
			$firstdata = new firstdata();

			//TODO: Need something else here...compare customer-email to quote->email maybe?
			/*
				twice now we've seen auth_type = sale when quote user has no whmcs record.
				may have to do with customer (or admin???) being logged in to an account
				but then using a different email for creating a quote.

				HOW DOES THIS EVEN HAPPEN!?!
			*/

			$auth_type = $paymentmethod == "linkpoint" ? "PREAUTH" : "AUTH_ONLY";
			if(isset($customer))
			{
				$email_match = $quote_details['user']['email'] == $customer->details['email'] ? true : false;
				if($paymentmethod == "linkpoint")
				{
					$auth_type = $email_match && $customer->CCverified ? "SALE" : $auth_type;
				}
				else
				{
					$auth_type = $email_match && $customer->CCverified ? "AUTH_CAPTURE" : $auth_type;
				}
			}

			if($isAdmin && !empty($quote_details['main']['txid']))
			{
				$auth_type = $paymentmethod == "linkpoint" ? "POSTAUTH" : "PRIOR_AUTH_CAPTURE";
				$authnet->authnet_values['x_trans_id'] = $quote_details['main']['txid'];
				$firstdata->order_values["oid"] = $quote_details['main']['txid'];
			}

			$authnet->authnet_values['x_type'] = $auth_type;
			$authnet->authnet_values['x_card_num'] = $cardnumber;
			$authnet->authnet_values['x_exp_date'] = $quote_details['user']['exp'];
			$authnet->authnet_values['x_description'] = "Quote Purchase $quote_id";
			$authnet->authnet_values['x_amount'] = $total_total;
			$authnet->authnet_values['x_first_name'] = $quote_details['user']['firstname_billing'];
			$authnet->authnet_values['x_last_name'] = $quote_details['user']['lastname_billing'];
			$authnet->authnet_values['x_address'] = $quote_details['user']['address1_billing'];
			$authnet->authnet_values['x_city'] = $quote_details['user']['city_billing'];
			$authnet->authnet_values['x_state'] = $quote_details['user']['state_billing'];
			$authnet->authnet_values['x_zip'] = $quote_details['user']['postcode_billing'];
			$authnet->authnet_values['CustomerAccountCode'] = $accountcode;

			$firstdata->ordertype = $auth_type;
			$cardinfo = array(
				"cardnumber" => $quote_details['user']['cardnumber'],
				"cardtype" => $cardtype,
				"exp" => $quote_details['user']['exp'],
				"cvv" => $quote_details['user']['cvv']
			);
			$user = array(
				"accountcode" => $accountcode,
				"name" => $quote_details['user']['firstname_billing'] . " " . $quote_details['user']['lastname_billing'],
				"company" => $quote_details['user']['companyname_billing'],
				"address1" => $quote_details['user']['address1_billing'],
				"city" => $quote_details['user']['city_billing'],
				"state" => $quote_details['user']['state_billing'],
				"country" => $quote_details['user']['country_billing'],
				"phone" => $quote_details['user']['phonenumber_billing'],
				"zip" => $quote_details['user']['postcode_billing']
			);

			$arr = array(
				"amount" => $total_total,
				"cardinfo" => $cardinfo,
				"user" => $user
			);
			$firstdata->setOrderValues($arr);

			codeLog("QB2:$quote_id - $auth_type : $total_total. [qb_fn->process_order]");

			if($quote_details['main']['txid'] == "3543720361")
			{
				codeLog("QB2:$quote_id - SKIPPED $auth_type : $total_total. [qb_fn->process_order]");
				$response_code = 1;
				$response_reason = "";
				$approval_code = "";
				$txid = "";
				$t = time();
			}
			else if($using_usbank)
			{
				require_once($MAIN_INCLUDE_PATH."classes/class.usbank.php");
				$usbank = new usbank();
				
			}
			else
			{
				$result = $paymentmethod == "linkpoint" ? $firstdata->dingit() : $authnet->dingIt();

				$response_code = $result[0];
				$response_reason = $result[3];
				$approval_code = $result[4];
				$txid = $result[6];
				$t = time();

				//log ALL transaction attempts						
				$verified = isset($customer) ? $customer->CCverified : 0;
				$hasTrunk = isset($customer) ? $customer->hasTrunk : 0;
				$arr = array(
					"accountcode" => $accountcode,
					"cardtype" => $quote_details['user']['cardtype'],
					"cardnum" => $quote_details['user']['cardnumber'],
					"exp" => $quote_details['user']['exp'],
					"cvv" => $quote_details['user']['cvv'],
					"authtype" => $auth_type,
					"amount" => $total_total,
					"verified" => $verified,
					"when" => $t,
					"result" => $response_code,
					"resultreason" => $response_reason,
					"txid" => $txid,
					"purchased" => "Quote purchase :{$quote_id}",
					"page" => "quotebuilder",
					"hasTrunk" => $hasTrunk
				);
				require_once($MAIN_INCLUDE_PATH."functions/cclog.php");
				cclog($arr, "quotebuilder");
			}

			if($response_code != 1)
			{
				codeLog("QB2:$quote_id - auth failed. $response_reason. [qb_fn->process_order]");
	
				print "Error: We're sorry. We could not authorize these charges on your current credit card. The reason given is:<br>\"{$response_reason}\"";
				exit;
			}

			$cc_authed = $response_code == 1 ? 1 : 0;
			$tmp = array("cc_authed" => $cc_authed, "txid" => $txid);
			$quote->updateQuoteMain($tmp);
		}

		codeLog("QB2:$quote_id - auth success. txid:$txid [qb_fn->process_order]");

		if($isAdmin)
		{
			$arrLog = array(
				"time" => time(),
				"description" => "Processing Quote: $quote_id",
				"user" => $adminusername
			);
			logActivity($arrLog);
			codeLog("QB2:$quote_id - Admin user:$adminusername [qb_fn->process_order]");

			if($accountcode > 0)
			{
				$customer = new customer($accountcode);
				//check if a card exists
				if($customer->hasCC)
				{
					$query = "update voiplionweb.cardinfo set `verified` = 1 where `accountcode` = $accountcode";
					$result = $customer->general_UPDATE($query);
					if($result != "SUCCESS")
					{
						codeLog("QB2:$quote_id - FAILED to update cardinfo - accountcode:$accountcode. [result:$result]");
					}
				}
				else if(($paymentmethod == "authorize" || $paymentmethod == "linkpoint") && !$using_usbank)
				{
					$arr = array(
						"accountcode" => $accountcode,
						"cardnumber" => $quote_details['user']['cardnumber'],
						"cardtype" => $quote_details['user']['cardtype'],
						"exp" => $quote_details['user']['exp'],
						"cvv" => $quote_details['user']['cvv'],
						"verified" => 1
					);

					$result = $customer->general_INSERT($arr, "voiplionweb.cardinfo", "openser");

					if($result != "SUCCESS")
					{
						codeLog("QB2:$quote_id - FAILED to insert cardinfo - accountcode:$accountcode. [result:$result]");
					}

					//IMPORTANT! We need to make sure WHMCS has the CC stuff for NetPBX billing cron...what happens if we try to add the magic card?
					if($cardnumber != "beau5Diner")
					{
						$arrUpdateUser = array(
							"accountcode" => $accountcode,
							"cardtype" => $quote_details['user']['cardtype'],
							"cardnum" => $cardnumber,
							"expdate" => $quote_details['user']['exp'],
							"startdate" => $quote_details['user']['exp'],
							"issuenumber" => $quote_details['user']['cvv']
						);
						require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
						$whmcs = new whmcs();
						$result = $whmcs->updateClient($arrUpdateUser);
						$data = $whmcs->curlData;
						$data = explode(";",$data);
						$result = array();
						foreach($data AS $temp) 
						{
							$temp = explode("=",$temp);
							if(isset($temp[1]))
							{
								$result[$temp[0]] = $temp[1];
							}
						}
						if($result['result'] != "success")
						{
							//TODO: IMPORTANT! We need to make sure WHMCS has the CC stuff...NEED EMAIL NOTIFICATION
							codeLog("QB2:$quote_id - FAILED TO ADD/UPDATE CC IN WHMCS. [quotes/order.php]");
						}
					}
				}
				else if($paymentmethod == "mailin" && !$customer->hasACH && !$using_usbank)
				{
					$arrACHUser = array(
						"accountcode" => $accountcode,
						"checkaba" => $quote_details['user']['checkaba'],
						"checkaccount" => $quote_details['user']['checkaccount'],
						"account_holder_type" => $quote_details['user']['account_holder_type'],
						"account_type" => $quote_details['user']['account_type']
					);
					$result = !empty($quote_details['user']['checkaccount']) ? $quote->general_INSERT($arrACHUser, "voiplion_main.ach_users") : "";
				}
			}
			else if($accountcode == 0)
			{
				$customer = new customer();
				$arrUser = array(
					"email" => $quote_details['user']['email'],
					"password" => $quote_details['user']['password'],
					"firstname" => $quote_details['user']['firstname'],
					"lastname" => $quote_details['user']['lastname'],
					"companyname" => $quote_details['user']['companyname'],
					"address1" => $quote_details['user']['address1'],
					"address2" => $quote_details['user']['address2'],
					"city" => $quote_details['user']['city'],
					"state" => $quote_details['user']['state'],
					"postcode" => $quote_details['user']['postcode'],
					"country" => $quote_details['user']['country'],
					"phonenumber" => $quote_details['user']['phonenumber'],
					"ip" => $quote_details['user']['ip'],
					"host" => $quote_details['user']['host'],
					"firstname_billing" => $quote_details['user']['firstname_billing'],
					"lastname_billing" => $quote_details['user']['lastname_billing'],
					"companyname_billing" => $quote_details['user']['companyname_billing'],
					"address1_billing" => $quote_details['user']['address1_billing'],
					"address2_billing" => $quote_details['user']['address2_billing'],
					"city_billing" => $quote_details['user']['city_billing'],
					"state_billing" => $quote_details['user']['state_billing'],
					"postcode_billing" => $quote_details['user']['postcode_billing'],
					"country_billing" => $quote_details['user']['country_billing'],
					"phonenumber_billing" => $quote_details['user']['phonenumber_billing'],
					"firstname_shipping" => $quote_details['user']['firstname_shipping'],
					"lastname_shipping" => $quote_details['user']['lastname_shipping'],
					"companyname_shipping" => $quote_details['user']['companyname_shipping'],
					"address1_shipping" => $quote_details['user']['address1_shipping'],
					"address2_shipping" => $quote_details['user']['address2_shipping'],
					"city_shipping" => $quote_details['user']['city_shipping'],
					"state_shipping" => $quote_details['user']['state_shipping'],
					"postcode_shipping" => $quote_details['user']['postcode_shipping'],
					"country_shipping" => $quote_details['user']['country_shipping'],
					"phonenumber_shipping" => $quote_details['user']['phonenumber_shipping'],
					"cardnum" => $quote_details['user']['cardnumber'],
					"cardtype" => $quote_details['user']['cardtype'],
					"exp" => $quote_details['user']['exp'],
					"cvv" => $quote_details['user']['cvv'],
					"account_type" => $quote_details['user']['account_type'],
					"account_holder_type" => $quote_details['user']['account_holder_type'],
					"checkaba" => $quote_details['user']['checkaba'],
					"checkaccount" => $quote_details['user']['checkaccount'],
					"verified" => 1
				);
				codeLog("QB2:$quote_id - attempt to create new client. [qb_fn->process_order]");
				$result = $customer->createClient($arrUser);
				if($result == "SUCCESS")
				{
					$quote_details['user']['accountcode'] = $accountcode = $customer->accountcode;

					//Try to update quote.user...no biggie if it fails I guess
					$tmp = array(
						"userid" => $userid,
						"email" => $quote_details['user']['email'],
						"accountcode" => $accountcode,
						"isClient" => 1
					);
					$quote->updateUser($tmp);

					//look for ccs agent salesrep...if found, insert ccs_agent_accounts record
					$salesrep = $quote_details['user']['salesrep'];
					if(substr($salesrep, 0, 3) == "CCS")
					{
						$tmp = $quote->getCCSAgent($salesrep);
						$ccs_agent_id = isset($tmp['id']) ? $tmp['id'] : 0;
						$tmp = array(
							"ccs_agent_id" => $ccs_agent_id,
							"customer_accountcode" => $accountcode
						);
						$result = $quote->general_INSERT($tmp, "voiplion_main.ccs_agent_accounts");
						codeLog("QB2:$quote_id - Insert ccs_agent_accounts record. Agent:$salesrep, Client:$accountcode");
					}

					//IMPORTANT! We need to make sure WHMCS has the CC stuff for NetPBX billing cron...what happens if we try to add the magic card?
					if($cardnumber != "beau5Diner" && !empty($cardnumber))
					{
						$arrUpdateUser = array(
							"accountcode" => $accountcode,
							"cardtype" => $quote_details['user']['cardtype'],
							"cardnum" => $cardnumber,
							"expdate" => $quote_details['user']['exp'],
							"startdate" => $quote_details['user']['exp'],
							"issuenumber" => $quote_details['user']['cvv']
						);
						require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
						$whmcs = new whmcs();
						$result = $whmcs->updateClient($arrUpdateUser);
						$data = $whmcs->curlData;
						$data = explode(";",$data);
						$result = array();
						foreach($data AS $temp) 
						{
							$temp = explode("=",$temp);
							if(isset($temp[1]))
							{
								$result[$temp[0]] = $temp[1];
							}
						}
						if($result['result'] != "success")
						{
							//TODO: IMPORTANT! We need to make sure WHMCS has the CC stuff...NEED EMAIL NOTIFICATION
							codeLog("QB2:$quote_id - FAILED TO ADD/UPDATE CC IN WHMCS. [quotes/order.php]");
						}
					}

					if(!empty($checkaba))
					{
						$arrACHUser = array(
							"accountcode" => $accountcode,
							"checkaba" => $quote_details['user']['checkaba'],
							"checkaccount" => $quote_details['user']['checkaccount'],
							"account_holder_type" => $quote_details['user']['account_holder_type'],
							"account_type" => $quote_details['user']['account_type']
						);
						$result = $quote->general_INSERT($arrACHUser, "voiplion_main.ach_users");
					}

					if($using_usbank)
					{
						//insert a default record...if any 'netsip_options', will be updated below
						$arrUser = array("accountcode" => $accountcode);
						$result = $quote->general_INSERT($arrUser, "voiplion_main.autoreplenish");
					}
				}
				else
				{
					print $result;
					exit;
				}
			}
		}

		//we're gonna update sip acct info if user exists
		if($accountcode > 0)
		{
			require_once($ROOT_PATH."myaccount/classes/class.customer.php");
			$customer = new customer($accountcode);
			$existingClient = $customer->details_billing['signupwhen'] < mktime(0,0,0, date("m"), date("d"), date("Y")) ? 1 : 0;
			if(isset($quote_details['netsip_options']))
			{
				$arr = array(
					"is_notify" => $quote_details['netsip_options']['is_notify'],
					"notifyAmount" => $quote_details['netsip_options']['notifyamt'],
					"cancallintl" => $quote_details['netsip_options']['cancallintl']
				);
				if(!$existingClient)
				{
					if($using_usbank)
					{
						$result = $customer->updateUserInfo($arr, "billing");
					}
					else
					{
						//TODO: setting cancallintl in either case here DOES NOT set can_call_international in PG account table! Certainly not trunk settings!
						if($paymentmethod == "mailin")
						{
							$ach_notify = $quote_details['netsip_options']['is_notify'];
							$ach_notifyAmount = $quote_details['netsip_options']['notifyamt'];
							$ach_cancallintl = $quote_details['netsip_options']['cancallintl'];

							$query = "update voiplion_main.ach_users set `notify` = $ach_notify, `notifyAmount` = $ach_notifyAmount where `accountcode` = $accountcode";
							$result = $customer->general_UPDATE($query);

							$query = "update voiplionweb.userInfo set `cancallintl` = $ach_cancallintl where `accountcode` = $accountcode";
							$result = $customer->general_UPDATE($query);
						}
						else
						{
							$result = $customer->updateUserInfo($arr, "billing");
						}
					}
				}

				//we don't want to mess with existing values
				if(!$existingClient)
				{
					$autodebit = $quote_details['netsip_options']['autodebit'];

					//$replenishamount = isset($customer->details_cc['replenishamount']) && $customer->details_cc['replenishamount'] > 0 ? $customer->details_cc['replenishamount'] : $quote_details['netsip_options']['replenishamount'];
					//$replenishto = isset($customer->details_cc['replenishto']) && $customer->details_cc['replenishto'] > 0 ? $customer->details_cc['replenishto'] : $quote_details['netsip_options']['replenishto'];

					$replenishamount = $quote_details['netsip_options']['replenishamount'];
					$replenishto = $quote_details['netsip_options']['replenishto'];

					$arr = array(
						"autodebit" => $autodebit,
						"replenishamount" => $replenishamount,
						"replenishto" => $replenishto
					);

					if($using_usbank)
					{
						$query = "update voiplion_main.autoreplenish set `status` = $autodebit, `replenish_amount` = $replenishamount, `threshold` = $replenishto where `accountcode` = $accountcode";
						$result = $customer->general_UPDATE($query);
					}
					else
					{
						if($paymentmethod == "mailin")
						{
							$query = "update voiplion_main.ach_users set `autodebit` = $autodebit, `replenishamount` = $replenishamount, `replenishto` = $replenishto where `accountcode` = $accountcode";
							$result = $customer->general_UPDATE($query);
						}
						else
						{
							$result = $customer->netSIP_ccInfoUpdate($arr);
						}
					}
				}
			}

			//	...admin creates a quote AND processes the order
			//	we'll have a "PREAUTH" OR "AUTH_ONLY" and now need to capture

			//If using_usbank, will we be using any kind of "PREAUTH" OR "AUTH_ONLY"?

			if($isAdmin && ($auth_type == "PREAUTH" || $auth_type == "AUTH_ONLY" || $auth_type == "auth") && isset($txid) && $quote_details['main']['txid'] != "3457471697")
			{
				//added "auth" here but we may NOT be "authing" ach orders
				if($paymentmethod == "mailin")
				{
					$t = time();
					$details_ach = array(
						"checkaba" => $quote_details['user']['checkaba'],
						"checkaccount" => $quote_details['user']['checkaccount'],
						"account_holder_type" => $quote_details['user']['account_holder_type'],
						"account_type" => $quote_details['user']['account_type']
					);
					$details_billing = array(
						"accountcode" => $accountcode,
						"email" => $quote_details['user']['email'],
						"firstname" => $quote_details['user']['firstname_billing'],
						"lastname" => $quote_details['user']['lastname_billing'],
						"company" => $quote_details['user']['companyname_billing'],
						"address1" => $quote_details['user']['address1_billing'],
						"city" => $quote_details['user']['city_billing'],
						"state" => $quote_details['user']['state_billing'],
						"country" => $quote_details['user']['country_billing'],
						"phone" => $quote_details['user']['phonenumber_billing'],
						"zip" => $quote_details['user']['postcode_billing']
					);

					require_once($MAIN_INCLUDE_PATH."classes/class.ach.php");
					$ach = new ach();
					$auth_type = "capture";
					$ach->pg_transaction_type = $auth_type;
					//TODO: NEED A TXID??? WHICH???
					//$ach->pg_authorization_code = $quote_details['main']['txid'];
					//$ach->pg_trace_number = $quote_details['main']['txid'];
					$arr = array(
						"orderid" => $quote_id,
						"amount" => $total_total,
						"achinfo" => $details_ach,
						"user" => $details_billing
					);
					$ach->setOrderValues($arr);
					$result = $ach->dingit();

					$response_code = isset($result[0]) ? $result[0] : -1;
					$response_reason_code = isset($result[2]) ? $result[2] : -1;
					$response_reason = isset($result[3]) ? $result[3] : "";
					$approval_code = isset($result[4]) ? $result[4] : "";
					$auth_code = isset($result[5]) ? $result[5] : "";
					$txid = isset($result[6]) ? $result[6] : $t;

					if($response_code != 1)
					{
						codeLog("QB2:$quote_id - auth failed. $response_reason. [qb_fn->process_order]");
	
						print "Error: We're sorry. We could not authorize these charges on your ACH Direct Debit Account. The reason given is:<br>\"{$response_reason}\"";
						exit;
					}
				}
				else
				{
					$auth_type = $paymentmethod == "linkpoint" ? "POSTAUTH" : "PRIOR_AUTH_CAPTURE";

					$authnet->authnet_values['x_type'] = $auth_type;
					$authnet->authnet_values['x_trans_id'] = $txid;
					$authnet->authnet_values['x_card_num'] = $cardnumber;
					$authnet->authnet_values['x_exp_date'] = $quote_details['user']['exp'];
					$authnet->authnet_values['x_description'] = "Quote Purchase $quote_id";
					$authnet->authnet_values['x_amount'] = $total_total;
					$authnet->authnet_values['x_first_name'] = $quote_details['user']['firstname_billing'];
					$authnet->authnet_values['x_last_name'] = $quote_details['user']['lastname_billing'];
					$authnet->authnet_values['x_address'] = $quote_details['user']['address1_billing'];
					$authnet->authnet_values['x_city'] = $quote_details['user']['city_billing'];
					$authnet->authnet_values['x_state'] = $quote_details['user']['state_billing'];
					$authnet->authnet_values['x_zip'] = $quote_details['user']['postcode_billing'];
					$authnet->authnet_values['CustomerAccountCode'] = $accountcode;

					$firstdata->order_values["oid"] = $txid;
					$firstdata->ordertype = $auth_type;
					$cardinfo = array(
						"cardnumber" => $quote_details['user']['cardnumber'],
						"cardtype" => $cardtype,
						"exp" => $quote_details['user']['exp'],
						"cvv" => $quote_details['user']['cvv']
					);
					$user = array(
						"accountcode" => $accountcode,
						"name" => $quote_details['user']['firstname_billing'] . " " . $quote_details['user']['lastname_billing'],
						"company" => $quote_details['user']['companyname_billing'],
						"address1" => $quote_details['user']['address1_billing'],
						"city" => $quote_details['user']['city_billing'],
						"state" => $quote_details['user']['state_billing'],
						"country" => $quote_details['user']['country_billing'],
						"phone" => $quote_details['user']['phonenumber_billing'],
						"zip" => $quote_details['user']['postcode_billing']
					);
					$arr = array(
						"amount" => $total_total,
						"cardinfo" => $cardinfo,
						"user" => $user
					);
					$firstdata->setOrderValues($arr);

					$result = $paymentmethod == "linkpoint" ? $firstdata->dingit() : $authnet->dingIt();

					codeLog("QB2:$quote_id - $auth_type : $total_total. [qb_fn->process_order]");

					$response_code = $result[0];
					$response_reason = $result[3];
					$approval_code = $result[4];
					$txid = $result[6];
					$t = time();

					if($response_code != 1)
					{
						codeLog("QB2:$quote_id - auth failed. $response_reason. [qb_fn->process_order]");
	
						print "Error: We're sorry. We could not authorize these charges on your current credit card. The reason given is:<br>\"{$response_reason}\"";
						exit;
					}
					codeLog("QB2:$quote_id - auth success. txid:$txid [qb_fn->process_order]");

					//log ALL transaction attempts						
					$verified = isset($customer) ? $customer->CCverified : 0;
					$hasTrunk = isset($customer) ? $customer->hasTrunk : 0;
					$arr = array(
						"accountcode" => $accountcode,
						"cardtype" => $quote_details['user']['cardtype'],
						"cardnum" => $quote_details['user']['cardnumber'],
						"exp" => $quote_details['user']['exp'],
						"cvv" => $quote_details['user']['cvv'],
						"authtype" => $auth_type,
						"amount" => $total_total,
						"verified" => $verified,
						"when" => $t,
						"result" => $response_code,
						"resultreason" => $response_reason,
						"txid" => $txid,
						"purchased" => "Quote purchase :{$quote_id}",
						"page" => "quotebuilder",
						"hasTrunk" => $hasTrunk
					);
					require_once($MAIN_INCLUDE_PATH."functions/cclog.php");
					cclog($arr, "quotebuilder");
				}
			}

			//...and process everything if they are GOLDEN...NOTHING HERE ADDRESSES USING_USBANK!
			if($using_usbank || $customer->CCverified || ($customer->hasACH && $paymentmethod == "mailin") || (isset($quote_details['main']['is_paybycheck']) && $quote_details['main']['is_paybycheck'] == 1))
			{
				$ip = isset($quote_details['user']['ip']) && !empty($quote_details['user']['ip']) ? $quote_details['user']['ip'] : $_SERVER['REMOTE_ADDR'];
				$host = isset($quote_details['user']['host']) && !empty($quote_details['user']['host']) ? $quote_details['user']['host'] : gethostbyaddr("$ip");
				$arrUser = $customer->arrUser();
				$arrUser['quote_userid'] = $quote_details['user']['userid'];
				$arrUser['cardtype'] = $quote_details['user']['cardtype'];

				$store = new store($customer->details['email']);
				$arrUser['store_userid'] = $store->userid;

				$arrUser['companyname_shipping'] = $quote_details['user']['companyname_shipping'];
				$arrUser['firstname_shipping'] = $quote_details['user']['firstname_shipping'];
				$arrUser['lastname_shipping'] = $quote_details['user']['lastname_shipping'];
				$arrUser['address1_shipping'] = $quote_details['user']['address1_shipping'];
				$arrUser['address2_shipping'] = $quote_details['user']['address2_shipping'];
				$arrUser['city_shipping'] = $quote_details['user']['city_shipping'];
				$arrUser['state_shipping'] = $quote_details['user']['state_shipping'];
				$arrUser['postcode_shipping'] = $quote_details['user']['postcode_shipping'];
				$arrUser['country_shipping'] = $quote_details['user']['country_shipping'];
				$arrUser['phonenumber_shipping'] = $quote_details['user']['phonenumber_shipping'];

				//don't really care about this...for zencart crap only...SCRATCH THAT! Now we care because we will use this for refunds!
				$arrUser['visibleCardNum'] = $paymentmethod == "mailin" ? $quote_details['user']['checkaccount'] : $quote_details['user']['cardnumber'];
				$arrUser['exp'] = $quote_details['user']['exp'];
				$arrUser['cvv'] = $quote_details['user']['cvv'];


				$arrUser['approval_code'] = $approval_code;
				$arrUser['txid'] = $txid;
				$arrUser['ip'] = $ip;
				$arrUser['host'] = $host;

				$arrUser['user_comments'] = $quote_details['main']['comments'];

				$arrUser['isDev'] = isset($isDev) && $isDev ? 1 : 0; //added for sending order to NetX

				require_once($MAIN_INCLUDE_PATH."classes/class.order.php");
				$order = new order($arrUser);

				//put $quote_details into something order class will understand
				//01-08-2011...change paymentmethod to "authorize" from $quote_details['main']['paymentmethod']
				//2-24-2011...setting 'paymentmethod' above after adding ACH crap
				//9-20-2011...now also looking for pay by check
				$paymentmethod = isset($quote_details['main']['is_paybycheck']) && $quote_details['main']['is_paybycheck'] == 1 ? "PBC" : $paymentmethod;

				$arrQuote = array(
					"id" => $quote_id,
					"type" => $quote_details['main']['type'],
					"tax" => $quote_details['main']['tax'],
					"total" => $quote_details['main']['total'],
					"total_onetime" => $quote_details['main']['total_onetime'],
					"total_monthly" => $quote_details['main']['total_monthly'],
					"total_annually" => $quote_details['main']['total_annually'],
					"AccountBalance" => $quote_details['main']['AccountBalance'],
					"process_all" => $quote_details['main']['process_all'],
					"paymentmethod" => $paymentmethod
				);

				if(isset($quote_details['netpbx']))
				{
					$arrQuote['netpbx_purchase'] = $quote_details['netpbx'];

					//set delay_billing and delay_date here for order class
					if($delay_billing)
					{
						$arrQuote['netpbx_purchase']['delay_billing'] = 1;
						$arrQuote['netpbx_purchase']['delay_date'] = $delay_date;
					}
				}

				$arrQuote['netsip_purchase'] = array();
				if(isset($quote_details['netsip_options']))
				{
					$arrQuote['netsip_purchase']['options'] = $quote_details['netsip_options'];
				}
				if(isset($quote_details['netsip_packages']))
				{
					//need a trunk for each package
					for($i=0; $i < count($quote_details['netsip_packages']); $i++)
					{
						$trunk_identifier = $quote_details['netsip_packages'][$i]['name'];
						$quote_details['netsip_packages'][$i]['trunk'] = $customer->newTrunk(0,$trunk_identifier);
					}
					$arrQuote['netsip_purchase']['packages'] = $quote_details['netsip_packages'];
				}
				if(isset($quote_details['netsip_dids']))
				{
					$arrQuote['netsip_purchase']['dids'] = $quote_details['netsip_dids'];
				}

				if(count($arrQuote['netsip_purchase']) == 0)
				{
					unset($arrQuote['netsip_purchase']);
				}

				$arrQuote['store_purchase'] = array("cart" => array());
				if(isset($quote_details['store']))
				{
					foreach($quote_details['store'] as $key => $value)
					{
						if(is_numeric($key))
						{
							$tmp = array($value['products_id'], $value['products_qty'], "products_price" => $value['products_price'], "subtotal" => $value['subtotal']);
							array_push($arrQuote['store_purchase']['cart'], $tmp);
						}
						else if($key == "shipping")
						{
							$arrQuote['store_purchase']['shipping'] = $value[0];
						}
					}

					//pass ftp info to order class...
					$ftp_user = "";
					$ftp_pass = "";
					if(isset($_POST['ftp_info']))
					{
						$tmp = explode(":", $_POST['ftp_info']);
						$ftp_user = isset($tmp[0]) ? $tmp[0] : $ftp_user;
						$ftp_pass = isset($tmp[1]) ? $tmp[1] : $ftp_pass;
					}
					$arrQuote['store_purchase']['ftp_user'] = $ftp_user;
					$arrQuote['store_purchase']['ftp_pass'] = $ftp_pass;
				}

				//print_r($arrQuote);
				//exit;

				codeLog("QB2:$quote_id - order->orderQuote. [qb_fn->process_order]");

				$result = $order->orderQuote($arrQuote);
				if($result != "SUCCESS")
				{
					$tmp = array(
						"Where" => "QB2 Order qb_fn->process_order",
						"Quote ID" => $quote_id,
						"Result" => $result,
					);
					$error = new error();
					$error->arrError = $tmp;
					$error->logError();

					codeLog("QB2:$quote_id - order->orderQuote FAILED. [qb_fn->process_order]");

					print "We were unable to complete this order (#{$quote_id}-1000). Please contact VOIPLION.COM Customer Care.";
					exit;
				}
				codeLog("QB2:$quote_id - order->orderQuote SUCCESS. [qb_fn->process_order]");

				if($isAdmin)
				{
					$arrLog = array(
						"time" => time(),
						"description" => "Processed Quote: $quote_id successfully",
						"user" => $adminusername
					);
					$result = logActivity($arrLog);
				}

				if(isset($quote_details['netpbx']))
				{
					$orderid = $order->NetPBX_orderid;
					$arr = array("order_id" => $orderid);
					$quote->updateQuoteElement($arr, "quote_netpbx");

					$bluebox = $quote_details['netpbx']['bluebox'];

					$ctid = $orderid;
					while(strlen($ctid) < 5)
					{
						$ctid = "0".$ctid;
					}
					$ctid = $bluebox ? "56".$ctid : "16".$ctid;
					$account_dns = "npx{$ctid}.voiplion.net";
					$account_dns_flash = strtoupper($account_dns);

					if(substr_count($quote_details['netpbx']['product_name'], "Dedicated") == 0)
					{
						//emails here because we exit out
						//If this is a CCS Agent OR CCS Direct rep order, I don't think we need to send this
						//DO WE NEED TO SEND THIS AT ALL???
						if(substr($quote_id, 0, 1) == "Q")
						{
							//codeLog("QB2:$quote_id - Attempt emailOrderConfirmation send. [qb_fn->process_order]");
							//$quote->emailOrderConfirmation(); // this is "Thank you for placing an order with VOIPLION.COM...You will be receiving a follow-up email when your services have been provisioned."
						}

						//should we stop sending this?
						//codeLog("QB2:$quote_id - Attempt emailNewOrder_toAdmin send. [qb_fn->process_order]");
						//$quote->emailNewOrder_toAdmin();

						//NEW ORDER PROCESS - if init config, send TPS/config doc?
						/*
							Scenarios:
								Existing customer with init config...customer created quote
								Existing customer without init config...customer created quote

								Existing customer with init config...voiplion created quote
								Existing customer without init config...voiplion created quote
						*/
						$init_config = false;
						if(isset($quote_details['netpbx']['groupname']) && $quote_details['netpbx']['groupname'] == "NetPBX PRO Complete")
						{
							$init_config = true;
						}
						else if(isset($quote_details['netpbx']['addons']) && count($quote_details['netpbx']['addons']))
						{
							foreach($quote_details['netpbx']['addons'] as $addon)
							{
								if(substr_count($addon['name'], "Initial Configuration") > 0)
								{
									$init_config = true;
									break;
								}
							}
						}
						if($init_config && empty($quote_details['main']['purchase_date']))
						{
							$tps_id = $quote->setTPSID($quote_details);
							$quote_details['netpbx']['tps_id'] = $tps_id;

							$quote->emailTPS($quote_details);

							if(!$isDev)
							{
								require_once($ROOT_PATH."/support/integrationapi/lib/api.class.php");
								$CBS_KayakoAPI = new CBS_KayakoAPI();
								openMigrationTicket_local($quote_details);
							}
						}
						else
						{
							//ccs agent/direct rep orders already have a "purchase_date"...do not overwrite it
							$arr = empty($quote_details['main']['purchase_date']) ? array("purchase_date" => time(), "processed" => time()) : array("processed" => time());
							$quote->updateQuoteMain($arr);

							$product_name_flash = str_replace("NetPBX ", "", $quote_details['netpbx']['product_name']);
							print "SPINIT,0,$product_name_flash,$quote_id,$account_dns_flash,$isVoiplion";
							exit;
						}
					}
				}
				//ccs agent/direct rep orders already have a "purchase_date"...do not overwrite it
				$arr = empty($quote_details['main']['purchase_date']) ? array("purchase_date" => time(), "processed" => time()) : array("processed" => time());
				$quote->updateQuoteMain($arr);
				$quote_details = $quote->getQuote($quote_id,$userid);
			}
		}

		//TODO: Watch for using_usbank here! If using_usbank, we may want to assign a salesrep and have them submit order, thereby creating "Pending" WHMCS record, etc....

		if(empty($quote_details['main']['purchase_date']))
		{
			$init_config = false;
			if(isset($quote_details['netpbx']['groupname']) && $quote_details['netpbx']['groupname'] == "NetPBX PRO Complete")
			{
				$init_config = true;
			}
			else if(isset($quote_details['netpbx']['addons']) && count($quote_details['netpbx']['addons']))
			{
				foreach($quote_details['netpbx']['addons'] as $addon)
				{
					if(substr_count($addon['name'], "Initial Configuration") > 0)
					{
						$init_config = true;
						break;
					}
				}
			}
			if($init_config)
			{
				$tps_id = $quote->setTPSID($quote_details);
				$quote_details['netpbx']['tps_id'] = $tps_id;

				$quote->emailTPS($quote_details);

				if(!$isDev)
				{
					require_once($ROOT_PATH."/support/integrationapi/lib/api.class.php");
					$CBS_KayakoAPI = new CBS_KayakoAPI();
					openMigrationTicket_local($quote_details);
				}
			}
			else
			{
				codeLog("QB2:$quote_id - Attempt emailOrderConfirmation send. [qb_fn->process_order]");
				$quote->emailOrderConfirmation();

				codeLog("QB2:$quote_id - Attempt emailNewOrder_toAdmin send. [qb_fn->process_order]");
				$quote->emailNewOrder_toAdmin();
			}

			$arr = array("purchase_date" => time());
			$quote->updateQuoteMain($arr);
		}

		codeLog("QB2:$quote_id - Quote Ordered. [qb_fn->process_order]");

		print "processed";
		exit;

		//ZOHO...
		/*BYE BYE ZOHO
		$email = $quote_details['user']['email'];
		$name = $quote_details['user']['firstname']." ".$quote_details['user']['lastname'];
		$fname = $quote_details['user']['firstname'];
		$lname = $quote_details['user']['lastname'];
		require_once($MAIN_INCLUDE_PATH."classes/class.zoho.php");
		$zoho = new zoho();
		$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
		$headers .= "Return-Path: <sales@voiplion.com>\r\n";
		$eol = PHP_EOL;
		//come from lander?
		if(isset($_SESSION['zoho_record_id']) && isset($_SESSION['zoho_email']))
		{
			$zoho->action = "updateLeadStatus";
			$lead_status = "Converted to customer";
			$lead_priority = 0;
			$zoho->updateLeadStatus($_SESSION['zoho_record_id'], $lead_status, $lead_priority);
			if($zoho->arrResponse['response'] == "SUCCESS")
			{
				$zoho->action = "insertNote";
				$subject = "Ordered Quote Number {$quote_id}";
				$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
				$zoho->insertNote($_SESSION['zoho_record_id'], $subject, $note);
				if($zoho->arrResponse['response'] != "SUCCESS")
				{
					$subject = "FAILED Zoho New Note Attempt from QB2";
					$message = "Quote Number {$quote_id} $eol$eol ";
					$message .= "User: {$_SESSION['zoho_email']} $eol$eol ";
					$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
					@mail("sales@voiplion.com", $subject, $message, $headers);
				}
			}
			else
			{
				$subject = "FAILED Zoho Lead Update from QB2";
				$message = "Quote Number {$quote_id} $eol$eol ";
				$message .= "User: {$_SESSION['zoho_email']} $eol$eol ";
				$message .= "Lead Status: Converted to customer $eol$eol ";
				@mail("sales@voiplion.com", $subject, $message, $headers);
			}
		}
		else
		{
			$zoho->search_column = "email";
			$zoho->search_value = $email;
			$zoho->action = "getSearchRecordsByPDC";

			$result = $zoho->doAction();
			$zoho_response = isset($zoho->arrResponse['response']) ? $zoho->arrResponse['response'] : "";
			if($zoho_response == "SUCCESS")
			{
				$email_found = false;
				$row = 0;
				$leadid = 0;
				$email_zoho = "";
				if(isset($zoho->arrResponse['leads']) && count($zoho->arrResponse['leads']))
				{
					foreach($zoho->arrResponse['leads'] as $key => $value)
					{
						$row = $value['row'];
						$record_id = $value['leadid'];
						$email_zoho = $value['email'];
						if($email_zoho == $email)
						{
							$email_found = true;
							break;
						}
					}
				}
				if($email_found)
				{
					$zoho->action = "updateLeadStatus";
					$lead_status = "Converted to customer";
					$lead_priority = 0;
					$zoho->updateLeadStatus($record_id, $lead_status, $lead_priority);
					if($zoho->arrResponse['response'] != "SUCCESS")
					{
						$subject = "FAILED Zoho Lead Update from QB2";
						$message = "Quote Number {$quote_id} $eol$eol ";
						$message .= "User: {$email} $eol$eol ";
						$message .= "Lead Status: Converted to customer $eol$eol ";
						@mail("sales@voiplion.com", $subject, $message, $headers);
					}
					$zoho->action = "insertNote";
					$subject = "Ordered Quote Number {$quote_id}";
					$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
					$zoho->insertNote($record_id, $subject, $note);
					if($zoho->arrResponse['response'] != "SUCCESS")
					{
						$subject = "FAILED Zoho New Note Attempt from QB2";
						$message = "Quote Number {$quote_id} $eol$eol ";
						$message .= "User: {$email} $eol$eol ";
						$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
						@mail("sales@voiplion.com", $subject, $message, $headers);
					}
				}
			}
			else if($zoho_response == "NODATA")
			{
				$zoho->action = "insertRecords";
				$arr = array("name"=>$name, "fname"=>$fname, "lname"=>$lname, "email"=>$email);
				$zoho->insertRecord($arr);
				if($zoho->arrResponse['response'] == "SUCCESS")
				{
					$record_id = $zoho->arrResponse['record_id'];
					$zoho->action = "updateLeadStatus";
					$lead_status = "Converted to customer";
					$lead_priority = 0;
					$zoho->updateLeadStatus($record_id, $lead_status, $lead_priority);

					$zoho->action = "insertNote";
					$subject = "Ordered Quote Number {$quote_id}";
					$note = "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}";
					$zoho->insertNote($record_id, $subject, $note);
					if($zoho->arrResponse['response'] != "SUCCESS")
					{
						$subject = "FAILED Zoho New Note Attempt from QB2";
						$message = "Quote Number {$quote_id} $eol$eol ";
						$message .= "User: {$email} $eol$eol ";
						$message .= "Note: https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id} $eol$eol ";
						@mail("sales@voiplion.com", $subject, $message, $headers);
					}
				}
				else
				{
					$subject = "FAILED Zoho New Lead Attempt from QB2";
					$message = "Quote Number {$quote_id} $eol$eol ";
					$message .= "User: {$email} $eol$eol ";
					$message .= "Lead Status: Converted to customer $eol$eol ";
					@mail("sales@voiplion.com", $subject, $message, $headers);
				}
			}
		}
		*/
	break;

	case "processed":
		//include("order_processed.php");
		include("order_processed_new.php");
	break;

	case "cbey_processed":
		include("cbey_processed.php");
	break;

	case "process_propbx_test":
		sleep(30);
		$account_dns_flash = strtoupper("1601040.voiplion.net");
		$dialout = isset($_GET['dialout']) ? $_GET['dialout'] : "17703650412";
		$dc_flash = "West Coast";
		$ctid = "1601040";
		$selectedTrunk = "yuv48v";
		$hardware_node = "atlsm008.voiplion.net";
		unset($_SESSION['Quote']);
		print "pro_processed=1&account_dns=$account_dns_flash&dialout=$dialout&dc=$dc_flash&ctid=$ctid&hwnode=$hardware_node&trunk=$selectedTrunk&ready=yes";
	break;

	case "process_propbx":
		$completedActions = array();
		$errors = array();

		$registered = "<span class=sup>&reg;</span>"; 
		$showStopperText = "<!-- FAILED -->We're sorry.  There has been a problem in the automated provisioning your NetPBX PRO Server. ";
		$showStopperText .= "Don't worry, our engineers have already been alerted and are working on the issue. ";
		$showStopperText .= "You will receive an email as soon as your system spinup is complete. ";
		$showStopperText .= "We usually resolve these types of issues within 1-2 hours.<br><br>";
		$showStopperText .= "If you would still like to open a support ticket, you may do so by clicking on the Support tab above.<br><br>";

		$quote = new quote($quote_id);
		$arrQuote = $quote->getQuote($quote_id);
		$accountcode = $arrQuote['user']['accountcode'];

		//it amazes me that someone could screw this pooch! rep had somehow created TWO qb user records..identical except one had no email...that's the one that tried to process! SELECT * FROM voiplion_main.quote_user where `firstname` = 'Rokneddin';
		if($accountcode == 0)
		{
			print "<!-- FAILED -->Cannot continue without account number.";
			exit;
		}

		require_once($MYACCOUNT_PATH."classes/class.customer.php");
		$customer = new customer($accountcode);

		$orderid = $arrQuote['netpbx']['order_id'];

		$bluebox = $arrQuote['netpbx']['bluebox'] == 1 ? true : false; //JS needs to ONLY SEND East Coast DC
		$distro_spinup = $bluebox ? "blue" : "npx";

		require_once($MAIN_INCLUDE_PATH."classes/class.buddha.php");
		$buddha = new buddha();

		codeLog("QB2:$quote_id - Attempt to Provision new CT. Order#:$orderid [qb_fn->process_propbx]");
		if($orderid)
		{
			array_push($completedActions, "Attempt to Provision new CT. Accountcode: $accountcode.");
			array_push($completedActions, "Found order number $orderid.");

			//flash params
			$plan_name = str_replace("NetPBX ", "", $arrQuote['netpbx']['product_name']);
			$showtrunk = $arrQuote['netpbx']['groupname'] == "NetPBX PRO Complete" ? 1 : 0;
			if(!$showtrunk && (isset($arrQuote['netsip_packages']) || isset($arrQuote['netsip_dids'])))
			{
				$showtrunk = 1;
			}

			require_once($MAIN_INCLUDE_PATH."classes/class.whmcs.api.php");
			$whmcs = new whmcs();
			$order = $whmcs->getOrderItems($orderid);
			if(!isset($order['hosting']))
			{
				print $showStopperText;
				array_push($errors, "Could not getOrderItems with order number $orderid");
			}
			else
			{
				if($isDev)
				{
					//fake the rest of this and exit out!
					$product_name = $order['hosting']['name'];
					$distribution = $bluebox ? "NetPBX Pro" : "";
					$datacenter = $bluebox ? "Eastcoast US (Atlanta)" : "";
					$dc_flash = $bluebox ? "East Coast" : "";

					$ctid = $orderid;
					while(strlen($ctid) < 5)
					{
						$ctid = "0".$ctid;
					}
					$ctid = $bluebox ? "56".$ctid : "16".$ctid;
					array_push($completedActions, "CTID: $ctid.");

					$account_dns = "npx{$ctid}.voiplion.net";
					$account_dns_flash = strtoupper($account_dns);

					$hardware_node = "faked.voiplion.net";
					$selectedTrunk = "faked";

					//insert into account notes
					$logline = "<b><u>Provisioned FAKE ".$arrQuote['netpbx']['product_name']."</u></b><br>";
					if(count($completedActions))
					{
						foreach($completedActions as $key => $value)
						{
							$logline .= "$value<br>";
						}
					}
					if(count($errors))
					{
						$logline .= "ERRORS:<br>";
						foreach($errors as $key => $value)
						{
							$logline .= "$value<br>";
						}
					}
					$result = $customer->addAccountNote($logline);

					print "pro_processed=1&account_dns=$account_dns_flash&dc=$dc_flash&ctid=$ctid&hwnode=$hardware_node&trunk=$selectedTrunk&plan=$plan_name&showtrunk=$showtrunk&ready=yes&cbey=$isVoiplion";
					exit;
				}

				if($buddha->bigBuddhaRecordsExists($orderid))
				{
					print $showStopperText;
					array_push($errors, "Big Buddha record exists with order number $orderid");
				}
				else
				{
					$product_name = $order['hosting']['name'];
					$distribution = "";
					$datacenter = "";

					//WATCH THIS...If we ever spin a bluebox somewhere other than atlsm009...!!!

					$distribution = $bluebox ? "NetPBX Pro" : "";
					$datacenter = $bluebox ? "Eastcoast US (Atlanta)" : "";
					$dc_flash = $bluebox ? "East Coast" : "";

					if(!$bluebox)
					{
						foreach($order['hosting']['config'] as $key => $value)
						{
							switch(strtolower($value['config_type']))
							{
								case "system template":
								$distribution = $value['config_name'];
								break;
		
								case "choose your datacenter":
								$datacenter = $value['config_name'];
								$dc_flash = "East Coast";
								if(substr_count($datacenter, "West") > 0)
								{
									$dc_flash = "West Coast";
								}
								else if(substr_count($datacenter, "Midwest") > 0)
								{
									$dc_flash = "Midwest";
								}
								break;
							}
						}
					}

					require_once($ROOT_PATH."myaccount/includes/functions/_fn.php");
					$userPass = get_rand_id(8);
					$rootPass = get_rand_id(8);

					$arrIPs = $buddha->getAvailableIPs($distribution, $datacenter, 0);
					if(count($arrIPs) == 0)
					{
						print $showStopperText;
						array_push($errors, "No available IPs for $distribution/$datacenter. Order# $orderid");
						codeLog("CRAPPED OUT. No available IPs.");
					}
					else
					{
						//IMPORTANT! We need to discern which hwnode to use for load balancing
						$arrHWNodes = array();
						$arrCTcount = array();
						$hardware_node = "";
						$ip = "";

						//FOR NOW...only node where we can put blueballz is atlsm009.voiplion.net
						if($bluebox)
						{
							$arrIPs = array();
							require($MAIN_INCLUDE_PATH."config.php");
							$query = "SELECT `ip`, `hardware_node` from voiplion_main.little_buddha where `hardware_node` = 'atlsm009.voiplion.net' and `status` = 'Available'";
							$result = mysql_query($query);
							if(@mysql_num_rows($result))
							{
								$hardware_node = "atlsm009.voiplion.net";
								while($row = @mysql_fetch_assoc($result))
								{
									array_push($arrIPs, $row);
								}
							}
						}
						else
						{
							foreach($arrIPs as $key => $value)
							{
								if(!in_array($value['hardware_node'], $arrHWNodes))
								{
									array_push($arrHWNodes, $value['hardware_node']);
								}
							}

							codeLog("check running CT count for each hwnode (".count($arrHWNodes)." total)");

							require_once($MAIN_INCLUDE_PATH."vefunctions.php");
							foreach($arrHWNodes as $key => $value)
							{
								$hwnode = $value;
								if($hwnode != "ovzdev.voiplion.net")
								{
									//check running CT count for each hwnode
									$arr = array("hwnode" => $hwnode);
									$ct_count = vecontrol("nodecount", $arr);
									$tmp = array("count" => $ct_count, "hwnode" => $hwnode);
									array_push($arrCTcount, $tmp);
								}
							}
							asort($arrCTcount);
							foreach($arrCTcount as $key => $value)
							{
								if($value['count'] > 0)
								{
									$hardware_node = $value['hwnode'];
									break;
								}
							}

							codeLog("finished CT count.");
						}

						if(empty($hardware_node))
						{
							print $showStopperText;
							array_push($errors, "No available HWNodes for $distribution/$datacenter. Order# $orderid");
							codeLog("CRAPPED OUT. No available HWNodes for $distribution/$datacenter.");
						}
						else
						{
							foreach($arrIPs as $key => $value)
							{
								if($value['hardware_node'] == $hardware_node)
								{
									$ip = $value['ip'];

									//need to 'lock' this IP to prevent any other spinup from grabbing the same one...
									$arr = array(
										"ip" => $ip,
										"status" => "Unavailable"
									);
									$result = $buddha->updateLittleB_item($arr);
									if($result != "SUCCESS")
									{
										array_push($errors, "Unable to LOCK IP (set status to Unavailable) in Little Buddha for IP $ip");
									}

									break;
								}
							}

							$ctid = $orderid;
							while(strlen($ctid) < 5)
							{
								$ctid = "0".$ctid;
							}
							$ctid = $bluebox ? "56".$ctid : "16".$ctid;
							array_push($completedActions, "CTID: $ctid.");

							$account_dns = "npx{$ctid}.voiplion.net";
							$account_dns_flash = strtoupper($account_dns);
							$server = "";
							$user_account = "user77";
							$user_password = $userPass;
							$root_pass = $rootPass;
							$web_gui_url = $ip;
							$web_gui_user = "admin";
							$web_gui_pass = $userPass;
							$vzpp_url = $ip.":4643";
							$vzpp_user = "root";
							$vzpp_pass = $rootPass;

							//for dinosaur table
							$Account = $customer->netpbx_RecordCount() + 1;
							$AccountID = md5(uniqid(rand(), true));


							$arr = array(
								"OrderID" => $orderid,
								"Email" => $arrQuote['user']['email'],
								"ClientID" => $accountcode,
								"Account" => $Account,
								"AccountID" => $AccountID,
								"DNS" => $account_dns,
								"Server" => $server,
								"VPSNumber" => $ctid,
								"UserAccount" => $user_account,
								"UserPassword" => $user_password,
								"RootPass" => $root_pass,
								"WebGUIURL" => $web_gui_url,
								"WebGUIUser" => $web_gui_user,
								"WebGUIPass" => $web_gui_pass,
								"VZPPURL" => $vzpp_url,
								"VZPPUser" => $vzpp_user,
								"VZPPPass" => $vzpp_pass,
								"Product" => $product_name,
								"Distro" => $distribution,
								"datacenter" => $datacenter,
								"IP" => $ip
							);

							$result = $customer->general_INSERT($arr, "voiplion_main.client_accounts");
							if($result != "SUCCESS")
							{
								array_push($errors, "Error inserting new record into dinosaur table");
							}
							else
							{
								array_push($completedActions, "Added client_accounts record.");
							}

							$selectedTrunk = "";
							$selectedTrunkPass = "";
							$query_newtrunk = "";
							$err_newtrunk = "";

							$channels = explode(" ", $product_name);
							$channels = $channels[2];
							$channels_ve = ($channels * 2) + 1;

							//look for "NetPBX PRO" trunk
							/*
							$arrTrunks = $customer->netSIP_trunks();
							foreach($arrTrunks as $key => $value)
							{
								if($value['identifier'] == "NetPBX PRO")
								{
									$selectedTrunk = $value['username'];
									$selectedTrunkPass = $value['password'];
									break;
								}
							}
							*/
							$arrNewestTrunk = $customer->getNewestTrunk("NetPBX");
							if(count($arrNewestTrunk))
							{
								$selectedTrunk = $arrNewestTrunk['username'];
								$selectedTrunkPass = $arrNewestTrunk['password'];
							}

							if(empty($selectedTrunk) || empty($selectedTrunkPass))
							{
								$selectedTrunk = $customer->newTrunk(0, "NetPBX PRO");
								if(substr_count($selectedTrunk, "ERROR") == 0)
								{
									array_push($completedActions, "Created trunk [$selectedTrunk].");
									$tmp = $customer->getTrunkByUsername($selectedTrunk);
									$selectedTrunkPass = $tmp['password'];
								}
								else
								{
									$err_newtrunk = $selectedTrunk;
									$selectedTrunk = "";
								}
							}
							//still empty???
							if(empty($selectedTrunk) || empty($selectedTrunkPass))
							{
								print $showStopperText;
								array_push($errors, "Error creating new trunk. $err_newtrunk");

								//need to 'UNLOCK' this IP
								$arr = array(
									"ip" => $ip,
									"status" => "Available"
								);
								$result = $buddha->updateLittleB_item($arr);
								if($result != "SUCCESS")
								{
									array_push($errors, "Unable to UNLOCK IP (set status to Available) in Little Buddha for IP $ip");
								}
							}
							else
							{
								$callerid = !empty($customer->details_billing['address4']) ? $customer->details_billing['address4'] : "6178303300";
								$dialout = !empty($customer->details_billing['address3']) ? $customer->details_billing['address3'] : $customer->details['phonenumber'];
								$dialout = str_replace("-", "", $dialout);

								$first = str_replace(" ", "", $customer->details['firstname']);
								$first = str_replace("'", "", $first);
								$last = str_replace(" ", "", $customer->details['lastname']);
								$last = str_replace("'", "", $last);
								$arr = array(
									"ipaddr" => $ip,
									"ctid" => $ctid,
									"channels" => $channels_ve,
									"hwnode" => $hardware_node,
									"upass" => $web_gui_pass,
									"rpass" => $root_pass,
									"first" => $first,
									"last" => $last,
									"email" => str_replace(" ", "", $customer->details['email']),
									"callid" => $callerid,
									"trunk" => $selectedTrunk,
									"tpass" => $selectedTrunkPass,
									"dialout" => $dialout,
									"product" => 1
								);
								$this_arr = "";
								foreach($arr as $key => $value)
								{
									$this_arr .= "$key:$value, ";
								}

								codeLog("Spin up CT.");

								require_once($MAIN_INCLUDE_PATH."vefunctions.php");
								require_once($MAIN_INCLUDE_PATH."npxfunctions.php");
								//$result = npxcontrol("vzclone", $arr);

								//new API/Bluebox...
								$DBHOST = getdbhost($hardware_node);
								$APIHOST = getapihost($hardware_node);
								$arr = array(
									"form_id" => "ct",
									"NODE" => $hardware_node,
									"IP" => $ip,
									"CTID" => $ctid,
									"UPASS" => $web_gui_pass,
									"RPASS" => $root_pass,
									"NAME" => "$first $last",
									"EMAIL" => str_replace(" ", "", $customer->details['email']),
									"CHANNELS" => $channels_ve,
									"ITSP" => 0,
									"DC" => "ordcon",
									"DISTRO" => $distro_spinup,
									"DBHOST" => $DBHOST,
									"APIHOST" => $APIHOST,
									"DBPASSWD" => "Sg4gDf33Aw6afj7aAFASD",
									"ASTUSER" => "npxsupport",
						 			"ASTPASS" => "Supp0r71sg0od",
									"TRUNK" => $selectedTrunk,
									"TPASS" => $selectedTrunkPass,
									"CALLID" => $callerid
								);

								$result = npxcurl($arr);

								if($result != 1)
								{
									array_push($errors, "Unable to spin up! Result: $result. $this_arr");

									//need to 'UNLOCK' this IP
									$arr = array(
										"ip" => $ip,
										"status" => "Available"
									);
									$result = $buddha->updateLittleB_item($arr);
									if($result != "SUCCESS")
									{
										array_push($errors, "Unable to UNLOCK IP (set status to Available) in Little Buddha for IP $ip");
									}

									print $showStopperText;
								}
								else
								{
									array_push($completedActions, "Pro server spun up. Result: $result. $this_arr");
	
									//create DNS records
									$a_recordid = 0;
									$ptr_recordid = 0;

									require($MAIN_INCLUDE_PATH."classes/class.durabledns.php");
									$dns = new dns("createRecord");
									$dns->arrParams["name"] = "npx" . $ctid;
									$dns->arrParams["type"] = "A";
									$dns->arrParams["data"] = $ip;
									$dns->arrParams["aux"] = "";
									$dns->arrParams["ttl"] = 86400;
									$dns->callIt();
									if(is_numeric($dns->result))
									{
										$a_recordid = $dns->result;
										array_push($completedActions, "Created DNS A record $a_recordid.");
									}
									else
									{
										array_push($errors, "Error creating DNS A record. ".$dns->result);
									}

									$base_ip = explode(".", $ip);
									$base_ip = $base_ip[3].".".$base_ip[2];
	
									$dns = new dns("createRecord");
									$dns->arrParams["zonename"] = $dns->ptr_zone;
									$dns->arrParams["name"] = $base_ip;
									$dns->arrParams["type"] = "PTR";
									$dns->arrParams["data"] = "npx" . $ctid . ".".$dns->zone;
									$dns->arrParams["aux"] = "";
									$dns->arrParams["ttl"] = 86400;
									$dns->callIt();
									if(is_numeric($dns->result))
									{
										$ptr_recordid = $dns->result;
										array_push($completedActions, "Created DNS PTR record $ptr_recordid.");
									}
									else
									{
										array_push($errors, "Error creating DNS PTR record. ".$dns->result);
									}
									$arr = array(
										"order_number" => $orderid,
										"accountcode" => $accountcode,
										"dns_name" => $account_dns,
										"ctid" => $ctid,
										"hardware_node" => $hardware_node,
										"user_account" => $user_account,
										"user_pass" => $user_password,
										"root_pass" => $root_pass,
										"webgui_url" => $web_gui_url,
										"webgui_user" => $web_gui_user,
										"webgui_pass" => $web_gui_pass,
										"vzpp_url" => $vzpp_url,
										"vzpp_user" => $vzpp_user,
										"vzpp_pass" => $vzpp_pass,
										"product" => $product_name,
										"a_recordid" => $a_recordid,
										"ptr_recordid" => $ptr_recordid,
										"ip" => $ip
									);

									$result = $buddha->addBigB_item($arr);
									if($result != "SUCCESS")
									{
										array_push($errors, "Unable to add new Big Buddha record. $result");
									}
									else
									{
										array_push($completedActions, "Created Big Buddha record.");
										$result = $buddha->archiveBigB_item($ip, "initial");
										if($result != "SUCCESS")
										{
											array_push($errors, "ERROR inserting Big Buddha Archive record: $result");
										}
									}

									//Go back to Little Buddha...add order number and mark as not available (and set hardware_node?)
									$arr = array(
										"ip" => $ip,
										"status" => "Unavailable",
										"order_number" => $orderid
									);
									$result = $buddha->updateLittleB_item($arr);
									if($result != "SUCCESS")
									{
										array_push($errors, "Unable to set status to Unavailable in Little Buddha for IP $ip");
									}

									require($MAIN_INCLUDE_PATH."config.php");//in case we're not connected

									//set whmcs.clients record to Active
									$query = "update voiplion_whmcs.tblclients set `status` = 'Active' where `id` = $accountcode";
									$result = mysql_query($query);
									$err = mysql_error();
									if(!empty($err))
									{
										array_push($errors, "ERROR updating WHMCS Client record: $err. $query");
									}
									else
									{
										array_push($completedActions, "Update WHMCS Client record to Active.");
									}

									//set whmcs.hosting record to Active
									$query = "update voiplion_whmcs.tblhosting set `domainstatus` = 'Active' where `orderid` = $orderid";
									$result = mysql_query($query);
									$err = mysql_error();
									if(!empty($err))
									{
										array_push($errors, "ERROR updating WHMCS Hosting record: $err. $query");
									}
									else
									{
										array_push($completedActions, "Update WHMCS Hosting record to Active.");
									}

									//set whmcs.orders record to Active
									$query = "update voiplion_whmcs.tblorders set `status` = 'Active' where `id` = $orderid";
									$result = mysql_query($query);
									$err = mysql_error();
									if(!empty($err))
									{
										array_push($errors, "ERROR updating WHMCS Orders record: $err. $query");
									}
									else
									{
										array_push($completedActions, "Update WHMCS Orders record to Active.");
									}

									//Send emails here
									$name = $customer->details['firstname'] . " " . $customer->details['lastname'];
									$email = $customer->details['email'];

									$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
									$headers .= "Return-Path: <sales@voiplion.com>\r\n";
									$subject = "VOIPLION.COM NetPBX PRO Server Now Active";
									$to = "$name <$email>";

									//for body...if "A" quote, use different body content
									if(substr($quote_id, 0, 1) == "A")
									{
										$tech_name = "";
										$tech_email = "";
										if(!empty($arrQuote['user']['tech_contact_email']))
										{
											$tech_name = $arrQuote['user']['tech_contact_name'];
											$tech_email = $arrQuote['user']['tech_contact_email'];
										}
										require($MAIN_INCLUDE_PATH."email_to_customer_agent.php");
									}
									else
									{
										require($MAIN_INCLUDE_PATH."email_provisioned_pro_verified.php");
									}

									if(@mail($to, $subject, $body, $headers))
									{
										@mail("mnm@voiplion.com", $subject, $body, $headers);
										//@mail("dave@voiplion.com", $subject, $body, $headers);
										array_push($completedActions, "Provisioned email sent.");
									}
									else
									{
										array_push($errors, "ERROR sending Provisioned email.");
									}


									if(substr($quote_id, 0, 1) == "A")
									{
										//look for technical contact name/email
										if(!empty($arrQuote['user']['tech_contact_email']))
										{
											$tech_name = $arrQuote['user']['tech_contact_name'];
											$tech_email = $arrQuote['user']['tech_contact_email'];
											$tech_code = $arrQuote['user']['tech_contact_code'];
											$to_tech = "$tech_name <$tech_email>";
											$subject = "VOIPLION.COM NetPBX PRO Server Now Active";
											require($MAIN_INCLUDE_PATH."email_to_tech_contact_agent.php");
											if(@mail($to_tech, $subject, $body, $headers))
											{
												array_push($completedActions, "Email sent to tech contact. [$tech_name] [$tech_email]");
											}
											else
											{
												array_push($errors, "ERROR sending email to tech contact. [$tech_name] [$tech_email]");
											}
										}
									}


									$logline = "<b><u>Provisioned New ".$arrQuote['netpbx']['product_name']."</u></b><br>";
									if(count($completedActions))
									{
										foreach($completedActions as $key => $value)
										{
											$logline .= "$value<br>";
										}
									}
									if(count($errors))
									{
										$logline .= "ERRORS:<br>";
										foreach($errors as $key => $value)
										{
											$logline .= "$value<br>";
										}
									}

									//If init config ordered, send config email
									$NetPBXComplete = $arrQuote['netpbx']['groupname'] == "NetPBX PRO Complete" ? 1 : 0;
									$initConfig = false;
									if(isset($arrQuote['netpbx']['groupname']) && $arrQuote['netpbx']['groupname'] == "NetPBX PRO Complete")
									{
										$init_config = true;
									}
									else if(isset($arrQuote['netpbx']['addons']) && count($arrQuote['netpbx']['addons']))
									{
										foreach($arrQuote['netpbx']['addons'] as $addon)
										{
											if(substr_count($addon['name'], "Initial Configuration") > 0)
											{
												$init_config = true;
												break;
											}
										}
									}

									//QUESTION: If init config cannot be selected in CCS Agent orders, 

									/*TODO: NEW ORDER PROCESS - 
										first of all, WHY DO THIS HERE? PBX IS ALREADY SPUN UP!
										secondly, if we intercept init config for existing client spinups, they already have this (OR TPS email)

									if($initConfig && substr($quote_id, 0, 1) != "A")
									{
										$separator = md5(time());
										$eol = PHP_EOL;
										$path = $ROOT_PATH."support/docs/";
										$filename = "PBXConfigInfoForm4.doc";
										$fileatt = $path.$filename; // Path to the file 
										$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
										$file = fopen($fileatt,'rb'); 
										$data = fread($file,filesize($fileatt)); 
										fclose($file); 

										$data = chunk_split(base64_encode($data)); 

										include($MAIN_INCLUDE_PATH."email_configuration.php");

										$headers = "From: VOIPLION.COM <pbxconfig@voiplion.com>\r\n";
										$headers .= "Return-Path: <pbxconfig@voiplion.com>\r\n";

										$headers .= "MIME-Version: 1.0".$eol;
										$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
										$headers .= "Content-Transfer-Encoding: 7bit".$eol;
										$headers .= "This is a MIME encoded message.".$eol.$eol;
										// message
										$headers .= "--".$separator.$eol;
										$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
										$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
										$headers .= $body.$eol.$eol;
										// attachment
										$headers .= "--".$separator.$eol;
										$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
										$headers .= "Content-Transfer-Encoding: base64".$eol;
										$headers .= "Content-Disposition: attachment".$eol.$eol;
										$headers .= $data.$eol.$eol;
										$headers .= "--".$separator."--";

										$subject = "VOIPLION.COM PBX Configuration - Reply Needed";

										$to = "$name <$email>";
										if(@mail($to, $subject, $body, $headers))
										{
											//@mail("dave@voiplion.com", $subject, $body, $headers);
										}
									}
									*/

									//insert into account notes
									$result = $customer->addAccountNote($logline);

									print "pro_processed=1&account_dns=$account_dns_flash&dc=$dc_flash&ctid=$ctid&hwnode=$hardware_node&trunk=$selectedTrunk&plan=$plan_name&showtrunk=$showtrunk&ready=yes&cbey=$isVoiplion";
								}
							}
						}
					}
				}
			}
		}
		else
		{
			codeLog("QB2:$quote_id - NO ORDER NUMBER...WHAT???. [qb_fn->process_propbx]");
			print "Could not get Order Number";
			exit;
		}

		//compile an email listing all actions (and errors)
		$emailSubject  = "New NetPBX Pro Provisioning Report";
		$sendit = 0;
		$body = "";
		if(count($completedActions))
		{
			//$sendit = 1;
			$body .= "Completed Actions:\n";
			foreach($completedActions as $key => $value)
			{
				$body .= "$value\n";
			}
		}
		if(count($errors))
		{
			$emailSubject  = "New NetPBX Pro Provisioning Report - FAILURE";
			$sendit = 1;
			$body .= "ERRORS:\n";
			foreach($errors as $key => $value)
			{
				$body .= "$value\n";
			}
			$body .= "\n";
		}

		if($sendit)
		{
			$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
			$headers .= "Return-Path: <sales@voiplion.com>\r\n";
			$to = "speak@voiplion.com";
			//$to = "dave@voiplion.com";
			@mail($to, $emailSubject, $body, $headers);
		}
	break;

	case "validate_promo":
		$quote_details = $quote->getQuote($quote_id,$userid);
		$promo_code = $_GET['promo_code'];
		$productid = $quote_details['netpbx']['productid'];
		$products = new products();
		$arrPromotions = $products->netpbxPromotions();

		$code_found = 0;
		$code_valid = 0;
		$code_expired = 0;

		$promo_table = "<table width=\"100%\" cellspacing=\"0\" border=0 style=\"padding-top:10px;\">\n";

		foreach($arrPromotions as $key => $value)
		{
			if(strtoupper($value['code']) == strtoupper($promo_code))
			{
				$code_found = 1;
			
				//HACK!!! Production has a different version of WHMCS!
				if($_SERVER['SERVER_NAME'] == "dev.voiplion.com" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1")
				{
					//$packages = explode(",", $value['packages']);	//OLD VERSION WHMCS
					$packages = explode(",", $value['appliesto']);	//NEW VERSION WHMCS
				}
				else
				{
					$packages = explode(",", $value['appliesto']);	//NEW VERSION WHMCS
				}

				if(in_array($productid, $packages))
				{
					$expiry = $value['expirationdate'] != "0000-00-00" ? strtotime($value['expirationdate']) : 0;
					$t = time();

					if($t > $expiry && $expiry != 0)
					{
						$code_expired = 1;
					}
					else
					{
						$code_valid = 1;
						//$_SESSION['Quote']['netpbx_purchase']['promo_code'] = $value['code'];//$promo_code;

						//HACK!!! Production has a different version of WHMCS!
						if($_SERVER['SERVER_NAME'] == "dev.voiplion.com" || $_SERVER['REMOTE_ADDR'] == "127.0.0.1")
						{
							//$discount_freq = $quote_details['netpbx']['discount_freq'] = $value['type']; //One Time or Recurring
							//$discount_type = $quote_details['netpbx']['discount_type'] = $value['discount']; //Percentage or Money Value

							$discount_freq = $quote_details['netpbx']['discount_freq'] = str_replace(",", "", $value['cycles']); //One Time or Recurring
							$discount_type = $quote_details['netpbx']['discount_type'] = $value['type']; //Fixed Amount or Percentage
						}
						else{
							$discount_freq = $quote_details['netpbx']['discount_freq'] = str_replace(",", "", $value['cycles']); //One Time or Recurring
							$discount_type = $quote_details['netpbx']['discount_type'] = $value['type']; //Fixed Amount or Percentage
						}
						$discount_value = $quote_details['netpbx']['discount_value'] = $value['value'];
						$arr = array("promo_code" => $promo_code, "discount_freq" => "$discount_freq", "discount_type" => "$discount_type", "discount_value" => "$discount_value");
						$quote->updateQuoteElement($arr, "quote_netpbx");
					}
				}
				break;
			}
		}

		if(!$code_found)
		{
			$arr = array("promo_code" => "", "discount_freq" => "", "discount_type" => "", "discount_value" => "");
			$quote->updateQuoteElement($arr, "quote_netpbx");

			//if(isset($quote_details['netpbx']['promo_code'])) unset($quote_details['netpbx']['promo_code']);
			//if(isset($quote_details['netpbx']['discount_freq'])) unset($quote_details['netpbx']['discount_freq']);
			//if(isset($quote_details['netpbx']['discount_type'])) unset($quote_details['netpbx']['discount_type']);
			//if(isset($quote_details['netpbx']['discount_value'])) unset($quote_details['netpbx']['discount_value']);

			$promo_table .= "<tr><td class=alertsmall align=center>That promotion code was not found</td></tr>\n";
			$promo_table .= "<tr><td class=listTextBold align=center>Promotional Code: <input type=text id=promo_code class=formElement style=\"width:80px;\" onKeyPress=\"return submitenter_qb('promo',event)\"> &nbsp;&nbsp;&nbsp;";
			$promo_table .= "<input type=button value=\" Validate Code &raquo; \" onclick=\"validatePromo()\">";
			$promo_table .= "</td></tr>\n";
		}
		else if($code_found && !$code_valid)
		{
			$arr = array("promo_code" => "", "discount_freq" => "", "discount_type" => "", "discount_value" => "");
			$quote->updateQuoteElement($arr, "quote_netpbx");

			//if(isset($quote_details['netpbx']['promo_code'])) unset($quote_details['netpbx']['promo_code']);
			//if(isset($quote_details['netpbx']['discount_freq'])) unset($quote_details['netpbx']['discount_freq']);
			//if(isset($quote_details['netpbx']['discount_type'])) unset($quote_details['netpbx']['discount_type']);
			//if(isset($quote_details['netpbx']['discount_value'])) unset($quote_details['netpbx']['discount_value']);

			if($code_expired)
			{
				$promo_table .= "<tr><td class=alertsmall align=center>That promotional code has expired.</td></tr>\n";
			}
			else
			{
				$promo_table .= "<tr><td class=alertsmall align=center>That promotional code is not valid for the selected service.</td></tr>\n";
			}
			$promo_table .= "<tr><td class=listTextBold align=center>Promotional Code: <input type=text id=promo_code class=formElement style=\"width:80px;\" onKeyPress=\"return submitenter_qb('promo',event)\"> &nbsp;&nbsp;&nbsp;<input type=button value=\" Validate Code &raquo; \"></td></tr>\n";
		}
		else if($code_found && $code_valid)
		{
			if($discount_type == "Fixed Amount" || $discount_type == "Money Value") //"Money Value" accounts for older version of WHMCS...JEEZ!!!
			{
				$promo_table .= "<tr><td class=listText align=center><b>Promotional Code:</b> $promo_code - \$$discount_value $discount_freq Discount";
				//$promo_table .= $orderScreen || $purchased ? "" : " - <span class=listText><a href=\"?step=quote&removepromo{$adminParam}\">Don't use Promotional Code</a></span></td></tr>\n";
				//$promo_table .= " - <span class=listText><a href=\"?step=review&removepromo{$adminParam}\">Don't use Promotional Code</a></span></td></tr>\n";
				$promo_table .= " - <span class=listText><a href=\"javascript:void(0)\" onclick=\"removePromo()\">Don't use Promotional Code</a></span></td></tr>\n";
			}
			else if($discount_type == "Percentage")
			{
				$discount_value = (int)$discount_value;
				$promo_table .= "<tr><td class=listText align=center><b>Promotional Code:</b> $promo_code - $discount_value Percent $discount_freq Discount";
				//$promo_table .= $orderScreen || $purchased ? "" : " - <span class=listText><a href=\"?step=quote&removepromo{$adminParam}\">Don't use Promotional Code</a></span></td></tr>\n";
				//$promo_table .= " - <span class=listText><a href=\"?step=review&removepromo{$adminParam}\">Don't use Promotional Code</a></span></td></tr>\n";
				$promo_table .= " - <span class=listText><a href=\"javascript:void(0)\" onclick=\"removePromo()\">Don't use Promotional Code</a></span></td></tr>\n";
			}

			$productLabel = $promo_code == "ACHA8239" ? "NetPBX8" : "NetPBX4";
			$tmp = array("ACHA4267", "ACHA9636", "ACHA7632", "ACHA7548", "ACHA2987", "ACHA3784", "ACHA5648", "ACHA8239", "ACHA6397", "ACHA2384");
			if(in_array($promo_code, $tmp))
			{
				$promo_table .= "<tr><td class=listTextBold style=\"padding-top:5px;\">As part of the enrollment process for the 30 day $productLabel Free Trial, you will be required to submit a valid credit card. \n";
				$promo_table .= "A small $1.00 amount will be authorized on your card for verification, and then subsequently voided.  \n";
				$promo_table .= "If you do not cancel your account prior to the 30 day period, you will be billed $".$quote_details['netpbx']['price']." per month for the subscription to $productLabel service. <a href=\"{$protocol}://{$DNS}/trial.php\" target=\"_blank\">Click here</a> for full terms and conditions of this offer.</td></tr>\n";
			}				
		}

		$promo_table .= "</table>\n";

		updateMain();

		if($code_found && $code_valid)
		{
			print "gotoq";
		}
		else
		{
			print $promo_table;
		}
	break;

	case "remove_promo":
		$arr = array("promo_code" => "", "discount_freq" => "", "discount_type" => "", "discount_value" => "");
		$quote->updateQuoteElement($arr, "quote_netpbx");
		updateMain();
		print "gotoq";
	break;

	case "netsip_credit":
		$quote_id = isset($_GET['qid']) ? $_GET['qid'] : 0;
		$amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
		$note = isset($_POST['note']) ? $_POST['note'] : "";
		$arr = array(
			"quote_id" => $quote_id,
			"amount" => $amount,
			"note" => $note
		);
		$result = $quote->general_INSERT($arr, "voiplion_main.quote_netsip_credit");
		if($result == "SUCCESS")
		{
			updateMain();
			print "go";
		}
		else
		{
			print $result;
		}
	break;

	case "netsip_credit_modify":
		$quote_id = isset($_GET['qid']) ? $_GET['qid'] : 0;
		$idx = isset($_GET['idx']) ? $_GET['idx'] : 0;
		$amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
		$note = isset($_POST['note']) ? $_POST['note'] : "";
		switch($_GET['a'])
		{
			case "modify":
			$arr = array(
				"idx" => $idx,
				"amount" => $amount,
				"note" => $note
			);
			$result = $quote->updateQuoteElement($arr, "quote_netsip_credit");
			if($result == "SUCCESS")
			{
				$arrLog = array(
					"time" => time(),
					"description" => "Quote# $quote_id NetSIP Credit, amount:$amount, note:$note",
					"user" => $adminusername
				);
				$result = logActivity($arrLog);

				updateMain();
				print "go";
			}
			else
			{
				print $result;
			}
		break;

		case "delete":
			$result = $quote->deleteNetSIPCredit($quote_id, $idx);
			if($result == "SUCCESS")
			{
				$arrLog = array(
					"time" => time(),
					"description" => "Quote# $quote_id NetSIP Credit Removed, amount:$amount, note:$note",
					"user" => $adminusername
				);
				$result = logActivity($arrLog);

				updateMain();

				print "go";
			}
			else
			{
				print $result;
			}
		break;

		default:
		print "Unknown action";
	}
	break;

	case "store_modify_quote":
		//TODO: refactor so that quote_details['store']['shipping'] goes away since quantities may change here...Also quote_details['main']['tax'] has to change?
		$err = "";
		$items = array();
		$logDescription = "";
		foreach($_POST as $key => $value)
		{
			if($key == "item")
			{
				foreach($_POST['item'] as $k => $v)
				{
					$tmp = explode("_", $v);
					$subtotal = $tmp[1] * $tmp[2];
					$tmp2 = array(
						"products_id" => $tmp[0],
						"products_qty" => $tmp[1],
						"products_price" => $tmp[2],
						"subtotal" => $subtotal
					);
					$logDescription .= "<br>ITEM: pid- ".$tmp[0].", qty- ". $tmp[1].", price- ".$tmp[2];
					array_push($items, $tmp2);
					$result = $quote->updateStoreItem($tmp2, "quote_store");
					if($result != "SUCCESS")
					{
						$err .= $result;
					}
				}
			}
		}
		if(empty($err))
		{
			$arrLog = array(
				"time" => time(),
				"description" => "Quote# $quote_id Store item(s) modified. $logDescription",
				"user" => $adminusername
			);
			$result = logActivity($arrLog);

			updateMain();
			print "go";
		}
		else
		{
			print $err;
		}
	break;

	case "run_maxmind":
		$quote_details = $quote->getQuote($quote_id,$userid);
		
		$tmp = explode("@", $quote_details['user']['email']);
		$domain = $tmp[1];
		// Area-code and local prefix of customer phone number
		$custPhone = str_replace(" ", "", $quote_details['user']['phonenumber']);
		$custPhone = str_replace("-", "", $custPhone);
		$custPhone = str_replace("/", "", $custPhone);
		if(substr($custPhone, 0, 1) == "1")
		{
			$custPhone = substr($custPhone, 1, strlen($custPhone));
		}
		$npa = substr($custPhone, 0, 3);
		$nxx = substr($custPhone, 3, 3);
		$custPhone = $npa ."-".$nxx;

		require_once($MAIN_INCLUDE_PATH."functions/creditcard.php");
		$cyph = explode("|", $quote_details['user']['cardnumber']);
		$cardnum = easy_decrypt($cyph);
		$bin = substr($cardnum, 0, 6);

		$arrMM = array(
			"i" => $quote_details['user']['ip'],
			"city" => $quote_details['user']['city_billing'],
			"region" => $quote_details['user']['state_billing'],
			"postal" => $quote_details['user']['postcode_billing'],
			"country" => $quote_details['user']['country_billing'],
			"domain" => $domain,
			"emailMD5" => $quote_details['user']['email'],
			"custPhone" => $custPhone,
			"shipAddr" => $quote_details['user']['address1'],
			"shipCity" => $quote_details['user']['city'],
			"shipRegion" => $quote_details['user']['state'],
			"shipPostal" => $quote_details['user']['postcode'],
			"shipCountry" => $quote_details['user']['country']
		);
		if($cardnum != "beau5Diner")
		{
			$arrMM['bin'] = $bin;
		}

		//codeLog("Running Maxmind from admin2...process quote");

		require($MAIN_INCLUDE_PATH."maxmind/maxmind.php");

		//update quote_main with fraudoutput
		$arr = array("fraudoutput" => addslashes($strMM));
		$result = $quote->updateQuoteMain($arr);
		if($result == "SUCCESS")
		{
			$quote_details['main']['fraudoutput'] = $strMM;
			$fraudoutput = str_replace("\n", "<br>", $strMM);
			print "<blockquote>$fraudoutput</blockquote>";
		}
		else
		{
			print "Error: $result";
		}
		
	break;

	case "whatsthis":
		$name = $_GET['name'];
		$pbxConfig = <<<EOF
			<div style="text-align:left;">
				<div style="float:left; width:auto; padding:8px;">
				<div class="pageTitle">PBX Initial Configuration</div>
					<p class="longp" align=justify>
						Configuration of your NetPBX<span style="font-size:80%; position:relative; top:-4px;">&reg;</span> is simple and easy with our Initial Configuration option.  
						Whether you're an expert Asterisk PBX user or not, we can save you time and money with this option.  
						You just fill out our form and we do the rest.  You'll end up with a provisioned PBX customized just for your business.  
					</p>
					<p class="longp">
						We provide the following initial setup for your NetPBX when you buy our Initial Configuration option:
					</p>
					<ul>
					<li>SIP Trunk setup
					<li>DID Routing setup
					<li>Extension provisioning
					<li>Voice Mail to Email setup
					<li>Follow Me setup
					<li>IVR setup (single level)
					<li>Ring Group setup
					<li>Conference setup
					</ul><br>
					<p class="longp">
						Still need more customization or need to make changes in the future?  Just contact us at 1-800-777-5555 and we'll work with you to provide the solution you need for your business.
					</p>
				</div>
			</div><br clear="all">
EOF;
		$ping = <<<EOF
			<div style="text-align:left;">
				<div style="float:left; width:auto; padding:8px;">
				<div class="pageTitle">Ping Test</div>
					<p class="longp">
						To check the latency from your location to our servers, please ping/traceroute the following servers:<br><br>
						Eastcoast US (Atlanta) - pingeast.voiplion.net<br><br>
						Westcoast US (Las Vegas) - pingwest.voiplion.net<br><br>
						Midwest US (Louisville) - pingmidwest.voiplion.net
					</p>
				</div>
			</div><br clear="all">
EOF;
		$channels = <<<EOF
			<div style="text-align:left;">
				<div style="float:left; width:auto; padding:8px;">
				<div class="pageTitle">Number of Channels</div>
					<p class="longp" align=justify>
						The number of 'channels' for your system, also referred to as the number of lines, trunks, simultaneous calls, 
						is the maximum number of active calls that can be placed through your system at any one time.  It includes non trunked, 
						extension-to-extension calls.  For example, a call from an extension to the PSTN over a SIP trunk is counted as '1 channel'.  
						An extension to extension call is counted as '1 channel'.  An inbound call from a PSTN SIP trunk into an IVR or call queue, 
						voicemail or conference bridge is counted as '1/2 a channel'.  8 people internal or external on a conference bridge will be 
						counted as '4 channels'. 
					</p>
				</div>
			</div><br clear="all">
EOF;
		$high_availability = <<<EOF
			<div style="text-align:left;">
				<div style="float:left; width:auto; padding:8px;">
					<div class="pageTitle">High Availability</div>
					<p class="longp" align=justify>
						For those that want the ultimate in redundancy, the high availability option allows you to have two mirrored virtual hosted Asterisk systems 
						running in geographically disperse datacenters.  When used in conjunction with our NetSIP trunking, you register a primary SIP trunk to the main 
						server and a secondary trunk to the high availability backup server.  When an incoming call comes in, our network will first attempt to send the 
						call to the primary server.  If it does not answer, we will send it to the secondary server.  
						For optimal use, you will want to use a phone that supports DUAL REGISTRATIONS (like a Polycom Soundpoint IP) to properly configure automatic failover 
						directly within your endpoints.  In this configuration, you can have a complete outage to the primary datacenter and calls will still work properly both inbound and outbound!
					</p>
				</div>
			</div><br clear="all">
EOF;
		$backup = <<<EOF
			<div style="text-align:left;">
				<div style="float:left; width:auto; padding:8px;">
				<div class="pageTitle">Nightly Backup</div>
					<p class="longp" align=justify>
						By default all of our NetPBX servers are backed up on a WEEKLY basis.  If you want the extra level of backup, choose this NIGHTLY option for enhanced backup.
					</p>
				</div>
			</div><br clear="all">
EOF;

		switch($name)
		{
			case "pbx":
			print $pbxConfig;
			break;
			case "channels":
			print $channels;
			break;
			case "ping":
			print $ping;
			break;
			case "ha":
			print $high_availability;
			break;
			case "backup":
			print $backup;
			break;
		}
	break;

	case "resend_confirmation":
		$quote_id = $_GET['qid'];
		$userid = $_GET['uid'];
		$quote = new quote($quote_id,$userid);
		//empty purchase_date
		$arr = array("purchase_date" => "");
		$quote->updateQuoteMain($arr);

		$quote_details = $quote->getQuote($quote_id,$userid);
		$quote->createPDF("ORDER CONFIRMATION");
		$reptype = substr($quote_id, 0, 1) == "A" ? "agent" : "direct";
		if(sendConfirmationEmail($quote_details, $reptype))
		{
			print "Email sent";
			exit;
		}
		print "<span class=alertsmall>ERROR</span>";
	break;

	case "resend_confirmation_admin":
		$quote_id = $_GET['qid'];
		$userid = $_GET['uid'];
		$quote = new quote($quote_id,$userid);
		//difference here is we're gonna empty the payment info for this user first
		$arr = array(
			"userid" => $userid,
			"email" => $quote->user_email,
			"cardnumber" => "",
			"cardtype" => "",
			"exp" => "",
			"cvv" => "",
			"checkaba" => "",
			"checkaccount" => ""
		);
		$quote->updateUser($arr);

		//empty purchase_date
		$arr = array("purchase_date" => "");
		$quote->updateQuoteMain($arr);

		$quote_details = $quote->getQuote($quote_id,$userid);
		$quote->createPDF("ORDER CONFIRMATION");
		$reptype = substr($quote_id, 0, 1) == "A" ? "agent" : "direct";
		if(sendConfirmationEmail($quote_details, $reptype))
		{
			print "Email sent";
			exit;
		}
		print "<span class=alertsmall>ERROR</span>";
	break;
}

function signinTable($accountcode=0, $email="")
{
	global $ROOT_PATH, $MAIN_INCLUDE_PATH, $adminParam;
	$retValue = "";
	if($accountcode)
	{
		require_once($ROOT_PATH."myaccount/classes/class.customer.php");
		$customer = new customer($accountcode);
		$email = $customer->details['email'];
	}
	$retValue .= "<fieldset>\n";
	$retValue .= "<legend><span class=listTextBold>Existing customer?</span></legend>\n";
	$retValue .= "<table width=100% border=0 cellspacing=3>";
	$retValue .= "<tr><td class=listTextBold style=\"width:50px;\" align=right>Email:</td><td><input type=\"text\" class=\"formElement\" style=\"width:100px;\" id=\"username_qb\" value=\"{$email}\" onKeyPress=\"return submitenter_qb('signin',event)\" tabindex=99></td></tr>";
	$retValue .= "<tr><td class=listTextBold style=\"width:50px;\" align=right>Password:</td><td><input type=\"password\" class=\"formElement\" style=\"width:100px;\" id=\"password_qb\" onKeyPress=\"return submitenter_qb('signin',event)\" tabindex=100></td></tr>";
	$retValue .= "<tr><td class=listTextBold align=right colspan=2 style=\"padding-right:10px;\"><input type=button value=\"Sign In\" onclick=\"signIn()\" tabindex=101></td></tr>";
	//$retValue .= "<tr><td colspan=2 class=\"alertsmall\">{$_SESSION['LoginErrorMessage']}</td></tr>";
	$retValue .= "</table></fieldset>";

	$retValue .= "<div align=center class=listTextBold style=\"margin-bottom:20px;\">Don't have an account?<br><a href=\"javascript:void(0)\" onclick=\"location.href='?step=order{$adminParam}'\">Click here</a> to get started.</div>";

	return $retValue;
}

function updateMain()
{
	global $quote, $quote_id, $userid;

	$quote_details = $quote->getQuote($quote_id,$userid);
	$total_monthly = 0;
	$total_one_time = $quote_details['main']['tax'];
	$account_balance = 0;
	if(isset($quote_details['main']['handsets']) && $quote_details['main']['handsets'] > 0)
	{
		$total_one_time += $quote->handset_price_base;
		if($quote_details['main']['handsets'] > 10)
		{
			$total_one_time += ($quote_details['main']['handsets'] - 10) * $quote->handset_price_each;
		}
	}
	if(isset($quote_details['netpbx']))
	{
		$total_monthly += $quote_details['netpbx']['price'];
		$total_monthly += $quote_details['netpbx']['ha_price'];
		$total_one_time += $quote_details['netpbx']['init_config'];
		$total_one_time += $quote_details['netpbx']['setup'];
		if(isset($quote_details['netpbx']['addons']))
		{
			foreach($quote_details['netpbx']['addons'] as $key => $value)
			{
				switch($value['billingcycle'])
				{
					case "Monthly":
					$total_monthly += $value['price'];
					break;
					case "One Time":
					$total_one_time += $value['price'];
					break;
				}
				$total_one_time += $value['setup'];
			}
		}

		$account_balance += $quote_details['netpbx']['groupname'] == "NetPBX PRO Complete" ? 30 : 0;

		if(isset($quote_details['netpbx']['promo_code']) && !empty($quote_details['netpbx']['promo_code']))
		{
			//only gonna look for One Time and (Money Value || Fixed Amount)
			$total_one_time -= $quote_details['netpbx']['discount_value'];
		}
	}

	if(isset($quote_details['netsip_options']))
	{
		$total_one_time += $quote_details['netsip_options']['initial_deposit'];
		$account_balance += $quote_details['netsip_options']['initial_deposit'];
	}
	if(isset($quote_details['netsip_packages']))
	{
		foreach($quote_details['netsip_packages'] as $key => $value)
		{
			$total_monthly += $value['price'];
		}
	}
	if(isset($quote_details['netsip_dids']))
	{
		foreach($quote_details['netsip_dids'] as $key => $value)
		{
			$total_monthly += $value['price'] * $value['quantity'];
			$total_one_time += $value['premium'] * $value['quantity'];
			//$account_balance += ($value['price'] * $value['quantity']) + ($value['premium'] * $value['quantity']);
		}
	}
	if(isset($quote_details['netsip_credit']))
	{
		foreach($quote_details['netsip_credit'] as $key => $value)
		{
			$total_one_time -= $value['amount'];
		}
	}
	if(isset($quote_details['store']))
	{
		foreach($quote_details['store'] as $key => $value)
		{
			if(is_numeric($key))
			{
				$total_one_time += $value['subtotal'];
			}
		}
		if(isset($quote_details['store']['shipping']))
		{
			$total_one_time += $quote_details['store']['shipping'][0]['cost'];
		}
	}
	$total_total = $total_monthly + $total_one_time;

	$userid = isset($quote_details['user']['userid']) ? $quote_details['user']['userid'] : $userid;
	$arr = array(
		"userid" => $userid,
		"AccountBalance" => $account_balance,
		"total" => $total_total,
		"total_onetime" => $total_one_time,
		"total_monthly" => $total_monthly,
		"update_date" => time(),
		"process_all" => 1
	);

	if(!isset($quote_details['store']))
	{
		$arr['tax'] = 0;
	}
	$result = $quote->updateQuoteMain($arr);
}

function sendQuoteEmail($quote_details, $rep_type="direct")
{
	global $ROOT_PATH, $MYACCOUNT_INCLUDE_PATH, $quote, $quote_id, $protocol, $DNS;

	$quote->createPDF("QUOTE");

	require_once($MYACCOUNT_INCLUDE_PATH."functions/password_funcs.php");

	$name = $quote_details['user']['firstname']." ".$quote_details['user']['lastname'];
	$email = $quote_details['user']['email'];
	$password = voiplion_decrypt(explode("|",$quote_details['user']['password']));

	$isBV = $quote_details['user']['cbey_bv_user'] == 1 ? true : false;

	// a random hash will be necessary to send mixed content
	$separator = md5(time());
	$eol = PHP_EOL;

	$subject = "VOIPLION.COM Quote";
	$to = "$name <$email>";

	$ccs_rep_name = "our sales team";
	$salesrep = $quote_details['user']['salesrep'];
	if($rep_type == "agent")
	{
		$tmp = array("firstname","lastname");
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_main.ccs_agent", "`agent_code` = '$salesrep'");
	}
	else
	{
		$tmp = array("firstname","lastname"); //may need to get phone here
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_whmcs.tbladmins", "`username` = '$salesrep' limit 1");
	}
	if(count($tmp_info))
	{
		$ccs_rep_name = $tmp_info['firstname']." ".$tmp_info['lastname'];
	}

	$message = !empty($name) ? "Dear $name, $eol$eol " : "";
	$message .= "An Quote has been created for you by $ccs_rep_name. $eol$eol ";


	$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
	$headers .= "Return-Path: <sales@voiplion.com>\r\n";

	$path = $ROOT_PATH."cache/";
	$filename = "quote_{$quote_id}.pdf";
	$fileatt = $path.$filename; // Path to the file 
	$fileatt_type = "application/pdf"; // File Type 
	$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
	$file = fopen($fileatt,'rb'); 
	$data = fread($file,filesize($fileatt)); 
	fclose($file); 

	$data = chunk_split(base64_encode($data)); 

	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

	//from http://www.daniweb.com/code/snippet908.html
	$headers .= "MIME-Version: 1.0".$eol;
	$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
	$headers .= "Content-Transfer-Encoding: 7bit".$eol;
	$headers .= "This is a MIME encoded message.".$eol.$eol;
	// message
	$headers .= "--".$separator.$eol;
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
	$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$headers .= $message.$eol.$eol;
	// attachment
	$headers .= "--".$separator.$eol;
	$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
	$headers .= "Content-Transfer-Encoding: base64".$eol;
	$headers .= "Content-Disposition: attachment".$eol.$eol;
	$headers .= $data.$eol.$eol;
	$headers .= "--".$separator."--";

	if(@mail($to, $subject, $message, $headers))
	{
		@mail("dave@voiplion.com", $subject, $message, $headers);
		return true;
	}
	return false;
}

function sendConfirmationEmail($quote_details, $rep_type="direct")
{
	global $ROOT_PATH, $MYACCOUNT_INCLUDE_PATH, $quote, $quote_id, $protocol, $DNS;

	require_once($MYACCOUNT_INCLUDE_PATH."functions/password_funcs.php");

	$name = $quote_details['user']['firstname']." ".$quote_details['user']['lastname'];
	$email = $quote_details['user']['email'];
	$password = voiplion_decrypt(explode("|",$quote_details['user']['password']));

	$isBV = $quote_details['user']['cbey_bv_user'] == 1 ? true : false;

	// a random hash will be necessary to send mixed content
	$separator = md5(time());
	$eol = PHP_EOL;

	$subject = "VOIPLION.COM Order Verification";
	$to = "$name <$email>";

	$ccs_rep_name = "our sales team";
	$salesrep = $quote_details['user']['salesrep'];
	if($rep_type == "agent")
	{
		$tmp = array("firstname","lastname");
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_main.ccs_agent", "`agent_code` = '$salesrep'");
	}
	else
	{
		$tmp = array("firstname","lastname"); //may need to get phone here
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_whmcs.tbladmins", "`username` = '$salesrep' limit 1");
	}
	if(count($tmp_info))
	{
		$ccs_rep_name = $tmp_info['firstname']." ".$tmp_info['lastname'];
	}

	$message = "Dear $name, $eol$eol ";
	$message .= "An order has been created for you by $ccs_rep_name. Please review the attached order information to ensure accuracy. $eol$eol ";
	$message .= "To finalize the order process, click on the link below (or copy and paste it into your browser) and sign in using these credentials: $eol ";
	$message .= "Email: $email$eol ";
	$message .= "Password: $password$eol$eol ";
	$message .= "{$protocol}://{$DNS}/agent/?verify=1&qid={$quote_id} $eol$eol ";

	$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
	$headers .= "Return-Path: <sales@voiplion.com>\r\n";

	$path = $ROOT_PATH."cache/";
	$filename = "quote_{$quote_id}.pdf";
	$fileatt = $path.$filename; // Path to the file 
	$fileatt_type = "application/pdf"; // File Type 
	$fileatt_name = $filename; // Filename that will be used for the file as the attachment 
	$file = fopen($fileatt,'rb'); 
	$data = fread($file,filesize($fileatt)); 
	fclose($file); 

	$data = chunk_split(base64_encode($data)); 

	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

	//from http://www.daniweb.com/code/snippet908.html
	$headers .= "MIME-Version: 1.0".$eol;
	$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
	$headers .= "Content-Transfer-Encoding: 7bit".$eol;
	$headers .= "This is a MIME encoded message.".$eol.$eol;
	// message
	$headers .= "--".$separator.$eol;
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"".$eol;
	$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
	$headers .= $message.$eol.$eol;
	// attachment
	$headers .= "--".$separator.$eol;
	$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
	$headers .= "Content-Transfer-Encoding: base64".$eol;
	$headers .= "Content-Disposition: attachment".$eol.$eol;
	$headers .= $data.$eol.$eol;
	$headers .= "--".$separator."--";

	if(@mail($to, $subject, $message, $headers))
	{
		$subject .= " [$quote_id]";
		@mail("dave@voiplion.com", $subject, $message, $headers);
		return true;
	}
	return false;
}

function checkRequiredFields($arr)
{
	global $isVoiplion;
	$retValue = "";
	$reqFields = array("firstname", "lastname", "email", "address1", "city", "state", "pr", "postcode", "phonenumber", "cardnumber", "exp", "checkaba", "checkaccount", "password", "password2");
	$this_country = "";
	//array_push($debug, $arr);
	foreach($arr as $key => $value)
	{
		if($key == "country")
		{
			$this_country = $value;
		}
		if($key == "email" && !empty($value))
		{
			if(substr_count($value, "@") == 0)
			{
				$retValue .= "&#42; Please provide a valid Email Address<br>";
			}
			else
			{
				$tmp = explode("@", $value);
				if(strtolower($tmp[1]) == "hotmail.com")
				{
					$retValue .= "&#42; We're sorry, We cannot accept email addresses from Hotmail.  Please use another email address for your registration. <br>";
				}
			}
		}
	}
	foreach($arr as $key => $value)
	{
		if(in_array($key, $reqFields))
		{
			if((str_replace(" ", "", $value) == "") || ($value == "Select..."))
			{
				switch($key)
				{
					case "firstname";
					$retValue .= "&#42; Please provide your First Name<br>";
					break;
					case "lastname";
					$retValue .= "&#42; Please provide your Last Name<br>";
					break;
					case "email";
					$retValue .= "&#42; Please provide your Email Address<br>";
					break;
					case "address1";
					$retValue .= "&#42; Please provide your Address<br>";
					break;
					case "city";
					$retValue .= "&#42; Please provide your City<br>";
					break;
					case "state";
					if($this_country == "US" && $value == "Select...")
					{
						$retValue .= "&#42; Please select your State<br>";
					}
					break;
					case "pr";
					if($this_country != "US")
					{
						$retValue .= "&#42; Please enter your Province/Region<br>";
					}
					break;
					case "postcode";
					$retValue .= "&#42; Please provide your Postal Code<br>";
					break;
					case "cardnumber";
					$retValue .= "&#42; Please provide your Credit Card number<br>";
					break;
					case "exp";
					$retValue .= "&#42; Please provide the expiration date of your Credit Card<br>";
					break;
					case "cvv";
					$retValue .= "&#42; Please provide Credit Card's CVV number<br>";
					break;
					case "phonenumber";
					$retValue .= "&#42; Please provide your Phone Number<br>";
					break;
					case "password";
					$retValue .= "&#42; Please choose a password<br>";
					break;
					case "checkaba";
					$retValue .= "&#42; Please provide your ACH Routing Number<br>";
					break;
					case "checkaccount";
					$retValue .= "&#42; Please provide your ACH Account Number<br>";
					break;
				}
			}
		}
	}

	if(isset($arr['password']) && isset($arr['password2']))
	{
		if(str_replace(" ", "", $arr['password']) != str_replace(" ", "", $arr['password2']))
		{
			$retValue .= "&#42; The passwords you entered do not match<br>";
		}
	}
	return $retValue;
}

function cleanPhone($num)
{
	$num = str_replace(" ", "", $num);
	$num = str_replace("+", "", $num);
	$num = str_replace("(", "", $num);
	$num = str_replace(")", "", $num);
	$num = str_replace("x", "", $num);
	$num = str_replace("X", "", $num);
	$num = str_replace(".", "", $num);

	return $num;
}

function getPerChannelPrice($channels)
{
	global $MAIN_INCLUDE_PATH;
	require_once($MAIN_INCLUDE_PATH."classes/class.products.php");
	$products = new products();
	$arr = $products->netsipPackages(5);
	foreach($arr as $key => $value)
	{
		if(substr_count($value['name'], "PRO") > 0)
		{
			$product_channels = str_replace("NetSIP", "", $value['name']);
			$product_channels = str_replace("ch PRO Unlimited", "", $product_channels);
			if($product_channels == $channels)
			{
				return $value['price'];
				break;
			}
		}
	}
	return 0;
}

function openMigrationTicket_local($arrOrder)
{
	//Created for quotes with init config...arrOrder is quote_details

	global $ROOT_PATH, $protocol, $DNS, $quote, $CBS_KayakoAPI;

	$email = $arrOrder['user']['email'];
	$fullName = $arrOrder['user']['firstname']." ".$arrOrder['user']['lastname'];
	$company = $arrOrder['user']['companyname'];
	$address = $arrOrder['user']['address1']." ".$arrOrder['user']['address2']." ".$arrOrder['user']['city'].", ".$arrOrder['user']['state']."  ".$arrOrder['user']['postcode'];
	$phone = $arrOrder['user']['phonenumber'];

	$isBV = $arrOrder['user']['cbey_bv_user'] == 1 ? true : false;
	$cbey_account_id = $arrOrder['user']['cbey_account_id'];

	$quote_id = $arrOrder['main']['quote_id'];
	$tps_id = isset($arrOrder['netpbx']['tps_id']) ? $arrOrder['netpbx']['tps_id'] : 0;
	$netpbx = $arrOrder['netpbx']['product_name'];
	$comments = $arrOrder['main']['comments'];

	$rep_name = "unknown";
	$rep_email = "";
	$salesrep = $arrOrder['user']['salesrep'];
	if(substr($salesrep, 0, 3) == "CCS") // or look for A quote vs. C quote?
	{
		$tmp = array("firstname","lastname","email");
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_main.ccs_agent", "`agent_code` = '$salesrep'");
		if(count($tmp_info))
		{
			$rep_name = $tmp_info['firstname'] ." ". $tmp_info['lastname'];
			$rep_email = $tmp_info['email'];
		}
	}
	else
	{
		$tmp = array("firstname","lastname","email");
		$tmp_info = $quote->getFieldValues($tmp, "voiplion_whmcs.tbladmins", "`username` = '$salesrep'");
		if(count($tmp_info))
		{
			$rep_name = $tmp_info['firstname'] ." ". $tmp_info['lastname'];
			$rep_email = $tmp_info['email'];
		}
	}

	$subject = !empty($company) ? $company : "No Company Name";

	$body = !empty($company) ? "{$company}<br>" : "";
	$body .= "Name: $fullName<br>";
	$body .= "Address: $address<br>";
	$body .= "Email: $email<br>";
	$body .= "Contact Phone Number: $phone<br>";
	$body .= "Sales Rep: $salesrep ";
	$body .= !empty($rep_email) ? "[$rep_email]<br>" : "<br>";

	$body .= $isBV ? "BV: $cbey_account_id<br>" : "";

	$body .= "<br>";
	$body .= "Order Summary:<br>";
	$body .= "=============================================<br>";
	$body .= "Quote: $quote_id<br>";
	$body .= "TPS ID: $tps_id<br>";
	$body .= "NetPBX: $netpbx<br>";
	$body .= "Order Comments: $comments<br><br>";
	$body .= "<a href=\"$protocol://$DNS/admin2/includes/quote_get.php?qid={$quote_id}\" target=\"_new\">View Quote</a><br>";

	$id = "";
	$mask = "";
	$username = "admin";
	$password = "g0th1cc";
	//[Non-SOAP] array submitTicket ( string $user , string $password , string $email , integer $departmentId , integer $priorityId , string $fullName , string $subject , string $message , boolean $sendAuto = true , integer $passType = 0 , string $pass = NULL )
	$result = $CBS_KayakoAPI->submitTicket(
		$username, 
		$password, 
		$email,
		20,
		3,
		$fullName,
		$subject,
		$body,
		false,
		0,
		NULL );
	if($result < 0)
	{
		return "Could not create ticket. Result:$result";
	}
	else
	{
		$id = $result['id'];
		$mask = $result['mask'];

		$eol = PHP_EOL;

		$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
		$headers .= "Return-Path: <sales@voiplion.com>\r\n";
		$subject = "New MC Activations Ticket [$mask]";
		$body = str_replace("<br>", $eol, $body);
		@mail("noc@voiplion.com", $subject, $body, $headers);
	}
	return "SUCCESS";
}


/*
							//NEW! NEW! NEW! cURL to salesforce...send email to sales@voiplion on failure
							$headers = "From: VOIPLION.COM <sales@voiplion.com>\r\n";
							$headers .= "Return-Path: <sales@voiplion.com>\r\n";
							$eol = PHP_EOL;
							$_url = "https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8";
							$postfields = array(
								"debug" => 0,
								"debugEmail" => "adam@voiplion.com",
								"oid" => "00DA0000000YUfD",
								"retURL" => "",
								"first_name" => $firstname,
								"last_name" => $lastname,
								"email" => $email,
								"00NA0000003tCbO" => "https://www.voiplion.com/admin2/includes/quote_get.php?qid={$quote_id}"
							);
							$fields = "";
							foreach($postfields as $key => $value)
							{
								$fields .= "$key=" . urlencode($value) . "&";
							}
							$ch = curl_init($_url);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
							curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($fields, "&")); // use HTTP POST to send form data (array)...interpreted as multi-part form-data
							$result = curl_exec($ch); //execute post and get results

							$succeeded = (curl_errno($ch) == 0);
							if(!$succeeded)
							{
								$subject = "FAILED Salesforce New Lead Attempt from QB2";
								$fields = "";
								foreach($postfields as $key => $value)
								{
									$fields .= "$key=$value, ";
								}
								$fields = rtrim($fields, ", ");
								$message = "Data: $fields $eol$eol ";
								$message .= "cURL failure: ".curl_errno($ch);
								@mail("sales@voiplion.com", $subject, $message, $headers);
							}
							else
							{
								$tmp = explode("\n", $result);
								foreach($tmp as $key => $value)
								{
									$tmp[$key] = trim($value);
								}
								if((isset($tmp[0]) && $tmp[0] != "Your request has been queued.") || !isset($tmp[0]) )
								{
									$subject = "FAILED Salesforce New Lead Attempt from QB2";
									$fields = "";
									foreach($postfields as $key => $value)
									{
										$fields .= "$key=$value, ";
									}
									$fields = rtrim($fields, ", ");
									$message = "Data: $fields $eol$eol ";
									$message .= "Response: $result $eol$eol ";
									@mail("sales@voiplion.com", $subject, $message, $headers);
								}
							}
							curl_close ($ch);
*/

?>