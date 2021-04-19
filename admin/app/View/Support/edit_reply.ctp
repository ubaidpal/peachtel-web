<div id="edit-pane" type="reply">
    <?php echo $this->Form->input('eid', array('type' => 'hidden', 'value' => $reply['Tblticketreply']['id'])); ?>
    <?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => false, 'div' => false, 'style' => 'width: 885px; height: 111px; vertical-align: top;', 'value' => $reply['Tblticketreply']['message'])); ?>
    <a href="javascript:void(0);" id="save">Save</a>
    <a href="javascript:void(0);" id="cancel">Cancel</a>
</div>