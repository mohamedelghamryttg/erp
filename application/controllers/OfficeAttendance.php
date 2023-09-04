<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OfficeAttendance extends CI_Controller {
    var $role,$user,$brand;

    public function attendance(){
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,210);
        
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,210);
            //body ..
            $data['users'] = $this->db->get('users');
            //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('officeAttendance/officeAttendance.php');
            $this->load->view('includes/footer.php'); 
 
    }

    }?>