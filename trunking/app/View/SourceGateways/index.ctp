<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to billing group', '/billing_groups/edit/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Source Gateway', 'add/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<table cellspacing="0">
    <tr>
        <th>IP Address</th>
        <th>Port</th>
        <th>Action</th>
    </tr>
    <?php foreach($sourcegateways as $sourcegateway) : ?>
    <tr>
        <td><?php echo $sourcegateway['SourceGateway']['addr']; ?></td>
        <td><?php echo $sourcegateway['SourceGateway']['port']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$sourcegateway['SourceGateway']['id']."/".$group_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$sourcegateway['SourceGateway']['id']."/".$group_id, array('onclick' => 'return confirm("Are you sure you want to delete this source gateway?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>