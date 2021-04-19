<?php
/*
 $mserviceID = $argv[1];

  if ($mserviceID!==' ') {

   $FromCTID = "500";
   $ToCTID = $mserviceID;

   $PBXDBUser = "jreiter";
   $PBXDBPassword = "bltr3df94pz12";
   $PBXDBHost = "69.61.88.13";
   $PBXDBList = array(
                '_freepbx',
                '_asteriskcdrdb',
                '_fop2'
                );

   $PBXDBConn = mysql_connect($PBXDBHost, $PBXDBUser, $PBXDBPassword);

   foreach ($PBXDBList as $DBSuffix) {

        $FromDB = $FromCTID . $DBSuffix;
        $ToDB = $ToCTID . $DBSuffix;

        $CurrentDB = mysql_select_db($FromDB, $PBXDBConn);
        if (!$CurrentDB) {
            die ("Cannot use $FromDB : " . mysql_error());
        }

        $DropDBSQL = "DROP DATABASE IF EXISTS $ToDB";
        mysql_query($DropDBSQL, $PBXDBConn);
        $CreateDBSQL = "CREATE DATABASE $ToDB";
        mysql_query($CreateDBSQL, $PBXDBConn);

        $MySqlReturn = mysql_list_tables($FromDB, $PBXDBConn);

        while ($row = mysql_fetch_row($MySqlReturn)) {
           $mTable=$row[0];
           $CloneTableSQL = "INSERT INTO $ToDB.$mTable SELECT * FROM $FromDB.$mTable";
           mysql_query($CloneTableSQL, $PBXDBConn);
        }
        mysql_free_result($MySqlReturn);
   }
}
*/

?>
