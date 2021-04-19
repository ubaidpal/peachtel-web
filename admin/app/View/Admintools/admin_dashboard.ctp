<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
//$cdetail = $clientDetails[0];
//print_r($cdetail['address1']);exit;
?>
<style>
.box li {
    list-style: square !important;
}
</style>

<div id="content">	
    <div id="contentHeader">
        <h1>Dashboard</h1>
    </div> <!-- #contentHeader -->
    <div class="container">

        <div class="grid-16"><!-- left side of the contentss 2/3rd of the container-->
            <div class="box">
                <h3>Admin Tools</h3>
                <ul style="margin-bottom: 0px;">
                    <li><a href="accounts/new_account"> Create New Account</a></li>
                    <li><a href="accounts/new_customers"> New Customers</a></li>
                    <li><a href="orders/cnam_lookup"> OpenCnam</a></li>
                    <li><a href="orders/pending_orders"> Pending Orders</a></li>
                    <li><a href="servers/port"> Port Requests</a></li>
                    <li><a href="accounts/sale_agents"> Sales Agents</a></li>
                    <li><a href="servers/inventory"> Server Inventory</a></li>
                    <li><a href="servers/trunking"> Trunking Packages</a></li>
                    <li><a href="private_functions/itaki_network_product"> Prestashop Import</a></li>
                    <li><a href="quotes/admin"> Quotes</a></li>
                </ul>
            </div>
            <div class="box">
                <h3>Reports</h3>
                <ul type="circle" style="margin-bottom: 0px;">
                    <li><a href="activities/activity_log"> Admin Activity</a></li>
                    <li><a href="reports/client_list"> Client List</a></li>
                    <li><a href="reports/e911_calls"> E911 Calls</a></li>
                    <li><a href="reports/tax_report"> FCC - USF</a></li>
                    <li><a href="reports/adwords"> Google Ad Words</a></li>
                    <li><a href="reports/revenue_report"> Revenue</a></li>
                    <li><a href="reports/agent_report"> Sales Agent</a></li>
                </ul>
            </div>
        </div><!-- .grid-16 -->

        <div class="grid-8"><!-- right side of the contentss 1/3rd of the container-->
            <div class="box">
                <div class="loader" style="position: absolute; width: 339px; height: 219px; text-align: center;display:none;">
                    <img src="./images/loaders/indicator-big.gif" alt="Loading..." style="position: relative;top: 46%;left:-14;z-index: 1"/>
                </div><!--loader-->
                <?php if ($flashM !== "") { ?>
                    <div class="notify notify-error">

                        <a href="javascript:;" class="close">×</a>

                        <h3>Please Check Your Input</h3>

                        <p><?php echo $flashM; ?></p>
                    </div>
                <?php } ?>
                <font style="color:red"> <?php $this->Session->flash(); ?></font>
                <h2 style="font-size: 26px;">Search A Client Account</h2>
                <?php echo $this->Form->create("admintools", array('id' => 'srch', 'action' => 'billing', 'div' => false, 'onsubmitt' => 'return validate(event)')); ?>
                <h4>Select A Criteria :</h4>​
                <div class="selector" id="uniform-cardtype"> <span id="upper_5" style="-moz-user-select: none;"> Email</span>
                    <select name="accIdentifier" onchange="emptyInput()" style="margin-left: 3px;" id="sf">
                        <option value="email">Email</option>
                        <option value="id">Account ID</option>
                         <!--<option value="comname">Company Name</option>-->
                         <!--<option value="CTID/Hostname">CTID/Hostname</option>-->
                         <!--<option value="DIDNumber">DID Number</option>-->
                         <!--<option value="LastName">Last Name</option>-->
                         <!--<option value="TrunkID">Trunk ID</option>-->
                         <!--<option value="Quote">Quote</option>-->
                    </select></div></br></br>
                <h4>Enter Value :</h4>​
                <div style="margin-top: -20px; margin-left: 2px;   width: 240px; height: auto; position: absolute; ">                    
                    <input type="text" name="query" placeholder="Search..."  onkeyuup="searchItem(this.value)" id="sr_inp" style="width:195px;border-radius:8px" autocomplete='off'/>
                    <div id="searchedItems">

                    </div>
                </div>
                </br></br>
                <?php
                echo $this->form->button('Go', array('type' => 'submit', 'div' => false, 'class' => 'btn btn-teal grid-12', "style" => "left: 1%;", 'id' => 'submitbutton'));
                ?>  
            </div><!--box-->
        </div><!--grid-->
    </div> <!-- .container -->
</div> <!-- #content -->
<script type="text/javascript">
    $('#submitbutton').click(function(){
        $('.loader').attr('style','position: absolute; width: 339px; height: 219px; text-align: center; display:compact;');
        //alert($('.loader').attr('style'));
    });
    document.getElementById('sr_inp').addEventListener('keyup',searchItem);
    var combo=document.getElementById('searchedItems');
    function validate(e){
        alert('asdf');
        e = e || event;
        if(e.keyCode==13) {return false;}
        else
        {alert('"'+document.getElementById('sf').options[document.getElementById('sf').selectedIndex].value+'"');
            var regx=/^[a-z0-9\.]*@[a-z0-9]+\.[a-z]{2,3}$/;
            if(!regx.test(document.getElementById('sr_inp').value&&document.getElementById('sf').options[document.getElementById('sf').selectedIndex].value==='email')){
                alert('invalid email');
                return false;
            }
        }

    }
    function checkEnter(e){
        e = e || event;
        alert(e.keyCode+" sdf"); return;
        return (e.keyCode || event.which || event.charCode || 0) !== 13;
    }  
    function emptyInput(){
        document.getElementById('sr_inp').value="";
        combo.innerHTML="";
        document.getElementById('upper_5').innerHTML=$('#sf').find('option:selected').text();
    }
    
    function setInput(item){
        var input=document.getElementById('sr_inp');
        input.value=item.innerHTML;
        combo.innerHTML="";
        
        //input.focus();
    }  
    var xhr;
    function searchItem(e){
        e = e || event;        
        //console.log(value=$('#sr_inp').val());
        if(e.keyCode==16||e.keyCode==13)return false; //if shift is pressed
        //alert(e.keyCode); return;
        value=$('#sr_inp').val();
        combo.innerHTML="";
        column=document.getElementById('sf').options[document.getElementById('sf').selectedIndex].value;
        if(value==""){
            return;
        }
        if(xhr && xhr.readyState != 4){
            xhr.abort();
        }
        xhr=jQuery.ajax({
            url:"<?php echo $this->base ?>/admintools/ajaxSearch/",
            data:{
                column:column,
                value:value
            },
            success: function(response){
                console.log(response);
                var len=0;
                if(response!='no data'){
                    var data=JSON.parse(response),i=0;
                    //console.log(data, response);
                    while(data[i]){
                        //console.log(response);
                        //console.log(data[i],i);
                        if(data[i][column].length>len){
                            len=data[i][column].length; 
                        }
                        var item = document.createElement("div");//create new option
                        var text = document.createTextNode(data[i][column]);//set option display text
                        item.appendChild(text);
                        //item.setAttribute("class","item_inactive");
                        //item.setAttribute("onmouseover","activate(this);");
                        //item.setAttribute("onmouseout","deactivate(this);");
                        item.setAttribute("onClick","setInput(this);");
                        item.setAttribute("id","i"+i);
                        combo.appendChild(item);//add created option to select box.
                        i++;
                    }
                    len=len*7+10;
                    if(len<240){
                        combo.setAttribute('style','z-index:2; width:240px'); 
                    }
                    else{
                        combo.setAttribute('style','z-index:2; width:'+len+"px");                        
                    }
                }
            },
            failure: function(){
                alert('connect to network');
            }
        });
    }
</script>