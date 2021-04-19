<?php 
	echo $this->Html->script(array('jquery.min', 'jquery-custom.min'));
	echo $this->Html->css(array('default/login', 'default/alljs', 'jquery.treeview'));
?>
<style>
	body {
		background: #333333;
		color: #fff;
		font-family: Arial;
	}
	.input label  {
		color: #000;
		display: block;
		font-size: 20px;
	}

	input[type="text"] {
		width: 395px;
		padding: 10px;
		font-size: 20px;
		border-radius: 3px;
		border: 1px solid #cdcdcd;
	}
	input[type="text"]:last-child() {
		width: 20px;
		padding: 5px;
		font-size: 16px;
	}
	input[type="submit"] {
		background: url;
	}
	#paynow {
		background: url("../../images/gallery/paynow.png") repeat scroll 0 0 transparent;
	    display: block;
	    height: 28px;
	    width: 172px;
	}
</style>
<div style="width: 400px; height: 300px; background: #fff; margin:auto; margin-top: 80px; padding: 10px; border-radius: 10px;">
	<?php echo $this->Form->create(); ?>
	<?php echo $this->Form->input('cardnum', array('label' => 'Creditcard Number: ', 'placeholder' => 'eg. 4111 1111 1111 1111')); ?>
	<br />
	<?php echo $this->Form->input('expdata', array('label' => 'Expiration Date: ', 'placeholder' => 'Month/Year - eg. 4/13')); ?>
	<br />
	<a id="paynow" a href="javascript:void(0);">&nbsp;</a>
</div>
<script type="text/javascript">
$("#TblticketreplyExpdata").datepicker({
	dateFormat: 'm/y'
});
$("#paynow").live('click', function() {
	$("#TblticketreplyProcessAuthorizeCheckoutForm").submit();
});
</script>