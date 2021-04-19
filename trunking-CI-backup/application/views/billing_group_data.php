<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Billing Group</title>
        <style type="text/css">

            ::selection{ background-color: #E13300; color: white; }
            ::moz-selection{ background-color: #E13300; color: white; }
            ::webkit-selection{ background-color: #E13300; color: white; }

            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            a.right {
                float: right;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            h2 {
                width: auto;
                float: left;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #body{
                margin: 0 15px 0 15px;
            }

            p.footer{
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
            }

            #container{
                margin: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }
            .clr {
                clear: both;
                width: 99%;
                height: 1px;
            }
        </style>
    </head>
    <body>
        <h2>Billing Group</h2>
        <div class="clr"></div>
        <form action="<?php echo base_url(); ?>customers/bg_data/<?php echo $cid;?>" method="post">
            <?php if (isset($bgs)) { ?>
                <input type="hidden" name="id" value="<?php echo $bgs[0]['id']; ?>" />
            <?php } ?>
            <input type="hidden" name="customer_id" value="<?php echo $cid; ?>" />
            <ol>
                <li>
                    <label for="descr">Name</label>
                    <input type="text" <?php if (isset($bgs)) {echo 'value="' . $bgs[0]['descr'] . '"';} ?> name="descr" id="name">
                </li>
                <li>
                    <label for="ingress_dnis_strip_digits">Ingress DNIS Strip Digits</label>
                    <input type="text" value="0" name="ingress_dnis_strip_digits" id="ingressDnisStripDigits">
                </li>
                <li>
                    <label for="ingress_dnis_prepend_prefix">Ingress Dnis Prepend Prefix</label>
                    <input type="text" value="0" name="ingress_dnis_prepend_prefix" id="ingressDnisPrependPrefix">
                </li>
                <li>
                    <label for="channel_limit">Channel Limit</label>
                    <input type="text" <?php if (isset($bgs)) {echo 'value="' . $bgs[0]['channel_limit'] . '"';} else { echo 'value="0"';} ?> name="channel_limit" id="channelLimit">
                </li>
                <li>
                    <label for="ingress_ani_strip_digits">Ingress Ani Strip Digits</label>
                    <input type="text" value="0" name="ingress_ani_strip_digits" id="ingressAniStripDigits">
                </li>
                <li>
                    <label for="ingress_ani_prepend_prefix">Ingress Ani Prepend Prefix</label>
                    <input type="text" value="0" name="ingress_ani_prepend_prefix" id="ingressAniPrependPrefix">
                </li>
                <li>
                    <label for="notify_email">Notify Email</label>
                    <input type="text" value="0" name="notify_email" id="notifyEmail">
                </li>
                <li>
                    <label for="vendor_term_group_id">Termination Group</label>
                    <select name="vendor_term_group_id">
                        <option selected="selected" value="1">Default</option>
                    </select>
                </li>

                <li>
                    <label for="term_rate_plan_id">Termination Rate Plan</label>
                    <select name="term_rate_plan_id">
                        <option selected="selected" value="1">Global</option>
                    </select>
                </li>

                <li>
                    <label for="proxy_media">Proxy Media</label>
                    <input type="radio" value="1" name="proxy_media">Yes &nbsp;&nbsp;
                    <input type="radio" checked="checked" value="0" name="proxy_media">No
                </li>
                <li class="submit">
                    <input type="submit" name="submit" value="Save" />
                </li>

            </ol>
        </form>
    </body>
</html>
