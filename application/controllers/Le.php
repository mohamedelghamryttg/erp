<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Le extends CI_Controller {
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
        $check = $this->admin_model->checkPermission($this->role,117);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,117);
            //body ..
            $data['newTasks'] = $this->projects_model->newLETasks($this->brand);
            $data['tasksPlan'] = $this->projects_model->LeRequestsPlan($this->brand);
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
                    $data['le_request'] = $this->projects_model->AllLETasks($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['le_request'] = $this->projects_model->AllLETasksPages($data['permission'],$this->user,$this->brand,9,0);
                }
                $data['total_rows'] = $data['le_request']->num_rows();
            }else{
                $limit = 25;
                $offset = $this->uri->segment(3);
                if($this->uri->segment(3) != NULL)
                {
                    $offset = $this->uri->segment(3);
                }else{
                    $offset = 0;
                }
                $count = $this->projects_model->AllLETasks($data['permission'],$this->user,$this->brand,$this->brand,1)->num_rows();
                $config['base_url']= base_url('le/index');
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
                
                $data['le_request'] = $this->projects_model->AllLETasksPages($data['permission'],$this->user,$this->brand,$limit,$offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/leRequest.php');
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
        header("Content-Disposition: attachment; filename=LE Requests.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,117);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,117);
            //body ..
            $data['newTasks'] = $this->projects_model->newLETasks($this->brand);
            
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
                    if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,5); }
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
                    $data['le_request'] = $this->projects_model->AllLETasks($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['le_request'] = $this->projects_model->AllLETasksPages($data['permission'],$this->user,$this->brand,9,0);
                }
               
            // //Pages ..
          
            $this->load->view('le/exportRequests',$data);
          
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function saveRequest(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('le/saveRequest.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
    
    public function doSaveRequest(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($permission->add == 1){
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = $data['status'] = $_POST['status'];
            $comment="";
            // echo "Reject";
            if($data['status'] == 5 || $data['status'] == 0){
                $comment = $history['comment'] = $data['reason'] = $_POST['reason'];
            }
            $history['created_by'] = $data['status_by'] = $this->user;
            $history['created_at'] = $data['status_at'] = date("Y-m-d H:i:s");
            if($this->db->insert('le_history',$history)){
                $this->db->update('le_request',$data,array('id' => $taskId));
            	$this->projects_model->sendLERequestStatusMail($taskId,$data,$comment);
                $this->admin_model->addToLoggerUpdate('le_request',117,'id',$taskId,0,0,$this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."le");
            }else{
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."le");
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function leJobs(){
        $check = $this->admin_model->checkPermission($this->role,118);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,118);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            // $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('le_request_job',array('request_id'=>$taskId));
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/leJobs.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function addJob(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,118);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/addJob.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doAddJob(){
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,118);
        if($permission->add == 1){
            $data['request_id'] = base64_decode($_POST['request_id']);
            $data['le'] = $_POST['le'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
           
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
             $mailSubject = "New Job Assignment: ".date("Y-m-d H:i:s");
            $mailBody = "You have assigned to a new job please check.";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."le/leJobs?t=".$_POST['request_id']);         
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            
            if($this->db->insert('le_request_job',$data)){
            	$this->projects_model->sendJobAssignment($data['le'],$mailSubject,$mailBody);
                $true = "Job Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."le/leJobs?t=".$_POST['request_id']);
            }else{
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."le/leJobs?t=".$_POST['request_id']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function editJob(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,118);
        if($data['permission']->edit == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $jobId = base64_decode($_GET['j']);
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('le_request_job',array('id'=>$jobId))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/editJob.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doEditJob(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,118);
        if($permission->edit == 1){
            $id = base64_decode($_POST['id']);
            $data['le'] = $_POST['le'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
           
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
        	$data['status'] = 0;
             $mailSubject = "New Update At the Assignment: ".date("Y-m-d H:i:s");
            $mailBody = "You have a new update at the assignment please check it.";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 10000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if ( ! $this->file_upload->do_upload('file'))
                {
                    $error= $this->file_upload->display_errors();   
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."le/leJobs?t=".$_POST['request_id']);             
                }
                else
                {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            
            if($this->db->update('le_request_job',$data,array('id'=>$id))){
                $this->projects_model->sendJobAssignment($data['le'],$mailSubject,$mailBody);
                $true = "Job Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."le/leJobs?t=".$_POST['request_id']);
            }else{
                $error = "Failed To Edit Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."le/leJobs?t=".$_POST['request_id']);
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function leTasks(){
        $check = $this->admin_model->checkPermission($this->role,119);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,119);
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
                    $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['job'] = $this->projects_model->AllLEJobsPages($data['permission'],$this->user,$this->brand,9,0);
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
                $count = $this->projects_model->AllLEJobs($data['permission'],$this->user,$this->brand,$this->brand,1)->num_rows();
                $config['base_url']= base_url('le/leTasks');
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
                
                $data['job'] = $this->projects_model->AllLEJobsPages($data['permission'],$this->user,$this->brand,$limit,$offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/leTasks.php');
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
        header("Content-Disposition: attachment; filename=LE Tasks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,119);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,119);
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
                    $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['job'] = $this->projects_model->AllLEJobsPages($data['permission'],$this->user,$this->brand,9,0);
                }
                
            // //Pages ..
            
            $this->load->view('le/exportTasks.php',$data);
           
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function viewLETask(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,119);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $jobId = base64_decode($_GET['t']);
            $data['job'] = $this->db->get_where('le_request_job',array('id'=>$jobId))->row();
            $data['response'] = $this->db->get_where('le_request_response',array('task'=>$jobId))->result();
            $data['history'] = $this->db->get_where('le_request_history',array('task'=>$jobId))->result();
            $data['request'] = $this->db->get_where('le_request',array('id'=>$data['job']->request_id))->row();
            /////
            $data['jobData'] = $this->projects_model->getJobData($data['request']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            //////
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/viewLETask.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function jobAction(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,119);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['action'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if($this->db->insert('le_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('le_request_job',119,'id',$data['task'],0,0,$this->user);
                $this->db->update('le_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
            	$this->projects_model->sendLEJobStatusMail($data['task'],$data);
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

    public function jobRespone(){
        $data['task'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        if(strlen(trim($data['response'])) > 0){
            if($this->db->insert('le_request_response',$data)){
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

    public function closeLEJob(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,119);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['taken_time'] =  $this->projects_model->returnLETakenTime($data['task'],$data['created_at']);
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
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

            if($this->db->insert('le_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('le_request_job',119,'id',$data['task'],0,0,$this->user);
                $this->db->update('le_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
            	$this->projects_model->sendLEJobStatusMail($data['task'],$data);
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,119);
        if($permission->add == 1){
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = 1;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
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

            if($this->db->insert('le_request_history',$data)){
                $this->admin_model->addToLoggerUpdate('le_request_job',119,'id',$data['task'],0,0,$this->user);
                $this->db->update('le_request_job',array('status'=>$data['status']),array('id'=>$data['task']));
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

    public function viewRequest(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['response'] = $this->db->get_where('le_response',array('request'=>$taskId))->result();
            $data['history'] = $this->db->get_where('le_history',array('request'=>$taskId))->result();
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('le_new/viewRequest.php');
            $this->load->view('includes_new/footer.php'); 
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
            if($this->db->insert('le_response',$data)){
                $this->projects_model->sendLeCommentByMail($data['request'],$data['response'],$flag);
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

    public function closeLERequest(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($permission->add == 1){
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            $file="";
            if ($_FILES['file']['size'] != 0)
            {
                $config['file']['upload_path']          = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
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

            if($this->db->insert('le_history',$data)){
                $this->admin_model->addToLoggerUpdate('le_request',117,'id',$data['request'],0,0,$this->user);
                $this->db->update('le_request',array('status'=>$data['status']),array('id'=>$data['request']));
            	$this->projects_model->sendLERequestStatusMail($data['request'],$data,$data['comment'],$file);
                // for check order tasks 
                $taskData = $this->db->get_where('le_request',array('id' => $data['request']))->row();
                $this->projects_model->CheckCloseRelatedTasks($taskData->job_id,$data['request'],"LE");
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

    public function leReport(){

    $check = $this->admin_model->checkPermission($this->role,128);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,128);
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
	                if(isset($_REQUEST['le'])){
	                    $le = $_REQUEST['le'];
	                    if(!empty($le)){ array_push($arr2,2); }
	                }else{
	                    $le = "";
	                }
	                // print_r($arr2);
	                $cond1 = "id = '$code'";            
	                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
	                $cond3 = "le = '$le'";            
	                $arr1 = array($cond1,$cond2,$cond3);
	                $arr_1_cnt = count($arr2);
	                $arr3 = array();
	                for($i=0; $i<$arr_1_cnt; $i++ ){
	                array_push($arr3,$arr1[$arr2[$i]]);
	                }
	                $arr4 = implode(" and ",$arr3);
	                // print_r($arr4);     
	                if($arr_1_cnt > 0){
	                    $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,$this->brand,$arr4);
	                }else{
	                     $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,0,1);
	                }
	            }else{
	            	 $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,0,1);
	            }
            // //Pages ..
	            
            $this->load->view('includes/header.php',$data);
            $this->load->view('le/leReport.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }


    }

	public function exportLEJobs(){
		$file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=LE Jobs.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,128);
        if($check){

            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,128);
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
	                if(isset($_REQUEST['le'])){
	                    $le = $_REQUEST['le'];
	                    if(!empty($le)){ array_push($arr2,2); }
	                }else{
	                    $le = "";
	                }
	                // print_r($arr2);
	                $cond1 = "id = '$code'";            
	                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
	                $cond3 = "le = '$le'";            
	                $arr1 = array($cond1,$cond2,$cond3);
	                $arr_1_cnt = count($arr2);
	                $arr3 = array();
	                for($i=0; $i<$arr_1_cnt; $i++ ){
	                array_push($arr3,$arr1[$arr2[$i]]);
	                }
	                $arr4 = implode(" and ",$arr3);
	                // print_r($arr4);     
	                if($arr_1_cnt > 0){
	                    $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,$this->brand,$arr4);
	                }else{
	                     $data['job'] = $this->projects_model->AllLEJobs($data['permission'],$this->user,0,1);
	                }

            // //Pages ..
            $this->load->view('le/exportLEJobs.php',$data);
        }else{
            echo "You have no permission to access this page";
        }
    }
    
    public function saveRequestPlan(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('le_request',array('id'=>$taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('le/saveRequestPlan.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
    }
    
    public function doSaveRequestPlan(){
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,117);
        if($permission->add == 1){
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = 7;
            $history['status'] = $data['status'] = $_POST['status'];         
           
            $comment = $history['comment'] = $data['plan_comment'] = $_POST['plan_comment']??"";
            
            $history['created_by'] = $this->user;
            $history['created_at'] = date("Y-m-d H:i:s");
            if($this->db->insert('le_history',$history)){
                $this->db->update('le_request',$data,array('id' => $taskId));
            	$this->projects_model->sendLERequestPlanStatusMail($taskId,$data,$comment);
                $this->admin_model->addToLoggerUpdate('le_request',117,'id',$taskId,0,0,$this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."le");
            }else{
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."le");
            }
        }else{
            echo "You have no permission to access this page";
        }
    }

    ///
 
    ///
}
?>