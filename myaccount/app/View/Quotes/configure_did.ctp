<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
#tabs {
    border: none;
}
#tabs ul {
    padding: 0;
}
#tabs ul li {
    list-style: none !important;
    margin: 0 0.2em 0 0;
}
#tabs li a {
    font-size: 16px;
    padding: 5px 10px;   
}
.ui-tabs .ui-tabs-panel {
    padding: 1em 0;
}

#found-numbers, #config-numbers {
    border: 1px solid #AAAAAA;
}

table tbody tr td {
    font-size: 10px;
}

.ui-widget-header {
    border: none;
    background: none;
}
#phone_search_form .input {
    margin-top: 10px;
}
#phone_search_form .input label {
    display: inline-block;
    width: 100px;
}

#findNumberBtn {
    background-color: #494949;
    background-image: -moz-linear-gradient(center bottom , #494949, #A9A9A9);
    border-bottom: 1px solid #4A4A4A;
    border-radius: 5px 5px 5px 5px;
    border-top: 1px solid #858585;
    color: #FFFFFF;
    display: block;
    list-style: none outside none;
    margin: 8px 0 10px 106px;
    padding: 5px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    width: 259px;   
}
</style>
<div id="phone_search_form">
    <hr />
    <?php //echo $this->Form->input('did', array('type' => 'hidden', 'value' => $did)); ?>
    <?php //echo $this->Form->input('line', array('type' => 'hidden', 'value' => $line)); ?>
    
    <div class="input select">
        <label for="search_did">Select DID Type: </label>
        <select id="search_did" name="data[search_did]" style="width: 259px;">
            <option value="">--- SELECT DID TYPE ---</option>
            <option value="GEOGRAPHIC">GEOGRAPHIC</option>
            <option value="TOLLFREE">TOLL FREE</option>
            <option value="NATIONAL">NATIONAL</option>
        </select>
    </div>
    <div class="input select" style="display:none;" id="search_country_holder">
    	<label for="search_country">Country: </label>
		<select id="search_country" name="data[search_country]" style="width: 259px;">
		    <!--<?php foreach($countries as $country): ?>
	    		<option value="<?php echo $country["COUNTRY_ID"] ?>"><?php echo $country["COUNTRY_NAME"] ?></option>
	    	<?php endforeach; ?>-->
		</select>
    </div>
    <div class="input select" style="display:none;"  id="search_states_holder">
    	<label for="search_states">State: </label>
		<select id="search_states" name="data[search_states]" style="width: 259px;"></select>
    </div>
    <a href="javascript:void(0);" id="findNumberBtn" style="display:none;">Search</a>
    <hr style="margin-bottom: 1.5e;"/>
    <div id="tabs">
         <ul>
            <li><a href="#found-numbers">Select DIDs</a></li>
            <li><a href="#config-numbers">Configure DIDs</a></li>
        </ul>
        <div id="found-numbers" style="overflow-x: auto; max-height: 360px; overflow-y: none;"></div>
        <div id="config-numbers" style="overflow-x: auto; max-height: 360px; overflow-y: none;"></div>
    </div>
</div>
<script type="text/javascript">$("#tabs").tabs();</script>