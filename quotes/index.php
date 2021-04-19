<?php if(!session_id()){ session_start(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<?php require_once('admin/db_functions.php'); ?>
	<?php $categories = getGroupListWHMCS(); ?>

	<script type="text/javascript" src="scripts/jquery-1.6.4.min.js"></script>
	<!-- <script type="text/javascript" src="scripts/jquery-ui-1.7.1.custom.min.js"></script> -->
	<script type="text/javascript" src="scripts/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="scripts/selectToUISlider.jQuery.js"></script>

	<link rel="stylesheet" href="css/redmond/jquery-ui-1.8.16.custom.css" type="text/css" />
	<link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />
	<link rel="Stylesheet" href="css/ui-lightness/jquery-ui-1.8.21.custom.css" type="text/css" />
	<link type="text/css" href="css/style.css" media="screen" rel="Stylesheet" />


		<script type="text/javascript">
			$(document).ready(function() {
				setFields();
				//resets radios so none are checked on page load
				$("input:radio.formE").prop('checked', false);
				<?php
					for($i=0;$i<count($categories);$i++){
						//create slider for categories set with displayType 1
						if($categories[$i]['displayType'] == 1){
							echo "createSlider('".remSpaces($categories[$i]['name'])."');\n";
						}
					}
				?>
			});
		</script>

		<title>PeachTEL</title>
	</head>
	<body>
	<div id="popUpInformation"></div>
	<div id="userIDField" userID=""></div>
		<div class="everything">
			<div class="logo">
				<h1>PeachTEL</h1>
			</div>
			<div class="left">
				<?php
					//Create section for each Category in database
					for ($j=0;$j<count($categories);$j++){
					    if($categories[$j]['visible'] == 1){
						echo "<div class='section'>\n";
						echo "<p class='ui-dialog-titlebar ui-widget-header ui-corner-all header' cid='".$categories[$j]['id']."'>".$categories[$j]['name']."</p>\n";
						echo "<p>".$categories[$j]['description']."</p>\n";

						//get list of all products within this category
						$products = getProductListWHMCS($categories[$j]['id']);

						//If category displayType = 1 then display as slider
						if($categories[$j]['displayType'] == 1){
							echo "<div class='UIslider'>\n";
							echo "<select name='".remSpaces($categories[$j]['name'])."' id='".remSpaces($categories[$j]['name'])."' class='formE ".remSpaces($categories[$j]['name'])."'>\n";
								for ($i=0;$i<count($products);$i++){
									//If product should be visible
									if($products[$i]['visible'] == 1){
										echo "<option value='".$products[$i]['name']."' price='".$products[$i]['price']."' setup='".$products[$i]['setupfee']."' pid='".$products[$i]['id']."' cid='".$categories[$j]['id']."' billType='".$products[$i]['billtype']."'>".$products[$i]['name']."</option>\n";
									}
								}
							echo "</select>\n";
							echo "</div>\n";
						}
						//if category displayType = 3 then display as input box
						else if($categories[$j]['displayType'] == 3){
							for ($i=0;$i<count($products);$i++){
								echo "<input type='input' name='".remSpaces($categories[$j]['name'])."' price='".$products[$i]['price']."' value='0' setup='".$products[$i]['setupfee']."' pid='".$products[$i]['id']."' cid='".$categories[$j]['id']."' type='input' title='".$products[$i]['name']."' billType='".$products[$i]['billtype']."' class='formE' size='3' /> ".$products[$i]['name']."<br>\n";
							}
						}
						//else display as radio buttons
						else{
							for ($i=0;$i<count($products);$i++){
								echo "<input type='radio' name='".remSpaces($categories[$j]['name'])."' price='".$products[$i]['price']."' value='".$products[$i]['name']."' setup='".$products[$i]['setupfee']."' pid='".$products[$i]['id']."' cid='".$categories[$j]['id']."' billType='".$products[$i]['billtype']."' class='formE' /> ".$products[$i]['name']."<br>\n";
							}
						}
						echo "</div>\n";
					    }
					}
				?>
			</div>
			<div class="right">
				<div class="cart">
					<p class="header">Quote</p>
				<?php
						for ($j=0;$j<count($categories);$j++){
							if($categories[$j]['visible'] == 1){
								echo "<div class='clear subheader'>".$categories[$j]['name']."</div>\n";
								if ($categories[$j]['displayType'] == 3){
									//add individual items for each product displayed as an input box
									//get list of all products within this category
									$products = getProductListWHMCS($categories[$j]['id']);
									for ($i=0;$i<count($products);$i++){
										echo "<div class='quoteLeft ".remSpaces($categories[$j]['name']).$products[$i]['id']."Value' pid=''></div><div class='quoteRight billingItem ".remSpaces($categories[$j]['name']).$products[$i]['id']."Price ".remSpaces($categories[$j]['name']).$products[$i]['id']."Setup'></div>\n";
									}
								}else{
									echo "<div class='quoteLeft ".remSpaces($categories[$j]['name'])."Value' pid=''></div><div class='quoteRight billingItem ".remSpaces($categories[$j]['name'])."Price ".remSpaces($categories[$j]['name'])."Setup'></div>\n";
								}
							}
						}
						echo "<p class='header'>Monthly Total</p>\n";
						echo "<div class='monthlyTotal totals'></div>\n";

						echo "<p class='header'>One-Time Total</p>\n";
						echo "<div class='oneTimeTotal totals'></div>\n";

						echo "<p class='header'>Setup</p>\n";
						echo "<div class='setupTotal totals'></div>\n";

				?>
					<p class="header">Grand Total</p>
					<div class="cartTotal"></div>
					<div id="loginLinks" class='center'>
						<p><a href="#" class="printQuote">Print Quote</a></p>
						<p><a href="#" class="orderNow">Order Now</a></p>
						<p><a href="#" id="loginAccount">Login / Create Account</a></p>
					</div>
					<div id="whmcsLinks">
						<p class='center'><a href="#" id="gotoWHMCS">WHMCS Account</a></p>
						<p class='center'><a href="#" id="saveQuote">Save Quote</a></p>
						<p class='center'><a href="#" onClick="printQuote('temp')">Print Quote</a></p>
						<p class='center'><a href="#" class="orderNow">Order Now</a></p>
						<p class='center'><a href="#" id="logoutSubmit">Log Out</a></p>
						<div class='header'>Existing Quotes</div>
						<div id='quoteList'></div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<script type="text/javascript">
			<?php if(isset($_SESSION['uid'])){ ?>
				whmcsLinks("loggedin");
				$("#userIDField").attr('userID','<?php echo $_SESSION['uid']; ?>');
				displayListQuotes(<?php echo $_SESSION['uid']; ?>);
			<?php }else{ ?>
				whmcsLinks("loggedout");
			<?php } ?>
		</script>
	</body>
</html>
