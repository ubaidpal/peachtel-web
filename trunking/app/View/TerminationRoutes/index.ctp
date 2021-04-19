<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', '/vendors/edit/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Term. Route', 'add/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
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
        <th>Intra-Regional</th>
        <th>Min. Duration</th>
        <th>Dur. Increment</th>
        <th>Action</th>
    </tr>
    <?php foreach($termroutes as $termroute) : ?>
    <tr>
        <td><?php echo $termroute['TerminationRoute']['descr']; ?></td>
        <td><?php echo $termroute['TerminationRoute']['prefix']; ?></td>
        <td><?php echo $termroute['TerminationRoute']['minute_cost']; ?></td>
        <td><?php echo $this->Itaki->isActive($termroute['TerminationRoute']['active']); ?></td>
        <td><?php echo $this->Itaki->isActive($termroute['TerminationRoute']['intra_regional']); ?></td>
        <td><?php echo $termroute['TerminationRoute']['min_duration']; ?></td>
        <td><?php echo $termroute['TerminationRoute']['duration_incr']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$termroute['TerminationRoute']['id']."/".$vendor_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$termroute['TerminationRoute']['id']."/".$vendor_id, array('onclick' => 'return confirm("Are you sure you want to delete this route?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>