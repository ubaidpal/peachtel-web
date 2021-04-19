<div class="page_menu">
    <?php echo $this->Html->link('Add Package', 'add_package/'.$pkg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('pkg_nav'); ?>
</div><!-- .bg_nav -->

<table cellspacing="0">
    <tr>
        <th>Name</th>
        <th>Total Min.</th>
        <th>Ovg Min. Cost</th>
        <th>Ovg. Min. Duration</th>
        <th>Actions</th>
    </tr>
    <?php foreach($packages as $package) : ?>
    <tr>
        <td><?php echo $package['Package']['descr']; ?></td>
        <td><?php echo $package['Package']['total_min']; ?></td>
        <td><?php echo $package['Package']['ovg_minute_cost']; ?></td>
        <td><?php echo $package['Package']['ovg_min_duration']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit_package/'.$package['Package']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete_package/'.$package['Package']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this package?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>