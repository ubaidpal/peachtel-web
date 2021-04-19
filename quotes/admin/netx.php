<?php if(!session_id()){ session_start(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<!-- <link type="text/css" href="css/style.css" media="screen" rel="Stylesheet" /> -->

		<title>PeachTEL</title>
	</head>
	<body>
		<div id="netxContainer">
		<?php if(!isset($_SESSION['uid'])){ ?>
			<div class="netxBox">
				<p class="center">You are not logged in!</p>
			</div>
		<?php }else{ ?>
			<p class="netxBox">
				Would you like to purchase insurance:<br>
				<input type="radio" name="netxInsurance" value="yes" checked>Yes</input>
				<input type="radio" name="netxInsurance" value="no">No</input>
			</p>
			<p class="netxBox">
				Select your carrier to see quotes:<br>
				<a href="#" onClick="getNetxQuote(2)">Fedex</a> - <a href="#" onClick="getNetxQuote(1)">UPS</a>
			</p>
			<div class="netxBox">
				<div id="netxQuote"></div>
			</div>
			<div class="clear"></div>
		<?php } ?>
		</div>
	</body>
</html>
