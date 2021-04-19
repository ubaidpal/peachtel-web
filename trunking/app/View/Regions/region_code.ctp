<div class="page_menu">
    <?php echo $this->Html->link('Add Region code', 'add_region_code/'.$reg_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Prefix</th>
        <th>Actions</th>
    </tr>
    <?php foreach($regionCodes as $regionCode) : ?>
    <tr>
        <td>
            <?php echo $regionCode['RegionCode']['prefix']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Delete', 'delete_region_code/'.$regionCode['RegionCode']['prefix'], array('onclick' => 'return confirm("Are you sure you want to delete this region code?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>