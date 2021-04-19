<?php
class ItakiHelper extends FormHelper
{
	
	function isActive($data) {
        if($data == 't') {
            return "<img src='$this->base/images/icons/active.png' />";
        } else {
            return "<img src='$this->base/images/icons/inactive.png' />";
        }
    }
}
?>