<?php

require_once('db_functions.php');

if(!session_id()){ session_start(); }

$type = "";

if(isset($_REQUEST['action'])){$action = $_REQUEST['action'];}
if(isset($_REQUEST['quoteID'])){$quoteID = $_REQUEST['quoteID'];}
if(isset($_REQUEST['uid'])){$uid = $_REQUEST['uid'];}
if(isset($_REQUEST['type'])){$type = $_REQUEST['type'];}

switch($action){

	case "new":
		  //check if user is logged in
		if(isset($_SESSION['uid']) OR $type == "temp"){
			$quoteID = createQuoteID();
			  //create quote in quote_main table
			$date_update = date('Y-m-d');
			$date_quote = date('Y-m-d');
			if($type == "temp"){
				$status = "printed";
			}else{
				$status = "saved";
			}	
			$notes = "";
			$splitItems = explode("~~",$_REQUEST['items']);
			$cartTotals = explode("+",$splitItems[0]);
			$cartTotal = explode("=",$cartTotals[0]); $oneTimeTotal = explode("=",$cartTotals[1]); $monthlyTotal = explode("=",$cartTotals[2]); $setupTotal = explode("=",$cartTotals[3]);

			if($type == "temp"){
				$status = addTempQuote("'".$quoteID."','0','".$cartTotal[1]."','".$oneTimeTotal[1]."','".$monthlyTotal[1]."','".$setupTotal[1]."','".$date_quote."','".$date_update."','".$status."','".$notes."'");
			}else{
				$status = addQuote("'".$quoteID."','".$_SESSION['uid']."','".$cartTotal[1]."','".$oneTimeTotal[1]."','".$monthlyTotal[1]."','".$setupTotal[1]."','".$date_quote."','".$date_update."','".$status."','".$notes."'");
			}

			if($status == 1){
				echo "$quoteID";
			}else{
				echo "Error adding Quote to Main DB";
			}

			  //add each line item to quote_items table
			$lineItems = explode("|",$splitItems[1]);
			for($y=0;$y<count($lineItems);$y++){
				$itemsArr = explode("+",$lineItems[$y]);
				$arr = array();
				for ($z=0;$z<count($itemsArr);$z++){
					$item = explode("=",$itemsArr[$z]);
					$arr[$item[0]] = $item[1];
				}
				if($type == "temp"){
					$status = addTempQuoteItem("'".$quoteID."','".$arr['PID']."','".$arr['CID']."','".$arr['billType']."','".$arr['description']."','".$arr['unitprice']."','".$arr['setupfee']."','".$arr['qty']."'");
				}else{
					$status = addQuoteItem("'".$quoteID."','".$arr['PID']."','".$arr['CID']."','".$arr['billType']."','".$arr['description']."','".$arr['unitprice']."','".$arr['setupfee']."','".$arr['qty']."'");
				}
				  //if error adding items to quote,
				if($status == 0){
					echo "Error adding ".$arr['description']." to Quote.\n"; 
				}
			}
		}else{
			echo "You must Log In before saving";
		}
		break;
	case "deleteQuote":
		  //check if QuoteID was provided, fail if not
		if(!isset($quoteID)){
			echo "Failed with no QuoteID provided";
			break;
		}
		  //delete provided QuoteID from Main
		$sql = "DELETE FROM `quote_main` WHERE quote_id = '".$quoteID."'";
		serverConnect("voiplion");
		$result = mysql_query($sql);
		  //delete provided QuoteID from Items
		$sql = "DELETE FROM `quote_items` WHERE quote_id = '".$quoteID."'";
		serverConnect("voiplion");
		$result = mysql_query($sql);
		serverClose();
		break;
	case "displayQuotes":
		  //quit if no UID provided
		if(!isset($uid)){break;}
		  //get list of quotes based on UID provided
		$quotesArr = queryDB("SELECT * FROM quote_main WHERE WHMCS_user_id = $uid","voiplion");
		  //echo back each Quote as a link
		for($q=0;$q<count($quotesArr);$q++){
			echo "<p class='quoteListItem'><a href=# onClick=displayQuote('".$quotesArr[$q]['quote_id']."')>".$quotesArr[$q]['quote_id']."</a> - ".$quotesArr[$q]['date_create']." <a href='#' class='deleteQuote' quoteID='".$quotesArr[$q]['quote_id']."' userID='".$uid."' onClick=deleteQuote('".$quotesArr[$q]['quote_id']."','".$uid."')>DEL</a></p>";
		}
		break;
	case "updateShipping":
		  //update existing quote with shipping method
		  //check if QuoteID was provided, fail if not
		if(!isset($quoteID)){
			echo "Failed with no QuoteID provided";
			break;
		}
		$shippingError = 0;
		if(isset($_REQUEST['carrier'])){$carrier = $_REQUEST['carrier'];}else{$shippingError ++;}
		if(isset($_REQUEST['method'])){$method = $_REQUEST['method'];}else{$shippingError ++;}
		if(isset($_REQUEST['insurance'])){$insurance = $_REQUEST['insurance'];}else{$shippingError ++;}
		if(isset($_REQUEST['cost'])){$cost = $_REQUEST['cost'];}else{$shippingError ++;}
		  //carrier, method, insurance, cost
		$status = updateQuoteShipping($quoteID,$carrier,$method,$insurance,$cost);
		if($status != 1){
			echo "Error updating your quote - ".$status;
		}else{
			echo "Success";
		}
		break;
}

function createQuoteID(){
	  //PHP function to return a unique string
	return uniqid("Q");
}

function checkQuoteExists($id){
	  //find if quoteID already exists
	$sql = "SELECT quote_id FROM `quote_main` WHERE id=$id";
	serverConnect("voiplion");
	$result = mysql_query($sql);
	serverClose();
	  //return the number of rows we find using $id
	return mysql_numrows($result);
}

?>