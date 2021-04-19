<div class="page_menu">
    <?php echo $this->Html->link('Add Region', 'add_region/'.$reg_group_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach($regions as $region) : ?>
    <tr>
        <td><?php echo $region['Region']['id']; ?></td>
        <td>
            <?php echo $region['Region']['descr']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit_region/'.$region['Region']['id']); ?>
            <?php echo $this->Html->link('Region Code', 'region_code/'.$region['Region']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete_region/'.$region['Region']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this region?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>