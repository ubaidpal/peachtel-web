<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Controller', 'Admintools');
class OrdersController extends AdmintoolsController {
    public $uses = array('Tblorder', 'PsOrder', 'Cnam');
    public $layout = 'adminDefault';
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        return parent::userloggedIn();
    }
    
    public function pending_orders() {
        if ($this->userloggedIn()) {
            $psPendingOrders = array();
            $postfields['action'] = 'getorders';
            $postfields['status'] = 'Pending';
            $whmcsPendingOrders = parent::whmcsInvoker($postfields);
            $this->autoRender = true;
            
            app::import('Vendor', 'PSWebServiceLibrary');
            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
            $opt['resource'] = 'orders';
            $xml = $webService -> get($opt);
            $resources = $xml->children()->children();
            foreach($resources as $id) {
                $opt['id'] = $id->attributes();
                $xml = $webService -> get($opt);
                $orderDetails = $xml->children()->children();
                if($orderDetails->current_state == 12)
                    $psPendingOrders[] =$orderDetails;
            }
            /**
            $whmcsPendingOrders = $this->Tblorder->find('all', array(
                    'conditions' => array('Tblorder.status' => 'Pending'),
                    'contain' => array(
                        'Tblinvoice' => array(
                            'Tblinvoiceitem'
                        )
                    )
                )      
            );
            $psPendingOrders = $this->PsOrder->find('all', array('fields' => array('reference', 'module', 'total_paid_tax_incl', 'total_paid_tax_excl', 'date_add')));
            **/
            $this->set(compact('whmcsPendingOrders', 'psPendingOrders'));
        }
    }

    public function cnam_lookup() {
        if ($this->userloggedIn()) {
            $this->autoRender = true;

        }
    }

    public function cnam_request() {
        if ($this->userloggedIn()) {
            $this->layout = false;
            $this->autoRender = true;
            $cnamdata = array();
            set_time_limit(0);
            if($this->request->data || $this->request->query['phonenumber']) {
                $download = (isset($this->request->query['download']) && $this->request->query['download'] == true) ?  $this->request->query['download'] : false;
                $numberList = array();
                if($download)
                    $phnum = $this->request->query['phonenumber'];
                else
                    $phnum = $this->request->data['phonenumber'];

                $numbers = preg_split("/[,]+/", $phnum);

                foreach($numbers as $key => $number) {
                    $number = preg_replace('/[\s-]/', '', preg_replace('/[+]+1/', '', $number));
                    if(strlen($number) == 10) {
                        $cnam = $this->Cnam->findByNumber('+1'.$number);

                        if(!$cnam) {
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://api.opencnam.com/v2/phone/+1' . $number . '?format=json&account_sid='.CNAM_ACC_SID.'&auth_token='.CNAM_AUTH_TOKEN);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_HTTPGET, true);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $data = curl_exec($ch);
                                if(curl_errno($ch)) { print curl_error($ch); }
                                curl_close($ch);

                                if(!empty($data)) {
                                    $numberdata = json_decode($data);
                                    $cnamdata[] = array(
                                        'name' => $numberdata->name,
                                        'price' => $numberdata->price,
                                        'uri' => $numberdata->uri,
                                        'updated' => $numberdata->updated,
                                        'number' => $numberdata->number,
                                        'created' => $numberdata->created
                                    );
                                    $numberList[$key] = $numberdata;
                                }
                        } else {
                            $numberList[$key] = (object) $cnam['Cnam'];
                        }
                    }
                }

                if(!empty($cnamdata))
                    $this->Cnam->saveAll($cnamdata);

                $this->set(compact('numberList', 'download', 'numbers'));
            }
        }
    }
}
