<?php
function cmp($a, $b) {
    return strcmp($a["Register"], $b["Register"]);
}

if($_GET['method'] == 'get') {
    $macid = $_GET['macid'];
    $query = "Select * from macids as MI
                INNER JOIN phonedatas as PD ON PD.MacID = MI.id
                LEFT JOIN brandmodels as BM ON PD.Field = 'BrandModel.Id' AND BM.id = PD.Data
                where MI.MacID = '$macid'";
}
$db_host = 'localhost';
$db_username = 'VoipLionU1';
$db_password = 'cde$33MC';
$db_name = 'voipapp';

$con = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error() . ' in line ' . __LINE__);
mysql_select_db($db_name, $con) or die(mysql_error() . ' in line ' . __LINE__);
$result = mysql_query($query) or die(mysql_error() . ' in line ' . __LINE__);

$i = 0;
$data = array();
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    
    if($i == 0) {
        $data = array(
            'id' => $row['MacID'],
            'MacID' => $macid,
            'AccountID' => $row['AccountID'],
        );
    }

    
    if(!isset($data['Phonedata'][$row['ButtonNum']])) { $data['Phonedata'][$row['ButtonNum']] = array(); }
    if($row['ButtonNum'] == 0 && $row['Field'] == 'BrandModel.id') {
        
        $data['Phonedata'][0]['FriendlyName'] = $row['FriendlyName'];
        $data['Phonedata'][0]['Brand'] = $row['Brand'];
        $data['Phonedata'][0]['Family'] = $row['Family'];
    }
    $push = array($row['Field'] => $row['Data']);
    $data['Phonedata'][$row['ButtonNum']] = array_merge($push, $data['Phonedata'][$row['ButtonNum']]);
    $i++;
}  
$data['Phonedata'][0]['Register'] = 0;
usort($data['Phonedata'], "cmp");

mysql_close($con);

/**
echo "<pre>";
print_r($data);
echo "</pre>";
*/

print_r(json_encode($data));
