<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Translation extends CI_Controller
{
    var $role, $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }
    public function index()
    {
        // ini_set('memory_limit', '-1');
        $check = $this->admin_model->checkPermission($this->role, 114);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
            // //Pages ..
            $data['brand'] = $this->brand;
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/translationRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    function get_transtations()
    {
        ini_set('max_execution_time', 0);
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        $filter_data = $this->input->post('filter_data');
        parse_str($filter_data, $params);
        $arr2 = array();
        if ($filter_data) {
            if (isset($params['code'])) {
                $code = $params['code'];
                if (!empty($code)) {
                    array_push($arr2, 0);
                }
            } else {
                $code = "";
            }
            if (isset($params['pm'])) {
                $pm = $params['pm'];
                if (!empty($pm)) {
                    array_push($arr2, 1);
                }
            } else {
                $pm = "";
            }
            if (isset($params['date_from']) && isset($params['date_to'])) {
                $date_from = date("Y-m-d", strtotime($params['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($params['date_to'])));

                if (!empty($params['date_from']) && !empty($params['date_to'])) {
                    array_push($arr2, 2);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }
            if (isset($params['subject'])) {
                $subject = $params['subject'];
                if (!empty($subject)) {
                    array_push($arr2, 3);
                }
            } else {
                $subject = "";
            }
            if (isset($params['status'])) {
                $data['status'] = $status = $params['status'];
                if (!empty($status)) {
                    array_push($arr2, 4);
                }
            } else {
                $data['status'] = $status = "";
            }
        } else {
            $code = "";
            $pm = "";
            $date_from = "";
            $date_to = "";
            $subject = "";
            $status = "";
        }
        // print_r($arr2);
        $cond1 = "t.id = '$code'";
        $cond2 = "t.created_by = '$pm'";
        $cond3 = "t.created_at BETWEEN '$date_from' AND '$date_to' ";
        $cond4 = "t.subject LIKE '%$subject%'";
        $cond5 = "t.status = '$status'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        if ($arr_1_cnt > 0) {
            $arr4 = implode(" and ", $arr3);
        } else {
            $arr4 = '1';
        }

        $data['allRequestsData'] = $this->projects_model->AllTranslation($data['permission'], $this->user, $this->brand, $arr4)->result_array();
        // var_dump($this->db->last_query());
        $data['translationRequestsData'] = $this->projects_model->newTranslationTasks($this->brand)->result_array();
        $data['handsRequestsData'] = $this->projects_model->TranslationRequestsPlan($this->brand)->result_array();

        $data['brand'] = $this->brand;
        echo base64_encode(json_encode($data));
    }
    public function index_old()
    {
        ini_set('memory_limit', '-1');
        $check = $this->admin_model->checkPermission($this->role, 114);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
            //body ..
            $data['newTasks'] = $this->projects_model->newTranslationTasks($this->brand);
            $data['tasksPlan'] = $this->projects_model->TranslationRequestsPlan($this->brand);
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['pm'])) {
                    $pm = $_REQUEST['pm'];
                    if (!empty($pm)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $pm = "";
                }

                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 2);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $subject = "";
                }
                if (isset($_REQUEST['status'])) {
                    $data['status'] = $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $data['status'] = $status = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";
                $cond2 = "created_by = '$pm'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond4 = "subject LIKE '%$subject%'";
                $cond5 = "status = '$status'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['translation_request'] = $this->projects_model->AllTranslationTasks($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['translation_request'] = $this->projects_model->AllTranslationTasksPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['translation_request']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllTranslationTasks($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('translation/index');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page']  = $limit;
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

                $data['translation_request'] = $this->projects_model->AllTranslationTasksPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/translationRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportRequests()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation Requests.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 114);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
            //body ..
            $data['newTasks'] = $this->projects_model->newTranslationTasks($this->brand);

            $arr2 = array();
            if (isset($_REQUEST['code'])) {
                $code = $_REQUEST['code'];
                if (!empty($code)) {
                    array_push($arr2, 0);
                }
            } else {
                $code = "";
            }
            if (isset($_REQUEST['pm'])) {
                $pm = $_REQUEST['pm'];
                if (!empty($pm)) {
                    array_push($arr2, 1);
                }
            } else {
                $pm = "";
            }

            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 2);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }
            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    array_push($arr2, 3);
                }
            } else {
                $status = "";
            }
            // print_r($arr2);
            $cond1 = "id = '$code'";
            $cond2 = "created_by = '$pm'";
            $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond4 = "status = '$status'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['translation_request'] = $this->projects_model->AllTranslationTasks($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['translation_request'] = $this->projects_model->AllTranslationTasksPages($data['permission'], $this->user, $this->brand, 9, 0);
            }

            // //Pages ..

            $this->load->view('translation/exportRequests', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


    /*public function exportRequests(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation Requests.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
       // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,114);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,114);
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
                    $data['le_request'] = $this->projects_model->AllTranslationTasks($data['permission'],$this->user,$this->brand,$arr4);
                }else{
                    $data['le_request'] = $this->projects_model->AllTranslationTasksPages($data['permission'],$this->user,$this->brand,9,0);
                }
               
            // //Pages ..
          
            $this->load->view('translation/exportRequests',$data);
          
        }else{
            echo "You have no permission to access this page";
        }
    }*/

    public function saveRequest()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/saveRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doSaveRequest()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($permission->add == 1) {
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = $data['status'] = $_POST['status'];
            $comment = "";
            // echo "Reject";
            if ($data['status'] == 5 || $data['status'] == 0) {
                $history['comment'] = $data['reason'] = $_POST['reason'];
                $comment = $history['comment'] = $data['reason'] = $_POST['reason'];
            }
            $history['created_by'] = $data['status_by'] = $this->user;
            $history['created_at'] = $data['status_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('translation_history', $history)) {
                $this->db->update('translation_request', $data, array('id' => $taskId));
                $this->projects_model->sendTranslationRequestStatusMail($taskId, $data, $comment);
                $this->admin_model->addToLoggerUpdate('translation_request', 114, 'id', $taskId, 0, 0, $this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "translation");
            } else {
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "translation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function TranslationJobs()
    {
        $check = $this->admin_model->checkPermission($this->role, 115);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 115);
            //body ..

            $taskId = base64_decode($_GET['t']);
            //  base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('translation_request_job', array('request_id' => $taskId));
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/translationJobs.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addJob()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 115);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/addJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddJob()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 115);
        if ($permission->add == 1) {
            $data['request_id'] = base64_decode($_POST['request_id']);
            $data['translator'] = $_POST['translator'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $mailSubject = "New Job Assignment: " . date("Y-m-d H:i:s");
            $mailBody = "You have assigned to a new job please check.";
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path']          = './assets/uploads/translationJob/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('translation_request_job', $data)) {
                $this->projects_model->sendJobAssignment($data['translator'], $mailSubject, $mailBody);
                $true = "Job Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
            } else {
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editJob()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 115);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $jobId = base64_decode($_GET['j']);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            $data['job'] = $this->db->get_where('translation_request_job', array('id' => $jobId))->row();
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/editJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditJob()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 115);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['translator'] = $_POST['translator'];
            $data['task_type'] = $_POST['task_type'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 0;
            $mailSubject = "New Update At the Assignment: " . date("Y-m-d H:i:s");
            $mailBody = "You have a new update at the assignment please check it.";
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path']          = './assets/uploads/translationJob/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->update('translation_request_job', $data, array('id' => $id))) {
                $this->projects_model->sendJobAssignment($data['translator'], $mailSubject, $mailBody);
                $true = "Job Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
            } else {
                $error = "Failed To Edit Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function TranslationTasks()
    {
        $check = $this->admin_model->checkPermission($this->role, 116);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";
                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['job'] = $this->projects_model->AllTranslationJobsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['job']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('translation/TranslationTasks');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page']  = $limit;
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

                $data['job'] = $this->projects_model->AllTranslationJobsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/TranslationTasks.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportTasks()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation Tasks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 116);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['code'])) {
                $code = $_REQUEST['code'];
                if (!empty($code)) {
                    array_push($arr2, 0);
                }
            } else {
                $code = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 1);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }
            // print_r($arr2);
            $cond1 = "id = '$code'";
            $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['job'] = $this->projects_model->AllTranslationJobsPages($data['permission'], $this->user, $this->brand, 9, 0);
            }

            // //Pages ..

            $this->load->view('translation/exportTasks.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewTranslatorTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $jobId = base64_decode($_GET['t']);
            $data['job'] = $this->db->get_where('translation_request_job', array('id' => $jobId))->row();
            $data['response'] = $this->db->get_where('translation_request_response', array('task' => $jobId))->result();
            $data['history'] = $this->db->get_where('translation_request_history', array('task' => $jobId))->result();
            $data['request'] = $this->db->get_where('translation_request', array('id' => $data['job']->request_id))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/viewTranslatorTask.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function jobAction()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($permission->add == 1) {
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['action'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('translation_request_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request_job', 116, 'id', $data['task'], 0, 0, $this->user);
                $this->db->update('translation_request_job', array('status' => $data['status']), array('id' => $data['task']));
                $this->projects_model->sendTranslationJobStatusMail($data['task'], $data);
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function jobRespone()
    {
        $data['task'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        if (strlen(trim($data['response'])) > 0) {
            if ($this->db->insert('translation_request_response', $data)) {
                $this->projects_model->sendTranslationCommentBtweenTeamByMail($data['task'], $data['response']);
                $true = "Task Reply Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Task Reply ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Failed To Add Task Reply ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function closeTranslatioJob()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($permission->add == 1) {
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['taken_time'] =  $this->projects_model->returnTranslationTakenTime($data['task'], $data['created_at']);
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path']          = './assets/uploads/translationJob/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('translation_request_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request_job', 116, 'id', $data['task'], 0, 0, $this->user);
                $this->db->update('translation_request_job', array('status' => $data['status']), array('id' => $data['task']));
                $this->projects_model->sendTranslationJobStatusMail($data['task'], $data);
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function reopenJob()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($permission->add == 1) {
            $data['task'] = base64_decode($_POST['id']);
            $data['status'] = 1;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path']          = './assets/uploads/translationJob/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationJob/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "translation/TranslationJobs?t=" . $_POST['request_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('translation_request_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request_job', 116, 'id', $data['task'], 0, 0, $this->user);
                $this->db->update('translation_request_job', array('status' => $data['status']), array('id' => $data['task']));
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updateFinalCount()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($permission->add == 1) {
            $task = base64_decode($_POST['id']);
            $data['updated_count'] = $_POST['updated_count'];
            $data['updated_by'] = $this->user;
            $data['updated_date'] = date("Y-m-d H:i:s");

            $this->admin_model->addToLoggerUpdate('translation_request_job', 116, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('translation_request_job', $data, array('id' => $task))) {
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewRequest()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['response'] = $this->db->get_where('translation_response', array('request' => $taskId))->result();
            $data['history'] = $this->db->get_where('translation_history', array('request' => $taskId))->result();
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('translation_new/viewRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function requestRespone()
    {
        $data['request'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        $flag = $_POST['flag'];
        if (strlen(trim($data['response'])) > 0) {
            if ($this->db->insert('translation_response', $data)) {
                if ($flag == 1) {
                    //from translation
                    $pm = $this->db->get_where('translation_request', array('id' => $data['request']))->row()->created_by;
                    $mailTo = $this->db->get_where('users', array('id' => $pm))->row()->email;
                } elseif ($flag == 2) {
                    //from pm
                    $mailTo = "translation.allocator@thetranslationgate.com";
                }
                $this->projects_model->sendTranslationCommentByMail($data['request'], $mailTo, $data['response']);
                $true = "Task Reply Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Task Reply ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Failed To Add Task Reply ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function closeTranslationRequest()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($permission->add == 1) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            $file = "";
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path']          = './assets/uploads/translationRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationRequest/';
                $config['file']['encrypt_name']         = TRUE;
                $config['file']['allowed_types']  = 'zip|rar';
                $config['file']['max_size']             = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $file = $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('translation_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request', 114, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('translation_request', array('status' => $data['status'], 'tm' => $_POST['tm']), array('id' => $data['request']));
                $this->projects_model->sendTranslationRequestStatusMail($data['request'], $data, $data['comment'], $file);
                // for check order tasks 
                $taskData = $this->db->get_where('translation_request', array('id' => $data['request']))->row();
                $this->projects_model->CheckCloseRelatedTasks($taskData->job_id, $data['request'], "Translation");
                //end order tasks check
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    //
    public function updateTranslationRequestToWattingConfirmation()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($permission->add == 1) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('translation_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request', 114, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('translation_request', array('status' => $data['status']), array('id' => $data['request']));
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    //
    public function translationReport()
    {

        $check = $this->admin_model->checkPermission($this->role, 130);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 130);
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['translator'])) {
                    $translator = $_REQUEST['translator'];
                    if (!empty($translator)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $translator = "";
                }
                // print_r($arr2);
                $cond1 = "id = '$code'";
                $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond3 = "translator = '$translator'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, 0, 1);
                }
            } else {
                $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, 0, 1);
            }
            // //Pages ..

            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/translationReport.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportTranslationJobs()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation Jobs.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 130);
        if ($check) {

            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 130);
            //body ..
            $arr2 = array();
            if (isset($_REQUEST['code'])) {
                $code = $_REQUEST['code'];
                if (!empty($code)) {
                    array_push($arr2, 0);
                }
            } else {
                $code = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 1);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }
            if (isset($_REQUEST['translator'])) {
                $translator = $_REQUEST['translator'];
                if (!empty($translator)) {
                    array_push($arr2, 2);
                }
            } else {
                $translator = "";
            }
            // print_r($arr2);
            $cond1 = "id = '$code'";
            $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond3 = "translator = '$translator'";
            $arr1 = array($cond1, $cond2, $cond3);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, 0, 1);
            }

            // //Pages ..
            $this->load->view('translation/exportTranslationJobs.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function translationProductionReport()
    {
        $check = $this->admin_model->checkPermission($this->role, 149);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 149);
            //body ..

            $brand = $this->brand;
            if (isset($_GET['search'])) {
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                $data['unit'] = $this->db->get('unit')->result();
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/translationProductionReport.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function exportTranslationProductionReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation Production Report.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 149);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 149);
            //body ..
            $brand = $this->brand;
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            } else {
                $date_to = "";
                $date_from = "";
            }
            $data['date_from'] = $date_from;
            $data['date_to'] = $date_to;
            $data['unit'] = $this->db->get('unit')->result();

            // //Pages ..

            $this->load->view('translation/exportTranslationProductionReport.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function updateCount()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 116);
        if ($permission->add == 1) {
            $task = base64_decode($_POST['id']);
            $data['count'] = $_POST['count'];
            $data['updated_by'] = $this->user;
            $data['updated_date'] = date("Y-m-d H:i:s");

            $this->admin_model->addToLoggerUpdate('translation_request_job', 116, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('translation_request_job', $data, array('id' => $task))) {
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function saveRequestPlan()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $taskId = base64_decode($_GET['t']);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('translation/saveRequestPlan.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doSaveRequestPlan()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($permission->add == 1) {
            $history['request'] = $taskId = base64_decode($_POST['id']);
            $history['status'] = $data['status'] = $_POST['status'];

            $comment = $history['comment'] = $data['plan_comment'] = $_POST['plan_comment'] ?? "";

            $history['created_by'] = $this->user;
            $history['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('translation_history', $history)) {
                $this->db->update('translation_request', $data, array('id' => $taskId));
                $this->projects_model->sendTranslationRequestPlanStatusMail($taskId, $data, $comment);
                $this->admin_model->addToLoggerUpdate('translation_request', 114, 'id', $taskId, 0, 0, $this->user);
                $true = "Changes Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "translation");
            } else {
                $error = "Failed To Save Your Changes ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "translation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updateClosedTranslationRequestToRunning()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 114);
        if ($permission->add == 1 && ($this->role == 21 || $this->role == 28)) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = 2;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('translation_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request', 114, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('translation_request', array('status' => $data['status']), array('id' => $data['request']));
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Update The Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
}
