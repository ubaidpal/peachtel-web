<Style>
    .input {
        margin-bottom: 5px;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>OpenCam</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-24">
            <div class="box" id="categories">
            	<form method="POST" action="">
            	<label style="display: inline-block; width: 120px;">Server Host Name: </label><?php echo "http://".$hosting['Server']['domain'] ?><br /><br />
            	<label style="display: inline-block; width: 120px;">Server Image: </label>PIAF (Pbx in a Flash) 2.0.6.3 + Red + FreePBX 2.10<br /><br />
                <?php echo $this->Form->input('location', array('type' => 'select', 'options' => $locations, 'label' => 'Select your location: ')); ?>
                <br />
                <button id="searchCNAM" class="btn btn-teal">Build</button>
                <br /><br />
                <div id="result"></div>
            	</form>
            </div>
        </div>
    </div>
</div> <!-- #content -->