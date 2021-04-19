<?php
/*
function del_my_order($vars) {
   
   $username = $vars['params']['username'];
   $password =  $vars['params']['password'];
   $mserviceID = $vars['params']['serviceid'];

   $output = shell_exec('sudo /usr/local/bin/ddb.sh '.$mserviceID);



    $mds=ldap_connect("69.61.88.98", 389 );
    if ($mds) {
        $mr=ldap_bind($mds, "cn=admin,dc=itaki,dc=net", "test");
        $info["cn"]=$username;
        $info["uid"]=$username;
        $info["userpassword"]=$password;
        $info["sn"] = $username . " user";
        $info["objectclass"][0] = "inetOrgPerson";
        $info["objectclass"][1] = "top";
        $mr = ldap_delete($mds, "cn=" . $username . ",ou=Users,dc=itaki,dc=net");
        ldap_close($mds);
    }
}

add_hook("AfterModuleTerminate",1,"del_my_order");
*/
?>
