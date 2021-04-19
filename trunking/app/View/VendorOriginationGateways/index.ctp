<div class="page_menu">
    <?php echo $this->Html->link('&larr; Back to vendor', '/vendors/edit/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
    <?php echo $this->Html->link('Add Orig. Gateway', 'add/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<table>
    <tr>
        <th>IP Address</th>
        <th>Port</th>
        <th>Channel Limit</th>
        <th>Action</th>
    </tr>
    <?php foreach($origgateways as $origgateway) : ?>
    <tr>
        <td style="border-right: 1px solid #ccc;"><?php echo $origgateway['VendorOriginationGateway']['addr']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $origgateway['VendorOriginationGateway']['port']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $origgateway['VendorOriginationGateway']['channel_limit']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 300px">
            <?php echo $this->Html->link('Edit', 'edit/'.$origgateway['VendorOriginationGateway']['id']."/".$vendor_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$origgateway['VendorOriginationGateway']['id']."/".$vendor_id, array('onclick' => 'return confirm("Are you sure you want to delete this gateway?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>