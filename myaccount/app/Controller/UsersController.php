<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {

    public $uses= array('User', 'PsProduct', 'BillingGroup', 'VendorOriginationRoute', 'OriginationRoute', 'Tblhosting', 'Tblticket', 'Tblticketdepartment', 'Tblticketreply', 'Customer', 'MasterBillingGroup', 'PsCustomer', 'OriginationRouteCostDest', 'PsCountry', 'PsState', 'DestinationGateway', 'Server');
    
    public function beforeFilter() {
        set_time_limit(0);
        parent::beforeFilter();
        
        if(!in_array($this->action, array('login', 'register', 'quote_tool', 'getCountryStates', 'getStateCountry', 'addProduct', 'addDevices', 'view_quote', 'reviewQuote', 'saveQuote', 'updateQuote', 'setShippingMethod', 'validateCheckoutAddress', 'processCheckout', 'completeCheckout', 'createWhmcsOrder', 'getShippingMethod', 'checkSession', 'psProductLogger', 'psLogDelete', 'productReader', 'removeProduct', 'configureDid', 'setPhoneNumbers', 'addRemoveNumber', 'getDIDStates', 'getDIDInfo', 'getDIDArea', 'configureSelectedDids', 'configureRemoveSelectedDids', 'getProductDatacenters', 'getDatacenter', 'getProductDatacenter'))) {
            $this->checkValidSession();
        } else {
            return 'login';
        }
    }

    public function index() {
        $this->autoRender = false;
        $this->redirect('/');
    }
    
    public function checkValidSession() {
        $client = $this->Session->read('clientDetails');
        if(!empty($client)) {
            return true;
        } else {
            $this->Session->setFlash(_("Please login to view the page content."));
            $this->redirect('http://'.$_SERVER['HTTP_HOST']."/");
        }
    }
    
    public function login() {
        $this->layout = 'login';
        $checkout = false;
        if($this->request->data) {
            $this->Session->write('Register', '');
            
            $postfields["action"] = "validatelogin";
            $postfields["email"] = $this->request->data['User']['username'];
            $postfields["password2"] = $this->request->data['User']['password'];

            $clientDetail = $this->whmcsInvoker($postfields);
            if($clientDetail['WHMCSAPI']['RESULT'] == 'success') {

                $postfields["action"] = "getclientsdetails";
                $postfields["clientid"] = $clientDetail['WHMCSAPI']['USERID'];

                $clientDetail = $this->whmcsInvoker($postfields);
                $this->Session->write("clientDetails", $clientDetail['WHMCSAPI']);
                if(isset($this->request->data['User']['type']) && $this->request->data['User']['type'] == 'ajax') {
                    return $clientDetail['WHMCSAPI']['CLIENT']['FIRSTNAME']." ".$clientDetail['WHMCSAPI']['CLIENT']['LASTNAME'];
                } else {

                    if($this->request->data['User']['redirect'] == 'quote') {
                        $redirect = '/quotes/quote_tool?admin=1';
                    } else if($this->request->data['User']['redirect'] == 'checkout') {
                        $redirect = '/quotes/quote_tool?admin=1';
                        $checkout = true;
                    } else {
                        $redirect = 'billing';
                    }
                    
                    $this->Session->write('isCheckout', $checkout);
                    $this->redirect($redirect);
                }
            } else {
                if(isset($this->request->data['User']['type']) && $this->request->data['User']['type'] == 'ajax') {
                    return false;
                } else {
                    $this->Session->setFlash(_("Invalid Username or Password."));
                    $redirect = ($this->request->data['User']['redirect'] == 'quote') ? '/quotes/quote_tool' : '/';
                    $this->redirect($redirect);
                }
            }
        }

        $this->Session->write('isCheckout', $checkout);
        $devices = $this->PsProduct->find('all', array('limit' => 10, 'order' => 'rand()', 'fields' => array('PsProduct.id_product', 'id_manufacturer', 'price'), 'group' => array('PsProduct.id_product'), 'contain' => array('PsImage' => array('fields' => array('id_image', 'id_product')), 'PsProductLang' => array('name', 'description', 'link_rewrite'))));
        $this->set(compact('devices'));
    }

    public function dashboard() {
        /** Currently disabled. */
        $this->layout = 'client';
    }

    public function billing($action = null) {
        $this->layout = 'client';
        
        $clientDetails = $this->Session->read('clientDetails');
        $query = "Select * from tblinvoices where userid='" . $clientDetails['CLIENT']['ID'] . "' ORDER BY date DESC";
        $billingData = $this->remoteData($query);
        
        if ($billingData['status'] == "success")
            $this->Session->write("clientbillingHistory", $billingData);
        
        $clientBillingHistory = $this->Session->read('clientbillingHistory');
        
        $this->autoRender = true;
        $this->set(compact('clientDetails', 'action', 'clientBillingHistory'));
    }
    
    public function update_creditcard() {
        if($this->request->data) {
            $clientDetail = $this->Session->read('clientDetails');
            
            $update['cardtype'] = $this->request->data['User']['card_type'];
            $update['cardnum'] = $this->request->data['User']['card_number'];
            //$update['expdate'] = $this->request->data['User']['expiry_date'];
            $update['action'] = 'updateclient';
            $update['clientid'] = $clientDetail['CLIENT']['USERID'];
            $this->whmcsInvoker($update);
            $this->redirect(Controller::referer());
        }
    }
    
    public function account_information($action = null) {
        $this->layout = 'client';
        $clientDetail = $this->Session->read('clientDetails');
        
        /** update client call  -- updateclient */
        if($this->request->data) {
            if(!isset($this->request->data['User']['select_contact'])) {
                $update = $this->request->data["User"];
                $update['action'] = 'updateclient';
                $update['clientid'] = $clientDetail['CLIENT']['USERID'];
                $this->whmcsInvoker($update);
                $postfields["action"] = "getclientsdetails";
                $postfields["clientid"] = $clientDetail['CLIENT']['USERID'];
                $newClientDetail = $this->whmcsInvoker($postfields);
                $this->Session->write("clientDetails", $newClientDetail['WHMCSAPI']);
                $this->redirect('account_information');
            }
        }
        
        $update['action'] = 'getcontacts';
        $update['userid'] = $clientDetail['CLIENT']['USERID'];
        $rawContacts = $this->whmcsInvoker($update);
        $contactDetail = array('ID' => '','FIRSTNAME' => '','LASTNAME' => '','COMPANYNAME' => '','EMAIL' => '','ADDRESS1' => '','ADDRESS2' => '','CITY' => '','STATE' => '','POSTCODE' => '','COUNTRY' => '','PHONENUMBER' => '','GENERALEMAILS' => '','PRODUCTEMAILS' => '','DOMAINEMAILS' => '','INVOICEEMAILS' => '','SUPPORTEMAILS' => '');
        $contacts = array();
        
        if(isset($rawContacts['WHMCSAPI']['CONTACTS'])) {
            foreach($rawContacts['WHMCSAPI']['CONTACTS'] as $contact) {
                if(isset($this->request->data['User']['select_contact']) && $contact['ID'] == $this->request->data['User']['select_contact'])
                    $contactDetail = $contact;

                $contacts[$contact['ID']] = $contact['FIRSTNAME']." ".$contact['LASTNAME'];
            }
        }
        
        $states = $this->PsState->find('list', array('fields' => array('name', 'name'), 'order' => array('name ASC')));          
        $countryList = $this->PsCountry->getCountries();
        
        $this->autoRender = true;
        $this->set(compact('states', 'countryList', 'clientDetail', 'contacts', 'contactDetail', 'action'));
    }
    
    public function add_contact() {
        $add = $this->request->data["User"];
        if($this->request->data) {
            if(!empty($this->request->data['User']['contactid'])) {
                $add['action'] = 'updatecontact';
            } else {
                $clientDetail = $this->Session->read('clientDetails');
                $add['action'] = 'addcontact';
                $add['clientid'] = $clientDetail['CLIENT']['USERID'];
            }
            $this->whmcsInvoker($add);
            $this->redirect(Controller::referer());
        }
    }
    
    public function change_password() {
        if($this->request->data) {
            $clientDetail = $this->Session->read('clientDetails');
            $validate["action"] = "validatelogin";
            $validate["email"] = $clientDetail['CLIENT']['EMAIL'];
            $validate["password2"] = $this->request->data['User']['old_password'];
            $isValid = $this->whmcsInvoker($validate);
            if($isValid['WHMCSAPI']['RESULT'] == 'success') {
                $change["clientid"] = $clientDetail['CLIENT']['ID'];
                $change["action"] = "updateclient";
                $change["password2"] = $this->request->data['User']['password'];
                $this->whmcsInvoker($change);
            }
            $this->redirect(Controller::referer());
        }
    }
    
    public function trunking() {
        $this->layout = 'client';
        $client         = $this->Session->read('clientDetails');
        $clientDetails  = $client['CLIENT'];
        $clientTrunkID   = $clientDetails['ID'];//$trunkName.$clientDetails['ID'];
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
        $routes       = $this->OriginationRoute->find('all', array('conditions' => $cond, 'contain' => array('OriginationRouteCostDest')));
        $this->set(compact('clientDetails', 'clientTrunkData', 'clientTrunkID', 'customerBGs', 'vendor_prefs', 'routes'));
    }

    public function pbx() {
        $this->autoRender = true;
        $this->layout = 'client';
        $currentClient = $this->Session->read('clientDetails');

        $userActiveHostings = $this->Server->find('all', array('conditions' => array('user_id' => $currentClient['CLIENT']['ID'])));

        $this->set(compact('userActiveHostings'));
    }

    public function pbx_provision($hid) {
        App::import("Vendor","vrcloud/config");
        $this->layout = 'client';
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

    public function createDNS($name) {
        $this->autoRender = false;
        App::import("Vendor","vrcloud/config");
        App::import("Vendor","durabledns/durable_include");
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
            } else
                return false;
        }
        return false;
    }

    public function provisioning() {
        $this->layout = 'client';
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

                $data[$key]['Phonedata'][$pd['ButtonNum']] = !isset($data[$key]['Phonedata'][$pd['ButtonNum']]) ? array() : $data[$key]['Phonedata'][$pd['ButtonNum']];

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
        if(!empty($macAddresses))
            $bolPhonesProvisioned = true;

        $this->set(compact('brandList', 'frendlynameList', 'macAddresses', 'bolPhonesProvisioned'));
    }
    
    public function check_mac_addr() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $mac = $this->request->data['mac'];
            $currentClient = $this->Session->read('clientDetails');
            
            $isRegistered = $this->Macid->find('first', array('conditions' => array('MacID' => $mac, 'AccountID' => $currentClient['CLIENT']['USERID'])));
            
            if(!empty($isRegistered))
                echo true;
            else
                echo false;

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
                if($ph['Phonedata']['Field'] == 'BrandModel.id')
                    $phone = $ph;
                else
                    $form = $ph;
            }

            if(isset($form))
                $formdata = json_decode($form['Phonedata']['Data'], TRUE);

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
        
        if($this->Phonedata->deleteAll($conditions)) {
            $this->Phonedata->saveAll($data);
            $this->redirect('provisioning');
        } else {
            $this->Phonedata->saveAll($data);
            $this->redirect('provisioning');
        }
    }
    
    public function generate_gui_html($cfg_data, $max_lines = 1) {
        //take the data out of the database and turn it back into an array for use

        $template_variables_array = array();
        $group_count = 0;
        $variables_count = 0;

        for($a=1;$a <= $max_lines; $a++)
            $template_variables_array[$group_count]['title'] = "Line Information for Line ".$a;

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
    
    function generate_form_data ($i, $cfg_data, $key=NULL) {
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

    public function changeStdToArray($obj) {
        $this->autoRender = false;
        return get_object_vars($obj);
    }

    public function savePhoneData() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $currentClient = $this->Session->read('clientDetails');
            $this->request->data['Macid']['AccountID'] = $currentClient['CLIENT']['USERID'];
            
            if(isset($this->request->data['Macid']['id']))
                $this->Macid->id = $this->request->data['Macid']['id'];
            
            $saveData['Macid'] = $this->request->data['Macid'];
            $i = 0;
            $keys = array();
            foreach($this->request->data['Phonedata'] as $phones) {
                foreach($phones as $key => $phone) {
                    $globals = array('DateTimeZone', 'AccountID', 'BrandModel.id', 'Registrations', 'LocalPort', 'ExtensionNumber');
                    
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
                /** '/[0-9A-Fa-f]{12}/i */

                if(!$data) {
                    $this->Macid->delete(array('id' => $this->Macid->id));
                    return false;
                } else {

                    if(isset($this->request->data['Macid']['edit']))
                        return true;
                    else
                        return $this->Macid->getLastInsertID();

                }
            } else
                return false;

        }
    }

    public function sendFriendlyNames() { //ajax called method
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
            $this->set(compact('editData'));
        }
    }

    public function deleteMac() { //ajax called method
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if ($this->Macid->delete(array('id' => $this->request->data['macId'])))
                return true;
            else
                return false;

        }
    }

    public function store() {
        $this->layout = 'client';
    }
    
    public function quotes() {
        $this->layout = 'client';
    }

    public function support() {
        $this->autoRender = true;
        $this->layout = 'client';

        $currentClient = $this->Session->read('clientDetails');
        $this->paginate = array(
            'conditions' => array('userid' => $currentClient['CLIENT']['ID']),
            'limit' => 10
        );
        $userTickets = $this->paginate('Tblticket');
        $depts = $this->Tblticketdepartment->find('list');
        $this->set(compact('userTickets', 'currentClient'));
    }
    
    public function open_ticket() {
        $this->autoRender = true;
        $this->layout = 'client';
        $currentClient = $this->Session->read('clientDetails');
        $depts = $this->Tblticketdepartment->find('list');
        if($this->request->data) {
            $saveTicket = array(
                'tid' => mt_rand(10000,999999),
                'did' => $this->request->data['Ticket']['did'],
                'userid' => $currentClient['CLIENT']['ID'],
                'name' => $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME'],
                'email' => $currentClient['CLIENT']['EMAIL'],
                'title' => $this->request->data['Ticket']['subject'],
                'message' => $this->request->data['Ticket']['message'],
                'urgency' => $this->request->data['Ticket']['priority'],
                'status' => 'Open',
                'date' => date('Y-m-d H:i:s'),
            );

            if($this->Tblticket->save($saveTicket))
                $this->redirect('/users/support');
            else
                $this->redirect('/users/support'); 

        }

        $this->set(compact('depts', 'currentClient'));
    }
    
    public function get_ticket() {
        $ticketId = $this->params['tid'];
        $this->layout = 'client';

        $currentClient = $this->Session->read('clientDetails');
        $ticket = $this->Tblticket->find('first', array('conditions' => array('Tblticket.userid' => $currentClient['CLIENT']['ID'], 'Tblticket.id' => $ticketId), 'recursive' => -1));

        $this->paginate = array(
            'conditions' => array('Tblticketreply.tid' => $ticket['Tblticket']['id']),
            'recursive' => -1,
            'order' => 'Tblticketreply.date DESC',
            'limit' => 10,
            'page' => (isset($_GET['page'])) ? $_GET['page'] : 1
        );

        $userTicketsreply = $this->paginate('Tblticketreply');
        if(isset($_GET['page'])) {
            $this->layout = false;
            $this->set(compact('userTicketsreply'));
            $this->render('reply_page');

        } else
            $this->set(compact('ticket', 'currentClient', 'userTicketsreply', 'ticketId'));

    }
    
    public function ticketUpdateStatus() {
        if($this->request->is('ajax')) {
            $tid = $this->request->data['tid'];
            $status = $this->request->data['status'];

            $this->Tblticket->id = $tid;

            if($this->Tblticket->save(array('status' => $status)))
                return true;
            else
                return false;

        }
    }
    
    public function deleteTicket() {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $tid = $this->request->data['eid'];
            if($this->Tblticket->delete(array('id' => $tid)))
                return true;
            else
                return false;

        } 
    }
    
    public function editTicket() {
        $this->layout = false;
        if($this->request->is('ajax')) {
            if($this->request->data) {
                $tid = $this->request->data['eid'];
                $ticket = $this->Tblticket->find('first', array('conditions' => array('id' => $tid), 'recursive' => -1));

                $this->set(compact('ticket'));
            }
        }
    }
    
    public function saveTicket() { 
        if($this->request->is('ajax')) {
            if($this->request->data) {
                $rid = $this->request->data['eid'];
                $message = $this->request->data['message'];

                $this->Tblticket->id = $rid;
                if($this->Tblticket->save(array('message' => $message)))
                    return true;
                else
                    return false;
            }
        }
    }
    
    public function addReply() {
        $this->autoRender = false;
        if($this->request->data) {
            $currentClient = $this->Session->read('clientDetails');

            $data = array(
                'tid' => $this->request->data['Tblticketreply']['tid'],
                'userid' => $currentClient['CLIENT']['ID'],
                'name' => $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME'],
                'email' => $currentClient['CLIENT']['EMAIL'],
                'date' => date('Y-m-d H:i:s'),
                'message' => $this->request->data['Tblticketreply']['message']
            );

            if($this->Tblticketreply->save($data)) {
                $this->Tblticket->id = $this->request->data['Tblticketreply']['tid'];
                if($this->Tblticket->save(array('lastreply' => date('Y-m-d H:i:s')))) {
                    return '<div id="reply-container">
                                <div id="subject" type="reply">
                                    <h3>'.$data['name'].'</h3>
                                    <label style="margin-bottom: 10px; color: #fff; padding: 1px 5px; display: block; background: green; width: 50px; text-align:center;">Client</label>
                                    <div id="reply-buttons" eid="'.$this->Tblticketreply->getLastInsertID().'">
                                        <a href="javascript:void(0);" method="edit">&nbsp;</a>
                                        <a href="javascript:void(0);" method="delete">&nbsp;</a>
                                    </div>
                                </div>
                                <div id="message-container">
                                    <i>Wrote a reply:</i>
                                    <hr />
                                    <p style="text-indent: 15px; margin: 10px 0 10px 0">'.$data['message'].'</p>
                                    <hr />
                                    <i style="font-weight: bold; font-size: 10px;">Just Now</i>
                                </div>
                            </div>';
                }
            } else {
                return false;
            }
        }
    }
    
    public function editReply() {
        $this->layout = false;
        if($this->request->is('ajax')) {
            if($this->request->data) {
                $rid = $this->request->data['eid'];
                $reply = $this->Tblticketreply->find('first', array('conditions' => array('id' => $rid), 'recursive' => -1));

                $this->set(compact('reply'));
            }
        }
    }
    
    public function saveReply() {
        if($this->request->is('ajax')) {
            if($this->request->data) {
                $rid = $this->request->data['eid'];
                $message = $this->request->data['message'];

                $this->Tblticketreply->id = $rid;
                if($this->Tblticketreply->save(array('message' => $message)))
                    return true;
                else
                    return false;
            }
        }
    }
    
    public function deleteReply() {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            if($this->request->data) {
                $rid = $this->request->data['eid'];

                if($this->Tblticketreply->delete($rid)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function notes() {
        if ($this->clientIdPresent()) {
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
                
                if($this->Tblnote->save($data)) {
                    $this->redirect('notes');
                } else {
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
        if ($this->clientIdPresent()) {
            $this->autoRender = false;
            if($this->request->is('ajax')) {
                $nid = $this->request->data['nid'];

                if($this->Tblnote->delete($nid))
                    return true;
                else
                    return false;

            }
        }
    }

    public function logout() {
        $this->Session->destroy();
        $this->Session->setFlash(_("You have successfully logged out."));
        $this->redirect('http://'.$_SERVER['HTTP_HOST']."/myaccount");
    }

    public function remoteData($query) {
        $this->autoRender = false;
         /** ONLINE DATABASE */
          
        $db_host = 'localhost';
        $db_username = 'VoipLionU1';
        $db_password = 'cde$33MC';
        $db_name = 'itaki_whmcs';
         
        $con = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error() . ' in line ' . __LINE__);
        mysql_select_db($db_name, $con) or die(mysql_error() . ' in line ' . __LINE__);
        $result = mysql_query($query) or die(mysql_error() . ' in line ' . __LINE__);

        $i = 0;
        $data['status'] = 'error';
        if (mysql_num_rows($result) != 0)
            $data['status'] = 'success';

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
            $data[$i++] = $row;
        
        mysql_close($con);
        return $data;
    }

    public function whmcsInvoker($postfields) {
        $this->autoRender = false;

        $url = 'http://devweb.peachtel.net/clients/includes/api.php';

        $postfields["username"] = 'vladmin';
        $postfields["password"] = '750de8cc22b9573340b4548365adc6ab';
        
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

        $data = $this->whmcsapi_xml_parser($xml);
        return ($data);

    }
    
    function whmcsapi_xml_parser($rawxml) {
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
    
    public function search_by_date() {
        if($this->request->data) {
            $this->layout = '';
            $cdrs = $this->Cdr->findSDateEDate($this->request->data);
            $this->set(compact('cdrs'));
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
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function addDeletePrefix() {
        $this->autoRender = false;
        if($this->request->data) {
            if($this->request->data['method'] == 'delete') {
                $this->OriginationRoute->id = $this->request->data['rid'];
                $this->request->data['prefix'] = '';
                if($this->OriginationRoute->save($this->request->data)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->OriginationRoute->id = $this->request->data['admintool']['id'];
                $this->request->data = $this->request->data['admintool'];
                if($this->OriginationRoute->save($this->request->data)) {
                    $this->Session->setFlash(_("New prefix added."));
                    $this->redirect('trunking');
                } else {
                    $this->Session->setFlash(_("Failed to add prefix."));
                    $this->redirect('trunking');
                }
            }
        }
    }
    
    public function subs_update_field() {
        $this->autoRender = false;
        if($this->request->data) {
            $this->Subscriber->id = $this->request->data['id'];
            if($this->Subscriber->saveAll($this->request->data)) {
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
        $data = $this->request->data['user'];
        $this->OriginationRouteCostDest->id = $data['orig_route_id'];
        if($this->OriginationRouteCostDest->save($data)) {
            $this->Session->setFlash(__('Changes saved.'));
        } else {
            $this->Session->setFlash(__('Failed to update Cost Destination.'));
        }
        $this->redirect('trunking');
    }
    
    public function register() {
        $this->autoRender = false;
            
        if($this->request->data) {

            $postfields["firstname"] = $this->request->data['User']['firstname'];
            $postfields["lastname"] = $this->request->data['User']['lastname'];
            $postfields["companyname"] = $this->request->data['User']['company'];
            $postfields["email"] = $this->request->data['User']['username'];
            $postfields["phonenumber"] = $this->request->data['User']['phonenumber'];
            $postfields["password2"] = $this->request->data['User']['password'];
            
            $postfields["address1"] = 'Generated Address';
            $postfields["city"] = 'Generated City';
            $postfields["state"] = 'Generated State';
            $postfields["postcode"] = '12345';

            $return = explode(';', htmlentities($this->_createAccount($postfields)));
            $data = array();
            foreach($return as $ret) {
                if(!empty($ret)) {
                    $fields = explode('=', $ret);
                    $data = array_merge($data, array($fields[0] => $fields[1]));
                }
            }
            if($data['result'] == 'success') {
                /** create prestahop user via API associated with whmcs using email and password */
                $this->tools = $this->Components->load('Tools');
                $psPassword = $this->tools->genPass($postfields["password2"]);
                $data['PsCustomer'] = array(
                    'id_shop_group' => '1',
                    'id_shop' => '1',
                    'id_gender' => '1',
                    'id_default_group' => '3',
                    'id_risk' => '0',
                    'company' => $postfields["companyname"],
                    'siret' => '',
                    'ape' => '',
                    'firstname' => $postfields["firstname"],
                    'lastname' => $postfields["lastname"],
                    'email' => $postfields["email"],
                    'passwd' => $psPassword,
                    'last_passwd_gen' => date('Y-m-d H:i:s'),
                    'birthday' => '',
                    'newsletter' => '',
                    'ip_registration_newsletter' => '',
                    'newsletter_date_add' => '0000-00-00 00:00:00',
                    'optin' => '0',
                    'website' => '',
                    'outstanding_allow_amount' => '0.000000',
                    'show_public_prices' => '0',
                    'max_payment_days' => '0',
                    'secure_key' => md5(uniqid(rand(), true)),
                    'note' => '',
                    'active' => '1',
                    'is_guest' => '0',
                    'deleted' => '0',
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s')
                );

                $data['PsCustomerGroup'] = array(
                    'id_group' => 3
                );

                if($this->PsCustomer->saveAll($data)) {
                    $this->Session->setFlash(_("New account created."), '', array(), 'Register');
                    $this->Session->setFlash($postfields, '', array(), 'rawUserData');
                    $this->redirect('/');
                } else {
                    $this->Session->setFlash(_("New account created. Error: Please create your prestashop account manually at http://www.devweb.peachtel.net/prestashop"));
                    $this->redirect('/');
                }
            } else {
                $this->Session->setFlash(_("Failed to create new account. ".$data['message']));
                $this->redirect('/');
            }
        }
    }
    
    private function _createAccount($postfields) {
        $url = "http://devweb.peachtel.net/clients/includes/api.php";
        $username = "vladmin";
        $password = "cde$33MC";
        
        $postfields["username"] = $username;
        $postfields["password"] = md5($password);
        $postfields["action"] = "addclient"; 
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
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
        
        $return = $validate->validate($in_address1, $in_address2, $in_city, $in_state, $in_zip);
        return json_encode($return);
    }
    
    public function getElapseTime($time) {
        
        $elapseTime = $this->timeAgo($time);
        echo $elapseTime;
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
            1 => 'Seconds'
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

    public function testfunction() {
        $this->layout = "client";

    }

    private function _generateStrings($limit) {
        $keys = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $quoteName = '';
        for($i = 0; $i < $limit; $i++) {
            $quoteName .= $keys[rand(0, strlen($keys) - 1)];
        }
        
        return $quoteName;
    }
}

?>
