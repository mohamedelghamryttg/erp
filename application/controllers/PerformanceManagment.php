<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PerformanceManagment extends CI_Controller
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

    public function kpi()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 184);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
            $data['emp_id'] = $this->emp_id;
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['employee_title'])) {
                    $employee_title = $_REQUEST['employee_title'];
                    if (!empty($employee_title)) {
                        array_push($arr2, 0);
                        $data['employee_title'] = $employee_title;
                    }
                } else {
                    $data['employee_title'] = $employee_title = "";
                }
                if (isset($_REQUEST['active'])) {
                    $active = $_REQUEST['active'];
                    if (!empty($active)) {
                        array_push($arr2, 1);
                        $data['active'] = $active;
                        if ($active == 2)
                            $active = 0;
                    }
                } else {
                    $data['active'] = $active = "";
                }

                $cond1 = "employee_title = $employee_title";
                $cond2 = "active = $active";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['kpis'] = $this->hr_model->AllKpi($data['permission'], $arr4);
                } else {
                    $data['kpis'] = $this->hr_model->AllKpiPages($data['permission'], 9, 0);
                }
                $data['total_rows'] = $data['kpis']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllKpi($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('performanceManagment/kpi');
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

                $data['kpis'] = $this->hr_model->AllKpiPages($data['permission'], $limit, $offset);
                //echo $data['emp_id'];
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/kpi.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewSingleKpi($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);

            $data['core_headers'] = $this->hr_model->getCoreheaders($id);
            $data['kpi'] = $this->hr_model->getKpi($id);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/viewSingleKpi.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addKpi()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //$data['headers'] = $this->hr_model->getKpiHeaders();
            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/addKpi.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function copyKpi($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;
            $data['core_headers'] = $this->hr_model->getCoreheaders($id);
            $data['kpi'] = $this->hr_model->getKpi($id);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/copyKpi.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddKpi()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission->add == 1) {
            // check if this emp is title manager
            $isManager = $this->db->query("SELECT id FROM employees WHERE title = " . $_POST['employee_title'] . " and manager =" . $this->emp_id . " and status = 0")->row();
            if ($isManager) {
                $manager_id = $this->emp_id;
            } else {
                // if admin/hr insert data
                $manager_id = $this->db->query("SELECT manager FROM employees WHERE title = " . $_POST['employee_title'] . " and status = 0")->row()->manager;
            }

            // $check = $this->db->query("SELECT id FROM kpi WHERE employee_title = " . $_POST['employee_title'] . " and year = " . $_POST['year']. " and month = " . $_POST['month'])->result();

            // $check = $this->db->query("SELECT id FROM kpi WHERE manager_id = " . $this->emp_id . " and employee_title = " . $_POST['employee_title'] . " and year = " . $_POST['year']. " and month = " . $_POST['month'])
//             if (!empty($check)) {
//                    $error = "Error! Kpi with this employee title / year /month already exists";
//                    $this->session->set_flashdata('error', $error);
//                    redirect($_SERVER['HTTP_REFERER']);
//             }
            $data_kpi['manager_id'] = $manager_id;
            $data_kpi['employee_title'] = $_POST['employee_title'];
            $data_kpi['title'] = $_POST['title'];
            $data_kpi['active'] = $_POST['active'];
            $data_kpi['created_at'] = date("Y-m-d H:i:s");
            $data_kpi['created_by'] = $this->user;

            ///insert to table KPI first
            $kpi = $this->db->insert('kpi', $data_kpi);
            if ($kpi) {
                // insert core & sub 
                $kpi_insert_id = $this->db->insert_id();
                // set all other kpi to not active if this active
                $this->hr_model->switchKpiActive($kpi_insert_id);

                $data_core['kpi_id'] = $kpi_insert_id;
                $data_core['created_at'] = date("Y-m-d H:i:s");
                $data_core['created_by'] = $this->user;
                if ($_POST['kpi_id']) {
                    $old_kpi = $this->hr_model->getKpi($_POST['kpi_id']);
                    $cores = $this->hr_model->getCoreheaders($old_kpi->id);
                    foreach ($cores as $key => $value) {
                        $data_core['core_name'] = $value->core_name;
                        if ($this->db->insert('kpi_core', $data_core)) {
                            $data_sub['kpi_core_id'] = $this->db->insert_id();
                            ///add sub 
                            $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                            foreach ($sub as $key => $val) {
                                $data_sub['sub_name'] = $val->sub_name;
                                $data_sub['weight'] = $val->weight;
                                $data_sub['target'] = $val->target;
                                $data_sub['target_type'] = $val->target_type;
                                $data_sub['created_at'] = date("Y-m-d H:i:s");
                                $data_sub['created_by'] = $this->user;
                                $this->db->insert('kpi_sub', $data_sub);
                            }
                        }
                    }
                    $true = "Kpi Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "performanceManagment/kpi");
                } else {
                    for ($i = 0; $i < count($_POST['core_pair']); $i++) {
                        $data_core['core_name'] = $_POST['core_pair'][$i]['core'];
                        if ($this->db->insert('kpi_core', $data_core)) {
                            $data_sub['kpi_core_id'] = $this->db->insert_id();
                            ///add sub 
                            for ($x = 0; $x < count($_POST['core_pair'][$i]['sub_pair']); $x++) {
                                $data_sub['sub_name'] = $_POST['core_pair'][$i]['sub_pair'][$x]['sub'];
                                $data_sub['weight'] = $_POST['core_pair'][$i]['sub_pair'][$x]['weight'];
                                $data_sub['target'] = $_POST['core_pair'][$i]['sub_pair'][$x]['target'];
                                $data_sub['target_type'] = $_POST['core_pair'][$i]['sub_pair'][$x]['target_type'];
                                $data_sub['created_at'] = date("Y-m-d H:i:s");
                                $data_sub['created_by'] = $this->user;
                                $this->db->insert('kpi_sub', $data_sub);
                            }
                        }
                    }
                    $true = "Kpi Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "performanceManagment/kpi");
                }

            } else {
                $error = "Failed To Add Your Request...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportViewSingleKpi()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";

        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 184);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
            //body ..
            $kpi = $this->db->get_where('kpi', array('id' => $_GET['kpi_id']))->row();
            $data['core_headers'] = $this->hr_model->getCoreheaders($kpi->id);
            $employee_title = $data['employee_title'] = $kpi->employee_title;
            $data['year'] = $kpi->year;
            $filename = $this->hr_model->getTitle($employee_title);
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=Kpi_$filename.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('performanceManagment/exportViewSingleKpi.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCore()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission->edit == 1) {
            $id = $_POST['id'];
            $data['core_name'] = $_POST['core_name'];
            // $this->admin_model->addToLoggerUpdate('kpi_core', 184, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('kpi_core', $data, array('id' => $id))) {
                $true = "Kpi Core Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Edit Kpi core ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editSubCore()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission->edit == 1) {
            $id = $_POST['id'];
            //check if subcore has already scores
            $score = $this->db->get_where('kpi_score_data', array('kpi_sub_id' => $id))->row();
            if (!empty($score)) {
                $error = "Error! Kpi Sub already has score ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            $data['sub_name'] = $_POST['sub_name'];
            $data['weight'] = $_POST['weight'];
            $data['target'] = $_POST['target'];
            $data['target_type'] = $_POST['target_type'];
            $this->admin_model->addToLoggerUpdate('kpi_sub', 184, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('kpi_sub', $data, array('id' => $id))) {
                $true = "Kpi Sub Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Edit Kpi Sub ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function kpiScore()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 193);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 0);
                        $data['year'] = $year;
                    }
                } else {
                    $data['year'] = $year = "";
                }
                if (isset($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2, 1);
                        $data['month'] = $month;
                    }
                } else {
                    $data['month'] = $month = "";
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
                $idsArray = array();
                $empIds = "";
                if (isset($_REQUEST['department'])) {
                    $department = $_REQUEST['department'];
                    if (!empty($department)) {
                        array_push($arr2, 3);
                        $data['department'] = $department;
                        $ids = $this->db->select('id')->get_where('employees', array('department' => $department))->result();
                        if (!empty($ids)) {
                            foreach ($ids as $val)
                                array_push($idsArray, $val->id);
                            $empIds = implode(" , ", $idsArray);
                        } else {
                            $empIds = "0";
                        }
                    }
                } else {
                    $data['department'] = $department = "";
                }
                $scoreIdsArray = array();
                $scoreIds = "";
                if (isset($_REQUEST['matrix'])) {
                    $matrix = $_REQUEST['matrix'];
                    if (!empty($matrix)) {
                        array_push($arr2, 4);
                        $data['matrix'] = $matrix;
                        $oldBoundaries = $this->hr_model->getMatrixBoundaries($matrix, 4);
                        $newBoundaries = $this->hr_model->getMatrixBoundaries($matrix, 5);

                        $score_ids = $this->db->query("SELECT DISTINCT(kpi_score_id), sum(score) as sum1 from kpi_score_data where kpi_score_id in(SELECT DISTINCT(id) from kpi_score where year = 4) group BY kpi_score_id HAVING sum1 > " . $oldBoundaries['matrix_min'] . " and sum1 <= " . $oldBoundaries['matrix_max'] . " 
                                UNION 
                                SELECT DISTINCT(kpi_score_id), sum(score) as sum1 from kpi_score_data where kpi_score_id in(SELECT DISTINCT(id) from kpi_score where year >= 5) group BY kpi_score_id HAVING sum1 > " . $newBoundaries['matrix_min'] . " and sum1 <= " . $newBoundaries['matrix_max'])->result();
                        if (!empty($score_ids)) {
                            foreach ($score_ids as $val)
                                array_push($scoreIdsArray, $val->kpi_score_id);
                            $scoreIds = implode(" , ", $scoreIdsArray);
                        } else {
                            $scoreIds = "0";
                        }
                    }
                } else {
                    $data['matrix'] = $matrix = "";
                }
                if (isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 5);
                        $data['status'] = $status;
                        $status = $status - 1;

                    }
                } else {
                    $data['status'] = $status = "";
                }

                $cond1 = "year LIKE '%$year%'";
                $cond2 = "month LIKE '%$month%'";
                $cond3 = "emp_id LIKE '%$employee_name%'";
                $cond4 = "emp_id IN ($empIds)";
                $cond5 = "id IN ($scoreIds)";
                $cond6 = "status = $status";

                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['kpis'] = $this->hr_model->AllKpiScore($data['permission'], $arr4);
                } else {
                    $data['kpis'] = $this->hr_model->AllKpiScorePages($data['permission'], 9, 0);
                }
                $data['total_rows'] = $data['kpis']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllKpiScore($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('performanceManagment/kpiScore');
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

                $data['kpis'] = $this->hr_model->AllKpiScorePages($data['permission'], $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/allkpiScore.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addKpiScore()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;
            $data['emp_title'] = $this->db->query(" SELECT title FROM employees WHERE id = '$this->emp_id' ")->row()->title;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/addKpiScore.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddKpiScore()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($permission->add == 1) {
            $employee_title = $_POST['employee_title'];
            $kpi_id = $_POST['kpi_id'];
            $sqlArray = array();
            $core_headers = $this->hr_model->getCoreheaders($kpi_id);
            // check if already has score           
            $score = $this->db->get_where('kpi_score', array('kpi_id' => $kpi_id, 'emp_id' => $_POST['employee_name'], 'month' => $_POST['month']))->row();

            if (!empty($score)) {
                $error = "Employee has already kpi score for this month & year....";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $score['kpi_id'] = $kpi_id;
            $score['emp_id'] = $_POST['employee_name'];
            $score['year'] = $_POST['year'];
            $score['month'] = $_POST['month'];
            $score['created_at'] = date("Y-m-d H:i:s");
            $score['created_by'] = $this->user;
            $this->db->insert('kpi_score', $score);
            $kpi_score_id = $this->db->insert_id();
            foreach ($core_headers as $key => $value) {
                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                foreach ($sub as $key => $val) {
                    $data_score['kpi_score_id'] = $kpi_score_id;
                    $data_score['kpi_sub_id'] = $val->id;
                    $data_score['weight'] = $_POST['weight' . '_' . $val->id];
                    $data_score['target'] = $_POST['target' . '_' . $val->id];
                    $data_score['achieved'] = $_POST['achieved' . '_' . $val->id];
                    $data_score['score'] = $_POST['score' . '_' . $val->id];
                    $data_score['comment'] = $_POST['comment' . '_' . $val->id];
                    $data_score['created_at'] = date("Y-m-d H:i:s");
                    $data_score['created_by'] = $this->user;
                    array_push($sqlArray, $data_score);
                }
            }
            if ($this->db->insert_batch('kpi_score_data', $sqlArray)) {
                $this->hr_model->sendKpiEmail($this->user, $_POST['employee_name'], $_POST['month'], "new");
                $true = "Records Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "performanceManagment/kpiScore");
            } else {
                $error = "Failed To Add KPI score ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getEmployeesNameByTitle()
    {
        $employee_title = $_POST['employee_title'];
        if ($this->role == 21 || $this->role == 31) {
            $data = $this->db->query("SELECT name,id FROM employees WHERE title = '$employee_title' and status = 0")->result_array();
        } else {
            $data = $this->db->query("SELECT name,id FROM employees WHERE title = '$employee_title' and (manager = '$this->emp_id' or id = '$this->emp_id') and status = 0")->result_array();
        }
        echo json_encode($data);
    }

    public function drawKpiScoreTable()
    {
        $employee_title = $_POST['employee_title'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $employee_name = $_POST['employee_name'];
        $data = $this->hr_model->drawKpiScoreTable($employee_title, $year, $month, $employee_name);
        echo $data;
    }

    public function viewSingleKpiScore($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        $score = $this->db->get_where('kpi_score', array('id' => $id))->row();
        if (($data['permission']->view == 1 && $data['permission']->follow != 2) || ($data['permission']->view == 1 && $score->created_by == $this->user) || ($score->emp_id == $this->emp_id)) {
            //header ..          
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['score'] = $score = $this->db->get_where('kpi_score', array('id' => $id))->row();
            $data['actions'] = $this->db->get_where('kpi_actions', array('kpi_score_id' => $score->id))->result();
            $data['emp_id'] = $this->emp_id;
            $data['employee_id'] = $score->emp_id;
            $data['month'] = $score->month;
            $data['kpi'] = $this->db->get_where('kpi', array('id' => $score->kpi_id))->row();
            $data['core_headers'] = $this->hr_model->getCoreheaders($score->kpi_id);
            $gab = 0;
            $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_score_id = '$score->id'")->result();
            foreach ($score_data as $val) {
                //Average Performance 
                $avgPer = $this->hr_model->getScoreAveragePerformance($val->score, $val->weight, $score->year);
                if ($avgPer) {
                    $gab++;
                }
            }
            $data['gab'] = $gab;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/viewSingleKpiScore.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportViewSingleKpiScore()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";

        // Check Permission ..
        $score_id = base64_decode($_GET['score_id']);
        $data['score'] = $score = $this->db->get_where('kpi_score', array('id' => $score_id))->row();

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);

        if (($data['permission']->view == 1 && $data['permission']->follow != 2) || ($data['permission']->view == 1 && $score->created_by == $this->user) || ($data['permission']->view == 2 && $score->emp_id == $this->emp_id)) {

            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $gab = 0;
            $score_data = $this->db->query("SELECT * From kpi_score_data WHERE kpi_score_id = '$score->id'")->result();
            foreach ($score_data as $val) {
                if (((float) $val->score / (float) $val->weight) * 100 <= 84) {
                    $gab++;
                }
            }
            $data['gab'] = $gab;
            $data['actions'] = $this->db->get_where('kpi_actions', array('kpi_score_id' => $score->id))->result();
            $data['kpi'] = $this->db->get_where('kpi', array('id' => $score->kpi_id))->row();
            $data['core_headers'] = $this->hr_model->getCoreheaders($score->kpi_id);

            $filename = $this->hr_model->getEmployee($score->emp_id) . '(' . $this->accounting_model->getMonth($score->month) . ')';
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=Kpi_Score_$filename.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('performanceManagment/exportViewSingleKpiScore.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCore()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission->add == 1) {
            $data['kpi_id'] = $_POST['kpi_id'];
            $data['core_name'] = $_POST['core_name'];
            if ($this->db->insert('kpi_core', $data)) {
                $true = "Kpi Core Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Kpi core ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addSubCore()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission->add == 1) {
            $data['kpi_core_id'] = $_POST['kpi_core_id'];
            $data['sub_name'] = $_POST['sub_name'];
            $data['weight'] = $_POST['weight'];
            $data['target'] = $_POST['target'];
            if ($this->db->insert('kpi_sub', $data)) {
                $true = "Kpi Sub Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Kpi Sub ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteSub($id)
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->delete == 1) {
            // check if already has score 
            $score = $this->db->get_where('kpi_score_data', array('kpi_sub_id' => $id))->row();
            if (!empty($score)) {
                $error = "Error! Kpi Sub already has score ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->admin_model->addToLoggerDelete('kpi_sub', 184, 'id', $id, 0, 0, $this->user);
                $this->db->delete('kpi_sub', array('id' => $id));
                $true = "Kpi Sub Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCore($id)
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->delete == 1) {
            $sub = $this->db->get_where('kpi_sub', array('kpi_core_id' => $id))->result();
            foreach ($sub as $val) {
                $score = $this->db->get_where('kpi_score_data', array('kpi_sub_id' => $val->id))->row();
                // check if core sub already has score            
                if (!empty($score)) {
                    $error = "Error!There is Sub Core already has score ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            $this->admin_model->addToLoggerDelete('kpi_core', 184, 'id', $id, 0, 0, $this->user);
            $this->db->delete('kpi_core', array('id' => $id));
            $true = "Kpi Core Deleted Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function checkScoreIfExists()
    {

        // check if already has score 
        $kpi = $this->db->query("SELECT * from kpi  WHERE employee_title = " . $_POST['employee_title'] . " and active = 1")->row();

        if (!empty($kpi)) {
            $score = $this->db->get_where('kpi_score', array('emp_id' => $_POST['emp_id'], 'month' => $_POST['month'], 'year' => $_POST['year']))->row();
            if (!empty($score)) {
                $data['status'] = "error";
                $data['msg'] = "Employee has already kpi score for this month & year....";
            } else
                $data['status'] = "success";
        } else {
            $data['status'] = "error";
            $data['msg'] = "kpi for this employee title doesn't exists ,Please check it first ...";
        }


        echo json_encode($data);
    }

    public function checkKpiIfExists()
    {

        // check if already exists
        $check = $this->db->query("SELECT id FROM kpi WHERE employee_title = " . $_POST['employee_title'] . " and year = " . $_POST['year'] . " and month = " . $_POST['month'])
            ->result();
        if (!empty($check)) {
            $data['status'] = "error";
            $data['msg'] = "Kpi with this employee title / year /month already exists";
        } else
            $data['status'] = "success";
        // end check  

        echo json_encode($data);
    }

    public function copyEmployeeKpiScore()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        $id = base64_decode($_GET['score_id']);
        $data['score'] = $score = $this->db->get_where('kpi_score', array('id' => $id))->row();
        if ($data['permission']->add == 1 && (($data['permission']->view == 1 && $data['permission']->follow != 2) || $score->created_by == $this->user)) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;

            $data['kpi'] = $kpi = $this->db->get_where('kpi', array('id' => $score->kpi_id))->row();
            $data['employee_names'] = $this->db->query("SELECT name,id FROM employees WHERE title = $kpi->employee_title and status = 0")->result_array();
            $data['core_headers'] = $this->hr_model->getCoreheaders($score->kpi_id);

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/copyKpiScore.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editEmployeeKpiScore($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        $score = $this->db->get_where('kpi_score', array('id' => $id))->row();
        if ($data['permission']->edit == 1 && $score->created_by == $this->user) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;

            $data['score'] = $score = $this->db->get_where('kpi_score', array('id' => $id))->row();
            $data['kpi'] = $kpi = $this->db->get_where('kpi', array('id' => $score->kpi_id))->row();
            $data['employee_names'] = $this->db->query("SELECT name,id FROM employees WHERE title = $kpi->employee_title and status = 0")->result_array();
            $data['core_headers'] = $this->hr_model->getCoreheaders($score->kpi_id);

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/editKpiScore.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updateKpiScore()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($permission->edit == 1) {

            $score_id = $_POST['score_id'];
            $sqlArray = array();
            $score = $this->db->get_where('kpi_score', array('id' => $score_id))->row();
            $core_headers = $this->hr_model->getCoreheaders($score->kpi_id);
            if ($score->status >= 2) {
                $error = "Error! Kpi Score already accepted Or Send To HR ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }

            foreach ($core_headers as $key => $value) {
                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                foreach ($sub as $key => $val) {
                    $data_score['weight'] = $_POST['weight' . '_' . $val->id];
                    $data_score['target'] = $_POST['target' . '_' . $val->id];
                    $data_score['achieved'] = $_POST['achieved' . '_' . $val->id];
                    $data_score['score'] = $_POST['score' . '_' . $val->id];
                    $data_score['comment'] = $_POST['comment' . '_' . $val->id];
                    $data_score['updated_at'] = date("Y-m-d H:i:s");
                    $data_score['updated_by'] = $this->user;
                    // add to logger
                    $kpi_score_data_id = $this->db->get_where('kpi_score_data', array('kpi_score_id' => $score_id, 'kpi_sub_id' => $val->id))->row()->id;
                    $this->admin_model->addToLoggerUpdate('kpi_score_data', 193, 'id', $kpi_score_data_id, 0, 0, $this->user);

                    $this->db->update('kpi_score_data', $data_score, array('kpi_score_id' => $score_id, 'kpi_sub_id' => $val->id));
                }
            }

            $this->hr_model->sendKpiEmail($this->user, $score->emp_id, $score->month, "update");
            $true = "Records Updated Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "performanceManagment/kpiScore");
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function changeScoreStatus()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($data['permission']->view == 1 || $data['permission']->view == 2) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['emp_id'] = $this->emp_id;

            if (isset($_GET['accept'])) {
                $data_action['status'] = 3;
            } elseif (isset($_GET['reject'])) {
                $data_action['status'] = 2;
            } else {
                $data_action['status'] = 1;
            }

            $this->db->update('kpi_score', $data_action, array('id' => $_GET['score']));

            $score = $this->db->get_where('kpi_score', array('id' => $_GET['score']))->row();
            $this->hr_model->sendKpiEmail($score->created_by, $score->emp_id, $score->month, $this->hr_model->getScoreStatus($_GET['score']));

            redirect(base_url() . "performanceManagment/kpiScore");
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function saveKpiAction()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($permission->edit == 1) {
            $kpi_score_id = $_POST['kpi_score_id'];
            $sqlArray = array();
            foreach ($_POST['kpi_sub_id'] as $key => $value) {
                $data_score['kpi_score_id'] = $kpi_score_id;
                $data_score['kpi_sub_id'] = $value;
                $data_score['action'] = $_POST['action'][$key];
                $data_score['deadline'] = $_POST['deadline'][$key];
                $data_score['owner'] = $_POST['owner'][$key];
                $data_score['comment'] = $_POST['comment'][$key];
                $data_score['created_at'] = date("Y-m-d H:i:s");
                $data_score['created_by'] = $this->user;
                array_push($sqlArray, $data_score);

            }
            if ($this->db->insert_batch('kpi_actions', $sqlArray)) {
                $data['status'] = 1;
                $this->db->update('kpi_score', $data, array('id' => $kpi_score_id));
                //    $this->hr_model->sendKpiEmail($_POST['employee_name'], $_POST['month'], "new");
                $true = "Records Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "performanceManagment/kpiScore");
            } else {
                $error = "Failed To Add KPI score ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteKpiDesign($id)
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->delete == 1) {
            $kpi = $this->db->get_where('kpi', array('id' => $id))->row();
            $score = $this->db->get_where('kpi_score', array('kpi_id' => $kpi->id))->row();
            // check if kpi already has score            
            if (!empty($score)) {
                $error = "Error! Failed To Delete  Kpi already has score ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                // get all core 
                $kpi_core = $this->db->get_where('kpi_core', array('kpi_id' => $kpi->id))->result();
                foreach ($kpi_core as $core) {
                    // get all sub
                    $this->admin_model->addToLoggerDelete('kpi_sub', 184, 'kpi_core_id', $core->id, 0, 0, $this->user);
                    $this->db->delete('kpi_sub', array('kpi_core_id' => $core->id));
                }
                $this->admin_model->addToLoggerDelete('kpi_core', 184, 'kpi_id', $kpi->id, 0, 0, $this->user);
                $this->db->delete('kpi_core', array('kpi_id' => $kpi->id));

                $this->admin_model->addToLoggerDelete('kpi', 184, 'id', $id, 0, 0, $this->user);
                $this->db->delete('kpi', array('id' => $id));
                $true = "Kpi Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }


        } else {
            echo "You have no permission to access this page";
        }
    }

    // log
    public function incidentLog()
    {

        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 195);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 195);
            $data['emp_id'] = $this->emp_id;
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['month'])) {
                    $month = $_REQUEST['month'];
                    if (!empty($month)) {
                        array_push($arr2, 0);
                        $data['month'] = $month;
                    }
                } else {
                    $data['month'] = $month = "";
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
                $cond1 = "MONTH(date) = '$month'";
                $cond2 = "emp_id LIKE '%$employee_name%'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['logs'] = $this->hr_model->AllIncidentLog($data['permission'], $arr4);
                } else {
                    $data['logs'] = $this->hr_model->AllIncidentLogPages($data['permission'], 9, 0);
                }
                $data['total_rows'] = $data['logs']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllIncidentLog($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('performanceManagment/incidentLog');
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

                $data['logs'] = $this->hr_model->AllIncidentLogPages($data['permission'], $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/incidentLog.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewEmployeeincidentLog($employee_id, $month, $sub_core = '')
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 195);
        // get emp manager to check permissions
        $manager_id = $this->db->get_where('employees', array('id' => $employee_id))->row()->manager;

        if ($data['permission']->view == 1 || ($data['permission']->view == 2 && $this->emp_id == $manager_id)) {

            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['emp_id'] = $this->emp_id;
            if ($sub_core)
                $data['logs'] = $this->db->query("SELECT * FROM `kpi_incidents_log` WHERE emp_id = $employee_id AND MONTH(date) = $month AND kpi_sub_id = $sub_core ORDER BY id DESC ")->result();
            else
                $data['logs'] = $this->db->query("SELECT * FROM `kpi_incidents_log` WHERE emp_id = $employee_id AND MONTH(date) = $month ORDER BY id DESC ")->result();
            $data['month'] = $month;
            $data['employee_id'] = $employee_id;
            $data['sub_core'] = $sub_core;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/viewSingleIncidentLog.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLog()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 195);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //$data['headers'] = $this->hr_model->getKpiHeaders();
            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/addLog.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }

    }

    public function saveLog()
    {

        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 195);
        if ($permission->add == 1) {

            $data['emp_id'] = $_POST['emp_id'];
            $data['date'] = $_POST['date'];
            $data['title'] = $_POST['title'];
            $data['comment'] = $_POST['comment'];
            $data['kpi_core_id'] = $_POST['kpi_core_id'];
            $data['kpi_sub_id'] = $_POST['kpi_sub_id'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            if ($_FILES['file']['size'] != 0) {
                $config['file']['upload_path'] = './assets/uploads/performanceManagment/';
                //  $config['file']['upload_path'] = './assets/uploads/performanceManagment/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar|gif|jpg|png|jpeg';
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

            $log = $this->db->insert('kpi_incidents_log', $data);
            if ($log) {
                $true = "Records Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "performanceManagment/incidentLog");

            } else {
                $error = "Failed To Add Your Request...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // end log

    public function deleteKpiScore($id)
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 193);
        if ($data['permission']->delete == 1) {
            $score = $this->db->get_where('kpi_score', array('id' => $id))->row();

            if (empty($score)) {
                $error = "Error! Failed To Delete ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                // delete all kpi score actions   
                $this->admin_model->addToLoggerDelete('kpi_actions', 193, 'kpi_score_id', $id, 0, 0, $this->user);
                $this->db->delete('kpi_actions', array('kpi_score_id' => $id));
                // delete all score data 
                $this->admin_model->addToLoggerDelete('kpi_score_data', 193, 'kpi_score_id', $id, 0, 0, $this->user);
                $this->db->delete('kpi_score_data', array('kpi_score_id' => $id));

                $this->admin_model->addToLoggerDelete('kpi_score', 193, 'id', $id, 0, 0, $this->user);
                $this->db->delete('kpi_score', array('id' => $id));

                $true = "Score Card Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }


        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportAllKpiScore()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 184);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
            $data['emp_id'] = $this->emp_id;
            //body ..
            $arr2 = array();
            if (isset($_REQUEST['year'])) {
                $year = $_REQUEST['year'];
                if (!empty($year)) {
                    array_push($arr2, 0);
                    $data['year'] = $year;
                }
            } else {
                $data['year'] = $year = "";
            }
            if (isset($_REQUEST['month'])) {
                $month = $_REQUEST['month'];
                if (!empty($month)) {
                    array_push($arr2, 1);
                    $data['month'] = $month;
                }
            } else {
                $data['month'] = $month = "";
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
            $idsArray = array();
            $empIds = "";
            if (isset($_REQUEST['department'])) {
                $department = $_REQUEST['department'];
                if (!empty($department)) {
                    array_push($arr2, 3);
                    $data['department'] = $department;
                    $ids = $this->db->select('id')->get_where('employees', array('department' => $department))->result();
                    if (!empty($ids)) {
                        foreach ($ids as $val)
                            array_push($idsArray, $val->id);
                        $empIds = implode(" , ", $idsArray);
                    } else {
                        $empIds = "0";
                    }
                }
            } else {
                $data['department'] = $department = "";
            }
            $scoreIdsArray = array();
            $scoreIds = "";
            if (isset($_REQUEST['matrix'])) {
                $matrix = $_REQUEST['matrix'];
                if (!empty($matrix)) {
                    array_push($arr2, 4);
                    $data['matrix'] = $matrix;
                    $oldBoundaries = $this->hr_model->getMatrixBoundaries($matrix, 4);
                    $newBoundaries = $this->hr_model->getMatrixBoundaries($matrix, 5);

                    $score_ids = $this->db->query("SELECT DISTINCT(kpi_score_id), sum(score) as sum1 from kpi_score_data where kpi_score_id in(SELECT DISTINCT(id) from kpi_score where year = 4) group BY kpi_score_id HAVING sum1 > " . $oldBoundaries['matrix_min'] . " and sum1 <= " . $oldBoundaries['matrix_max'] . " 
                               UNION 
                               SELECT DISTINCT(kpi_score_id), sum(score) as sum1 from kpi_score_data where kpi_score_id in(SELECT DISTINCT(id) from kpi_score where year >= 5) group BY kpi_score_id HAVING sum1 > " . $newBoundaries['matrix_min'] . " and sum1 <= " . $newBoundaries['matrix_max'])->result();
                    if (!empty($score_ids)) {
                        foreach ($score_ids as $val)
                            array_push($scoreIdsArray, $val->kpi_score_id);
                        $scoreIds = implode(" , ", $scoreIdsArray);
                    } else {
                        $scoreIds = "0";
                    }
                }
            } else {
                $data['matrix'] = $matrix = "";
            }
            if (isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    array_push($arr2, 5);
                    $data['status'] = $status;
                    $status = $status - 1;

                }
            } else {
                $data['status'] = $status = "";
            }

            $cond1 = "year LIKE '%$year%'";
            $cond2 = "month LIKE '%$month%'";
            $cond3 = "emp_id LIKE '%$employee_name%'";
            $cond4 = "emp_id IN ($empIds)";
            $cond5 = "id IN ($scoreIds)";
            $cond6 = "status = $status";

            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['kpis'] = $this->hr_model->AllKpiScore($data['permission'], $arr4);
            } else {
                $data['kpis'] = $this->hr_model->AllKpiScore($data['permission'], 1);
            }

            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=AllKpiScore.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->load->view('performanceManagment/exportAllKpiScore.php', $data);
        } else {
            echo "You have no permission to access this page";
        }

    }

    public function getEmployeesByDepartment()
    {
        $department = $_POST['department'];
        $data = '<option value="" selected="selected">-- Select Employee --</option>';
        $data .= $this->hr_model->selectEmployeesByDepartment($department);

        echo $data;
    }

    // get kpi avg. reports
    public function KpiReports()
    {

        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 213);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 213);
            //body ..
            $months_list = array();
            $years_list = array();
            $idsArray = array();
            if (isset($_GET['search']) || isset($_REQUEST['export'])) {

                if (isset($_REQUEST['employee_name'])) {
                    $data['employee_name'] = $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($idsArray, $employee_name);
                    }
                } else {
                    $data['employee_name'] = $employee_name = "";
                }

                if (isset($_REQUEST['department'])) {
                    $department = $_REQUEST['department'];
                    if (!empty($department)) {
                        $data['department'] = $department;
                        if (empty($employee_name)) {
                            $ids = $this->db->select('id')->get_where('employees', array('department' => $department))->result();
                            if (!empty($ids)) {
                                foreach ($ids as $val) {
                                    array_push($idsArray, $val->id);
                                }
                            }
                        }
                    }
                } else {
                    $data['department'] = $department = "";
                }
                // show all
                if (empty($employee_name) && empty($department)) {
                    $ids = $this->db->select('id')->get_where('employees', array('status' => 0))->result();
                    if (!empty($ids)) {
                        foreach ($ids as $val) {
                            array_push($idsArray, $val->id);
                        }
                    }
                }

                if (isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date'])) {
                    // explode year & month 
                    $start_date = explode("-", $_REQUEST['start_date']);
                    $data['start_month'] = $start_month = $start_date[0];
                    $data['start_year'] = $start_year = $start_date[1];
                    $data['start_year_str'] = $start_year_str = $this->hr_model->getYear($start_year);

                } else {
                    $data['start_year'] = $start_year = 0;
                    $data['start_month'] = $start_month = 0;
                }
                if (isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date'])) {
                    // explode year & month  
                    $end_date = explode("-", $_REQUEST['end_date']);
                    $data['end_month'] = $end_month = $end_date[0];
                    $data['end_year'] = $end_year = $end_date[1];
                    $data['end_year_str'] = $end_year_str = $this->hr_model->getYear($end_year);

                } else {
                    $data['end_year'] = $end_year = 0;
                    $data['end_month'] = $end_month = 0;
                }
                // get months & years between 2 dates 
                $start_date_str = new DateTime("$start_year_str-$start_month-01");
                $end_date_str = new DateTime("$end_year_str-$end_month-01");

                $interval = DateInterval::createFromDateString('1 month');
                $period = new DatePeriod($start_date_str, $interval, $end_date_str);
                foreach ($period as $dt) {
                    array_push($months_list, $dt->format("m"));
                    $year_id = $this->db->get_where('years', array('name' => $dt->format("Y")))->row()->id;
                    array_push($years_list, $year_id);
                }
                array_push($months_list, $end_month);
                array_push($years_list, $end_year);
                // start where cond.

                // employees id
                foreach ($idsArray as $emp_id) {
                    $sum = 0;
                    $counter = 0;
                    foreach ($months_list as $k => $val) {
                        //  $score_data = $this->db->query("SELECT sum(score) as sum FROM `kpi_score` Left Join `kpi_score_data` on `kpi_score_data`.kpi_score_id=`kpi_score`.id where month = $val AND year = $years_list[$k] AND emp_id = $emp_id AND status = 3")->row();
                        $score_data = $this->db->query("SELECT sum(score) as sum FROM `kpi_score` Left Join `kpi_score_data` on `kpi_score_data`.kpi_score_id=`kpi_score`.id where month = $val AND year = $years_list[$k] AND emp_id = $emp_id")->row();
                        $data['scores'][$emp_id][$val][$years_list[$k]] = $score_data->sum ? number_format($score_data->sum, 2) . ' %' : "--";
                        if ($score_data->sum) {
                            $sum += number_format($score_data->sum, 2);
                            $counter++;
                        }
                    }
                    $data['counter'][$emp_id] = $counter;
                    $data['score_avg'][$emp_id] = $counter != 0 ? number_format($sum / $counter, 2) : 0;
                    //                    print_r($data['scores']);
                }
                //                echo'<br/>';
//               exit();
            }
            //Pages ..
            $data['years_list'] = $years_list;
            $data['months_list'] = $months_list;
            $data['employees'] = $idsArray;
            $data['total_rows'] = count($idsArray);
            if (isset($_REQUEST['export'])) {
                $this->exportKpiReport($data);
            }
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('performanceManagment/kpiReport.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }


    }

    public function exportKpiReport($data)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 213);
        if ($permission == 1) {
            $file_type = "vnd.ms-excel";
            $file_ending = "xls";
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=KpiScoreReport_" . date('d-m-Y') . ".$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");


            $this->load->view('performanceManagment/exportKpiReport.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }

    // for incident log kpi core&sub
    public function getKpiByEmployeesName()
    {

        $employee_title = $this->db->query("SELECT title FROM employees WHERE id = " . $_POST['employee_id'])->row()->title;
        $kpi = $this->db->query("SELECT id FROM kpi WHERE employee_title = " . $employee_title . " AND active = 1 ")->row();
        $data = '<option value="" selected="selected" disabled>-- Select  --</option>';
        if (!empty($kpi)) {
            $data .= $this->hr_model->selectActiveKpiCore($kpi->id);
        }
        echo $data;

    }

    public function getKpiSubByCore()
    {
        $kpi_core = $_POST['kpi_core_id'];
        $data = '<option value="" selected="selected" disabled>-- Select  --</option>';
        $data .= $this->hr_model->selectActiveKpiSubCore($kpi_core);

        echo $data;
    }

    // for active kpi
    public function setKpiActive($kpi_id)
    {
        // set all other kpi to not active if this active
        $data['active'] = 1;
        if ($this->db->update('kpi', $data, array('id ' => $kpi_id))) {
            $this->hr_model->switchKpiActive($kpi_id);
            $true = "Kpi Actived Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Error, Failed To Update Kpi  ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function editKpiTitle()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($permission) {
            $kpi_id = $_POST['kpi_id'];
            $this->admin_model->addToLoggerUpdate('kpi', 184, 'id', $kpi_id, 0, 0, $this->user);
            $data['title'] = $_POST['title'];
            if ($this->db->update('kpi', $data, array('id' => $kpi_id))) {
                $true = "Kpi Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Edit Kpi  ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}

?>