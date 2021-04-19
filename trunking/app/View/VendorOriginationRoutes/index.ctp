<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', '/vendors/edit/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Orig. Route', 'add/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<table>
    <tr>
        <th>Name</th>
        <th>Prefix</th>
        <th>Cost</th>
        <th>Active</th>
        <th>Min. Duration</th>
        <th>Dur. Increment</th>
        <th>Action</th>
    </tr>
    <?php foreach($origroutes as $origroute) : ?>
    <tr>
        <td><?php echo $origroute['VendorOriginationRoute']['descr']; ?></td>
        <td><?php echo $origroute['VendorOriginationRoute']['prefix']; ?></td>
        <td><?php echo $origroute['VendorOriginationRoute']['minute_cost']; ?></td>
        <td><?php echo $this->Itaki->isActive($origroute['VendorOriginationRoute']['active']); ?></td>
        <td><?php echo $origroute['VendorOriginationRoute']['min_duration']; ?></td>
        <td><?php echo $origroute['VendorOriginationRoute']['duration_incr']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$origroute['VendorOriginationRoute']['id']."/".$vendor_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$origroute['VendorOriginationRoute']['id']."/".$vendor_id, array('onclick' => 'return confirm("Are you sure you want to delete this gateway?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>