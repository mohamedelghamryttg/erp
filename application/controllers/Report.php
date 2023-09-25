<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
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
    }
    public function inHouseTeam()
    {
        $check = $this->admin_model->checkPermission($this->role, 132);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 132);
            //body ..
            $brand = $this->brand;
            if (isset($_POST['search'])) {
                if (isset($_REQUEST['report'])) {
                    $data['report'] = $_REQUEST['report'];
                    if ($data['report'] == 1) {
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
                            if (isset($_REQUEST['inHouseTeam'])) {
                                $dtp = $_REQUEST['inHouseTeam'];
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
                                $data['job'] = $this->projects_model->AllDTPJobs($data['permission'], $this->user, $this->brand, $arr4);
                            } else {
                                $data['job'] = $this->projects_model->AllDTPJobs($data['permission'], $this->user, 0, 1);
                            }
                        } else {
                            $data['job'] = $this->projects_model->AllDTPJobs($data['permission'], $this->user, 0, 1);
                        }
                    } elseif ($data['report'] == 2) {
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
                            if (isset($_REQUEST['inHouseTeam'])) {
                                $le = $_REQUEST['inHouseTeam'];
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
                                $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, $this->brand, $arr4);
                            } else {
                                $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, 0, 1);
                            }
                        } else {
                            $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, 0, 1);
                        }
                    } elseif ($data['report'] == 3) {
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
                            if (isset($_REQUEST['inHouseTeam'])) {
                                $translator = $_REQUEST['inHouseTeam'];
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
                    }
                }
            } else {
                $data['report'] = 0;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('admin/inHouseTeam.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportInHouseTeam()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";
        header("Content-Type: application/$file_type");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 132);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 132);
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
                        $data['job'] = $this->projects_model->AllDTPJobs($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllDTPJobs($data['permission'], $this->user, 0, 1);
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
                        $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllLEJobs($data['permission'], $this->user, 0, 1);
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
                        $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, $this->brand, $arr4);
                    } else {
                        $data['job'] = $this->projects_model->AllTranslationJobs($data['permission'], $this->user, 0, 1);
                    }
                }
            }
            //Pages ..
            $this->load->view('admin/exportInHouseTeam.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getInHouseTeam()
    {
        $team = $_POST['team'];
        echo '<option value="" selected="selected" disabled="">-- Select Member --</option>';
        if ($team == 1) {
            echo $this->admin_model->selectAllDTP($this->brand);
        } else if ($team == 2) {
            echo $this->admin_model->selectAllLE($this->brand);
        } else if ($team == 3) {
            echo $this->admin_model->selectAllTranslator($this->brand);
        }
    }



    public function dtpCOGS()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 142);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 142);
            //body ..

            if (isset($_GET['search'])) {
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

                // print_r($arr2);

                $cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";

                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->admin_model->dtpCOGS($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->admin_model->dtpCOGS($data['permission'], $this->user, 0, 0);
                }
            } else {
                $data['project'] = $this->admin_model->dtpCOGS($data['permission'], $this->user, 0, 0);
            }
            // //Pages ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/dtpCOGS.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportDtpCOGS()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP COGS.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 142);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 142);
            //body ..

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

            // print_r($arr2);

            $cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";

            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['project'] = $this->admin_model->dtpCOGS($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['project'] = $this->admin_model->dtpCOGS($data['permission'], $this->user, 0, 0);
            }


            //Pages ..

            $this->load->view('admin/exportDtpCOGS.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    /////late vpos hagar 
    public function lateVPOs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 127);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 127);
            //body ..
            $data['jobs'] = $this->projects_model->jobsWithoutTasks($this->brand);
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/latevpos.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    ///////////
    public function activeCustomers()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 171);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 171);
            //body ..

            if (isset($_GET['search'])) {
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

                // print_r($arr2);

                // $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";      
                $cond1 = "j.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['customer'] = $this->projects_model->AllPMOCustomer($data['permission'], $this->user, $this->brand, $arr4);
                }
            }
            // //Pages ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('projects/activeCustomers.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function translationCOGS()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 190);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 190);
            //body ..

            if (isset($_GET['search'])) {
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

                // print_r($arr2);

                // $cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->admin_model->translationCOGS($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->admin_model->translationCOGS($data['permission'], $this->user, 0, 0);
                }
            } else {
                $data['project'] = $this->admin_model->translationCOGS($data['permission'], $this->user, 0, 0);
            }
            // //Pages ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/translationCOGS.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportTranslationCOGS()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation COGS.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 190);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 190);
            //body ..

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

            // print_r($arr2);

            //$cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";      
            //$cond1 = "j.closed_date BETWEEN '$date_from' AND '$date_to' ";
            $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['project'] = $this->admin_model->translationCOGS($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['project'] = $this->admin_model->translationCOGS($data['permission'], $this->user, 0, 0);
            }


            //Pages ..

            $this->load->view('admin/exportTranslationCOGS.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function leCOGS()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 191);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 191);
            //body ..

            if (isset($_GET['search'])) {
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

                // print_r($arr2);

                //$cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->admin_model->leCOGS($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->admin_model->leCOGS($data['permission'], $this->user, 0, 0);
                }
            } else {
                $data['project'] = $this->admin_model->leCOGS($data['permission'], $this->user, 0, 0);
            }
            // //Pages ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/leCOGS.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportLeCOGS()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=LE COGS.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 191);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 191);
            //body ..

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

            // print_r($arr2);

            //$cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['project'] = $this->admin_model->leCOGS($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['project'] = $this->admin_model->leCOGS($data['permission'], $this->user, 0, 0);
            }


            //Pages ..

            $this->load->view('admin/exportLeCOGS.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function accountingDtpCOGS()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 192);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 192);
            //body ..

            if (isset($_GET['search'])) {
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

                // print_r($arr2);

                //$cond1 = "j.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->admin_model->accountingDtpCOGS($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->admin_model->accountingDtpCOGS($data['permission'], $this->user, 0, 0);
                }
            } else {
                $data['project'] = $this->admin_model->accountingDtpCOGS($data['permission'], $this->user, 0, 0);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/accountingDtpCOGS.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportAccountingDtpCOGS()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=AccountingDTPCOGS.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 192);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 192);
            //body ..

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

            // print_r($arr2);

            //$cond1 = "j.closed_date BETWEEN '$date_from' AND '$date_to'";
            $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['project'] = $this->admin_model->accountingDtpCOGS($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['project'] = $this->admin_model->accountingDtpCOGS($data['permission'], $this->user, 0, 0);
            }


            //Pages ..

            $this->load->view('admin/exportAccountingDtpCOGS.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }
}
