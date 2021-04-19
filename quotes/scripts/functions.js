	//create cart array for storing cart data
	cart = new Array();

	//create a variable to store temporary quote ID
	var QIDtemp = "";
	
	//create vairables to store address for checkout
	var Qaddress1 = "";
	var Qaddress2 = "";
	var Qcity = "";
	var Qstate = "";
	var Qzip = "";
	var Qcontact = "VoipLion";
	var Qinsurance = "";
	var Qcarrier = "";
	var Qshippingmethod = "";
	var Qcost = "";

	//Form elements on change event *Input Box*
	$('.formE').change(function() {
		if($(this).attr('type') == 'input'){
			inputPrice = $(this).val() * $(this).attr('price');
			inputSetup = $(this).val() * $(this).attr('setup');
			$("." + $(this).attr('name') + $(this).attr('pid') + "Price").attr('quantity',$(this).val());
			$("." + $(this).attr('name') + $(this).attr('pid') + "Price").text("$" + inputPrice);
			$("." + $(this).attr('name') + $(this).attr('pid') + "Price").attr('price',inputPrice);
			$("." + $(this).attr('name') + $(this).attr('pid') + "Setup").attr('setup',inputSetup);
			$("." + $(this).attr('name') + $(this).attr('pid') + "Value").attr('pid',$(this).attr("pid"));
			$("." + $(this).attr('name') + $(this).attr('pid') + "Value").text($(this).attr("title"));
			updateCart($(this).attr("cid")+"-"+$(this).attr("pid"),$(this).attr("pid"),$(this).attr("billType"),$(this).attr("title"),$(this).attr("price"),$(this).attr("setup"),$(this).val());
			//alert($(this).attr("cid")+"-"+$(this).attr("pid")+","+$(this).attr("pid")+","+$(this).attr("billType")+","+$(this).attr("title")+","+$(this).attr("price")+","+$(this).attr("setup")+","+$(this).val());
		}else{
	//Form elements on change event *All Others*
			tempVal = $(this).val();
			$("." + $(this).attr('name') + "Value").text($(this).val());
			$("." + $(this).attr('name') + "Setup").attr('setup',$(this).attr("setup"));
			$("." + $(this).attr('name') + "Value").attr('pid',$(this).attr("pid"));
			$("." + $(this).attr('name') + "Price").text("$" + $(this).attr("price"));
			$("." + $(this).attr('name') + "Price").attr('price',$(this).attr("price"));
			updateCart($(this).attr("cid"),$(this).attr("pid"),$(this).attr("billType"),$(this).val(),$(this).attr("price"),$(this).attr("setup"),1);
			//alert($(this).attr("cid")+","+$(this).attr("pid")+","+$(this).attr("billType")+","+$(this).val()+","+$(this).attr("price")+","+$(this).attr("setup")+",1");
		}
		calculateTotal();
	});

	function updateCart(cid,pid,billType,value,price,setup,qty){
		cartLength = cart.length;
		cartID = cartLength;
		/*if(cartLength == 0){
			cart[0] = new Array();
		}*/
		  //check if we already have a product for this category
		for(i=0;i<cartLength;i++){
			if(cart[i]['cid'] == cid){
				cartID = i;
			}
		}
		  //
		if(cartID == cartLength){ cart[cartID] = new Array(); }
		cart[cartID]['cid'] = cid;
		cart[cartID]['pid'] = pid;
		cart[cartID]['value'] = value;
		cart[cartID]['price'] = price;
		cart[cartID]['setup'] = setup;
		cart[cartID]['qty'] = qty;
		cart[cartID]['billType'] = billType;
	}
	
	function loadCart(){
		//Load a saved Cart
	}

	function setFields(){
		calculateTotal();
	}
	
	function whmcsLinks(state){
		if(state == "loggedin"){
			$("#whmcsLinks").show();
			$("#loginLinks").hide();
		}else{
			$("#whmcsLinks").hide();
			$("#loginLinks").show();
		}
	}

	function createSlider(name){
		$('#'+name).selectToUISlider({
			tooltip:false,
			sliderOptions: {
				animate:true,
				change:function(e, ui) {
					$("." + name + "Price").fadeOut(500, function(){
						$("." + name + "Price").text('$'+$('#'+name+' option').eq(ui.values[0]).attr("price")).fadeIn(500);
					});
					$("." + name + "Value").fadeOut(500, function(){
						$("." + name + "Value").text($('#'+name+' option').eq(ui.values[0]).text()).fadeIn(500);
					});
					$("." + name + "Price").attr('price',$('#'+name+' option').eq(ui.values[0]).attr("price"));
					$("." + name + "Setup").attr('setup',$('#'+name+' option').eq(ui.values[0]).attr("setup"));
					updateCart($('#'+name+' option').eq(ui.values[0]).attr("cid"),$('#'+name+' option').eq(ui.values[0]).attr("pid"),$('#'+name+' option').eq(ui.values[0]).attr("billType"),$('#'+name+' option').eq(ui.values[0]).attr("value"),$('#'+name+' option').eq(ui.values[0]).attr("price"),$('#'+name+' option').eq(ui.values[0]).attr("setup"),1);
					calculateTotal();
				}
			}
		}).hide();
	}

	function createSlider2(name){
		$('#'+name).slider({
				value:10,
				min:1,
				max:1000,
				animate:true,
				change:function(e, ui) {
					$("." + name + "Price").fadeOut(500, function(){
						$("." + name + "Price").text('$'+$('#'+name+' option').eq(ui.values[0]).attr("price")).fadeIn(500);
					});
					$("." + name + "Value").fadeOut(500, function(){
						$("." + name + "Value").text($('#'+name+' option').eq(ui.values[0]).text()).fadeIn(500);
					});
					$("." + name + "Price").attr('price',$('#'+name+' option').eq(ui.values[0]).attr("price"));
					$("." + name + "Setup").attr('setup',$('#'+name+' option').eq(ui.values[0]).attr("setup"));
					calculateTotal();
			}
		}).hide();
	}

	function calculateTotal(){
		var setupTotalValue = 0;
		var cartTotalValue = 0;
		$(".quoteRight").each(function() {
			//add only if the value is number
			var PE = $(this).attr("price");
			var SV = $(this).attr("setup");
			if(!isNaN(PE) && PE.length!=0) {
				cartTotalValue += parseFloat(PE);
				setupTotalValue += parseFloat(SV);
			}

		});
		cartTotalValue += setupTotalValue;
		$('.cartTotal').attr('price',cartTotalValue);
		$('.setupTotal').attr('price',setupTotalValue);
		//Fade out the old total and in the new total
		$('.cartTotal').fadeOut(1000,function(){
			$('.cartTotal').text("$" + cartTotalValue.toFixed(2)).fadeIn(2000);
		});
		$('.setupTotal').fadeOut(1000,function(){
			$('.setupTotal').text("$" + setupTotalValue.toFixed(2)).fadeIn(2000);
		});

		var monthlyTotalValue = 0;
		var oneTimeTotalValue = 0;
		var freeTotalValue = 0;
		for(c=0;c<cart.length;c++){
			if(cart[c]['billType'] == 1){
				  //one-time
				oneTimeTotalValue += parseFloat(cart[c]['price']);
			}
			else if(cart[c]['billType'] == 2){
				  //monthly
				monthlyTotalValue += parseFloat(cart[c]['price']);
			}else{
				  //everything else should be free
				freeTotalValue += parseFloat(cart[c]['price']);
			}
		}
		
		//update the total displayed if it has changed - fade the value out then back in with the new total
		if($('.monthlyTotal').attr('price') != monthlyTotalValue){
			$('.monthlyTotal').attr('price',monthlyTotalValue);
			$('.monthlyTotal').fadeOut(1000,function(){
				$('.monthlyTotal').text("$" + monthlyTotalValue.toFixed(2)).fadeIn(2000);
			});
		}

		//update the total displayed if it has changed - fade the value out then back in with the new total
		//oneTimeTotalValue.toFixed(2);
		if($('.oneTimeTotal').attr('price') != oneTimeTotalValue){
			$('.oneTimeTotal').attr('price',oneTimeTotalValue);
			$('.oneTimeTotal').fadeOut(1000,function(){
				$('.oneTimeTotal').text("$" + oneTimeTotalValue).fadeIn(2000);
			});
		}
	}

	//Admin
	$('.saveCategory').click(function(){
		submitCategoryChanges($(this).attr('id'));
		
	});
	$('#saveAllCategories').click(function(){
		$('.saveCategory').trigger('click');
		
	});
	//QB WHMCS links
	$('#loginAccount').click(function(){
		loginForm();
	});
	$('#gotoWHMCS').click(function(){
		$.post('admin/loginAccountFunctions.php', { action: 'check' }, function(data) {
			if(data != 0){
				window.location = "admin/submitToWHMCS.php?action=account&email="+data;
			}else{
				alert("You must login first");
			}
		});
	});
	//QB general links
	$('#saveQuote').click(function(){
		saveQuote();
	});
	$('#logoutSubmit').click(function(){
		$.post('admin/loginAccountFunctions.php', { action: 'logout' }, function(data) {
			$('#loginInfo').html(data);
			if(data == "Logged Out"){
				whmcsLinks("loggedout");
				$('#userIDField').attr('userID','');
			}
		});
	});
	$('.printQuote').click(function(){
		printQuote("temp");
	});
	$('.orderNow').click(function(){
		orderFlow("click");
	});

	function createSubmit(step){
		$.post('admin/loginAccountFunctions.php', { action: 'createAccount', firstName: $('#createFirstName').val(), lastName: $('#createLastName').val(), company: $('#createCompany').val(), email: $('#createEmail').val(), password: $('#createPassword').val(), phone: $('#createPhone').val() }, function(data) {
			$('#createInfo').html(data);
			if(data == "Success"){
				whmcsLinks("loggedin");
				$.post('admin/loginAccountFunctions.php', { action: 'login', username: $('#createEmail').val(), password: $('#createPassword').val() }, function(data) {
					if(data != "error"){
						whmcsLinks("loggedin");
						$('#userIDField').attr('userID',data);
					}
				});
				$("#popUpInformation").dialog("close");
				if(step == "order"){
					orderFlow("login");
				}
			}
		});
	}
	
	function loginForm(step){
		$("#popUpInformation").dialog({width:425,height:425});
		$("#popUpInformation").load("admin/accountLogin.php?step="+step);
		$("#popUpInformation").dialog('open');
	}

	function loginSubmit(step){
		$.post('admin/loginAccountFunctions.php', { action: 'login', username: $('#loginName').val(), password: $('#loginPassword').val() }, function(data) {
			$('#loginInfo').html(data);
			if(data != "error"){
				whmcsLinks("loggedin");
				$('#userIDField').attr('userID',data);
				displayListQuotes(data);
				$("#popUpInformation").dialog("close");
				if(step == "order"){
					orderFlow("login");
				}
			}
		});
	}

	function collectShipping(){
		$("#popUpInformation").dialog({width:425,height:425});
		$("#popUpInformation").load("admin/shipping.php?uid="+$('#userIDField').attr('userID'));
		$("#popUpInformation").dialog('open');
	}

	function updateShipping(){
		  //error checking - all fields required
		error = "false";
		if($('#ship-address1').val() == "" && $('#exist-address1').text() == ""){
			error = "true";
		}
		if($('#ship-city').val() == "" && $('#exist-city').text() == ""){
			error = "true";
		}
		if($('#ship-state').val() == "" && $('#exist-state').text() == ""){
			error = "true";
		}
		if($('#ship-zip').val() == "" && $('#exist-zip').text() == ""){
			error = "true";
		}
		if(error == "true"){
			alert("All Fields Are Required");
		}else{
		   if($('#ship-address1').val() == "" && $('#exist-address1').text() != ""){
			  //update Quote variables we'll need later
			Qaddress1 = $('#exist-address1').text();
			Qcity = $('#exist-city').text();
			Qstate = $('#exist-state').text();
			Qzip = $('#exist-zip').text();
			orderFlow("shipping");
		   }else{
			  //collect entered data - save Quote variables where applicable
			UID = $('#userIDField').attr('userID');
			ADDRESS1 = Qaddress1 = $('#ship-address1').val();
			ADDRESS2 = $('#ship-address2').val();
			CITY = Qcity = $('#ship-city').val();
			STATE = Qstate = $('#ship-state').val();
			ZIP = Qstate = $('#ship-zip').val();

			  //verify address and present choice to accept or keep entered data
			addressMatch = "FALSE";
			$.post('admin/usps.php', { address1: ADDRESS1, address2: ADDRESS2, city: CITY, state: STATE, zip: ZIP }, function(data) {
				alert(data);
				if(data != "ERROR"){
					addressMatch = "TRUE";
					var arr = data.split("&");
					var arrAddress = new Array();
					for(a=0;a<arr.length;a++){
						var arrSub = arr[a].split("=");
						arrAddress[arrSub[0]] = arrSub[1];
					}
					$("#popUpInformation").dialog({
						width:450,
						height:400,
						buttons: {
							"Replace": function() {
								ADDRESS1 = arrAddress['address1'];
								ADDRESS2 = arrAddress['address2'];
								CITY = arrAddress['city'];
								STATE = arrAddress['state'];
								ZIP = arrAddress['zip'];
								$("#popUpInformation").dialog("close");
								saveShipping(UID,ADDRESS1,ADDRESS2,CITY,STATE,ZIP);
							},
							"Keep Original": function() {
								$("#popUpInformation").dialog("close");
								saveShipping(UID,ADDRESS1,ADDRESS2,CITY,STATE,ZIP);
							}
						}
					});
					$("#popUpInformation").html("<p>Please select to Keep the Original address as you entered it, or Replace with the one we found through USPS</p><div class=shippingBox><p>Your entered address<br>"+ADDRESS1+"<br>"+ADDRESS2+"<br>"+CITY+"<br>"+STATE+"<br>"+ZIP+"</p></div><div class=shippingBox><p>Our found address<br>"+arrAddress['address1']+"<br>"+arrAddress['address2']+"<br>"+arrAddress['city']+"<br>"+arrAddress['state']+"<br>"+arrAddress['zip']+"</p></div><div class=clear></div>");
					$("#popUpInformation").dialog('open');
				}else{
					//there was not a match
					alert("There was not a match");
				}
			});
		   }
		}
	}

	function saveShipping(UID,ADDRESS1,ADDRESS2,CITY,STATE,ZIP){
		  //save address
		$.post('admin/loginAccountFunctions.php', { action: 'updateShipping', uid: UID, address1: ADDRESS1, address2: ADDRESS2, city: CITY, state: STATE, zip: ZIP }, function(data) {
			if(data == "Success"){
				orderFlow("shipping");
			}else{
				alert(data);
				collectShipping();
			}
		});
	}

	function GetXmlHttpObject(){ 
		var objXMLHttp=null
		if (window.XMLHttpRequest){
			objXMLHttp=new XMLHttpRequest()
		}else if (window.ActiveXObject){
			objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
		}
		return objXMLHttp
	}

	function collectNetx(){
		$("#popUpInformation").dialog({width:425,height:425});
		$("#popUpInformation").load("admin/netx.php");
		$("#popUpInformation").dialog('open');
	}

	function getNetxQuote(carrier){
		$('#netxQuote').html("<center><img src='images/loader.gif' width='100' height='100'></center>");  //Let user know we are loading data
		if(carrier == 1 || carrier == 2){
			DEVICELIST = "";
			Qinsurance = $('input[name=netxInsurance]').filter(':checked').val(); 
			Qcarrier = carrier;
			Qshippingmethod = "Ground"; //netx requires something in this field when we submit for quote
			$.post('admin/submitToNetx.php', { action: 'shipping', address1: Qaddress1, city: Qcity, state: Qstate, zip: Qzip, ordernum: QIDtemp, contact: Qcontact, shipper: Qcarrier, insurance: Qinsurance, shippingmethod: Qshippingmethod, devicelist: DEVICELIST }, function(data) {
				$('#netxQuote').html(data);
			});
		}else{
			$('#netxQuote').html("Error gathering needed information");
		}
	}

	function saveNetxQuote(){
		Qshippingmethod = $('input[name=selectNetxQuote]').filter(':checked').val();
		Qcost = $('input[name=selectNetxQuote]').filter(':checked').attr('cost');
		if(Qshippingmethod == "" || Qshippingmethod == undefined){
			alert("You must select a Shipping Method to contine");
		}else{
			  //save shipping info to quote DB
			$.post('admin/quotes.php', { action: 'updateShipping', quoteID: QIDtemp, carrier: Qcarrier, method: Qshippingmethod, insurance: Qinsurance, cost: Qcost }, function(data) {
				if(data == "Success"){
					orderFlow("netxusa");
				}else{
					alert(data);
				}
			});
		}
	}

	function updateNetxUSA(){
		//save NetxUSA data
		orderFlow("netxusa");
	}

	function collectPaymentInfo(){
		$("#popUpInformation").dialog({width:425,height:425});
		$("#popUpInformation").load("admin/payment.php?uid="+$('#userIDField').attr('userID'));
		$("#popUpInformation").dialog('open');
	}

	function updatePaymentInfo(){
		if($('#payment-ccexpmonth').val() != "00" && $('#payment-ccexpyear').val() != "00" && $('#payment-cctype').val() != "00"){
			if(checkCreditCard($('#payment-ccnum').val())){
				$.post('admin/loginAccountFunctions.php', { action: 'updatePayment', uid: $('#userIDField').attr('userID'), cctype: $('#payment-cctype').val(), ccnum: $('#payment-ccnum').val(), ccvv: $('#payment-ccvv').val(), expdate: $('#payment-ccexpmonth').val()+$('#payment-ccexpyear').val() }, function(data) {
					if(data == "Success"){
						orderFlow("payment");
					}else{
						alert(data);
					}
				});
			}else{
				alert("Credit Card Number is invalid");
			}
		}else if($('#payment-ccexpmonth').val() == "00" && $('#payment-ccexpyear').val() == "00" && $('#payment-cctype').val() == "00" && $('#existing-ccnum').attr("digits") != ""){
			orderFlow("payment");
		}else{
			alert("Please enter all information");
		}
	}

	function orderFlow(step){
		  //step is equal to step just completed
		if(step == "click"){
			  //check if logged in
			orderLogin();
		}else if(step == "login"){
			saveQuote();  //save quote first
			if(QIDtemp != "Error"){
				  //Collect / Verify shippping address
				collectShipping();
			}
		}else if(step == "shipping"){
			  //gather Next USA Shipping for Phones
			collectNetx();
		}else if(step == "netxusa"){
			  //collect / verify payment
			collectPaymentInfo();
		}else if(step =="payment"){
			  //confirm order
			displayQuote(QIDtemp,"confirm");
		}else if(step == "confirm"){
			  //process order
			alert("Process Order");
		}else{
			alert("There was an error in the order Process");
		}
	}

	function orderLogin(){
		$.post('admin/loginAccountFunctions.php', { action: 'check' }, function(data) {
			//check if logged in, if not log in / create account
			if(data == 0){
				//Logged Out - present Log In / Sign Up form
				loginForm("order");
			}else{
				orderFlow("login");
			}
		});
	}

	function tempQID(x){
		  //this function is used by the saveQuote function to
		  //store the QID returned by quotes.php into a temporary variable
		QIDtemp = x;
	}

	function saveQuote(){
		  //error check to see if anything is in cart yet
		if(cart.length == 0){
			alert("There are no items in your cart");
			return("Error");
		}else{
			lineItems = "";
			lineItems += "cartTotal="+$('.cartTotal').attr('price')+"+oneTimeTotal="+$('.oneTimeTotal').attr('price')+"+monthlyTotal="+$('.monthlyTotal').attr('price')+"+setupTotal="+$('.setupTotal').attr('price')+"~~";
			for(var varx=0;varx<cart.length;varx++){
				lineItems += "CID="+cart[varx]['cid']+"+PID="+cart[varx]['pid']+"+billType="+cart[varx]['billType']+"+description="+cart[varx]['value']+"+unitprice="+cart[varx]['price']+"+setupfee="+cart[varx]['setup']+"+qty="+cart[varx]['qty']+"|";
				//alert(lineItems);
			}
			lineItems = lineItems.slice(0,-1);
			$.post('admin/quotes.php', { action: 'new', items: lineItems }, function(data) {
				tempQID(data);
			});
			displayListQuotes($('#userIDField').attr('userID'));
		}
	}

	function displayQuote(quoteID,type){
		if(type == "temp" || type == "confirm"){
			$("#popUpInformation").load("admin/printQuote.php?quoteID="+quoteID+"&type="+type);
		}else{
			$("#popUpInformation").load("admin/printQuote.php?quoteID="+quoteID);
		}
		$("#popUpInformation").dialog({width:750,height:500});
		$("#popUpInformation").dialog('open');
	}

	function displayListQuotes(UID){
		$.post('admin/quotes.php', { action: 'displayQuotes', uid: UID }, function(data) {
			$('#quoteList').html(data);
		});
	}

	function printQuote(type){
		  //error check to see if anything is in cart yet
		if(cart.length == 0){
			alert("There are no items in your cart");
		}else{
			lineItems = "";
			lineItems += "cartTotal="+$('.cartTotal').attr('price')+"+oneTimeTotal="+$('.oneTimeTotal').attr('price')+"+monthlyTotal="+$('.monthlyTotal').attr('price')+"+setupTotal="+$('.setupTotal').attr('price')+"~~";
			for(var varx=0;varx<cart.length;varx++){
				lineItems += "CID="+cart[varx]['cid']+"+PID="+cart[varx]['pid']+"+billType="+cart[varx]['billType']+"+description="+cart[varx]['value']+"+unitprice="+cart[varx]['price']+"+setupfee="+cart[varx]['setup']+"+qty="+cart[varx]['qty']+"|";
			}
			lineItems = lineItems.slice(0,-1);
			$.ajaxSetup({async: false});
			$.post('admin/quotes.php', { action: 'new', items: lineItems, type: type }, function(data) {
				QID = data;
			});
		}
		displayQuote(QID,type);
	}

	function deleteQuote(QID,UID){
		$("#popUpInformation").dialog({
			width:450,
			height:200,
			buttons: {
				"Delete": function() {
					$.post('admin/quotes.php', { action: 'deleteQuote', quoteID: QID }, function(data) {
						if(data != ""){
							$("#popUpInformation").dialog("close");
							alert(data);
						}else{
							$("#popUpInformation").dialog("close");
							displayListQuotes(UID);
						}
					});
				},
				Cancel: function() {
					$("#popUpInformation").dialog("close");
				}
			}
		});
		$("#popUpInformation").html("<p class='center'>Are you sure you want to delete Quote "+QID+"?</p>");
		$("#popUpInformation").dialog('open');
	}

	function checkCreditCard(CC){                        
		if (CC.length > 19 || CC.length < 13){
			return (false);
		}
		sum = 0; mul = 1; l = CC.length;
		for (i = 0; i < l; i++){
			digit = CC.substring(l-i-1,l-i);
			tproduct = parseInt(digit ,10)*mul;
			if (tproduct >= 10){
				sum += (tproduct % 10) + 1;
			}else{
				sum += tproduct;
			}
			if (mul == 1){
				mul++;
			}else{
				mul--;
			}
		}
		if ((sum % 10) == 0){
			return (true);
		}else{
			return (false);
		}
	}


	function stripName(withName, name){
		return withName.replace(name,"");
	}
	function findRowIdInArray(arr,id){
		  //search through given array to find which row contains the ID we are looking for
		  //return the appropriate row for the ID, or if not found return length+1 for a new row
		len = arr.length;
		for(j=0;j<arr.length;j++){
			if(arr.length==0){
				len = 0;
			}
			if(arr[j]){
				if(arr[j]['id'] == id){
					len = j;
				}
			}
		}
		return len;
	}
	function submitCategoryChanges(name){
		changesP = new Array();
		changesC = new Array();
		  //printArray is used for Debugging later on
		printArray = "";
		  //get category information
		changesC['id'] = $('.'+name+'Name').attr('id');
		changesC['wid'] = $('.'+name+'Name').attr('wid');
		changesC['description'] = $('.'+name+'Description').val();
		changesC['displayType'] = $('#'+name+changesC['id']+'DisplayType').val();
		changesC['order'] = $('.'+name+'Name').attr('order');
		//changesC['billType'] = $('#'+name+changesC['id']+'BillType').val();
		if ($('#'+name+'Visible').is(':checked')){changesC['visible'] = 1;}else{changesC['visible'] = 0;}
		//for each product field in the category we are saving
		$('.'+name+'Prod').each(function(){
			  //find the row in the changes array that has the database ID we are adding these fields for
			x = findRowIdInArray(changesP,$(this).attr('row'));
			  //if we haven't alread, set aside a new row in the array for our data
			if(!changesP[x]){changesP[x] = new Array();}
			  //update the data for this row in the array, we will be adding a new value to the array each time
			changesP[x]['id'] = $(this).attr('row');
			changesP[x]['category'] = changesC['wid'];
			changesP[x]['wid'] = $(this).attr('wid');
			  //check if Option to treat it different
			if($(this).attr('name') == name+changesP[x]['id']+"Visible"){
				changesP[x][stripName($(this).attr('name'),name+changesP[x]['id'])] = $('#'+name+changesP[x]['id']+'Visible').val();
			}else{
				changesP[x][stripName($(this).attr('name'),name)] = $(this).val();
			}
		});

		  //submit to script that saves to DB
		$("#popUpInformation").dialog({width:450,height:300});
		$("#popUpInformation").html("<p id='returnData' class='center'></p>");
		$("#popUpInformation").dialog('open');
		  //update category
			$.post('saveChanges.php', { action: 'updateCategory', id: changesC['id'], wid: changesC['wid'], description: changesC['description'], visible: changesC['visible'], order: changesC['order'], displayType: changesC['displayType'] }, function(data) {
				returnData = $('#returnData').html();
				$('#returnData').html(returnData+"<br>"+data);
			});
		  //update each product
		for(p=0;p<changesP.length;p++){
			$.post('saveChanges.php', { action: 'updateProduct', id: changesP[p]['id'], wid: changesP[p]['wid'], visible: changesP[p]['Visible'], category: changesP[p]['category'] }, function(data) {
				returnData = $('#returnData').html();
				$('#returnData').html(returnData+"<br>"+data);
			});
		}
		returnData = $('#returnData').html();
		$('#returnData').html(returnData+"<br>Update Complete");
		//debugging
		//printArray = "wid ="+changesC['wid']+" <br>Description="+changesC['description']+" <br>Visible="+changesC['visible']+" <br>Order="+changesC['order']+" <br>DisplayType="+changesC['displayType']+"<br>\n";
		//$('#returnData').html(printArray);
	}
	$("#popUpInformation").dialog({
		autoOpen: false,
		modal: true,
		beforeClose: function(){
			$(this).dialog("option", "buttons", null);
		}
	});

//functions brought over from QuoteBuilder qb.js

function stateChanged_qb() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		alert("[x"+xmlHttp.responseText+"]");//
		if(xmlHttp.responseText == "go")
		{
			location.href = window.location;
			return;
		}
		else if(xmlHttp.responseText == "gotoreview")
		{
			location.href="../../get_quote.php";
			return;
		}
		else if(xmlHttp.responseText == "gotoorder")
		{
			setTimeout("goThere('?step=order'+adParam)", 500);
			//location.href="?step=order"+adParam;
			return;
		}
		else if(xmlHttp.responseText == "gotoq")
		{
			setTimeout("goThere('?step=review'+adParam)", 500);
			//location.href="?step=review"+adParam;
			return;
		}
		else if(xmlHttp.responseText == "gotoq_google")
		{
			setTimeout("goThere('?step=review&gad=1'+adParam)", 500);
			//location.href="?step=review&gad=1"+adParam;
			return;
		}
		else if(xmlHttp.responseText == "newquote")
		{
			setTimeout("goThere('?step=netpbx')", 500);
			//location.href="?step=netpbx";
			return;
		}
		else if(xmlHttp.responseText == "signedin")
		{
			setTimeout("goThere('?step=order'+adParam)", 500);
			//location.href="?step=order"+adParam;
			return;
		}
		else if(xmlHttp.responseText.indexOf("cssagentordered") > -1)
		{
			stateChangedObj_qb = "qb_main";
			document.getElementById("order_box").style.display = "none";
			document.getElementById("options").style.display = "none";
			document.getElementById("nav_table").style.display = "none";
			document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
			return;
		}
		else if(xmlHttp.responseText.indexOf("CBEYSAVED") > -1)
		{
			document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
			setTimeout("getOptionsBox()", 500);
		}
		else if(xmlHttp.responseText.indexOf("channel_list") > -1)
		{
			document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
			setTimeout("getTotals(_confirm)", 500);
		}
		else if(xmlHttp.responseText.indexOf("PACKAGELIST") > -1)
		{
			document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
			setTimeout("getTotals(_confirm)", 500);
		}
		else if(stateChangedObj_qb == 'dedicated_options')
		{
			document.getElementById(stateChangedObj_qb).innerHTML=xmlHttp.responseText;
			setTimeout("getTotals()", 1000);
		}
		else if(stateChangedObj_qb == 'whatsthis_inner')
		{
			document.getElementById(stateChangedObj_qb).innerHTML=xmlHttp.responseText;
			document.getElementById("whatsthis").style.display = "block";
		}
		else if(stateChangedObj_qb == 'addons')
		{
			_confirm = 1;
			document.getElementById(stateChangedObj_qb).innerHTML=xmlHttp.responseText;
			setOptionsDisplay();
			setTimeout("getTotals(_confirm)", 500);
		}
		else if(stateChangedObj_qb == 'dedicated_cost')
		{
			document.getElementById(stateChangedObj_qb).innerHTML=xmlHttp.responseText;
			setTimeout("getTotals()", 500);
		}
		else if(stateChangedObj_qb == 'ha_monthly' || stateChangedObj_qb == 'backup_monthly')
		{
			document.getElementById(stateChangedObj_qb).innerHTML=xmlHttp.responseText;
			setTimeout("getDedicatedCost()", 500);
		}
		else if(stateChangedObj_qb == 'process')
		{
			//alert("[x"+xmlHttp.responseText+"]");
			if(xmlHttp.responseText.indexOf("Terms of Service") > -1 || xmlHttp.responseText.indexOf("Error") > -1)
			{
				document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
				document.getElementById("process_button").value = "Confirm Order";
				document.getElementById("process_button").disabled = false;
			}
			else if(xmlHttp.responseText == "processed")
			{
				//setTimeout("orderProcessed()", 500);
				location.href="?processed=1"+adParam;
				return;
			}
			else if(xmlHttp.responseText.indexOf("SPINIT") > -1)
			{
				document.getElementById("qb_main").innerHTML = "";
				document.getElementById("order_box").style.display = "none";
				document.getElementById("options").style.display = "none";
				document.getElementById("nav_table").style.display = "none";
				var tmp = xmlHttp.responseText.split(",");
				if(tmp[1] == 1)
				{
					migrate(tmp[3], tmp[2]);
				}
				else
				{
					showProgress(tmp[2],tmp[4],tmp[5]);
					spinup(tmp[3]);
				}
				return;
			}
			else if(xmlHttp.responseText.indexOf("pro_processed") > -1)
			{
				setVars(xmlHttp.responseText);
			}
			else
			{
				document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
				document.getElementById("order_box").style.display = "block";
				document.getElementById("options").style.display = "block";
				document.getElementById("nav_table").style.display = "block";
				document.getElementById("process_button").value = "Confirm Order";
				document.getElementById("process_button").disabled = false;
			}
		}
		else if(xmlHttp.responseText.indexOf("pro_processed") > -1)
		{
			setVars(xmlHttp.responseText);
		}
		else
		{
			document.getElementById(stateChangedObj_qb).innerHTML = xmlHttp.responseText;
			if(xmlHttp.responseText.indexOf("SHOWORDERNOW") > -1)
			{
				getOptionsBox();
			}
			else if(xmlHttp.responseText == "signedin")
			{
				//confirmOrder();
				location.href="?step=order"+adParam;
				return;
			}
			else if(xmlHttp.responseText == "nocc")
			{
				getSignUp("billing", 1);
			}
		}

		if(stateChangedObj_qb.indexOf("qb_cart_") > -1)
		{
			setTimeout("allTotals()", 500);
		}

		//if(stateChangedObj_qb == "qb_main" || stateChangedObj_qb == "order_resp" || stateChangedObj_qb == "options" || stateChangedObj_qb == "saveBox")
		//{
			setTimeout("dofocus()", 1000);
		//}
	}
}

function dofocus()
{
	if(document.getElementById('firstname_service'))
	{
		var c = document.getElementById("country_service").value;
		countrySet_service(c);
		document.getElementById('firstname_service').focus();
	}
	else if(document.getElementById('firstname_billing'))
	{
		var c = document.getElementById("country_billing").value;
		countrySet_billing(c);
		document.getElementById('firstname_billing').focus();
	}
	else if(document.getElementById('username_qb'))
	{
		document.getElementById('username_qb').focus();
	}
	else if(document.getElementById('save_username'))
	{
		//document.getElementById('save_username').focus();
	}
	else if(document.getElementById('save_p'))
	{
		document.getElementById('save_p').focus();
	}
	else if(document.getElementById('save_firstname'))
	{
		document.getElementById('save_firstname').focus();
	}
	else if(document.getElementById('quote_note'))
	{
		document.getElementById('quote_note').focus();
	}
	return true;
}