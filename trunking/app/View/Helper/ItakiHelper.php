<?php
class ItakiHelper extends FormHelper
{
	
	function isActive($data) {
        if($data) {
            return "<img src='$this->base/img/icons/active.png' />";
        } else {
            return "<img src='$this->base/img/icons/inactive.png' />";
        }
    }
}
?>