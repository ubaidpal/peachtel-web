<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Admintools');
class ServersController extends AdmintoolsController {
    public $uses = array('Tblclient');
    public $layout = 'adminDefault';
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function port() {
        
    }
    
    public function inventory() {
        
    }
    
    public function trunking() {
        
    }
}