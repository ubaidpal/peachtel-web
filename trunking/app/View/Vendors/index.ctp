<div class="page_menu">
    <?php echo $this->Html->link('Add vendor', 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->
<table>
    <tr>
        <th>Vendor Name</th>
        <th>Active</th>
        <th>Region Group</th>
        <th>Action</th>
    </tr>
    <?php foreach($vendors as $vendor) : ?>
    <tr>
        <td><?php echo $vendor['CustomerVendor']['descr']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 50px">
            <?php echo $this->Itaki->isActive($vendor['CustomerVendor']['active']); ?>
        </td>
        <td style="border-left: 1px solid #ccc; width: 100px"><?php echo $vendor['CustomerVendor']['region_group_id']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 250px">
            <?php echo $this->Html->link('Edit', '/vendors/edit/'.$vendor['CustomerVendor']['id']); ?>
            <?php echo $this->Html->link('Delete', '/vendors/delete/'.$vendor['CustomerVendor']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this customer?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>