<form name="form1" method="post" action="process.php">
<?php
foreach($html_array as $sections) {
    echo "<pre>";
    print_r($sections['title']);
    echo "</pre>";
	echo "<h1>".$sections['title']."</h1>";
	foreach($sections['data'] as $html_els) {
		switch($html_els['type']) {
			case 'input':
				$html_els['value'] = ($html_els['key'] == 'option|mac') ? $mac : $html_els['value'];
				echo $html_els['description'].': <input type="text" name="'.$html_els['key'].'" value="'.$html_els['value'].'"/><br />';
				if($html_els['key'] == 'option|mac') { echo "<br />"; };
				break;
			case 'break':
				echo '<br/>';
				break;
			case 'list':
				echo $html_els['description']."<select name='".$html_els['key']."'>";
				foreach($html_els['data'] as $list) {
					  $selected = ($html_els['value'] == $list['value']) ? 'selected' : '';
					  echo '<option value="'.$list['value'].'" '.$selected.'>'.$list['description'].'</option>';
				}
				echo "</select><br />";
				break;
			case 'radio':
				echo $html_els['description'].':';
				foreach($html_els['data'] as $list) {
					$checked = isset($list['checked']) ? 'checked' : '';
					echo '|<input type="radio" name="'.$list['key'].'" value="'.$list['key'].'" '.$checked.'/>'.$list['description'];
				}
				echo '<br />';
				break;
			case 'checkbox':
				$checked = $html_els['value'] ? 'checked' : '';
				echo $html_els['description'].': <input type="checkbox" name="'.$html_els['key'].'" '.$checked.'/><br />';
				break;	
			default:
				break;
		}
	}
}
?>
<input type="hidden" id="brand" name="brand" value="<?php echo $phonedata['Brandmodel']['Brand'];?>" />
<input type="hidden" id="product" name="product" value="<?php echo $phonedata['Brandmodel']['Family'];?>" />
<input type="hidden" id="model" name="model" value="<?php echo $phonedata['Brandmodel']['FriendlyName'];?>" />
<input type="hidden" id="mac" name="mac" value="<?php echo $mac;?>" />
<input type="hidden" id="timezone" name="timezone" value="<?php //echo "$timezone";?>" />
<input type="submit" value="Submit" />
</form>
