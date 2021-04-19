<?php

App::uses('AppController', 'Controller');

class RegionsController extends AppController {
    public $name = "Regions";
    var $uses = array('Region', 'RegionCode', 'RegionGroup');
    var $layout = "admin_layout";
    
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $regionGroups = $this->RegionGroup->find('all');
        
        $this->set(compact('regionGroups'));
    }
    
    public function add() {
        if($this->request->data) {
            if($this->RegionGroup->save($this->request->data)) {
                $this->Session->setFlash(_("Region group successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add region group."));
                $this->redirect('index');
            }
        }
    }
    
    public function edit($reg_group_id) {
        if($this->request->data) {
            $this->RegionGroup->id = $reg_group_id;
            if($this->RegionGroup->save($this->request->data)) {
                $this->Session->setFlash(_("Region group successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index');
            }
        }
        $regionGroup = $this->RegionGroup->findById($reg_group_id);
        $this->set(compact('regionGroup', 'reg_group_id'));
    }
    
    
    public function delete($id) {
        if($this->RegionGroup->delete($id)) {
            $this->Session->setFlash(_("Region Group successfully removed."));
            $this->redirect('index');
        } else {
            $this->Session->setFlash(_("Failed to delete Region group."));
            $this->redirect('index');
        }
    }
    
    public function region($reg_group_id) {
        $regions = $this->Region->findAllByRegionGroupId($reg_group_id);
        
        $this->set(compact('regions', 'reg_group_id'));
    }
    
    public function add_region($reg_group_id) {
        if($this->request->data) {
            if($this->Region->save($this->request->data)) {
                $this->Session->setFlash(_("Region successfully removed."));
                $this->redirect('region/'.$reg_group_id);
            } else {
                $this->Session->setFlash(_("Failed to delete Region."));
                $this->redirect('region/'.$reg_group_id);
            }
        }
        $this->set(compact('reg_group_id'));
    }
    
    public function edit_region($reg_id) {
        $region = $this->Region->findById($reg_id);
        if($this->request->data) {
            $this->Region->id = $reg_id;
            if($this->Region->save($this->request->data)) {
                $this->Session->setFlash(_("Region successfully added."));
                $this->redirect('region/'.$region['Region']['region_group_id']);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('region/'.$region['Region']['region_group_id']);
            }
        }
        $reg_group_id = $region['Region']['region_group_id'];
        $this->set(compact('region', 'reg_group_id'));
    }
    
    public function delete_region($reg_id) {
        if($this->Region->delete($reg_id)) {
            $this->Session->setFlash(_("Region successfully removed."));
        } else {
            $this->Session->setFlash(_("Failed to delete Region."));
        }
    }
    
    public function region_code($reg_id) {
        $regionCodes = $this->RegionCode->findAllByRegionId($reg_id);
        
        $this->set(compact('regionCodes', 'reg_id'));
    }
    
    public function add_region_code($reg_id) {
        if($this->request->data) {
            if($this->RegionCode->save($this->request->data)) {
                $this->Session->setFlash(_("Region code added."));
                $this->redirect('region_code/'.$reg_id);
            } else {
                $this->Session->setFlash(_("Failed to add Region code."));
                $this->redirect('region_code/'.$reg_id);
            }
        }
        $this->set(compact('reg_id'));
    }
    
    public function delete_region_code($prefix) {
        $regionCode = $this->RegionCode->findByPrefix($reg_id);
        $conditions = array('RegionCode.prefix' => $prefix);
        if($this->RegionCode->delete($conditions)) {
            $this->Session->setFlash(_("Region Code successfully removed."));
            $this->redirect('region_code/'.$regionCode['RegionCode']['region_id']);
        } else {
            $this->Session->setFlash(_("Failed to delete Region Code."));
            $this->redirect('region_code/'.$regionCode['RegionCode']['region_id']);
        }
    }
}

?>
