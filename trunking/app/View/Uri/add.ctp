<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back', 'index', array('class' => 'menu_btn', 'escape' => false)); ?>
</div>
<div class="add_trunk_form">
    <div class="form_header">Add Uri</div>
    <div class="form_content">
        <?php echo $this->Form->create('Uri'); ?>
        <?php echo $this->Form->input('username'); ?><br />
        <?php echo $this->Form->input('domain'); ?><br />
        <?php echo $this->Form->input('uri_user'); ?><br />
        <?php echo $this->Form->end('Add Uri'); ?>
    </div> 
</div> 

