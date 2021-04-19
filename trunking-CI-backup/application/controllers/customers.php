<?php

class Customers extends CI_Controller {

    function index() {
        $data['customers'] = $this->customers_model->get_all_customers();
        //require_once 'fire.php';
        //fb($data, '$data');
        $this->load->view('customers_list', $data);
    }

    function customer_data($id = '') {
        if ($id == '') {
            if ($this->input->post('submit')) {
                $name = $this->input->post('name');
                $active = $this->input->post('active');
                require_once 'fire.php';
                fb($name, '$data');
                if ($this->input->post('iden')) {
                    $this->customers_model->update_customer($name, $active, $this->input->post('iden'));
                } else {
                    $this->customers_model->add_new_customer($name, $active);
                }
                redirect('customers/index');
            } else {
                $this->load->view('new_customer');
            }
        } else {
            $data['customer'] = $this->customers_model->get_customer($id);
            $this->load->view('new_customer', $data);
        }
    }

    function customer_bg($cid) {
        $data['bgs'] = $this->customers_model->get_customer_bg($cid);
        $data['cid'] = $cid;
        $this->load->view('customer_bg', $data);
    }

    function bg_data($cid, $bgid = '') {
        if ($bgid == '') {
            if ($this->input->post('submit')) {
                $data['customer_id'] = $this->input->post('customer_id');
                $data['descr'] = $this->input->post('descr');
                $data['ingress_dnis_strip_digits'] = $this->input->post('ingress_dnis_strip_digits');
                $data['ingress_dnis_prepend_prefix'] = $this->input->post('ingress_dnis_prepend_prefix');
                $data['channel_limit'] = $this->input->post('channel_limit');
                $data['ingress_ani_strip_digits'] = $this->input->post('ingress_ani_strip_digits');
                $data['ingress_ani_prepend_prefix'] = $this->input->post('ingress_ani_prepend_prefix');
                $data['notify_email'] = $this->input->post('notify_email');
                $data['vendor_term_group_id'] = $this->input->post('vendor_term_group_id');
                $data['term_rate_plan_id'] = $this->input->post('term_rate_plan_id');
                $data['proxy_media'] = $this->input->post('proxy_media');
                if ($this->input->post('id')) {
                    $data['id'] = $this->input->post('id');
                    $this->customers_model->update_bg($data);
                } else {
                    $this->customers_model->add_new_bg($data);
                }
                redirect('customers/customer_bg/' . $cid);
            } else {
                $data['cid'] = $cid;
                $this->load->view('billing_group_data', $data);
            }
        } else {
            $data['bgs'] = $this->customers_model->get_bg($bgid);
            $data['cid'] = $cid;
            $this->load->view('billing_group_data', $data);
        }
    }

}
