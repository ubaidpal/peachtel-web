<div class="page_menu">
    <?php echo $this->Html->link('Add New Customer', 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table>
    <tr>
        <th>Customer Name</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
    <?php foreach($customers as $customer) : ?>
    <tr>
        <td style="border-right: 1px solid #ccc;"><?php echo $customer['Customer']['descr']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 300px"><?php echo $this->Itaki->isActive($customer['Customer']['active']); ?></th>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$customer['Customer']['id']); ?>
            <?php echo $this->Html->link('Billing Groups', '/billing_groups/index/'.$customer['Customer']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$customer['Customer']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this customer?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>