<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProjectManagment extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->admin_model->verfiyLogin();
        $this->load->library('Excelfile');
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
    }
    public function index()
    {
        // Check Permission ..        
        $check = $this->admin_model->checkPermission($this->role, 204);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 204);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $data['opportunity'] = $this->projects_model->OpportunitiesByPm($data['permission'], $this->user, $this->brand);
            $having = 1;
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
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if ($status == 2) {
                        $having = "closed = '0'";
                    } elseif ($status == 1) {
                        $having = "closed = '1'";
                    }
                } else {
                    $status = "";
                    $having = 1;
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 4);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "code LIKE '%$code%'";
                $cond2 = "name LIKE '%$name%'";
                $cond3 = "customer = '$customer'";
                $cond4 = "product_line = '$product_line'";
                if ($status == 2) {
                    $status = 0;
                }
                $cond6 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond6);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt <= 0) {
                    $arr4 = 1;
                }
                $data['project'] = $this->projects_model->AllProjects($data['permission'], $this->user, $this->brand, $arr4, $having);
                $data['total_rows'] = $data['project']->num_rows();
                $data['offset'] = 0;
            } else {
                $limit = 20;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $data['offset'] = $offset;

                $count = $this->projects_model->AllProjectsCount($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projectManagment/index');
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

                $data['project'] = $this->projects_model->AllProjectsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/view_projects.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function projectJobs($id = '')
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 65);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 65);
            //body ..
            $data['project'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['project_data'] = $this->projects_model->getProjectData($data['project']);
            $data['job'] = $this->projects_model->projectJobs($data['permission'], $this->user, $data['project']);
            $data['tasks'] = $this->projects_model->projectTasks($data['permission'], $this->user, $data['project']);
            $data['tasks_offers'] = $this->projects_model->projectTasksOffers($data['permission'], $this->user, $data['project']);
            $data['translation_request'] = $this->projects_model->projectTranslationRequest($data['permission'], $this->user, $data['project']);
            $data['le_request'] = $this->projects_model->projectLeRequest($data['permission'], $this->user, $data['project']);
            $data['dtp_request'] = $this->projects_model->projectDTPRequest($data['permission'], $this->user, $data['project']);

            $data['pm_setup'] = $this->projects_model->getPmSetup($this->brand);

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/projectJobs.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 38);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 38);
            //body ..
            $data['pm'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addProject.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 38);
        if ($check) {
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['name'] = $_POST['name'];
            $data['product_line'] = $_POST['product_line'];
            $data['code'] = $this->projects_model->generateProjectCode($data['lead'], $this->user);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            // min_profit_percentage
            $data['min_profit_percentage'] = $this->projects_model->getProfitPercentageSetup($this->brand);
            
            if ($this->db->insert('project', $data)) {
                $project_id = $this->db->insert_id();
                $jobsNum = $_POST['new_job'];
                for ($i = 1; $i < $jobsNum; $i++) {
                    if (isset($_POST['price_list_' . $i])) {
                        $price_list = $_POST['price_list_' . $i];
                    } else {
                        $error = "Failed To Add Project, Please make sure to select from price list ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects");
                    }

                    $row = $this->sales_model->getPriceListData($price_list);
                    $job_price['product_line'] = $row->product_line;
                    $job_price['source'] = $row->source;
                    $job_price['target'] = $row->target;
                    $job_price['service'] = $row->service;
                    $job_price['task_type'] = $row->task_type;
                    $job_price['subject'] = $row->subject;
                    $job_price['unit'] = $row->unit;
                    $job_price['rate'] = $row->rate;
                    $job_price['currency'] = $row->currency;
                    $job_price['comment'] = $row->comment;
                    $job_price['price_list_id'] = $price_list;
                    $job_price['created_by'] = $this->user;
                    $job_price['created_at'] = date("Y-m-d H:i:s");
                    $this->db->insert('job_price_list', $job_price);


                    $job['price_list'] = $this->db->insert_id();
                    $job['type'] = $_POST['type_' . $i];
                    $job['name'] = $_POST['jobName_' . $i];
                    $job['project_id'] = $project_id;
                    if ($job['type'] == 1) {
                        $job['volume'] = $_POST['volume_' . $i];
                    }
                    $job['start_date'] = $_POST['start_date_' . $i];
                    $job['delivery_date'] = $_POST['delivery_date_' . $i];
                    $job['code'] = $this->projects_model->generateJobCode($job['project_id'], $price_list);
                    $job['created_by'] = $this->user;
                    $job['created_at'] = date("Y-m-d H:i:s");
                    $job['assigned_sam'] = $this->projects_model->getAssignedSam($data['lead']);
                    $job['job_type'] = $_POST['job_type_' . $i];
                    if ($this->db->insert('job', $job)) {
                        if ($job['type'] == 2) {
                            $fuzzy['job'] = $this->db->insert_id();
                            for ($x = 1; $x <= $_POST['total_rows_' . $i]; $x++) {
                                $fuzzy['prcnt'] = $_POST['prcnt_' . $x . '_' . $i];
                                $fuzzy['unit_number'] = $_POST['unit_number_' . $x . '_' . $i];
                                $fuzzy['value'] = $_POST['value_' . $x . '_' . $i];
                                $this->db->insert('project_fuzzy', $fuzzy);
                            }
                        }
                    } else {
                        $error = "Failed To Add Job ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects");
                    }
                }

                $true = "Project Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
            } else {
                $error = "Failed To Add Project ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddTaskVendorModule()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $tableName = "job_task";
            $vendorType = $_POST['vendor'];
            $data['job_id'] = base64_decode($_POST['job_id']);
            $project_id = $this->db->get_where('job', array('id' => $data['job_id']))->row()->project_id;
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['time_zone'] = $_POST['time_zone'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['job_portal'] = 1;
            $data['status'] = 4;
            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/taskFile/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 20000000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if (!empty($_POST['start_after'])) {
                $data['start_after_id'] = substr(strstr($_POST['start_after'], '//'), 2);
                $data['start_after_type'] = strstr($_POST['start_after'], '//', true);
                $data['status'] = 6;
            }

            // start send to multi vendors if service = test
            if ($_POST['serviceType'] == 1 && $vendorType == "all") {
                foreach ($_POST['vendors'] as $k => $val) {
                    $data['service_type'] = 1;
                    $data['vendor'] = $val;
                    $data['rate'] = $_POST['rate'];
                    $data['currency'] = $_POST['currency'];
                    $data['unit'] = $_POST['unit'];
                    $data['code'] = $this->projects_model->generateTaskCode($data['job_id']);
                    if ($this->db->insert("job_task", $data)) {
                        $insert_id = $this->db->insert_id();
                        $totalVpo = $data['rate'] * $data['count'];
                        if ($data['status'] == 4) {
                            $this->projects_model->sendVendorTaskMailVendorModule($insert_id, $this->user, $this->brand);
                            // task log
                            $this->projects_model->addToTaskLogger($insert_id, 0);
                        }
                        $true = "Task Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                    } else {
                        $error = "Failed To Add Task ...";
                        $this->session->set_flashdata('error', $error);
                    }
                }
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            }

            // end 

            if ($vendorType == "all") {

                $vendor_list = implode(", ", $_POST['vendors']);
                $vendor_list .= ', ';
                $data['vendor_list'] = $vendor_list;
                $data['rate'] = $_POST['rate'];
                $data['currency'] = $_POST['currency'];
                $data['unit'] = $_POST['unit'];
                $tableName = "job_offer_list";
            } else {
                $data['vendor'] = $_POST['vendor'];
                $select = $_POST['select'];
                $data['rate'] = $_POST['rate_' . $select];
                $data['currency'] = $_POST['currency_' . $select];
                $data['unit'] = $_POST['unit_' . $select];
                $data['code'] = $this->projects_model->generateTaskCode($data['job_id']);
            }
            // checkSingleTaskPercentage
            $checkTaskCost = $this->projects_model->getTaskCost(1,$data);
            $check = $this->projects_model->checkSingleTaskPercentage($project_id,1,$data);
            if($check == True && $checkTaskCost > 0){
                if ($this->db->insert($tableName, $data)) {
                    $insert_id = $this->db->insert_id();
                    $totalVpo = $data['rate'] * $data['count'];
                    if ($totalVpo > 0 && $data['status'] == 4) {
                        if ($tableName == "job_task") {
                            $this->projects_model->sendVendorTaskMailVendorModule($insert_id, $this->user, $this->brand);
                            // task log
                            $this->projects_model->addToTaskLogger($insert_id, 0);
                        } else {
                            //  new email to all vendors
                            $this->projects_model->sendToVendorList($insert_id, $this->user, $this->brand);
                        }
                    }
                    $true = "Task Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $error = "Failed To Add Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                }        
            }else{
                 if($checkTaskCost == 0){
                    $msg = $this->projects_model->checkTaskCostError(1,$data);
                    $error = "Failed To Add Task <br/>$msg";
                }else{
                    $error = "Failed To Add Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                }
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            }         
        }else {
        echo "You have no permission to access this page";
        }
    }


    public function addJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 66);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 66);
            //body ..
            $data['project'] = base64_decode($_GET['t']);
            $data['project_data'] = $this->projects_model->getProjectData($data['project']);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 66);
        if ($check) {
            $price_list = $_POST['price_list'];
            $project_id = base64_decode($_POST['project_id']);
            if (isset($_POST['price_list'])) {
                $price_list = $_POST['price_list'];
            } else {
                $error = "Failed To Add Project, Please make sure to select from price list ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
            }
            if ($_POST['job_type'] == 0 && $_POST['total_revenue'] == 0) {
                $error = "Please check , total revenue for real job must be > zero ... ";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
            }

            $row = $this->sales_model->getPriceListData($price_list);
            $job_price['product_line'] = $row->product_line;
            $job_price['source'] = $row->source;
            $job_price['target'] = $row->target;
            $job_price['service'] = $row->service;
            $job_price['task_type'] = $row->task_type;
            $job_price['subject'] = $row->subject;
            $job_price['unit'] = $row->unit;
            $job_price['rate'] = $row->rate;
            $job_price['currency'] = $row->currency;
            $job_price['comment'] = $row->comment;
            $job_price['price_list_id'] = $price_list;
            $job_price['created_by'] = $this->user;
            $job_price['created_at'] = date("Y-m-d H:i:s");
            $this->db->insert('job_price_list', $job_price);


            $data['price_list'] = $this->db->insert_id();
            $data['type'] = $_POST['type'];
            $data['name'] = $_POST['name'];
            $data['project_id'] = base64_decode($_POST['project_id']);
            $projectData = $this->db->get_where('project', array('id' => $data['project_id']))->row();
            $data['assigned_sam'] = $this->projects_model->getAssignedSam($projectData->lead);
            if ($data['type'] == 1) {
                $data['volume'] = $_POST['volume'];
            }
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['code'] = $this->projects_model->generateJobCode($data['project_id'], $price_list);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['job_type'] = $_POST['job_type'];
            $data['client_pm_id'] = $_POST['client_pm_id'];
            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/jobFile/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 20000000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $data_file = $this->file_upload->data();
                    $data['job_file'] = $data_file['file_name'];
                    $data['job_file_name'] = $_FILES['file']['name'];
                }
            }
            if ($_FILES['attached_email']['size'] != 0 && $_POST['job_type'] == 1) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/jobFile/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 20000000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('attached_email')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $data_file = $this->file_upload->data();
                    $data['attached_email'] = $data_file['file_name'];
                }
            }
            if ($this->db->insert('job', $data)) {
                if ($data['type'] == 2) {
                    $fuzzy['job'] = $this->db->insert_id();
                    for ($i = 1; $i <= $_POST['total_rows']; $i++) {
                        $fuzzy['prcnt'] = $_POST['prcnt_' . $i];
                        $fuzzy['unit_number'] = $_POST['unit_number_' . $i];
                        $fuzzy['value'] = $_POST['value_' . $i];
                        $this->db->insert('project_fuzzy', $fuzzy);
                    }
                }
                $true = "Job Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
            } else {
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . base64_encode($project_id));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addTask()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            redirect("projectManagment/addTaskVendorModule?t=" . $_GET['t']);
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addTaskVendorModule()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addTaskVendorModule.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteJob()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 65);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $project = base64_decode($_GET['p']);
            $job_data = $this->projects_model->getJobData($id);
             // checkProjectProfitPercentageForJobs
            $checkPer = $this->projects_model->checkProjectProfitPercentageForJobs($project,$id);
            if($checkPer == True ){
                $this->admin_model->addToLoggerDelete('job', 68, 'id', $id, 0, 0, $this->user);
                if ($this->db->delete('job', array('id' => $id))) {
                    $this->admin_model->addToLoggerDelete('job_price_list', 68, 'id', $job_data->price_list, 1, $id, $this->user);
                    $this->db->delete('job_price_list', array('id' => $job_data->price_list));
                    $true = "Job Deleted Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project));
                } else {
                    $error = "Failed To Delete Job ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project));
                }            
            }
            else {
                    $error = "Failed To Delete Job <br/>Project Profit Percentage < Minimum Profit Percentage";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project));
                }     
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 67);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 67);
            //body ..
            $data['project'] = base64_decode($_GET['p']);
            $data['job'] = base64_decode($_GET['t']);
            $data['project_data'] = $this->projects_model->getProjectData($data['project']);
            $data['row'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['row']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/editJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 67);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $price_list = $_POST['price_list'];
            if (isset($_POST['price_list'])) {
                $price_list = $_POST['price_list'];
            } else {
                $error = "Failed To Add Project, Please make sure to select from price list ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            }
            if ($_POST['job_type'] == 0 && $_POST['total_revenue'] == 0) {
                $error = "Please check , total revenue for real job must be > zero ... ";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            }
             $project_id = base64_decode($_POST['project_id']);
                // checkProjectProfitPercentageForJobs
            $checkPer = $this->projects_model->checkProjectProfitPercentageForJobs($project_id,$id,$_POST);
            if($checkPer == True ){               
                $row = $this->sales_model->getPriceListData($price_list);
                $job_price['product_line'] = $row->product_line;
                $job_price['source'] = $row->source;
                $job_price['target'] = $row->target;
                $job_price['service'] = $row->service;
                $job_price['task_type'] = $row->task_type;
                $job_price['subject'] = $row->subject;
                $job_price['unit'] = $row->unit;
                $job_price['rate'] = $row->rate;
                $job_price['currency'] = $row->currency;
                $job_price['comment'] = $row->comment;
                $job_price['price_list_id'] = $price_list;
                $job_price_list = $_POST['job_price_list'];
                $this->admin_model->addToLoggerUpdate('job_price_list', 67, 'id', $job_price_list, 1, $id, $this->user);
                $this->db->update('job_price_list', $job_price, array('id' => $job_price_list));
               
                $data['type'] = $_POST['type'];
                $data['name'] = $_POST['name'];
                if ($data['type'] == 1) {
                    $data['volume'] = $_POST['volume'];
                }
                $data['start_date'] = $_POST['start_date'];
                $data['delivery_date'] = $_POST['delivery_date'];
                $data['code'] = $this->projects_model->updateJobCode($project_id, $price_list, $id);
                $data['job_type'] = $_POST['job_type'];
                $data['client_pm_id'] = $_POST['client_pm_id'];        
                $this->admin_model->addToLoggerUpdate('job', 67, 'id', $id, 0, 0, $this->user);

                if ($_FILES['attached_email']['size'] != 0 && $_POST['job_type'] == 1) {
                    //$config['file']['upload_path']          = './assets/uploads/vendors/';
                    $config['file']['upload_path'] = './assets/uploads/jobFile/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 20000000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('attached_email')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['attached_email'] = $data_file['file_name'];
                    }
                }            
                if ($this->db->update('job', $data, array('id' => $id))) {
                    if ($data['type'] == 2) {
                        $fuzzy['job'] = $id;
                        $this->db->delete('project_fuzzy', array('job' => $id));
                        for ($i = 1; $i <= $_POST['total_rows']; $i++) {
                            $fuzzy['prcnt'] = $_POST['prcnt_' . $i];
                            $fuzzy['unit_number'] = $_POST['unit_number_' . $i];
                            $fuzzy['value'] = $_POST['value_' . $i];
                            $this->db->insert('project_fuzzy', $fuzzy);
                        }
                    } elseif ($data['type'] == 1) {
                        $this->db->delete('project_fuzzy', array('job' => $id));
                    }
                    $true = "Job Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                } else {
                    $error = "Failed To Edit Job ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                }
            }
            else {
                 $error = "Failed To Edit Job <br/>Project Profit Percentage < Minimum Profit Percentage";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function closeJob()
    {
        if (isset($_POST['select'])) {
            $select = $_POST['select'];
            $jobIds = implode(",", $_POST['select']);
            $poData['number'] = trim($_POST['po']);
            $poData['verified'] = 0;
            $poData['created_at'] = date("Y-m-d H:i:s");
            $poData['created_by'] = $this->user;
            $projectData = $this->db->get_where('project', array('id' => base64_decode($_POST['project_id'])))->row();
            $poData['customer'] = $projectData->customer;
            $poData['lead'] = $projectData->lead;
            $checkPo = $this->projects_model->checkProjectPo($poData['number'], $jobIds);
            if ($checkPo) {
                if ($_FILES['cpo_file']['size'] != 0) {
                    $config['cpo_file']['upload_path'] = './assets/uploads/cpo/';
                    $config['cpo_file']['encrypt_name'] = TRUE;
                    $config['cpo_file']['allowed_types'] = 'zip|rar';
                    $config['cpo_file']['max_size'] = 500000;
                    $config['cpo_file']['max_width'] = 1024;
                    $config['cpo_file']['max_height'] = 768;
                    $this->load->library('upload', $config['cpo_file'], 'file_upload');
                    if (!$this->file_upload->do_upload('cpo_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $poData['cpo_file'] = $data_file['file_name'];
                    }
                }

                if ($this->db->insert('po', $poData)) {
                    $jobData['po'] = $this->db->insert_id();
                    for ($i = 0; $i < count($select); $i++) {
                        $id = $select[$i];
                        $jobData['status'] = 1;
                        $jobData['closed_date'] = date("Y-m-d H:i:s");
                        $jobData['closed_by'] = $this->user;
                        $this->admin_model->addToLoggerUpdate('job', 65, 'id', $id, 0, 0, $this->user);
                        if ($this->db->update('job', $jobData, array('id' => $id))) {
                        } else {
                            $error = "Failed To Close Job : " . $id . " ...";
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                        }
                    }

                    $true = "Job Closed Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                } else {
                    $error = "Failed To Close Job ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                }
            } else {
                $error = "PO Already Exist, Please choose another project ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            }
        } else {
            $error = "No Job Selected Failed To Close Job ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
        }
    }

    public function reopenJob()
    {
        $job = base64_decode($_GET['t']);
        $po = base64_decode($_GET['p']);
        $poData = $this->projects_model->getJobPoData($po);
        if ($poData->verified != 1) {
            $jobData['status'] = 0;
            $jobData['po'] = null;
            $this->admin_model->addToLoggerUpdate('job', 65, 'id', $job, 0, 0, $this->user);
            if ($this->db->update('job', $jobData, array('id' => $job))) {
                $this->admin_model->addToLoggerDelete('po', 65, 'id', $po, 0, 0, $this->user);
                $true = "Job Re-opened Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Re-open  Job : " . $job . " ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Can't Reopen this job : " . $job . " ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function reopenJob_newPo()
    {
        $job = base64_decode($_GET['t']);
        $po = base64_decode($_GET['p']);
        $poData = $this->projects_model->getJobPoData($po);
        if ($poData->verified != 1) {
            $jobData['status'] = 0;
            $jobData['po'] = null;
            $this->admin_model->addToLoggerUpdate('job', 65, 'id', $job, 0, 0, $this->user);
            if ($this->db->update('job', $jobData, array('id' => $job))) {
                // $this->admin_model->addToLoggerDelete('po',65,'id',$po,0,0,$this->user);
                //  $this->db->delete('po',array('id'=>$po));
                $true = "Job Re-opened Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Re-open  Job : " . $job . " ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Can't Reopen this job : " . $job . " ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function editTask()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['task'] = base64_decode($_GET['t']);
            $data['job'] = base64_decode($_GET['j']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $row = $data['row'] = $this->projects_model->getTaskData($data['task']);
            if ($row->status == 0 || $row->status == 4 || $row->status == 3) {
                // //Pages ..
                $this->load->view('includes/header.php', $data);
                $this->load->view('projectManagment/editTask.php');
                $this->load->view('includes/footer.php');
            } else {
                echo "You Can't Edit this Task ";
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditTask()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $task_id = base64_decode($_POST['task_id']);
            $data['job_id'] = base64_decode($_POST['job_id']);
            $project_id = $this->db->get_where('job', array('id' => $data['job_id']))->row()->project_id;
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['vendor'] = $_POST['vendor'];
            $select = $_POST['select'];
            $data['rate'] = $_POST['rate_' . $select];
            $data['currency'] = $_POST['currency_' . $select];
            $data['unit'] = $_POST['unit_' . $select];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['time_zone'] = $_POST['time_zone'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
             // checkProjectProfitPercentageForTasks    
            $data['created_at'] =  $this->projects_model->getTaskData($task_id)->created_at;
            $checkPer = $this->projects_model->checkProjectProfitPercentageForTasks($project_id,1,$task_id,$data);
            if($checkPer == True ){ 
                if ($_FILES['file']['size'] != 0) {
                    //$config['file']['upload_path']          = './assets/uploads/vendors/';
                    $config['file']['upload_path'] = './assets/uploads/taskFile/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 10000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }
                // new if task rejected & edit -> resend job portal = 1
                $task_data = $this->db->get_where('job_task', array('id' => $task_id))->row();
                $old_status = $task_data->status;
                if (($task_data->status == 3 || $task_data->status == 0) && $task_data->job_portal == 1) {
                    // update status to waiting vendor acceptance & send new task email to vendor
                    $data['status'] = 4;
                }
                $this->admin_model->addToLoggerUpdate('job_task', 70, 'id', $task_id, 0, 0, $this->user);
                if ($this->db->update('job_task', $data, array('id' => $task_id))) {
                    if ($old_status == 3 && $task_data->job_portal == 1) {
                        // task log
                        $this->projects_model->addToTaskLogger($task_id, 5);
                        $this->projects_model->sendVendorTaskMailVendorModule($task_id, $this->user, $this->brand);
                    } else {
                        $this->projects_model->addToTaskLogger($task_id, 7);
                        $this->projects_model->sendVendorTaskMailVendorModule($task_id, $this->user, $this->brand, 1);
                        //$this->projects_model->sendVendorUpdateTaskMail($task_id,$this->user,$this->brand);
                    }
                    $true = "Task Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $error = "Failed To Edit Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                }
            }
                $error = "Failed To Edit Task ...<br/>Project Profit Percentage < Minimum Profit Percentage";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteTask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $job = base64_decode($_GET['j']);
            $project_id = $this->db->get_where('job', array('id' => $job))->row()->project_id;
            $this->admin_model->addToLoggerDelete('job_task', 69, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('job_task', array('id' => $id))) {
                // vendor
                $this->db->delete('task_evaluation', array('task_id' => $id));
                $block_setup = $this->projects_model->VendorBlockSetup($this->brand);
                $vendor_count = $this->db->get_where('task_evaluation', array('vendor_id' => $_POST['vendor_id'], 'pm_ev_type' => 2))->num_rows();
                $dataVendor['ev_block_count'] = $vendor_count;
                $dataVendor['ev_block'] = ($vendor_count >= $block_setup) ? 1 : 0;
                $this->db->update('vendor', $dataVendor, array('id' => $_POST['vendor_id']));
                // end vendor

                $true = "Task Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            } else {
                $error = "Failed To Delete Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function cancelTask()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 89);
        if ($check) {
            $jobId = base64_decode($_GET['j']);
            $taskId = base64_decode($_GET['t']);
            $project_id = $this->db->get_where('job', array('id' => $jobId))->row()->project_id;
            $this->admin_model->addToLoggerUpdate('job_task', 89, 'id', $taskId, 0, 0, $this->user);
            if ($this->db->update('job_task', array('status' => '2'), array('id' => $taskId))) {
                $this->projects_model->sendVendorCancelTaskMail($taskId, $this->user, $this->brand);
                $true = "Task Canceled Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addTranslationTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addTranslationTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddTranslationTask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $project_id = $this->db->get_where('job', array('id' => $data['job_id']))->row()->project_id;
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/translationRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            if (!empty($_POST['start_after'])) {
                $data['start_after_id'] = substr(strstr($_POST['start_after'], '//'), 2);
                $data['start_after_type'] = strstr($_POST['start_after'], '//', true);
                $data['status'] = 6;
            } 
            // checkSingleTaskPercentage            
            
            $checkTaskCost = $this->projects_model->getTaskCost(2,$data);
            $check = $this->projects_model->checkSingleTaskPercentage($project_id,2,$data);
            if($check == True && $checkTaskCost > 0){
                if ($this->db->insert('translation_request', $data)) {
                    $inserted_id = $this->db->insert_id();               
                      if ($data['status'] == 1)
                          $this->projects_model->sendTranslationRequestMail($inserted_id);
                        $true = "Task Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                       redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $error = "Failed To Add Task ...";
                    $this->session->set_flashdata('error', $error);  
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                }
            }else{
                if($checkTaskCost == 0){
                    $msg = $this->projects_model->checkTaskCostError(2,$data);
                    $error = "Failed To Add Task <br/>$msg";
                }else{
                    $error = "Failed To Add Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                }

                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
            }
           
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function translationTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $taskId = base64_decode($_GET['t']);
            $data['response'] = $this->db->get_where('translation_response', array('request' => $taskId))->result();
            $data['history'] = $this->db->get_where('translation_history', array('request' => $taskId))->result();
            $data['task'] = $this->db->get_where('translation_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);

            // //Pages ..            
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/translationTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function cancelTranslationRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_GET['t']);
            $taskData = $this->db->get_where('translation_request', array('id' => $task))->row();
            if ($taskData->status == 1 || $taskData->status == 5 || $taskData->status == 6) {
                $data['status'] = 4;
                $this->admin_model->addToLoggerUpdate('translation_request', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('translation_request', $data, array('id' => $task))) {
                    $this->projects_model->sendTranslationCancelRequestMail($task);
                    $true = "Task Cancelled Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $error = "Failed To Cancel Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewOffer()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['task'] = base64_decode($_GET['t']);
            $data['job'] = base64_decode($_GET['j']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['row'] = $this->db->get_where('job_offer_list', array('id' => $data['task']))->row();
            $data['vendor_list'] = explode(', ', $data['row']->vendor_list);
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/viewOffer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function pmDirectConfirm()
    {

        $response = 1;
        $task = base64_decode($_GET['task_id']);

        // status delivered
        $data['status'] = 1;
        $data['closed_date'] = date("Y-m-d H:i:s");
        $data['closed_by'] = $this->user;
        $this->admin_model->addToLoggerUpdate('job_task', 69, 'id', $task, 0, 0, $this->user);
        if ($this->db->update('job_task', $data, array('id' => $task))) {
            $this->projects_model->sendVendorResponseMail($task, $this->brand, $response);
            // task log                
            $this->projects_model->addToTaskLogger($task, 4);
            // for check order tasks 
            $taskData = $this->projects_model->getTaskData($task);
            $this->projects_model->CheckCloseRelatedTasks($taskData->job_id, $task, "Vendor");
            //end order tasks check
            $true = "Task Confirmed Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "There's Something Wrong , Please try Again !!";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function pmConfirm()
    {

        $data['reject_reason'] = $_POST['reason'];
        $response = $_POST['response'];
        $job_status = $_POST['job_status'];
        $task = base64_decode($_POST['task_id']);


        if ($response == 0) {
            // reopen the task
            $this->db->update('job_task', $data, array('id' => $task));
            $this->projects_model->sendVendorResponseMail($task, $this->brand, $response);

            // task log
            $this->projects_model->addToTaskLogger($task, 5, $data['reject_reason']);

            redirect("projectManagment/reopenTask?t=" . base64_encode($task) . "&p=$job_status");
        } else {
            // status delivered
            $data['status'] = 1;
            $data['closed_date'] = date("Y-m-d H:i:s");
            $data['closed_by'] = $this->user;
            $this->admin_model->addToLoggerUpdate('job_task', 69, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('job_task', $data, array('id' => $task))) {
                $this->projects_model->sendVendorResponseMail($task, $this->brand, $response);

                // task log                
                $this->projects_model->addToTaskLogger($task, 4);
                // for check order tasks 
                $taskData = $this->projects_model->getTaskData($task);
                $this->projects_model->CheckCloseRelatedTasks($taskData->job_id, $task, "Vendor");
                //end order tasks check
                $true = "Task Confirmed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "There's Something Wrong , Please try Again !!";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function viewTask()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['task'] = base64_decode($_GET['t']);
            $data['job'] = base64_decode($_GET['j']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['row'] = $this->projects_model->getTaskData($data['task']);
            $data['timeline'] = $this->db->get_where('job_task_conversation', array('task' => $data['task']))->result();
            $data['jobHisory'] = $this->db->get_where('job_task_log', array('task' => $data['task']))->result();
            $data['rate'] = $this->db->get_where('task_feedback', array('task_id' => $data['task']))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/viewTask.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function cancelOffer()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 89);
        if ($check) {
            $taskId = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerUpdate('job_offer_list', 89, 'id', $taskId, 0, 0, $this->user);
            if ($this->db->update('job_offer_list', array('status' => '2'), array('id' => $taskId))) {
                $this->projects_model->sendVendorListCancelTaskMail($taskId, $this->user, $this->brand);
                $true = "Task Canceled Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLeTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/addLeTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddLeTask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $project_id = $this->db->get_where('job', array('id' => $data['job_id']))->row()->project_id;
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['complexicty'] = $_POST['complexicty'];
            $data['complexicty_value'] = $this->projects_model->getLeComplexictyValue($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['rate'] = $this->projects_model->calculateLeRequestRate($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            if (!empty($_POST['start_after'])) {
                $data['start_after_id'] = substr(strstr($_POST['start_after'], '//'), 2);
                $data['start_after_type'] = strstr($_POST['start_after'], '//', true);
                $data['status'] = 6;
            }
            // checkSingleTaskPercentage
            $checkTaskCost = $this->projects_model->getTaskCost(3,$data);
            $check = $this->projects_model->checkSingleTaskPercentage($project_id,3,$data);
            if($check == True && $checkTaskCost > 0){
                if ($this->db->insert('le_request', $data)) {
                $inserted_id = $this->db->insert_id();                
                if ($data['status'] == 1)
                     $this->projects_model->sendLERequestMail($inserted_id);
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                 redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                          
                } else {
                    $error = "Failed To Add Task ...";
                    $this->session->set_flashdata('error', $error);           
                     redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                }
            }else{ 
                if($checkTaskCost == 0){
                    $msg = $this->projects_model->checkTaskCostError(3,$data);
                    $error = "Failed To Add Task <br/>$msg";
                }else{
                    $error = "Failed To Add Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                }
                $this->session->set_flashdata('error', $error);
                 redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
              } 
           
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function dtpRequest()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 69);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
            //body ..
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/dtpRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddDTPRequest()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $project_id = $this->db->get_where('job', array('id' => $data['job_id']))->row()->project_id;
            $data['task_name'] = $_POST['task_name'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['source_direction'] = $_POST['source_direction'];
            $data['target_direction'] = $_POST['target_direction'];
            $data['source_application'] = $_POST['source_application'];
            $data['target_application'] = $_POST['target_application'];
            $data['translation_in'] = $_POST['translation_in'];
            $data['rate'] = $_POST['rate'];
            $data['status'] = 1;
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['assigned_to'] = $_POST['assigned_to'];

            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/dtpRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            if (!empty($_POST['start_after'])) {
                $data['start_after_id'] = substr(strstr($_POST['start_after'], '//'), 2);
                $data['start_after_type'] = strstr($_POST['start_after'], '//', true);
                $data['status'] = 6;
            }
             // checkSingleTaskPercentage
             $checkTaskCost = $this->projects_model->getTaskCost(4,$data);
            $check = $this->projects_model->checkSingleTaskPercentage($project_id,4,$data);
            if($check == True && $checkTaskCost > 0){
                 if ($this->db->insert('dtp_request', $data)) {
                    $inserted_id = $this->db->insert_id();
                   $check = $this->projects_model->checkProjectProfitPercentage($project_id);                  
                       if ($data['status'] == 1)
                           $this->projects_model->sendDTPRequestMail($this->db->insert_id());
                       $true = "Task Added Successfully ...";
                       $this->session->set_flashdata('true', $true);
                       redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                } else {
                    $error = "Failed To Add Task ...";
                    $this->session->set_flashdata('error', $error);      
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
                }
            }else{ 
                 if($checkTaskCost == 0){
                    $msg = $this->projects_model->checkTaskCostError(4,$data);
                    $error = "Failed To Add Task <br/>$msg";
                }else{
                    $error = "Failed To Add Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                }
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
              }           
            
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function test_close()
    {
        $data['request'] = base64_decode($_GET['id']);
        $data['type'] = ($_GET['type']);
        if ($data['type'] == "translation") {
            $taskData = $this->db->get_where('translation_request', array('id' => $data['request']))->row();
        } elseif ($data['type'] == "le") {
            $taskData = $this->db->get_where('le_request', array('id' => $data['request']))->row();
        } elseif ($data['type'] == "vendor") {
            $taskData = $this->projects_model->getTaskData($data['request']);
        }
        $this->projects_model->CheckCloseRelatedTasks($taskData->job_id, $data['request'], $data['type']);
        //end order tasks check
    }

    public function addPoNumber()
    {

        $poData['number'] = trim($_POST['po']);
        $poData['verified'] = 0;
        $poData['created_at'] = date("Y-m-d H:i:s");
        $poData['created_by'] = $this->user;
        $projectData = $this->db->get_where('project', array('id' => base64_decode($_POST['project_id'])))->row();
        $poData['customer'] = $projectData->customer;
        $poData['lead'] = $projectData->lead;
        $poData['total_amount'] = $_POST['total_amount'];
        // check if po exists
        $checkPo = $this->projects_model->checkPoExists($poData['number']);
        if ($checkPo) {
            if ($_FILES['cpo_file']['size'] != 0) {
                $config['cpo_file']['upload_path'] = './assets/uploads/cpo/';
                // $config['cpo_file']['upload_path']          = './assets/uploads/cpo/';
                $config['cpo_file']['encrypt_name'] = TRUE;
                $config['cpo_file']['allowed_types'] = 'zip|rar';
                $config['cpo_file']['max_size'] = 500000;
                $config['cpo_file']['max_width'] = 1024;
                $config['cpo_file']['max_height'] = 768;
                $this->load->library('upload', $config['cpo_file'], 'file_upload');
                if (!$this->file_upload->do_upload('cpo_file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $poData['cpo_file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('po', $poData)) {

                $true = "Po Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            } else {
                $error = "Failed To Add po ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            }
        } else {
            $error = "PO Already Exist, Please Check ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
        }
    }

    public function closeJobNew()
    {
        if (isset($_POST['select'])) {
            $select = $_POST['select'];
            $poId = $_POST['po'];
            $jobIds = implode(",", $_POST['select']);
            // check total po & jobs selected
            $checkPo = $this->projects_model->checkPoTotal($poId, $jobIds);
            if ($checkPo) {
                $jobData['po'] = $poId;
                for ($i = 0; $i < count($select); $i++) {
                    $id = $select[$i];
                    $jobData['status'] = 1;
                    $jobData['closed_date'] = date("Y-m-d H:i:s");
                    $jobData['closed_by'] = $this->user;
                    $this->admin_model->addToLoggerUpdate('job', 65, 'id', $id, 0, 0, $this->user);
                    if ($this->db->update('job', $jobData, array('id' => $id))) {
                    } else {
                        $error = "Failed To Close Job : " . $id . " ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
                    }
                }

                $true = "Job Closed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            } else {
                $error = "Jobs Total Revenue > PO Amount,Please Check ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
            }
        } else {
            $error = "Failed To Close Job ,Please select job ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "ProjectManagment/projectJobs?t=" . $_POST['project_id']);
        }
    }

    public function editTranslationTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['j']);
            $task = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['task'] = $this->db->get_where('translation_request', array('id' => $task))->row();
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/editTranslationTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditTranslationTask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_POST['task']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
            $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            // checkProjectProfitPercentageForTasks
            $data['created_at'] =  $this->db->get_where('translation_request', array('id' => $task))->row()->created_at;
            $project_id = $this->projects_model->getJobData(base64_decode($_POST['job_id']))->project_id;
            $checkPer = $this->projects_model->checkProjectProfitPercentageForTasks($project_id,2,$task,$data);
            if($checkPer == True ){  
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/translationRequest/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 10000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projectManagment/jobTasks?t=" . $_POST['job_id']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }

                $this->admin_model->addToLoggerUpdate('translation_request', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('translation_request', $data, array('id' => $task))) {
                    $this->projects_model->sendTranslationRequestMail($task);
                    $true = "Task Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $error = "Failed To Update Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/jobTasks?t=" . $_POST['job_id']);
                }
            }  else {
                 $error = "Failed To Update Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/jobTasks?t=" . $_POST['job_id']);
                }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function jobTasks()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 69);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
            //body ..
            $data['job'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['task'] = $this->projects_model->jobTasks($data['permission'], $this->user, $data['job']);
            $data['dtp_request'] = $this->db->get_where('dtp_request', array('job_id' => $data['job']));
            $data['translation_request'] = $this->db->get_where('translation_request', array('job_id' => $data['job']));
            $data['le_request'] = $this->db->get_where('le_request', array('job_id' => $data['job']));
            $data['project_comission'] = $this->db->get_where('project_comission', array('job_id' => $data['job']));
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/jobTasks.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function reopenTask()
    {
        $task = base64_decode($_GET['t']);
        $jobStatus = base64_decode($_GET['p']);
        if ($jobStatus == 0) {
            $data['status'] = 0;
            $this->admin_model->addToLoggerUpdate('job_task', 69, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('job_task', $data, array('id' => $task))) {
                $true = "Task Re-opened Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "There's Something Wrong , Please try Again !!";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Can't Reopen this Task ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function pmDirectConfirmExternalLink()
    {
        $check = $this->admin_model->checkPermission($this->role, 70);
        $task = base64_decode($_GET['task_id']);
        $row = $this->projects_model->getTaskData($task);
        if ($check) {
            if ($row->status == 5) {
                $response = 1;
                // status delivered
                $data['status'] = 1;
                $data['closed_date'] = date("Y-m-d H:i:s");
                $data['closed_by'] = $this->user;
                $this->admin_model->addToLoggerUpdate('job_task', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('job_task', $data, array('id' => $task))) {
                    $this->projects_model->sendVendorResponseMail($task, $this->brand, $response);
                    // task log                
                    $this->projects_model->addToTaskLogger($task, 4);
                    $true = "Task Confirmed Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment");
                } else {
                    $error = "There's Something Wrong , Please try Again !!";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment");
                }
            } else {
                $error = "Error , Task Already Confirmed , please check first ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectManagment");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 39);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 39);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['pm'] = $this->user;
            $data['row'] = $this->db->get_Where('project', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/editProject.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 39);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['name'] = $_POST['name'];
            $data['product_line'] = $_POST['product_line'];
            $data['code'] = $this->projects_model->updateProjectCode($data['lead'], $id, $this->user);
            $this->admin_model->addToLoggerUpdate('project', 39, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('project', $data, array('id' => $id))) {
                $true = "Project Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projectManagment");
                }
            } else {
                $error = "Failed To Edit Project ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projectManagment");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    
    public function editProjectPercentage()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 39);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 39);
            //body ..
            $data['id'] = base64_decode($_GET['t']); 
             $data['pm'] = $this->user;
            $data['row'] = $this->db->get_Where('project', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projectManagment/editProjectPercentage.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    
    public function doEditProjectPercentage()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 39);
        $project_id = $_POST['project_id'];
        $id = base64_decode($_POST['project_id']);
        $managerCheck = $this->projects_model->checkManagerAccess($id);
       if ($check && $managerCheck) {    
            $currPer = $this->projects_model->getProjectProfitPercentage($id);
            if($currPer < $_POST['min_profit_percentage']){
                $error = "Failed To Edit Data...<br/>Current Percentage less than ". $_POST['min_profit_percentage']." %";
                $this->session->set_flashdata('error', $error);
                 redirect(base_url() . "projectManagment/projectJobs?t=" .$project_id);
            }else{
               // min_profit_percentage
            $data['min_profit_percentage'] =  $_POST['min_profit_percentage'];
            $data['approval_by'] = $this->user;
            $data['approval_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('project', 39, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('project', $data, array('id' => $id))) {
                $true = "Project Edited Successfully ...";
                $this->session->set_flashdata('true', $true);                
                redirect(base_url() . "projectManagment/projectJobs?t=" .$project_id);
                
            } else {
                $error = "Failed To Edit Project ...";
                $this->session->set_flashdata('error', $error);
                 redirect(base_url() . "projectManagment/projectJobs?t=" .$project_id);
            } 
            }
            
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteProject()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 204);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('project', 40, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('project', array('id' => $id))) {
                $true = "Project Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Project ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // not checked 
    public function saveProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 38);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 38);
            //body ..
            $data['pm'] = $this->user;
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_opportunity', array('id' => $id))->row();
            $data['job'] = $this->db->get_where('job', array('opportunity' => $data['row']->id))->result();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/saveProject.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doSaveProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 38);
        if ($check) {
            if (isset($_POST['submit'])) {
                $row = $this->db->get_where('sales_opportunity', array('id' => $_POST['id']))->row();
                $project['lead'] = $row->lead;
                $project['customer'] = $row->customer;
                $project['name'] = $row->project_name;
                $project['product_line'] = $row->product_line;
                $project['code'] = $this->projects_model->generateProjectCode($project['lead'], $this->user);
                $project['created_by'] = $this->user;
                $project['created_at'] = date("Y-m-d H:i:s");
                $project['opportunity'] = $row->id;
                // min_profit_percentage
                $project['min_profit_percentage'] = $this->projects_model->getProfitPercentageSetup($this->brand);
            
                $opportunity['saved'] = 1;
                if ($this->db->insert('project', $project)) {
                    $job_data['project_id'] = $this->db->insert_id();

                    $this->admin_model->addToLoggerUpdate('sales_opportunity', 38, 'id', $project['opportunity'], 0, 0, $this->user);
                    $this->db->update('sales_opportunity', $opportunity, array('id' => $project['opportunity']));

                    $jobs = $this->db->get_where('job', array('opportunity' => $_POST['id']))->result();
                    foreach ($jobs as $job) {
                        $job_data['created_by'] = $this->user;
                        $jobPrice = $this->db->get_where('job_price_list', array('id' => $job->price_list))->row();
                        $job_data['code'] = $this->projects_model->updateJobCode($job_data['project_id'], $jobPrice->price_list_id, $job->id);
                        $this->db->update('job', $job_data, array('id' => $job->id));
                    }

                    $true = "Project Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects");
                } else {
                    $error = "Failed To Add Project ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects");
                }
            } elseif (isset($_POST['reject'])) {
                $data['reject_reason'] = $_POST['reject_reason'];
                $data['saved'] = 2;
                $data['assigned'] = 0;
                $opportunity = $_POST['id'];
                $this->admin_model->addToLoggerUpdate('sales_opportunity', 38, 'id', $opportunity, 0, 0, $this->user);
                if ($this->db->update('sales_opportunity', $data, array('id' => $opportunity))) {
                    $this->projects_model->sendRejectMail($data, $this->user, $opportunity);
                    $true = "Project Rejected Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects");
                } else {
                    $error = "Failed To Reject Project ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function closeTask()
    {
        $id = base64_decode($_POST['id']);
        $data['status'] = $_POST['status'];
        $data['closed_date'] = date("Y-m-d H:i:s");
        $data['closed_by'] = $this->user;
        // vendorTaskFile
        if ($_FILES['vendor_task_file']['size'] != 0) {
            //$config['vendor_task_file']['upload_path']          = './assets/uploads/vendorTaskFile/';
            $config['vendor_task_file']['upload_path'] = './assets/uploads/vendorTaskFile/';
            $config['vendor_task_file']['encrypt_name'] = TRUE;
            $config['vendor_task_file']['allowed_types'] = 'zip|rar';
            $config['vendor_task_file']['max_size'] = 500000;
            $config['vendor_task_file']['max_width'] = 1024;
            $config['vendor_task_file']['max_height'] = 768;
            $this->load->library('upload', $config['vendor_task_file'], 'file_upload');
            if (!$this->file_upload->do_upload('vendor_task_file')) {
                $error = $this->file_upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/taskPage?t=" . $_POST['id']);
            } else {
                $data_file = $this->file_upload->data();
                $data['vendor_task_file'] = $data_file['file_name'];
            }
        } else {
            $error = "Please upload vendor task file ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "projects/taskPage?t=" . $_POST['id']);
        }
        $this->admin_model->addToLoggerUpdate('job_task', 69, 'id', $id, 0, 0, $this->user);
        $task = $this->db->get_where('job_task', array('id' => $id))->row();
        if ($this->db->update('job_task', $data, array('id' => $id))) {
            $total = $task->rate * $task->count;
            if ($total > 0) {
                $this->projects_model->sendVPOMail($id, $this->user, $this->brand);
            }
            $true = "Task Status Changed Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "projects/taskPage?t=" . $_POST['id']);
        } else {
            $error = "Failed To Change Task Status ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "projects/taskPage?t=" . $_POST['id']);
        }
    }


    public function addCommission()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/addCommission.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCommission()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $data['commission'] = $_POST['commission'];
            $data['volume'] = $_POST['volume'];
            $data['rate'] = $_POST['rate'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('project_comission', $data)) {
                $true = "Commission Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Commission ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCommission()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('project_comission', array('id' => $id))->row();
            $data['job_data'] = $this->projects_model->getJobData($data['row']->job_id);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/editCommission.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCommission()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['commission'] = $_POST['commission'];
            $data['volume'] = $_POST['volume'];
            $data['rate'] = $_POST['rate'];

            $this->admin_model->addToLoggerUpdate('project_comission', 70, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('project_comission', $data, array('id' => $id))) {
                $true = "Commission Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Edit Commission ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getCommissionEmail()
    {
        $id = $_POST['commission'];
        $email = $this->db->get_where('commission', array('id' => $id))->row()->email;
        echo $email;
    }

    public function getCommissionRate()
    {
        $id = $_POST['commission'];
        $rate = $this->db->get_where('commission', array('id' => $id))->row()->rate;
        echo $rate;
    }


    public function closeProject()
    {
        $id = base64_decode($_POST['id']);
        $data['po'] = $_POST['po'];
        $data['status'] = $_POST['status'];
        $data['verified'] = 0;
        $data['closed_date'] = date("Y-m-d H:i:s");
        $data['closed_by'] = $this->user;
        $check = $this->projects_model->checkCloseProject($id);
        if ($check) {
            $checkPO = $this->projects_model->checkProjectPo($data['po'], $id);
            if ($checkPO) {
                if ($_FILES['cpo_file']['size'] != 0) {
                    //$config['cpo_file']['upload_path']          = './assets/uploads/vendors/';
                    $config['cpo_file']['upload_path'] = './assets/uploads/cpo/';
                    $config['cpo_file']['encrypt_name'] = TRUE;
                    $config['cpo_file']['allowed_types'] = 'zip|rar';
                    $config['cpo_file']['max_size'] = 500000;
                    $config['cpo_file']['max_width'] = 1024;
                    $config['cpo_file']['max_height'] = 768;
                    $this->load->library('upload', $config['cpo_file'], 'file_upload');
                    if (!$this->file_upload->do_upload('cpo_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/projectJobs?t=" . $_POST['id']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['cpo_file'] = $data_file['file_name'];
                    }
                }

                $this->admin_model->addToLoggerUpdate('project', 65, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('project', $data, array('id' => $id))) {
                    $true = "Project Closed Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/projectJobs?t=" . $_POST['id']);
                } else {
                    $error = "Failed To Close Project ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/projectJobs?t=" . $_POST['id']);
                }
            } else {
                $error = "Please Check PO Number Is Already Exists In Another Project ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/projectJobs?t=" . $_POST['id']);
            }
        } else {
            $error = "Please Close All Jobs First ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "projects/projectJobs?t=" . $_POST['id']);
        }
    }

    public function taskPage()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 73);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 73);
            //body ..
            $data['task'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['task_data'] = $this->projects_model->getTaskData($data['task']);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/taskPage.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function checkProjectPo()
    {
        $po = $_POST['po'];
        $select = $_POST['select'];
        $checkPO = $this->projects_model->checkProjectPo($po, $select);
        if ($checkPO) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function allJobs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 84);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 84);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
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
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['source'])) {
                    $source = $_REQUEST['source'];
                    if (!empty($source)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source = "";
                }
                if (isset($_REQUEST['target'])) {
                    $target = $_REQUEST['target'];
                    if (!empty($target)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        if ($status == 2) {
                            $status = 0;
                        }
                        array_push($arr2, 6);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 8);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "j.code LIKE '%$code%'";
                $cond2 = "l.product_line LIKE '%$product_line%'";
                $cond3 = "p.customer = '$customer'";
                $cond4 = "l.service = '$service'";
                $cond5 = "l.source = '$source'";
                $cond6 = "l.target = '$target'";
                $cond7 = "j.status = '$status'";
                $cond8 = "j.created_by = '$created_by'";
                $cond9 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->allJobs($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['job'] = $this->projects_model->allJobsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->allJobs($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/allJobs');
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

                $data['job'] = $this->projects_model->allJobsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/allJobs.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function newAllJobs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 84);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 84);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
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
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['source'])) {
                    $source = $_REQUEST['source'];
                    if (!empty($source)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source = "";
                }
                if (isset($_REQUEST['target'])) {
                    $target = $_REQUEST['target'];
                    if (!empty($target)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        if ($status == 2) {
                            $status = 0;
                        }
                        array_push($arr2, 6);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 8);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "j.code LIKE '%$code%'";
                $cond2 = "l.product_line LIKE '%$product_line%'";
                $cond3 = "p.customer = '$customer'";
                $cond4 = "l.service = '$service'";
                $cond5 = "l.source = '$source'";
                $cond6 = "l.target = '$target'";
                $cond7 = "j.status = '$status'";
                $cond8 = "j.created_by = '$created_by'";
                $cond9 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->allJobs($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['job'] = $this->projects_model->allJobsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->allJobs($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/allJobs');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
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

                $data['job'] = $this->projects_model->allJobsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/allJobs.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function allTasks()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 85);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 85);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
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
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        if ($status == 3) {
                            $status = 0;
                        }
                        array_push($arr2, 3);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['source'])) {
                    $source = $_REQUEST['source'];
                    if (!empty($source)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source = "";
                }
                if (isset($_REQUEST['target'])) {
                    $target = $_REQUEST['target'];
                    if (!empty($target)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 7);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "j.code LIKE '%$code%'";
                $cond2 = "j.vendor = '$vendor'";
                $cond3 = "j.task_type = '$task_type'";
                $cond4 = "j.status = '$status'";
                $cond5 = "l.source = '$source'";
                $cond6 = "l.target = '$target'";
                $cond7 = "j.created_by = '$created_by'";
                $cond8 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->projects_model->AllTasks($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['task'] = $this->projects_model->AllTasksPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllTasks($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/AllTasks');
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

                $data['task'] = $this->projects_model->AllTasksPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/AllTasks.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function allTickets()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 88);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 88);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['request_type'])) {
                    $request_type = $_REQUEST['request_type'];
                    if (!empty($request_type)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $request_type = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                // print_r($arr2);
                $cond1 = "request_type = '$request_type'";
                $cond2 = "service = '$service'";
                $cond3 = "status = '$status'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewPmAllTickets($data['permission'], $data['brand'], $arr4, $this->user);
                } else {
                    $data['ticket'] = $this->vendor_model->viewPmAllTickets($data['permission'], $data['brand'], 1, $this->user);
                }
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->viewPmAllTickets($data['permission'], $data['brand'], 1, $this->user)->num_rows();
                $config['base_url'] = base_url('projects/allTickets');
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

                $data['ticket'] = $this->vendor_model->viewPmAllTicketsPages($data['permission'], $data['brand'], $this->user, $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/allTickets.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function productionSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 94);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 94);
            //body ..
            $brand = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                } else {
                    $date_from = "";
                }
                if (isset($_REQUEST['date_to'])) {
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                } else {
                    $date_to = "";
                }
                if (!empty($_REQUEST['created_by'])) {
                    $created_by = "p.created_by = " . $_REQUEST['created_by'];
                } else {
                    $created_by = 1;
                }
                if ($data['permission']->view == 1) {
                    $data['project'] = $this->db->query(" SELECT *,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p WHERE p.created_at BETWEEN '$date_from' AND '$date_to' AND " . $created_by . " HAVING brand = '$brand' ORDER BY p.created_at DESC ");
                } elseif ($data['permission']->view == 2) {
                    $data['project'] = $this->db->query(" SELECT *,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p WHERE p.created_at BETWEEN '$date_from' AND '$date_to' AND p.created_by = '$this->user' HAVING brand = '$brand' ORDER BY p.created_at DESC ");
                }
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/productionSheet.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportProductionSheet()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=production_sheet.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 94);
        $brand = $this->brand;
        $arr2 = array();

        if (!empty($_REQUEST['date_to']) && !empty($_REQUEST['date_from'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            $dateQuery = " j.created_at BETWEEN '" . $date_from . "' AND '" . $date_to . "' ";
        } else {
            $date_to = "";
            $date_from = "";
            $dateQuery = 1;
        }
        if (!empty($_REQUEST['closed_date_to']) && !empty($_REQUEST['closed_date_from'])) {
            $closed_date_from = date("Y-m-d", strtotime($_REQUEST['closed_date_from']));
            $closed_date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['closed_date_to'])));
            $closedDateQuery = "j.status = '1' AND j.closed_date BETWEEN '" . $closed_date_from . "' AND '" . $closed_date_to . "' ";
        } else {
            $closed_date_to = "";
            $closed_date_from = "";
            $closedDateQuery = 1;
        }
        if (isset($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
            if ($status == 2) {
                $statusQuery = "j.status = '0'";
            } elseif ($status == 1) {
                $statusQuery = "j.status = '1'";
            } else {
                $statusQuery = 1;
            }

            // if($closedDateQuery = 1){
            // $statusQuery = 1;
            // }
        } else {
            $statusQuery = 1;
        }
        if (!empty($_REQUEST['created_by'])) {
            $created_by = "j.created_by = " . $_REQUEST['created_by'];
        } else {
            $created_by = 1;
        }
        if ($data['permission']->view == 1) {
            // echo " SELECT p.code AS p_code,p.customer,p.lead,p.product_line,p.created_by AS p_createdBy,p.created_at AS p_createdAt,j.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p LEFT OUTER JOIN job AS j ON j.project_id = p.id WHERE ".$statusQuery." AND ".$closedDateQuery." AND ".$dateQuery." AND ".$created_by." HAVING brand = '$brand' ORDER BY j.closed_date DESC ";
            $data['project'] = $this->db->query(" SELECT p.code AS p_code,p.customer,p.lead,p.product_line,p.created_by AS p_createdBy,p.created_at AS p_createdAt,j.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p LEFT OUTER JOIN job AS j ON j.project_id = p.id WHERE " . $statusQuery . " AND " . $closedDateQuery . " AND " . $dateQuery . " AND " . $created_by . " HAVING brand = '$brand' ORDER BY j.closed_date DESC ");
        } elseif ($data['permission']->view == 2) {
            // echo " SELECT p.code AS p_code,p.customer,p.lead,p.product_line,p.created_by AS p_createdBy,p.created_at AS p_createdAt,j.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p LEFT OUTER JOIN job AS j ON j.project_id = p.id WHERE ".$statusQuery." AND ".$closedDateQuery." AND ".$dateQuery." AND j.created_by = '$this->user' HAVING brand = '$brand' ORDER BY j.closed_date DESC ";
            $data['project'] = $this->db->query(" SELECT p.code AS p_code,p.customer,p.lead,p.product_line,p.created_by AS p_createdBy,p.created_at AS p_createdAt,j.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p LEFT OUTER JOIN job AS j ON j.project_id = p.id WHERE " . $statusQuery . " AND " . $closedDateQuery . " AND " . $dateQuery . " AND j.created_by = '$this->user' HAVING brand = '$brand' ORDER BY j.closed_date DESC ");
        }

        $this->load->view('projects/exportProductionSheet.php', $data);
    }

    public function priceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 95);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 95);
            //body ..
            $data['user'] = $this->user;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['source'])) {
                    $source = $_REQUEST['source'];
                    if ($source != '-1') {
                        array_push($arr2, 2);
                    }
                } else {
                    $source = "";
                }
                if (isset($_REQUEST['target'])) {
                    $target = $_REQUEST['target'];
                    if ($target != '-1') {
                        array_push($arr2, 3);
                    }
                } else {
                    $target = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "product_line = '$product_line'";
                $cond2 = "customer = '$customer'";
                $cond3 = "source = '$source'";
                $cond4 = "target = '$target'";
                $cond5 = "service = '$service'";
                $cond6 = "task_type = '$task_type'";
                $cond7 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['priceList'] = $this->customer_model->getAllPriceListPm($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['priceList'] = $this->customer_model->getAllPriceListPagesPm($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->getAllPriceListPm($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/priceList');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
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

                $data['priceList'] = $this->customer_model->getAllPriceListPagesPm($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/priceList.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function customerJobs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 97);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 97);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $data['project'] = $this->projects_model->AllCustomerJobs($data['permission'], $this->user, $this->brand);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/customerJobs.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function lateDeliveryReport()
    {
        $check = $this->admin_model->checkPermission($this->role, 100);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 100);
            //body ..
            $now = date("Y-m-d H:i:s");
            $nowFilter = "delivery_date < '$now'";
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['delivery_date'])) {
                    $delivery_date = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['delivery_date'])));
                    if (!empty($_REQUEST['delivery_date'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $delivery_date = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "delivery_date < '$delivery_date'";
                $cond2 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->lateDeliveryReport($arr4, $this->brand);
                } else {
                    $data['job'] = $this->projects_model->lateDeliveryReport($nowFilter, $this->brand);
                }
            } else {
                $data['job'] = $this->projects_model->lateDeliveryReport($nowFilter, $this->brand);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/lateDeliveryReport.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportLateDeliveryJobs()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=LateDeliveryJobs.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 100);
        //body ..
        $arr2 = array();
        if (isset($_REQUEST['delivery_date'])) {
            $delivery_date = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['delivery_date'])));
            if (!empty($_REQUEST['delivery_date'])) {
                array_push($arr2, 0);
            }
        } else {
            $delivery_date = "";
        }
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 1);
            }
        } else {
            $created_by = "";
        }
        // print_r($arr2);
        $cond1 = "delivery_date < '$delivery_date'";
        $cond2 = "created_by = '$created_by'";
        $arr1 = array($cond1, $cond2);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['job'] = $this->projects_model->lateDeliveryReport($arr4, $this->brand);
        } else {
            $data['job'] = $this->projects_model->lateDeliveryReport(1, $this->brand);
        }
        $this->load->view('projects/exportLateDeliveryJobs.php', $data);
    }

    public function clientAllJobs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 103);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 103);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['source'])) {
                    $source = $_REQUEST['source'];
                    if (!empty($source)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source = "";
                }
                if (isset($_REQUEST['target'])) {
                    $target = $_REQUEST['target'];
                    if (!empty($target)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status) || $status == 0) {
                        array_push($arr2, 6);
                    }
                } else {
                    $status = "";
                }
                // print_r($arr2);
                $cond1 = "j.code LIKE '%$code%'";
                $cond2 = "l.product_line LIKE '%$product_line%'";
                $cond3 = "p.customer = '$customer'";
                $cond4 = "l.service = '$service'";
                $cond5 = "l.source = '$source'";
                $cond6 = "l.target = '$target'";
                $cond7 = "j.status = '$status'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->projects_model->clientAllJobs($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['job'] = $this->projects_model->clientAllJobsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->clientAllJobs($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/clientAllJobs');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
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

                $data['job'] = $this->projects_model->clientAllJobsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/clientAllJobs.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function dTPTask()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
            //body ..
            $data['brand'] = $this->brand;
            $taskId = base64_decode($_GET['t']);
            $data['job'] = base64_decode($_GET['j']);
            $data['task'] = $this->db->get_where('dtp_request', array('id' => $taskId))->row();
            $data['response'] = $this->db->get_where('dtp_response', array('request' => $taskId))->result();
            $data['history'] = $this->db->get_where('dtp_history', array('request' => $taskId))->result();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/dTPTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function dTPTaskNew()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
            //body ..
            $data['brand'] = $this->brand;
            $taskId = base64_decode($_GET['t']);
            $data['job'] = base64_decode($_GET['j']);
            $data['task'] = $this->db->get_where('dtp_request', array('id' => $taskId))->row();
            $data['response'] = $this->db->get_where('dtp_response', array('request' => $taskId))->result();
            $data['history'] = $this->db->get_where('dtp_history', array('request' => $taskId))->result();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            // $this->load->view('includes/header.php',$data);
            // $this->load->view('projects/dTPTask.php');
            // $this->load->view('includes/footer.php'); 
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function reopenDTPTask()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/dtpRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('dtp_history', $data)) {
                $this->admin_model->addToLoggerUpdate('dtp_request', 69, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('dtp_request', array('status' => $data['status']), array('id' => $data['request']));
                $this->projects_model->sendDTPReOpenRequestMail($data['request']);
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

    public function editDTPTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['j']);
            $task = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['task'] = $this->db->get_where('dtp_request', array('id' => $task))->row();
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editDTPTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditDTPTask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_POST['task']);
            $data['task_name'] = $_POST['task_name'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['source_direction'] = $_POST['source_direction'];
            $data['target_direction'] = $_POST['target_direction'];
            $data['source_application'] = $_POST['source_application'];
            $data['target_application'] = $_POST['target_application'];
            $data['translation_in'] = $_POST['translation_in'];
            $data['rate'] = $_POST['rate'];
            $data['status'] = 1;
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
              $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            // checkProjectProfitPercentageForTasks
            $data['created_at'] =  $this->db->get_where('dtp_request', array('id' => $task))->row()->created_at;
            $project_id = $this->projects_model->getJobData(base64_decode($_POST['job_id']))->project_id;
            $checkPer = $this->projects_model->checkProjectProfitPercentageForTasks($project_id,3,$task,$data);
            if($checkPer == True ){ 
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/dtpRequest/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 10000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }

                $this->admin_model->addToLoggerUpdate('dtp_request', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('dtp_request', $data, array('id' => $task))) {
                    $this->projects_model->sendDTPRequestMail($task);
                    $true = "Task Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $error = "Failed To Update Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                } 
            
            }else {
                 $error = "Failed To Update Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/jobTasks?t=" . $_POST['job_id']);
                }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function cancelDTPRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_GET['t']);
            $taskData = $this->db->get_where('dtp_request', array('id' => $task))->row();
            if ($taskData->status == 1 || $taskData->status == 5) {
                $data['status'] = 4;
                $this->admin_model->addToLoggerUpdate('dtp_request', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('dtp_request', $data, array('id' => $task))) {
                    $this->projects_model->sendDTPCancelRequestMail($task);
                    $true = "Task Cancelled Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
                } else {
                    $error = "Failed To Cancel Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
                }
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function reopenTrasnlationTask()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/translationRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('translation_history', $data)) {
                $this->admin_model->addToLoggerUpdate('translation_request', 69, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('translation_request', array('status' => $data['status']), array('id' => $data['request']));
                $this->projects_model->sendTranslationReOpenRequestMail($data['request']);
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


    public function leTask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $taskId = base64_decode($_GET['t']);
            $data['response'] = $this->db->get_where('le_response', array('request' => $taskId))->result();
            $data['history'] = $this->db->get_where('le_history', array('request' => $taskId))->result();
            $data['task'] = $this->db->get_where('le_request', array('id' => $taskId))->row();
            $data['jobData'] = $this->projects_model->getJobData($data['task']->job_id);
            $data['priceListData'] = $this->projects_model->getJobPriceListData($data['jobData']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/leTask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function reopenLETask()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['request'] = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['comment'] = $_POST['comment'];
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('le_history', $data)) {
                $this->admin_model->addToLoggerUpdate('le_request', 69, 'id', $data['request'], 0, 0, $this->user);
                $this->db->update('le_request', array('status' => $data['status']), array('id' => $data['request']));
                $this->projects_model->sendLEReOpenRequestMail($data['request']);
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

    public function editLETask()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['j']);
            $task = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            $data['task'] = $this->db->get_where('le_request', array('id' => $task))->row();
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editLETask.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditLETask()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_POST['task']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['complexicty'] = $_POST['complexicty'];
            $data['complexicty_value'] = $this->projects_model->getLeComplexictyValue($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['rate'] = $this->projects_model->calculateLeRequestRate($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
             $data['work_hours'] = $_POST['work_hours'];
            $data['overtime_hours'] = $_POST['overtime_hours'];
            $data['doublepaid_hours'] = $_POST['doublepaid_hours'];
            $data['created_at'] = $this->db->get_where('le_request', array('id' => $task))->row()->created_at;
            // checkProjectProfitPercentageForTasks
            $data['created_at'] =  $this->db->get_where('le_request', array('id' => $task))->row()->created_at;
            $project_id = $this->projects_model->getJobData(base64_decode($_POST['job_id']))->project_id;
            $checkPer = $this->projects_model->checkProjectProfitPercentageForTasks($project_id,4,$task,$data);
            if($checkPer == True ){  
                 if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            $this->admin_model->addToLoggerUpdate('le_request', 69, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('le_request', $data, array('id' => $task))) {
                $this->projects_model->sendLERequestMail($task);
                $true = "Task Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Update Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            }
        }else {
                 $error = "Failed To Update Task <br/>Project Profit Percentage < Minimum Profit Percentage";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectManagment/jobTasks?t=" . $_POST['job_id']);
                }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function cancelLERequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->edit == 1) {
            $task = base64_decode($_GET['t']);
            $taskData = $this->db->get_where('le_request', array('id' => $task))->row();
            if ($taskData->status == 1 || $taskData->status == 5) {
                $data['status'] = 4;
                $this->admin_model->addToLoggerUpdate('le_request', 69, 'id', $task, 0, 0, $this->user);
                if ($this->db->update('le_request', $data, array('id' => $task))) {
                    $this->projects_model->sendLECancelRequestMail($task);
                    $true = "Task Cancelled Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
                } else {
                    $error = "Failed To Cancel Task ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
                }
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_GET['j']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function salesTickets()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 131);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 131);
            //body ..
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $id = "";
                }
                // print_r($arr2);
                $cond1 = "t.id = '$id'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);      
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewPmSalesTickets($data['permission'], $this->brand, $arr4, $this->user);
                } else {
                    $data['ticket'] = $this->vendor_model->viewPmSalesTicketsPages($data['permission'], $this->brand, $this->user, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->viewPmSalesTickets($data['permission'], $this->brand, $this->brand, 1, $this->user)->num_rows();
                $config['base_url'] = base_url('projects/salesTickets');
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

                $data['ticket'] = $this->vendor_model->viewPmSalesTicketsPages($data['permission'], $this->brand, $this->user, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/salesTickets.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function pmLERequest()
    {
        $check = $this->admin_model->checkPermission($this->role, 144);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 144);
            //body ..
            $data['newTasks'] = $this->projects_model->newLETasks($this->brand);
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
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $subject = "";
                }

                // print_r($arr2);
                $cond1 = "id = '$code'";
                $cond2 = "subject = '$subject'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['le_request'] = $this->projects_model->AllLETasksNoJob($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['le_request'] = $this->projects_model->AllLETasksPagesNoJob($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['le_request']->num_rows();
            } else {
                $limit = 25;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllLETasksNoJob($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/pmLERequest');
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

                $data['le_request'] = $this->projects_model->AllLETasksPagesNoJob($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/pmLERequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function addLeRequest()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 144);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;

            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addLeRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddLeRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 144);
        if ($permission->add == 1) {
            $data['id'] = base64_decode($_POST['id']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['product_line'] = $_POST['product_line'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['complexicty'] = $_POST['complexicty'];
            $data['complexicty_value'] = $this->projects_model->getLeComplexictyValue($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['rate'] = $this->projects_model->calculateLeRequestRate($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
            if ($_FILES['file']['size'] != 0) {
                // $config['file']['upload_path']          = './assets/uploads/leRequest/';
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/pmLERequest");
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('le_request', $data)) {
                $this->projects_model->sendLERequestMail($this->db->insert_id());
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/pmLERequest");
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/pmLERequest");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editLeRequest()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 144);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['brand'] = $this->brand;

            //body ..
            $id = base64_decode($_GET['t']);
            $data['le_request'] = $this->db->get_where('le_request', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editLeRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function doEditLeRequest($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 144);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['product_line'] = $_POST['product_line'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['linguist'] = $_POST['linguist_format'];
            $data['deliverable'] = $_POST['deliverable_format'];
            $data['unit'] = $_POST['unit'];
            $data['volume'] = $_POST['volume'];
            $data['complexicty'] = $_POST['complexicty'];
            $data['complexicty_value'] = $this->projects_model->getLeComplexictyValue($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['rate'] = $this->projects_model->calculateLeRequestRate($_POST['task_type'], $_POST['linguist_format'], $_POST['deliverable_format'], $_POST['complexicty'], $_POST['volume']);
            $data['tm_usage'] = $_POST['tm_usage'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 1;
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 100000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/pmLERequest");
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('le_request', 144, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('le_request', $data, array('id' => $id))) {
                $this->projects_model->sendLERequestMail($id);
                $true = "Request Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/pmLERequest");
            } else {
                $error = "Failed To Edit Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/pmLERequest");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function pmInHouse()
    {
        $check = $this->admin_model->checkPermission($this->role, 148);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 148);
            //body ..
            $brand = $this->brand;
            if (isset($_POST['search'])) {
                if (isset($_REQUEST['report'])) {
                    $data['report'] = $_REQUEST['report'];
                    if ($data['report'] == 1) {
                        if (isset($_POST['search'])) {
                            $arr2 = array();

                            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                                    array_push($arr2, 0);
                                }
                            } else {
                                $date_to = "";
                                $date_from = "";
                            }
                            if (isset($_REQUEST['id'])) {
                                $id = $_REQUEST['id'];
                                if (!empty($id)) {
                                    array_push($arr2, 1);
                                }
                            } else {
                                $id = "";
                            }
                            if (isset($_REQUEST['task_name'])) {
                                $task_name = $_REQUEST['task_name'];
                                if (!empty($task_name)) {
                                    array_push($arr2, 2);
                                }
                            } else {
                                $task_name = "";
                            }
                            if (isset($_REQUEST['created_by'])) {
                                $created_by = $_REQUEST['created_by'];
                                if (!empty($created_by)) {
                                    array_push($arr2, 3);
                                }
                            } else {
                                $created_by = "";
                            }
                            // print_r($arr2);

                            $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                            $cond2 = "id LIKE '%$id%'";
                            $cond3 = "task_name LIKE '%$task_name%'";
                            $cond4 = "created_by = '$created_by'";
                            $arr1 = array($cond1, $cond2, $cond3, $cond4);
                            $arr_1_cnt = count($arr2);
                            $arr3 = array();
                            for ($i = 0; $i < $arr_1_cnt; $i++) {
                                array_push($arr3, $arr1[$arr2[$i]]);
                            }
                            $arr4 = implode(" and ", $arr3);
                            // print_r($arr4);     
                            if ($arr_1_cnt > 0) {
                                $data['job'] = $this->projects_model->AllDTPPm($data['permission'], $this->user, $this->brand, $arr4);
                            } else {
                                $data['job'] = $this->projects_model->AllDTPPm($data['permission'], $this->user, 0, 1);
                            }
                        } else {
                            $data['job'] = $this->projects_model->AllDTPPm($data['permission'], $this->user, 0, 1);
                        }
                    } elseif ($data['report'] == 2) {
                        if (isset($_POST['search'])) {
                            $arr2 = array();

                            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                                    array_push($arr2, 0);
                                }
                            } else {
                                $date_to = "";
                                $date_from = "";
                            }
                            if (isset($_REQUEST['id'])) {
                                $id = $_REQUEST['id'];
                                if (!empty($id)) {
                                    array_push($arr2, 1);
                                }
                            } else {
                                $id = "";
                            }
                            if (isset($_REQUEST['task_name'])) {
                                $task_name = $_REQUEST['task_name'];
                                if (!empty($task_name)) {
                                    array_push($arr2, 2);
                                }
                            } else {
                                $task_name = "";
                            }
                            if (isset($_REQUEST['created_by'])) {
                                $created_by = $_REQUEST['created_by'];
                                if (!empty($created_by)) {
                                    array_push($arr2, 3);
                                }
                            } else {
                                $created_by = "";
                            }
                            // print_r($arr2);

                            $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                            $cond2 = "id LIKE '%$id%'";
                            $cond3 = "subject LIKE '%$task_name%'";
                            $cond4 = "created_by = '$created_by'";
                            $arr1 = array($cond1, $cond2, $cond3, $cond4);
                            $arr_1_cnt = count($arr2);
                            $arr3 = array();
                            for ($i = 0; $i < $arr_1_cnt; $i++) {
                                array_push($arr3, $arr1[$arr2[$i]]);
                            }
                            $arr4 = implode(" and ", $arr3);
                            // print_r($arr4);     
                            if ($arr_1_cnt > 0) {
                                $data['job'] = $this->projects_model->AllLEPm($data['permission'], $this->user, $this->brand, $arr4);
                            } else {
                                $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, 0, 1);
                            }
                        } else {
                            $data['job'] = $this->projects_model->AllLEpm($data['permission'], $this->user, 0, 1);
                        }
                    } elseif ($data['report'] == 3) {
                        if (isset($_POST['search'])) {
                            $arr2 = array();

                            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                                    array_push($arr2, 0);
                                }
                            } else {
                                $date_to = "";
                                $date_from = "";
                            }
                            if (isset($_REQUEST['id'])) {
                                $id = $_REQUEST['id'];
                                if (!empty($id)) {
                                    array_push($arr2, 1);
                                }
                            } else {
                                $id = "";
                            }
                            if (isset($_REQUEST['task_name'])) {
                                $task_name = $_REQUEST['task_name'];
                                if (!empty($task_name)) {
                                    array_push($arr2, 2);
                                }
                            } else {
                                $task_name = "";
                            }
                            if (isset($_REQUEST['created_by'])) {
                                $created_by = $_REQUEST['created_by'];
                                if (!empty($created_by)) {
                                    array_push($arr2, 3);
                                }
                            } else {
                                $created_by = "";
                            }
                            // print_r($arr2);

                            $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                            $cond2 = "id LIKE '%$id%'";
                            $cond3 = "subject LIKE '%$task_name%'";
                            $cond4 = "created_by = '$created_by'";
                            $arr1 = array($cond1, $cond2, $cond3, $cond4);
                            $arr_1_cnt = count($arr2);
                            $arr3 = array();
                            for ($i = 0; $i < $arr_1_cnt; $i++) {
                                array_push($arr3, $arr1[$arr2[$i]]);
                            }
                            $arr4 = implode(" and ", $arr3);
                            // print_r($arr4);     
                            if ($arr_1_cnt > 0) {
                                $data['job'] = $this->projects_model->AllTranslationPm($data['permission'], $this->user, $this->brand, $arr4);
                            } else {
                                $data['job'] = $this->projects_model->AllTranslationPm($data['permission'], $this->user, 0, 1);
                            }
                        } else {
                            $data['job'] = $this->projects_model->AllTranslationPm($data['permission'], $this->user, 0, 1);
                        }
                    }
                }
            } else {
                $data['report'] = 0;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/pmInHouse.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportPmInHouse()
    {

        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";
        header("Content-Type: application/$file_type");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 148);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 148);
            //body ..
            $brand = $this->brand;
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            } else {
                $data['date_from'] = "2018-01-01";
                $data['date_to'] = date("Y-m-d");
            }
            if (isset($_REQUEST['report'])) {
                $data['report'] = $_REQUEST['report'];
                if ($data['report'] == 1) {
                    header("Content-Disposition: attachment; filename=InHouseReportBYDTP.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
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
                    if (isset($_REQUEST['dtp'])) {
                        $dtp = $_REQUEST['dtp'];
                        if (!empty($dtp)) {
                            array_push($arr2, 2);
                        }
                    } else {
                        $dtp = "";
                    }
                    // print_r($arr2);
                    $cond1 = "id = '$code'";
                    $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                    $cond3 = "dtp = '$dtp'";
                    $arr1 = array($cond1, $cond2, $cond3);
                    $arr_1_cnt = count($arr2);
                    $arr3 = array();
                    for ($i = 0; $i < $arr_1_cnt; $i++) {
                        array_push($arr3, $arr1[$arr2[$i]]);
                    }
                    $arr4 = implode(" and ", $arr3);
                    // print_r($arr4);     
                    if ($arr_1_cnt > 0) {
                        $data['job'] = $this->projects_model->AllDTPPm($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllDTPPm($data['permission'], $this->user, 0, 1);
                    }
                } elseif ($data['report'] == 2) {
                    header("Content-Disposition: attachment; filename=InHouseReportBYLE.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
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
                    if (isset($_REQUEST['le'])) {
                        $le = $_REQUEST['le'];
                        if (!empty($le)) {
                            array_push($arr2, 2);
                        }
                    } else {
                        $le = "";
                    }
                    // print_r($arr2);
                    $cond1 = "id = '$code'";
                    $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                    $cond3 = "le = '$le'";
                    $arr1 = array($cond1, $cond2, $cond3);
                    $arr_1_cnt = count($arr2);
                    $arr3 = array();
                    for ($i = 0; $i < $arr_1_cnt; $i++) {
                        array_push($arr3, $arr1[$arr2[$i]]);
                    }
                    $arr4 = implode(" and ", $arr3);
                    // print_r($arr4);     
                    if ($arr_1_cnt > 0) {
                        $data['job'] = $this->projects_model->AllLEPm($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllLEPm($data['permission'], $this->user, 0, 1);
                    }
                } elseif ($data['report'] == 3) {
                    header("Content-Disposition: attachment; filename=InHouseReportBYTranslation.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
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
                        $data['job'] = $this->projects_model->AllTranslationPm($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllTranslationPm($data['permission'], $this->user, 0, 1);
                    }
                }
            }
            //Pages ..
            $this->load->view('projects/exportPmInHouse.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function pmoReport()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 153);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 153);
            //body ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/pmoReport.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportPmoReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=PMOReport.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $this->load->view('projects/exportPmoReport.php');
    }

    public function pmoCustomer()
    {

        $check = $this->admin_model->checkPermission($this->role, 161);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 161);
            //body ..
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $name = implode(",", $_REQUEST['name']);
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                // print_r($arr2);
                $cond1 = "id IN ($name)";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);    
                $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if ($arr_1_cnt > 0) {
                    $data['customer'] = $this->projects_model->AllPMOCustomer($data['permission'], $this->user, $this->brand, $arr4);
                }
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/pmoCustomer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportPmoCustomer()
    {

        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=PMOCustomers.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 161);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 161);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['name'])) {
                $name = implode(",", $_REQUEST['name']);
                if (!empty($name)) {
                    array_push($arr2, 0);
                }
            } else {
                $name = "";
            }
            // print_r($arr2);
            $cond1 = "id IN ($name)";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            //print_r($arr4);    
            $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if ($arr_1_cnt > 0) {
                $data['customer'] = $this->projects_model->AllPMOCustomer($data['permission'], $this->user, $this->brand, $arr4);
            }
            //Pages ..

            $this->load->view('projects/exportPmoCustomer.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function creditNote()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 163);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 163);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['po'])) {
                    $po = $_REQUEST['po'];
                    if (!empty($po)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $po = "";
                }
                if (isset($_REQUEST['verified'])) {
                    $verified = $_REQUEST['verified'];
                    if (!empty($verified)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $verified = "";
                }
                if (isset($_REQUEST['invoiced'])) {
                    $invoiced = $_REQUEST['invoiced'];
                    if (!empty($invoiced)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $invoiced = "";
                }
                if ($verified == 2) {
                    $verified = 0;
                }
                if ($invoiced == 2) {
                    $invoiced = 0;
                }
                //print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "number LIKE '%$po%'";
                $cond3 = "verified = '$verified'";
                $cond4 = "invoiced = '$invoiced'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['creditNote'] = $this->projects_model->creditNote($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['creditNote'] = $this->projects_model->creditNotePages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->creditNote($data['permission'], $this->user, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/creditNote');
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

                $data['creditNote'] = $this->projects_model->creditNotePages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/creditNote.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewCreditNote()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 163);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('credit_note', array('id' => $id))->row();
            $data['job'] = $this->db->get_where('job', array('po' => $data['row']->po))->result();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/viewCreditNote.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function creditNoteAction()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 163);
        if ($check) {
            $id = base64_decode($_POST['id']);
            //Approve ..
            if (isset($_POST['submit'])) {

                $data['approved_by'] = $this->user;
                $data['approved_at'] = date("Y-m-d H:i:s");
                $data['status'] = 1;

                $this->admin_model->addToLoggerUpdate('credit_note', 163, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('credit_note', $data, array('id' => $id))) {
                    $this->accounting_model->sendApproveCreditNoteMail($id, $data['status'], "");
                    $true = "Credit Note Request Approved Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/creditNote");
                } else {
                    $error = "Failed To Approve Credit Note Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/creditNote");
                }
            } elseif (isset($_POST['reject'])) {
                //Reject ..
                $data['reject_reason'] = $_POST['reject_reason'];
                $data['approved_by'] = $this->user;
                $data['approved_at'] = date("Y-m-d H:i:s");
                $data['status'] = 2;

                $this->admin_model->addToLoggerUpdate('credit_note', 163, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('credit_note', $data, array('id' => $id))) {
                    $this->accounting_model->sendApproveCreditNoteMail($id, $data['status'], $data['reject_reason']);
                    $true = "Credit Note Request Rejected Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projects/creditNote");
                } else {
                    $error = "Failed To Reject Credit Note Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/creditNote");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function pmoCustomerPm()
    {

        $check = $this->admin_model->checkPermission($this->role, 166);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 166);
            //body ..
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $name = implode(",", $_REQUEST['name']);
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                // print_r($arr2);
                $cond1 = "id IN ($name)";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);    
                $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if ($arr_1_cnt > 0) {
                    $data['customer'] = $this->projects_model->AllPMOCustomer($data['permission'], $this->user, $this->brand, $arr4);
                }
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/pmoCustomerPm.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportPmoCustomerPm()
    {

        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=PMOCustomersPm.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 166);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 166);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['name'])) {
                $name = implode(",", $_REQUEST['name']);
                if (!empty($name)) {
                    array_push($arr2, 0);
                }
            } else {
                $name = "";
            }
            // print_r($arr2);
            $cond1 = "id IN ($name)";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            //print_r($arr4);    
            $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if ($arr_1_cnt > 0) {
                $data['customer'] = $this->projects_model->AllPMOCustomer($data['permission'], $this->user, $this->brand, $arr4);
            }
            //Pages ..

            $this->load->view('projects/exportPmoCustomerPm.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    /// pm conversion request

    public function pmConversionRequest()
    {
        $check = $this->admin_model->checkPermission($this->role, 167);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['file_name'])) {
                    $file_name = $_REQUEST['file_name'];
                    if (!empty($file_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $file_name = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $task_type = "";
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
                $cond1 = "file_name = '$file_name'";
                $cond2 = "task_type = '$task_type'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";

                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['pm_conversion_requests'] = $this->projects_model->AllPmConversionRequest($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['pm_conversion_requests'] = $this->projects_model->AllPmConversionRequestPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['pm_conversion_requests']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllPmConversionRequest($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('projects/pmConversionRequest');
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

                $data['pm_conversion_requests'] = $this->projects_model->AllPmConversionRequestPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/pmConversionRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addPmConversionRequest()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addPmConversionRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddPmConversionRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
        if ($permission->add == 1) {
            $data['file_name'] = $_POST['file_name'];
            $data['task_type'] = $_POST['task_type'];
            $data['attachment_type'] = $_POST['attachment_type'];
            ///    
            if ($data['attachment_type'] == 1) {
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/pmConversionRequestDocument/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 1000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/pmConversionRequest");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['attachment'] = $data_file['file_name'];
                        $data['link'] = " ";
                    }
                } else {
                    $error = "You should upload attachment";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/pmConversionRequest");
                }
            } elseif ($data['attachment_type'] == 2) {
                $data['attachment'] = " ";
                $data['link'] = $_POST['link'];
            }

            ///
            $data['link'] = $_POST['link'];
            $data['status'] = 1;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_conversion_request', $data)) {
                $true = "Request Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/pmConversionRequest");
            } else {
                $error = "Failed To Add Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/pmConversionRequest");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    //edit
    public function editPmConversionRequest()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_conversion_request', array('id' => $data['id']))->row();
            //print_r($data);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editPmConversionRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditPmConversionRequest()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 167);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            //
            $data['file_name'] = $_POST['file_name'];
            $data['task_type'] = $_POST['task_type'];
            $data['attachment_type'] = $_POST['attachment_type'];
            ///   
            if ($data['attachment_type'] == 1) {
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/pmConversionRequestDocument/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 10000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/pmConversionRequest");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['attachment'] = $data_file['file_name'];
                        $data['link'] = " ";
                    }
                } else {
                    $error = "You should upload attachment";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/pmConversionRequest");
                }
            } elseif ($data['attachment_type'] == 2) {
                $data['attachment'] = " ";
                $data['link'] = $_POST['link'];
            }

            ///
            $data['status'] = 1;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            //

            $this->admin_model->addToLoggerUpdate('pm_conversion_request', 167, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('pm_conversion_request', $data, array('id' => $id))) {
                $true = "Request Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/pmConversionRequest");
                }
            } else {
                $error = "Failed To Edit Request ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/pmConversionRequest");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    //

    public function deletePmConversionRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('pm_conversion_request', 167, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_conversion_request', array('id' => $id))) {
                $true = "Request Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Request ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewPmConversionRequest()
    {
        $check = $this->admin_model->checkPermission($this->role, 167);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
            //body ..
            $requestId = base64_decode($_GET['t']);
            $data['request'] = $this->db->get_where('pm_conversion_request', array('id' => $requestId))->row();

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/viewPmConversionRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    /// 
    public function exportPmConversionRequest()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=PmConversionRequest.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 167);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 167);
            $arr2 = array();
            if (isset($_REQUEST['file_name'])) {
                $file_name = $_REQUEST['file_name'];
                if (!empty($file_name)) {
                    array_push($arr2, 0);
                }
            } else {
                $file_name = "";
            }
            if (isset($_REQUEST['task_type'])) {
                $task_type = $_REQUEST['task_type'];
                if (!empty($task_type)) {
                    array_push($arr2, 1);
                }
            } else {
                $task_type = "";
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
            $cond1 = "file_name = '$file_name'";
            $cond2 = "task_type = '$task_type'";
            $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";

            $arr1 = array($cond1, $cond2, $cond3);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['pm_conversion_requests'] = $this->projects_model->AllPmConversionRequest($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['pm_conversion_requests'] = $this->projects_model->AllPmConversionRequestPages($data['permission'], $this->user, $this->brand, 9, 0);
            }
            $this->load->view('projects/exportPmConversionRequest.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    ///

    public function sendLateDeliveryJobs()
    {
        $now = date("Y-m-d H:i:s");
        $nowFilter = "delivery_date < '$now'";
        $jobs = $this->projects_model->lateDeliveryReport($nowFilter, 1);
        $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('./assets/uploads/excel/Late_jobs.xlsx');
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $rows = 2;
        foreach ($jobs->result() as $row) {
            $priceList = $this->projects_model->getJobPriceListData($row->price_list);
            $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
            $objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->admin_model->getAdmin($row->created_by));
            $objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $row->code);
            $objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $row->name);
            $objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $this->admin_model->getServices($priceList->service));
            $objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $this->admin_model->getLanguage($priceList->source));
            $objPHPExcel->getActiveSheet()->setCellValue('f' . $rows, $this->admin_model->getLanguage($priceList->target));
            $objPHPExcel->getActiveSheet()->setCellValue('g' . $rows, $total_revenue);
            $objPHPExcel->getActiveSheet()->setCellValue('h' . $rows, $this->admin_model->getCurrency($priceList->currency));
            $objPHPExcel->getActiveSheet()->setCellValue('i' . $rows, $row->start_date);
            $objPHPExcel->getActiveSheet()->setCellValue('j' . $rows, $row->delivery_date);
            $rows++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileName = 'late_delivery_report_' . date("Y-m-d_H_i_s") . '.xlsx';
        $objWriter->save(getcwd() . '/assets/uploads/late_delivery_daily_report/' . $fileName);
        $this->projects_model->sendLateDeliveryJobsMail($fileName);
    }

    ////// 
    public function exportAllRunnningJobs()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=allRunningJobs.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 204);
        //body ..
        $data['jobs'] = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                LEFT OUTER JOIN customer_leads AS c on c.id = p.lead 
                WHERE j.status = '0 AND 2' HAVING brand = '1' ");
        $this->load->view('projects/exportAllRunnningJobs.php', $data);
    }

    ////// 

    ///send feedback 
    public function customerFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 170);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 170);
            //body ..

            $data['feedback'] = $this->db->get_where('customer_feedback');
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/customerFeedback.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCustomerFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 170);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 170);
            //body ..
            $data['brand'] = $this->brand;
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addCustomerFeedback.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddCustomerFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 170);
        if ($check) {
            //$emails = $_POST['emails'];
            //$data['emails'] = implode(" , ", $emails);
            $data['emails'] = $_POST['emails'];
            $data['feedback_message'] = $_POST['feedback'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('customer_feedback', $data)) {
                $true = "Customer Feedback Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/customerFeedback");
            } else {
                $error = "Failed To Add Customer Feedback ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/customerFeedback");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteCustomerFeedback()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 170);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_feedback', 170, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer_feedback', array('id' => $id))) {
                $true = "Customer Feedback Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Customer Feedback ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function handover()
    {
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer_name'])) {
                    $customer_name = $_REQUEST['customer_name'];
                    if (!empty($customer_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer_name = "";
                }
                if (isset($_REQUEST['ttg_pm_name'])) {
                    $ttg_pm_name = $_REQUEST['ttg_pm_name'];
                    if (!empty($ttg_pm_name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $ttg_pm_name = "";
                }

                $cond1 = "customer_name = '$customer_name'";
                $cond2 = "ttg_pm_name = '$ttg_pm_name'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['handover'] = $this->projects_model->AllHandover($data['permission'], $this->user, $arr4);
                } else {
                    $data['handover'] = $this->projects_model->AllHandoverPages($data['permission'], $this->user, 9, 0);
                }
                $data['total_rows'] = $data['handover']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllHandover($data['permission'], $this->user, 1)->num_rows();
                $config['base_url'] = base_url('projects/handover/');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
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

                $data['handover'] = $this->projects_model->AllHandoverPages($data['permission'], $this->user, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/handover.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addHandover()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addHandover.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddHandover()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
        if ($permission->add == 1) {
            $new_pair = $_POST['new_pair'];
            $data['customer_name'] = $_POST['customer_name'];
            $data['customer_pm'] = $_POST['customer_pm'];
            $data['ttg_pm_name'] = $_POST['ttg_pm_name'];
            $data['productline'] = $_POST['productline'];
            $data['email_subject'] = $_POST['email_subject'];
            $data['service'] = $_POST['service'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['dialect'] = $_POST['dialect'];
            $data['tool'] = $_POST['tool'];
            $data['source_format'] = $_POST['source_format'];
            $data['source_files_location'] = $_POST['source_files_location'];
            $data['deliverables_format'] = $_POST['deliverables_format'];
            $data['delivery_location'] = $_POST['delivery_location'];
            $data['number_of_files'] = $_POST['number_of_files'];
            $data['files_names'] = $_POST['files_names'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['volume'] = $_POST['volume'];
            $data['unit'] = $_POST['unit'];
            $data['total_po_amount'] = $_POST['total_po_amount'];
            $data['customer_instructions'] = $_POST['customer_instructions'];
            $data['vendors_to_avoid'] = $_POST['vendors_to_avoid'];
            $data['important_comment'] = $_POST['important_comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('handover', $data)) {

                ///
                $handover_resources['handover'] = $this->db->insert_id();
                for ($i = 1; $i < $new_pair; $i++) {
                    $handover_resources['type'] = $_POST['type_' . $i];
                    $handover_resources['name'] = $_POST['name_' . $i];
                    $handover_resources['delevery_date'] = $_POST['resource_delivery_date_' . $i];
                    $handover_resources['created_by'] = $this->user;
                    $handover_resources['created_at'] = date("Y-m-d H:i:s");
                    if ($this->db->insert('handover_resources', $handover_resources)) {
                    } else {
                        $error = "Failed To Add Vendor Sheet ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/handover");
                    }
                }

                ///
                $true = "Handover Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/handover");
            } else {
                $error = "Failed To Add Handover ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/handover");
            }
            //print_r($data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editHandover()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_Where('handover', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editHandover.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditHandover()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            /// 
            $new_pair = $_POST['new_pair'];
            $data['customer_name'] = $_POST['customer_name'];
            $data['customer_pm'] = $_POST['customer_pm'];
            $data['ttg_pm_name'] = $_POST['ttg_pm_name'];
            $data['productline'] = $_POST['productline'];
            $data['email_subject'] = $_POST['email_subject'];
            $data['service'] = $_POST['service'];
            $data['subject_matter'] = $_POST['subject_matter'];
            $data['source_language'] = $_POST['source_language'];
            $data['target_language'] = $_POST['target_language'];
            $data['dialect'] = $_POST['dialect'];
            $data['tool'] = $_POST['tool'];
            $data['source_format'] = $_POST['source_format'];
            $data['source_files_location'] = $_POST['source_files_location'];
            $data['deliverables_format'] = $_POST['deliverables_format'];
            $data['delivery_location'] = $_POST['delivery_location'];
            $data['number_of_files'] = $_POST['number_of_files'];
            $data['files_names'] = $_POST['files_names'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['volume'] = $_POST['volume'];
            $data['unit'] = $_POST['unit'];
            $data['total_po_amount'] = $_POST['total_po_amount'];
            $data['customer_instructions'] = $_POST['customer_instructions'];
            $data['vendors_to_avoid'] = $_POST['vendors_to_avoid'];
            $data['important_comment'] = $_POST['important_comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('handover', 173, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('handover', $data, array('id' => $id))) {
                $handover_resources['handover'] = $id;
                for ($i = 1; $i < $new_pair; $i++) {
                    $handover_resources['type'] = $_POST['type_' . $i];
                    $handover_resources['name'] = $_POST['name_' . $i];
                    $handover_resources['delevery_date'] = $_POST['resource_delivery_date_' . $i];
                    $handover_resources['created_by'] = $this->user;
                    $handover_resources['created_at'] = date("Y-m-d H:i:s");
                    if ($this->db->insert('handover_resources', $handover_resources)) {
                    } else {
                        $error = "Failed To Add Vendor Sheet ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projects/handover");
                    }
                }

                $true = "Handover Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/handover");
                }
            } else {
                $error = "Failed To Edit Handover ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/handover");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editHandoverResource()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_Where('handover_resources', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editHandoverResource.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditHandoverResource()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['type'] = $_POST['type'];
            $data['name'] = $_POST['name'];
            $data['delevery_date'] = $_POST['delevery_date'];
            $this->admin_model->addToLoggerUpdate('project', 173, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('handover_resources', $data, array('id' => $id))) {
                $true = "Handover Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/handover");
                }
            } else {
                $error = "Failed To Edit Handover ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "projects/handover");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteHandover()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('handover', 173, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('handover', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('handover_resources', 173, 'handover', $id, 0, 0, $this->user);
                $this->db->delete('handover_resources', array('handover' => $id));
                $true = "Handover Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Handover ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteHandoverResource()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('handover_resources', 173, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('handover_resources', array('id' => $id))) {
                $true = "Handover Resource Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Handover Resource ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    //// 
    //handover view test 
    public function handover_test()
    {
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer_name'])) {
                    $customer_name = $_REQUEST['customer_name'];
                    if (!empty($customer_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer_name = "";
                }
                if (isset($_REQUEST['ttg_pm_name'])) {
                    $ttg_pm_name = $_REQUEST['ttg_pm_name'];
                    if (!empty($ttg_pm_name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $ttg_pm_name = "";
                }

                $cond1 = "customer_name = '$customer_name'";
                $cond2 = "ttg_pm_name = '$ttg_pm_name'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['handover'] = $this->projects_model->AllHandover($data['permission'], $this->user, $arr4);
                } else {
                    $data['handover'] = $this->projects_model->AllHandoverPages($data['permission'], $this->user, 9, 0);
                }
                $data['total_rows'] = $data['handover']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllHandover($data['permission'], $this->user, 1)->num_rows();
                $config['base_url'] = base_url('projects/handover/');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
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

                $data['handover'] = $this->projects_model->AllHandoverPages($data['permission'], $this->user, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projects_new/handover.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addHandover_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 173);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 173);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addHandover.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    ////////////

    public function addTask_new()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['job'] = base64_decode($_GET['t']);
            $data['job_data'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['job_data']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/addTask_new.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddTask_new()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['vendor'] = $_POST['vendor'];
            $select = $_POST['select'];
            $data['rate'] = $_POST['rate_' . $select];
            $data['currency'] = $_POST['currency_' . $select];
            $data['unit'] = $_POST['unit_' . $select];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['time_zone'] = $_POST['time_zone'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/taskFile/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 20000000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            //$data['code'] = $this->projects_model->generateTaskCode($data['job_id']);
            $data['code'] = 123;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('job_task_new', $data)) {
                $totalVpo = $data['rate'] * $data['count'];
                if ($totalVpo > 0) {
                    //$this->projects_model->sendVendorTaskMail($this->db->insert_id(),$this->user,$this->brand);
                }
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    ///
    ///////
    public function sendMessage()
    {
        $data['message'] = $_POST['msg'];
        $data['task'] = base64_decode($_POST['jobID']);
        $data['from'] = 1;
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        // echo $message;
        if ($this->db->insert('job_task_conversation', $data)) {
            $this->projects_model->sendVendorMessageMail($data['task'], $data['message'], $this->brand);
            echo 1;
        } else {
            echo 0;
        }
    }


    public function PMNew()
    {
        $this->load->view('includes_new/header.php');
        $this->load->view('projects_new/pm_new.php');
        $this->load->view('includes_new/footer.php');
    }

    // add task feedback
    public function addTaskFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        $row = $this->projects_model->getTaskData(base64_decode($_GET['t']));
        $feedback = $this->db->get_where('task_feedback', array('task_id' => $row->id))->num_rows();
        if ($check && $row->created_by == $this->user) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 70);
            //body ..
            $data['brand'] = $this->brand;
            $data['task'] = base64_decode($_GET['t']);
            $data['row'] = $row;
            if ($row->status == 1) {
                // //Pages ..
                $this->load->view('includes_new/header.php', $data);
                $this->load->view('projectManagment/addTaskFeedback.php');
                $this->load->view('includes_new/footer.php');
            } elseif ($feedback > 0) {
                echo "You Already Add Feedback ... ";
            } else {
                echo "You Can't Add Feedback, This Task isn't 'Delivered' ";
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // do add task feedback
    public function doAddTaskFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 70);
        if ($check) {
            $job = base64_decode($_POST['job']);
            $data['task_id'] = base64_decode($_POST['task']);
            $row = $this->projects_model->getTaskData($data['task_id']);
            $data['vendor_id'] = $row->vendor;
            $data['quality'] = $_POST['quality'] ?? 0;
            $data['communication'] = $_POST['communication'] ?? 0;
            $data['price'] = $_POST['price'] ?? 0;
            $data['comment'] = $_POST['comment'];
            $data['task_response'] = $_POST['task_response'] ?? null;

            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('task_feedback', $data)) {
                $true = "Data Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectManagment/viewTask?t=" . $_POST['task'] . "&j=" . $_POST['job']);
            } else {
                $error = "Failed To Add Data ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    /* Client Pm Functions */
    public function listClientPm()
    {
        // Check Permission ..        
        $check = $this->admin_model->checkPermission($this->role, 233);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 233);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $data['name'] = $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['email'])) {
                    $data['email'] = $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $email = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $data['customer'] = $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $customer = "";
                }

                $cond1 = "name LIKE '%$name%'";
                $cond2 = "email LIKE '%$email%'";
                $cond3 = "customer_id = '$customer'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt <= 0) {
                    $arr4 = 1;
                }
                $data['clientPms'] = $this->projects_model->AllClientPms($data['permission'], $arr4);
                $data['total_rows'] = $data['clientPms']->num_rows();
            } else {
                $limit = 20;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllClientPms($data['permission'], 1)->num_rows();
                $baseUrl = base_url('projectManagment/listClientPm');
                $config = $this->admin_model->paginationConfig($baseUrl, $limit, $count);
                $this->pagination->initialize($config);

                $data['clientPms'] = $this->projects_model->AllClientPmsPages($data['permission'], $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/client_pm/listClientPm.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addClientPm()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 233);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 233);
            //body ..
            $data['pm'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/client_pm/addClientPm.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddClientPm()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 233);
        if ($check) {
            $last_code = $this->db->select_max('code')->get('client_pm')->row()->code;
            $data['code'] = $last_code ? $last_code + 1 : "00001";
            $data['customer_id'] = $_POST['customer'];
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $job = $_POST['job'] ?? '0';
            $check_email = $this->db->get_where('client_pm', array('email' => $_POST['email']))->num_rows();
            if ($check_email == 0) {
                if ($this->db->insert('client_pm', $data)) {
                    if ($job == 1) {
                        $cpm_id = $this->db->insert_id();
                        $response['status'] = "success";
                        $response['id'] = $cpm_id;
                        $response['text'] = $data['name'] . " (" . $_POST['email'] . ")";
                        echo json_encode($response);
                    } else {
                        $true = "The data has been added successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "projectManagment/listClientPm");
                    }
                } else {
                    $error = "Failed To Add PM ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/listClientPm");
                }
            } else {
                if ($job == 1) {
                    $response['status'] = "error";
                    echo json_encode($response);
                } else {
                    $error = "This Email Already Exists...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editClientPm()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 233);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 233);
            //body ..
            $id = base64_decode($_GET['p']);
            $data['client_pm'] = $this->db->get_where('client_pm', array('id' => $id))->row();
            $data['pm'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('projectManagment/client_pm/editClientPm.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditClientPm()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 233);
        if ($check) {
            $id = $_POST['id'];
            $data['customer_id'] = $_POST['customer'];
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            // check email exists & not connected to any job
            $check_email = $this->db->get_where('client_pm', array('email' => $_POST['email'], 'id !=' => $id))->num_rows();
            $check_job = $this->db->get_where('job', array('client_pm_id' => $id))->num_rows();
            if ($check_job == 0) {
                if ($check_email == 0) {
                    if ($this->db->update('client_pm', $data, array('id' => $id))) {
                        $true = "Data Updated Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "projectManagment/listClientPm");
                    } else {
                        $error = "Failed To Edit PM ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "projectManagment/listClientPm");
                    }
                } else {
                    $error = "This Email Already Exists...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "Failed To Edit Data, Pm Is Already Connected To Jobs";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteClientPm()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 233);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['p']);
            $check_job = $this->db->get_where('job', array('client_pm_id' => $id))->num_rows();
            if ($check_job == 0) {
                $this->admin_model->addToLoggerDelete('client_pm', 233, 'id', $id, 0, 0, $this->user);
                if ($this->db->delete('client_pm', array('id' => $id))) {
                    $true = "Data Deleted Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "projectManagment/listClientPm");
                } else {
                    $error = "Failed To Delete ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectManagment/listClientPm");
                }
            } else {
                $error = "Failed To Delete, Pm Is Already Connected To Jobs";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddJobQC()
    {
        $check = $this->admin_model->checkPermission($this->role, 67);
        if ($check) {

            // check if alreday exists
            $job_qc = $this->db->get_where('job_qc', array('job_id' => $_POST['job_id']))->row();
            $project_id = $_POST['project_id'] ? base64_encode($_POST['project_id']) : base64_encode($job_qc->project_id);
            $job_id = $data['job_id'] = $_POST['job_id'];
            if (empty($job_qc)) {
                $data['project_id'] = $_POST['project_id'];
                $data['service_id'] = $_POST['service_id'];
                $qc_type = $data['qc_type'] = $_POST['qc_type'];
                if ($qc_type == 1 || $qc_type == 3) {
                    if ($_FILES['file']['size'] != 0) {
                        //$config['file']['upload_path']          = './assets/uploads/jobQc/';
                        $config['file']['upload_path'] = './assets/uploads/jobQc/';
                        $config['file']['encrypt_name'] = TRUE;
                        $config['file']['allowed_types'] = 'zip|rar';
                        $config['file']['max_size'] = 20000000;
                        $config['file']['max_width'] = 1024;
                        $config['file']['max_height'] = 768;
                        $this->load->library('upload', $config['file'], 'file_upload');
                        if (!$this->file_upload->do_upload('file')) {
                            $error = $this->file_upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                        } else {
                            $data_file = $this->file_upload->data();
                            $data['file'] = $data_file['file_name'];
                        }
                    }
                }
                if ($qc_type == 2 || $qc_type == 3) {
                    for ($i = 1; $i <= 30; $i++) {
                        $data["logcheck$i"] = $_POST["label_logcheck$i"];
                        $data["logcheck_value$i"] = $_POST["logcheck$i"];
                    }
                    for ($i = 31; $i <= 35; $i++) {
                        $x = $i - 30;
                        $data["logcheck$i"] = $_POST["label_logcheckn$x"];
                        $data["logcheck_value$i"] = $_POST["logcheckn$x"];
                    }
                }
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                //                print_r($data);
                //                print_r($_POST);exit();
                if ($this->db->insert('job_qc', $data)) {

                    $true = "Data Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                } else {
                    $error = "Failed To Data Job ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                }
            } else {
                // do edit 
                if ($_FILES['file']['size'] != 0) {
                    //$config['file']['upload_path']          = './assets/uploads/jobQc/';
                    $config['file']['upload_path'] = './assets/uploads/jobQc/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 20000000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                        // delete old one 
                        $old_path = $job_qc->file;
                        unlink('./assets/uploads/jobQc/' . $old_path);
                        // unlink('./assets/uploads/jobQc/' . $old_path);
                    }
                }

                if (!empty($_POST['qc_type'])) {
                    $data['project_id'] = $_POST['project_id'];
                    $data['service_id'] = $_POST['service_id'];
                    $qc_type = $data['qc_type'] = $_POST['qc_type'];
                }
                if ($job_qc->qc_type == 2 || $job_qc->qc_type == 3) {
                    for ($i = 1; $i <= 30; $i++) {
                        $data["logcheck$i"] = $_POST["label_logcheck$i"];
                        $data["logcheck_value$i"] = $_POST["logcheck$i"];
                    }
                    for ($i = 31; $i <= 35; $i++) {
                        $x = $i - 30;
                        $data["logcheck$i"] = $_POST["label_logcheckn$x"];
                        $data["logcheck_value$i"] = $_POST["logcheckn$x"];
                    }
                }
                $data['updated_by'] = $this->user;
                $data['updated_at'] = date("Y-m-d H:i:s");
                $this->admin_model->addToLoggerUpdate('job_qc', 65, 'id', $job_qc->id, 1, 1, $this->user);
                if ($this->db->update('job_qc', $data, array('job_id' => $job_id))) {
                    $true = "Data Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                } else {
                    $error = "Failed To Edit Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function sendJobsOverDueQC()
    {
        $cuurnetDate = date("Y-m-d");
        $jobList = '<table class="table" style="border: 1px solid;width: 100%;text-align: center"><thead><tr><td>#</td><td>Job ID</td><td>Code</td><td>PM</td><td>Delivery Date</td></tr></thead>';
        $mailData = $data = $this->db->query(" SELECT qmemail,qmemailsub, qmemaildesc FROM `pm_setup`")->row();
        $jobs = $this->db->order_by('id', 'DESC')->get_where('job', array('qc_flag' => 0, 'status' => 0, 'delivery_date < ' => $cuurnetDate))->result();
        if (count($jobs) > 0) {
            foreach ($jobs as $k => $row) {
                $jobList .= "<tr><td>" . ++$k . "</td><td>$row->id</td><td>$row->code</td><td>" . $this->admin_model->getAdmin($row->created_by) . "</td><td>$row->delivery_date</td></tr>";
            }
        } else {
            $jobList .= '<tr><td colspan="5">No Data Found</td></tr>';
        }
        $jobList .= '</table>';

        if ($this->projects_model->sendJobsOverDueQC($mailData, $jobList)) {
            $data['job_flag'] = 1;
            foreach ($jobs as $row) {
                $this->db->update('job', $data, array('id' => $row->id));
            }
        }
    }

    public function doAddVendorEvaluation()
    {
        $check = $this->admin_model->checkPermission($this->role, 67);
        if ($check) {
            // check if alreday exists
            //            print_r($_POST);exit();
            $task_id = $data['task_id'] = $_POST['task_id'];
            $project_id = base64_encode($_POST['project_id']);
            $data['project_id'] = $_POST['project_id'];
            $data['job_id'] = $_POST['job_id'];
            $data['vendor_id'] = $_POST['vendor_id'];
            $data['pm_ev_select'] = $_POST['pm_ev_select'];
            $data['pm_ev_type'] = ($_POST['pm_ev_select'] < 5) ? 2 : 1;
            $data['pm_note'] = $_POST['pm_note'];
            for ($i = 1; $i <= 6; $i++) {
                $data["pm_ev_text$i"] = $_POST["pm_ev_text$i"] ?? null;
                $data["pm_ev_val$i"] = $_POST["pm_ev_val$i"] ?? null;
                if ($data["pm_ev_text$i"] == null)
                    $data["pm_ev_val$i"] = null;
                else
                    $data["pm_ev_val$i"] = $_POST["pm_ev_val$i"] ?? 0;
            }
            $task_ev = $this->db->get_where('task_evaluation', array('task_id' => $_POST['task_id']))->row();

            if (empty($task_ev)) {
                $data['pm_ev_created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('task_evaluation', $data)) {
                    // vendor
                    $block_setup = $this->projects_model->VendorBlockSetup($this->brand);
                    $vendor_count = $this->db->get_where('task_evaluation', array('vendor_id' => $_POST['vendor_id'], 'pm_ev_type' => 2))->num_rows();
                    $dataVendor['ev_block_count'] = $vendor_count;
                    $dataVendor['ev_block'] = ($vendor_count >= $block_setup) ? 1 : 0;
                    $this->db->update('vendor', $dataVendor, array('id' => $_POST['vendor_id']));
                    // end vendor
                    $true = "Data Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                } else {
                    $error = "Failed To Data Job ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                }
            } else {
                // do edit 

                if ($task_ev->pm_ev_type == null)
                    $data['pm_ev_created_at'] = date("Y-m-d H:i:s");
                $id = $task_ev->id;
                $this->admin_model->addToLoggerUpdate('task_evaluation', 65, 'id', $id, 1, 1, $this->user);
                if ($this->db->update('task_evaluation', $data, array('id' => $id))) {
                    // vendor
                    $block_setup = $this->projects_model->VendorBlockSetup($this->brand);
                    $vendor_count = $this->db->get_where('task_evaluation', array('vendor_id' => $_POST['vendor_id'], 'pm_ev_type' => 2))->num_rows();
                    $dataVendor['ev_block_count'] = $vendor_count;
                    $dataVendor['ev_block'] = ($vendor_count >= $block_setup) ? 1 : 0;
                    $this->db->update('vendor', $dataVendor, array('id' => $_POST['vendor_id']));
                    // end vendor
                    $true = "Data Saved Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                } else {
                    $error = "Failed To Edit Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectManagment/projectJobs?t=" . $project_id);
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
}
