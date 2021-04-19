<style>
    .label {
        width: 150px !important;
        display: inline-block;
    }
    .input {
        display: inline-block;
        margin-top:10px;
    }
    
    #swfupload-control {
        display: inline-block;
        vertical-align: top;
        width: 500px;
    }
    
    #swfupload-control #queuestatus {
        margin: 5px 0px 0px;
        background: none repeat scroll 0% 0% rgb(168, 204, 236);
        font-weight: bold;
    }
    #swfupload-control p {
        margin: 0
    }
    
    #swfupload-control #log {
        list-style: none;
        margin: 0
    }
    
    #swfupload-control #log li {
        margin: 0;
        padding: 5px;
        border: 1px solid #d5d5d5;
        border-top: none;
        background: #fff;
        position: relative;
    }
    
    #swfupload-control #log li:first-child {
        border-top: 1px solid #d5d5d5;
    }
    
    #swfupload-control #log li .cancel {
        background: url("../images/sprite/sprite-16-black.png") repeat scroll 0 572px transparent;
        position: absolute;
        height: 16px;
        top: 7px;
        right: 5px;
        width: 16px;
        cursor: pointer;
    }
    
    #swfupload-control #log li em {
        padding: 3px;
    }
    
</style>
<?php echo $this->Html->script(array('multi_load/jquery.swfupload', 'multi_load/swfupload/swfupload', 'private_functions/import_product')); ?>
<div id="content">	
    
    <div id="contentHeader">
        <h1>Add Prestashop Product</h1>
    </div> <!-- #contentHeader -->
    
    <div class="container">
        <div class="trunking_main_holder">
            <div class="box">
                <div>
                    <h1>Import CSV file</h1>
                    <p>Note: Manufacturer will be always in default id (1). This will be fixed after manufacturer data has been set in the Prestashop admin site
                    <br />Please do not insert special characters such as ( &, <, > and ETC ) in the CSV file.
                    </p>
                    <?php echo $this->form->create('Nextusa', array('type' => 'file')); ?>
                    <div class="label">Load Images :<span style="float: right;">[<a href="javascript:void(0);" onclick="$('#uploadfiles').slideToggle()">Toggle</a>]</span></div>

                    <div id="swfupload-control">
                        <button id="multiLoad"  ></button>
                        <div id="uploadfiles" style="display: none;">
                        <p id="queuestatus" ></p>
                        <ol id="log"></ol>
                        </div>
                    </div>
                    <br />
                    <div class="label">CSV File :</div>
                    <?php echo $this->form->input('product_csv', array('label' => false, 'type' => 'file')); ?><br />
                    <br />
                    <?php echo $this->form->input('Begin Import', array('label' => false, 'type' => 'submit', 'onclick' => 'return false;')); ?>
                    <?php echo $this->form->end(); ?>
                </div>
                <br />
                <hr />
                <h1>Add Product</h1>
                <?php echo $this->form->create(); ?>
                    <div class="label">Name :</div>
                    <?php echo $this->form->input('name', array('label' => false)); ?><br />
                    
                    <div class="label">Price :</div>
                    <?php echo $this->form->input('price', array('label' => false)); ?><br />
                    
                    <div class="label">Reference :</div>
                    <?php echo $this->form->input('reference', array('label' => false)); ?><br />
                    
                    <div class="label">UPC :</div>
                    <?php echo $this->form->input('upc', array('label' => false)); ?><br />
                    
                    <div class="label">Status :</div>
                    <?php echo $this->form->input('active', array('label' => false, 'type' => 'checkbox')); ?><br />
                    
                    <div class="label">Visibility :</div>
                    <?php echo $this->form->input('visibility', array('label' => false, 'options' => array('catalog' => 'Catalog', 'search' => 'Search', 'none' => 'None'))); ?><br />
                    
                    <div class="label">Condition :</div>
                    <?php echo $this->form->input('condition', array('label' => false, 'options' => array('new' => 'New', 'used' => 'Used', 'refurbished' => 'Refurbished'))); ?><br />
                    
                    <div class="label">Short Description :</div>
                    <?php echo $this->form->input('description_short', array('label' => false, 'type' => 'textarea')); ?><br />
                    
                    <div class="label">Description :</div>
                    <?php echo $this->form->input('description', array('label' => false, 'type' => 'textarea')); ?><br />
                    <br />
                <?php echo $this->form->end('Add Product'); ?>
                <br />
            </div> <!-- .box -->
        </div> <!-- .trunking_main_holder -->
        
    </div> <!-- .container -->
    
</div> <!-- #content -->