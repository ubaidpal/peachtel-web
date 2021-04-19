<div class="page_menu">
    <?php echo $this->Html->link("&larr; Add", 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Username</th>
        <th>Domain</th>
        <th>Uri User</th>
        <th>Last Modified</th>
        <th>Action</th>
    </tr>
    <?php foreach($uris as $uri) : ?>
    <tr>
        <td><?php echo $uri['Uri']['username']; ?></td>
        <td><?php echo $uri['Uri']['domain']; ?></td>
        <td><?php echo $uri['Uri']['uri_user']; ?></td>
        <td><?php echo $uri['Uri']['last_modified']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$uri['Uri']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$uri['Uri']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this URI?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>