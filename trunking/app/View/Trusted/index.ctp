<div class="page_menu">
    <?php echo $this->Html->link("&larr; Add", 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Source IP</th>
        <th>Proto</th>
        <th>Pattern</th>
        <th>Tag</th>
        <th>Action</th>
    </tr>
    <?php foreach($trusted as $trust) : ?>
    <tr>
        <td><?php echo $trust['Trusted']['src_ip']; ?></td>
        <td><?php echo $trust['Trusted']['proto']; ?></td>
        <td><?php echo $trust['Trusted']['from_pattern']; ?></td>
        <td><?php echo $trust['Trusted']['tag']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$trust['Trusted']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$trust['Trusted']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this trusted?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>