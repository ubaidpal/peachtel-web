<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Admintools');
class ReportsController extends AdmintoolsController {
    public $uses = array('Tblclient');
    public $layout = 'adminDefault';
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function client_list() {
        
        $postfields['action'] = 'getclients';
        
        if($this->request->data)
            $postfields['search'] = $this->request->data['Tblclient']['name_email']; 
        
        $clientslist = parent::whmcsInvoker($postfields);
        $this->autoRender = true;
        
        $clients = $clientslist['WHMCSAPI']['CLIENTS'];
        $this->set(compact('clients'));
    }
    
    public function e911_calls() {
        
    }
    
    public function tax_report() {
        
    }
    
    public function adwords() {
        
    }
    
    public function revenue_report() {
        
    }
    
    public function agent_report() {
        
    }
}