<div id="reg_header"><ul></ul></div>
<form name="form1" method="post" action="saveTemplate">
<?php
$j = 0;

foreach($html_array as $sections) { ?>
    <table width="420" border="0" cellspacing="2" cellpadding="2">
        <tbody id="show_registrations"> 
            <th></th>
            <th style="text-align: left;"><h1><?php echo $sections['title']; ?></h1></th>
            <?php 
            $i = 0;
            foreach($sections['data'] as $html_els) { 
                if($html_els['type'] != 'break')
                    $val = (isset($formdata) && isset($formdata[$html_els['key']])) ? $formdata[$html_els['key']] : $html_els['value'];
            ?>
                    <?php 
                    switch($html_els['type']) {
                        case 'input':
                            $html_els['value'] = ($html_els['key'] == 'option|mac') ? $mac : $html_els['value'];
                            echo '<tr><td width="30%"><label>'.$html_els['description'].'</label></td>';
                            echo '<td width="70%">
                                    <input style="width: 193px !important" type="text" id="reg_val" name="'.$html_els['key'].'" value="'.$val.'" />
                                </td></tr>';
                            break;
                        case 'list':
                            $style = ($i % 2 == 1 && $j == 0) ? "style='border-bottom: 1px dashed #777; padding-bottom: 10px; margin-bottom: 20px;'" : "";
                            echo '<tr><td width="30%" '.$style.'><label>'.$html_els['description'].'</label></td>';
                            echo "<td width='70%' $style>
                                    <div class='selector' id='uniform-cardtype'><span id='upper' style='-moz-user-select: none;'>".ucfirst($val)."</span>
                                    <select name='".$html_els['key']."'>";
                            foreach($html_els['data'] as $list) {
                                $selected = ($val == $list['value']) ? 'selected' : '';
                                echo '<option value="'.$list['value'].'" '.$selected.'>'.$list['description'].'</option>';
                            }
                            echo "</select></td></tr>";
                            break;
                        case 'radio':
                            echo '<tr><td width="30%"><label>'.$html_els['description'].'</label></td>';
                            echo "<td width='70%'>";
                            foreach($html_els['data'] as $list) {
                                $checked = ($val == $list['value']) ? 'checked' : '';
                                echo '<input type="radio" name="'.$list['key'].'" value="'.$list['value'].'" '.$checked.'/>'.$list['description'];
                            }
                            echo "</select></td></tr>";
                            break;
                        case 'checkbox':
                            echo '<tr><td width="30%"><label>'.$html_els['description'].'</label></td>';
                            $checked = $val ? 'checked' : '';
                            echo '<td width="70%"><input type="checkbox" name="'.$html_els['key'].'" '.$checked.'/></td></tr>';
                            break;	
                        default:
                            break;
                    } ?>
            <?php 
            $i++;
            } ?>
        </tbody>
    </table>
<?php $j++; } ?>
<br />
<input type="hidden" id="brand" name="brand" value="<?php echo $phonedata['Brandmodel']['Brand'];?>" />
<input type="hidden" id="product" name="product" value="<?php echo $phonedata['Brandmodel']['Family'];?>" />
<input type="hidden" id="model" name="model" value="<?php echo $phonedata['Brandmodel']['FriendlyName'];?>" />
<input type="hidden" id="mac" name="mac" value="<?php echo $mac;?>" />
<input type="hidden" id="mac" name="macID" value="<?php echo $macID;?>" />
<input type="hidden" id="timezone" name="timezone" value="<?php //echo "$timezone";?>" />
<input type="submit" value="Configure" />
</form>
