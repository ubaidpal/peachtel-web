<?php
// Variables for DB connection \\
//$serverAddress = 'localhost';
//$serverUsername = 'root';
//$serverPassword = 'cde$33MC';

// Connect to DB \\
function serverConnect($db){
	//$serverConnection = mysql_connect($GLOBALS['serverAddress'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword']) or die('Could not connect: ' . mysql_error());
	mysql_connect('localhost', 'root', 'cde$33MC') or die('Could not connect: ' . mysql_error());
	mysql_select_db($db) or die("Error connecting to voiplion database");
}

function serverClose(){
	mysql_close();
}

function queryDB($query, $db){
	serverConnect($db);
	$result = mysql_query($query);
	//$rows = mysql_fetch_array($result);
	$table_result=array();
	$r=0;
	if(!$result){
		return $table_result;
		break;
	}
	while($row = mysql_fetch_assoc($result)){
		$arr_row=array();
		$c=0;
		while ($c < mysql_num_fields($result)) {       
			$col = mysql_fetch_field($result, $c);   
			$arr_row[$col -> name] = $row[$col -> name];           
			$c++;
		}   
		$table_result[$r] = $arr_row;
		$r++;
	} 
	serverClose();
	return $table_result;
}

function updateProduct($id,$wid,$visible,$category){
	$sql = "INSERT INTO `QB_admin_product` (`wid`,`visible`,`category`) VALUES ($wid,$visible,$category) ON DUPLICATE KEY UPDATE `visible`=$visible, `category`=$category";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return "ERROR updating Product wid:".$wid." - Visible:".$visible;}else{return "SUCCESS updating Product wid=".$wid;}
}

function updateCategory($id,$wid,$description,$visible,$order,$displayType){
	if($order==""){$order = 0;}
	if($description==""){$description = " ";}
	$sql = "INSERT INTO `QB_admin_category` (`wid`,`description`,`visible`,`order`,`displayType`) VALUES ($wid,'".$description."',$visible,$order,$displayType) ON DUPLICATE KEY UPDATE `description`='".$description."', `visible`=$visible, `order`=$order, `displayType`=$displayType";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return "ERROR updating Category ".$wid." - visible:".$visible." - description:".$description." - visible:".$visible." - order:".$order." - displayType:".$displayType;}else{return "SUCCESS updating Category ".$wid;}
}

function addQuote($quote){
	$sql = "INSERT INTO `quote_main` (`quote_id`,`WHMCS_user_id`,`total_price`,`total_onetime`,`total_recurring`,`total_setup`,`date_create`,`date_update`,`status`,`notes`) VALUES ($quote)";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

function addQuoteItem($item){
	$sql = "INSERT INTO `quote_items` (`quote_id`,`WHMCS_item_id`,`whmcs_cat_id`,`bill_type`,`item_name`,`item_price`,`item_setup`,`item_qty`) VALUES ($item)";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

function addTempQuote($quote){
	$sql = "INSERT INTO `temp_main` (`quote_id`,`WHMCS_user_id`,`total_price`,`total_onetime`,`total_recurring`,`total_setup`,`date_create`,`date_update`,`status`,`notes`) VALUES ($quote)";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

function addTempQuoteItem($item){
	$sql = "INSERT INTO `temp_items` (`quote_id`,`WHMCS_item_id`,`whmcs_cat_id`,`bill_type`,`item_name`,`item_price`,`item_setup`,`item_qty`) VALUES ($item)";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

function updateQuoteShipping($QID,$carrier,$method,$insurance,$cost){
	$sql = "UPDATE `quote_main` SET `shipping_carrier` = '".$carrier."', `shipping_method` = '".$method."', `shipping_insurance` = '".$insurance."', `shipping_cost` = '".$cost."' WHERE `quote_id` = '".$QID."'";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

function addQuoteItemWHMCS($item){
	$sql = "INSERT INTO `tblquoteitems` (`quoteid`,`description`,`quantity`,`unitprice`,`discount`,`taxable`,`pid`) VALUES ($item)";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	if(!$result){return 0;}else{return 1;}
}

  //Our Admin gather info functions

function getProductList($prodID){
	return queryDB("SELECT * FROM QB_admin_product WHERE category = $prodID","voiplion");
}

function getCategoryList(){
	return queryDB("SELECT * FROM QB_admin_category","voiplion");
}

  //WHMCS gather info functions

function determineBillType($groupID){
	$whmcsArr = queryDB("SELECT * FROM tblproducts WHERE gid = $groupID","itaki_whmcs");
	$recurring = 0; $free = 0; $onetime = 0;
	for($b=0;$b<count($whmcsArr);$b++){
		if($whmcsArr[$b]['paytype'] == "recurring"){$recurring++;}
		if($whmcsArr[$b]['paytype'] == "free"){$free++;}
		if($whmcsArr[$b]['paytype'] == "onetime"){$onetime++;}
	}
	if($recurring > $free && $recurring > $onetime){return 2;}
	elseif($free > $recurring && $free > $onetime){return 3;}
	elseif($onetime > $recurring && $onetime > $free){return 1;}
	else{return 1;}
}

function determineProductBillType($ID){
	$whmcsArr = queryDB("SELECT * FROM tblproducts WHERE id = $ID","itaki_whmcs");
	if($whmcsArr[0]['paytype'] == "recurring"){return 2;}
	else if($whmcsArr[0]['paytype'] == "free"){return 3;}
	else if($whmcsArr[0]['paytype'] == "onetime"){return 1;}
	else{return 0;}
}

function getProductListWHMCS($groupID){
	$whmcsArr = queryDB("SELECT * FROM `tblproducts` WHERE `gid` = $groupID ORDER BY `order` ASC","itaki_whmcs");
	$adminArr = queryDB("SELECT * FROM `QB_admin_product` WHERE `category` = $groupID","voiplion");
	for($i=0;$i<count($whmcsArr);$i++){
		  //get Price
		$priceArr = queryDB("SELECT * FROM `tblpricing` WHERE `relid` = ".$whmcsArr[$i]['id'],"itaki_whmcs");
		  //set visible here by default - if present in Admin this setting will be overwritten
		$whmcsArr[$i]['visible'] = 1;
		$whmcsArr[$i]['price'] = $priceArr[0]['monthly'];
		$whmcsArr[$i]['setupfee'] = $priceArr[0]['msetupfee'];
		$whmcsArr[$i]['billtype'] = determineProductBillType($whmcsArr[$i]['id']);
		for($j=0;$j<count($adminArr);$j++){
			if($adminArr[$j]['wid'] == $whmcsArr[$i]['id']){
				$whmcsArr[$i]['visible'] = $adminArr[$j]['visible'];
			}
		}
	}
	return $whmcsArr;
}

function getGroupListWHMCS(){
	$whmcsArr = queryDB("SELECT * FROM `tblproductgroups`","itaki_whmcs");
	$adminArr = queryDB("SELECT * FROM `QB_admin_category`","voiplion");
	for($i=0;$i<count($whmcsArr);$i++){
		//$whmcsArr[$i]['description'] = "";
		//$whmcsArr[$i]['order'] = "";
		  //set displayType to Radio by default - if present in Admin this settign will be overwritten
		$whmcsArr[$i]['displayType'] = 2;
		  //set visible here by default - if present in Admin this setting will be overwritten
		$whmcsArr[$i]['visible'] = 1;
		$whmcsArr[$i]['billType'] = determineBillType($whmcsArr[$i]['id']);
		for($j=0;$j<count($adminArr);$j++){
			if($adminArr[$j]['wid'] == $whmcsArr[$i]['id']){
				$whmcsArr[$i]['description'] = $adminArr[$j]['description'];
				//$whmcsArr[$i]['order'] = $adminArr[$j]['order'];
				$whmcsArr[$i]['displayType'] = $adminArr[$j]['displayType'];
				$whmcsArr[$i]['visible'] = $adminArr[$j]['visible'];
			}
		}
	}
	return $whmcsArr;
}

function getUserInfo($userID){
	return queryDB("SELECT * FROM `tblclients` WHERE `id` = ".$userID,"itaki_whmcs");
}

  //

function convertDisplayType($id){
	$description = queryDB("SELECT description FROM QB_admin_display_type WHERE id = $id","voiplion");
	return $description[0]['description'];
}

function convertBillType($id){
	$description = queryDB("SELECT description FROM QB_admin_bill_type WHERE id = $id","voiplion");
	return $description[0]['description'];
}

function remSpaces($x){
	return str_replace(" ","",$x);
}

function checkIfBillTypeExists($search,$type){
	$existence = FALSE;
	for($b=0;$b<count($search);$b++){
		if($search[$b]['billType'] == $type || $search[$b]['billtype'] == $type){
			if($search[$b]['visible'] == 1){$existence = TRUE;}
		}
	}
	return $existence;
}

  //For WHMCS Accounts



?>
