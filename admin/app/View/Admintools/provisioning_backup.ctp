<?php
//debug($bolPhonesProvisioned);
//debug($mac_id_add_ext_host);
//debug($global_for_each_mac);
//debug($host_address);
//exit;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//debug($devceBrand);
//foreach ($devceBrand as $db):
//    debug($db['brandmodels']['brand']);
//endforeach;
//exit;
?>

<div id="modal" style="display:none;"><!--EDIT FORM ON Provisioning*******************************-->
    <div id="modalHeader">
        <h2>Configure your phone</h2>
        <a class="close" href="javascript:;" onClick="close_window();">×</a>
    </div>
    <div id="modalContent">
        <!--                <div id="modalLoader">
                            <img src="/img/ajax-loader.gif" alt="Loading please wait..."/>
                        </div>-->
        <form class="form" id="phone_data_form" onsubmit="return false;"> 
            <div id="main_content"  >
                <div id="div1"  class="field-group" >
                    <div id="mydiv_p"  style="text-align:center; position:absolute;right: 50%; display:none; top: 194px; z-index: 1"> 
                        <?php echo $this->Html->image('/images/loaders/indicator-big.gif'); ?><br/> Please Wait...
                    </div>
                    <table width="420" border="0" cellspacing="5" cellpadding="2">
                        <tr>
                            <td width="202" align="left">  <label>Phone:</label> </td>
                            <td width="284" align="left"> 
                                <div class="selector" id="uniform-cardtype"> <span id="upper_1" style="-moz-user-select: none;"> </span>
                                    <select name="phone_model_family" id="phone_opt" onChange="changeFormData(this.value,'change');"></select></div> </td>
                        </tr>
                        <tr>
                            <td align="left">    <label>TimeZone:</label></td>
                            <td align="left">
                                <div class="selector" id="uniform-cardtype"> <span id="time_zone_span" style="-moz-user-select: none;"></span>
                                    <select name="timezone" id="DropDownTimezone">
                                        <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
                                        <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
                                        <option value="-10.0">(GMT -10:00) Hawaii</option>
                                        <option value="-9.0">(GMT -9:00) Alaska</option>
                                        <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                                        <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                                        <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
                                        <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                                        <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                                        <option value="-3.5">(GMT -3:30) Newfoundland</option>
                                        <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                                        <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
                                        <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                                        <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                                        <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
                                        <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                                        <option value="3.5">(GMT +3:30) Tehran</option>
                                        <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                                        <option value="4.5">(GMT +4:30) Kabul</option>
                                        <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                                        <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                                        <option value="5.75">(GMT +5:45) Kathmandu</option>
                                        <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                                        <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                                        <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                                        <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                                        <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
                                        <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                                        <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                                        <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                                    </select></div>
                            </td>   

                        </tr>
                        <tr>
                            <td align="left"> <label>MAC Address:</label> </td>
                            <td align="left"><span id="mac_add" class='ticket'>macaddress</span></td>
                        </tr>

                        <tr>
                            <td align="left">  <label>Local Port:</label></td>
                            <td align="left">
                                <input type="text" name="localport" id="local_port" /></td>
                        </tr>
                        <tr>
                            <td width="22%"> <label>Registrations:</label>
                            <td width="78%" >
                                <div class="selector" id="uniform-cardtype"> <span id="upper_6" style="-moz-user-select: none;"> 1</span>
                                    <select name="registrations" id="registrations" onChange="addFields(this.value,'registration')">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select></div>
                            </td>
                        </tr>
                        </tr>
                    </table>
                    <hr style="margin: 0px"></hr>
                </div>
                <div  class="field-group" id="div2">
                    <table width="420" border="0" cellspacing="2" cellpadding="2" id="reg_table">
                        <tbody id="show_registrations"> 
                            <tr>
                                <td width="30%"><label>Registration:</label></td>
                                <td width="70%"> <span id='reg_num1'></span></td>
                            </tr>
                            <tr>
                                <td align="left"><label>Extension:</label></td>
                                <td align="left">
                                    <input type="text" name="extension" id="extension1" /></td>
                            </tr>

                            <tr>
                                <td align="left"><label>Password:</label></td>
                                <td align="left">
                                    <input type="text" name="pass" id="pass1" /></td>
                            </tr>
                            <tr>
                                <td align="left">  <label>Appearances:</label></td>
                                <td align="left">
                                    <input type="text" name="appearances" id="appearances1" /></td>
                            </tr>
                            <tr >
                                <td align="left">  <label>Server Address:</label></td>
                                <td align="left">
                                    <input type="text" name="server_address" id="server_address1" /></td>
                            </tr>
    <!--                        <tr>
                                <td align="left"> <label>Line key:</label></td>
                                <td align="left">
                                    <select name="line_key" id="line_key" onchange="changeDetailsBelow(this.selectedIndex);" style="min-width: 70px">
                                    </select>
                            </tr>-->
    <!--                        <tr>
                                <td align="left"><label>Lable:</label></td>
                                <td align="left">
                                    <input type="text" name="label" id="label" /></td>
                            </tr>-->
    <!--                        <tr>
                                <td align="left"><label>User ID:</label></td>
                                <td align="left">
                                    <input type="text" name="userid" id="userid" /></td>
                            </tr>-->
                        </tbody>
                    </table>
                    <div style="text-align: right;margin-top: 2px ">
                        <input type="hidden" name="hidden_mac_id" id="hidden_mac_id" />
                        <input type="hidden" name="hidden_json_length" id="hidden_json_length" />
                        <input type="button" name="reset" id="reset" value="Cancel" style="color: red" onClick="close_window()"/>
                        <input type="button" name="submit" id="submit" value="Submit Configuration" onclick="send_detailed_data('submit');"/>  
                    </div>

                </div>
            </div></form>
    </div>
</div><!-- .modelcontent-->
<div id="overlay" style="display: none"></div>
<div id="content">	
    <div id="contentHeader">
        <h1>Provisioning</h1>
    </div> <!-- #contentHeader -->
    <div class="container">


        <!--  <div>
         </div>-->
        <div class="grid-16">
            <div class="box">
                <div class="widget">

                    <div class="widget-header">
                        <h3 class="icon aperture">Provisioned Devices</h3>
                    </div> <!-- .widget-header -->

                    <div class="widget-content" id="provisioned_phones">
                        <?php
                        if ($bolPhonesProvisioned) {
                            $mac_count = 0;
                            $response = "";
                            foreach ($global_for_each_mac as $globaldata)://$mac_id_add_ext_host[$mac_count]["id"]
                                $response.='<div id="phone' . $mac_count . '"><span onclick="deleteDeviceWithSerl(\'' . $mac_count . '\')" id="del' . $mac_count . '" style="cursor: pointer;" class="icon-trash-fill"></span>&nbsp&nbsp&nbsp<span onclick="show_window(\'' . $mac_count . '\');" id="edit' . $mac_count . '" class="icon-pen-alt2" style="cursor: pointer;"> </span> &nbsp&nbsp&nbsp<span id="text' . $mac_count . '">'
                                        . $globaldata['Brand'] . " " . $globaldata['FriendlyName'] . ' - MAC Address: ' . $mac_id_add_ext_host[$mac_count]["MacId"] . '</span> - Ext: <span id="ext' . $mac_count . '">' . $mac_id_add_ext_host[$mac_count]["ExtensionNumber"] . '</span> on <span id="host' . $mac_count . '">' . $mac_id_add_ext_host[$mac_count++]["Host"] . '</span></div>';
                            endforeach;
                            echo $response;
                        }
                        else
                            echo 'No Devices Provisioned Yet.';
                        ?>
                    </div> <!-- .widget-content -->

                </div>
            </div>
        </div><!--.Grid 6-->
        <div class="grid-8">
            <div class="box form">
                <!---provvv-->
                <div class="widget">

                    <div class="widget-header">
                        <span class="icon-article"></span>
                        <h3>Provision a new Device</h3>
                    </div> <!-- .widget-header -->

                    <div class="widget-content">
                        <div id="grid-12" style=""> 
                            <div id="mydiv_g"  style="text-align:center; position:absolute;right: 40%; display: none; top: 37%;z-index: 1"> 
                                <?php echo $this->Html->image('/images/loaders/indicator-big.gif'); ?><br/> 
                            </div>
                            <div class="field-group">
                                <label for="brandname">Select Brand Name:</label>
                                <div class="field" >
                                    <div class="selector" id="uniform-cardtype">
                                        <span id="upper" style="-moz-user-select: none;"> 
                                            <?php echo $devceBrand[0]['brandmodels']['brand']; ?></span> 
                                        <select id="brandname" enabled="false" name="cardtype" style="opacity: 0;" onchange="getFriendlyNames()">
                                            <?php foreach ($devceBrand as $db):    //debug($db['brandmodels']['brand']);?>
                                                <option><?php echo $db['brandmodels']['brand'] ?></option><?php endforeach; ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field-group">
                                <label for="frendlyname">Select Product: <img src='../images/loaders/facebook.gif' alt = 'Loading...' id = 'fr_lodr' style = 'display: none'/></label>
                                <div class="field" id="fr_name">
                                    <div class="selector" id="uniform-cardtype"><span id="upper2" style="-moz-user-select: none;"> <?php echo $frendlyname[1]; ?></span>   
                                        <?php echo $this->Form->input('frendlyname', array('label' => FALSE, 'options' => $frendlyname, 'div' => false, 'id' => 'frendlyname')); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="field-group">
                                <label for="required">Enter Mac Address:</label>
                                <div class="field">
                                    <input type="text" name="macid" id="required" size="20" maxlength="12" class="validate[required]" >	
                                </div>
                            </div>

                            <div class="field-group" style='text-align: right'>		
                                <button class="btn btn-grey btn-teal" onclick="savePhone()" id="sav_btn">Go</button>		
                            </div> <!-- .field-group -->


                        </div> <!-- .widget-content -->

                    </div>
                </div>
            </div>
        </div><!--.Grid 7-->
    </div><!--EDIT FORM ON Provisioning*******************************-->
    <div id="mydiv2_delete"  style="text-align:center;  display: none; position:absolute;right: 66%;top: 226px"> 
        <?php echo $this->Html->image('/images/loaders/indicator-big.gif'); ?>
        <br/> Please Wait...</div>
</div> <!-- .container -->
</div> <!-- #content -->
<div id="alert" style="display: none">
    <div id="alertContent">
        <h2>Alert</h2>
        <p>Are you sure your want to delete configuration?</p>
        <div id="alertActions">
            <input type="hidden" id="serial_num"/>
            <button class="btn btn-small btn-primary" id="conformly_delete">Confirm</button>
            <button class="btn btn-small btn-quaternary" id="hide_alert">Cancel</button>
        </div>
    </div>
    <a class="close" href="javascript:;">×</a>
</div>
<script type="text/javascript">
    $('#DropDownTimezone').change(function(){
        $('#time_zone_span').text(this.options[this.selectedIndex].text);
    });
    $('#frendlyname').change(function (){
        $('#upper2').text(document.getElementById('frendlyname').options[document.getElementById('frendlyname').selectedIndex].text);
    });
    $('#brandname').bind('change',function (){
        $('#upper').text(this.value);
        
    });
    $('#hide_alert').click(function(){
        $('#overlay').hide();
        $('#alert').hide();
    });
    $('#conformly_delete').click(function(){
        //$("select#phone_opt option[text='"+"polycom 430"+"']").remove(); return;
        $('#overlay').hide();
        $('#alert').hide();
        var sr_num=$('#serial_num').val();
        //alert(globalPhoneDetail.length);
        //$('#phone'+sr_num).remove();//return;
        //console.log(globalPhoneDetail.length);
        //var new_json=[];
        // var new_json_2=[];
        // console.log(globalPhoneDetail[sr_num],macids_ext_host[sr_num],'iiiiiiiiiiii');
        // for(var i=0;i<globalPhoneDetail.length;i++)
        //{
        //if(i==sr_num)continue;
        // new_json=new_json.concat(globalPhoneDetail[i]);
        // new_json_2=new_json_2.concat(macids_ext_host[i]);
        // }
        // macids_ext_host=new_json_2;
        //globalPhoneDetail=new_json;
        //console.log(globalPhoneDetail[sr_num],macids_ext_host[sr_num],'33333333333');
        //console.log(globalPhoneDetail.length);return;
        jQuery.ajax({
            type:'POST',
            dataType:'text',
            url:"<?php echo $this->base ?>/admintools/deleteDeviceWithMacId",
            beforeSend: function(){
                // Handle the beforeSend event
                $('#mydiv2_delete').show();
      
            },
            data:{
                mac_id: macids_ext_host[sr_num].id
            },
            success: function(response){ 
                $('#mydiv2_delete').hide();
                $('#phone'+sr_num).remove();
                globalPhoneDetail[sr_num].Brand="";
                globalPhoneDetail[sr_num].FriendlyName="";
                macids_ext_host[sr_num].ExtensionNumber="";
                macids_ext_host[sr_num].Host="";
                //document.getElementById('phone_opt').add(option)
                if(document.getElementById('provisioned_phones').childElementCount==0){
                    document.getElementById('provisioned_phones').innerHTML="All Devices Deleted.";
                    macids_ext_host=globalPhoneDetail="";
                }
                //alert(response);
            },
            failure: function(){
                alert('can not do it');
            }
        });
    });
    function deleteDeviceWithSerl(sr_num){
        $('#serial_num').val(sr_num);
        $('#overlay').show();
        $('#alert').show();
        //alert(mac_id);
    }
    //document.getElementById('registrations').addEventListener('onchange',addFields(this.value),false);
    var jsonPhoneDetails="";//got through AJAX below**************
    function checkToDelete(new_number){ //called below
        var old_reg=globalPhoneDetail[document.getElementById('phone_opt').value].Registrations;
        var new_reg=new_number;
        if(new_reg<old_reg||(new_reg==1&&old_reg>0)){
            
            //alert(globalPhoneDetail[document.getElementById('phone_opt').selectedIndex].MacId);return;
            new_reg=0;
            // if(new_reg==1&&old_reg>=1){
                
            // }
            // else {
            //    new_reg=new_number;
            // }
            //delete specified buttons
            //            jQuery.ajax({
            //                type:'POST',
            //                dataType:'json',
            //                url:"<-?php echo $this->base ?>/admintools/deleteDetailsOfMacId",
            //                data:{
            //                    old_registrations:old_reg,
            //                    new_registrations:new_reg,
            //                    mac_id:globalPhoneDetail[document.getElementById('phone_opt').selectedIndex].MacId
            //                },
            //                success: function(response){
            //                    if(response.success){
            //                        globalPhoneDetail[document.getElementById('phone_opt').selectedIndex].Registrations=new_reg;
            //                        //if(new_number==1){
            //                        //alert('delete from '+old_reg+" to "+new_reg); 
            jsonPhoneDetails="";
            $('#hidden_json_length').val("changed");
            for(var i=new_number;i>0;i--){
                //console.log(i);
                if(i!=1)
                    document.getElementById('reg_num'+i).innerHTML="";  
                document.getElementById('extension'+i).value="";
                document.getElementById('pass'+i).value="";
                document.getElementById('server_address'+i).value="";
                document.getElementById('appearances'+i).value="";
                           
            }
                         
            //}
            //else {
            //
            // jsonPhoneDetails[i]="";
            //}
            //}
            //}
            //  },
            // failure: function(){
            //alert('can not do it. you may not be on network.');
            // }
            // });
        }
    }
    function addFields(new_number,source){  
        $('#upper_6').text(new_number);
        var total_items=document.getElementById('show_registrations').childElementCount;
        var already_present=(total_items+1)/6;
        if(source=="registration"){
            checkToDelete(new_number);
        }
        if(new_number>already_present){
            for(var i=already_present+1; i<=new_number;i++){
                //alert(i);
                var blankrow=document.createElement('tr');
                blankrow.innerHTML='<label style="height:15px"></label>';
                document.getElementById('show_registrations').appendChild(blankrow);
                //alert(i+" ex nu = "+);
               
                //first td
                var row1=document.createElement('tr');
                var col1=document.createElement('td');
                col1.attributes['align']='left';
                col1.innerHTML='<label>Registration:</label>';
                         
                var col2=document.createElement('td');
                col2.innerHTML='<span id="reg_num'+(i)+'">'+(i)+'</span>';
                col2.attributes['align']='left';
           
                row1.appendChild(col1);
                row1.appendChild(col2);
                
                document.getElementById('show_registrations').appendChild(row1);
            
                //second td
                var row2=document.createElement('tr');
                var col1=document.createElement('td');
                col1.attributes['align']='left';
                col1.innerHTML='<label>Extension:</label>';
                         
                var col2=document.createElement('td');
                col2.innerHTML='<input type="text" name="extension" id="extension'+i+'"/>';
                col2.attributes['align']='left';
           
                row2.appendChild(col1);
                row2.appendChild(col2);
            
                document.getElementById('show_registrations').appendChild(row2);
                //third td
                var row3=document.createElement('tr');
                var col1=document.createElement('td');
                col1.attributes['align']='left';
                col1.innerHTML='<label>Password:</label>';
                         
                var col2=document.createElement('td');
                col2.innerHTML=' <input type="text" name="pass" id="pass'+i+'"/>';
                col2.attributes['align']='left';
           
                row3.appendChild(col1);
                row3.appendChild(col2);
            
                document.getElementById('show_registrations').appendChild(row3);
                //fourth td
                var row4=document.createElement('tr');
                var col1=document.createElement('td');
                col1.attributes['align']='left';
                col1.innerHTML='<label>Appearances:</label>';
                         
                var col2=document.createElement('td');
                col2.innerHTML='<input type="text" name="appearances" id="appearances'+i+'"/>';
                col2.attributes['align']='left';
           
                row4.appendChild(col1);
                row4.appendChild(col2);
            
                document.getElementById('show_registrations').appendChild(row4);
                //fifth td
                var row5=document.createElement('tr');
                var col1=document.createElement('td');
                col1.attributes['align']='left';
                col1.innerHTML='<label>Server Address:</label>';
                         
                var col2=document.createElement('td');
                col2.innerHTML='<input type="text" name="server_address" id="server_address'+i+'"/>';
                col2.attributes['align']='left';
                col2.appendChild(document.createElement('br'));
                row5.appendChild(col1);
                row5.appendChild(col2);
                //alert(row1);
                document.getElementById('show_registrations').appendChild(row5);
            }
            
        }
        else  //remove fields that are not in use
        {
            for(var endIndex=total_items-1;endIndex>=(new_number*6)-1;endIndex--)
                document.getElementById('show_registrations').deleteRow(endIndex);
        }
        populatePresentFields(new_number); //add data to fields created****************
    }
    function populatePresentFields(num_of_fields){
        //alert(num_of_fields);
        // Apperances=,ExtensionNumber=,
        //Host=,Secret=;
        //console.log(jsonPhoneDetails[i],'lllllllllllllllllllleeeeeeeeeee');
        //alert(jsonPhoneDetails[num_of_fields]);
        if(jsonPhoneDetails[num_of_fields]){
            for(i=1;i<=num_of_fields;i++){
                document.getElementById('reg_num'+i).innerHTML=i;  
                document.getElementById('extension'+i).value=jsonPhoneDetails[i].ExtensionNumber;
                document.getElementById('pass'+i).value=jsonPhoneDetails[i].Secret;
                document.getElementById('server_address'+i).value=jsonPhoneDetails[i].Host;
                document.getElementById('appearances'+i).value=jsonPhoneDetails[i].Apperances;
            }
        }
    }
    var globalPhoneDetail=
<?php
if ($bolPhonesProvisioned)
    echo json_encode($global_for_each_mac);
else
    echo '""';
?>;
    var macids_ext_host=
<?php
if ($bolPhonesProvisioned)
    echo json_encode($mac_id_add_ext_host);
else
    echo '""';
?>;
    function send_detailed_data(source){
        //alert(document.getElementById('hidden_mac_id').value);return;
        
        var num_of_reg=document.getElementById('registrations').value;
        var index_of_local_data_to_change=document.getElementById('phone_opt').value;
        //alert(globalPhoneDetail[index_of_local_data_to_change].Registrations+" ---index "+index_of_local_data_to_change);
        
        macids_ext_host[index_of_local_data_to_change].ExtensionNumber=document.getElementById('extension1').value;
        macids_ext_host[index_of_local_data_to_change].Host=document.getElementById('server_address1').value;
        if(source=='cancel'){
            num_of_reg=0;
        }
        var g_data_to_server=[];
        var data_to_server={
            timezone: document.getElementById('DropDownTimezone').value,
            localport:document.getElementById('local_port').value,
            registrations:num_of_reg,
            mac_id: document.getElementById('hidden_mac_id').value,
            previous_reg:globalPhoneDetail[index_of_local_data_to_change].Registrations
        };
        for(var i=1; i<=num_of_reg;i++){                            
            var regnum={
                host: document.getElementById('server_address'+i).value,
                extension:document.getElementById('extension'+i).value,
                password:document.getElementById('pass'+i).value,
                appearances:document.getElementById('appearances'+i).value
            };
            data_to_server[i-1]=regnum;
        }
        jQuery.ajax({
            type:'POST',
            dataType:'json',
            url:"<?php echo $this->base ?>/admintools/saveTotalDeviceConfig",
            data:'values='+JSON.stringify(data_to_server),
            beforeSend: function(){
                // Handle the beforeSend event
                $('#mydiv_p').show();
            },
            success: function(response){
                $('#mydiv_p').hide();
                if(response.status=="success"){
                    document.getElementById('ext'+index_of_local_data_to_change).innerHTML=macids_ext_host[index_of_local_data_to_change].ExtensionNumber;
                    document.getElementById('host'+index_of_local_data_to_change).innerHTML=macids_ext_host[index_of_local_data_to_change].Host;
                    //document.getElementById('provisioned_phones').innerHTML=response
                    globalPhoneDetail[index_of_local_data_to_change].DateTimeZone=document.getElementById('DropDownTimezone').options[document.getElementById('DropDownTimezone').selectedIndex].value;
                    globalPhoneDetail[index_of_local_data_to_change].Registrations=num_of_reg;
                    globalPhoneDetail[index_of_local_data_to_change].LocalPort=document.getElementById('local_port').value;
                    $('#hidden_json_length').val('new');
                    close_window();
                    //getDataForForm(document.getElementById('hidden_mac_id').value);
                    // }    
                }
                else
                    alert(response.status);
            },
            failure: function(){
                alert('can not do it');
            }
        });
    }
    function changeFormData(selected,from){
        //console.log(globalPhoneDetail[selected]["MacID.AccountID"]);
        if(from=='init'){
            //console.log(globalPhoneDetail);return;
            var i=0;
            while(globalPhoneDetail[i]){
                if(globalPhoneDetail[i]['Brand']==""){//this index is deleted on deleting device
                    i++;
                    continue;
                } 
                var option=document.createElement('option');
                //reg_option=document.createElement('option');
                option.value=i;
                option.text=globalPhoneDetail[i]['Brand']+" "+globalPhoneDetail[i]['FriendlyName']; 
                if(i==selected){
                    option.setAttribute('selected',true);
                    document.getElementById('upper_1').innerHTML=globalPhoneDetail[i]['Brand']+" "+globalPhoneDetail[i]['FriendlyName']; 
                    //reg_option.setAttribute('selected',true);
                }
                document.getElementById('phone_opt').add(option);//option added to phone.......
               i++;
                //reg_option.text=i+1;
                //reg_option.setAttribute('selected',false);
               
            }
            document.getElementById('local_port').value=globalPhoneDetail[selected].LocalPort;
            document.getElementById('mac_add').innerHTML=macids_ext_host[selected].MacId;
            //document.getElementById('registrations').innerHTML=globalPhoneDetail[selected].Registrations;
            //document.getElementById('userid').value=globalPhoneDetail[selected]["MacID.AccountID"];
        }
        else if(from=='change'){
            document.getElementById('local_port').value=globalPhoneDetail[selected].LocalPort;
            document.getElementById('mac_add').innerHTML=macids_ext_host[selected].MacId;
            document.getElementById('upper_1').innerHTML=(document.getElementById('phone_opt')[selected].innerHTML);
            //document.getElementById('registrations').innerHTML=globalPhoneDetail[selected].Registrations;
            //document.getElementById('userid').value=globalPhoneDetail[selected]["MacID.AccountID"];
        }
        //document.getElementById('DropDownTimezone').selectedIndex=8;// by default selected index of Timezone****
        if(globalPhoneDetail[selected]["DateTimeZone"]!=""){              
            //alert(selected+"settttttttttt");
            var timezoneopts=document.getElementById('DropDownTimezone').options;
            var length=timezoneopts.length;
            var i=0;
            var avl_timzone=globalPhoneDetail[selected]["DateTimeZone"];
            while(i<length){
                if(avl_timzone==eval(timezoneopts[i].value)){
                    timezoneopts[i].selected=true;
                    $('#time_zone_span').text(timezoneopts[i].text);
                    break; //found in list...
                }
                i++;
            }
        }
        for(var i=(document.getElementById('show_registrations').childElementCount+1)/6;i>=1;i--){//clear all lower phone fields***
            //console.log(i);
            document.getElementById('reg_num'+i).innerHTML="";  
            document.getElementById('extension'+i).value="";
            document.getElementById('pass'+i).value="";
            document.getElementById('server_address'+i).value="";
            document.getElementById('appearances'+i).value="";
            //document.getElementById('line_key').innerHTML="";
        }
        getDataForForm(macids_ext_host[selected].id);
    }
    /*function getModle_Family(f_name_models){//****************************Not in use
        var arr=f_name_models.split(',');
        arr[0]=arr[0].replace(/^{/, '');
        arr[arr.length-1]=arr[arr.length-1].replace(/}$/, '');
        for(var i=0;i<arr.length;i++){
            arr[i]=arr[i].replace(/"/g, '');
            temp=arr[i].split(':');
            arr[i]=temp[1]+" "+temp[0];
        }
        return arr;
    }*/
    function close_window(){
        //console.log(jsonPhoneDetails[1].Host);
        //alert($('#hidden_json_length').val()+"  json len ="+jsonPhoneDetails)
        if($('#hidden_json_length').val()=="changed"){
            if(confirm('Do you want to save changes?')){
                send_detailed_data('cancel');
                $('#hidden_json_length').val('new'); //to be compared on window close
                return;
            }
        }
        document.getElementById('DropDownTimezone').selectedIndex=0;
        document.getElementById('phone_opt').innerHTML="";
        document.getElementById('mac_add').innerHTML="";
        //document.getElementById('registrations').innerHTML="";
        //document.getElementById('line_key').innerHTML="";
        for(var endIndex=document.getElementById('show_registrations').childElementCount-1;endIndex>=5;endIndex--)
            document.getElementById('show_registrations').deleteRow(endIndex);
        $('#modal').hide();        
        $('#overlay').hide();
    }
    function show_window(select){
    
        //alert(select);
        //return;
        $('#overlay').show();
        changeFormData(select,'init');
        $('#modal').show();
    
  
    }
    
    function changeDetailsBelow(selected){      // called for line_key NOT IN USE NOW
        alert(document.getElementById('line_key').options[selected].text);  
        if(document.getElementById('line_key').options[selected].text=="New"){
            document.getElementById('extension1').value="";
            document.getElementById('pass1').value="";
            document.getElementById('server_address1').value="";
            document.getElementById('appearances1').value="";
            document.getElementById('reg_num1').innerHTML=selected+1;
            return;
        }       
        document.getElementById('reg_num1').innerHTML=selected+1;
        document.getElementById('extension1').value=jsonPhoneDetails[selected+1].ExtensionNumber;
        document.getElementById('pass1').value=jsonPhoneDetails[selected+1].Secret;
        document.getElementById('appearances1').value=jsonPhoneDetails[selected+1].Apperances;
        document.getElementById('server_address1').value=jsonPhoneDetails[selected+1].Host;
    }
    
    function getDataForForm(mac_id){
        document.getElementById('hidden_mac_id').value=mac_id;
        //url:"<?php echo $this->base; ?>/admintools/sendPhoneInfoRelatedToEachMac",
        //alert(document.getElementById('22').macid);
        jQuery.ajax({
            type:'POST',
            url:"<?php echo $this->base; ?>/admintools/sendPhoneInfoRelatedToEachMac",            
            dataType:'json',
            data:{macid:mac_id},
            success: function(response){ 
                $('#hidden_json_length').val('new'); //to be compared on window close
                if(response.status){
                    //console.log(response.phoneDetail,'phoneeeeeeDETALLLLLLLLLLLLLLLLll');
                    jsonPhoneDetails=response.phoneDetail;
                    /* while(response.phoneDetail[i]){ USED TO INITIALIZE LINE_KEY
                        var option=document.createElement('option');
                        option.text=i++;
                        option.selected=true;
                        document.getElementById('line_key').add(option);
                    }*/
                    //console.log(response.phoneDetail[i].Apperances);
                    var i=1;
                    while(jsonPhoneDetails[i++]);//count the items in the phonedetails*****
                    --i;
                    addFields(--i,"initialize");
                    document.getElementById('registrations').selectedIndex=i-1;
                    
                }
                else{
                    jsonPhoneDetails="";
                    
                    addFields(1,"initialize");
                    document.getElementById('registrations').selectedIndex=0;
                }
                ;
                /*var option=document.createElement('option');
                option.text='New';
                document.getElementById('line_key').add(option);*/
                document.getElementById('reg_num1').innerHTML=1;
            },
            failure: function(){
                alert('can not do it');
            }
        });
    }
    function savePhone(){//*****************provision new device*********
        //alert(document.getElementById('provisioned_phones').childElementCount/3+1);
        //return;
        if (!$('#required').val().match(/^[a-zA-Z0-9]{12}/))
        {
            alert("Invalid Value");
            return false;   
        }
        jQuery.ajax({
            type:'POST',
            url:"<?php echo $this->base ?>/admintools/savePhone",
            beforeSend: function(){
                // Handle the beforeSend event
                $('#mydiv_g').show();
      
            },
            data:{
                brand:$('#brandname').val(),
                frendlyname:document.getElementById('frendlyname').options[document.getElementById('frendlyname').selectedIndex].text,
                macid:$('#required').val(),
                registrations:0//document.getElementById('provisioned_phones').childElementCount/3+1
            },
            dataType:'json',
            success: function(response){
                $('#mydiv_g').hide();
                //alert(response.Macid);
                if(response.status=='success'){               
                    var json_data_local=
                        {"BrandModels.id":"1",
                        "MacID.AccountID":response.userid,
                        "DateTimeZone":"-5.0",
                        "DisplayName":"MyPhone",        //some data pending here************
                        "LocalPort":"",
                        "Registrations":"0",
                        "MacId":response.Macid,
                        "FriendlyName":document.getElementById('frendlyname').options[document.getElementById('frendlyname').selectedIndex].text,
                        "Brand":$('#brandname').val()
                    };
                    var json_local_mac={MacId:$('#required').val(),id:response.Macid,ExtensionNumber:"",Host:""};
                    macids_ext_host=macids_ext_host.concat(json_local_mac);
                    //alert(macids_ext_host.length);
                    //alert(response.Macid);                    
                    var num=globalPhoneDetail.length;
                    globalPhoneDetail=globalPhoneDetail.concat(json_data_local);
                    var ss=String.trim(document.getElementById('provisioned_phones').innerHTML);
                    if(ss=='No Devices Provisioned Yet.'||ss=="All Devices Deleted."){
                        document.getElementById('provisioned_phones').innerHTML="";
                        //window.location=window.location;
                        macids_ext_host=[json_local_mac];
                        globalPhoneDetail=[json_data_local];
                        num=0
                    }
                        
                    //console.log(globalPhoneDetail);return;
                    var device_html ='<div id="phone' + num + '"><span class="icon-trash-fill" style="cursor: pointer;" onclick="deleteDeviceWithSerl(\'' + num + '\')" id="del'+num+'"></span>&nbsp&nbsp&nbsp<span class="icon-pen-alt2" style="cursor: pointer;" onclick="show_window(\'' +num+ '\');" id="edit'+num+'"></span>&nbsp&nbsp&nbsp <span id="text'+num+'">'
                        +$('#brandname').val()+ " " +document.getElementById('frendlyname').options[document.getElementById('frendlyname').selectedIndex].text+ ' - MAC Address: '+$('#required').val()+'</span> - Ext: <span id="ext'+num+'"></span>  on <span id="host'+num+'"></span></div>';
                    document.getElementById('provisioned_phones').innerHTML+=device_html;   
                    //alert(document.getElementById('provisioned_phones').childElementCount/3+1);
                    //return;
                    show_window(globalPhoneDetail.length-1);
                    $('#required').val('');
                    document.getElementById('brandname').selectedIndex=0;
                    getFriendlyNames();
                    //alert("Device Provisioned");
                    return;
                }
                alert(response.message);
            },
            failure: function(){
                alert('can not do it');
            }
        });
    }
    function getFriendlyNames(){
        //console.log($('#brandname').val()); 
        document.getElementById('fr_lodr').setAttribute('style','display:compact;');
        document.getElementById('sav_btn').disabled=true;
        jQuery.ajax({
            type:'POST',
            url:"<?php echo $this->base ?>/admintools/sendFriendlyNames",
            data:{
                brand:$('#brandname').val()
            },
            success: function(response){
                if(document.getElementById('frendlyname').innerHTML!=""){
                    document.getElementById('frendlyname').innerHTML="";
                }
                var data=JSON.parse(response);
                jQuery.each(data,function(index,item){
                    var option=document.createElement('option');
                    option.text=item;
                    document.getElementById('frendlyname').add(option);
                    
                });
                $('#upper2').text(document.getElementById('frendlyname').options[1].text);

                document.getElementById('sav_btn').disabled=false;
                document.getElementById('fr_lodr').setAttribute('style','display:none;');
            },
            failure: function(){
                alert('can not do it');
            }
        });
    }
    /*  jQuery.ajax({
        url:"<?php echo $this->base; ?>/admintools/sendProvisionedDevices",
        type:'POST',
        dataType:'html',
        success:function(response){
            document.getElementById('provisioned_phones').innerHTML=response;
            //alert(response);
        },
        failure:function(response){
            alert(response);
        }
    });
     */
</script>