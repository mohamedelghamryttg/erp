<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class It extends CI_Controller {

    var $role, $user, $brand;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
        $this->ticket_type = array("Service Request","Change Request","Incident");
        $this->load->model('automation_model');
    }

    public function tickets() {
         $check = $this->admin_model->checkPermission($this->role, 202);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 202);
            $data['emp_id'] = $this->emp_id;           
            
        if (isset($_GET['search'])) {
                $arr2 = array();                 
                
                if (isset($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2,0);
                        $data['month'] = $month;
                    }
                } else {
                    $month = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 1);
                        $data['employee_name'] = $employee_name;
                    }
                } else {
                    $data['employee_name'] = $employee_name = "";
                }
                $idsArray = Array();
                $empIds ="";
                if (isset($_REQUEST['department'])) {
                    $department = $_REQUEST['department'];                   
                    if (!empty($department)) {
                        array_push($arr2, 2);  
                        $data['department'] = $department;
                        $ids =  $this->db->select('id')->get_where('employees',array('department' => $department))->result();
                           if (!empty($ids)) {
                               foreach ($ids as $val)                           
                                 array_push($idsArray,$val->id);  
                            $empIds = implode(" , ", $idsArray);
                            }else{
                               $empIds ="0"; 
                            }
                    }
                }else {
                    $data['department']= $department = "";                     
                } 
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2,3);
                        $data['type'] = $type;
                    }
                } else {
                    $type = "";
                }
                $cond1 = "date_format(created_at, '%m') LIKE '%$month%'";               
                $cond2 = "emp_id = '$employee_name'";                
                $cond3 = "emp_id IN ($empIds)";
                $cond4 = "ticket_type = '$type'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['tickets'] = $this->automation_model->AllTickets_IT($data['permission'],$arr4);
                } else {
                    $data['tickets'] = $this->automation_model->AllTicketPages_IT($data['permission'],9, 0);
                }
                $data['total_rows'] = $data['tickets']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->automation_model->AllTickets_IT($data['permission'],1)->num_rows();
                $config['base_url'] = base_url('it/tickets');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['tickets'] = $this->automation_model->AllTicketPages_IT($data['permission'],$limit, $offset);                             
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('it/allTickets.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    
    public function addTicket() {       
         // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 202);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
           
            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('it/addTicket.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    
    public function saveTicket() {               
            
            $data['emp_id'] = $this->emp_id;           
            $data['subject'] = $_POST['subject'];
            $data['body'] = $_POST['body'];           
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");            
            $data['from_email'] = $this->db->get_where('users',array('id'=>$this->user))->row()->email;
           
            foreach($_POST['cc_email'] as $k =>$email){
                $email_array[] = $email;
            }
            $data['cc_email'] = implode("; ",$email_array);
            $mailSubject = "Falaq System - ".$data['subject'];
            $mailBody = $data['body'];
            
            
            if($this->db->insert('it_tickets',$data)){
            	$this->automation_model->sendITTicketMail($mailSubject,$mailBody,$email_array);
                $true = "Ticket Send Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."it/tickets");
            }else{
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
    }

    public function viewTicket($id) {
         // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 202);
        $ticket = $this->db->get_where('it_tickets',array('id'=>$id))->row();
        if ($data['permission']->view == 1 || $ticket->emp_id ==  $this->emp_id) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..            
            $data['emp_id'] = $this->emp_id;
            $data['role'] = $this->role;
            $data['ticket'] = $ticket = $this->db->get_where('it_tickets',array('id'=>$id))->row();
           
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('it/viewTicket.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    
}
