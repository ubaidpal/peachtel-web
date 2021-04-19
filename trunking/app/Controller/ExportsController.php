<?php

App::uses('AppController', 'Controller');

class ExportsController extends AppController {
    public $name = "Exports";
    var $uses = array('Nextusa');
    var $layout = "admin_layout";
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        if($this->request->data) {
            $file = $this->request->data['Nextusa']['csv_file'];

		
			if (!in_array($file['type'], array('application/vnd.ms-excel', 'text/csv', 'application/octet-stream'))) {
				$this->Session->setFlash(__('Only CSV file format is allowed', true), 'error');
				$this->redirect(array('action' => 'import'));
			}
			
			App::import("Vendor","parsecsv/parsecsv");
			$csv = new parseCSV();
			$csv->headKey = false; //Use the normal array keys
			$csv->auto($file['tmp_name']);
            
            foreach($csv->data as $data) {
                
                $csvData[] = array(
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
            }
            
            
            if($this->Nextusa->saveAll($csvData)) {
                $this->Session->setFlash(_("Import CSV Success."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to save csv."));
                $this->redirect('index/');
            }
        }
            
    }
}

?>
