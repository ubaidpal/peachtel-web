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
<style>
    
    .icon-template-alt2 {
        background-position: 0 -660px;
    }
</style>
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
                        if ($bolPhonesProvisioned) :
                            $mac_count = 0;
                            $response = "";
                            foreach ($macAddresses as $macAddr) : ?>
                                <div id="phone<?php echo $mac_count; ?>">
                                    <span id="del<?php echo $mac_count; ?>" mac_id="<?php echo $macAddr['Macid']['id']?>" style="cursor: pointer;" class="icon-trash-fill delete-brand"></span>&nbsp&nbsp&nbsp
                                    <span id="edit<?php echo $mac_count; ?>" class="icon-pen-alt2 edit-mac" style="cursor: pointer;" mac_id="<?php echo $macAddr['Macid']['id']?>"> </span> &nbsp
                                    <span id="edit_template_<?php echo $mac_count; ?>" class="icon-template-alt2 edit-template" style="cursor: pointer;" mac_id="<?php echo $macAddr['Macid']['id']?>"> </span> &nbsp&nbsp&nbsp
                                        <span id="text<?php echo $mac_count; ?>"> <?php echo ucfirst($macAddr['Phonedata'][0]['Brandmodel']['Brand']) . " " . $macAddr['Phonedata'][0]['Brandmodel']['FriendlyName'] . " - MAC Address: " . $macAddr['Macid']['MacID'] . "</span> - Ext: <span id='ext".$mac_count."' class='local_port'>" . $macAddr['Phonedata'][0]['ExtensionNumber'] . "</span> on <span id='host" . $mac_count . "' class='extension'>" . $macAddr['Phonedata'][0]['LocalPort'] . "</span></div>"; ?>
                        <?php
                                $mac_count++;
                            
                            endforeach;
                            
                        else : ?>         
                            No Devices Provisioned Yet.
                        <?php
                        
                        endif;
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
                        <div id="grid-12" style="margin-left:19px"> 
                            <div id="mydiv_g"  style="text-align:center; position:absolute;right: 40%; display: none; top: 37%;z-index: 1"> 
                                <?php echo $this->Html->image('/images/loaders/indicator-big.gif'); ?><br/> 
                            </div>
                            <div class="field-group">
                                <label for="brandname">Select Brand Name:</label>
                                <div class="field" >
                                    <div class="selector" id="uniform-cardtype"style="width:138;">
                                        <span id="upper" style="-moz-user-select: none;width:111px;"><?php echo "Polycom"; ?></span>
                                        <?php echo $this->Form->input('cardtype', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $brandList, 'selected' => 'Polycom', 'id' => 'brandname',  'style' => 'opacity: 0;', 'class' => 'brandname')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="field-group">
                                <label for="frendlyname">Select Product: </label>
                                <div class="field" id="fr_name">
                                    <div class="selector" id="uniform-cardtype" style="width:138;">
                                        
                                        <span id="upper" style="-moz-user-select: none;width:111px;"> <?php reset($frendlynameList); echo $frendlynameList[key($frendlynameList)]; ?></span>   
                                        <?php echo $this->Form->input('frendlyname', array('label' => FALSE, 'options' => $frendlynameList, 'selected' => key($frendlynameList), 'div' => false, 'id' => 'frendlyname')); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="field-group">
                                <label for="required">Enter Mac Address:</label>
                                <div class="field">
                                    <input type="text" name="macid" id="required" size="20" maxlength="12" class="validate[required]"  placeholder="12 Characters" style="width:147;border-radius:8px"  onfocus="error_gone()"/> 	
                                </div>
                            </div>

                            <div class="field-group" style='text-align:center;margin-left:100px'>		
                                <button class="btn btn-grey btn-teal" onclick="savePhone(true)" id="sav_btn">Go</button>		
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
</div> <!-- #content -->

<!--***********************************Modal View ****************************************************-->
<div id="overlay" style="display: none"></div>

<!--***********************************Form **********************************************************-->
<?php echo $this->element('dialogs/form'); ?>

<!--***********************************Validation Errors**********************************************-->
<?php echo $this->element('dialogs/provision_error'); ?>

<!--***********************************Alert***** ****************************************************-->
<?php echo $this->element('dialogs/alert'); ?>
<?php echo $this->Html->script(array('provisioning/provisioning'), array('inline' => false)); ?>