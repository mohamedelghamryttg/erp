<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProjectPlanning extends CI_Controller
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
        //        if($this->brand != 1 && $this->brand != 3 && $this->brand != 11 ){
//            echo "You have no permission to access this page";
//            exit();
//        }
    }
    public function index()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 208);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 208);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;


            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['product_line'])) {
                    $product_line = $_REQUEST['product_line'];
                    if (!empty($product_line)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $product_line = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $status = "";
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
                $cond1 = "project_name LIKE '%$name%'";
                $cond2 = "customer = '$customer'";
                $cond3 = "product_line = '$product_line'";
                $cond4 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
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
                $having = 1;
                $data['project'] = $this->projects_model->AllProjectPlanning($data['permission'], $this->user, $this->brand, $arr4, $having);
                $data['total_rows'] = $data['project']->num_rows();
            } else {
                $limit = 50;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->projects_model->AllProjectPlanningCount($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('ProjectPlanning/index');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1 fw-bold'>";
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

                $data['project'] = $this->projects_model->AllProjectPlanningPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('project_planning/view_projects.php');
            $this->load->view('includes_new/footer.php');
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
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('project_planning/addProject.php');
            $this->load->view('includes_new/footer.php');
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
            $data['project_name'] = $_POST['project_name'];
            $data['product_line'] = $_POST['product_line'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->brand == 1)
                $data['branch_name'] = $_POST['branch_name'];

            if ($this->db->insert('project_planning', $data)) {
                $project_id = $this->db->insert_id();
                $true = "Project Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectPlanning/projectJobs?t=" . base64_encode($project_id));
            } else {
                $error = "Failed To Add Project ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectPlanning");
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
            $data['row'] = $this->db->get_Where('project_planning', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('project_planning/editProject.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditProject()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 39);
        if ($check) {
            $id = base64_decode($_POST['id']);
            //   $data['lead'] = $_POST['lead'];
            //  $data['customer'] = $_POST['customer'];
            $data['project_name'] = $_POST['project_name'];
            //   $data['product_line'] = $_POST['product_line'];            
            if ($this->brand == 1)
                $data['branch_name'] = $_POST['branch_name'];

            $this->admin_model->addToLoggerUpdate('project_planning', 39, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('project_planning', $data, array('id' => $id))) {
                $true = "Project Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectPlanning");
            } else {
                $error = "Failed To Edit Project ...";
                $this->session->set_flashdata('error', $error);

                redirect(base_url() . "ProjectPlanning");

            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteProject()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 208);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('project_planning', 40, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('project_planning', array('id' => $id))) {
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

    public function projectJobs()
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
            $data['project_data'] = $this->projects_model->getProjectPlanningData($data['project']);
            $data['job'] = $this->projects_model->projectPlanningJobs($data['permission'], $this->user, $data['project']);

            $this->load->view('includes/header.php', $data);
            $this->load->view('project_planning/projectJobs.php');
            $this->load->view('includes/footer.php');
        } else {
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
            $data['project_data'] = $this->projects_model->getProjectPlanningData($data['project']);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('project_planning/addJob.php');
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
            if (isset($_POST['price_list'])) {
                $price_list = $_POST['price_list'];
            } else {
                $error = "Failed To Add Project, Please make sure to select from price list ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/projectJobs?t=" . $_POST['project_id']);
            }
            if ($_POST['job_type'] == 0 && $_POST['total_revenue'] == 0) {
                $error = "Please check , total revenue for real job must be > zero ... ";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/projectJobs?t=" . $_POST['project_id']);
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
            $data['plan_id'] = base64_decode($_POST['project_id']);
            $projectData = $this->db->get_where('project_planning', array('id' => $data['project_id']))->row();
            $data['assigned_sam'] = $this->projects_model->getAssignedSam($projectData->lead);
            if ($data['type'] == 1) {
                $data['volume'] = $_POST['volume'];
            }
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['job_type'] = $_POST['job_type'];
            $data['status'] = 7;
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
                    redirect(base_url() . "projectManagment/projectJobs?t=" . base64_encode($project_id));
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
                    redirect(base_url() . "projectPlanning/projectJobs?t=" . $_POST['project_id']);
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
                redirect(base_url() . "projectPlanning/projectJobs?t=" . $_POST['project_id']);
            } else {
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/projectJobs?t=" . $_POST['project_id']);
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
            $data['project_data'] = $this->projects_model->getProjectPlanningData($data['project']);
            $data['row'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['row']->price_list);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('project_planning/editJob.php');
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
                redirect(base_url() . "ProjectPlanning/projectJobs?t=" . $_POST['project_id']);
            }
            if ($_POST['job_type'] == 0 && $_POST['total_revenue'] == 0) {
                $error = "Please check , total revenue for real job must be > zero ... ";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectPlanning/projectJobs?t=" . $_POST['project_id']);
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
            $data['job_type'] = $_POST['job_type'];
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
                    redirect(base_url() . "ProjectPlanning/projectJobs?t=" . $_POST['project_id']);
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
                } elseif ($type == 1) {
                    $this->db->delete('project_fuzzy', array('job' => $id));
                }
                $true = "Job Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "ProjectPlanning/projectJobs?t=" . $_POST['project_id']);
            } else {
                $error = "Failed To Edit Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "ProjectPlanning/projectJobs?t=" . $_POST['project_id']);
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
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('project_planning/jobTasks.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addTranslationPlan()
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
            $this->load->view('project_planning/addTranslationRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddTranslationRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 69);
        if ($permission->add == 1) {
            $data['job_id'] = base64_decode($_POST['job_id']);
            $data['subject'] = $_POST['subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['count'] = $_POST['count'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['status'] = 7;

            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/translationRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/translationRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('translation_request', $data)) {
                // send Heads-Up mail for translation
                $this->projects_model->sendRequestPlanMail($this->db->insert_id(), 1);
                //   $this->projects_model->sendTranslationRequestMail($this->db->insert_id());
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLeRequest()
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
            $this->load->view('project_planning/addLeRequest.php');
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
            $data['status'] = 7;
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/leRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/leRequest/';
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

            if ($this->db->insert('le_request', $data)) {
                $this->projects_model->sendRequestPlanMail($this->db->insert_id(), 2);
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addDtpRequest()
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
            $this->load->view('project_planning/adddtpRequest.php');
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
            $data['status'] = 7;
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['insrtuctions'] = $_POST['insrtuctions'];
            $data['assigned_to'] = $_POST['assigned_to'];

            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/dtpRequest/';
                // $config['file']['upload_path']          = '/var/www/html/assets/uploads/dtpRequest/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('dtp_request', $data)) {
                $this->projects_model->sendRequestPlanMail($this->db->insert_id(), 3);
                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addVendorRequest()
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
            $this->load->view('project_planning/addTaskVendorRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVendorRequest()
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
            $data['job_portal'] = 1;
            $data['status'] = 7;
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
                    redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['code'] = $this->projects_model->generateTaskCode($data['job_id']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('job_task', $data)) {
                $insert_id = $this->db->insert_id();
                $totalVpo = $data['rate'] * $data['count'];
                if ($totalVpo > 0) {
                    $this->projects_model->sendVendorRequestPlanMail($insert_id, $this->user, $this->brand);
                }
                // task log
                $this->projects_model->addToTaskLogger($insert_id, 8);

                $true = "Task Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Add Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/jobTasks?t=" . $_POST['job_id']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }



    // delete job & all inside tasks
    public function deleteJob()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 65);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $project = base64_decode($_GET['p']);
            $job_data = $this->projects_model->getJobData($id);
            $this->admin_model->addToLoggerDelete('job', 68, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('job', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('job_price_list', 68, 'id', $job_data->price_list, 1, $id, $this->user);
                $this->db->delete('job_price_list', array('id' => $job_data->price_list));
                $true = "Job Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projectPlanning/projectJobs?t=" . base64_encode($project));
            } else {
                $error = "Failed To Delete Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projectPlanning/projectJobs?t=" . base64_encode($project));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }



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
            $data['row'] = $this->db->get_where('project_planning', array('id' => $id))->row();
            $data['job'] = $this->db->get_where('job', array('plan_id' => $data['row']->id))->result();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('project_planning/saveProject.php');
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
                // check min. per for planning 
                $checkPer = $this->projects_model->checkPlanProfitPercentage($_POST['id']);
                if($checkPer){
                    $row = $this->db->get_where('project_planning', array('id' => $_POST['id']))->row();
                    $project['lead'] = $row->lead;
                    $project['customer'] = $row->customer;
                    $project['name'] = $row->project_name;
                    $project['product_line'] = $row->product_line;
                    $project['code'] = $this->projects_model->generateProjectCode($project['lead'], $this->user);
                    $project['created_by'] = $this->user;
                    $project['created_at'] = date("Y-m-d H:i:s");
                    if ($this->brand == 1)
                        $project['branch_name'] = $row->branch_name;


                    // first save as a project
                    if ($this->db->insert('project', $project)) {
                        $project_id = $this->db->insert_id();

                        $job_data['status'] = 0;
                        $job_data['project_id'] = $project_id;
                        $projectPlan['project_id'] = $project_id;
                        $projectPlan['status'] = 1;
                        //  update project plan with status & project_id
                        $this->admin_model->addToLoggerUpdate('project_planning', 38, 'id', $_POST['id'], 0, 0, $this->user);
                        $this->db->update('project_planning', $projectPlan, array('id' => $_POST['id']));
                        // update jobs with project_id & & status & code
                        $jobs = $this->db->get_where('job', array('plan_id' => $_POST['id']))->result();
                        foreach ($jobs as $job) {
                            $job_data['created_by'] = $this->user;
                            $jobPrice = $this->db->get_where('job_price_list', array('id' => $job->price_list))->row();
                            $job_data['code'] = $this->projects_model->updateJobCode($job_data['project_id'], $jobPrice->price_list_id, $job->id);
                            $this->db->update('job', $job_data, array('id' => $job->id));
                            // update tasks
                            $tasks = $this->db->get_where('job_task', array('job_id' => $job->id))->result();
                            foreach ($tasks as $task) {
                                $task_data['code'] = $this->projects_model->updateTaskCode($job->id, $task->id);
                                $this->db->update('job_task', $task_data, array('id' => $task->id));
                            }
                        }

                        $true = "Project Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "ProjectManagment");
                    } else {
                        $error = "Failed To Add Project ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectManagment");
                    }
                }else{
                        $error = "Failed To Add Project <br/>Project Profit Percentage < Minimum Profit Percentage";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "ProjectPlanning");
                }
            } elseif (isset($_POST['reject'])) {
                // $projectPlan['reject_reason'] = $_POST['reject_reason'];
                $projectPlan['status'] = 2;
                $plan = $_POST['id'];
                $this->admin_model->addToLoggerUpdate('project_planning', 38, 'id', $plan, 0, 0, $this->user);
                if ($this->db->update('project_planning', $projectPlan, array('id' => $plan))) {
                    $true = "Project Rejected Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProjectPlanning");
                } else {
                    $error = "Failed To Reject Project ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "ProjectPlanning");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function startVendorTask()
    {

        $task_id = base64_decode($_GET['t']);
        $data['status'] = 4;

        if ($this->db->update('job_task', $data, array('id' => $task_id))) {

            $this->projects_model->sendVendorTaskMailVendorModule($task_id, $this->user, $this->brand);
            $true = "Task Started Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Start Task ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }


    }

    public function startTranslationTask()
    {

        $task_id = base64_decode($_GET['t']);
        $data['status'] = 1;
        if ($this->db->update('translation_request', $data, array('id' => $task_id))) {
            $this->projects_model->sendTranslationRequestMail($task_id);
            $true = "Task Started Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Start Task ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function startDTPTask()
    {

        $task_id = base64_decode($_GET['t']);
        $data['status'] = 1;
        if ($this->db->update('dtp_request', $data, array('id' => $task_id))) {
            $this->projects_model->sendDTPRequestMail($task_id);
            $true = "Task Started Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Start Task ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function startLeTask()
    {

        $task_id = base64_decode($_GET['t']);
        $data['status'] = 1;
        if ($this->db->update('le_request', $data, array('id' => $task_id))) {
            $this->projects_model->sendLERequestMail($task_id);
            $true = "Task Started Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Start Task ...";
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
            $data['row'] = $this->projects_model->getTaskData($data['task']);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/editTask.php');
            $this->load->view('includes/footer.php');
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
            // new if task rejected & edit -> resend job portal = 1
            $task_data = $this->db->get_where('job_task', array('id' => $task_id))->row();
            $old_status = $task_data->status;
            if ($task_data->status == 3 && $task_data->job_portal == 1) {
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
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
            } else {
                $error = "Failed To Edit Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $_POST['job_id']);
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
            $jobId = $_GET['j'];
            $taskId = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerUpdate('job_task', 89, 'id', $taskId, 0, 0, $this->user);
            if ($this->db->update('job_task', array('status' => '2'), array('id' => $taskId))) {
                $this->projects_model->sendVendorCancelTaskMail($taskId, $this->user, $this->brand);
                $true = "Task Canceled Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "projects/jobTasks?t=" . $jobId);
            } else {
                $error = "Failed To Cancel Task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "projects/jobTasks?t=" . $jobId);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

} ?>