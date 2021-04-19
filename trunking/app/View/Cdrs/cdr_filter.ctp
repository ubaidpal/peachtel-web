<table>
    <tr>
        <th>Source</th>
        <th>Destination</th>
        <th>Customer</th>
        <th>Duration</th>
        <th>Post Answer Duration</th>
        <th>Action</th>
    </tr>
    <?php foreach($cdrs as $cdr) : ?>
    <tr>
        <td><?php echo $cdr['Cdr']['src']; ?></td>
        <td><?php echo $cdr['Cdr']['dest']; ?></td>
        <td><?php echo $cdr['Customer']['descr']; ?></td>
        <td><?php echo $cdr['Cdr']['duration_sec']." sec"; ?></td>
        <td style="border-left: 1px solid #ccc; width: 200px"><?php echo $cdr['Cdr']['post_answer_duration_sec']." sec"; ?></td>
        <td>
            <?php echo $this->Html->link('View Details', '/cdrs/view_details/'.$cdr['Cdr']['id']); ?>
            <?php echo $this->Html->link('View Rating', '/cdrs/view_rating/'.$cdr['Cdr']['id']); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>
<div>
    <?php 
        echo $this->Paginator->prev(' ' . __('Prev '), array(), null, array('class' => 'prev disabled'));
        echo ' | ';
        echo $this->Paginator->numbers(array('separator' => ' | '));
        echo ' | ';
        echo $this->Paginator->next(__(' Next') . ' ', array(), null, array('class' => 'next disabled'));
    ?>
</div>