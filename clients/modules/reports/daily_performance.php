<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

$pmonth = str_pad($month, 2, "0", STR_PAD_LEFT);

$reportdata["title"] = "Daily Performance for ".$months[(int)$month]." ".$year;
$reportdata["description"] = "This report shows a daily activity summary for a given month.";

$reportdata["tableheadings"] = array("Date","New Orders","New Accounts","New Invoices","Paid Invoices","New Tickets","Cancellations");

for ( $day = 1; $day <= 31; $day += 1) {
	$date = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($day,2,"0",STR_PAD_LEFT);
	
	$query = "SELECT COUNT(*) FROM tblorders WHERE `date` LIKE '$date%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$neworders = $data[0];
	
	$query = "SELECT COUNT(*) FROM tblhosting WHERE `regdate`='$date'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$newaccounts = $data[0];
	
	$query = "SELECT COUNT(*) FROM tbldomains WHERE `registrationdate`='$date'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$newaccounts += $data[0];
	
	$query = "SELECT COUNT(*) FROM tblinvoices WHERE `date`='$date'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$newinvoices = $data[0];
	
	$query = "SELECT COUNT(*) FROM tblinvoices WHERE `datepaid` LIKE '$date%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$paidinvoices = $data[0];
	
	$query = "SELECT COUNT(*) FROM tbltickets WHERE `date` LIKE '$date%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$newtickets = $data[0];
	
	$query = "SELECT COUNT(*) FROM tblcancelrequests WHERE `date` LIKE '$date%'";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	$cancellations = $data[0];
	
	$reportdata["tablevalues"][] = array(fromMySQLDate($date),"$neworders","$newaccounts","$newinvoices","$paidinvoices","$newtickets","$cancellations");
}

while ($data = mysql_fetch_array($result)) {
	$id = $data["id"];
	$ordernum = $data["ordernum"];
	$userid = $data["userid"];
	$date = $data["date"];
	$amount = $CONFIG["CurrencySymbol"].$data["amount"];
	$promo = $data["promocode"];
	$paymentmethod = $data["value"];
	$status = $data["status"];
	$date = fromMySQLDate($date);
	$clientname = $data["firstname"]." ".$data["lastname"];
	if ($promo=="") {
		$promo="-";
	}
	$reportdata["tablevalues"][] = array("$id","$ordernum","$date","$clientname","$amount","$promo","$paymentmethod","$status");
}

$reportdata["monthspagination"] = true;

?>