<?php

class Customers_model extends CI_Model {
    
    function get_all_customers(){
        $this->db->select('*');
        $this->db->from('customer');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function get_customer($id){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function add_new_customer($name,$active){
        $data['descr'] = $name;
        $data['active'] = $active;
        $this->db->insert('customer', $data);
    }
    
    function update_customer($name, $active,$id) {
        $data['descr'] = $name;
        $data['active'] = $active;
        $this->db->where('id',$id);
        $this->db->update('customer', $data);
    }
    
    function get_customer_bg($cid){
        $this->db->select('*');
        $this->db->from('customer_bg');
        $this->db->where('customer_id',$cid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function get_bg($bgid){
        $this->db->select('*');
        $this->db->from('customer_bg');
        $this->db->where('id',$bgid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function update_bg($data){
        $this->db->where('id',$data['id']);
        $this->db->update('customer_bg', $data);
    }
    
    function add_new_bg($data){
        $this->db->insert('customer_bg', $data);
    }
}
