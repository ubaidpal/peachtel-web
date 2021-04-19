<div class="page_menu">
    <?php echo $this->Html->link("&larr; Back to customer's list", '/customers/index/', array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add billing group', 'add/'.$customer_id, array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Group Name</th>
        <th>Channel Limit</th>
        <th>Action</th>
    </tr>
    <?php foreach($billingGroups as $billingGroup) : ?>
    <tr>
        <td><?php echo $billingGroup['BillingGroup']['descr']; ?></td>
        <td>
            <?php echo $billingGroup['BillingGroup']['channel_limit']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$billingGroup['BillingGroup']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$billingGroup['BillingGroup']['id']."/".$customer_id, array('onclick' => 'return confirm("Are you sure you want to delete this billing group?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>