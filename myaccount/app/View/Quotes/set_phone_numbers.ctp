<?php
	/** Start Treeview */
	$numbers = array();
	echo "<ul id='browser' class='treeview'>";
	foreach($areas as $area) {
		if(isset($area['AREA_ID'])) {
	        echo "<li id={$area['AREA_ID']}><span>{$area['AREA_NAME']}</span>";
	        echo "<ul>";
	        echo "</ul>";
	        echo "</li>";
    	}
	}
	echo "</ul>"; 
?>