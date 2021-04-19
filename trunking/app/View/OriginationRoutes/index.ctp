<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to billing group', '/billing_groups/edit/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Origination Route', 'add/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<table cellspacing="0">
    <tr>
        <th>Origination Name</th>
        <th>Prefix</th>
        <th>Rate</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
    <?php foreach($originationRoutes as $originationRoute) : ?>
    <tr>
        <td><?php echo $originationRoute['OriginationRoute']['descr']; ?></td>
        <td><?php echo $originationRoute['OriginationRoute']['prefix']; ?></td>
        <td><?php echo $originationRoute['OriginationRoute']['orig_rate_id']; ?></td>
        <td><?php echo $this->Itaki->isActive($originationRoute['OriginationRoute']['active']); ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$originationRoute['OriginationRoute']['id']."/".$group_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$originationRoute['OriginationRoute']['id']."/".$originationRoute['OriginationRoute']['customer_bg_id'], array('onclick' => 'return confirm("Are you sure you want to delete this billing group?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>