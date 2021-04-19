<?php

App::uses('AppController', 'Controller');

class PackagesController extends AppController {
    public $name = "Packages";
    var $uses = array('Package', 'PackageTermCode', 'PackageTermCodeGroup');
    var $layout = "admin_layout";
    
    public function beforeFilter() {
        parent::beforeFilter();
        
    }
    
    public function index() {
        $pkgTermCodeGroups = $this->PackageTermCodeGroup->find('all');
        
        $this->set(compact('pkgTermCodeGroups'));
    }
    
    public function add() {
        if($this->request->data) {
            if($this->PackageTermCodeGroup->save($this->request->data)) {
                $this->Session->setFlash(_("Package group successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to add package group."));
                $this->redirect('index');
            }
        }
    }
    
    public function edit($pkg_group_id) {
        if($this->request->data) {
            $this->PackageTermCodeGroup->id = $pkg_group_id;
            if($this->PackageTermCodeGroup->save($this->request->data)) {
                $this->Session->setFlash(_("Package group successfully added."));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('index');
            }
        }
        $pkgTermCodeGroup = $this->PackageTermCodeGroup->findById($pkg_group_id);
        $this->set(compact('pkgTermCodeGroup', 'pkg_group_id'));
    }
    
    public function delete($id) {
        if($this->PackageTermCodeGroup->delete($id)) {
            $this->Session->setFlash(_("Package group successfully removed."));
            $this->redirect('index');
        } else {
            $this->Session->setFlash(_("Failed to delete Package  group."));
            $this->redirect('index');
        }
    }
    
    public function package($pkg_group_id) {
        $packages = $this->Package->findAllByPkgTermCodeGroupId($pkg_group_id);
        
        $this->set(compact('packages', 'pkg_group_id'));
    }
    
    public function add_package($pkg_group_id) {
        if($this->request->data) {
            if($this->Package->save($this->request->data)) {
                $this->Session->setFlash(_("Package successfully added."));
                $this->redirect('package/'.$pkg_group_id);
            } else {
                $this->Session->setFlash(_("Failed to add package."));
                $this->redirect('package/'.$pkg_group_id);
            }
        }
        $this->set(compact('pkg_group_id'));

    }
    
    public function edit_package($pkg_id) {
        if($this->request->data) {
            $this->Package->id = $pkg_id;
            if($this->Package->save($this->request->data)) {
                $this->Session->setFlash(_("Package successfully saved."));
                $this->redirect('package/'.$pkg_id);
            } else {
                $this->Session->setFlash(_("Failed to save changes."));
                $this->redirect('package/'.$pkg_id);
            }
        }
        $package = $this->Package->findById($pkg_id);
        $pkg_group_id = $package['Package']['pkg_term_code_group_id'];
        $this->set(compact('package', 'pkg_id', 'pkg_group_id'));

    }
    
    public function delete_package($id) {
        if($this->Package->delete($id)) {
            $this->Session->setFlash(_("Package successfully removed."));
            $this->redirect('package/'.$id);
        } else {
            $this->Session->setFlash(_("Failed to delete Package."));
            $this->redirect('package/'.$id);
        }
    }
    
    public function package_term_code($pkg_group_id) {
        $pkgTermCode = $this->PackageTermCode->findByPkgTermCodeGroupId($pkg_group_id);
        if($this->request->data) {
            $this->PackageTermCode->id = $pkg_group_id;
            if($this->PackageTermCode->save($this->request->data)) {
                $this->Session->setFlash(_("Package Term Code successfully saved."));
                $this->redirect('package_term_code/'.$pkg_group_id);
            } else {
                $this->Session->setFlash(_("Failed to delete Package Term Code."));
                $this->redirect('package_term_code/'.$pkg_group_id);
            }
        }
        
        $this->set(compact('pkgTermCode', 'pkg_group_id'));
    }
   
}

?>
