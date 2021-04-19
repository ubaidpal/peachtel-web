<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::import('Controller', 'Users');
class QuotesController extends UsersController {
    public $uses = array(
        'Datacenter',
        'BillingGroup',
        'Customer',
        'OriginationRoute',
        'OriginationRouteCostDest',
        'QbAdminBillType',
        'QbAdminDisplayType',
        'QbAdminCategory',
        'QbAdminProduct',
        'SavedQuote',
        'Server',
        'Tblticketreply',
        'Tblclient',
        'Tblhosting',
        'Tblproductgroup',
        'Tblproduct',
        'Tblpricing',
        'PsProduct',
        'PsCustomer',
        'PsCart',
        'PsCartProduct',
        'PsState',
        'PsCountryLang',
        'PsCountry',
        'PsManufacturer',
        'PhoneNumber',
        'VendorOriginationRoute',
        'Zipcode'
    );

    public $layout = 'client';
    public $components = array("RequestHandler", "Paypal");
    public $valid;

    public function beforeFilter() {
        $this->valid = parent::beforeFilter();
    }

    public function userloggedIn() {
        return $this->valid;
    }

    public function quote_tool($mode = '') {
        $userDetails = $this->Session->read('clientDetails.CLIENT');

        if (isset($_GET['admin']) && $_GET['admin'] == 1 && !empty($userDetails))
           $this->layout;
        else
            $this->layout = 'login';

        $quotes = $this->SavedQuote->getSavedQuotes($userDetails['USERID']);
        $states = $this->PsState->getStates(21);
        $countryList = $this->PsCountry->getCountries();
        $displayType = $this->QbAdminDisplayType->find('list', array('fields' => array('id', 'description')));
        $WHMCScategories = $this->Tblproductgroup->displayWHMCScategories();

        $devices = $this->Session->read('devices');
        $products = $this->Session->read('products');

        $this->autoRender = true;
        $this->set(compact('userDetails', 'WHMCScategories', 'displayType', 'devices', 'quotes', 'states', 'countryList', 'devices', 'products'));
    }

    public function getProductDatacenters() {
        $this->autoRender = false;
        $products = $this->Datacenter->find('all', array('conditions' => array('Datacenter.product_id' => $this->request->data['pid']), 'recursive' => -1));

        $options = '';
        foreach($products as $product) {
             $options .= '<div class="input radio" style="color: #3d3d3d;">
             <input id="datacenter_" type="hidden" value="" name="data[datacenter]">
             <input id="DatacenterATL" class="datacenter datacenters" type="radio" checked="checked" value="'.$product['Datacenter']['code'].'" name="data[datacenter]">
             '.$product['Datacenter']['name'].' - Datacenter - $'.$product['Datacenter']['value'].'
             </div>';
        }
        echo $options;
    }

    public function getCountryStates() {
        $this->autoRender = false;

        if($this->request->is('ajax')) {
            $countryIso = $this->request->data['cid'];

            $states = $this->PsCountry->find('first', array('conditions' => array('iso_code' => $countryIso), 'contain' => array('PsState' => array('fields' => array('iso_code', 'name')))));

            $statesList = '';
            foreach($states['PsState'] as $key => $state) {
                $statesList .= '<option value="'.$state['iso_code'].'">'.$state['name'].'</option>';
            }

            echo $statesList;
        }
    }

    public function getStateCountry() {
        $this->autoRender = false;
        if($this->request->is('ajax')) {
            $stateIso = $this->request->data['siso'];

            $states = $this->PsState->find('first', array('conditions' => array('PsState.iso_code' => $stateIso)));
            echo $states['PsCountry']['iso_code'];
        }
    }

    public function addProduct() {
        $this->layout = false;
        $cats = array();
        $pids = array();

        $categories = $this->request->data;
        $this->Session->write('products', $categories);
        foreach($categories as $key => $category) {
            array_push($cats, $key);
            foreach($category as $key2 => $product)
            	array_push($pids, $key2);

        }

        $WHMCScategories = $this->Tblproductgroup->getWHMCScategories($pids, $cats);

        $this->set(compact('WHMCScategories', 'categories'));
    }

    public function getDatacenter($dcid) {
        $this->autoRender = false;
        $datacenter = $this->Datacenter->find("first", array("conditions" => array("Datacenter.code" => $dcid), 'recursive' => -1));
        return $datacenter['Datacenter']['value'];
    }

    public function getProductDatacenter($code) {
        $this->autoRender = false;
        return $this->Datacenter->find('first', array('conditions' => array('code' => $code), 'recursive' => -1));
    }

    public function configureDid() {
        $this->layout = false;
        //$did = $this->request->data['did'];
        //$line = $this->request->data['line'];
        $dids = $this->Session->read('dids');
        //$data = array('action' => 'ANVEO.COUNTRIES.LIST', 'param' => array('DID_TYPE' => 'GEOGRAPHIC'));
        //$countries = $this->getDIDInfo($data);

        //$this->set(compact('did', 'line', 'dids', 'countries'));
        $this->set(compact('dids', 'countries'));
    }

    public function getDIDCountries() {
        $this->autoRender = false;
        $didType = "GEOGRAPHIC";//$this->request->data['did_type'];
        $data = array('action' => 'ANVEO.COUNTRIES.LIST', 'param' => array('DID_TYPE' => $didType));
        $countries = $this->getDIDInfo($data);
        $countriesOptions = '';
        $countriesOptions .= '<option value="">--- Select One ---</option>';
        foreach($countries as $country)
            $countriesOptions .= '<option has_states="'. $country["HAS_STATES"] .'" value="'. $country["COUNTRY_ID"] .'">'. $country["COUNTRY_NAME"] .'</option>';

        echo $countriesOptions;
    }

    public function getDIDStates() {
        $this->autoRender = false;
        $countryID = $this->request->data['country_id'];
        $didType = "GEOGRAPHIC"; //$this->request->data['did_type'];
        $data = array('action' => 'ANVEO.STATES.LIST', 'param' => array('DID_TYPE' => $didType, 'COUNTRY_ID' => $countryID));
        $states = $this->getDIDInfo($data);
        $statesOptions = '';
        if(!empty($states)) {
            $statesOptions .= '<option value="">--- Select One ---</option>';

            foreach($states as $state)
                $statesOptions .= '<option value="'.$state["STATE_ID"].'">'.$state["STATE_NAME"].'</option>';

        }

        echo $statesOptions;
    }

    public function setPhoneNumbers() {
        $this->layout = '';

        //$did = $this->request->data['did'];
        $dids = $this->Session->read('dids');
        $country = $this->request->data['country'];
        $state = $this->request->data['state'];
        $didType = "GEOGRAPHIC"; //$this->request->data['did_type'];
        $data = array('action' => 'ANVEO.AREAS.LIST', 'param' => array('DID_TYPE' => $didType, 'COUNTRY_ID' => $country));

        if(!empty($state)) {
            $data['param']['STATE_ID'] = $state;
            unset($data['param']['COUNTRY_ID']);
        } else {
            unset($data['param']['STATE_ID']);
        }

        $areas = $this->getDIDInfo($data);

        $this->set(compact('areas', 'dids', 'did'));
    }

    public function getDIDArea() {
        $this->autoRender = false;

        $areaID = $this->request->data['id'];
        $didType = $this->request->data['did_type'];
        $didNumbers = $this->Session->read('dids');
        $didNumbers = !empty($didNumbers) ? $this->Session->read('dids') : array();
        $data = array('action' => 'DID.ORDER', 'param' => array('DID_TYPE' => $didType));
        $data['param']['AREA_ID'] = $areaID;
        $data['param']['RATE_PLAN_ID'] = 'DIRECTVALUE';
        $dids = $this->getDIDInfo($data);
        foreach($dids as $did) {
            $checked = "";
            if(in_array($did['E164'], $didNumbers)) {
                $checked = "checked='checked'";
            }

            echo "<li><span><input type='checkbox' {$checked} value='".json_encode($did)."'/>&nbsp;<label>".$did['E164']."</label></span>";
            echo "</li>";
        }
    }

    public function addRemoveNumber() {
        $this->autoRender = false;
        $method = $this->request->data['method'];
        $nid = $this->request->data['nid'];
        $dids = $this->Session->read('dids');
        $did = json_decode($nid, true);

        if($method == 'remove') {
            unset($dids[$did['E164']]);
            $this->Session->write('dids', $dids);
        } else {
            if(!in_array($did['E164'], $dids)) {
                $dids[$did['E164']] = $did;
                $this->Session->write('dids', $dids);
            }
        }
    }

    public function configureSelectedDids() {
        $this->layout = '';
        $dids = $this->Session->read('dids');
        if(!empty($dids)) {
        $clientDetails = $this->Session->read('clientDetails');

        if(!empty($clientDetails))
            $clientTrunkData = $this->Customer->findCustomerByName($clientDetails['CLIENT']['ID']);

        $this->set(compact('dids', 'clientTrunkData', 'clientDetails'));
        } else {
            $this->autoRender = false;
            echo "<label style='font-size: 12px; margin-left: 10px; color: #ff0000; font-weight: bold;'>No Selected DID(s).</label>";
        }
    }

    public function configureRemoveSelectedDids() {
        $this->autoRender = false;
        $dids = $this->Session->read('dids');
        $did = $this->request->data['did'];

        unset($dids[$did]);
        $this->Session->write('dids', $dids);
    }

    public function buySelectedDids() {
        $this->autoRender = false;
        $dids = $this->Session->read('dids');
        $vendorRoute = array();
        $origRoute = array();
        $clientDetails = $this->Session->read('clientDetails');
        $clientTrunkData = $this->Customer->find('first', array('conditions' => array('Customer.descr' => $clientDetails['CLIENT']['ID']), 'recursive' => -1));
        $vendor = $this->VendorOriginationRoute->find('first', array('order' => array('VendorOriginationRoute.id DESC')));
        $orig = $this->OriginationRoute->find('first', array('order' => array('OriginationRoute.id DESC')));

        $i = 1;
        foreach($this->request->data as $key => $did) {
            $dids[$key]["BG_ID"] = $did;
            $vendorRoute[] = array(
                'id' => $vendor['VendorOriginationRoute']['id'] + $i,
                'vendor_id' => '5',
                'active' => 't',
                'descr' => '',
                'prefix' => $dids[$key]["E164"],
                'minute_cost' => '0.019',
                'min_duration' => '',
                'duration_incr' => '6'
            );

            $origRoute[] = array(
                'OriginationRoute' => array(
                    'id' => $orig['OriginationRoute']['id'] + $i,
                    'customer_bg_id' => $did,
                    'descr' => '',
                    'prefix' => $dids[$key]["E164"],
                    'orig_rate_id' => '1',
                    'active' => 't',
                )
            );
            $origRouteDest[] = array(
                'OriginationRouteCostDest' => array(
                    'orig_route_id' => $orig['OriginationRoute']['id'] + $i,
                    'priority' => 1,
                    'class_dest' => 'bg:'.$did,
                    'final' => 't'
                )
            );
            $i++;
        }

        $this->setDIDBg($vendorRoute, $origRoute, $origRouteDest);
        $this->Session->write('dids', $dids);
    }

    public function setDIDBg($vendorRoute, $origRoute, $origRouteDest) {
        $this->VendorOriginationRoute->begin();
        if($this->VendorOriginationRoute->saveAll($vendorRoute)) {
            $this->OriginationRoute->begin();
            if($this->OriginationRoute->saveAll($origRoute)) {

                if($this->OriginationRouteCostDest->saveAll($origRouteDest)) {
                    $dids = $this->Session->write('dids', array());
                    $this->OriginationRoute->commit();
                    $this->VendorOriginationRoute->commit();
                } else {
                    $this->OriginationRoute->rollback();
                    $this->VendorOriginationRoute->rollback();
                }

            } else
                $this->VendorOriginationRoute->rollback();
        }
        $this->redirect('quote_tool');
    }

    public function removeProduct() {
        $this->autoRender = false;
        if($this->request->data) {
            $devices = $this->Session->read('devices');
            foreach($devices['product']['products'] as $key => $device) {
                if($this->request->data['id'] == $device['id']) {
                    unset($devices['product']['products'][$key]);
                    $this->Session->write('devices', $devices);
                }
            }
        }
    }

    public function checkHasDevices() {
        $this->autoRender = false;
        $qid = $this->request->data['qid'];
        $quote = $this->SavedQuote->getQuote($qid);
        if (!empty($quote['PsCart']['PsCartProduct']))
            return true;

        return false;
    }

    public function addDevices() {
        $this->layout = false;
        $devices = $this->Session->read('devices');
        if(!empty($devices['product']['products'])) {
            $dataId = array();
            foreach($devices['product']['products'] as $key => $device) {
                array_push($dataId, $device['id']);
                $newArray[$device['id']] = $device['quantity'];
            }

            $selectedDevices = $this->PsProduct->getSelectedDevices($dataId);
            $devices = $newArray;
            $this->set(compact('selectedDevices', 'devices'));
        }
    }

    public function view_quote($qid) {
        $this->layout = false;

        $quote = $this->SavedQuote->getQuote($qid);

        /** Update cart*/
        $upd = array('date_upd' => date('Y-m-d H:i:s'));
        $this->PsCart->id = $quote['PsCart']['id_cart'];
        $this->PsCart->save($upd);
        $this->set(compact('quote'));
    }

    public function reviewQuote() {
        $this->layout = false;
        $devices = $this->Session->read('devices');
        $products = $this->Session->read('products');
        $products = !empty($products) ? $products : array();
        $devices = !empty($devices) ? $devices : array();

        $cats = array();
        $pids = array();
        $newArray = array();
        $selectedDevices = array();


        foreach($products as $key => $category) {
            array_push($cats, $key);
            foreach($category as $key2 => $product) {
                array_push($pids, $key2);
            }
        }

        $WHMCScategories = $this->Tblproductgroup->getWHMCScategories($pids, $cats);

        /** Get all devices by ids*/
        if(!empty($devices['product']['products'])) {
            $dataId = array();
            foreach($devices['product']['products'] as $key => $device) {
                array_push($dataId, $device['id']);
                $newArray[$device['id']] = $device['quantity'];
            }

            $selectedDevices = $this->PsProduct->getSelectedDevices($dataId);

        }

        if(empty($WHMCScategories) && empty($selectedDevices)) {
            $this->autoRender = false;
            return false;
        }

        $devices = $newArray;
        $this->set(compact('selectedDevices', 'devices', 'WHMCScategories', 'products'));
    }

    public function saveQuote() {
        $this->autoRender = false;

        $userDetails = $this->Session->read('clientDetails.CLIENT');
        $psUser = $this->PsCustomer->find('first', array('conditions' => array('PsCustomer.email' => $userDetails['EMAIL'])));
        $devices = $this->Session->read('devices');
        $products = $this->Session->read('products');
		$dids = $this->Session->read('dids');
		$this->Session->write('isCheckout', false);
        if(!empty($psUser)) {

            if(!empty($products) || !empty($devices['product']['products'])) {
                $this->SavedQuote->begin();
                if($this->SavedQuote->saveQuote($userDetails, $dids, $products, $this->_generateStrings(10), $this->request->data)) {
                    if($this->PsCart->saveCart($psUser, $devices, $this->SavedQuote->getLastInsertID())) {
                        $this->SavedQuote->commit();
                        return (!empty($this->request->data['method'])) ? $this->SavedQuote->id : true;
                    } else {
                        $this->SavedQuote->rollback();
                        return false;
                    }

                } else
                    return false;

            } else
                return 'invalid';

        } else
            return false;
    }

    public function updateQuote() {
        if($this->request->is('ajax')) {
            $this->autoRender = false;
            if($this->SavedQuote->save($this->request->data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function setShippingMethod() {
        $this->autoRender = false;

        $quoteDetails = $this->SavedQuote->findById($this->request->data['qid']);
        return json_encode($quoteDetails);
    }

    public function validateCheckoutAddress() {
        $this->SavedQuote->id = $this->request->data['Tblclient']['quotes_key'];
        $data = array(
            'country' => $this->request->data['Tblclient']['country'],
            'state' => $this->request->data['Tblclient']['state'],
            'city' => $this->request->data['Tblclient']['city'],
            'postcode' => $this->request->data['Tblclient']['postcode'],
            'address1' => $this->request->data['Tblclient']['address1'],
            'address_2' => $this->request->data['Tblclient']['address2'],
            'phonenumber' => $this->request->data['Tblclient']['phonenumber']
        );
        $this->SavedQuote->save($data);
        return parent::validateLocation();
    }

    /** Paypal Payment Gateway */
    public function processCheckout($qid = null) {
        $this->autoRender = false;
        if($qid) {
            $quote = $this->SavedQuote->findById($qid);
            $amount = $quote['SavedQuote']['total_price'] + $quote['SavedQuote']['onetime_fee'] + $quote['SavedQuote']['recurring_fee'] + $quote['SavedQuote']['shipping_cost'];
            $desc = 'Payment: Total Fee: $'.$quote['SavedQuote']['total_price'].' One Time Fee: $'.$quote['SavedQuote']['onetime_fee']." Monthly Fee: $".$quote['SavedQuote']['recurring_fee']." Shipping Cost: $".$quote['SavedQuote']['shipping_cost'];

            $this->Paypal->amount = number_format($amount, 2, '.', '');
            $this->Paypal->currencyCode = 'USD';
            $this->Paypal->returnUrl = Router::url('completeCheckout/'.$qid, true);
            $this->Paypal->cancelUrl = Router::url('', true);
            $this->Paypal->itemName = 'PeachTEL Checkout';
            $this->Paypal->orderDesc = $desc;
            $this->Paypal->quantity = 1;
            $this->Paypal->expressCheckout();
        } else {
            echo "Checkout Error: Invalid arguments supplied.";
        }
    }

    public function completeCheckout($qid) {
        $this->autoRender = false;
        $this->Paypal->token = $this->request->query['token'];
        $this->Paypal->payerId = $this->request->query['PayerID'];

        $customer_details = $this->Paypal->getExpressCheckoutDetails();
        $this->Paypal->amount = $customer_details['AMT'];
        $this->Paypal->currencyCode = $customer_details['CURRENCYCODE'];
        $this->Paypal->token = $customer_details['TOKEN'];
        $this->Paypal->payerId = $customer_details['PAYERID'];
        $response = $this->Paypal->doExpressCheckoutPayment();

        /** */
        if(isset($response) && $response['PAYMENTSTATUS'] == 'Completed') {
            $this->updateSavedQuote($qid);
        }
    }

    /** Google Payment Gateway */

    public function processGoogleCheckout($qid = null) {
        $this->layout = '';
        if($qid) {

            App::import("Vendor","google-checkout/library/googlecart");
            App::import("Vendor","google-checkout/library/googleitem");
            App::import("Vendor","google-checkout/library/googleshipping");
            $qid = $qid;
            $cart = new GoogleCart("912516949287892", "6i7uwy3PzYBp4MIn32y_dA", "sandbox", "USD");

            $quote = $this->SavedQuote->findById($qid);
            $amount = $quote['SavedQuote']['total_price'] + $quote['SavedQuote']['onetime_fee'] + $quote['SavedQuote']['recurring_fee'] + $quote['SavedQuote']['shipping_cost'];
            $item_1 = new GoogleItem("PeachTEL Quote #".$quote['SavedQuote']['name'], "Google Payment",  1, $amount);
            $cart->AddItem($item_1);

            $ship_1 = new GoogleFlatRateShipping("USPS", 0.00);
            $Gfilter = new GoogleShippingFilters();
            $Gfilter->SetAllowedCountryArea('CONTINENTAL_48');
            $ship_1->AddShippingRestrictions($Gfilter);

            $cart->AddShipping($ship_1);
            $cart->SetEditCartUrl("http://devweb.peachtel.net/myaccount/quotes/quotes_tool");
            $cart->SetContinueShoppingUrl("http://devweb.peachtel.net/myaccount/quotes/googleCompleteCheckout/".$qid);

            /** set cart data */
            $data = "<quote-id>".$qid."</quote-id>";
            $cart->SetMerchantPrivateData($data);

            $cart->SetRequestBuyerPhone(false);

            $btn = $cart->CheckoutButtonCode("SMALL", true, "en_US", false, "trans");

            $this->set(compact('btn'));
        } else {
            $this->autoRender = false;
            echo "Invalid arguments supplied.";
        }
    }

    public function googleCallback() {
        App::import("Vendor","google-checkout/library/googleresponse");
        $resp = new GoogleResponse("912516949287892", "6i7uwy3PzYBp4MIn32y_dA");

        pr($resp->ProcessNewOrderNotification());
    }

    public function googleCompleteCheckout($qid) {

        $this->updateSavedQuote($qid);
    }

    /** Authorize.net Payment Gateway */

    public function processAuthorizeCheckout($qid) {
        $this->layout = '';
        $quote = $this->SavedQuote->findById($qid);
        $amount = $quote['SavedQuote']['total_price'] + $quote['SavedQuote']['onetime_fee'] + $quote['SavedQuote']['recurring_fee'] + $quote['SavedQuote']['shipping_cost'];

        if($this->request->data) {
            $cardnumber = $this->request->data['Tblticketreply']['cardnum'];
            $cardexp = $this->request->data['Tblticketreply']['expdata'];
            App::import("Vendor","anet_php_sdk/AuthorizeNet");
            $transaction = new AuthorizeNetAIM('8943KRYJthAW', '27Z74gDRCx9Lb9s7');
            $transaction->amount = $amount;
            $transaction->card_num = $cardnumber;
            $transaction->exp_date = $cardexp;

            $response = $transaction->authorizeAndCapture();
            if ($response->approved) {
                $this->updateSavedQuote($qid);
                $this->render("../Elements/quotes/process_authorize2");
            } else {
              echo $response->error_message;
              echo "<pre>";
              print_r($response);
              echo "</pre>";
            }
        }
    }

    public function createWhmcsOrder($qid) {
        $quoteItem = $this->SavedQuote->findById($qid);
        App::import("Vendor","vrcloud/config");
        $vr = new vr_cloud(VR_API_KEY);

        if($quoteItem['SavedQuote']['whmcs_oid'] == 0 || empty($quoteItem['SavedQuote']['whmcs_oid'])) {
            /** create whmcs order*/
            $addorder["action"] = "addorder";

            $i = 0;
            foreach($quoteItem['WhmcsProduct'] as $lineitem) {
                $line = $this->Tblproduct->findById($lineitem['product_id']);
                if($line['Tblproduct']['gid'] == 2 || $line['Tblproduct']['gid'] == 10) {

                    $name = preg_replace('/\D/', '', $line['Tblproduct']['name']);
                    if($name >= 2 || $name <= 8)
                        $plan = "VRp5";
                    else
                        $plan = "VR1G";

                    $vrret = $vr->buy($plan);

                    $addorder["pid[".$i."]"] = $lineitem['product_id'];
                    $addorder["domain[".$i."]"] = $vrret->id.".itaki.net";
                    $i++;
                }
            }

            $data = array('user_id' => $quoteItem['SavedQuote']['user_id'], 'domain' => $vrret->id.".itaki.net");
            $this->Server->save($data);

            $addorder["clientid"] = $quoteItem['SavedQuote']['user_id'];
            $addorder["noemail"] = true;
            $addorder["paymentmethod"] = "paymentsgateway";
            $whmcsOrder = parent::whmcsInvoker($addorder);

            /** Update Invoice to paid*/
            if($whmcsOrder['WHMCSAPI']['RESULT'] == 'success') {
                $invoiceId = $whmcsOrder['WHMCSAPI']['INVOICEID'];

                $updateinvoice["action"] = "updateinvoice";
                $updateinvoice["invoiceid"] = $invoiceId;
                $updateinvoice["status"] = "Paid";
                $whmcsInvoice = parent::whmcsInvoker($updateinvoice);

                if($whmcsInvoice['WHMCSAPI']['RESULT'] == 'success') {
                    $this->SavedQuote->id = $qid;
                    if($this->SavedQuote->save(array('whmcs_oid' => $whmcsOrder['WHMCSAPI']['ORDERID'])))
                        return true;
                    else
                        return false;
                }
            }
        }

        return true;
    }

    public function getShippingMethod() {
        $this->layout = false;
        $this->request->data = $this->request->data['Tblclient'];
        $url = "https://www.netxusa.com/order2.php";
		$curl['action'] = "shippingquotes";
		$curl['loginname'] = "itaki";
		$curl['loginpass'] = "tg8z2rsb";
        $curl['contact'] = "VoipLion";
        $curl['shippingmethod'] = "Ground";
		$curl['address1'] = $this->request->data['address1'];
		$curl['city'] = $this->request->data['city'];
		$curl['state'] = $this->request->data['state'];
		$curl['zip'] = $this->request->data['postcode'];
		$curl['country'] = $this->request->data['country'];
        $quoteKey = $this->SavedQuote->findById($this->request->data['quotes_key']);
		$curl['ordernumber'] = $quoteKey['SavedQuote']['name'];

		$curl['phonenumber'] = $this->request->data['phonenumber'];  //default this to VoipLion number in case NetX has to call
		$curl['shipper'] = $this->request->data['carrier'];
		$curl['insurance'] = ($this->request->data['insurance']) ? 'yes' : 'no';
		$curl['devicelist'] = "@/var/www/myaccount/app/webroot/files/devicelist.csv";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curl);
		$returndata = curl_exec($ch); //execute post and get results
        curl_close($ch);

        $err = explode(':', $returndata);

        if(!isset($err[1])) {

            $this->SavedQuote->id = $this->request->data['quotes_key'];
            $this->SavedQuote->save($this->request->data);

            $getFields = preg_split('/\n/', $returndata);
            $response = array_map("str_getcsv", $getFields);
            $this->set(compact('response'));
        } else {
            $this->set(compact('err'));
        }
    }

    public function checkSession() {
        $this->autoRender = false;
        $client = $this->Session->read('clientDetails');
        if(!empty($client)) {
            return true;
        } else {
            return false;
        }
    }

    /** Invoke via prestashop AJAX and write product in session*/
    public function psProductLogger() {
        $this->autoRender = false;
        if($this->request->data) {
            $this->Session->write('devices', $this->request->data);
        }
    }

    public function psLogDelete() {
        $this->Session->delete('products');
        $this->Session->delete('devices');
        $this->Session->delete('dids');
    }

    public function updateSavedQuote($qid) {
        $this->SavedQuote->id = $qid;
        if($this->SavedQuote->save(array('status' => 'shipping'))) {
            $oid = $this->createWhmcsOrder($qid);
            if($oid) {
                $this->psLogDelete();
                $this->createPrestashopOrder($qid);
                $this->autoRender = true;
                $this->layout = '';
            } else {
                $this->SavedQuote->save(array('status' => 'saved'));
            }
        } else {
            echo 'Error: Checkout failed.';
        }
    }

    private function createPrestashopOrder($qid) {
        $this->autoRender = false;
        $psCart = $this->PsCart->getPsCart($qid);

        $total = 2;
        foreach($psCart['PsCartProduct'] as $product) {
            $total += $product['quantity'] *  $product['PsProduct']['price'];
        }

        app::import('Vendor', 'PSWebServiceLibrary');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, FALSE);
        $psXML = '<prestashop xmlns:xlink="http://www.w3.org/1999/xlink">
                        <order>
                            <id_address_delivery required="true" format="isUnsignedId">1</id_address_delivery>
                            <id_address_invoice required="true" format="isUnsignedId">1</id_address_invoice>
                            <id_cart required="true" format="isUnsignedId">'.$psCart['PsCart']['id_cart'].'</id_cart>
                            <id_currency required="true" format="isUnsignedId">1</id_currency>
                            <id_lang required="true" format="isUnsignedId">1</id_lang>
                            <id_customer required="true" format="isUnsignedId">'.$psCart['PsCart']['id_customer'].'</id_customer>
                            <id_carrier required="true" format="isUnsignedId">1</id_carrier>
                            <module required="true">cheque</module>
                            <invoice_number/>
                            <invoice_date/>
                            <delivery_number/>
                            <delivery_date/>
                            <valid/>
                            <current_state not_filterable="true"/>
                            <date_add/>
                            <date_upd/>
                            <secure_key format="isMd5"/>
                            <payment required="true" format="isGenericName">Cheque</payment>
                            <recyclable format="isBool"/>
                            <gift format="isBool"/>
                            <gift_message format="isMessage"/>
                            <total_discounts format="isPrice"/>
                            <total_paid required="true" format="isPrice">'.$total.'</total_paid>
                            <total_paid_real required="true" format="isPrice">'.$total.'</total_paid_real>
                            <total_products required="true" format="isPrice">1</total_products>
                            <total_products_wt required="true" format="isPrice">1</total_products_wt>
                            <total_shipping format="isPrice"/>
                            <carrier_tax_rate format="isFloat"/>
                            <total_wrapping format="isPrice"/>
                            <shipping_number format="isUrl"/>
                            <conversion_rate required="true" format="isFloat">0.1</conversion_rate>
                        </order>
                    </prestashop>';

        try {
            $xmls = simplexml_load_string($psXML);
            $opt = array( 'resource' => 'orders' );
            $opt['postXml'] = $xmls->asXML();
            $webService->add( $opt );
        } catch(Exception $e) {
            return;
        }
    }

    private function _generateStrings($limit) {
        $keys = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $quoteName = '';

        for($i = 0; $i < $limit; $i++) {
            $quoteName .= $keys[rand(0, strlen($keys) - 1)];
        }

        return $quoteName;
    }

    public function getDIDInfo($params) {
        $url = "http://sandbox.anveo.com/api/v2.asp";
        $params['USERKEY'] = "b61461446d111455a901f1a9dff1b686f8d1e5c4";
        $queryString = '';
        asort($params);
        foreach($params as $key => $param) {
            if(is_array($param)) {
                $i = 1;
                foreach($param as $key2 => $sub) {
                    $queryString .= $key.'['.$key2.']='.$sub;

                    if($i < count($param)) {
                        $queryString .= "&";
                    }

                    $i++;
                }
            } else
                $queryString .= $key.'='.$param."&";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url. '?' .$queryString);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $this->xmlToArray($data);
    }

    private function xmlToArray($xml) {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $xml, $vals, $index);
        xml_parser_free($xml_parser);

        $ret = array();
        foreach($vals as $val) {
            if(isset($val['attributes']))
                $ret[] = $val['attributes'];
        }
        return $ret;
    }
}
