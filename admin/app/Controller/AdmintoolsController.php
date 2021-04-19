<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::import("Vendor","vrcloud/config");
App::import("Vendor","durabledns/durable_include");
class AdmintoolsController extends AppController {

    public $uses= array(
        'Activity',
        'BillingGroup', 
        'Cdr', 
        'Customer', 
        'CreditControll', 
        'DestinationGateway',
        'FraudCtrlPref', 
        'MasterBillingGroup', 
        'Nextusa', 
        'OriginationRoute', 
        'OriginationRouteCostDest',
        'PsProduct',
        'Server',
        'PsCustomer',
        'QbAdminBillType',
        'QbAdminDisplayType',
        'QbAdminCategory',
        'Subscriber', 
        'Tblhosting', 
        'Tblticket', 
        'Tblticketdepartment', 
        'Tblticketreply', 
        'Tblclient', 
        'Tblnote',
        'Tblproductgroup',
        'Tblproduct',
        'VendorOriginationRoute'
    );
    
    public function beforeFilter() {
        set_time_limit(0);
        parent::beforeFilter();
        //*********************AUTHINTICATING********************
        //$this->Auth->authenticate = array('Form');  //setup
        //$this->Auth->allow(array(''));
        //$this->Auth->allow('ajaxSearch');
        //debug($this->Auth); exit;
        $withParams = array(
            'get_ticket'
        );
        if(in_array($this->action, $withParams)) {
            if(empty($this->params['tid']))
                $this->redirect('/admintools/support/');
        }
    }

    public function index() {
        $this->autoRender = false;
        $this->redirect(array("controller" => "admintools", "action" => "adminDashboard"));
    }

    /*     * ******************************** admin login for local*************
      public function adminlogin() {
      $this->layout = 'login';
      $this->autoRender = 'false';
      $this->set('title_for_layout', 'Login');
      if ($this->request->is('post')) {
      //debug($this->request->data); exit;
      //$query = "Select first from tbladmin where username='" . $this->request->data['Tbladmin']['username'] . "' AND password='" . md5($this->request->data['Tbladmin']['password']) . "'";
      print_r($query);
      exit;
      //$admin = $this->Tbladmin->find('first', array('conditions' => array('username' => $this->request->data['Tbladmin']['username'], 'password' => md5($this->request->data['Tbladmin']['password']))));

      if ($admin) {//debug($this->Auth->login($admin['Tbladmin'])); exit;
      if ($this->Auth->login($admin['Tbladmin'])) {
      $clients = $this->remoteData("select id, email from  tblclients");
      $this->Session->write('clients', $clients);
      //                    debug($this->Session->read('clients'));
      //                    exit;
      //$this->redirect($this->Auth->redirect());
      } else {
      $this->Session->setFlash(__('<font style="color:red;">Invalid username or password, try again</font>'));
      }
      } else {
      $this->Session->setFlash(__('<font style="color:red;">Invalid username or password, try again</font>'));
      }
      }
      }
     * */
    /*     * ************CLIENT LOGIN******************** */

    public function clientlogin() {
        $this->layout = 'login';
    }

    public function adminlogin() {
        $this->layout = 'login';
        //$this->autoRender = 'false';
        $this->set('title_for_layout', 'Login');
        if ($this->request->is('post')) {
            if ($this->request->data['Admin']['username'] != "" && $this->request->data['Admin']['password'] != "") {
                //debug($this->request->data);

                $query = "Select * from tbladmins where username='" . $this->request->data['Admin']['username'] . "' AND password='" . md5($this->request->data['Admin']['password']) . "'";
                $adminuser = $this->remoteData($query);
                // print_r($adminuser); exit;
                if ($adminuser['status'] == 'success') {
                    $adminuser = $adminuser[0];
                    //debug($user['id']);
                    //exit;
                    $this->Session->write('adminUser', $adminuser);
                    //$_SESSION['adminUser']=$adminuser;
                    //debug($this->Session->read('adminUser'));
                    //exit;
                    $this->Session->write('id', $adminuser['id']);
                    //debug($this->Session->read('id')); exit;
                    $this->logActivity('Admin '.$adminuser['CLIENT']['EMAIL'].' has logged in.');
                    
                    $this->redirect(array("controller" => "admintools", "action" => "adminDashboard"));
                } else {
                    $this->Session->setFlash(__('Invalid username or password, try again'));
                    $this->redirect(array("controller" => "admintools", "action" => "adminlogin"));
                }
            } else {
                $this->Session->setFlash(__('Please enter a valid Username and password'));
            }
        }
    }

    /*     * ***********************************************CHECKS*********************************************** */

    public function userloggedIn() {
        $this->autoRender = false;
        if ($this->Session->read('id') != null)
            return true;
        $this->Session->setFlash(__('<font style="color:red;">Please Login first</font>'));
        $this->redirect(array("controller" => "admintools", "action" => "adminlogin"));
    }

    public function clientIdPresent() {
        $this->autoRender = false;
        if ($this->Session->read("clientDetails") != null)
            return true;
        $this->Session->setFlash('Search for a cleint first.');
        $this->redirect(array("controller" => "admintools", "action" => "adminDashboard"));
    }

    /*     * ***************************************End Checks******************************************** */

    public function adminDashboard() {
        $fm = $this->Session->read('flash') == null ? "" : $this->Session->read('flash');
        $this->set('flashM', $fm);
        //debug($this->Session->read('flash')==null); exit;
        $this->Session->write('flash', "");
        if ($this->userloggedIn()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            //debug($this->Session->read('id')); exit;
            //$this->set('clients', $this->Session->read('clients'));
        }

            /**
            //debug($this->Session->read("clientDetails")); exit;
            $clientDetails = $this->Session->read('clientDetails');
            $clientTrunkID   = $clientDetails['CLIENT']['ID'];//$trunkName.$clientDetails['ID'];
            $clientTrunkData = $this->Customer->findCustomerByName($clientTrunkID);
            $customerBGs  = $this->BillingGroup->findCustomerBgs($clientTrunkData['Customer']['id']);

            $this->set(compact("customerBGs"));
            **/
    }

    public function billing() {
        if ($this->userloggedIn()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            if ($this->request->is('post')) {
                
                $s_field = $this->request->data["accIdentifier"];
                $s_value = $this->request->data['query'];
                if (($s_field == 'id' || $s_field == 'email') && $s_value != "") {  //for searching a client detail********
                    //debug($this->request->data);
                    //exit;
                    //$query = "Select * from  tblclients where " . $s_field . "='" . $s_value . "'";
                    //print_r($query); exit;
                    //$clientDetail = $this->remoteData($query);
                    //*****************************************WHMCS API
                    $postfields["action"] = "getclientsdetails";
                    if ($s_field == "id")
                        $postfields["clientid"] = $s_value;
                    else if ($s_field == "email")
                        $postfields["email"] = $s_value;
                    //debug($postfields); exit;
                    $clientDetail = $this->whmcsInvoker($postfields);
                    sleep(2);
                    $clientDetail = $clientDetail['WHMCSAPI'];
                    //debug($clientDetail); //************************************APICALL
                    //exit;
                    if ($clientDetail['RESULT'] == 'success') {
                        //debug($clientDetail); exit;
                        $this->Session->write("clientDetails", $clientDetail);

                        $query = "Select * from tblinvoices where userid='" . $clientDetail['CLIENT']['ID'] . "' ORDER BY date DESC";
                        //print_r($query); exit;
                        $billingData = $this->remoteData($query);
                        //print_r($billingData);exit;
                        if ($billingData['status'] == "success") {  //billing data found
                            $this->Session->write("clientbillingHistory", $billingData);
                            // debug($billingData); exit;
                        }
                        $this->redirect(array("controller" => "admintools", "action" => "billing"));
                    } else {
                        $this->Session->write('flash', "No client related to  " . $s_field . " = " . $s_value);
                        $this->redirect(array("controller" => "admintools", "action" => "adminDashboard"));
                    }
                } else {
                    //$this->Session->setFlash(__('<font style="color:red;">Enter Valid credentials</font>'));
                    $this->Session->write('flash', 'Enter Valid credentials');
                    //$this->Session->setFlash("No client related to client having " . $s_field . " : " . $s_value);
                    $this->redirect(array("controller" => "admintools", "action" => "adminDashboard"));
                }
            }
            //debug($this->Session->read("clientDetails")); exit;
            $this->set('clients', $this->Session->read('clients'));
            $this->set('clientDetails', $this->Session->read('clientDetails'));
            $this->set('clientBillingHistory', $this->Session->read('clientbillingHistory'));
        }
        //debug('at end'); exit;
    }

    public function changeClientStatusInWHMCS() {
        $this->autoRender = false;
        if ($this->request->is('ajax') && ($this->clientIdPresent())) {
            $adminUser = $this->Session->read('adminUser');
            $currentClient = $this->Session->read('clientDetails');
            $postfields["action"] = "updateclient";
            $postfields["clientid"] = $currentClient['CLIENT']['ID'];
            $postfields["status"] = $this->request->data['status'];
            $status = $this->whmcsInvoker($postfields);
            if ($status['WHMCSAPI']['RESULT'] == 'success') {
                $response['done'] = true;
                $currentClient['CLIENT']["STATUS"] = $this->request->data['status'];
                $this->logActivity('Updated '.$currentClient['CLIENT']['EMAIL'].' status to '.$postfields["status"]);
                $this->Session->write('clientDetails',$currentClient);
            } else {
                $response['done'] = false;
            }
            echo json_encode($response);
        }
    }

    public function ajaxSearch() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $s_field = $_REQUEST['column'];
            $s_value = $_REQUEST['value'];
            $query = "Select " . $s_field . " from  tblclients where  " . $s_field . " LIKE '" . $s_value . "%'";
            $clientDetail = $this->remoteData($query);
            //print_r($clientDetail); exit;
            if ($clientDetail['status'] == 'success') {
                echo json_encode($clientDetail);
            } else {
                echo 'no data';
            }
        }
    }

    public function pbx() {
        if ($this->clientIdPresent() && $this->clientIdPresent()) {

            $this->autoRender = true;
            $this->layout = 'adminDefault';
            $currentClient = $this->Session->read('clientDetails');

            $userActiveHostings = $this->Server->find('all', array('conditions' => array('user_id' => $currentClient['CLIENT']['ID'])));

            $this->set(compact('userActiveHostings'));
        }
    }  

    public function pbx_provision($hid) {
        $this->layout = 'adminDefault';
        $hosting = $this->Server->findById($hid);

        if($this->request->data) {
            $fqdn = explode('.', $hosting['Server']['domain']);
            $vr = new vr_cloud(VR_API_KEY, $fqdn[0]);
            $password = $this->_generateStrings(16);
            $server = $vr->build($this->request->data['location'], 3323, $hosting['Server']['domain'], $password);

            if(isset($server->id)) {
                $this->Server->id = $hid;

                $data = array(
                    'location' => $this->request->data['location'],
                    'image' => 3323,
                    'status' => 'Active',
                    'password' => $password,
                    'build_id' => $server->id
                );

                $this->Server->save($data);
                $this->createDNS($fqdn[0]);

                $this->redirect('pbx');
            } else {
                $this->redirect('pbx');
            }
        }

        $vr = new vr_cloud(VR_API_KEY);
        $vrlocations = $vr->locations();

        foreach($vrlocations as $location)
            $locations[$location->id] = $location->name;

        $this->set(compact('hosting', 'locations'));
    }

    public function pbx_stop($hid) {
        $this->autoRender = false;
        $hosting = $this->Server->findById($hid);
        $id = explode('.', $hosting['Server']['domain']);
        $vr = new vr_cloud(VR_API_KEY, $id[0]);
        $return = $vr->shutdown(1);

        if(isset($return->id)) {
            $this->Session->setFlash(_("Server has been stopped successfully."));
            $this->redirect('pbx');
        } else {
            $this->Session->setFlash(_("Failed to process request."));
            $this->redirect('pbx');
        }
    }

    public function pbx_restart($hid) {
        $this->autoRender = false;
        $hosting = $this->Server->findById($hid);
        $id = explode('.', $hosting['Server']['domain']);
        $vr = new vr_cloud(VR_API_KEY, $id[0]);
        $return = $vr->reboot(1);

        if(isset($return->id)) {
            $this->Session->setFlash(_("Server has been restarted successfully."));
            $this->redirect('pbx');
        } else {
            $this->Session->setFlash(_("Failed to process request."));
            $this->redirect('pbx');
        }
    }

    public function pbx_start($hid) {
        $this->autoRender = false;
        $hosting = $this->Server->findById($hid);
        $id = explode('.', $hosting['Server']['domain']);
        $vr = new vr_cloud(VR_API_KEY, $id[0]);
        $return = $vr->start();

        if(isset($return->id)) {
            $this->Session->setFlash(_("Server has been started successfully."));
            $this->redirect('pbx');
        } else {
            $this->Session->setFlash(_("Failed to process request."));
            $this->redirect('pbx');
        }
    }

    public function createDNS($name) {
        $this->autoRender = false;
        $dns = new DurableDNSHandler();
        $hostings = $this->Server->find('first', array('conditions' => array('domain' => $name.".itaki.net")));
        if($hostings) {

            $vr = new vr_cloud(VR_API_KEY, $name);
            $server = $vr->server();
            $dns->zonename = "itaki.net.";
            $dns->recordname = $name;
            $dns->recordtype = "A";
            $dns->recorddata = $server->ip;
            $dns->ttl = '86400';
            $dns->CreateRecord();

            if(!$dns->error) {
                return true;
            } else {
                $this->Session->setFlash(_("Failed to register DNS please contact your administrator about this issue."));
                return false;
            }
        }
        return false;
    }

    public function provisioning() {
        
        if ($this->clientIdPresent() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            $this->set('title_for_layout', 'Provisioning');
            $currentClient = $this->Session->read('clientDetails');
            
            $brandList = $this->Brandmodel->find("list", array('fields' => array('Brand', 'Brand'), 'group' => 'Brand'));
            $frendlynameList = $this->Brandmodel->find("list", array('fields' => 'FriendlyName', 'conditions' => array('Brandmodel.Brand' => 'polycom')));
            
            $macAddresses = $this->Macid->find('all', array('conditions' => array('AccountID' => $currentClient['CLIENT']['USERID'])));
            $data = array();
            $bm = '';
            foreach($macAddresses as $key => $ma) {
                $data[$key]['Macid'] = $ma['Macid'];
                foreach($ma['Phonedata'] as $pd) {
                    
                    if(!isset($data[$key]['Phonedata'][$pd['ButtonNum']])) {$data[$key]['Phonedata'][$pd['ButtonNum']] = array();}
                    
                    if($pd['Field'] == 'BrandModel.id') {
                        $bm = $this->Brandmodel->findById($pd['Data']); 
                        $data[$key]['Phonedata'][0]['Brandmodel'] = $bm['Brandmodel'];
                    }
                    
                    $push = array('MacID' => $pd['MacID'], $pd['Field'] => $pd['Data']);
                    $data[$key]['Phonedata'][$pd['ButtonNum']] = array_merge($push, $data[$key]['Phonedata'][$pd['ButtonNum']]);
                }
            }
            $macAddresses = $data;

            $bolPhonesProvisioned = false;
            if(!empty($macAddresses)) {
                $bolPhonesProvisioned = true;
            }
            
            $this->set(compact('brandList', 'frendlynameList', 'macAddresses', 'bolPhonesProvisioned'));
        }
    }
    
    public function check_mac_addr() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $mac = $this->request->data['mac'];
            $currentClient = $this->Session->read('clientDetails');
            
            $isRegistered = $this->Macid->find('first', array('conditions' => array('MacID' => $mac, 'AccountID' => $currentClient['CLIENT']['USERID'])));
                        
            if(!empty($isRegistered)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function editTemplate() {
        $this->layout = false;
        if ($this->request->is('ajax')) {
            App::import("Vendor", "provisioner/merge_data");
            $provisioner = new provisioner();
            $macID = $this->request->data['macId'];
            $conditions = array('Phonedata.MacID' => $macID, 'OR' => array(array('Phonedata.Field' => 'BrandModel.id'), array('Phonedata.Field' => 'lineOptionsRaw')));
            $phone = $this->Phonedata->find('all', array('conditions' => $conditions));
            
            $conditions = array('Phonedata.MacID' => $macID, 'Phonedata.Field' => 'registrations', 'Phonedata.ButtonNum' => '0' );
            $reg = $this->Phonedata->find('first', array('conditions' => $conditions));

            foreach($phone as $ph) {
                if($ph['Phonedata']['Field'] == 'BrandModel.id') {
                    $phone = $ph;
                } else {
                    $form = $ph;
                }
            }
            if(isset($form)) {
                $formdata = json_decode($form['Phonedata']['Data'], TRUE);
            }
            $mac = $phone['Macid']['MacID'];
            
            $phonedata = $this->Brandmodel->findById($phone['Phonedata']['Data']);
            $json_data = $provisioner->mergeData('data', strtolower($phonedata['Brandmodel']['Brand']), $phonedata['Brandmodel']['Family'], $phonedata['Brandmodel']['FriendlyName']);

            $html_array = $this->generate_gui_html(json_decode($json_data, TRUE), $reg['Phonedata']['Data']);
            $this->set(compact('html_array', 'phonedata', 'mac', 'macID', 'formdata'));
        }
    }
    
    public function saveTemplate() {
        
        $this->autoRender = false;
        $form = $this->request->data;
        foreach($this->request->data as $key => $data) {
            if(preg_match("/lineloop\|(.*)\|(.*)/i",$key,$matches)) {
                
                $stuff = $matches;
                $line = $stuff[1];
                $var = $stuff[2];
                $req = $stuff[0];

                $line_options['line'][$line][$var] = $this->request->data[$req];
                $line_options['line'][$line]['line'] = $line;
                unset($this->request->data[$req]);
                
            } elseif(preg_match("/loop\|.*\|(.*)_([\d]*)_(.*)/i",$key,$matches)) {
                
                $stuff = $matches;		
                $loop = $stuff[1];
                $var = $stuff[3];
                $count = $stuff[2];
                $req = $stuff[0];

                $loops_options[$loop][$count][$var] = $this->request->data[$req];
                unset($this->request->data[$req]);
                
            } elseif(preg_match("/option\|(.*)/i",$key,$matches)) {
                
                $stuff = $matches;
                $var = $stuff[1];
                $req = $stuff[0];

                $options[$var] = $this->request->data[$req];
                unset($this->request->data[$req]);
                
            } elseif(preg_match("/line_static\|(.*)\|(.*)/i",$key,$matches)) {
                
                $stuff = $matches;
                $line = $stuff[1];
                $var = $stuff[2];
                $req = $stuff[0];

                $line_static[$line][$var] = $this->request->data[$req];
                unset($this->request->data[$req]);
                
            }
        }
        
        if(!empty($loops_options) && !empty($options)) {
            $final_ops2 = array_merge($loops_options,$options);
        } elseif(empty($loops_options) && !empty($options)) {
            $final_ops2 = $options;
        } elseif(!empty($loops_options) && empty($options)) {
            $final_ops2 = $loops_options;
        }
        $lineOpt = json_encode($final_ops2);
        $data = array(
            0 => array(
                'MacID' => $this->request->data['macID'],
                'ButtonNum' => 0,
                'Field' => 'lineOptions',
                'Data' => $lineOpt
            ),
            1 => array(
                'MacID' => $this->request->data['macID'],
                'ButtonNum' => 0,
                'Field' => 'lineOptionsRaw',
                'Data' => json_encode($form)
            )
        );
        
        $conditions = array(
            'Phonedata.MacID' => $this->request->data['macID'],
            'OR' => array(
                array('Field' => 'lineOptions'),
                array('Field' => 'lineOptionsRaw')
            )
        );
        $this->logActivity('Updated MAC template ID #'.$this->request->data['macID']);
        if($this->Phonedata->deleteAll($conditions)) {
            $this->Phonedata->saveAll($data);
            $this->redirect('provisioning');
        } else {
            $this->Phonedata->saveAll($data);
            $this->redirect('provisioning');
        }
    }
    
    public function generate_gui_html($cfg_data, $max_lines = 1) {
        if ($this->request->is('ajax')) {
            //take the data out of the database and turn it back into an array for use

            $template_variables_array = array();
            $group_count = 0;
            $variables_count = 0;

            //$globals = $cfg_data['data']['globals'];
            //unset($cfg_data['data']['globals']);
            for($a=1;$a <= $max_lines; $a++) {
                $template_variables_array[$group_count]['title'] = "Line Information for Line ".$a;
            }
            $line_count = 1;
            foreach($cfg_data['data'] as $key => $data) {

                $template_variables_array[$group_count]['title'] = $key;
                $variables_count = 0;
                foreach($data as $key2 => $data2) {
                    foreach($data2 as $key3 => $data3) {
                        preg_match('/(.*)\|(.*)/i',$key3,$matches);				
                        $type = $matches[1];
                        $variable = $matches[2];
                        switch($type) {
                            case "option":
                                if(isset($data3[0]['description'])) {
                                    $data3[0]['description'] = str_replace('{$count}',$a,$data3[0]['description']);
                                    $key = $type."|".str_replace('$','',$data3[0]['variable']);
                                    $template_variables_array[$group_count]['data'][$variables_count] = $this->generate_form_data($variables_count,$data3[0],$key);
                                    $variables_count++;
                                }
                                break;
                            case "lineloop":
                                if($line_count <= $max_lines) {
                                    foreach($data3 as $items) {
                                        $a = $items['line_count'];
                                        if(isset($items['description'])) {
                                            $items['description'] = str_replace('{$count}',$a,$items['description']);
                                            $key = $type."|".$a."|".str_replace('$','',$items['variable']);
                                        }
                                        $items[$variables_count] = $items;

                                        if($items['variable'] == '$line_enabled') {
                                            $items['default_value'] = TRUE;
                                        }
                                        $template_variables_array[$group_count]['data'][$variables_count] = $this->generate_form_data($variables_count,$items,$key);
                                        $template_variables_array[$group_count]['data'][$variables_count]['looping'] = TRUE;
                                        $variables_count++;
                                    }
                                }
                                $template_variables_array[$group_count]['data'][$variables_count]['type'] = 'break';
                                $variables_count++;
                                $line_count++;
                                break;
                            case "loop":
                                foreach($data3 as $items) {
                                    $a = $items['loop_count'];
                                    if(isset($items['description'])) {
                                        $items['description'] = str_replace('{$count}',$a,$items['description']);
                                        $key = $type."|".$a."|".str_replace('$','',$items['variable']);
                                    }
                                    $items[$variables_count] = $items;
                                    $template_variables_array[$group_count]['data'][$variables_count] = $this->generate_form_data($variables_count,$items,$key);
                                    $template_variables_array[$group_count]['data'][$variables_count]['looping'] = TRUE;
                                    $variables_count++;
                                }
                                break;

                            default:
                                break;
                        }
                    }
                }
                $group_count++;
            }
            return($template_variables_array);
        }
    }
    
    function generate_form_data ($i, $cfg_data, $key=NULL) {
        if ($this->request->is('ajax')) {
            switch ($cfg_data['type']) {
                case "input":
                    $template_variables_array['type'] = "input";
                    $template_variables_array['max_chars'] = isset($cfg_data['max_chars']) ? $cfg_data['max_chars'] : '';
                    $template_variables_array['key'] = $key;
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    $template_variables_array['description'] = $cfg_data['description'];
                    break;
                case "radio":
                    $template_variables_array['type'] = "radio";
                    $template_variables_array['key'] = $key;
                    $template_variables_array['description'] = $cfg_data['description'];
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    $z = 0;
                    while($z < count($cfg_data['data'])) {
                        $template_variables_array['data'][$z]['key'] = $key;
                        $template_variables_array['data'][$z]['value'] = $cfg_data['data'][$z]['value'];
                        $template_variables_array['data'][$z]['description'] = $cfg_data['data'][$z]['text'];
                        $z++;
                    }
                    break;
                case "list":
                    $template_variables_array['type'] = "list";
                    $template_variables_array['key'] = $key;
                    $template_variables_array['description'] = $cfg_data['description'];
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    $z = 0;
                    while($z < count($cfg_data['data'])) {
                        $template_variables_array['data'][$z]['value'] = $cfg_data['data'][$z]['value'];
                        $template_variables_array['data'][$z]['description'] = $cfg_data['data'][$z]['text'];
                        if (isset($cfg_data['data'][$z]['disable'])) {
                            $cfg_data['data'][$z]['disable'] = str_replace('{$count}', $z, $cfg_data['data'][$z]['disable']);
                            $template_variables_array['data'][$z]['disables'] = explode(",", $cfg_data['data'][$z]['disable']);
                        }
                        if (isset($cfg_data['data'][$z]['enable'])) {
                            $cfg_data['data'][$z]['enable'] = str_replace('{$count}', $z, $cfg_data['data'][$z]['enable']);
                            $template_variables_array['data'][$z]['enables'] = explode(",", $cfg_data['data'][$z]['enable']);
                        }
                        $z++;
                    }
                    break;
                case "checkbox":
                    $template_variables_array['type'] = "checkbox";
                    $template_variables_array['key'] = $key;
                    $template_variables_array['description'] = $cfg_data['description'];
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    $z = 0;
                    break;
                case "file";
                    $template_variables_array['type'] = "file";
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    if(isset($cfg_data['max_chars'])) {
                        $template_variables_array['max_chars'] = $cfg_data['max_chars'];
                    }
                    $template_variables_array['key'] = $key;
                    $template_variables_array['value'] = '';
                    $template_variables_array['description'] = $cfg_data['description'];
                    break;
                case "textarea":
                    $template_variables_array['type'] = "textarea";
                    $template_variables_array['value'] = isset($cfg_data['default_value']) && !empty($cfg_data['default_value']) ? $cfg_data['default_value'] : '';
                    if(isset($cfg_data['max_chars'])) {
                        $template_variables_array['max_chars'] = $cfg_data['max_chars'];
                    }
                    $template_variables_array['key'] = $key;
                    $template_variables_array['value'] = '';
                    $template_variables_array['description'] = $cfg_data['description'];
                    break;
                case "break":
                    $template_variables_array['type'] = "break";
                break;
                default:
                    $template_variables_array['type'] = "NA";
                    break;
            }

            if(isset($cfg_data['description_attr']['tooltip'])) {
                $template_variables_array['tooltip'] = $cfg_data['description_attr']['tooltip'];
            }
            return($template_variables_array);
        }
    }
    
    public function savePhoneData() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $currentClient = $this->Session->read('clientDetails');
            $this->request->data['Macid']['AccountID'] = $currentClient['CLIENT']['USERID'];
            
            if(isset($this->request->data['Macid']['id'])) {
                $this->Macid->id = $this->request->data['Macid']['id'];
            }
            
            $saveData['Macid'] = $this->request->data['Macid'];
            $i = 0;
            $keys = array();
            foreach($this->request->data['Phonedata'] as $phones) {
                foreach($phones as $key => $phone) {
                    $globals = array('DateTimeZone', 'AccountID', 'BrandModel.id', 'registrations', 'LocalPort', 'ExtensionNumber');
                    
                    if(in_array($key, $globals)) {
                        if(!in_array($key, $keys)) {
                            $saveData['Phonedata'][$i] = array(
                                'ButtonNum' => 0,
                                'Field' => $key,
                                'Data' => $phone
                            );
                            array_push($keys, $key);
                        }
                    } else {
                        $saveData['Phonedata'][$i] = array(
                            'ButtonNum' => $phones['Register'],
                            'Field' => $key,
                            'Data' => $phone
                        );
                    }
                    if(isset($this->request->data['Macid']['edit'])) {
                        $saveData['Phonedata'][$i]['MacID'] = $saveData['Macid']['id'];
                    }
                    $i++;
                }
            }
            
            if(isset($this->request->data['Macid']['edit'])) {
                ksort($saveData['Phonedata']);
                $this->Phonedata->deleteAll(array('Phonedata.Macid' => $saveData['Macid']['id'], 'NOT' => array('Phonedata.Field' => 'lineOptions', 'Phonedata.Field' => 'lineOptionsRaw')));
            }
            
            $data = 'passed';
            if($this->Macid->saveAll($saveData)) {
                $url = "http://devices.itaki.net/a.php?mac=".$this->request->data['Macid']['MacID']."&from_script=true";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $data = curl_exec($ch);
                curl_close($ch);
                
                if($data == 'failed') {
                    $this->Macid->delete(array('id' => $this->Macid->id));
                    return false;
                } else {
                    if(isset($this->request->data['Macid']['edit'])) {
                        $this->logActivity('Updated provisioned phone id #'.$saveData['Macid']['id']);
                        return true;
                    } else { 
                        $this->logActivity('Added new provisioned phone id #'.$this->Macid->getLastInsertID().' to '.$currentClient['CLIENT']['EMAIL']);
                        return $this->Macid->getLastInsertID();
                    }
                }
            } else {
                return false;
            }
        }
    }

    public function changeStdToArray($obj) {
        $this->autoRender = false;
        return get_object_vars($obj);
    }

    public function sendFriendlyNames() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $fname = $this->Brandmodel->find("list", array('fields' => array('id', 'FriendlyName'), 'conditions' => array('Brandmodel.Brand LIKE' => "%".$this->request->data['brand']."%")));
            echo json_encode($fname);
        }
    }
    
    public function editMac() {
        $this->layout = false;
        if ($this->request->is('ajax')) {
            $macData = $this->Macid->find('first', array('conditions' => array('Macid.id' => $this->request->data['macId'])));
            $editData = array();
            $bm = '';
            $editData['Macid'] = $macData['Macid'];
            foreach($macData['Phonedata'] as $pd) {

                if(!isset($editData['Phonedata'][$pd['ButtonNum']])) {$editData['Phonedata'][$pd['ButtonNum']] = array();}

                if($pd['Field'] == 'BrandModel.id') {
                    $bm = $this->Brandmodel->findById($pd['Data']); 
                    $editData['Phonedata'][0]['Brandmodel'] = $bm['Brandmodel'];
                }

                $push = array('MacID' => $pd['MacID'], $pd['Field'] => $pd['Data']);
                $editData['Phonedata'][$pd['ButtonNum']] = array_merge($push, $editData['Phonedata'][$pd['ButtonNum']]);
            }
            ksort($editData['Phonedata']);
            
            $this->set(compact('editData'));
        }
    }

    public function deleteMac() { //ajax called method
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if ($this->Macid->delete(array('id' => $this->request->data['macId']))) {
                $this->logActivity('Deleted provisioned phone id #'.$this->request->data['macId']);
                return true;
            } else {
                return false;
            }
        }
    }

    public function trunking() {
        if ($this->clientIdPresent() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            
            $client         = $this->Session->read('clientDetails');
            $clientDetails  = $client['CLIENT'];
            $clientTrunkID   = $clientDetails['ID'];
            
            $clientTrunkData = $this->Customer->findCustomerByName($clientTrunkID);
            if(empty($clientTrunkData)) {
                /** Transactional Models*/
                $this->Customer->begin();
                
                $data = array(
                    'descr' => $clientDetails['ID'],
                    'active' => false
                );
                
                if($this->Customer->save($data)) {
                    $custId = $this->Customer->getLastInsertID();
                    $data = array(
                        'MasterBillingGroup' => array(
                            'customer_id' => $custId,
                            'notify_email' => $clientDetails['EMAIL'],
                            'descr' => "MBG".$clientDetails['ID']
                        )
                    );
                    if($this->MasterBillingGroup->save($data)) {
                        $this->Customer->commit();
                        $this->Session->setFlash(_("CSRP account has been configured."));
                        $this->redirect('trunking');
                    } else {
                        $this->Customer->rollback();
                        $this->Session->setFlash(_("Failed to configure CSRP account."));
                        $this->redirect('trunking');
                    }
                }
            }
            
            
            $customerBGs  = $this->BillingGroup->findCustomerBgs($clientTrunkData['Customer']['id']);
            $vendor_prefs = $this->VendorOriginationRoute->find('list', array('fields' => array('id', 'prefix')));
            $cond         = array('OriginationRoute.customer_bg_id' => array_keys($customerBGs)); 
            $routes       = $this->OriginationRoute->find('all', array(
                'conditions' => $cond,
                'contain' => array('OriginationRouteCostDest', 'BillingGroup' => array('fields' => array('id', 'descr')))
            ));

            $this->set(compact('clientDetails', 'clientTrunkData', 'clientTrunkID', 'customerBGs', 'vendor_prefs', 'routes'));
        }
    }

    public function addDID() {
        $this->autoRender = false;  

        $dids = preg_split('/\r\n|[\r\n]/', $this->request->data['admintool']['prefix']);
        $vendor = $this->VendorOriginationRoute->find('first', array('order' => array('VendorOriginationRoute.id DESC')));
        $orig = $this->OriginationRoute->find('first', array('order' => array('OriginationRoute.id DESC')));
        $i= 1;
        foreach($dids as $key => $did) {
            if(!empty($did)) {
                $vendorRoute[] = array(
                    'id' => $vendor['VendorOriginationRoute']['id'] + $i,
                    'vendor_id' => '',
                    'active' => 't',
                    'descr' => $did,
                    'prefix' => $did,
                    'minute_cost' => $this->request->data['admintool']['per_min'],
                    'min_duration' => '6',
                    'duration_incr' => '6'
                );

                $origRoute[] = array(
                    'OriginationRoute' => array(
                        'id' => $orig['OriginationRoute']['id'] + $i,
                        'customer_bg_id' => $this->request->data['admintool']['trunk'],
                        'descr' =>  $did,
                        'prefix' => $did,
                        'orig_rate_id' => '1',
                        'active' => 't',
                    )
                );
                $origRouteDest[] = array(
                    'OriginationRouteCostDest' => array(
                        'orig_route_id' => $orig['OriginationRoute']['id'] + $i,
                        'priority' => 1,
                        'class_dest' => 'bg:'.$this->request->data['admintool']['trunk'],
                        'final' => 't'
                    )
                );
            }
            $i++;
        }
        $this->setDIDBg($vendorRoute, $origRoute, $origRouteDest);
    }

    public function setDIDBg($vendorRoute, $origRoute, $origRouteDest) {
        $this->VendorOriginationRoute->begin();
        if($this->VendorOriginationRoute->saveAll($vendorRoute)) {
            $this->OriginationRoute->begin();
            if($this->OriginationRoute->saveAll($origRoute)) {

                if($this->OriginationRouteCostDest->saveAll($origRouteDest)) {
                    $dids = $this->Session->write('dids', array());
                    $this->OriginationRoute->commit();
                    $this->VendorOriginationRoute->commit();
                } else {
                    $this->OriginationRoute->rollback();
                    $this->VendorOriginationRoute->rollback();
                }

            } else
                $this->VendorOriginationRoute->rollback();
        }
        $this->redirect('trunking');
    }

    public function updateDidBg() {
        $this->autoRender = false;
        $this->OriginationRoute->save($this->request->data);

        if(isset($this->request->data["withVendor"]) && $this->request->data["withVendor"]) {
            $vendor = $this->VendorOriginationRoute->find("first", array('conditions' => array('VendorOriginationRoute.prefix' => $this->request->data["did"])));
            //$this->VendorOriginationRoute->id =  $vendor["VendorOriginationRoute"]['id'];
            $data = array(
                'id' => $vendor["VendorOriginationRoute"]['id'],
                'active' => $this->request->data['active']
            );
            $this->VendorOriginationRoute->save($data);
        }
    }

    public function store() {
        if ($this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
        }
    }

    public function notes() {
        if ($this->userloggedIn() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            
            $admin = $this->Session->read('adminUser');
            $currentClient = $this->Session->read('clientDetails');
            if($this->request->data) {
                $data = array(
                    'id' => $this->request->data['Note']['id'],
                    'userid' => $currentClient['CLIENT']['ID'],
                    'adminid' => $admin['id'],
                    'note' => $this->request->data['Note']['note']
                );
                
                if($this->request->data['Note']['id'] == '') {
                    $data['created'] = date('Y-m-d H:i:s');
                    $data['modified'] = date('Y-m-d H:i:s');
                }
                
                $noteHeader = (!empty($this->request->data['Note']['id'])) ? "Updated" : "Added";
                
                if($this->Tblnote->save($data)) {
                    $this->Session->setFlash(_("New note has been added."));
                    $this->logActivity($noteHeader.' a note id #'.$this->Tblnote->id);
                    $this->redirect('notes');
                } else {
                    $this->Session->setFlash(_("Failed to process request."));
                    $this->redirect('notes');
                }
            }
            $this->paginate = array(
                'conditions' => array(
                    'adminid' => $admin['id'],
                    'userid' => $currentClient['CLIENT']['ID']
                 ),
                'limit' => 10
            );
            $notes = $this->paginate('Tblnote');
            $this->set(compact('notes'));
        }
    }
    
    public function deleteNote() {
        if ($this->userloggedIn()) {
            $this->autoRender = false;
            if($this->request->is('ajax')) {
                $nid = $this->request->data['nid'];
                if($this->Tblnote->delete($nid)) {
                    $this->logActivity('Deleted a note id #'.$nid);
                    return true;
                }else {
                    return false;
                }
            }
        }
    }

    public function logout() {
        $this->Session->setFlash('Successfully logged out.');
        $this->Session->destroy();
        $this->redirect(array("controller" => "admintools", "action" => "adminlogin"));
    }

    public function remoteData($query) {
        $this->autoRender = false;
         /** ONLINE DATABASE */
          
        $db_host = 'localhost';
        $db_username = 'VoipLionU1';
        $db_password = 'cde$33MC';
        $db_name = 'itaki_whmcs';
        
        /* LOCALDATABASE *******
          $db_host = "localhost";
          $db_username = 'root';
          $db_password = '';
          $db_name = 'itaki_whmcs'; */
         
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
        $this->autoRender = false;
        $url = 'http://devweb.peachtel.net/clients/includes/api.php';
        $admin = $this->Session->read('adminUser');

        $postfields["username"] = $admin['username'];
        $postfields["password"] = $admin['password'];

        /*         * ** WHMCS XML API Sample Code *** */
        $postfields["stats"] = true;
        $postfields["responsetype"] = "xml";
        //debug($postfields); exit;
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
    /******************************************* Trunking Ajax functions ***************************************/
    public function search_by_date() {
        if($this->request->data) {
            $this->layout = '';
            $cdrs = $this->Cdr->findSDateEDate($this->request->data);
            $this->set(compact('cdrs'));
        }
    }
    
    public function set_status() {
        if($this->request->data) {
            $this->autoRender = false;
            
            $this->Customer->id = $this->request->data['cid'];
            $data = array(
                'active' => $this->request->data['status']
            );

            if($this->Customer->save($data)) {
                    
                return true;
            } else {
                return false;
            }
            
        }
    }
    
    public function add_billing_group() {
        if($this->request->data) {
            $this->autoRender = false;
            
            $client         = $this->Session->read('clientDetails');
            $clientDetails  = $client['CLIENT'];
            
            /** Description */
            $postFix        = array(30, 37);
            $postIndex      = array_rand($postFix);
            $preFix         = mt_rand(10000000, 99999999);
            
            /** password*/
            $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $temp_pw = substr( str_shuffle( $chars ), 0, 12 );
            $bgID = $this->BillingGroup->find('first', array('fields' => array('id'), 'order' => array('BillingGroup.id desc'), 'recursive' => '-1'));
            $destID = $this->DestinationGateway->find('first', array('fields' => array('id'), 'order' => array('DestinationGateway.id desc'), 'recursive' => '-1'));
        
            $data = array(
                'BillingGroup' => array(
                    'id' => $bgID['BillingGroup']['id']+1,
                    'descr' => "BG".$postFix[$postIndex].$preFix,
                    'customer_bg_billing_target_id' => $this->request->data['billing_target_id'],
                    'customer_id' => $this->request->data['cid'],
                    'notify_email' => $clientDetails['EMAIL']
                ),
                'Subscriber' => array(
                    0 => array(
                        'username' => $postFix[$postIndex].$preFix,
                        'password' => $temp_pw,
                        'domain' => 'sip.itaki.net'
                    )
                ),
                'DestinationGateway' => array(
                    0 => array(
                        'id' => $destID['DestinationGateway']['id']+1,
                        'dest' => $postFix[$postIndex].$preFix."@sip.itaki.net",
                        'dest_type' => 1,
                        'priority' => 1
                    )
                )
            );
            
            if($this->BillingGroup->saveAll($data)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function bg_update_field() {
        $this->autoRender = false;
        if($this->request->data) {
            $this->BillingGroup->id = $this->request->data['id'];
            if($this->BillingGroup->saveAll($this->request->data)) {
                $this->logActivity('Updated billing group id #'.$this->BillingGroup->id);
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function emailer($email) {
        $sendEmail = new CakeEmail('default');
        $sendEmail->template('update')
            ->emailFormat('html')
            ->to($email)
            ->from(array('Itakinet@info.com'=> 'Itakinet Info'))  
            ->subject('Customer Billing Group has been UPDATED!')    
            ->send(); 
    }
    
    public function addDeletePrefix() {
        $this->autoRender = false;
        if($this->request->data) {
            if($this->request->data['method'] == 'delete') {
                $this->OriginationRoute->id = $this->request->data['rid'];
                $this->request->data['prefix'] = '';
                $this->request->data['descr'] = '';
                if($this->OriginationRoute->save($this->request->data)) {
                    $this->logActivity('Updated origination route id #'.$this->request->data['rid']);
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->OriginationRoute->id = $this->request->data['admintool']['id'];
                $this->request->data = $this->request->data['admintool'];
                $this->request->data['descr'] = $this->request->data['prefix'];
                if($this->OriginationRoute->save($this->request->data)) {
                    $this->Session->setFlash(_("New prefix added."));
                    $this->logActivity('Added prefix to origination route id #'.$this->OriginationRoute->id);
                    $this->redirect('trunking');
                } else {
                    $this->Session->setFlash(_("Failed to add prefix."));
                    $this->redirect('trunking');
                }
            }
        }
    }
    
    public function edit_fraud() {
        $this->layout = '';
        if($this->request->data) {
            $fraud = $this->FraudCtrlPref->findByCustomerBgId($this->request->data['id']);
            $this->set(compact('fraud'));
        }
    }
    
    public function save_fraud() {
        if($this->request->data) {
            $this->FraudCtrlPref->id = $this->request->data['admintool']['id'];
            if($this->FraudCtrlPref->save($this->request->data['admintool'])) {
                $this->logActivity('Updated Fraud controll id #'.$this->request->data['admintool']['id']);
                $this->Session->setFlash(_("Changes saved."));
                $this->redirect('trunking');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('trunking');
            }
        }
    }
    
    public function add_credit() {
        $this->CreditControll->id = $this->request->data['admintool']['bg_id'];
        if($this->request->data['admintool']['method'] == "add") {
            $log = (empty($this->request->data['admintool']['bg_id'])) ? 'Added new Credit Controll' : 'Added $'.$this->request->data['admintool']['Credit'].' to Credit Controll id #'.$this->request->data['admintool']['bg_id'];
            $bal = $this->request->data['admintool']['bal'] + $this->request->data['admintool']['Credit'];
        } else {
            if(!empty($this->request->data['admintool']['bal']) && ($this->request->data['admintool']['bal'] > $this->request->data['admintool']['Credit'])) {
                $log = 'Debit $'.$this->request->data['admintool']['Credit'].' to Credit Controll id #'.$this->request->data['admintool']['bg_id'];
                $bal = $this->request->data['admintool']['bal'] - $this->request->data['admintool']['Credit'];
            } else {
                $this->Session->setFlash(_("Insufficient credit balance."));
                $this->redirect('trunking');
            }
        }
        
        $data = array(
            'credit_bal' => $bal,
            'customer_bg_id' => $this->request->data['admintool']['bg_id']
        );
        if($this->CreditControll->save($data)) {
            $this->logActivity($log);
            $this->Session->setFlash(_("Changes saved."));
            $this->redirect('trunking');
        } else {
            $this->Session->setFlash(_("Failed to save changes."));
            $this->redirect('trunking');
        }
    }
    
    public function subs_update_field() {
        $this->autoRender = false;
        if($this->request->data) {
            $this->Subscriber->id = $this->request->data['id'];
            if($this->Subscriber->saveAll($this->request->data)) {
                $this->logActivity('Updated subscriber id #'.$this->request->data['id']);
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function getCostDest() {
        $this->autoRender = false;
        $cid = $this->request->data['id'];
        
        $costDest = $this->OriginationRouteCostDest->findByOrigRouteId($cid);
        return json_encode($costDest['OriginationRouteCostDest']);
    }
    
    public function updateCostDest() {
        $data = $this->request->data['admintool'];
        $this->OriginationRouteCostDest->id = $data['orig_route_id'];
        if($this->OriginationRouteCostDest->save($data)) {
            $this->Session->setFlash(__('Changes saved.'));
        } else {
            $this->Session->setFlash(__('Failed to update Cost Destination.'));
        }
        $this->redirect('trunking');
    }
    
    public function getElapseTime($time) {
        
        $elapseTime = $this->timeAgo($time);
        echo $elapseTime;
    }
    
    public function logActivity($detail) {
        $this->autoRender = false;
        $adminUser = $this->Session->read('adminUser');
        $data = array(
            'admin_id' => $adminUser['id'],
            'description' => $detail
        );
        
        $this->Activity->save($data);
    }
    
    public function timeAgo($time) {
        $time = time() - $time; // to get the time since that moment
        $tokens = array (
            31536000 => 'Year',
            2592000 => 'Month',
            604800 => 'Week',
            86400 => 'Day',
            3600 => 'Hour',
            60 => 'Minute',
            1 => 'Second'
        );
        $elapseTime = '';
        $i = 0;
        foreach ($tokens as $unit => $text) {
            
            $quotient = floor($time / $unit);
            $time = $time - $quotient * $unit;
            if($i < 3 && $quotient != 0) {
                if($quotient > 1) {
                    $text = $text."s";
                }
                $elapseTime .= $quotient." ".$text." ";
                $i++;
            }
        }

        return $elapseTime;
       
    } 
    
    public function validateLocation() {
        $this->autoRender = false;
        App::import("Vendor", "validator/LocationValidator");
        
        $validate = new LocationValidator();
        
        $in_address1 = $this->request->data['Tblclient']['address1'];
        $in_address2 = $this->request->data['Tblclient']['address1'];
        $in_city = $this->request->data['Tblclient']['city'];
        $in_state = $this->request->data['Tblclient']['state'];
        $in_zip = $this->request->data['Tblclient']['postcode'];
        
        /** 
            $in_address1 = '3900 South Las Vegas, Boulevard';
            $in_address2 = '3900 South Las Vegas, Boulevard';
            $in_city = 'Las Vegas';
            $in_state = 'NV';
            $in_zip = '89119';
        */
        
        $return = $validate->validate($in_address1, $in_address2, $in_city, $in_state, $in_zip);
        return json_encode($return);
    }
    /******************************************* End Trunking Ajax functions ***************************************/
}

?>
