<div>
    <div><?php echo $this->Html->link('Credit Control', '/billing_groups/credit_controll/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Margin Enforcement', '/billing_groups/margin_enforcement/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Origination Routes', '/origination_routes/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Source Gateways', '/source_gateways/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link('Destination Gateways', '/destination_gateways/index/'.$group_id); ?></div>
    <div><?php echo $this->Html->link("Subscribers", '/subscribers/index/'.$group_id); ?></div>
</div>