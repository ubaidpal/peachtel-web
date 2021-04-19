<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public $name = "Users";
    var $layout = "admin_layout";
    public function login() {
        
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(_("Welcome"));
                $this->redirect('/');
            } else {
                $this->Session->setFlash(_("Incorrect Username and Password"));
                $this->redirect('/');
            }
        }
    }
    
    public function create_user() {
        $this->request->data['User']['password'] = Security::hash($this->request->data['User']['password']);
        $this->User->save($this->request->data);
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
}

?>
