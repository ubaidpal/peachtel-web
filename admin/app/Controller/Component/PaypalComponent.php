<?php

// 
//  Paypal.php
//  CakePHP 2.0 component for paypal website payments pro
//  PayPal Express and Direct Payments
//  Created by Rob Mcvey on 2011-12-03.
//  Copyright 2011 Rob Mcvey. All rights reserved.
// 
App::uses('HttpSocket', 'Network/Http');

class PaypalComponent extends Component {

    // Live v Sandbox mode !important
    public $sandboxMode = true;
    // Live paypal API config
    public $config = array(
        'webscr' => 'https://www.paypal.com/webscr/',
        'endpoint' => 'https://api.paypal.com/nvp/',
        'password' => 'ZZRXU39JJJ52JUPG',
        'email' => 'menporcs14_api1.gmail.com',
        'signature' => 'AhnWJUsUy0B1zvH6DOdL1HXeboQXAkUVJIYqbUf2RS3YMsDq2vcscgB5'
    );
    // Sandbox paypal API config
    public $sandboxConfig = array(
        'webscr' => 'https://www.sandbox.paypal.com/webscr/',
        'endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
        //'endpoint' => 'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay',
        //'endpoint' => 'https://api.sandbox.paypal.com/nvp/',
        'password' => '1362550024',
        'email' => 'itaki_1362549961_biz_api1.mailinator.com',
        'signature' => 'A3Lp-EHvt8IhbTidnvhKikktU0xvATuE4guuqAU5TwshZ.9d8TGWEw6x'
    );
    // API version
    public $apiVersion = '53.0';
    // Return URL for express payments
    public $returnUrl = '';
    // Cancel URL for Express payments cancelled
    public $cancelUrl = '';
    // Default Currency code
    public $currencyCode = 'USD';
    //The amount of the transaction For example, EUR 2.000,00 must be specified as 2000.00 or 2,000.00.	
    public $amount = null;
    // Customise Express checkout with a description (api version > 53)
    public $itemName = '';
    // Customise Express checkout with a description (api version > 53)
    public $orderDesc = '';
    // optional quantity
    public $quantity = 1;
    // The token returned from payapl and used in subsequesnt reuqest
    public $token = null;
    // The payers paypal ID 
    public $payerId = null;
    // Credit card details
    public $creditCardNumber = '';
    public $creditCardType = '';
    public $creditCardExpires = '';
    public $creditCardCvv = '';
    // Customer details
    public $customerSalutation = '';
    public $customerFirstName = '';
    public $customerMiddleName = '';
    public $customerLastName = '';
    public $customerSuffix = '';
    public $logoimg = '';
    // Billing details
    public $billingAddress1 = '';
    public $billingAddress2 = '';
    public $billingCity = '';
    public $billingState = '';
    public $billingCountryCode = '';
    public $billingZip = '';
    // Users IP address
    public $ipAddress = '';
    // controller reference
    protected $_controller = null;

    /**
     * Start up, gets an instance on the controller class (needed for redirect) sets 
     * the config (live or sandbox) and sets the users IP 
     *
     * @return void
     * @author Rob Mcvey
     * */
    public function initialize($controller) {
        $this->_controller = $controller;
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
        if ($this->sandboxMode) {
            $this->config = $this->sandboxConfig;
        } else {
            $this->PaypalAccount = ClassRegistry::init('PaypalAccount');
            $config = $this->PaypalAccount->read(null, 1);
            if (!empty($config['PaypalAccount']['password'])
                    && !empty($config['PaypalAccount']['username'])
                    && !empty($config['PaypalAccount']['signature'])) {
                $this->config['password'] = $config['PaypalAccount']['password'];
                $this->config['email'] = $config['PaypalAccount']['username'];
                $this->config['signature'] = $config['PaypalAccount']['signature'];
            } else {
                $this->config = $this->sandboxConfig;
            }
        }
    }

    /**
     * Generated a fresh token and redirects the use to the paypal page
     *
     * @return void
     * @author Rob Mcvey
     * */
    public function expressCheckout() {

        // We dont have a valid amount	
        if (!isset($this->amount) || empty($this->amount) || !is_numeric($this->amount)) {
            throw new Exception(__('Invalid amount - must be numeric in the format 1234.00'));
        }

        // Call the SetExpressCheckout method to get a fresh token
        $token = $this->setExpressCheckout();

        // We have a token, redirect to paypals web server (not the URL is different to the API endpoint)
        if ($token) {
            $this->_controller->redirect($this->config['webscr'] . '?cmd=_express-checkout&token=' . $token);
        } else {
            $this->log($token, 'paypal');
            throw new Exception(__('The was a problem with the payment gateway'));
        }
    }

    /**
     * To set up an Express Checkout transaction, you must invoke the SetExpressCheckout API 
     * operation to provide sufficient information to initiate the payment flow and redirect 
     * to PayPal if the operation was successful with the token sent back from Paypal
     *
     * @return string $token A token to be used when redirecting the user to PayPal
     * @author Rob Mcvey
     * */
    public function setExpressCheckout() {

        // Build the NVPs (Named value pairs)	
        $setExpressCheckoutNvp = array(
            'METHOD' => 'SetExpressCheckout',
            'VERSION' => $this->apiVersion,
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            'CURRENCYCODE' => $this->currencyCode,
            'RETURNURL' => $this->returnUrl,
            'CANCELURL' => $this->cancelUrl,
            'PAYMENTACTION' => 'ORDER',
            'AMT' => $this->amount,
            'L_NAME0' => $this->itemName,
            'L_DESC0' => $this->orderDesc,
            'L_AMT0' => $this->amount,
            'L_QTY0' => $this->quantity,
        );
        //debug($setExpressCheckoutNvp); exit();
        // HTTPSocket class		
        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $setExpressCheckoutNvp);
        // Parse the guff that comes back from paypal
        parse_str($response->body, $parsed);

        // Return the token, or throw a human readable error
        if (array_key_exists('TOKEN', $parsed) && array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed['TOKEN'];
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_LONGMESSAGE0']);
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_ERRORCODE0']);
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    /**
     * To obtain details about an Express Checkout transaction, you can invoke the 
     * GetExpressCheckoutDetails API operation. 
     * 
     * @return array $parsed An array of fields with the customers details, or throws and exception
     * @author Rob Mcvey
     * */
    public function getExpressCheckoutDetails() {

        // Build the NVPs (Named value pairs)	
        $getExpressCheckoutDetailsNvp = array(
            'METHOD' => 'GetExpressCheckoutDetails',
            'TOKEN' => $this->token,
            'VERSION' => $this->apiVersion,
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
        );

        // HTTPSocket class		
        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $getExpressCheckoutDetailsNvp);

        // Parse the guff that comes back from paypal
        parse_str($response, $parsed);

        // Return the token, or throw a human readable error
        if (array_key_exists('TOKEN', $parsed) && array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_LONGMESSAGE0']);
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_ERRORCODE0']);
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    /**
     * To complete an Express Checkout transaction, you must invoke the 
     * DoExpressCheckoutPayment API operation. 
     *
     * @return array $parsed An array of fields with the payment info, or throws and exception
     * @author Rob Mcvey
     * */
    public function doExpressCheckoutPayment() {

        // Build the NVPs (Named value pairs)	
        $doExpressCheckoutPaymentNvp = array(
            'METHOD' => 'DoExpressCheckoutPayment',
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            'VERSION' => $this->apiVersion,
            'TOKEN' => $this->token,
            'PAYERID' => $this->payerId,
            'PAYMENTACTION' => 'Sale',
            'CURRENCYCODE' => $this->currencyCode,
            'AMT' => $this->amount
        );

        // HTTPSocket class		
        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $doExpressCheckoutPaymentNvp);

        // Parse the guff that comes back from paypal
        parse_str($response, $parsed);

        // Return the token, or throw a human readable error
        if (array_key_exists('TOKEN', $parsed) && array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_LONGMESSAGE0']);
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_ERRORCODE0']);
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    /**
     * The DoDirectPayment API Operation enables you to process a credit card payment.
     *
     * @return array $parsed An array of fields with the payment info, or throws and exception
     * @author Rob Mcvey
     * */
    public function doDirectPayment() {

        // Build the NVPs (Named value pairs)	
        $doDirectPaymentNvp = array(
            'METHOD' => 'DoDirectPayment',
            'PAYMENTACTION' => 'SALE',
            'VERSION' => $this->apiVersion,
            'AMT' => $this->amount,
            'CURRENCYCODE' => $this->currencyCode,
            'IPADDRESS' => $this->ipAddress,
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            // Credit Card Details
            'CREDITCARDTYPE' => $this->creditCardType,
            'ACCT' => $this->creditCardNumber,
            'EXPDATE' => $this->creditCardExpires,
            'CVV2' => $this->creditCardCvv,
            // Customer Details
            'SALUTATION' => $this->customerSalutation,
            'FIRSTNAME' => $this->customerFirstName,
            'MIDDLENAME' => $this->customerMiddleName,
            'LASTNAME' => $this->customerLastName,
            'SUFFIX' => $this->customerSuffix,
            // Billing Address
            'STREET' => $this->billingAddress1,
            'STREET2' => $this->billingAddress2,
            'CITY' => $this->billingCity,
            'STATE' => $this->billingState,
            'COUNTRYCODE' => $this->billingCountryCode,
            'ZIP' => $this->billingZip,
        );

        $this->log($doDirectPaymentNvp);

        // HTTPSocket class		
        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $doDirectPaymentNvp);

        // Parse the guff that comes back from paypal
        parse_str($response, $parsed);

        // Return the token, or throw a human readable error
        if (array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_LONGMESSAGE0']);
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            $this->log($parsed, 'paypal');
            throw new Exception($parsed['ACK'] . ' : ' . $parsed['L_ERRORCODE0']);
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    public function partialRefund() {

        // Build the NVPs (Named value pairs)	
        $partialRefundNvp = array(
            'METHOD' => 'RefundTransaction',
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            'VERSION' => $this->apiVersion,
            'CURRENCYCODE' => $this->currencyCode,
            'TRANSACTIONID' => $this->transactionid,
            'REFUNDTYPE' => $this->refundtype,
            'AMT' => $this->amount,
        );

        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $partialRefundNvp);

        // Parse the guff that comes back from paypal
        parse_str($response->body, $parsed); //debug($parsed);
        //debug($parsed); exit();

        if (array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    public function massPayment($paypal, $amount, $count) {
        $massUser = array();
        $massPayNvp = array();

        for ($i = 0; $i < $count; $i++) {
            $paypal[$i] = array(
                'L_AMT' . $i => $amount[$i],
                'L_EMAIL' . $i => $paypal[$i],
            );
            $massUser = array_merge($massUser, $paypal[$i]);
        }

        $paypalConfig = array(
            'METHOD' => 'MassPay',
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            'VERSION' => $this->apiVersion,
            'EMAILSUBJECT' => 'HireAnAussie Payment',
            'CURRENCYCODE' => 'AUD',
            'RECEIVERTYPE' => 'EmailAddress',
            'FEESPAYER' => 'EACHRECEIVER',
        );

        $massPayNvp = array_merge($paypalConfig, $massUser);

        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $massPayNvp); // debug($response);
        // Parse the guff that comes back from paypal
        parse_str($response->body, $parsed);
        debug($parsed);


        if (array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    public function pay($amount, $user, $admin) {
        ini_set("track_errors", true);
        $url = trim("https://svcs.sandbox.paypal.com/AdaptivePayments/Pay");

        $api_appid = 'APP-80W284485P519543T';
        $API_UserName = "hireau_1340070090_biz_api1.yahoo.com";
        $API_Password = "1340070127";
        $API_Signature = "Alk75-ux3vfmgvFc2VbhqP2hyTJ0AueSkiH6l3A8vAlvM0FYAHDcyt.U";
        $API_AppID = "APP-80W284485P519543T";
        $API_RequestFormat = "NV";
        $API_ResponseFormat = "NV";

        if ($admin['PaypalAccount']['email'] != null) {
            $sendEmail = $admin['PaypalAccount']['email'];
        } else {
            $sendEmail = "hireau_1340070090_biz@yahoo.com";
        }

        $bodyparams = array("requestEnvelope.errorLanguage" => "en_US",
            "actionType" => "PAY",
            "cancelUrl" => "http://cancelUrl",
            "returnUrl" => "http://returnUrl",
            "currencyCode" => "AUD",
            "senderEmail" => $sendEmail,
            "receiverList.receiver.email" => $user['User']['paypal_account'],
            "receiverList.receiver.amount" => $amount
        );

        $body_data = http_build_query($bodyparams, "", chr(38));

        try {
            $params = array("http" => array(
                    "method" => "POST",
                    "content" => $body_data,
                    "header" => "X-PAYPAL-SECURITY-USERID: " . $API_UserName . "\r\n" .
                    "X-PAYPAL-SECURITY-SIGNATURE: " . $API_Signature . "\r\n" .
                    "X-PAYPAL-SECURITY-PASSWORD: " . $API_Password . "\r\n" .
                    "X-PAYPAL-APPLICATION-ID: " . $API_AppID . "\r\n" .
                    "X-PAYPAL-REQUEST-DATA-FORMAT: " . $API_RequestFormat . "\r\n" .
                    "X-PAYPAL-RESPONSE-DATA-FORMAT: " . $API_ResponseFormat . "\r\n"
                    ));
            $returnData = array();
            $ctx = stream_context_create($params);
            $fp = @fopen($url, "r", false, $ctx);
            if (!empty($fp)) {
                $response = stream_get_contents($fp);
            } else {
                throw new Exception("php error message = " . "$php_errormsg");
            }
            if ($response === false) {
                throw new Exception("php error message = " . "$php_errormsg");
            }
            fclose($fp);

            $keyArray = explode("&", $response);

            foreach ($keyArray as $rVal) {
                list($qKey, $qVal) = explode("=", $rVal);
                $kArray[$qKey] = $qVal;
            }

            if ($kArray["responseEnvelope.ack"] == "Success") {
                foreach ($kArray as $key => $value) {
                    $returnData[$key] = $value;
                }
            } else {
                $returnData['ERROR Code'] = $kArray["error(0).errorId"];
                $returnData['ERROR Message'] = urldecode($kArray["error(0).message"]);
            }
            return $returnData;
        } catch (Exception $e) {
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    public function executePayment($response) {
        //turn php errors on
        ini_set("track_errors", true);

        //set PayPal Endpoint to sandbox
        $url = trim("https://svcs.sandbox.paypal.com/AdaptivePayments/ExecutePayment");

        $api_appid = 'APP-80W284485P519543T';   // para sandbox
        //PayPal API Credentials
        $API_UserName = "hireau_1340070090_biz_api1.yahoo.com"; //TODO
        $API_Password = "1340070127"; //TODO
        $API_Signature = "Alk75-ux3vfmgvFc2VbhqP2hyTJ0AueSkiH6l3A8vAlvM0FYAHDcyt.U"; //TODO
        //Default App ID for Sandbox    
        $API_AppID = "APP-80W284485P519543T";

        $API_RequestFormat = "NV";
        $API_ResponseFormat = "NV";


        //Create request payload with minimum required parameters
        $bodyparams = array(
            "requestEnvelope.errorLanguage" => "en_US",
            "payKey" => $response['payKey'],
            "senderOptions" => '',
            "receiverOptions" => '',
        );

        // convert payload array into url encoded query string
        $body_data = http_build_query($bodyparams, "", chr(38));

        try {
            $params = array("http" => array(
                    "method" => "POST",
                    "content" => $body_data,
                    "header" => "X-PAYPAL-SECURITY-USERID: " . $API_UserName . "\r\n" .
                    "X-PAYPAL-SECURITY-SIGNATURE: " . $API_Signature . "\r\n" .
                    "X-PAYPAL-SECURITY-PASSWORD: " . $API_Password . "\r\n" .
                    "X-PAYPAL-APPLICATION-ID: " . $API_AppID . "\r\n" .
                    "X-PAYPAL-REQUEST-DATA-FORMAT: " . $API_RequestFormat . "\r\n" .
                    "X-PAYPAL-RESPONSE-DATA-FORMAT: " . $API_ResponseFormat . "\r\n"
                    ));

            $ctx = stream_context_create($params);
            $fp = @fopen($url, "r", false, $ctx);
            $response = stream_get_contents($fp);
            if ($response === false) {
                throw new Exception("php error message = " . "$php_errormsg");
            }
            fclose($fp);

            $keyArray = explode("&", $response);

            foreach ($keyArray as $rVal) {
                list($qKey, $qVal) = explode("=", $rVal);
                $kArray[$qKey] = $qVal;
            }

            if ($kArray["responseEnvelope.ack"] == "Success") {
                foreach ($kArray as $key => $value) {
                    echo $key . ": " . $value . "<br/>";
                }
            } else {
                echo 'ERROR Code: ' . $kArray["error(0).errorId"] . " <br/>";
                echo 'ERROR Message: ' . urldecode($kArray["error(0).message"]) . " <br/>";
            }
        } catch (Exception $e) {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

    public function massPayment_hourly($paypal, $amount, $count) {
        $massUser = array();
        $massPayNvp = array();
        $paypal = array(
            'L_AMT0' => $amount,
            'L_EMAIL0' => $paypal,
        );
        $paypalConfig = array(
            'METHOD' => 'MassPay',
            'USER' => $this->config['email'],
            'PWD' => $this->config['password'],
            'SIGNATURE' => $this->config['signature'],
            'VERSION' => $this->apiVersion,
            'EMAILSUBJECT' => 'HireAnAussie Payment',
            'CURRENCYCODE' => 'AUD',
            'RECEIVERTYPE' => 'EmailAddress',
        );

        $massPayNvp = array_merge($paypalConfig, $paypal);

        $httpSocket = new HttpSocket();

        // Post the NVPs to the relevent endpoint
        $response = $httpSocket->post($this->config['endpoint'], $massPayNvp);

        // Parse the guff that comes back from paypal
        parse_str($response->body, $parsed);


        if (array_key_exists('ACK', $parsed) && $parsed['ACK'] == 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_LONGMESSAGE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } elseif (array_key_exists('ACK', $parsed) && array_key_exists('L_ERRORCODE0', $parsed) && $parsed['ACK'] != 'Success') {
            return $parsed;
        } else {
            $this->log($parsed, 'paypal');
            throw new Exception(__('There is a problem with the payment gateway. Please try again later.'));
        }
    }

}
