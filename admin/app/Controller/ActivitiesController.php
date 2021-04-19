<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Controller', 'Admintools');
class ActivitiesController extends AdmintoolsController {
    public $uses = array('Activity');
    public $layout = 'adminDefault';
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function activity_log() {
        $adminUser = $this->Session->read('adminUser');
        
        $whmcsActivityLog = $postfields['action'] = 'getactivitylog';
        $whmcsPendingOrders = parent::whmcsInvoker($postfields);
        $this->autoRender = true;
        /**
        $this->paginate = array(
            'conditions' => array('admin_id' => $adminUser['id']),
            'limit' => 10
        );
        **/
        $activities = $this->Activity->find('all', array('conditions' => array('admin_id' => $adminUser['id']), 'order' => array('created DESC')));
        $this->set(compact('activities', 'adminUser', 'whmcsPendingOrders'));
    }
    
    public function test() {

    }
        
}