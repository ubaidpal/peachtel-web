<div class="page_menu">
    <?php echo $this->Html->link('Add Package group', 'add', array('class' => 'menu_btn', 'escape' => false)); ?>
</div><!-- .page_menu -->

<table cellspacing="0">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach($pkgTermCodeGroups as $pkgTermCodeGroup) : ?>
    <tr>
        <td><?php echo $pkgTermCodeGroup['PackageTermCodeGroup']['id']; ?></td>
        <td>
            <?php echo $pkgTermCodeGroup['PackageTermCodeGroup']['descr']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Edit', 'edit/'.$pkgTermCodeGroup['PackageTermCodeGroup']['id']); ?>
            <?php echo $this->Html->link('Package', 'package/'.$pkgTermCodeGroup['PackageTermCodeGroup']['id']); ?>
            <?php echo $this->Html->link('Delete', 'delete/'.$pkgTermCodeGroup['PackageTermCodeGroup']['id'], array('onclick' => 'return confirm("Are you sure you want to delete this package?")')); ?>
        </td>
    </tr>
    <?php endforeach;?>

</table>