<link rel="stylesheet" href="/prestashop/modules/itakitrunking/css/style.css" type="text/css">
<script>
    $(function(){
        $("#trunking_tabs ul li a").click(function(){
            var tab = $(this).attr("href");

            $("#trunking_tabs ul li").attr("class", "");
            $(this).parent().attr("class", "active");

            $("#trunking_tabs div").attr("class", "");
            $(tab).attr("class", "selected");

            return false;
        });
    });
</script>

<div class="block">
    <div id="trunking_tabs">
        <ul>
            <li class="active"><a href="#tabs-1">Billing</a></li>
            <li><a href="#tabs-2">PBX</a></li>
            <li><a href="#tabs-3">Provisioning</a></li>
            <li><a href="#tabs-4">Store</a></li>
            <li><a href="#tabs-5">Support</a></li>
            <li><a href="#tabs-6">Quotes</a></li>
        </ul>
        <div id="tabs-1" class="selected">
            <h4 style="color: #fff;">General Info</h4>
            <br />
            <p>Account Balance: {$userData.WHMCSAPI.STATS.CREDITBALANCE}</p>
            <p>Auto Replenish is set to : On</p>
            <p>Payment Methods is <label style="color: blue;">{$userData.WHMCSAPI.CLIENT.CCTYPE}</label> ending in {$userData.WHMCSAPI.CLIENT.CCLASTFOUR} expiring N/A</p>
            <p>Make a Payment of $100</p>
            
            <hr />
            <br />
            
            <h4 style="color: #fff;">Billing Address</h4>
            <br />
            <p>Address 1: {$userData.WHMCSAPI.CLIENT.ADDRESS1}</p>
            <p>Address 2: {$userData.WHMCSAPI.CLIENT.ADDRESS2}</p>
            <p>City: {$userData.WHMCSAPI.CLIENT.CITY}</p>
            <p>State: {$userData.WHMCSAPI.CLIENT.STATE}</p>
            <p>Postcode: {$userData.WHMCSAPI.CLIENT.POSTCODE}</p>
            <p>Country: {$userData.WHMCSAPI.CLIENT.COUNTRYNAME}</p>
            <p>Phonenumber: {$userData.WHMCSAPI.CLIENT.PHONENUMBER}</p>
        </div>
        
        <div id="tabs-2">2</div>
        <div id="tabs-3">3</div>
        <div id="tabs-4">4</div>
        <div id="tabs-5">5</div>
        <div id="tabs-6">6</div>
    </div>
</div>