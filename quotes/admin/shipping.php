<?php

if(!session_id()){ session_start(); }
require_once('form_functions.php');

  //get current shipping information for display later on page
$url = "localhost/quotes/admin/loginAccountFunctions.php";
$query_string = "action=getShipping&uid=".$_REQUEST['uid'];
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
	$shipping['address1'] = "";
	$shipping['address2'] = "";
	$shipping['city'] = "";
	$shipping['state'] = "";
	$shipping['zip'] = "";
}else{
	$shipping = array();
	$arr = explode("&",$buffer);
	for($y=0;$y<count($arr);$y++){
		$arrayItems = explode("=",$arr[$y]);
		$shipping[$arrayItems[0]] = $arrayItems[1];
	}
}

$states = statesArray();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<?php if(!session_id()){ session_start(); } ?>

	<head>
	<!-- <link type="text/css" href="css/style.css" media="screen" rel="Stylesheet" /> -->

		<title>PeachTEL</title>
	</head>
	<body>
		<div id="shippingContainer">
		<?php if(!isset($_SESSION['uid'])){ ?>
			<div class="shippingBox">
				<p class="center">You are not logged in!</p>
			</div>
		<?php }else{ ?>
			<div class="shippingBox">
				<div class="shippingBoxRow center">Update Shipping Information</div>
				<div class="shippingBoxRow">Address1:</div>
				<div class="shippingBoxRow"><input type="text" name="address1" id="ship-address1" /></div>
				<div class="shippingBoxRow">Address2:</div>
				<div class="shippingBoxRow"><input type="text" name="address2" id="ship-address2" /></div>
				<div class="shippingBoxRow">City:</div>
				<div class="shippingBoxRow"><input type="text" name="city" id="ship-city" /></div>
				<div class="shippingBoxRow">State:</div>
				<div class="shippingBoxRow">
					<select name="state" id="ship-state">
					<option value=""></option>
				<?php	foreach($states as $key => $value){
						echo "<option value='".$value."'>".$key."</option>";
					} ?>
					</select></div>
				<div class="shippingBoxRow">Zip:</div>
				<div class="shippingBoxRow"><input type="text" name="zip" id="ship-zip" /></div>
			</div>
			<div class="shippingBox">
				<div class="shippingBoxRow center">Current Shipping Information</div>
				<div class="shippingBoxRow">Address1:</div>
				<div class="shippingBoxRowC" id="exist-address1"><?php echo $shipping["address1"]; ?></div>
				<div class="shippingBoxRow">Address2:</div>
				<div class="shippingBoxRowC" id="exist-address2"><?php echo $shipping["address2"]; ?></div>
				<div class="shippingBoxRow">City:</div>
				<div class="shippingBoxRowC" id="exist-city"><?php echo $shipping["city"]; ?></div>
				<div class="shippingBoxRow">State:</div>
				<div class="shippingBoxRowC" id="exist-state"><?php echo $shipping["state"]; ?></div>
				<div class="shippingBoxRow">Zip:</div>
				<div class="shippingBoxRowC" id="exist-zip"><?php echo $shipping["zip"]; ?></div>
			</div>
			<div class="clear"></div>
			<div class="shippingBoxRow"><a href="#" id="updateShipping" onClick="updateShipping()">Save and Continue</a></div>
		<?php } ?>
		</div>
	</body>
</html>
