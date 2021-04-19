<tr>
    <th>Start Time</th>
    <th>Billing Group</th>
    <th>Source</th>
    <th>Destination</th>
    <th>Duration</th>
    <th>Sip Reason</th>
</tr>
<?php if(!empty($cdrs)) : ?>

<?php foreach($cdrs as $cdr) : ?>
<tr>
    <td><?php echo $cdr['Cdr']['start_time']; ?></td>
    <td><?php echo $cdr['Cdr']['customer_bg_id']; ?></td>
    <td><?php echo $cdr['Cdr']['src']; ?></td>
    <td><?php echo $cdr['Cdr']['dest']; ?></td>
    <td><?php echo $cdr['Cdr']['duration_sec']; ?></td>
    <td><?php echo $cdr['Cdr']['sip_reason']; ?></td>
</tr>
<?php endforeach; ?>

<?php else: ?>
<tr>
    <td>No Data Found.</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<?php endif; ?>
