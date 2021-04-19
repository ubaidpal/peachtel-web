<?php

if(!session_id()){ session_start(); }
require_once('form_functions.php');

  //get current payment information for display later on page
$url = "localhost/quotes/admin/loginAccountFunctions.php";
$query_string = "action=getPayment&uid=".$_REQUEST['uid'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$buffer = curl_exec($ch);
curl_close($ch);

if($buffer == "error"){
	$payment = array();
	$payment['cctype'] = "";
	$payment['cclastfour'] = "";
}else{
	$payment = array();
	$arr = explode("&",$buffer);
	for($y=0;$y<count($arr);$y++){
		$arrayItems = explode("=",$arr[$y]);
		$payment[$arrayItems[0]] = $arrayItems[1];
	}
}

$CCtype = CCtypeArray();
$CCexpiremonth = CCexpireMonthArray();
$CCexpireyear = CCexpireYearArray();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php if(!session_id()){ session_start(); } ?>

	<head>
	<!-- <link type="text/css" href="css/style.css" media="screen" rel="Stylesheet" /> -->

		<title>PeachTEL</title>
	</head>
	<body>
		<div id="paymentContainer">
		<?php if(!isset($_SESSION['uid'])){ ?>
			<div class="paymentBox">
				<p class="center">You are not logged in!</p>
			</div>
		<?php }else{ ?>
			<div class="paymentBox">
			<?php if($payment['cctype'] != ""){ ?>
				<div class="paymentBoxRow center">Current Payment Information</div>
				<div class="paymentBoxRow">Credit Card Type:</div>
				<div class="paymentBoxRow"><?php echo $payment['cctype']; ?></div>
				<div class="paymentBoxRow">Credit Card Number:</div>
				<div class="paymentBoxRow" id="existing-ccnum" digits="<?php echo $payment['cclastfour']; ?>">************<?php echo $payment['cclastfour']; ?></div>
				<div class="paymentBoxRow">CVV / CVV2:</div>
				<div class="paymentBoxRow" id="existing-ccvv"><?php echo $payment['cvv']; ?></div>
			<?php } ?>
			</div>
			<div class="paymentBox">
				<div class="paymentBoxRow center">Update Payment Information</div>
				<div class="paymentBoxRow">Credit Card Type:</div>
				<div class="paymentBoxRow">
					<select name="payment-cctype" id="payment-cctype">
					<?php	foreach($CCtype as $key => $value){
						echo "<option value='".$value."'>".$key."</option>";
					} ?>
					</select>
				</div>
				<div class="paymentBoxRow">Credit Card Number:</div>
				<div class="paymentBoxRow"><input type="text" name="payment-ccnum" id="payment-ccnum"></div>
				<div class="paymentBoxRow">CVV / CVV2:</div>
				<div class="paymentBoxRow"><input type="text" name="payment-ccvv" id="payment-ccvv"></div>
				<div class="paymentBoxRow">Expiration Date:</div>
				<div class="paymentBoxRow">
					<select name="payment-ccexpmonth" id="payment-ccexpmonth">
					<?php	foreach($CCexpiremonth as $key => $value){
						echo "<option value='".$value."'>".$key."</option>";
					} ?>
					</select>
					<select name="payment-ccexpyear" id="payment-ccexpyear">
					<?php	foreach($CCexpireyear as $key => $value){
						echo "<option value='".$value."'>".$key."</option>";
					} ?>
					</select>
				</div>
			</div>
			<div class="paymentBox"><a href="#" id="updatePayment" onClick="updatePaymentInfo()">Save and Continue</a></div>
		<?php } ?>
		</div>
	</body>
</html>
