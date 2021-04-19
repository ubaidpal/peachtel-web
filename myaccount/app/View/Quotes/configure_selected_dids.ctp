<?php if(empty($clientDetails)): ?>
<h4 style="color: #ff0000; font-size: 16px; margin-left: 10px; margin-bottom:5px;">Please login to your account to continue purchasing DID(s).</h4>
<?php endif; ?>
<form action="buySelectedDids" method="POST">
<div class="widget widget-table">
    <div class="widget-header">
        <h3 style="margin-top: 10px;color:#454545;font-size: 16px">Configuration</h3>		
    </div>
    <div class="widget-content">
        <table class="table table-bordered table-striped data-table">
            <thead>
            <th>Number</th>
            <th>DID Type</th>
            <th>Country</th>
            <th>Area</th>
            <?php if(empty($clientDetails)): ?>
            	<th>Account Number</th>
        	<?php else: ?>
        		<th>Billing Group</th>
    		<?php endif?>
            <th>Action</th>
            </thead>
            <?php foreach($dids as $did) : ?>
                <tr class="gradeA">
                    <td> <?php echo $did['E164'] ?> </td>
                    <td> <?php echo $did['DID_TYPE'] ?> </td>
                    <td> <?php echo $did['COUNTRY_NAME'] ?> </td>
                    <td> <?php echo $did['AREA_NAME'] ?> </td>
                    <?php if(empty($clientDetails)): ?>
		            	<td> <?php echo $did['ACCOUNT_NUMBER'] ?> </td>
	        		<?php else: ?>
		        		<td>
		        			<?php if(!empty($clientTrunkData['MasterBillingGroup']['BillingGroup'])) : ?>
			        			<select name="<?php echo $did['E164'] ?>">
			        				<?php foreach($clientTrunkData['MasterBillingGroup']['BillingGroup'] as $bg) : ?>
			        					<option value="<?php echo $bg['id'] ?>"><?php echo $bg['descr'] ?></option>]
			        				<?php endforeach; ?>
			        			</select>
			        		<?php else: ?>
			        			<th>No Billing Group</th>
			        		<?php endif; ?>
		        		</td>
	        		<?php endif?>
                    <td> <a href="javascript:void(0);" id="removeDID" did="<?php echo $did['E164'] ?>" >Remove</a> </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div> <!-- .widget-content -->
</div> <!-- .widget -->

<?php if(!empty($clientDetails) && !empty($clientTrunkData['MasterBillingGroup']['BillingGroup'])): ?>
<input type="submit" value="Buy Numbers" />
<br /><br />
<?php endif?>

</form>

<script>
$("#removeDID").live("click", function() {

	var data = {did: $(this).attr('did')};
    ajaxQuery('configureRemoveSelectedDids', data);
    $(this).parents().eq(1).remove();

    if($("tbody tr").length == 0) {
    	$("#config-numbers").html("<label style='font-size: 12px; margin-left: 10px; color: #ff0000; font-weight: bold;'>No Selected DID(s).</label>");
    }
});
</script>