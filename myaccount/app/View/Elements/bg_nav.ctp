<div>
    <div><?php echo $this->Html->link('Credit Control', '/trunking_billing_groups/credit_controll/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Margin Enforcement', '/trunking_billing_groups/margin_enforcement/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Origination Routes', '/trunking_origination_routes/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Source Gateways', '/trunking_source_gateways/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Destination Gateways', '/trunking_destination_gateways/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link("Subscribers", '/trunking_subscribers/index/'.$group_id); ?></div>
</div>