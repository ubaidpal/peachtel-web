<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PrivateFunctionsController extends AppController {

    public $uses= array('Nextusa', 'PsProduct', 'PsStockAvailable');
    
    public function beforeFilter() {
        set_time_limit(0);
        parent::beforeFilter();
    }
    
    public function userloggedIn() {
        $this->autoRender = false;
        if ($this->Session->read('id') != null)
            return true;
        $this->Session->setFlash(__('<font style="color:red;">Please Login first</font>'));
        $this->redirect(array("controller" => "admintools", "action" => "adminlogin"));
    }
    
    public function itaki_network_product() {

        if ($this->userloggedIn()) {
            $this->autoRender = true;
            $this->layout = 'privateDefault';

            if($this->request->data) {
                if(isset($this->request->data['Nextusa']['product_csv'])) {
                    $file = $this->request->data['Nextusa']['product_csv'];
                    
                    if (!in_array($file['type'], array('application/vnd.ms-excel', 'text/csv', 'application/octet-stream'))) {
                        $this->Session->setFlash(__('Only CSV file format is allowed.', true), 'error');
                        $this->redirect('itaki_network_product');
                    }
                    
                    App::import("Vendor","parsecsv/parsecsv");

                    $csv = new parseCSV();
                    $csv->headKey = false;
                    $csv->auto($file['tmp_name']);
                                    
                    $manufacturers = $this->_getProductAssociation('manufacturers');
                    //$categories = $this->_getProductAssociation('categories');
                    $this->Session->setFlash(_("New products added."));
                    
                    foreach($csv->data as $product) {

                        if($product[1] != '') {
                            
                            $product[4] = ereg_replace("[^0-9.]", "", $product[4]);
                            $convmap= array(0x0100, 0xFFFF, 0, 0xFFFF);
                            $iso1 = utf8_decode(mb_encode_numericentity($product[1], $convmap, 'UTF-8'));
                            $iso2 = htmlspecialchars(utf8_decode(mb_encode_numericentity($product[2], $convmap, 'UTF-8')));
                            $iso3 = htmlspecialchars(utf8_decode(mb_encode_numericentity($product[3], $convmap, 'UTF-8')));
                            
                            /** get product manufacturer */
                            $key = array_keys($manufacturers, $product[0]);
                            
                            /**
                            Populate description and short description
                            if(strlen($iso3) < 400) {
                                $addLength =  400 - strlen($iso3);
                                $iso3 = $iso3." ".substr($iso3, 0, $addLength);
                            } else if(strlen($iso3) > 790) {
                            	$iso3 = substr($iso3, 0, 790);
                            }
                            */
                            
                            /** Passed params*/
                            $data = array(
                                'manufacturer' => $key[0],
                                'category' => '2',
                                'name' => $product[0].' '.$iso1,
                                'reference' => $iso2,
                                'description' => $iso3,
                                'description_short' => $iso3,
                                'base_price' => $product[4],
                                'final_price' => ($product[4] * .12) + $product[4],
                                'upc' => '1',
                                'active' => 1,
                                'visibility' => 'catalog',
                                'condition' => 'new',
                                'image' => $product[7]
                            );

                            $success = self::_callProductInsert($data);

                            if(!$success) {
                                $this->Session->setFlash(_("Error on importing products, Please make sure your CSV is in the right format."));
                            }
                        }
                    }
                    
                    $this->redirect('itaki_network_product'); 
                        
                } else {
                    $success = self::_callProductInsert($this->request->data['Nextusa']);
                    if($success) {
                        $this->Session->setFlash(_("New product added."));
                        $this->redirect('itaki_network_product');  
                    } else {
                        $this->Session->setFlash(_("Failed to add new product."));
                        $this->redirect('itaki_network_product');
                    }
                }
            }
        }
    }
    
    public function bulkUploadImages() {
        $this->autoRender = false;
        $uploadDirectory = 'images/uploads/';
        $file = $uploadDirectory . basename($_FILES['BulkImages']['name']); 
        if (move_uploaded_file($_FILES['BulkImages']['tmp_name'], $file)) { 
            echo "success"; 
        } else {
            echo "error";
        }
    }
    
    public function import() {
        if ($this->userloggedIn()) {    
            $this->autoRender = true;
            $this->layout = 'privateDefault';

            if($this->request->data) {
                $file = $this->request->data['Nextusa']['csv_file'];

                if (!in_array($file['type'], array('application/vnd.ms-excel', 'text/csv', 'application/octet-stream'))) {
                    $this->Session->setFlash(__('Only CSV file format is allowed', true), 'error');
                    $this->redirect('import');
                }

                App::import("Vendor","parsecsv/parsecsv");
                
                $csv = new parseCSV();
                $csv->headKey = false;
                $csv->auto($file['tmp_name']);
                
                $i= 0;

                foreach($csv->data as $data) {
                    $data[6] = ereg_replace("[^0-9.]", "", $data[6]);
                    
                    $csvData[$i] = array(
                        'manufacturer' => $data[0],
                        'product_name' => $data[1],
                        'part_number' => $data[2],
                        'description' => $data[3],
                        'provisionable' => $data[4],
                        'msrp' => $data[5],
                        'qty1' => $data[6],
                        'w_labels' => $data[7],
                        'w_labels_provisioning' => $data[8],
                        'w_provisioning' => $data[9],
                    );

                    $id = $this->Nextusa->checkExisting($data);

                    if(!empty($id)) {
                        $csvData[$i]['id'] = $id;
                    }

                    $i++;
                }

                if($this->Nextusa->saveAll($csvData)) {
                    $this->Session->setFlash(_("Import CSV Success."));
                    $this->redirect('import');
                } else {
                    $this->Session->setFlash(_("Failed to save csv."));
                    $this->redirect('import');
                }

            }
        }
    }
      
    private function _getProductAssociation($assoc) {
        app::import('Vendor', 'PSWebServiceLibrary');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
        $opt['resource'] = $assoc;
        $xml = $webService->get($opt);
        
        // Here we get the elements from children of customer markup which is children of prestashop root markup
        $resources = $xml->children()->children();
        
        $i = 0;
        foreach($resources as $resource) {
            $id = $resource->attributes();
            $id = (array)$id['id'];
            $opt['id'] = $id[0];

            $a_xml = $webService->get($opt);
            $data = $a_xml->children()->children();
            
            foreach ($data as $key => $a_data) {
                if($key == "name") {
                    $associations[$id[0]] = htmlentities($a_data);                
                }
            }
            $i++;
        }
        
        /** test get product 
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
        $opt['resource'] = 'products';
        $opt['id'] = 157;
        $p_xml = $webService->get($opt);
        $pdata = $p_xml->children()->children();
        
        foreach ($pdata as $key => $p_data) {
            echo $key.$p_data."<br />";
        }
        */
        
        return $associations;
    }
    
    public function itakiCart() {
        $this->autoRender = false;
        
        app::import('Vendor', 'PSWebServiceLibrary');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
        $xml = $webService -> get(array('url' => PS_SHOP_PATH . '/api/carts?schema=blank'));
        $resources = $xml -> children() -> children();
        
        
        $resource->id_address_delivery = 0;
        $resource->id_address_invoice = 0;
        $resource->id_currency = 1;
        $resource->id_customer = 2;
        $resource->id_guest = 2;
        $resource->id_lang = 1;
        $resource->id_shop_group = 1;
        $resource->id_shop = 1;
        $resource->id_carrier = 0;
        $resource->recyclable = 1;
        $resource->gift = 0;
        $resource->gift_message = '';
        $resource->delivery_option = '';
        $resource->secure_key = '92c00d54181431efc470820f407586cc';
        $resource->allow_seperated_package = 0;
        $resource->date_add = date('Y-m-d H:i:s');
        $resource->date_upd = date('Y-m-d H:i:s');
        $resource->associations->cart_rows->cart_row->id_product = 1;
        $resource->associations->cart_rows->cart_row->id_product_attribute = 0;
        $resource->associations->cart_rows->cart_row->quantity = 1;
        
        try {
            
            $opt = array('resource' => 'carts');
            $opt['postXml'] = $xml -> asXML();
            $xml = $webService -> add($opt);
            
            return true;
            
        } catch(PrestaShopWebserviceException $ex) {
            
            echo '<b>Error : '.$ex->getMessage().'</b>';
            return false;
        }
    }
    
    public function test() {
        $this->autoRender = false;
        $url = "http://devweb.peachtel.net/admin/private_functions/test2";
        //$url = PS_SHOP_PATH.'/api/images/products/536';
        $image = "C:/Users/balt/Desktop/cred.txt";

        $postdata = array("image" => "@".$image);
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url);
        curl_setopt($ch2, CURLOPT_POST, true);
        //curl_setopt($ch2, CURLOPT_USERPWD, PS_WS_AUTH_KEY.':');
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch2);

        if(curl_errno($ch2)) {
            echo 'Error: ' . curl_error($ch2);
        }
        else {
            echo $result;
        }
        
        curl_close($ch2);
    }
    
    public function test2() {
        $this->autoRender = false;
        pr($_POST);
        pr($_FILES);
    }
    
    private function _callProductInsert($data) {
        /** 
         * Load Prestashop Library
         */
        $this->autoRender = false;
        
        app::import('Vendor', 'PSWebServiceLibrary');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
        $xml = $webService -> get(array('url' => PS_SHOP_PATH . '/api/products?schema=blank'));
        $resources = $xml -> children() -> children();
        /**
         *  Default Values 
         *  These fields are required
         */
        
        $n_link_rewrite = 'someone_rewrite';
        $n_avail4order = '1';
        $n_show_price ='1';
        $addRetailPrice = .14;
        
        /**
         * Unset fields that is not needed
         */
        unset($resources -> id);
        unset($resources -> position);
        unset($resources -> id_shop_default);
        unset($resources -> date_add);
        unset($resources -> date_upd);
        unset($resources->associations->combinations);
        unset($resources->associations->product_options_values);
        unset($resources->associations->product_features);
        unset($resources->associations->stock_availables->stock_available->id_product_attribute);

        /** 
         * Fields present in creating new product
         */
        $resources-> id_manufacturer = $data['manufacturer'];
        $resources-> id_supplier = '0';
        $resources-> id_category_default = $data['category'];
        $resources-> new = '0';
        $resources-> cache_default_attribute;
        $resources-> id_default_image = '';
        $resources-> id_default_combination = '0';
        $resources-> id_tax_rules_group ='1';
        $resources-> reference = $data['reference'];
        $resources-> supplier_reference;
        $resources-> location;
        $resources-> width;
        $resources-> height;
        $resources-> depth;
        $resources-> weight;
        $resources-> quantity_discount;
        $resources-> ean13;
        $resources-> upc = $data['upc'];
        $resources-> cache_is_pack;
        $resources-> cache_has_attachments;
        $resources-> is_virtual;
        $resources-> on_sale;
        $resources-> online_only;
        $resources-> ecotax;
        $resources-> minimal_quantity = 1;
        $resources-> price = $data['final_price'];
        $resources-> wholesale_price = $data['base_price'];
        $resources-> unity;
        $resources-> unit_price_ratio;
        $resources-> additional_shipping_cost;
        $resources-> customizable;
        $resources-> text_fields;
        $resources-> uploadable_files;
        $resources-> active = $data['active'];
        $resources-> available_for_order = $n_avail4order;
        $resources-> available_date;
        $resources-> condition = $data['condition'];
        $resources-> show_price = $n_show_price;
        $resources-> indexed = '0';
        $resources-> visibility = $data['visibility'];
        $resources-> advanced_stock_management='0';
        $resources-> date_add;
        $resources-> date_upd;
        $resources-> name = $data['name'];
        $resources-> description = $data['description'];
        $resources-> description_short = $data['description_short'];
        $resources-> associations-> categories-> category-> id = 2;

        $node = dom_import_simplexml($resources -> link_rewrite -> language[0][0]);
        $no = $node -> ownerDocument;
        $node -> appendChild($no -> createCDATASection($n_link_rewrite));
        
        try {
        	
            $opt = array('resource' => 'products');
            $opt['postXml'] = $xml -> asXML();
            $xml = $webService -> add($opt);
            
			$psID = $this->PsStockAvailable->find('first', array('conditions' => array('id_stock_available' => $webService->ps_id)));
			
			/** UPDATE STOCK DEFAULT TO 100 */
			$stock = array(
				'PsProduct' => array('id_product' => $psID['PsStockAvailable']['id_product'], 'quantity' => '100'),
				'PsStockAvailable' => array('id_stock_available' => $psID['PsStockAvailable']['id_stock_available'], 'quantity' => '100')
			);
			$this->PsProduct->saveAll($stock);
			
            /** BEGIN PRODUCT INSERT */
        	$url = PS_SHOP_PATH.'/api/images/products/'.$psID['PsStockAvailable']['id_product'];    
            $image = BASE_PATH.$data['image'];
            $postdata = array('image' => '@'.$image);
        	
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $url);
            curl_setopt($ch2, CURLOPT_POST, true);
            curl_setopt($ch2, CURLOPT_USERPWD, PS_WS_AUTH_KEY.':');
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch2);
            curl_close($ch2);
            /** END OF PRODUCT INSERT */
            
            //unlink($image);
            return true;
            
        } catch(PrestaShopWebserviceException $ex) {
            
            echo '<b>Error : '.$ex->getMessage().'</b>';
            return false;
        }
    }
}

?>
