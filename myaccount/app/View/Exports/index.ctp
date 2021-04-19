<div>
    <fieldset>
        <legend><h2>Export CSV > Table Nextusa</h2></legend>
        
        <?php echo $this->form->create('Nextusa', array('type' => 'file')); ?>
        <?php echo $this->form->input('csv_file', array('type' => 'file')); ?>
        <?php echo $this->form->end('Import'); ?>
    </fieldset>
</div>