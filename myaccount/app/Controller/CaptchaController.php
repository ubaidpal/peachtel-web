<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CaptchaController extends AppController {
    public $uses = array('User');
    public $components = array("Captcha");
    
    public function beforeFilter() {
        
    }
    
    public function createCaptcha() {
        echo $this->Captcha->getCaptcha();
    }
    
    public function newCaptcha() {
        $this->autoRender = false;
        return $this->Session->read('cakecaptcha');
    }
}