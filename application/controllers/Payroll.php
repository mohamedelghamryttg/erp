<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
    }

    public function index()
    {

        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 212);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
            $data['emp_id'] = $this->emp_id;
            //body ..            
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['month']) && !empty($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2, 0);
                        $data['month'] = $month;
                    }
                } else {
                    $data['month'] = $month = "";
                }
                if (isset($_REQUEST['year']) && !empty($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 1);
                        $data['yearVal'] = $yearVal = $this->hr_model->getYear($year);
                        $data['year'] = $year;
                    }
                } elseif (isset($_REQUEST['yearValue'])) {
                    $year = $this->db->get_where('years', array('name' => $_REQUEST['yearValue']))->row();

                    if (!empty($year)) {
                        array_push($arr2, 1);
                        $data['yearVal'] = $yearVal = $_REQUEST['yearValue'];
                        $data['year'] = $year->id;
                    }
                } else {
                    $data['year'] = $data['yearVal'] = $year = $yearVal = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 2);
                        $data['employee_name'] = $employee_name;
                    }
                } else {
                    $data['employee_name'] = $employee_name = "";
                }
                if (isset($_REQUEST['action'])) {
                    $action = $_REQUEST['action'];
                    if (!empty($action)) {
                        array_push($arr2, 3);
                        $data['action'] = $action;
                    }
                } else {
                    $data['action'] = $action = "";
                }
                // search with (month& year) or only year
                if (!empty($month) && !empty($yearVal)) {
                    $searchDate = "$yearVal-$month-01";
                    $cond1 = "(start_date <= '$searchDate' AND end_date>= '$searchDate' ) || start_date = '$searchDate'";
                    $cond2 = "1";
                } else {
                    // $cond1 = "(MONTH(start_date)='$month') || (MONTH(start_date)>='$month' AND MONTH(end_date)<='$month')";
                    $cond1 = "1";
                    $cond2 = "(Year(start_date)='$yearVal' || Year(end_date)='$yearVal')";
                }

                $cond3 = "emp_id = '$employee_name'";
                $cond4 = "action = '$action'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['logs'] = $this->hr_model->AllPayroll($data['permission'], $arr4);
                } else {
                    $data['logs'] = $this->hr_model->AllPayrollPages($data['permission'], 9, 0);
                }
                $data['total_rows'] = $data['logs']->num_rows();

            } else {
                $data['month'] = $data['year'] = $data['action'] = $data['yearVal'] = $data['employee_name'] = '';
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllPayroll($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('payroll/index');
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

                $data['logs'] = $this->hr_model->AllPayrollPages($data['permission'], $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/payroll/payrollList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCard()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/payroll/addPayroll.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function savePayroll()
    {

        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($permission->add == 1) {          
            $start = strtotime("01-" . $_POST['start_month'] . "-" . $_POST['start_year']);
            $start_date = date('Y-m-01', $start);
            if ($_POST['recurrence'] == 1) {
                $end = strtotime("01-" . $_POST['end_month'] . "-" . $_POST['end_year']);
                $end_date = date('Y-m-01', $end);
                if ($end_date <= $start_date) {
                    $error = "Failed To Add, End Date must be after start date...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $end_date = null;
            }

            if($_POST['action'] == 2){
                $data['monthly_installment'] = $_POST['monthly_installment'];
                $data['num_month'] = $_POST['num_month'];
            }
            $data['emp_id'] = $_POST['emp_id'];
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['action'] = $_POST['action'];
            $data['amount'] = $_POST['amount'];
            $data['unit'] = $_POST['unit'];
            $data['recurrence'] = $_POST['recurrence'];
            $data['comment'] = $_POST['comment'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            $log = $this->db->insert('payroll', $data);
            if ($log) {
                $true = "Records Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "payroll");
            } else {
                $error = "Failed To Add Your Request...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCard($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
            $data['emp_id'] = $this->emp_id;

            $data['row'] = $this->db->get_where('payroll', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/payroll/editPayroll.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updatePayroll($id)
    {

        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($permission->edit == 1) {

            $start = strtotime("01-" . $_POST['start_month'] . "-" . $_POST['start_year']);
            $start_date = date('Y-m-01', $start);
            if ($_POST['recurrence'] == 1) {
                $end = strtotime("01-" . $_POST['end_month'] . "-" . $_POST['end_year']);
                $end_date = date('Y-m-01', $end);
                if ($end_date <= $start_date) {
                    $error = "Failed To Add, End Date must be after start date...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $end_date = null;
            }
            if($_POST['action'] == 2){
                $data['monthly_installment'] = $_POST['monthly_installment'];
                $data['num_month'] = $_POST['num_month'];
            }
            $data['emp_id'] = $_POST['emp_id'];
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['action'] = $_POST['action'];
            $data['amount'] = $_POST['amount'];
            $data['unit'] = $_POST['unit'];
            $data['recurrence'] = $_POST['recurrence'];
            $data['comment'] = $_POST['comment'];
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['updated_by'] = $this->user;

            $this->admin_model->addToLoggerUpdate('payroll', 212, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('payroll', $data, array('id' => $id))) {
                $true = "Records Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "payroll");
            } else {
                $error = "Failed To Add Your Request...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCard($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($permission->delete == 1) {

            $this->admin_model->addToLoggerDelete('payroll', 212, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('payroll', array('id' => $id))) {
                $true = "Card Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "payroll");
            } else {
                $error = "Failed To Delete Card ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "payroll");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewCard($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
        if ($data['permission']->view == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
            $data['emp_id'] = $this->emp_id;
            $data['row'] = $this->db->get_where('payroll', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/payroll/viewCard.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportPayroll()
    {

        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Payroll.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 212);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 212);
            //$data['employees'] = $this->db->query(" SELECT * FROM `employees` WHERE brand = '$this->brand' ");
            $data['employees'] = $this->db->query(" SELECT * FROM `employees` ");
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['month']) && !empty($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2, 0);
                        $data['month'] = $month;
                    }
                } else {
                    $data['month'] = $month = "";
                }
                if (isset($_REQUEST['year']) && !empty($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 1);
                        $data['yearVal'] = $yearVal = $this->hr_model->getYear($year);
                        $data['year'] = $year;
                    }
                } elseif (isset($_REQUEST['yearValue'])) {
                    $year = $this->db->get_where('years', array('name' => $_REQUEST['yearValue']))->row();

                    if (!empty($year)) {
                        array_push($arr2, 1);
                        $data['yearVal'] = $yearVal = $_REQUEST['yearValue'];
                        $data['year'] = $year->id;
                    }
                } else {
                    $data['year'] = $data['yearVal'] = $year = $yearVal = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 2);
                        $data['employee_name'] = $employee_name;
                    }
                } else {
                    $data['employee_name'] = $employee_name = "";
                }
                if (isset($_REQUEST['action'])) {
                    $action = $_REQUEST['action'];
                    if (!empty($action)) {
                        array_push($arr2, 3);
                        $data['action'] = $action;
                    }
                } else {
                    $data['action'] = $action = "";
                }
                // search with (month& year) or only year
                if (!empty($month) && !empty($yearVal)) {
                    $searchDate = "$yearVal-$month-01";
                    $cond1 = "(start_date <= '$searchDate' AND end_date>= '$searchDate' ) || start_date = '$searchDate'";
                    $cond2 = "1";
                } else {
                    // $cond1 = "(MONTH(start_date)='$month') || (MONTH(start_date)>='$month' AND MONTH(end_date)<='$month')";
                    $cond1 = "1";
                    $cond2 = "(Year(start_date)='$yearVal' || Year(end_date)='$yearVal')";
                }

                $cond3 = "emp_id = '$employee_name'";
                $cond4 = "action = '$action'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['logs'] = $this->hr_model->AllPayroll($data['permission'], $arr4);
            } else {
                $data['logs'] = $this->hr_model->AllPayroll($data['permission'], 1);
            }

            // //Pages ..

            $this->load->view('hr_new/payroll/exportPayroll.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


} ?>