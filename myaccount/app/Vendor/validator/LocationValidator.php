<?php

class LocationValidator {
    
    function validate($in_address1, $in_address2, $in_city, $in_state, $in_zip) {
        $usps_user_id = "199ARETT5175";
        $usps_passwd = "120OQ88ZM416";
        
        $company = "";//rawurlencode(trim("$company"));
        $address1 = $in_address1;
        $address2 = $in_address2;
        $city = $in_city;
        $state = $in_state;
        $zip5 = $in_zip;
        $zip4 = "";//trim("$zip4");

        $usps_url_code  = "http://production.shippingapis.com/";
        $usps_url_code .= "ShippingAPI.dll?";

        $usps_url_code .= "API=Verify&XML=";
        $usps_url_code2 = "<AddressValidateRequest USERID='$usps_user_id'>";
        $usps_url_code2 .= "<Address>";
        $usps_url_code2 .= "<FirmName>$company</FirmName>";
        $usps_url_code2 .= "<Address1>$address1</Address1>";
        $usps_url_code2 .= "<Address2>$address2</Address2>";
        $usps_url_code2 .= "<City>$city</City>";
        $usps_url_code2 .= "<State>$state</State>";
        $usps_url_code2 .= "<Zip5>$zip5</Zip5>";
        $usps_url_code2 .= "<Zip4>$zip4</Zip4>";
        $usps_url_code2 .= "</Address>";
        $usps_url_code2 .= "</AddressValidateRequest>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $usps_url_code.urlencode($usps_url_code2));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $xml = curl_exec($ch);

        if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.'<message>Connection Error</message><curlerror>'.curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
        curl_close($ch);

        $arr = $this->whmcsapi_xml_parser($xml);

        if(isset($arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ERROR']) || isset($arr['H1'])){
            if(isset($arr['H1'])) {
                return "ERROR";
            } else {
                return "ERROR: ".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ERROR']["DESCRIPTION"];
            }
        } else {
            $returnVar = "address1=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS2']."&";
            if(isset($arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS1'])){
                $returnVar .= "address2=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ADDRESS1']."&";
            }else{
                $returnVar .= "address2=&";
            }
            $returnVar .= "city=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['CITY']."&";
            $returnVar .= "state=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['STATE']."&";
            $returnVar .= "zip=".$arr['ADDRESSVALIDATERESPONSE']['ADDRESS']['ZIP5'];
            return $returnVar;
        }
    }
    
    function whmcsapi_xml_parser($rawxml) {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
        xml_parser_free($xml_parser);
        $params = array();
        $level = array();
        $alreadyused = array();
        $x=0;
        foreach ($vals as $xml_elem) {
            if ($xml_elem['type'] == 'open') {
                if (in_array($xml_elem['tag'],$alreadyused)) {
                    $x++;
                    $xml_elem['tag'] = $xml_elem['tag'].$x;
                }
                $level[$xml_elem['level']] = $xml_elem['tag'];
                $alreadyused[] = $xml_elem['tag'];
            }
            if ($xml_elem['type'] == 'complete') {
                $start_level = 1;
                $php_stmt = '$params';
                while($start_level < $xml_elem['level']) {
                    $php_stmt .= '[$level['.$start_level.']]';
                    $start_level++;
                }
            
                $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
                @eval($php_stmt);
            }
        }
        return($params);
    }
}
?>
