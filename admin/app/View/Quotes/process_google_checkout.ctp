
<style>
	input[name="Checkout"] {
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";

		/* IE 5-7 */
		filter: alpha(opacity=0);

		/* Netscape */
		-moz-opacity: 0;

		/* Safari 1.x */
		-khtml-opacity: 0;

		/* Good browsers */
		opacity: 0;
	}
</style>
<?php
	echo $this->Html->script(array('jquery.min', 'jquery-custom.min', 'selectToUISlider.jQuery', 'jquery.validate_1', 'jquery.treeview','jquery.treeview.edit'));

	echo $btn;

?>
<script>
	$('input[name="Checkout"]').click();
</script>