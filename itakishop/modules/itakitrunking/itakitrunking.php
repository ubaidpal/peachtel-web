<?php 
    if (!defined('_PS_VERSION_'))
    exit;

    class ItakiTrunking extends Module {
        public function __construct() {
            $this->name = 'itakitrunking';
            $this->tab = 'Itaki Trunking';
            $this->version = 1.0;
            $this->author = 'Itakinet';
            $this->need_instance = 0;
            
            parent::__construct();

            $this->displayName = $this->l('Itaki Trunking');
            $this->description = $this->l('Itaki trunking tool.');
        }
        
        public function install() {
            if (parent::install() == false)
            return false;
            return true;
        }
        
        public function uninstall() {
            if (!parent::uninstall())
                Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'itakitrunking`');
            parent::uninstall();
        }
        
        public function hookCustomerAccount($params) {
            global $smarty;

            $postfields["action"] = "getclientsdetails";
            $postfields["email"] = 'danielmanis@gmail.com';
            
            /**
            echo "<pre>";
            print_r($this->whmcsInvoker($postfields));
            echo "</pre>";
             * 
             */
            $userData = $this->whmcsInvoker($postfields);
            //$this->provisioning();
            $smarty->assign('userData', $userData);
            
            return $this->display(__FILE__, 'itakitrunking.tpl'); // this is your .tpl file. You can add css/javascript links in your tpl file.
        }
        
        public function hookRightColumn($params){
            global $smarty;

            $postfields["action"] = "getclientsdetails";
            $postfields["email"] = 'danielmanis@gmail.com';

            // @todo this variable seems not used
            $userData = $this->whmcsInvoker($postfields);
            $smarty->assign('userData', $userData);
            return $this->display(__FILE__, 'itakitrunking.tpl'); // this is your .tpl file. You can add css/javascript links in your tpl file.
        }
        
        public function whmcsInvoker($postfields) {
            $this->autoRender = false;
            //$url = "http://www.whmcs-developers.com/whmcs/includes/api.php"; # URL to WHMCS API file
            //112.203.65.104
            $url = 'http://devweb.itaki.net/clients/includes/api.php';
            //$admin = $this->Session->read('adminUser');
            //debug($admin['password']);
            $postfields["username"] = 'vladmin';
            $postfields["password"] = '750de8cc22b9573340b4548365adc6ab';

            /*         * ** WHMCS XML API Sample Code *** */
            $postfields["stats"] = true;
            $postfields["responsetype"] = "xml";
            $query_string = "";
            foreach ($postfields AS $k => $v)
                $query_string .= "$k=" . urlencode($v) . "&";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $xml = curl_exec($ch);
            if (curl_error($ch) || !$xml)
                $xml = '<whmcsapi><result>error</result>' .
                        '<message>Connection Error</message><curlerror>' .
                        curl_errno($ch) . ' - ' . curl_error($ch) . '</curlerror></whmcsapi>';
            curl_close($ch);
            $data = $this->whmcsapi_xml_parser($xml); # Parse XML
            return ($data);
        }
        
        public function whmcsapi_xml_parser($rawxml) {
            $this->autoRender = false;
            $xml_parser = xml_parser_create();
            xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
            xml_parser_free($xml_parser);
            $params = array();
            $level = array();
            $alreadyused = array();
            $x = 0;
            foreach ($vals as $xml_elem) {
                if ($xml_elem['type'] == 'open') {
                    if (in_array($xml_elem['tag'], $alreadyused)) {
                        $x++;
                        $xml_elem['tag'] = $xml_elem['tag'] . $x;
                    }
                    $level[$xml_elem['level']] = $xml_elem['tag'];
                    $alreadyused[] = $xml_elem['tag'];
                }
                if ($xml_elem['type'] == 'complete') {
                    $start_level = 1;
                    $php_stmt = '$params';
                    while ($start_level < $xml_elem['level']) {
                        $php_stmt .= '[$level[' . $start_level . ']]';
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