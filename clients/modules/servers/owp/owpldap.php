<?php
    $mds=ldap_connect("69.61.88.98", 389 );
    if ($mds) {
        $mr=ldap_bind($mds, "cn=admin,dc=itaki,dc=net", "test");
        $info["cn"]="testa";
        $info["uid"]="testa";
        $info["userpassword"]="testa";
        $info["sn"] = "testa user";
        $info["objectclass"][0] = "inetOrgPerson";
        $info["objectclass"][1] = "top";
        $mr = ldap_add($mds, "cn=testa,ou=Users,dc=itaki,dc=net", $info);
        ldap_close($mds);
    }

?>
