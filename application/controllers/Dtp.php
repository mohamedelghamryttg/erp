<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dtp extends CI_Controller {
    var $role,$user;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
      	$this->brand = $this->session->userdata('brand');
    }

    public function index(){
        $check = $this->admin_model->checkPermission($this->role,111);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,111);
            //body ..
            $data['newTasks'] = $this->projects_model->newDtpTasks($this->brand);
            $data['tasksPlan'] = $this->projects_model->DtpRequestsPlan($this->brand);
            if(isset($_GET['search'])){
                $arr2 = array();
                if(isset($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                    if(!empty($code)){ array_push($arr2,0); }
                }else{
                    $code = "";
                }

                if(isset($_REQUEST['pm'])){
                    $pm = $_REQUEST['pm'];
                    if(!empty($pm)){ array_push($arr2,1); }
                }else{
                    $pm = "";
                }

                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,2); }
                }else{
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'"; ;                      
                $cond2 = "created_by = '$pm'";      
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $arr1 = array($cond1,$cond2,$cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['dtp_request'] = $this->projects_model->AllDTPTasks($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['dtp_request'] = $this->projects_model->AllDTPTasksPages($data['permission'],$this->user,$this->brand,9,0);
                }
                $data['total_rows'] = $data['dtp_request']->num_rows();
            }else{
                $limit = 50;
                $offset = $this->uri->segment(3);
                if($this->uri->segment(3) != NULL)
                {
                    $offset = $this->uri->segment(3);
                }else{
                    $offset = 0;
                }
                  $count = $this->projects_model->AllDTPTasks($data['permission'],$this->user,$this->brand,$this->brand,1)->num_rows();
                  $config['base_url']= base_url('dtp/index');
                  $config['uri_segment'] = 3;
                  $config['display_pages']= TRUE;
                  $config['per_page']  = $limit;
                  $config['total_rows'] = $count;
                  $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                  $config['full_tag_close'] ="</ul>";
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
                
                $data['dtp_request'] = $this->projects_model->AllDTPTasksPages($data['permission'],$this->user,$this->brand,$limit,$offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/dtpRequest.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
    public function exportRequests(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP Requests.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,111);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,111);
            //body ..
            $data['newTasks'] = $this->projects_model->newDtpTasks($this->brand);
            
                $arr2 = array();
                if(isset($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                    if(!empty($code)){ array_push($arr2,0); }
                }else{
                    $code = "";
                }

                if(isset($_REQUEST['pm'])){
                    $pm = $_REQUEST['pm'];
                    if(!empty($pm)){ array_push($arr2,1); }
                }else{
                    $pm = "";
                }

                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,2); }
                }else{
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";                   
                $cond2 = "created_by = '$pm'";           
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $arr1 = array($cond1,$cond2,$cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['dtp_request'] = $this->projects_model->AllDTPTasks($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['dtp_request'] = $this->projects_model->AllDTPTasksPages($data['permission'],$this->user,$this->brand,9,0);
                }
                
            // //Pages ..
            
            $this->load->view('dtp/exportRequests.php',$data);
            
        }else{
            echo "You have no permission to access this page";
        }
    }
    public function saveRequest(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,111);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('dtp/saveRequest.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doSaveRequest(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,111);
        if($permission->add == 1){
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = $data['status'] = $_POST['status'];
            $comment="";
            // echo "Reject";
            if($data['status'] == 5 || $data['status'] == 0){
                $comment = $history['comment'] = $data['reject_reason'] = $_POST['reason'];  
            }
            $history['created_by'] = $data['status_by'] = $this->user;
            $history['created_at'] = $data['status_at'] = date("Y-m-d H:i:s");
            if($this->db->insert('dtp_history',$history)){
                $this->db->update('dtp_request',$data,array('id' => $taskId));
            	$this->projects_model->sendDTPRequestStatusMail($taskId,$data,$comment);
                $this->admin_model->addToLoggerUpdate('dtp_request',111,'id',$taskId,0,0,$this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."dtp");
            }else{
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."dtp");
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function dtpJobs(){
        $check = $this->admin_model->checkPermission($this->role,112);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,112);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('dtp_request_job',array('request_id'=>$taskId));
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/dtpJobs.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function addJob(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,112);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/addJob.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doAddJob(){
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,112);
        if($permission->add == 1){
            $data['request_id'] = base64_decode($_POST['request_id']);
            $data['dtp'] = $_POST['dtp'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['source_direction'] = $_POST['source_direction'];
            $data['target_direction'] = $_POST['target_direction'];
            $data['source_application'] = $_POST['source_application'];
            $data['target_application'] = $_POST['target_application'];
            $data['translation_in'] = $_POST['translation_in'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $mailSubject = "New Job Assignment: ".date("Y-m-d H:i:s");
            $mailBody = "You have assigned to a new job please check.";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                // $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 10000;
                $config['file']['max_width']            = 1024;
                $config['file']['max_height']           = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);             
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            
            if($this->db->insert('dtp_request_job',$data)){
            	$this->projects_model->sendJobAssignment($data['dtp'],$mailSubject,$mailBody);
                $true = "Job Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);
            }else{
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function editJob(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,112);
        if($data['permission']->edit == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $jobId = base64_decode($_GET['j']);
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('dtp_request_job',array('id'=>$jobId))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/editJob.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doEditJob(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,112);
        if($permission->edit == 1){
            $id = base64_decode($_POST['id']);
            $data['dtp'] = $_POST['dtp'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['source_direction'] = $_POST['source_direction'];
            $data['target_direction'] = $_POST['target_direction'];
            $data['source_application'] = $_POST['source_application'];
            $data['target_application'] = $_POST['target_application'];
            $data['translation_in'] = $_POST['translation_in'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 0;
            $mailSubject = "New Update At the Assignment: ".date("Y-m-d H:i:s");
            $mailBody = "You have a new update at the assignment please check it.";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                // $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 10000;
                $config['file']['max_width']            = 1024;
                $config['file']['max_height']           = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);             
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            
            if($this->db->update('dtp_request_job',$data,array('id'=>$id))){
                $this->projects_model->sendJobAssignment($data['dtp'],$mailSubject,$mailBody);
                $true = "Job Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);
            }else{
                $error = "Failed To Edit Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function dtpTasks(){
        $check = $this->admin_model->checkPermission($this->role,113);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,113);
            //body ..
            if(isset($_GET['search'])){
                $arr2 = array();
                if(isset($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                    if(!empty($code)){ array_push($arr2,0); }
                }else{
                    $code = "";
                }
                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,1); }
                }else{
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";            
                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $arr1 = array($cond1,$cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['job'] = $this->projects_model->AllDTPJobsPages($data['permission'],$this->user,$this->brand,9,0);
                }
                $data['total_rows'] = $data['job']->num_rows();
            }else{
                $limit = 9;
                $offset = $this->uri->segment(3);
                if($this->uri->segment(3) != NULL)
                {
                    $offset = $this->uri->segment(3);
                }else{
                    $offset = 0;
                }
                $count = $this->projects_model->AllDTPJobs($data['permission'],$this->user,$this->brand,$this->brand,1)->num_rows();
                $config['base_url']= base_url('dtp/dtpTasks');
                $config['uri_segment'] = 3;
                $config['display_pages']= TRUE;
                $config['per_page']  = $limit;
                $config['total_rows'] = $count;
              $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
              $config['full_tag_close'] ="</ul>";
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
            
                
                $data['job'] = $this->projects_model->AllDTPJobsPages($data['permission'],$this->user,$this->brand,$limit,$offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/dtpTasks.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
    public function exportTasks(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP Tasks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,113);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,113);
            //body ..
            
                $arr2 = array();
                if(isset($_REQUEST['code'])){
                    $code = $_REQUEST['code'];
                    if(!empty($code)){ array_push($arr2,0); }
                }else{
                    $code = "";
                }
                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,1); }
                }else{
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";            
                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $arr1 = array($cond1,$cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['job'] = $this->projects_model->AllDTPJobsPages($data['permission'],$this->user,$this->brand,9,0);
                }
                
            // //Pages ..
            
            $this->load->view('dtp/exportTasks.php',$data);
           
        }else{
            echo "You have no permission to access this page";
        }
    }
    public function viewDTPTask(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $jobId = base64_decode($_GET['t']);
            $data['job'] = $this->db->get_where('dtp_request_job',array('id'=>$jobId))->row();
            $data['response'] = $this->db->get_where('dtp_request_response',array('task'=>$jobId))->result();
            $data['history'] = $this->db->get_where('dtp_request_history',array('task'=>$jobId))->result();
            $data['request'] = $this->db->get_where('dtp_request',array('id'=>$data['job']->request_id))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/viewDtpTask.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function jobAction(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['action'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if($this->db->insert('dtp_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('dtp_request_job',113,'id',$data['task'],0,0,$this->user);
                $this->db->update('dtp_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
            	$this->projects_model->sendDTPJobStatusMail($data['task'],$data);
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function closeDtpJob(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['taken_time'] =  $this->projects_model->returnDTPTakenTime($data['task'],$data['created_at']);
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                // $config['file']['upload_path']          = './assets/uploads/dtpJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);            
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if($this->db->insert('dtp_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('dtp_request_job',113,'id',$data['task'],0,0,$this->user);
                $this->db->update('dtp_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
            	$this->projects_model->sendDTPJobStatusMail($data['task'],$data);
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function requestRespone(){
        $data['request'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
         $flag = $_POST['flag'];
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        if(strlen(trim($data['response'])) > 0){
            if($this->db->insert('dtp_response',$data)){
               $this->projects_model->sendDtpCommentByMail($data['request'],$data['response'],$flag);
                $true = "Task Reply Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Add Task Reply ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }              
        }else{
            $error = "Failed To Add Task Reply ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function viewRequest(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['response'] = $this->db->get_where('dtp_response',array('request'=>$taskId))->result();
            $data['history'] = $this->db->get_where('dtp_history',array('request'=>$taskId))->result();
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('dtp_new/viewRequest.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function closeDtpRequest(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($permission->add == 1){
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            $file="";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/dtpRequest/';
                // $config['file']['upload_path']          = './assets/uploads/dtpRequest/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);           
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $file = $data['file'] = $data_file['file_name'];
                }
            }

            if($this->db->insert('dtp_history',$data)){
                $this->admin_model->addToLoggerUpdate('dtp_request',113,'id',$data['request'],0,0,$this->user);
                $this->db->update('dtp_request',array('status'=>$data['status']),array('id'=>$data['request']));
            	$this->projects_model->sendDTPRequestStatusMail($data['request'],$data,$data['comment'],$file);
                // for check order tasks 
                $taskData = $this->db->get_where('dtp_request',array('id' => $data['request']))->row();
                $this->projects_model->CheckCloseRelatedTasks($taskData->job_id,$data['request'],"DTP");
                //end order tasks check
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function reopenJob(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = 1;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/DTPJob/';
                // $config['file']['upload_path']          = './assets/uploads/DTPJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."dtp/dtpJobs?t=".$_POST['request_id']);             
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if($this->db->insert('dtp_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('dtp_request_job',113,'id',$data['task'],0,0,$this->user);
                $this->db->update('dtp_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function updateFinalCount(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,113);
        if($permission->add == 1){
            $task = base64_decode($_POST['id']);
            $data['updated_count'] = $_POST['updated_count'];
            $data['updated_by'] = $this->user;
            $data['updated_date'] = date("Y-m-d H:i:s");
            
            $this->admin_model->addToLoggerUpdate('dtp_request_job',113,'id',$task,0,0,$this->user);
            if($this->db->update('dtp_request_job',$data,array('id'=>$task))){
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    // public function ticketRespone(){
    //     $data['task'] = base64_decode($_POST['id']);
    //     $data['response'] = trim($_POST['comment']);
    //     $data['created_by'] = $this->user;
    //     $data['created_at'] = date("Y-m-d H:i:s");
    //     if(strlen(trim($data['response'])) > 0){
    //         if($this->db->insert('dtp_request_response',$data)){
    //             $true = "Task Reply Added Successfully ...";
    //             $this->session->set_flashdata('true', $true);
    //             redirect($_SERVER['HTTP_REFERER']);
    //         }else{
    //             $error = "Failed To Add Task Reply ...";
    //             $this->session->set_flashdata('error', $error);
    //             redirect($_SERVER['HTTP_REFERER']);
    //         }              
    //     }else{
    //         $error = "Failed To Add Task Reply ...";
    //         $this->session->set_flashdata('error', $error);
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }
    // }

    // public function closeDTPTask(){
    //     $data['task'] = base64_decode($_POST['id']);
    //     $data['file'] = $_POST['file'];
    //     $data['comment'] = $_POST['comment'];
    //     $data['status'] = 4;
    //     $data['created_by'] = $this->user;
    //     $data['created_at'] = date("Y-m-d H:i:s");
    //     $data['taken_time'] =  $this->projects_model->returnDTPTakenTime($data['task'],$data['created_at']);

    //     if($this->db->insert('dtp_request_history',$data)){
    //         $this->db->update('dtp_request',array('status'=>4),array('id'=>$data['task']));
    //         $true = "Task Closed Successfully ...";
    //         $this->session->set_flashdata('true', $true);
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }else{
    //         $error = "Failed To Close The Task ...";
    //         $this->session->set_flashdata('error', $error);
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }

    // }

    // public function actionPmDTPTask(){
    //     $data['task'] = base64_decode($_POST['id']);
    //     $data['comment'] = trim($_POST['comment']);
    //     $data['status'] = $_POST['status'];
    //     $data['created_by'] = $this->user;
    //     $data['created_at'] = date("Y-m-d H:i:s");
        
    //     if(strlen(trim($data['comment'])) <= 0 && $data['status'] == 2){
    //         $error = "Failed To Re-open The Task, Please leave a comment! ...";
    //         $this->session->set_flashdata('error', $error);
    //         redirect($_SERVER['HTTP_REFERER']);  
    //     }else{
    //         if($this->db->insert('dtp_request_history',$data)){
    //             $this->db->update('dtp_request',array('status'=>$data['status']),array('id'=>$data['task']));
    //             $true = "Task Status Changed Successfully ...";
    //             $this->session->set_flashdata('true', $true);
    //             redirect($_SERVER['HTTP_REFERER']);
    //         }else{
    //             $error = "Failed To Change The Task Status ...";
    //             $this->session->set_flashdata('error', $error);
    //             redirect($_SERVER['HTTP_REFERER']);
    //         }
    //     }
    // }

    // public function calculateTime(){
    //     $started = strtotime("2019-03-11 13:42:20");
    //     $stoped = strtotime("2019-03-12 13:00:23");

    //     $taken = $stoped - $started;
    //     echo $taken / (60 * 60);
    // }

    public function getDTPRate(){
        $target_direction = $_POST['target_direction'];
        $source_application = $_POST['source_application'];
        $translation_in = $_POST['translation_in'];
        echo $data = $this->projects_model->getDTPRate($target_direction,$source_application,$translation_in);
    }


    public function dtpReport(){

    $check = $this->admin_model->checkPermission($this->role,129);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,129);
            //body ..

                if(isset($_GET['search'])){
                    $arr2 = array();
                    if(isset($_REQUEST['code'])){
                        $code = $_REQUEST['code'];
                        if(!empty($code)){ array_push($arr2,0); }
                    }else{
                        $code = "";
                    }
                    if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                        $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                        $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                        if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,1); }
                    }else{
                        $date_to = "";
                        $date_from = "";
                    }
                    if(isset($_REQUEST['dtp'])){
                        $dtp = $_REQUEST['dtp'];
                        if(!empty($dtp)){ array_push($arr2,2); }
                    }else{
                        $dtp = "";
                    }
                    // print_r($arr2);
                    $cond1 = "id = '$code'";            
                    $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                    $cond3 = "dtp = '$dtp'";            
                    $arr1 = array($cond1,$cond2,$cond3);
                    $arr_1_cnt = count($arr2);
                    $arr3 = array();
                    for($i=0; $i<$arr_1_cnt; $i++ ){
                    array_push($arr3,$arr1[$arr2[$i]]);
                    }
                    $arr4 = implode(" and ",$arr3);
                    // print_r($arr4);     
                    if($arr_1_cnt > 0){
                        $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,$this->brand,$arr4);
                    }else{
                         $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,0,1);
                    }
                }else{
                     $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,0,1);
                }
            // //Pages ..
                
            $this->load->view('includes/header.php',$data);
            $this->load->view('dtp/dtpReport.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }


    }

	public function exportDTPJobs(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP Jobs.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,129);
        if($check){

            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,129);
            //body ..
                    $arr2 = array();
                    if(isset($_REQUEST['code'])){
                        $code = $_REQUEST['code'];
                        if(!empty($code)){ array_push($arr2,0); }
                    }else{
                        $code = "";
                    }
                    if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                        $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                        $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                        if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,1); }
                    }else{
                        $date_to = "";
                        $date_from = "";
                    }
                    if(isset($_REQUEST['dtp'])){
                        $dtp = $_REQUEST['dtp'];
                        if(!empty($dtp)){ array_push($arr2,2); }
                    }else{
                        $dtp = "";
                    }
                    // print_r($arr2);
                    $cond1 = "id = '$code'";            
                    $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                    $cond3 = "dtp = '$dtp'";            
                    $arr1 = array($cond1,$cond2,$cond3);
                    $arr_1_cnt = count($arr2);
                    $arr3 = array();
                    for($i=0; $i<$arr_1_cnt; $i++ ){
                    array_push($arr3,$arr1[$arr2[$i]]);
                    }
                    $arr4 = implode(" and ",$arr3);
                    // print_r($arr4);     
                    if($arr_1_cnt > 0){
                        $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,$this->brand,$arr4);
                    }else{
                         $data['job'] = $this->projects_model->AllDTPJobs($data['permission'],$this->user,0,1);
                    }

            // //Pages ..
            $this->load->view('dtp/exportDTPJobs.php',$data);
        }else{
            echo "You have no permission to access this page";
        }
    }

    ///////dtp freelance 
    public function dtpFreelance(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,147);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $task_type = $this->db->query(" SELECT GROUP_CONCAT(id SEPARATOR ',') AS id FROM task_type WHERE parent = '23' ")->row()->id;
            if(isset($_POST['search'])){
                $arr2 = array();
                if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,0); }
                }else{
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['row'] = $this->projects_model->AllDTPFreeLance($task_type,$this->brand,$arr4);
                }else{
                    $data['row'] = $this->projects_model->AllDTPFreeLancePages($task_type,$this->brand,9,0);
                }
                $data['total_rows'] = $data['row']->num_rows();
            }else{
                $limit = 9;
                $offset = $this->uri->segment(3);
                if($this->uri->segment(3) != NULL)
                {
                    $offset = $this->uri->segment(3);
                }else{
                    $offset = 0;
                }
                $count = $this->projects_model->AllDTPFreeLance($task_type,$this->brand,$this->brand,1)->num_rows();
                $config['base_url']= base_url('dtp/dtpFreelance');
                $config['uri_segment'] = 3;
                $config['display_pages']= TRUE;
                $config['per_page']  = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] ="</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);
                
                $data['row'] = $this->projects_model->AllDTPFreeLancePages($task_type,$this->brand,$limit,$offset);
                $data['total_rows'] = $count;
            }
        	/*if(isset($_POST['search'])){
                if(isset($_POST['date_from']) && isset($_POST['date_to'])){
                    $date_from = date("Y-m-d",strtotime($_POST['date_from']));
                    $date_to = date("Y-m-d",strtotime($_POST['date_to']));
                   // $data['row'] = $this->db->query("SELECT * FROM `job_task` WHERE created_at >= '$date_from' AND created_at <= '$date_to'");
                  $data['row'] = $this->db->query("SELECT * FROM `job_task` WHERE task_type IN ('$task_type') AND created_at BETWEEN '$date_from' AND '$date_to'");
                }    
            }else{
                $data['row'] = $this->db->query("SELECT * FROM `job_task` WHERE task_type IN ('$task_type')");
             }*/
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('dtp/dtpFreelance.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
         ////////////
    public function exportDtpFreelance(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP Tasks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
       $check= $this->admin_model->getScreenByPermissionByRole($this->role,147);
       if($check){
        //header ..
           $data['group'] = $this->admin_model->getGroupByRole($this->role);
           //body ..
           $task_type = $this->db->query(" SELECT GROUP_CONCAT(id SEPARATOR ',') AS id FROM task_type WHERE parent = '23' ")->row()->id;
               $arr2 = array();
               if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                   $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                   $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                   if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,0); }
               }else{
                   $date_to = "";
                   $date_from = "";
               }
               // print_r($arr2);
               $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
               $arr1 = array($cond1);
               $arr_1_cnt = count($arr2);
               $arr3 = array();
               for($i=0; $i<$arr_1_cnt; $i++ ){
               array_push($arr3,$arr1[$arr2[$i]]);
               }
               $arr4 = implode(" and ",$arr3);
               // print_r($arr4);     
               if($arr_1_cnt > 0){
                   $data['row'] = $this->projects_model->AllDTPFreeLance($task_type,$this->brand,$arr4);
               }else{
                   $data['row'] = $this->projects_model->AllDTPFreeLancePages($task_type,$this->brand,9,0);
               }
          
            
            $this->load->view('dtp/exportDtpFreelance.php',$data);
           
        }else{
            echo "You have no permission to access this page";
        }
    }
    
public function dtpProductionReport(){
        $check = $this->admin_model->checkPermission($this->role,158);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,158);
            //body ..
        	$data['dtp'] = $this->db->query(" SELECT * FROM `users` WHERE (role = '23' OR role = '24') AND brand = '$this->brand'  ")->result();
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('dtp/dtpProductionReport.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
    
    public function saveRequestPlan(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,111);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('dtp_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('dtp/saveRequestPlan.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doSaveRequestPlan(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,111);
        if($permission->add == 1){
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = $data['status'] = $_POST['status'];
            
            $comment = $history['comment'] = $data['plan_comment'] = $_POST['plan_comment']??"";
            $history['created_by'] =  $this->user;
            $history['created_at'] =  date("Y-m-d H:i:s");
            if($this->db->insert('dtp_history',$history)){
                $this->db->update('dtp_request',$data,array('id' => $taskId));
            	$this->projects_model->sendDTPRequestPlanStatusMail($taskId,$data,$comment);
                $this->admin_model->addToLoggerUpdate('dtp_request',111,'id',$taskId,0,0,$this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."dtp");
            }else{
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."dtp");
            }
        }else{
            echo "You have no permission to access this page";
        }
    }


}
?>