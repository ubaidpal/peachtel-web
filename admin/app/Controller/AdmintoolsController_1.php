<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdmintoolsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        //*********************AUTHINTICATING********************
        //$this->Auth->authenticate = array('Form');  //setup
        //$this->Auth->allow(array(''));
        $this->Auth->allow('adminDashboard');
        //debug($this->Auth); exit;
    }

    public function adminlogin() {
        $this->layout = 'login';
        $this->autoRender = 'false';
        $this->set('title_for_layout', 'Login');
        if ($this->request->is('post')) {
            //debug($this->request->data); exit;
            $admin = $this->Tbladmin->find('first', array('conditions' => array('username' => $this->request->data['Tbladmin']['username'], 'password' => md5($this->request->data['Tbladmin']['password']))));
            //debug($user); exit;
//        $db_host="174.122.89.69";
//        $db_username = 'whmcsdev_whmcs';
//        $db_password = '(k6CV;oBVQ?z';
//        $db_name = 'whmcsdev_whmcs';
//        $con=mysql_connect($db_host, $db_username, $db_password)or die(mysql_error().' in line '.__LINE__);
//        mysql_select_db($db_name, $con)or die(mysql_error().' in line '.__LINE__);
//        $result=mysql_query("select * from tbladmin");
            //debug($admin['Tbladmin']); exit;
            if ($admin) {//debug($this->Auth->login($admin['Tbladmin'])); exit;
                if ($this->Auth->login($admin['Tbladmin'])) {
                    $clients = $this->remoteData("select id, email from  tblclients");
                    $this->Session->write('clients', $clients);
//                    debug($this->Session->read('clients'));
//                    exit;
                    $this->redirect($this->Auth->redirect());
                } else {
                    $this->Session->setFlash(__('<font style="color:red;">Invalid username or password, try again</font>'));
                }
            } else {
                $this->Session->setFlash(__('<font style="color:red;">Invalid username or password, try again</font>'));
            }
        }
    }

    public function adminDashboard() {
        //debug($this->Auth->user('password'));exit;
        $this->layout = 'adminDefault';
        //print_r($this->Session->read('clients')); exit;
        $this->set('clients', $this->Session->read('clients'));
    }

    public function billing() {
        $this->layout = 'adminDefault';
        $this->set('clients', $this->Session->read('clients'));
        $this->set('clientDetails', $this->Session->read('clientDetails'));
        if ($this->request->is('post')) {
            //ssssssdebug($this->request->data); exit;
            $s_field = $this->request->data["accIdentifier"];
            $s_value = $this->request->data['query'];
            $query = "Select * from  tblclients where " . $s_field . "='" . $s_value . "'";
            //debug($query); exit;
            $clientDetail = $this->remoteData($query);
            //print_r($clientDetail); exit;
            $this->Session->write("clientDetails", $clientDetail);
            $query = "Select * from tblinvoices where userid='" . $clientDetail[0]['id'] . "' ORDER BY date DESC";
            $billingHistory = $this->remoteData($query);
            $this->Session->write("clientbillingHistory", $billingHistory);
            //print_r($this->Session->read('clientbillingHistory')); exit;
            //debug($clientDetail); exit;
        }
        //debug($this->Session->read("clientDetails")); exit;
        $this->set('clientDetails', $this->Session->read("clientDetails"));
        $this->set('clientBillingHistory', $this->Session->read('clientbillingHistory'));
    }

    public function ajaxSearch() {
        $this->autoLayout = false;
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $s_field = $_REQUEST['column'];
            $s_value = $_REQUEST['value'];
            $query = "Select " . $s_field . " from  tblclients where  " . $s_field . " LIKE '" . $s_value . "%'";
            $clientDetail = $this->remoteData($query);
            if ($clientDetail['status'] == 'success') {
                echo json_encode($clientDetail);
            }
            else
                echo 'no data';
        }
    }

    public function pbx() {
        $this->layout = 'adminDefault';
    }

    public function provisioning() {
        $this->layout = 'adminDefault';
    }

    public function trunking() {
        $this->layout = 'adminDefault';
    }

    public function store() {
        $this->layout = 'adminDefault';
    }

    public function support() {
        $this->layout = 'adminDefault';
    }

    public function notes() {
        $this->layout = 'adminDefault';
    }

    public function quotes() {
        $this->layout = 'adminDefault';
    }

    public function logout() {
        $this->layout = "login";
        //debug($this->Auth); exit;
        $this->Session->setFlash('Successfully loged out.');
        $this->Session->destroy();
        //debug($this->Auth); exit;
        $this->redirect($this->Auth->logout());
    }

    public function remoteData($query) {
        //        $db_host="174.122.89.69";
        $db_host = "localhost";
        $db_username = 'reyaz'; // 'whmcsdev_whmcs';
        $db_password = '1234'; // '(k6CV;oBVQ?z';
        $db_name = 'whmcsdev_whmcs';
        $con = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error() . ' in line ' . __LINE__);
        mysql_select_db($db_name, $con) or die(mysql_error() . ' in line ' . __LINE__);
        $result = mysql_query($query) or die(mysql_error() . ' in line ' . __LINE__);
        //print_r(mysql_fetch_array($result, MYSQL_ASSOC)); exit;
        $i = 0;
        $data['status'] = 'error';
        if (mysql_num_rows($result) != 0) {
            $data['status'] = 'success';
        }
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            //$i++;//debug($row); exit;
            //foreach ($row as $key => $val):
            //debug($key); //exit;
            //if (!preg_match('/^[0-9]/', $key)) {
            $data[$i++] = $row; //[$i][$key] = $val;
            //}
            //endforeach;
        }
        //debug($data); exit;
        mysql_close($con);
        return $data;
    }

    public function whmcsInvoker($postfields) {
        $this->layout = 'null';
        $this->autoLayout = false;
        $this->autoRender = false;
        $url = "http://www.whmcs-developers.com/whmcs/includes/api.php"; # URL to WHMCS API file
        $postfields["username"] = $this->Auth->user('username');
        $postfields["password"] = $this->Auth->user('password');
        /*         * ** WHMCS XML API Sample Code *** */
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
        /*
          Debug Output - Uncomment if needed to troubleshoot problems
          echo "<textarea rows=50 cols=100>Request: ".print_r($postfields,true);
          echo "\nResponse: ".htmlentities($xml)."\n\nArray: ".print_r($arr,true);
          echo "</textarea>";
         */
    }

    function whmcsapi_xml_parser($rawxml) {
        $this->layout = 'null';
        $this->autoLayout = false;
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
