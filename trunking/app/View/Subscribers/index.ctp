<div class="page_menu">
    <?php echo $this->Html->link('Add Subscriber', 'add/'.$group_id,  array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<div class="bg_nav">
    <?php echo $this->element('bg_nav'); ?>
</div><!-- .bg_nav -->

<table cellspacing="0">
    <tr>
        <th>Username</th>
        <th>Domain</th>
        <th>Action</th>
    </tr>
    <?php foreach($subscribers as $subscriber) : ?>
    <tr>
        <td style="border-right: 1px solid #ccc;"><?php echo $subscriber['Subscriber']['username']; ?></td>
        <td style="border-right: 1px solid #ccc;"><?php echo $subscriber['Subscriber']['domain']; ?></td>
        <td style="border-left: 1px solid #ccc; width: 300px">
            <?php echo $this->Html->link('Edit', 'edit/'.$subscriber['Subscriber']['id']."/".$group_id); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$subscriber['Subscriber']['id']."/".$group_id, array('onclick' => 'return confirm("Are you sure you want to delete this subscriber?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>