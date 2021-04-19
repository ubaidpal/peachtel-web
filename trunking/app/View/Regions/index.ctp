<div class="page_menu">
    <?php echo $this->Html->link('Add Region group', 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach($regionGroups as $regionGroup) : ?>
    <tr>
        <td><?php echo $regionGroup['RegionGroup']['id']; ?></td>
        <td>
            <?php echo $regionGroup['RegionGroup']['descr']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$regionGroup['RegionGroup']['id']); ?>
            <?php echo $this->Html->link('Region', 'region/'.$regionGroup['RegionGroup']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$regionGroup['RegionGroup']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this region?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>