<form enctype="multipart/form-data" method="POST" action="test">
  <fieldset>
    <legend>Add image for products No 1</legend>
    <input type="file" name="image">
    <input type="submit" value="Execute">
    <?php echo $this->Form->input('test'); ?>
    <?php echo $this->Form->input('image', array('type' => 'file')); ?>
  </fieldset>
</form>