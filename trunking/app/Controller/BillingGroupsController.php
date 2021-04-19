<?php

App::uses('AppController', 'Controller');

class BillingGroupsController extends AppController {
    public $name = "BillingGroups";
    var $uses = array('User', 'Customer', 'BillingGroup', 'TerminationGroup', 'TerminationRatePlan', 'CreditControll', 'MarginEnforcement');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index($customer_id) {
        
        $billingGroups = $this->BillingGroup->find('all', array('conditions' => array('customer_id' => $customer_id), 'recursive' => -1));

        $this->set(compact('billingGroups', 'customer_id'));
    }
    
    public function add($customer_id) {
        $terminationGroup = $this->TerminationGroup->find('list', array('fields' => array('id', 'descr')));
        $terminationPlan  = $this->TerminationRatePlan->find('list', array('fields' => array('id', 'descr')));
        
        if($this->request->data) {
            if($this->BillingGroup->saveAll($this->request->data)) {
                $this->Session->setFlash(_("New billing group successfully added."));
                $this->redirect('index/'.$customer_id);
            } else {
                $this->Session->setFlash(_("Failed to add billing group."));
            }
        }
        
        $this->set(compact('customer_id', 'terminationGroup', 'terminationPlan'));
    }
    
    public function edit($group_id) {
        
        $terminationGroup   = $this->TerminationGroup->find('list', array('fields' => array('id', 'descr')));
        $terminationPlan    = $this->TerminationRatePlan->find('list', array('fields' => array('id', 'descr')));
        $billingGroup       = $this->BillingGroup->find('first', array('conditions' => array('BillingGroup.id' => $group_id)));

        
        if($this->request->data) {
            $this->BillingGroup->id = $group_id;
            if($this->BillingGroup->save($this->request->data)) {
                $this->Session->setFlash(_("Billing group changes saved."));
                $this->redirect('index/'.$billingGroup['BillingGroup']['customer_id']);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index/'.$billingGroup['BillingGroup']['customer_id']);
            }
        }
        
        $this->set(compact('group_id', 'billingGroup', 'terminationGroup', 'terminationPlan'));
    }
    
    public function credit_controll($group_id) {
        $credit = $this->CreditControll->findByCustomerBgId($group_id);
        
        $this->set(compact('group_id', 'credit'));
        
        if($this->request->data) {
            if($this->CreditControll->save($this->request->data)) {
                $this->Session->setFlash(_("Credit controll saved."));
                $this->redirect('credit_controll/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save credit controll."));
                $this->redirect('credit_controll/'.$group_id);
            }
        }
    }
    
    public function margin_enforcement($group_id) {
        
        $margin = $this->MarginEnforcement->findByCustomerBgId($group_id);
        $this->set(compact('group_id', 'margin'));
        
        if($this->request->data) {
            if($this->MarginEnforcement->save($this->request->data)) {
                $this->Session->setFlash(_("Margin enforcement saved."));
                $this->redirect('margin_enforcement/'.$group_id);
            } else {
                $this->Session->setFlash(_("Failed to save margin enforcement."));
                $this->redirect('margin_enforcement/'.$group_id);
            }
        }
    }
    
    public function delete($group_id, $customer_id) {
        if($this->BillingGroup->delete($group_id)) {
            $this->Session->setFlash(_("Billing Group successfully removed."));
            $this->redirect('index/'.$customer_id);
        } else {
            $this->Session->setFlash(_("Failed to delete billing group."));
            $this->redirect('index/'.$customer_id);
        }
    }
}

?>
