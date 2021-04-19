<?php
    echo $this->Html->script(array('slider/jquery.nivo.slider.pack'));
    echo $this->Html->css(array('slider/nivo-slider', 'light/light'));
?>

<style>
    #flashMessage {
        display: inline-block;
        margin-left: 10px;
        vertical-align: top;
        width: 380px;
    }
</style>
<div id="slider_holder">
    <div id="images">
        <?php //echo $this->Html->image('/images/gallery/slide1.jpg'); ?>
        <div class="slider-wrapper theme-light">
            <div id="slider" class="nivoSlider">
                <img src="http://<?php echo $_SERVER['HTTP_HOST']."/myaccount/"; ?>images/gallery/slide3.jpg" data-thumb="images/gallery/slide3.jpg" alt="" title="PeachTEL offers you the most advanced business class telephone system at a reasonable price." />
                <a href="http://devwev.itaki.net/prestashop/">
                    <img src="http://<?php echo $_SERVER['HTTP_HOST']."/myaccount/"; ?>images/gallery/slide4.jpg" data-thumb="images/gallery/slide4.jpg" alt="" title="Get the Phones and Devices you need for your business. Click the image" />
                </a>
                <img src="http://<?php echo $_SERVER['HTTP_HOST']."/myaccount/"; ?>images/gallery/slide2.jpg" style="height: 403px !important; width: 532px !important;" data-thumb="images/gallery/slide2.jpg" alt="" title="Select a region of your choice or if you are having trouble selecting on what suits you best, we are happy to help you choose what's best." />
                <img src="http://<?php echo $_SERVER['HTTP_HOST']."/myaccount/"; ?>images/gallery/slide1.jpg" style="height: 403px !important; width: 532px !important;" data-thumb="images/gallery/slide1.jpg" alt="" title="Customer support. So you wont worry when you need help. We are happy to serve you anytime." />
            </div>
        </div>
    </div>
    <div id="content_buttons_holder">
        <div id="c_holder">
            <h2>PeachTEL.</h2>
            <p>offers you a low cost business class phone system with many great features.<br /><br /> Upgrade your phone system to the most advanced cloud based phone system available.</p>
            <div id="main_btn" style="margin-top:15px;"><a href="overview.html" style="text-decoration: none; color: #fff;">Read More</a></div>
        </div>
        <div id="b_holder">
            <a></a>
        </div>
    </div>
</div>
<div id="title_line"><label><span>PeachTEL</span> offers Trunking services for Phone Systems and a provisioning tool for many IP Phones. <span>PeachTEL</span> also offer telephone numbers across US and many other countries.</label><div id="main_btn"><a href="overview.html">Read More</a></div></div>
<div id="services_holder">
    <div id="left_holder">
        <h1>Our <span>Services</span></h1>
        <ul>
            <li>PBX Hosting</li>
            <li>Offer Phone Numbers</li>
            <li>Phone Provisioning</li>
            <li>Device Management</li>
            <li>Trunking Tool</li>
            <li>And so much more...</li>
        </ul>
        <br />
        <h1>Supported <span>Systems</span></h1>
        <ul>
            <li><a href="http://devweb.peachtel.net/prestashop/1_cisco" target="_blank">Cisco</a></li>
            <li><a href="http://devweb.peachtel.net/prestashop/2_polycom" target="_blank">Polycom</a></li>
            <li><a href="http://devweb.peachtel.net/prestashop/3_yealink" target="_blank">Yealink</a></li>
            <li><a href="http://devweb.peachtel.net/prestashop/4_asterisk" target="_blank">Asterisk</a></li>
            <li><a href="http://devweb.peachtel.net/prestashop/5_toshiba" target="_blank">Toshiba</a></li>
        </ul>
    </div>
    <div id="center_holder">
        <h1>Choose in our <span>4 different Datacenters</span></h1>
        <img src="images/gallery/map.jpg" />
        <p><span>PeachTEL</span> has multiple availability zones you can choose from.<p>
    </div>
    <div id="right_holder">
        <h1>Phones &<span> Devices</span></h1>
        <ul>
            <?php foreach($devices as $device): ?>
            <li>
                <?php
                    $url = $device['PsProduct']['id_product']."-".$device['PsProductLang']['link_rewrite'].".html";
                    echo "<a href='http://devweb.peachtel.net/prestashop/$url' target='_blank'>".$device['PsProductLang']['name']."</a>";
                ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <div id="main_btn" style="margin-top:15px;"><a href="http://devweb.peachtel.net/prestashop/" style="text-decoration: none; color: #fff;">See More...</a></div>
    </div>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
