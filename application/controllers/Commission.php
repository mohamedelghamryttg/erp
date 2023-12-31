<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Commission extends CI_Controller
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
        $this->load->model('Commission_model');
    }

    public function index()
    {
        $check = $this->admin_model->checkPermission($this->role, 236);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
            $data['emp_id'] = $this->emp_id;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2, 0);
                        $data['month'] = $month;
                    }
                } else {
                    $month = "";
                }
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 1);
                        $data['year'] = $year;
                    }
                } else {
                    $year = "";
                }
                if (isset($_REQUEST['brand'])) {
                    $brand = $_REQUEST['brand'];
                    if (!empty($brand)) {
                        array_push($arr2, 2);
                        $data['brand'] = $brand;
                    }
                } else {
                    $brand = "";
                }
                $cond1 = "month = '$month'";
                $cond2 = "year = '$year'";
                $cond3 = "brand_id = '$brand'";

                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['rules'] = $this->Commission_model->AllRules($data['permission'], $arr4);
                } else {
                    $data['rules'] = $this->Commission_model->AllRules($data['permission'], 1);
                }
            } else {
                $data['rules'] = $this->Commission_model->AllRules($data['permission'], 1);
            }

            if (isset($_REQUEST['export'])) {

                $this->exportCommission($data);
            } else {
                //Pages ..
                $data['total_rows'] = $this->Commission_model->AllRules($data['permission'], 1)->num_rows();
                $this->load->view('includes_new/header.php', $data);
                $this->load->view('commission/allRules.php');
                $this->load->view('includes_new/footer.php');
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addRule()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('commission/addRule.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddRule()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($permission->add == 1) {
            // check if alredy exists 
            $check = $this->db->get_where('commission_setting', array('brand_id' => $_POST['brand'], 'region_id ' => $_POST['region'], 'month' => $_POST['month'], 'year' => $_POST['year']))->num_rows();
            if ($check == 0) {
                $data['brand_id'] = $_POST['brand'];
                $data['region_id'] = $_POST['region'] ?? null;
                $data['year'] = $_POST['year'];
                $data['month'] = $_POST['month'];
                $data['date_from'] = $_POST['date_from'];
                $data['date_to'] = $_POST['date_to'];
                $data['standalone_per'] = $_POST['standalone_per'];
                $data['teamleader_per'] = $_POST['teamleader_per'];
                $data['cogs_per'] = $_POST['cogs_per'];
                for ($x = 1; $x < 6; $x++) {
                    $data["rev_target_from_$x"] = $_POST["rev_target_from_$x"] ?? null;
                    $data["rev_target_to_$x"] = $_POST["rev_target_to_$x"] ?? null;
                    $data["cogs_per_l$x"] = $_POST["cogs_per_l$x"] ?? null;
                    $data["cogs_per_m$x"] = $_POST["cogs_per_m$x"] ?? null;
                }
                $data["rev_target_6"] = $_POST["rev_target_6"];
                $data["cogs_per_l6"] = $_POST["cogs_per_l6"];
                $data["cogs_per_m6"] = $_POST["cogs_per_m6"];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('commission_setting', $data)) {
                    $true = "Data Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "commission");
                } else {
                    $error = "Failed To Add Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Rule Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editRule()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
            $data['id'] = $_GET['t'];
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('commission_setting', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('commission/editRule.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditRule()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($permission->edit == 1) {
            // check if alredy exists 
            $id = base64_decode($_POST['id']);
            $check = $this->db->get_where('commission_setting', array('id !=' => $id, 'brand_id' => $_POST['brand'], 'region_id ' => $_POST['region'], 'month' => $_POST['month'], 'year' => $_POST['year']))->num_rows();
            if ($check == 0) {
                $data['brand_id'] = $_POST['brand'];
                $data['region_id'] = $_POST['region'] ?? null;
                $data['year'] = $_POST['year'];
                $data['month'] = $_POST['month'];
                $data['date_from'] = $_POST['date_from'];
                $data['date_to'] = $_POST['date_to'];
                $data['standalone_per'] = $_POST['standalone_per'];
                $data['teamleader_per'] = $_POST['teamleader_per'];
                $data['cogs_per'] = $_POST['cogs_per'];
                for ($x = 1; $x < 6; $x++) {
                    $data["rev_target_from_$x"] = $_POST["rev_target_from_$x"] ?? null;
                    $data["rev_target_to_$x"] = $_POST["rev_target_to_$x"] ?? null;
                    $data["cogs_per_l$x"] = $_POST["cogs_per_l$x"] ?? null;
                    $data["cogs_per_m$x"] = $_POST["cogs_per_m$x"] ?? null;
                }
                $data["rev_target_6"] = $_POST["rev_target_6"];
                $data["cogs_per_l6"] = $_POST["cogs_per_l6"];
                $data["cogs_per_m6"] = $_POST["cogs_per_m6"];
                $data['updated_by'] = $this->user;
                $data['updated_at'] = date("Y-m-d H:i:s");
                if ($this->db->update('commission_setting', $data, array('id' => $id))) {
                    $true = "Data Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "commission");
                } else {
                    $error = "Failed To Update Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Rule Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportCommission($data)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($permission == 1) {
            $file_type = "vnd.ms-excel";
            $file_ending = "xls";
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=Commission.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");

            $this->load->view('commission/exportCommission.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteRule()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('commission_setting', 236, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('commission_setting', array('id' => $id))) {
                $true = "Rule Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Rule ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function copyRule()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($permission->edit == 1) {
            $count = 0;
            $error = "";
            // check if alredy exists 
            $month_old = $_POST['month_old'];
            $year_old = $_POST['year_old'];
            // get all data for old month & year
            $old_rules = $this->db->get_where('commission_setting', array('month' => $month_old, 'year' => $year_old))->result();
            if (!empty($old_rules)) {
                foreach ($old_rules as $row) {
                    $data['brand_id'] = $row->brand_id;
                    $data['region_id'] = $row->region_id ?? null;
                    $data['year'] = $_POST['year_new'];
                    $data['month'] = $_POST['month_new'];
                    $data['date_from'] = $_POST['date_from'];
                    $data['date_to'] = $_POST['date_to'];
                    $check = $this->db->get_where('commission_setting', array('brand_id' => $data['brand_id'], 'region_id ' => $data['region_id'], 'month' => $data['month'], 'year' => $data['year']))->num_rows();
                    if ($check == 0) {
                        $count++;
                        unset($row->id);
                        $row->year = $_POST['year_new'];
                        $row->month = $_POST['month_new'];
                        $row->date_from = $_POST['date_from'];
                        $row->date_to = $_POST['date_to'];
                        $row->created_by = $this->user;
                        $row->created_at = date("Y-m-d H:i:s");
                        $this->db->insert('commission_setting', $row);
                    } else {
                        $error .= "Rule Already Exists : " . $this->admin_model->getBrand($row->brand_id) . " --" . $this->admin_model->getRegion($row->region_id) . " --" . $this->accounting_model->getMonth($row->month) . "-- $row->year <br/>";
                    }
                }
                if ($count > 0) {
                    $true = " $count Rule(s) added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    if (strlen($error) > 0) {
                        $error = "$error";
                        $this->session->set_flashdata('error', $error);
                    }
                    redirect(base_url() . "commission");
                } else {
                    $error = "Error ... <br/> $error";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "Rules Doesn't Exists For Selected Month/Year";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
}
