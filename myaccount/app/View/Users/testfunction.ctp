<style>
	#show {
		color: #fff;
		height: 200px;
		width: 200px;
	background: red;
	}
</style>

<div id="content">	
    <div id="contentHeader">
        <h1>Test Function</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    	<?php
         
        $filename = "D:/web/myaccount/app/webroot/video\Wildlife.wmv";
        if (is_file($filename)) {

            $fd = fopen($filename, "r");
            $data = fopen('data.txt', 'w+');
            while(!feof($fd)) {
            	fwrite($data, fread($fd, 1024 * 5));
		        ob_flush();
		        flush();
            }
            fclose($data);
            fclose ($fd);
            exit();
        }

    	?>
    </div> <!-- .container -->
</div> <!-- #content -->
	
<script>
$("#click").click(function() {


});
</script>