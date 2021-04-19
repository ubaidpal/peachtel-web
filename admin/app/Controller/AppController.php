<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $uses = array('Brandmodel','Macid','Phonedata');
    public $helpers = array('Form', 'Session', 'Html', 'Js', 'Itaki');
    public $components = array(
//        'Auth' => array(
//        //'loginRedirect' => array('controller' => 'admintools', 'action' => 'adminDashboard'),
//        //'logoutRedirect' => array('controller' => 'admintools', 'action' => 'adminlogin'),
//        //'loginAction' => array('controller' => 'admintools', 'action' => 'adminlogin'),
//        ),
        'Session'
    );

    public function beforeFilter() {
            $systemLang = Configure::read('Config.language');
            if($systemLang == "jpn") {
                $lang = "ja";
            } elseif($systemLang == "eng") {
                $lang = "en";
            } else {
                throw new NotImplementedException('System Lang "'.$systemLang.'" is not implemented.');
            }
            $systemLang = $lang;
            $this->set(compact('systemLang', 'lang'));
//        //Configure AuthComponent 
//        $this->Auth->loginRedirect = array('controller' => 'Admintools', 'action' => 'adminDashboard', 'admin' => false);
//        //$this->Auth->loginAction = array('controller' => 'users', 'action' => 'index', 'admin' => false);
//        $this->Auth->loginAction = array('controller' => 'Admintools', 'action' => 'adminlogin', 'admin' => false);
//        $this->Auth->logoutRedirect = array('controller' => 'Admintools', 'action' => 'adminlogin', 'admin' => false);
//        $this->Auth->userModel = 'Tbladmin';
    }

}
