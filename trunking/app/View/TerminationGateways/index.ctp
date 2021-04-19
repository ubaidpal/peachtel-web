<div class="page_menu">
    <?php echo $this->Html->link('Add Term. Gateway', 'add/'.$vendor_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('v_navigation'); ?>
</div><!-- .bg_nav -->

<table>
    <tr>
        <th>Priority</th>
        <th>IP Address</th>
        <th>Port</th>
        <th>Channel Limit</th>
        <th>Action</th>
    </tr>
    <?php foreach($termgateways as $termgateway) : ?>
    <tr>
        <td style="border-right: 1px solid #ccc;"><?php echo $termgateway['TerminationGateway']['priority']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $termgateway['TerminationGateway']['addr']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $termgateway['TerminationGateway']['port']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $termgateway['TerminationGateway']['channel_limit']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 300px">
            <?php echo $this->Html->link('Edit', 'edit/'.$termgateway['TerminationGateway']['id']."/".$vendor_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$termgateway['TerminationGateway']['id']."/".$vendor_id, array('onclick' => 'return confirm("Are you sure you want to delete this gateway?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>