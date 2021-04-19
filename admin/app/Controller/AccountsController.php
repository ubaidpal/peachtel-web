<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Admintools');
class AccountsController extends AdmintoolsController {
    public $uses = array('Tblclient', 'PsCustomer', 'PsState');
    public $layout = 'adminDefault';
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function new_account() {
        if($this->userloggedIn()) {
            $this->autoRender = true;
            
            $states = $this->PsState->find('list', array('fields' => array('iso_code', 'name'), 'order' => array('name ASC')));

            if($this->request->data) {
                $postfields["firstname"] = $this->request->data['Tblclient']['firstname'];
                $postfields["lastname"] = $this->request->data['Tblclient']['lastname'];
                $postfields["companyname"] = $this->request->data['Tblclient']['companyname'];
                $postfields["email"] = $this->request->data['Tblclient']['email'];
                $postfields["phonenumber"] = $this->request->data['Tblclient']['phonenumber'];
                $postfields["password2"] = $this->request->data['Tblclient']['password2'];
                
                $postfields["address1"] = $this->request->data['Tblclient']['address1'];
                $postfields["city"] = $this->request->data['Tblclient']['city'];
                $postfields["state"] = $this->request->data['Tblclient']['state'];
                $postfields["postcode"] = $this->request->data['Tblclient']['postcode'];
                $postfields["country"] = "US";
                
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
                    $psPassword = $this->tools->genPass($this->request->data['Tblclient']['password2']);
                    $data['PsCustomer'] = array(
                        'id_shop_group' => '1',
                        'id_shop' => '1',
                        'id_gender' => '1',
                        'id_default_group' => '3',
                        'id_risk' => '0',
                        'company' => $this->request->data['Tblclient']['companyname'],
                        'siret' => '',
                        'ape' => '',
                        'firstname' => $this->request->data['Tblclient']['firstname'],
                        'lastname' => $this->request->data['Tblclient']['lastname'],
                        'email' => $this->request->data['Tblclient']['email'],
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
                        $this->Session->setFlash(_("New account created."));
                        $this->redirect('new_account');
                    } else {
                        $this->Session->setFlash(_("New account created. Error: Please create your prestashop account manually at http://www.devweb.peachtel.net/prestashop"));
                        $this->redirect('new_account');
                    }
                } else {
                    $this->Session->setFlash(_("Failed to create new account. ".$data['message']));
                }
            }
            $this->set(compact('states'));
        }
    }
    
    public function new_customers() {
        
    }
    
    public function sale_agents() {
        
    }
    
    
    public function createPrestashopAccount() {
        $this->autoRender = false;
        
        app::import('Vendor', 'PSWebServiceLibrary');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH_LOCAL, PS_WS_AUTH_KEY_LOCAL, false);
        $xml = $webService -> get(array('url' => PS_SHOP_PATH_LOCAL . '/api/customers?schema=blank'));
        $resources = $xml->children()->children();
        $opt = array('resource' => 'customers');


        $resources->id_default_group = 3;
        $resources->newsletter_date_add = '0000-00-00 00:00:00';
        $resources->ip_registration_newsletter = '';
        $resources->last_passwd_gen = date('Y-m-d H:i:s');
        $resources->secure_key = md5(uniqid(rand(), true));
        $resources->deleted = 0;
        $resources->passwd = '123123123';
        $resources->lastname = 'data';
        $resources->firstname = 'test';
        $resources->email = 'testaccount3@mailinator.com';
        $resources->id_gender = 1;
        $resources->birthday = '';
        $resources->newsletter = '';
        $resources->optin = 0;
        $resources->website = '';
        $resources->company = 'testcompany';
        $resources->siret = '';
        $resources->ape = '';
        $resources->outstanding_allow_amount = '0.000000';
        $resources->show_public_prices = 0;
        $resources->id_risk = 0;
        $resources->max_payment_days = 0;
        $resources->active = 1;
        $resources->note = '';
        $resources->is_guest = 0;
        $resources->id_shop = 1;
        $resources->id_shop_group = 1;
        $resources->date_add = '0000-00-00 00:00:00';
        $resources->date_upd = '0000-00-00 00:00:00';
        $resources->associations->groups->group->id = 3;
        $opt['postXml'] = $xml->asXML();
                
        $xml = $webService->add($opt);
    }
    

    public function validateLocation() {
        return parent::validateLocation();
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
}