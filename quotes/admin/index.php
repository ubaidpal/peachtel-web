<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<script type="text/javascript" src="../scripts/jquery-1.6.4.min.js"></script>
	<!-- <script type="text/javascript" src="../scripts/jquery-ui-1.7.1.custom.min.js"></script> -->
	<script type="text/javascript" src="../scripts/jquery-ui-1.8.16.custom.min.js"></script>

	<link rel="stylesheet" href="../css/redmond/jquery-ui-1.8.16.custom.css" type="text/css" />
	<link type="text/css" href="../css/style.css" media="screen" rel="Stylesheet" />
	<link type="text/css" href="../css/adminStyle.css" media="screen" rel="Stylesheet" />

		<title>PeachTEL Admin - WHMCS</title>
	</head>
	<body>
	<?php require_once('db_functions.php'); ?>
	<div id="popUpInformation"></div>

		<div class="everything">
			<div class="logo">
				<h1>PeachTEL Admin - WHMCS</h1>
			</div>
			<div class="left">
				<?php
					$categories = getGroupListWHMCS();
					for ($j=0;$j<count($categories);$j++){
						echo "<div class='section'>\n";
						  //determine if this this category is visible or not
						if($categories[$j]['visible'] == 1){$categoryVisible = "checked='yes'";}else{$categoryVisible = "";}
						echo "<p class='ui-dialog-titlebar ui-widget-header ui-corner-all header ".remSpaces($categories[$j]['name'])."Name' id='".$categories[$j]['id']."' wid='".$categories[$j]['id']."'order='".$categories[$j]['order']."' value='".$categories[$j]['name']."'>".$categories[$j]['name']."<input type='checkbox' name='".remSpaces($categories[$j]['name'])."Visible' id='".remSpaces($categories[$j]['name'])."Visible' class='categoryVisible' ".$categoryVisible."></p>\n";
						echo "<textarea class='categoryDescription ".remSpaces($categories[$j]['name'])."Description'>".$categories[$j]['description']."</textarea>\n";
						$displaySelect1 = ""; $displaySelect2 = ""; $displaySelect3 = ""; $billSelect1 = ""; $billSelect2 = "";$billSelect3 = "";
						if($categories[$j]['displayType'] == 1){$displaySelect1 = "selected='yes'";}else{$displaySelect2 = "selected='yes'";}
						if($categories[$j]['billType'] == 1){$billSelect1 = "selected='yes'";}elseif($categories[$j]['billType'] == 2){$billSelect2 = "selected='yes'";}else{$billSelect3 = "selected='yes'";}
						echo "<p>Display Type <select id='".remSpaces($categories[$j]['name']).$categories[$j]['id']."DisplayType'><option value='1' ".$displaySelect1.">Slider</option><option value='2' ".$displaySelect2.">Radio</option><option value='3' ".$displaySelect3.">Input</option></select> ";
						echo "  :  ";
						//echo " Bill Type <select id='".remSpaces($categories[$j]['name']).$categories[$j]['id']."BillType'><option value='1' ".$billSelect1.">One-Time</option><option value='2' ".$billSelect2.">Monthly</option><option value='3' ".$billSelect3.">Free</option></select></p>\n";
						echo " Bill Type - ".convertBillType($categories[$j]['billType'])."</p>\n";

						$products = getProductListWHMCS($categories[$j]['id']);

						echo "<div class='categoryProductField'>Name</div><div class='categoryProductField'>Price</div><div class='categoryProductField'>SetupFee</div><div class='categoryProductField'>Order</div><div class='categoryProductField'>Visible</div>\n";
						echo "<div class='clear'></div>\n";
						for ($i=0;$i<count($products);$i++){
							//determine if yes or no should be default for visible
							$visibleYes = ""; $visibleNo = "";
							if($products[$i]['visible'] == 0){$visibleNo = "selected='yes'";}else{$visibleYes = "selected='yes'";}
							//display editable fields
							echo "<div class='categoryProductField'><input type='text' name='".remSpaces($categories[$j]['name'])."Name' value='".$products[$i]['name']."' row='".$products[$i]['id']."' wid='".$products[$i]['id']."' class='formE readonly ".remSpaces($categories[$j]['name'])."Prod' size='12' readonly /></div>";
							echo "<div class='categoryProductField'><input type='text' name='".remSpaces($categories[$j]['name'])."Price' value='".$products[$i]['price']."' row='".$products[$i]['id']."' wid='".$products[$i]['id']."' class='formE readonly ".remSpaces($categories[$j]['name'])."Prod' size='12' readonly /></div>";
							echo "<div class='categoryProductField'><input type='text' name='".remSpaces($categories[$j]['name'])."SetupFee' value='".$products[$i]['setupfee']."' row='".$products[$i]['id']."' wid='".$products[$i]['id']."' class='formE readonly ".remSpaces($categories[$j]['name'])."Prod' size='12' readonly /></div>";
							echo "<div class='categoryProductField'><input type='text' name='".remSpaces($categories[$j]['name'])."Order' value='".$products[$i]['order']."' row='".$products[$i]['id']."' wid='".$products[$i]['id']."' class='formE readonly ".remSpaces($categories[$j]['name'])."Prod' size='12' readonly /></div>";
							echo "<div class='categoryProductField'><select row='".$products[$i]['id']."' wid='".$products[$i]['id']."' name='".remSpaces($categories[$j]['name']).$products[$i]['id']."Visible' class='formE ".remSpaces($categories[$j]['name'])."Prod' id='".remSpaces($categories[$j]['name']).$products[$i]['id']."Visible'><option value='1' ".$visibleYes.">Yes</option><option value='0' ".$visibleNo.">No</option></select></div>";
							echo "<div class='clear'></div>\n";
						}
						echo "<div class='clear'></div>\n";
						echo "<a href='#' class='saveCategory' id='".remSpaces($categories[$j]['name'])."'>Save ".$categories[$j]['name']."</a>\n";
						echo "</div>\n";
					}
				?>
			</div>
			<div class="right">
				<div class="cart">
					<p class="header">Right Side</p>
					<p><a href="#" id="saveAllCategories">Save All</a></p>
					<p><!--<a href="#">Add New Category</a>--></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<script type="text/javascript" src="../scripts/functions.js"></script>
	</body>
</html>
