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


<div id="content">	
    <div id="contentHeader">
        <h1>Dashboard</h1>
    </div> <!-- #contentHeader -->
    <div class="container">

        <div class="grid-16"><!-- left side of the contentss 2/3rd of the container-->
            <div class="box">
                <h3>Admin Tools</h3>
                <ul>
                    <li><a href="#"> Create New Account</a></li>
                    <li><a href="#"> New Customers</a></li>
                    <li><a href="#"> Pending Orders</a></li>
                    <li><a href="#"> Port Requests</a></li>
                    <li><a href="#"> Sales Agents</a></li>
                    <li><a href="#"> Server Inventory</a></li>
                    <li><a href="#"> Trunking Packages</a></li>
                </ul>
            </div>
            <div class="box">
                <h3>Reports</h3>
                <ul type="circle">
                    <li><a href="#"> Admin Activity</a></li>
                    <li><a href="#"> Client List</a></li>
                    <li><a href="#"> Sales Agent</a></li>
                    <li><a href="#"> Revenue</a></li>
                    <li><a href="#"> CSRP Carrier</a></li>
                    <li><a href="#"> FCC - USF Cron</a></li>
                    <li><a href="#"> Store Revenue</a></li>
                    <li><a href="#"> E911 Calls</a></li>
                    <li><a href="#"> Google Ad Words</a></li>
                </ul>
            </div>

        </div><!-- .grid-16 -->

        <div class="grid-8"><!-- right side of the contentss 1/3rd of the container-->
            <div class="box">
                <h2>Search A Client Account</h2>
                <?php echo $this->Form->create('admintool', array('action' => 'billing'), array('div' => false, 'submitonaction' => 'false')); ?>
                <h4>Select A Criteria :</h4>​
                <select name="accIdentifier"  style="margin-left: 25%;" id="sf">
                    <option value="id">Account ID</option>
                    <option value="comname">Company Name</option>
                    <option value="CTID/Hostname">CTID/Hostname</option>
                    <option value="DIDNumber">DID Number</option>
                    <option value="email">Email</option>
                    <option value="LastName">Last Name</option>
                    <option value="TrunkID">Trunk ID</option>
                    <option value="Quote">Quote</option>
                </select></br></br>
                <h4>Enter Value :</h4>​
                <div style="margin-top: -20px; margin-left: 85px;   width: 150px; height: auto; position: absolute; ">                    
                    <input type="text" name="query" placeholder="Search..."  onkeyup="searchItem(this)" id="sr_inp" style="width:100%;"/>
                    <div id="searchedItems">

                    </div>
                </div>
                </br></br>
                <?php
                echo $this->form->button('Go', array('type' => 'submit', 'div' => false, 'class' => 'btn btn-teal grid-12', "style" => "left: 57%;"));
                ?>  
            </div><!--box-->
        </div><!--grid-->
    </div> <!-- .container -->
</div> <!-- #content -->
<script type="text/javascript">
    var combo=document.getElementById('searchedItems');
    function searchItem(input){
        column=document.getElementById('sf').options[document.getElementById('sf').selectedIndex].value;
        if(combo.children.length!=0){
            //alert('df');
            for(var index=0; index<combo.children.length; combo.removeChild(document.getElementById('i'+index++)));                
        } 
        if(input.value==""){
            if(combo.children.length!=0){
                //alert('df');
                for(var index=0; index<combo.children.length; combo.removeChild(document.getElementById('i'+index++)));                
            } 
            return;
        }
        jQuery.ajax({
            url:"<?php echo $this->base ?>/admintools/ajaxSearch",
            data:{
                column:column,
                value:input.value
            },
            success: function(response){
                if(response!='no data'){
                    var data=JSON.parse(response),i=0;
                    while(data[i]){;
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
                    combo.setAttribute('style','z-index:2');
                }
            },
            failure: function(){
                alert('plz connect to internet');
            }
        });
    }
</script>