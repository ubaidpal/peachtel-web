<?php

function fb() {
    global $debug;
    $debug = true;
    global $firePhpObj;
    if (!$debug) {
        return false;
    }

    //include firePHP only for PHP 5!
    if (floor(phpversion()) < 5) {
        //log_message('error', 'PHP 5 is required to run FirePHP');
    } else {
        if (!class_exists('firephp')) {
            $firephp_file = "firephp.php";
            if (file_exists($firephp_file)) {
                require_once($firephp_file);

                $firePhpObj = new FirePHP();
            } else {
                return FALSE;
            }
        }
        $args = func_get_args();
        if (count($args)) {
            ob_start();
            print_r($args[0]);
            $output = ob_get_clean();

            //file_put_contents(absolute_path().'_protect/fb.log',date("Y-m-d h:i:s ").(isset($args[1]) ? $args[1] : "").": ".$output."\n",FILE_APPEND);

            return call_user_func_array(array($firePhpObj, 'fb'), $args);
        }
    }
    return FALSE;
}

?>
