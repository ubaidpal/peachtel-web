<?php 
    echo $this->Html->script('http://maps.google.com/maps/api/js?sensor=false');
    $locs = array(
        0 => array('lat' => '33.70944243157056', 'long' => '-84.40382478691413', 'country' => 'US', 'region' => 'Atlanta', 'city' => 'GA'),
        1 => array('lat' => '41.87667645110385', 'long' => '-87.63380525566413', 'country' => 'US', 'region' => 'Chicago', 'city' => 'IL'),
        2 => array('lat' => '39.73566237271131', 'long' => '-104.98602388359382', 'country' => 'US', 'region' => 'Denver', 'city' => 'CO'),
        3 => array('lat' => '51.5146896706115', 'long' => '-0.1386880681641287', 'country' => 'EU', 'region' => 'London', 'city' => 'UK'),
        4 => array('lat' => '25.7887116834402', 'long' => '-80.25099275566413', 'country' => 'US', 'region' => 'Miami', 'city' => 'FL'),
        5 => array('lat' => '40.704543629577046', 'long' => '-74.01075838066413', 'country' => 'US', 'region' => 'New York', 'city' => 'NY'),
        6 => array('lat' => '47.597790769918454', 'long' => '-122.32862947441413', 'country' => 'US', 'region' => 'Seattle', 'city' => 'WA')
    );
?>
<script>
/** google map code **/
	var geocoder = new google.maps.Geocoder();

	function initialize(lat, lon) {
	    if (lat == '[object Event]') {
	        lat = '-33.87375789373315';
	        lon = '151.2068037693116';
	    }

	    <?php foreach($locs as $loc):
	    	if(empty($loc)) {
				$loc['lat'] = 0;
	    	} else if(empty($locs)) {
				$loc['long'] = 0;
		    } else {}
		?>
	    var deflatLng = new google.maps.LatLng("<?php echo $loc['lat']?>", "<?php echo $loc['long']?>");
	    <?php endforeach; ?>
	    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
	        zoom: 3,
	        center: deflatLng,
	        mapTypeId: google.maps.MapTypeId.HYBRID
	    });
	    <?php foreach($locs as $loc): 
	    	if(empty($loc['lat'])) {
                $loc['lat'] = 0;
	    	} else if(empty($loc['long'])) {
				$loc['long'] = 0;
		    } else {}
	    ?>
	    	var infowindow = new google.maps.InfoWindow();
            marker = new google.maps.Marker({
                position: new google.maps.LatLng("<?php echo $loc['lat']?>", "<?php echo $loc['long']?>"),
                map: map,
                draggable: false,
                title: "<?php echo $loc['region'].", ".$loc['city']; ?>"
            });

            infowindow.setContent("<?php echo $loc['country']; ?>, <?php echo $loc['region']; ?>, <?php echo $loc['city']; ?>");
            infowindow.open(map, marker);
		<?php endforeach; ?>
	}
	
	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="datacenter-content">
    <h1>Our <span>Datacenters</span> are located at:</h1>
    <div id="mapCanvas" style="height: 430px; width: 980px;"></div>
    <p>We are offering different datacenter locations, choose one of our datacenter which suits you best.</p> 
</div>