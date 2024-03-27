<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{
    public $role, $user, $brand;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form', 'html');
        $this->load->library('Excelfile', 'form_validation');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }

    public function pm_settings()
    {
        $check = $this->admin_model->checkPermission($this->role, 235);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 235);
            $data['brand'] = $this->brand;
            $dd = $this->db->get_where('pm_setup', array('brand' => $this->brand))->row();

            if (!$this->db->get_where('pm_setup', array('brand' => $this->brand))->row()) {
                $data1['brand'] = $this->brand;
                $this->db->insert('pm_setup', $data1);
            }
            $data['pmConfig'] = $this->db->get_where('pm_setup', array('brand' => $this->brand))->row();

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('erp_setting/pm_setting');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function savePmConfig()
    {
        $id = $this->input->post('id');
        $data['qmemail'] = ($this->input->post('qmemail') ? $this->input->post('qmemail') : '');
        $data['qmemailsub'] = ($this->input->post('qmemailsub') ? $this->input->post('qmemailsub') : '');
        $data['qmemaildesc'] = ($this->input->post('qmemaildesc') ? $this->input->post('qmemaildesc') : '');
        $data['block_v_no'] = ($this->input->post('block_v_no') ? $this->input->post('block_v_no') : 0);
        $data['cuemailsub'] = ($this->input->post('cuemailsub') ? $this->input->post('cuemailsub') : '');
        $data['cuemaildesc'] = ($this->input->post('cuemaildesc') ? $this->input->post('cuemaildesc') : '');
        $data['min_profit_percentage'] = ($this->input->post('min_profit_percentage') ? $this->input->post('min_profit_percentage') : '');
        // var_dump($this->input->post('qmemail'));
        // die;
        for ($i = 1; $i <= 6; $i++) {
            $data['pm_ev_name' . $i] = ($this->input->post('pm_ev_name' . $i) ? $this->input->post('pm_ev_name' . $i) : '');
            $data['pm_ev_per' . $i] = ($this->input->post('pm_ev_per' . $i) ? $this->input->post('pm_ev_per' . $i) : 0);
            $data['v_ev_name' . $i] = ($this->input->post('v_ev_name' . $i) ? $this->input->post('v_ev_name' . $i) : '');
            $data['v_ev_per' . $i] = ($this->input->post('v_ev_per' . $i) ? $this->input->post('v_ev_per' . $i) : 0);
            $data['c_ev_name' . $i] = ($this->input->post('c_ev_name' . $i) ? $this->input->post('c_ev_name' . $i) : '');
            $data['c_ev_per' . $i] = ($this->input->post('c_ev_per' . $i) ? $this->input->post('c_ev_per' . $i) : 0);
        }

        $row_num = $this->db->get_where('pm_setup', ['brand' => $this->brand])->num_rows();
        if ($row_num == 0) {
            $data['brand'] = $this->brand;
            if ($this->db->insert('pm_setup', $data)) {
                $true = "Projects Management Settings Update Successfully  ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Update Projects Management Settings ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            $this->db->where('id', $id);
            if ($this->db->update('pm_setup', $data)) {
                $true = "Projects Management Settings Update Successfully  ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Update Projects Management Settings ...";
                $this->session->set_flashdata('error', $error);
            }
        }
        redirect(base_url() . "settings/pm_settings");
    }
    
    // vm settings
    public function vm_settings()
    {
        $check = $this->admin_model->checkPermission($this->role, 249);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 249);
            $data['brand'] = $this->brand;
          
            $data['vmConfig'] = $this->db->get('vm_setup')->row();

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('erp_setting/vm_setting');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function saveVmConfig()
    {
        $id = $this->input->post('id');
        $data['unaccepted_offers_email'] = ($this->input->post('unaccepted_offers_email') ? $this->input->post('unaccepted_offers_email') : '');
        $data['acceptance_offers_hours'] = ($this->input->post('acceptance_offers_hours') ? $this->input->post('acceptance_offers_hours') : '');
      
            $this->db->where('id', $id);
            if ($this->db->update('vm_setup', $data)) {
                $true = "Vendor Management Settings Update Successfully  ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Update Vendor Management Settings ...";
                $this->session->set_flashdata('error', $error);
            }
        
        redirect(base_url() . "settings/vm_settings");
    }
}
