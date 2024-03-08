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
        $this->load->model('AccountModel');
    }

    public function index()
    {
        $check = $this->admin_model->checkPermission($this->role, 246);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
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
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
        if ($permission->add == 1) {
            // check if alredy exists 
            $check = $this->db->get_where('commission_setting', array('brand_id' => $_POST['brand_id'], 'region_id ' => $_POST['region'], 'month' => $_POST['month'], 'year' => $_POST['year']))->num_rows();
            if ($check == 0) {
                $data['brand_id'] = $_POST['brand_id'];
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
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
        if ($permission->edit == 1) {
            // check if alredy exists 
            $id = base64_decode($_POST['id']);
            $check = $this->db->get_where('commission_setting', array('id !=' => $id, 'brand_id' => $_POST['brand_id'], 'region_id ' => $_POST['region'], 'month' => $_POST['month'], 'year' => $_POST['year']))->num_rows();
            if ($check == 0) {
                $data['brand_id'] = $_POST['brand_id'];
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('commission_setting', 246, 'id', $id, 0, 0, $this->user);
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
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 246);
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
    //************ cash in */
    public function commissionList()
    {
        $check = $this->admin_model->checkPermission($this->role, 243);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 243);

            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('commission/commissionList');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    function commissionGetData()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 243);
        $arr_1_cnt = 0;
        if (isset($_POST['search'])) {
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
        }
        if ($arr_1_cnt <= 0) {
            $arr4  = '1';
        }

        $data['rules'] = $this->Commission_model->AllRules($data['permission'], $arr4)->result_array();

        // var_dump($data);
        // $data['permissions'] = $this->db->query($sql)->result_array();

        echo base64_encode(json_encode($data));
    }
    function get_rule()
    {
        $arr_1_cnt = 0;

        $arr2 = array();
        if (isset($_REQUEST['searchMonth'])) {
            $searchMonth = $_REQUEST['searchMonth'];
            if (!empty($searchMonth)) {
                array_push($arr2, 0);
                $data['searchMonth'] = $searchMonth;
            }
        } else {
            $searchMonth = "";
        }
        if (isset($_REQUEST['searchYear'])) {
            $searchYear = $_REQUEST['searchYear'];
            if (!empty($searchYear)) {
                array_push($arr2, 1);
                $data['searchYear'] = $searchYear;
            }
        } else {
            $searchYear = "";
        }
        if (isset($_REQUEST['searchBrabd'])) {
            $searchBrabd = $_REQUEST['searchBrabd'];
            if (!empty($searchBrabd)) {
                array_push($arr2, 2);
                $data['searchBrabd'] = $searchBrabd;
            }
        } else {
            $searchBrabd = "";
        }
        $cond1 = "month = '$searchMonth'";
        $cond2 = "year = '$searchYear'";
        $cond3 = "brand_id = '$searchBrabd'";

        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        $sql = "SELECT c.*,m.name as month_name,m.value as month_value,b.name as brand_name FROM commission_setting as c
        inner join months as m on c.month = m.id
        inner join brand as b on c.brand_id = b.id where " . $arr4 . " limit 1";

        $data['commission_setting'] = $this->db->query($sql)->row_array();

        echo json_encode($data);
    }
    function commissionCalc()
    {
        $ruleID = $this->input->post('calcid');
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 243);
        if (!$ruleID  || $ruleID == '') {
            $data['jobData'] = array();
            echo json_encode($data);
            return;
        }
        $rules = $this->db->get_where('commission_setting', array('id' => $ruleID))->row();

        $data['rules'] = $this->db->get_where('commission_setting', array('year' => $rules->year, 'month' => $rules->month, 'brand_id' => $rules->brand_id))->result_array();


        $sql = "SELECT 
        created_by,
        pm_name,
        region,
        region_name,
        issue_date,
        MONTH(issue_date) AS months,
        YEAR(issue_date) AS years,
        SUM(profit) AS profit,
        SUM(cost) AS cost,
        SUM(revenue_local) AS revenue_local,
        0 AS commission,
        0 AS man_commission,
        0 AS stn_commission,
        title,
        emp_id,
        manager
    FROM
        (SELECT 
            j.created_by,
                j.profit,
                j.cost,
                j.revenue_local,
                cl.region,
                i.issue_date,
                emp.name AS pm_name,
                re.name AS region_name,
                emp.title AS title,
                emp.id as emp_id,
                emp.manager as manager
        FROM
            job AS j
        LEFT JOIN invoices AS i ON FIND_IN_SET(j.po, i.po_ids) > 0
        LEFT JOIN users AS u ON j.created_by = u.id
        LEFT JOIN job_price_list AS jp ON j.price_list = jp.id
        LEFT JOIN customer_price_list AS cp ON jp.price_list_id = cp.id
        LEFT JOIN customer_leads AS cl ON cp.lead = cl.id
        LEFT JOIN employees AS emp ON u.employees_id = emp.id
        LEFT JOIN regions AS re ON cl.region = re.id
        LEFT JOIN users AS u1 ON u1.employees_id = emp.manager
        
        where i.issue_date >= '$rules->date_from' and i.issue_date <= '$rules->date_to' and   u.brand = $rules->brand_id                       
                    ) as jobs        
                    group by created_by,";
        if ($rules->region_id != null && $rules->region_id != '') {
            $sql .= "region,";
        }
        $sql .= "month(issue_date),year(issue_date)
                    order by created_by";
        // var_dump($sql);
        $jobData = $this->db->query($sql)->result_array();
        $st_array = [
            '12', '28', '29', '65', '73', '99', '153', '211', '213', '230', '240', '32', '98'
        ];
        $tl_array = [
            '28', '73', '99', '32'
        ];
        $mn_arry = ['211', '213'];
        foreach ($jobData as &$row) {
            $man_commission = 0;
            $stn_commission = 0;
            if (in_array($row['emp_id'], $st_array)) {
                $stn_commission  = $row['profit'] * ($rules->standalone_per ?? 0) / 100;
                $row['stn_commission'] =  round($stn_commission, 3);
            } else {
                if ($rules->region_id != null && $rules->region_id != '') { // brnad rules with regions
                    if ($row['region'] != null && $row['region'] != '') {
                        $com_index = 0;
                        foreach ($data['rules'] as $rulesRow) {
                            if ($rulesRow['region_id'] == $row['region']) {
                                break;
                            }
                            $com_index++;
                        }
                        if ($com_index > (count($data['rules']) - 1)) {
                            $comm_arry = null;
                        } else {
                            $comm_arry = $data['rules'][$com_index];
                        }
                    }
                } else { // brnad rules without regions
                    $comm_arry = $data['rules'][0];
                }

                if (!$comm_arry) {
                    continue;
                }
                if ($row['revenue_local'] > 0) {
                    $profit_per = ($row['cost'] / $row['revenue_local']);
                } else {
                    $profit_per = 0;
                }
                $per_sym = "";
                if ($profit_per <= $comm_arry['cogs_per']) {
                    $per_sym = "cogs_per_l";
                } else {
                    $per_sym = "cogs_per_m";
                }
                $temp_rev = $row['revenue_local'];
                $commission = 0;
                $target_val = 0;
                $comm_val = 0;
                $row['commission'] = 0;

                for ($i = 1; $i < 7; $i++) {
                    if ($i == 6) {
                        $flt = '$temp_rev > $comm_arry["rev_target_from_' . strval($i) . '"]';
                    } else {
                        $flt = '$temp_rev > $comm_arry["rev_target_to_' . strval($i) . '"]';
                        // '$temp_rev >= $comm_arry["rev_target_from_' . $i . '"] && $temp_rev < $comm_arry["rev_target_to_' . $i . '"]';
                    }

                    if ($comm_arry['rev_target_from_' . strval($i)] && $comm_arry['rev_target_from_' . strval($i)] != 0) {
                        if (eval("return $flt;")) {
                            if ($i != 6) {
                                $target_val = $comm_arry['rev_target_to_' . strval($i)] - $target_val;
                            } else {
                                $target_val = $temp_rev;
                            }
                            $comm_val =  ($target_val * $comm_arry[$per_sym . strval($i)] / 100);
                            $commission =  $commission + $comm_val;
                            $temp_rev = $temp_rev - $target_val;
                        } else {
                            if ($i != 6) {
                                $target_val =  $target_val;
                            } else {
                                $target_val = $temp_rev;
                            }
                            $comm_val =  ($target_val * $comm_arry[$per_sym . strval($i)] / 100);
                            $commission =  $commission + $comm_val;
                            $temp_rev = $temp_rev - $target_val;
                            // if ($comm_val < 0) {
                            //     print_r('<pre>');
                            //     var_dump($target_val);
                            //     var_dump($comm_val);
                            //     var_dump($temp_rev);
                            //     die;
                            // }
                        }
                    }
                }
                $row['commission'] =  round($commission, 3);
            }
        }
        // teamleader commission
        $clon_arry = $jobData;
        foreach ($clon_arry as &$row) {
            $man_commission = 0;

            if (in_array($row['manager'], $tl_array)) {
                $man_commission  = $row['profit'] * ($rules->teamleader_per ?? 0) / 100;
                foreach ($jobData as &$row_man) {
                    if ($row_man['emp_id'] == $row['manager']) {
                        $row_man['man_commission'] = $row_man['man_commission'] + round($man_commission, 3);
                        // var_dump($row_man['man_commission']);

                        break;
                    }
                }
            }
        }


        $result = array_reduce($jobData, function ($carry, $item) {
            if (!isset($carry[$item['emp_id']])) {
                $carry[$item['emp_id']] = $item;
            } else {
                $carry[$item['emp_id']]['revenue_local'] += $item['revenue_local'];
                $carry[$item['emp_id']]['cost'] += $item['cost'];
                $carry[$item['emp_id']]['profit'] += $item['profit'];
                $carry[$item['emp_id']]['commission'] += $item['commission'];
                $carry[$item['emp_id']]['stn_commission'] += $item['stn_commission'];
                $carry[$item['emp_id']]['man_commission'] += $item['man_commission'];
            }
            return $carry;
        });

        $arrays = $result;

        $jobData = array();
        $i = 0;
        foreach ($arrays as $k => $item) {
            $jobData[$i] = $item;
            unset($arrays[$k]);
            $i++;
        }


        // $jobData = $result;

        $data['jobData'] = $jobData;
        // print_r('<pre>');
        // var_dump($data);
        // die;
        echo json_encode($data);
    }
    public function commissionRules()
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
                    $data['rules'] = $this->Commission_model->AllPmRules($data['permission'], $arr4);
                } else {
                    $data['rules'] = $this->Commission_model->AllPmRules($data['permission'], 1);
                }
            } else {
                $data['rules'] = $this->Commission_model->AllPmRules($data['permission'], 1);
            }

            if (isset($_REQUEST['export'])) {

                // $this->exportCommission($data);
            } else {
                //Pages ..
                $data['total_rows'] = $this->Commission_model->AllPmRules($data['permission'], 1)->num_rows();
                $this->load->view('includes_new/header.php', $data);
                $this->load->view('commission/pmRulesList.php');
                $this->load->view('includes_new/footer.php');
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addPmRule()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 236);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['pm_all'] = $this->db->query("select * from employees where department =12 and status = 0");
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('commission/addPmRule.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
}
