<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to billing group', '/billing_groups/edit/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Dest. Gateway', 'add/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<table cellspacing="0">
    <tr>
        <th>Priority</th>
        <th>Type</th>
        <th>Destination</th>
        <th>Action</th>
    </tr>
    <?php foreach($destgateways as $destgateway) : ?>
    <tr>
        <td><?php echo $destgateway['DestinationGateway']['priority']; ?></td>
        <td><?php echo ($destgateway['DestinationGateway']['dest_type']) ?  'Registrant' : 'Static'; ?></td>
        <td><?php echo $destgateway['DestinationGateway']['dest']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$destgateway['DestinationGateway']['id']."/".$group_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$destgateway['DestinationGateway']['id']."/".$group_id, array('onclick' => 'return confirm("Are you sure you want to delete this destination gateway?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>