<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Admintools');
class SupportController extends AdmintoolsController {
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function clientIdPresent() {
        return parent::clientIdPresent();
    }
    
    public function index() {
        if ($this->userloggedIn() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            
            $currentClient = $this->Session->read('clientDetails');
            $this->paginate = array(
                'conditions' => array('userid' => $currentClient['CLIENT']['ID']),
                'limit' => 10
            );
            $userTickets = $this->paginate('Tblticket');
            $depts = $this->Tblticketdepartment->find('list');
            $this->set(compact('userTickets', 'currentClient'));
        }
    }
    
    public function open_ticket() {
        if ($this->userloggedIn() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            $adminClient = $this->Session->read('adminUser');
            $currentClient = $this->Session->read('clientDetails');
            $depts = $this->Tblticketdepartment->find('list');
            if($this->request->data) {
                $saveTicket = array(
                    'tid' => mt_rand(10000,999999),
                    'did' => $this->request->data['Ticket']['did'],
                    'userid' => $currentClient['CLIENT']['ID'],
                    'name' => $currentClient['CLIENT']['FIRSTNAME']." ".$currentClient['CLIENT']['LASTNAME'],
                    'email' => $currentClient['CLIENT']['EMAIL'],
                    'cc' => $this->request->data['Ticket']['cc'],
                    'title' => $this->request->data['Ticket']['subject'],
                    'message' => $this->request->data['Ticket']['message'],
                    'urgency' => $this->request->data['Ticket']['priority'],
                    'status' => 'Open',
                    'date' => date('Y-m-d H:i:s'),
                    'admin' => $adminClient['firstname']." ".$adminClient['lastname']
                );
                
                if($this->Tblticket->save($saveTicket)) {
                    $this->logActivity('Added a new ticket #'.$saveTicket['tid'].' to '.$currentClient['CLIENT']['EMAIL']);
                    $this->redirect(array('controller' => 'support', 'action' => '/'));
                } else {
                    $this->redirect(array('controller' => 'support', 'action' => '/')); 
                }
            }
            $this->set(compact('depts', 'currentClient'));
        }
    }
    
    public function get_ticket() {
        $ticketId = $this->params['tid'];
        if ($this->userloggedIn() && $this->clientIdPresent()) {
            $this->autoRender = true;
            $this->layout = 'adminDefault';
            
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
                
            } else {
                $this->set(compact('ticket', 'currentClient', 'userTicketsreply', 'ticketId'));
            }
        }
    }
    
    public function ticketUpdateStatus() {
        if ($this->userloggedIn()) {
            if($this->request->is('ajax')) {
                $tid = $this->request->data['tid'];
                $status = $this->request->data['status'];

                $this->Tblticket->id = $tid;

                if($this->Tblticket->save(array('status' => $status))) {
                    $this->logActivity('Updated ticket status id #'.$this->Tblticket->id.' to '.$status);
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    
    public function deleteTicket() {
        if ($this->userloggedIn()) {
            $this->autoRender = false;
            if($this->request->is('ajax')) {
                $tid = $this->request->data['eid'];
                if($this->Tblticket->delete(array('id' => $tid))) {
                    $this->logActivity('Deleted ticket id #'.$this->Tblticket->id);
                    return true;
                } else {
                    return false;
                }
            } 
        }
    }
    
    public function editTicket() {
        if ($this->userloggedIn()) {
            $this->autoRender = true;
            $this->layout = false;
            if($this->request->is('ajax')) {
                if($this->request->data) {
                    $tid = $this->request->data['eid'];
                    $ticket = $this->Tblticket->find('first', array('conditions' => array('id' => $tid), 'recursive' => -1));
                    $this->set(compact('ticket'));
                }
            }
        }
    }
    
    public function saveTicket() {
        if ($this->userloggedIn()) {
            
            if($this->request->is('ajax')) {
                if($this->request->data) {
                    $rid = $this->request->data['eid'];
                    $message = $this->request->data['message'];

                    $this->Tblticket->id = $rid;
                    if($this->Tblticket->save(array('message' => $message))) {
                        $this->logActivity('Updated ticket id #'.$rid);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    
    public function addReply() {
        if ($this->userloggedIn()) {
            if($this->request->data) {
                $admin = $this->Session->read('adminUser');

                $data = array(
                    'tid' => $this->request->data['Tblticketreply']['tid'],
                    'userid' => $admin['id'],
                    'name' => $admin['firstname']." ".$admin['lastname'],
                    'email' => $admin['email'],
                    'date' => date('Y-m-d H:i:s'),
                    'message' => $this->request->data['Tblticketreply']['message'],
                    'admin' => 1
                );

                if($this->Tblticketreply->save($data)) {
                    $this->Tblticket->id = $this->request->data['Tblticketreply']['tid'];
                    if($this->Tblticket->save(array('lastreply' => date('Y-m-d H:i:s')))) {
                        $this->logActivity('Replied to ticket id #'.$this->Tblticket->id);
                        return '<div id="reply-container">
                                    <div id="subject" type="reply">
                                        <h3>'.$data['name'].'</h3>
                                        <label style="margin-bottom: 10px; color: #fff; padding: 1px 5px; display: block; background: green; width: 50px; text-align:center;">Staff</label>
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
    }
    
    public function editReply() {
        if ($this->userloggedIn()) {
            $this->autoRender = true;
            $this->layout = false;
            if($this->request->is('ajax')) {
                if($this->request->data) {
                    $rid = $this->request->data['eid'];
                    $reply = $this->Tblticketreply->find('first', array('conditions' => array('id' => $rid), 'recursive' => -1));

                    $this->set(compact('reply'));
                }
            }
        }
    }
    
    public function saveReply() {
        if ($this->userloggedIn()) {
            if($this->request->is('ajax')) {
                if($this->request->data) {
                    $rid = $this->request->data['eid'];
                    $message = $this->request->data['message'];

                    $this->Tblticketreply->id = $rid;
                    if($this->Tblticketreply->save(array('message' => $message))) {
                        $this->logActivity('Updated a reply id #'.$rid);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
    
    public function deleteReply() {
        if ($this->userloggedIn()) {
            if($this->request->is('ajax')) {
                if($this->request->data) {
                    $rid = $this->request->data['eid'];

                    if($this->Tblticketreply->delete($rid)) {
                        $this->logActivity('Deleted a reply id #'.$rid);
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
    }
}
?>
