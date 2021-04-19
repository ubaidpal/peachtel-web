<?php
require_once('db_functions.php');

if(!session_id()){ session_start(); }

if(isset($_REQUEST['quoteID'])){$quoteID = $_REQUEST['quoteID'];}
$type = "";
if(isset($_REQUEST['type'])){$type = $_REQUEST['type'];}
?>
<html>
<head>
<style>
#quoteBox{
	width:700px;
	margin:0 auto;
}
.quoteHeader{
	background-color:#dddddd;
	margin-bottom:10px;
}
.quoteInfoBox{
	float:left;
	width:50%;
}
.quoteDescription{
	float:left;
	width:348px;
	text-align:center;
}
.quoteQTY, .quoteMprice, .quoteOprice, .quoteSprice, .quoteItemTotal{
	float:left;
	width:63px;
	text-align:center;
	border-left:1px solid #000000;
	padding-right:5px;
}
.quoteLine{
	border-bottom:1px solid #000000;
	
}
.quoteTotalBox{
	float:right;
	width:250px;
}
.totalLeft{
	float:left;
	text-align:right;
	padding-right:5px;
}
.totalRight{
	float:left;
	text-align:left;
	padding-left:5px;
}
.center{
	text-align:center;
}
.print-edit{
	text-align:right;
	padding-right:20px;
}
.noBorder{
	border:none;
	padding:0 1px 0 5px;
}
.clear{
	clear:both;
}
.aLeft{
	text-align:left;
}
.aRight{
	text-align:right;
}
</style>
</head>
<body background-color="#ffffff"><div id="quoteBox">
<script>
function printPopUp(){
	w=window.open();
	w.document.write($('#popUpInformation').html());
	w.print();
	w.close();
}
</script>
<?php
if($type == "temp"){
	$quoteMain = queryDB("SELECT * FROM temp_main WHERE quote_id = '".$quoteID."'","voiplion");
	$lineItems = queryDB("SELECT * FROM temp_items WHERE quote_id = '".$quoteID."'","voiplion");
	//if($quoteMain[0]['WHMCS_user_id'] != '0'){
	//	$userInfo = getUserInfo($quoteMain[0]['WHMCS_user_id']);
	if(isset($_SESSION['uid'])){
		$userInfo = getUserInfo($_SESSION['uid']);
	}else{
		$userInfo = array();
		$userInfo[0] = array(
			"firstname" => "Guest",
			"lastname" => "",
			"companyname" => "",
		);
	}
}else{
	$quoteMain = queryDB("SELECT * FROM quote_main WHERE quote_id = '".$quoteID."'","voiplion");
	$lineItems = queryDB("SELECT * FROM quote_items WHERE quote_id = '".$quoteID."'","voiplion");
	$userInfo = getUserInfo($quoteMain[0]['WHMCS_user_id']);
}
?>

<p class="print-edit"><a href="#" onClick=printPopUp()>Print</a><p>
<div class="quoteHeader">
	<div class="quoteInfoBox">
		<p class="center">VoipLion.com Quote Builder</p>
		<?php if($type != "temp"){ ?><p class="center">Quote ID <?php echo $quoteID; ?></p><?php } ?>
	</div>
	<div class="quoteInfoBox">
		<p><?php echo $userInfo[0]['firstname']." ".$userInfo[0]['lastname']."<br>".$userInfo[0]['companyname']; ?><br>Printed on <?php echo date('m-d-Y'); ?></p>
	</div>
	<div class="clear"></div>
</div>
<div class="quoteLine">
	<div class="quoteDescription">Item Description</div><div class="quoteQTY noBorder">Quantity</div><div class="quoteMprice noBorder">Monthly Price</div><div class="quoteOprice noBorder">One-Time Price</div><div class="quoteSprice noBorder">Setup Price</div><div class="quoteItemTotal noBorder">Total</div><div class="clear"></div>
</div>
<?php
	for($i=0;$i<count($lineItems);$i++){
	$item_name = $lineItems[$i]['item_name'];
	$item_qty = $lineItems[$i]['item_qty'];
	$item_price = $lineItems[$i]['item_price'];
	$item_setup = $lineItems[$i]['item_setup'];
	$itemGrandTotal = ($item_price + $item_setup) * $item_qty;
	$billType = $lineItems[$i]['bill_type'];
	$billTypeM = 0; $billTypeO = 0;
	if($billType == 1){$billTypeO = $item_price;}
	else if($billType == 2){$billTypeM = $item_price;}
?>
<div class="quoteLine">
	<div class="quoteDescription aLeft"><?php echo $item_name; ?></div>
	<div class="quoteQTY aRight"><?php echo $item_qty; ?></div>
	<div class="quoteMprice aRight">$<?php echo $billTypeM; ?></div>
	<div class="quoteOprice aRight">$<?php echo $billTypeO; ?></div>
	<div class="quoteSprice aRight">$<?php echo $item_setup; ?></div>
	<div class="quoteItemTotal aRight">$<?php echo $itemGrandTotal; ?></div>
	<div class="clear"></div>
</div>
<?php 	}
	if($quoteMain[0]['shipping_carrier'] != ""){ 
	  if($quoteMain[0]['shipping_carrier'] == "1"){ $shipping_carrier = "UPS"; }else{ $shipping_carrier = "FEDEX"; }
?>

	<div class="quoteLine">
		<div class="quoteDescription aLeft">Shipping - <?php echo $shipping_carrier." ".$quoteMain[0]['shipping_method']." - Insurance:".$quoteMain[0]['shipping_insurance']; ?></div>
		<div class="quoteQTY aRight">&nbsp;</div>
		<div class="quoteMprice aRight">&nbsp;</div>
		<div class="quoteOprice aRight">$<?php echo $quoteMain[0]['shipping_cost']; ?></div>
		<div class="quoteSprice aRight">&nbsp;</div>
		<div class="quoteItemTotal aRight">$<?php echo $quoteMain[0]['shipping_cost']; ?></div>
		<div class="clear"></div>
	</div>

<?php   }
?>
<div class="quoteTotalBox">
	<div class="totalLeft">
		<p>$<?php echo $quoteMain[0]['total_onetime'] + $quoteMain[0]['shipping_cost']; ?></p>
		<p>$<?php echo $quoteMain[0]['total_recurring']; ?></p>
		<p>$<?php echo $quoteMain[0]['total_setup']; ?></p>
		<p>$<?php echo $quoteMain[0]['total_price'] + $quoteMain[0]['shipping_cost']; ?></p>
	</div>
	<div class="totalRight">
		<p>One-Time Total</p>
		<p>Monthly Total</p>
		<p>Setup Total</p>
		<p>Grand Total</p>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<?php if($type == "confirm"){ ?>
	<div class="confirmOrder center"><a href="#" onClick=orderFlow("confirm")>Confirm Order</a></div>
<?php } ?>

</div></body>