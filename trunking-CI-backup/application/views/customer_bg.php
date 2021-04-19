<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Customer billing groups</title>
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
        <h2>Customer billing groups </h2>
        <a class="right" href="<?php echo base_url(); ?>customers/bg_data/<?php echo $cid;?>">Create new billing group</a>
        <div class="clr"></div>
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Limit</td>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($bgs)) { ?>
                    <?php foreach ($bgs as $bg) { ?>
                        <tr>
                            <td><a href="<?php echo base_url(); ?>customers/bg_data/<?php echo $cid;?>/<?php echo $bg['id']; ?>"><?php echo $bg['descr']; ?></a></td>
                            <td>
                                <?php
                                    echo $bg['channel_limit'];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>
