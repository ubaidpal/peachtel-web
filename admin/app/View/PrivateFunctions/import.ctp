<div id="content">	
    
    <div id="contentHeader">
        <h1>Import CSV</h1>
    </div> <!-- #contentHeader -->
    
    <div class="container">
        <div class="trunking_main_holder">
            <div class="box">

                    <?php echo $this->form->create('Nextusa', array('type' => 'file')); ?>
                    <?php echo $this->form->input('csv_file', array('type' => 'file', 'label' => 'CSV File: ')); ?>
                    <br />
                    <?php echo $this->form->end('Import'); ?>
                    <br />
            </div> <!-- .box -->
        </div> <!-- .trunking_main_holder -->
        
    </div> <!-- .container -->
    
</div> <!-- #content -->