<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{

    public $role, $user, $brand, $chart;

    public function __construct()
    {
        parent::__construct();
        // $this->load->library('Excelfile');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->admin_model->verfiyLogin();
        $this->load->model('AccountModel');
        $this->load->model('CreateDatabase');
        $this->load->library('form_validation');
        $this->load->library('Excelfile');
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }
    public function createDataBase()
    {
        try {

            $this->CreateDatabase->createDatabaseAccountTables();

            $error = $this->db->error()["message"];

            if (!empty($error)) {
                // throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $error['message']);
            } else {
                $true = "Account Database is Recreated Successfully ...";
                $this->session->set_flashdata('true', $true);
                $this->accountConfig();
                redirect(base_url('account/accountConfig'));
            }
        } catch (Exception $e) {
            // this will not catch DB related errors. But it will include them, because this is more general. 
            // log_message('error: ',$e->getMessage() );
            echo json_encode($e);
        }
    }
    public function accountList($startfrom = 0)
    {

        $check = $this->admin_model->checkPermission($this->role, 218);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 218);
            $limit = 15;
            $offset = $this->uri->segment(3);
            $data['brand'] = $this->brand;
            $data['i'] = $startfrom;
            $data['offset'] = $offset;
            // $data['brand_name'] = $this->admin_model->getbrand($this->brand);
            $data['account_name'] = '';
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['account_name'])) {
                    $account_name = $_REQUEST['account_name'];
                } else {
                    $account_name = "";
                }
                $data['account_name'] = $account_name;
                if ($account_name != "") {
                    $data['chart'] = $this->db->query("select * from account_chart where brand = " . $this->brand . " and name like '%" . $account_name . "%' order by acode")->result();
                } else {
                    $data['chart'] = $this->db->query("select * from account_chart where brand = " . $this->brand . " order by acode" . " limit " . $limit . " OFFSET  " . $offset)->result();
                }
            } else {

                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $data['chart'] = $this->AccountModel->get_chart_list($limit, $offset);
                // $sql = "select * from account_chart where brand = " . $this->brand . " order by `acode`" . " limit " . $limit . " OFFSET  " . $offset;
                // $data['chart'] = $this->db->query("select * from account_chart where brand = " . $this->brand . " order by `acode`" . " limit " . $limit . " OFFSET  " . $offset);


                $count = $this->db->get_where('account_chart', ['brand' => $this->brand])->num_rows();
                $config['base_url'] = base_url('account/accountList');
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
            }
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/chart/accountList');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    function importaccount()
    {
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            // $object = PHPExcel_IOFactory::load($path);
            $inputFileType = PHPExcel_IOFactory::identify($path);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $flag = true;
            $i = 0;

            foreach ($allDataInSheet as $value) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                $inserdata[$i]['ccode'] = $value['A'];
                $inserdata[$i]['name'] = $value['C'];
                $inserdata[$i]['acode'] = $value['B'];
                $inserdata[$i]['brand'] = $this->brand;
                //$inserdata[$i]['parent'] = $this->AccountModel->getByID('brand', $this->brand);
                $inserdata[$i]['parent_id'] = ($this->AccountModel->getByNAME('account_chart', $value['D'])) ?? 0;
                $inserdata[$i]['parent'] = $value['D'];
                $inserdata[$i]['acc_thrd_party'] = false;

                $inserdata[$i]['level'] = $value['I'];
                $inserdata[$i]['acc'] = $value['J'];
                $inserdata[$i]['acode'] = '';
                // Create code And Levels //
                $v_acode = '';
                if ($inserdata[$i]['ccode'] <> '') {
                    $account = explode(".", $inserdata[$i]['ccode']);
                    for ($ii = 0; $ii < count($account); $ii++) {
                        if ($ii > 0) {
                            $v_acode .= "-";
                        }
                        if ($ii === 0) {
                            $v_acode = str_pad($account[$ii], 2, '0', STR_PAD_LEFT);
                        } else if ($ii === 1) {
                            $v_acode .= str_pad($account[$ii], 2, "0", STR_PAD_LEFT);
                        } else {
                            $v_acode .= str_pad($account[$ii], 3, "0", STR_PAD_LEFT);
                        }
                    }
                }
                $inserdata[$i]['acode'] = $v_acode;
                //str_pad($v_acode, 16, "0", STR_PAD_RIGHT);
                $i++;
            }
            $this->AccountModel->insertimport($inserdata, $this->brand);
            if ($inserdata) {
                echo "Imported successfully";
            } else {
                echo "ERROR !";
            }
        }
    }
    public function exportaccount()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=AccountofChart_" . $this->admin_model->getBrand($this->brand) . ".$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['chart'] = $this->db->get('account_chart');

        $this->load->view('account/chart/exportaccount', $data);
    }
    public function _example_output($output = null)
    {

        $this->load->view('account/chart/accountList', $output);
    }

    public function doeditaccount()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 218);
        if ($permission->edit == 1) {
            $data['id'] = base64_decode($_POST['id']);

            $data['ccode'] = $this->input->post('ccode');
            $data['acode'] = $this->input->post('acode');
            $data['name'] = $this->input->post('name');

            $found_rec = $this->db->query("SELECT * FROM account_chart WHERE (name ='" . $this->input->post('name') . "' OR ccode = '" . $this->input->post('ccode') . "') and brand ='" . $this->brand . "' and id <> '" . $data['id'] . "'");
            if ($found_rec->num_rows() > 0) {
                $error = "Failed To Update Account to Chart , Duplicate Found...";
                $this->session->set_flashdata('error', $error);
                echo "account/accountList";
                return;
            }

            $data['acc_type_id'] = $this->input->post('acc_type_id');
            $data['acc_type'] = $this->AccountModel->getByID('account_type', $this->input->post('acc_type_id'));
            $data['acc_close_id'] = $this->input->post('acc_close_id');
            $data['acc_close'] = $this->AccountModel->getByID('account_close', $this->input->post('acc_close_id'));
            $data['parent_id'] = $this->input->post('parent_id');
            $data['parent'] = $this->AccountModel->getByID('account_chart', $this->input->post('parent_id'));
            $data['currency_id'] = $this->input->post('currency_id');
            $data['currency'] = $this->AccountModel->getByID('currency', $this->input->post('currency_id'));
            $data['brand'] = $this->brand;
            $data['acc_thrd_party'] = $this->input->post('acc_thrd_party') ?? 0;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            $curr_row = $this->AccountModel->get_accountRowID($data['id']);
            if ($curr_row->parent_id == $data['parent_id']) {
                if ($this->db->update('account_chart', $data, array('id' => $data['id']))) {
                    $true = "Accounr Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                } else {
                    $error = "Failed To Edit Account ...";
                    $this->session->set_flashdata('error', $error);
                }
                echo "account/accountList";
            } else {
                //**********//

                $data['ccode'] = $this->input->post('ccode');

                $data['name'] = $this->input->post('name');
                $data['acc_type_id'] = $this->input->post('acc_type_id');
                $data['acc_type'] = $this->AccountModel->getByID('account_type', $this->input->post('acc_type_id'));
                $data['acc_close_id'] = $this->input->post('acc_close_id');
                $data['acc_close'] = $this->AccountModel->getByID('account_close', $this->input->post('acc_close_id'));
                $data['parent_id'] = $this->input->post('parent_id');
                $data['parent'] = $this->AccountModel->getByID('account_chart', $this->input->post('parent_id'));
                $data['currency_id'] = $this->input->post('currency_id');
                $data['currency'] = $this->AccountModel->getByID('currency', $this->input->post('currency_id'));
                $data['brand'] = $this->brand;
                $data['acc_thrd_party'] = $this->input->post('acc_thrd_party') ?? 0;
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");

                $parent_query = $this->AccountModel->get_lastrecord('account_chart', $data['parent_id']);
                $last_code = $parent_query->acode;

                if ($last_code == '' || $last_code == null) {
                    if ($data['parent_id'] == '' || $data['parent_id'] == null) {
                        $mcode = "00";
                        $mlevel = 1;
                    } else {
                        $sel_parant = $this->AccountModel->get_accountRowID($data['parent_id']);
                        $mcode = $sel_parant->acode;
                        $mlevel = $sel_parant->level + 1;
                    }
                } else {
                    $mcode = $last_code;
                    $mlevel = $parent_query->level;
                }

                $array_code = explode('-', $mcode);

                if ($mlevel < 2) {
                    $array_code[$mlevel - 1] = str_pad($array_code[$mlevel - 1] + 1, 2, '0', STR_PAD_LEFT);
                } else {
                    $array_code[$mlevel - 1] = str_pad($array_code[$mlevel - 1] + 1, 3, '0', STR_PAD_LEFT);
                }
                $v_acode = implode('-', $array_code);
                $v_level = $mlevel;
                $data['acode'] = $v_acode;
                $data['level'] = $v_level;
                // var_dump($array_code);
                // die;
                if ($this->db->update('account_chart', $data, array('id' => $data['id']))) {


                    //**********//
                    $parent_check = $this->db->get_where('account_chart', ['parent_id' => $curr_row->parent_id])->num_rows();
                    if ($parent_check != 0) {
                        $parent_data['acc'] = 1;
                    } else {
                        $parent_data['acc'] = 0;
                    }
                    $this->db->update('account_chart', $parent_data, array('id' => $curr_row->parent_id));
                    //************/
                    $parent_check = $this->db->get_where('account_chart', ['parent_id' => $data['parent_id']])->num_rows();
                    if ($parent_check != 0) {
                        $parent_data['acc'] = 1;
                    } else {
                        $parent_data['acc'] = 0;
                    }
                    $this->db->update('account_chart', $parent_data, array('id' => $data['parent_id']));
                    //************/

                    $true = "Accounr Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                } else {
                    $error = "Failed To Edit Account ...";
                    $this->session->set_flashdata('error', $error);
                }
                echo "account/accountList";
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editaccount()
    {
        $check = $this->admin_model->checkPermission($this->role, 12);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 12);
            //body ..
            $id = base64_decode($_GET['t']);

            $data['account_chart'] = $this->db->get_where('account_chart', ['id' => $id])->row();

            $data['brand'] = $this->brand;
            $data['brand_name'] = $this->admin_model->getbrand($this->brand);
            $data['role'] = $this->role;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/chart/accountEdit');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addAccount()
    {
        $data['brand'] = $this->brand;
        $data['group'] = $this->admin_model->getGroupByRole($this->role);

        $this->load->view('includes_new/header.php', $data);
        $this->load->view('account/chart/accountAdd');
        $this->load->view('includes_new/footer.php');
    }
    public function doaddaccount()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 218);
        if ($permission->add == 1) {
            $parent_id = $this->input->post('parent_id');
            if ($parent_id == '' || $parent_id == null) {
                $parent_id = 0;
            } else {
                $parent_id = $this->input->post('parent_id');
            }
            $found_rec = $this->db->query("SELECT * FROM account_chart WHERE (name ='" . $this->input->post('name') . "' OR ccode = '" . $this->input->post('ccode') . "') and brand ='" . $this->brand . "'");
            if ($found_rec->num_rows() > 0) {
                $error = "Failed To Add Account to Chart , Already Found...";
                $this->session->set_flashdata('error', $error);
                echo "account/accountList";
                return;
            }

            $parent_query = $this->AccountModel->get_lastrecord('account_chart', $parent_id);
            $last_code = $parent_query->acode;

            if ($last_code == '' || $last_code == null) {
                if ($parent_id == '' || $parent_id == null) {
                    $mcode = "00";
                    $mlevel = 1;
                } else {
                    $sel_parant = $this->AccountModel->get_accountRowID($parent_id);
                    $mcode = $sel_parant->acode;
                    $mlevel = $sel_parant->level + 1;
                }
            } else {
                $mcode = $last_code;
                $mlevel = $parent_query->level;
            }

            $array_code = explode('-', $mcode);

            if ($mlevel < 2) {
                $array_code[$mlevel - 1] = str_pad($array_code[$mlevel - 1] + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $array_code[$mlevel - 1] = str_pad($array_code[$mlevel - 1] + 1, 3, '0', STR_PAD_LEFT);
            }
            $v_acode = implode('-', $array_code);
            $v_level = $mlevel;

            $data['acode'] = $v_acode;
            $data['ccode'] = $this->input->post('ccode');
            $data['name'] = $this->input->post('name');
            $data['acc_type_id'] = $this->input->post('acc_type_id');
            $data['acc_type'] = $this->AccountModel->getByID('account_type', $this->input->post('acc_type_id'));
            $data['acc_close_id'] = $this->input->post('acc_close_id');
            $data['acc_close'] = $this->AccountModel->getByID('account_close', $this->input->post('acc_close_id'));
            $data['parent_id'] = $this->input->post('parent_id') ?? 0;
            $data['parent'] = $this->AccountModel->getByID('account_chart', $this->input->post('parent_id')) ?? 0;
            $data['currency_id'] = $this->input->post('currency_id');
            $data['currency'] = $this->AccountModel->getByID('currency', $this->input->post('currency_id')) ?? '';
            $data['brand'] = $this->brand;
            $data['level'] = $v_level;
            $data['acc'] = '0';
            $data['acc_thrd_party'] = $this->input->post('acc_thrd_party') ?? 0;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('account_chart', $data)) {

                $this->db->where('id', $parent_id);
                $this->db->update('account_chart', array('acc' => '1'));
                $true = "Acoount Added Successfully to Chart ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Add Account to Chart ...";
                $this->session->set_flashdata('error', $error);
            }

            echo "account/accountList";
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function accountDelete()
    {

        $this->db->where('id', base64_decode($_GET['t']));
        $this->db->delete('account_chart');
        redirect(base_url('account/accountList'));
    }

    public function create_close()
    {
        $data_array = [
            [
                'name' => 'Trading',
            ],
            [
                'name' => 'Profit & Loss',
            ],
            [
                'name' => 'Operation',
            ],
            [
                'name' => 'Revenue & Expenses',
            ],
            [
                'name' => 'Balance Sheet',
            ],
            [
                'name' => 'Others',
            ],
        ];

        $this->AccountModel->insert_data('account_chart', $data_array);

        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 216);

        $data_menu = $this->AccountModel->getaccountByParentId(0);
        $data['chart'] = json_encode($data_menu);

        $this->load->view('includes_new/header.php', $data);
        $this->load->view('account/accountTree.php');
        $this->load->view('includes_new/footer.php');
    }

    public function create_type()
    {
        $data_array = [
            [
                'name' => 'Cash',
            ],
            [
                'name' => 'Receivables',
            ],
            [
                'name' => 'Payables',
            ],
            [
                'name' => 'Revenue',
            ],
            [
                'name' => 'Expense',
            ],
            [
                'name' => 'Others',
            ],
        ];

        $this->AccountModel->insert_data('account_chart', $data_array);

        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 216);

        $data_menu = $this->AccountModel->getaccountByParentId(0);
        $data['chart'] = json_encode($data_menu);

        $this->load->view('includes_new/header.php', $data);
        $this->load->view('account/accountTree.php');
        $this->load->view('includes_new/footer.php');
    }


    public function view_chart()
    {

        $id = $this->input->post('id');
        $get_data = $this->db->get_where('account_chart', array('id' => $id))->row_array();

        $data['chart'] = $get_data;
        $this->load->view('account/view_account_data', $data);
    }


    public function calc_code()
    {
        $id = $this->input->post('id');

        $get_id = $this->AccountModel->get_lastrecord('account_chart', $id);
        $return_data['id'] = $get_id['id'];
        $return_data['acode'] = $get_id['acode'];
        $return_data['level'] = $get_id['level'];

        echo json_encode($return_data);
    }
    // start banks //
    public function bankCode()
    {

        $check = $this->admin_model->checkPermission($this->role, 223);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 223);

            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $cond = "brand = '$this->brand'";
            if (isset($_POST['search'])) {
                $arr2 = array();
                array_push($arr2, 0);
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['account_id'])) {
                    $account_id = $_REQUEST['account_id'];
                    if (!empty($account_id)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $account_id = "";
                }


                $cond1 = "id = '$name'";
                $cond2 = "account_id = '$account_id'";

                $arr1 = array($cond, $cond1, $cond2);
                $arr3 = array();
                for ($i = 0; $i < count($arr2); $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                $data['banks'] = $this->AccountModel->AllBanksPages($limit, $offset, $arr4);
                $data['total_rows'] = $data['banks']->num_rows();
                $count = $this->AccountModel->AllBanks($arr4)->num_rows();
            } else {
                $data['banks'] = $this->AccountModel->AllBanksPages($limit, $offset, $cond);
                $data['total_rows'] = $data['banks']->num_rows();
                $count = $this->AccountModel->AllBanks($cond)->num_rows();
            }
            $config['base_url'] = base_url('account/bankCode');
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
            $link = [
                'offset' => $offset,
                'brand' => $this->admin_model->getBrand($this->brand)
            ];
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/bankCode', $link);
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function exportBanks()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Banks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
        //body ..
        $data['user'] = $this->user;
        $arr2 = array();
        if (isset($_REQUEST['name'])) {
            $name = $_REQUEST['name'];
            if (!empty($name)) {
                array_push($arr2, 0);
            }
        } else {
            $name = "";
        }
        if (isset($_REQUEST['account_id'])) {
            $account_id = $_REQUEST['account_id'];
            if (!empty($account_id)) {
                array_push($arr2, 1);
            }
        } else {
            $account_id = "";
        }

        $cond1 = "brand = '$this->brand'";
        $cond2 = "id = '$name'";
        $cond3 = "account_id = '$account_id'";

        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        if ($arr_1_cnt > 0) {
            $data['banks'] = $this->AccountModel->AllBanks($arr4);
        } else {
            $data['banks'] = $this->AccountModel->AllBanks($cond1);
        }
        $this->load->view('account/bank/exportAllBanks', $data);
    }

    public function allBanks($update = "")
    {
    }

    public function addBank()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/addBank');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddBank()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
        if ($permission->add == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('bank')->where('name=', $_POST['name'])->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $data['name'] = $_POST['name'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['account_id'] = $_POST['account_id'];
            $data['brand'] = $this->brand;
            echo json_encode(['records' => 0]);

            if ($this->db->insert('bank', $data)) {
                $true = "Bank Added Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Add Bank ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editBank()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['banks'] = $this->db->get_where('bank', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/editBank');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditBank($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 223);
        if ($permission->edit == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('bank')->where('name=', $_POST['name'])->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['account_id'] = $_POST['account_id'];
            echo json_encode(['records' => 0]);
            $this->admin_model->addToLoggerUpdate('bank', 223, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('bank', $data, array('id' => $id))) {
                $true = "Bank Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Edit Bank ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteBank($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 223);
        if ($check) {
            $this->admin_model->addToLoggerDelete('bank', 223, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('bank', array('id' => $id))) {
                $true = "Bank Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "account/bankCode");
            } else {
                $error = "Failed To Delete Bak ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "account/bankCode");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // End banks //
    function cashcode()
    {

        $check = $this->admin_model->checkPermission($this->role, 222);
        if ($check) {
            //header
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
            //body
            $limit = 8;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $cond = "brand = '$this->brand'";
            if (isset($_POST['search'])) {
                $arr2 = array();
                array_push($arr2, 0);
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['account_id'])) {
                    $account_id = $_REQUEST['account_id'];
                    if (!empty($account_id)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $account_id = "";
                }
                if (isset($_REQUEST['currency_id'])) {
                    $currency_id = $_REQUEST['currency_id'];
                    if (!empty($currency_id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $currency_id = "";
                }

                $cond1 = "id = '$name'";
                $cond2 = "account_id = '$account_id'";
                $cond3 = "currency_id = '$currency_id'";
                $arr1 = array($cond, $cond1, $cond2, $cond3);
                $arr3 = array();
                for ($i = 0; $i < count($arr2); $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                $data['cash_code'] = $this->AccountModel->AddCashCodePages($limit, $offset, $arr4);
                $data['total_rows'] = $data['cash_code']->num_rows();
                $count = $this->AccountModel->AddCashCode($arr4)->num_rows();
            } else {
                $data['cash_code'] = $this->AccountModel->AddCashCodePages($limit, $offset, $cond);
                $data['total_rows'] = $data['cash_code']->num_rows();
                $count = $this->AccountModel->AddCashCode($cond)->num_rows();
            }
            $config['base_url'] = base_url('account/cashcode');
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
            $link = [
                'offset' => $offset,
                'brand' => $this->admin_model->getBrand($this->brand)
            ];
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/cashcode', $link);
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exporcashcode()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=cash_code.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        //body ..
        $data['user'] = $this->user;
        $arr2 = array();
        if (isset($_REQUEST['name'])) {
            $name = $_REQUEST['name'];
            if (!empty($name)) {
                array_push($arr2, 0);
            }
        } else {
            $name = "";
        }
        if (isset($_REQUEST['account_id'])) {
            $account_id = $_REQUEST['account_id'];
            if (!empty($account_id)) {
                array_push($arr2, 1);
            }
        } else {
            $account_id = "";
        }
        if (isset($_REQUEST['currency_id'])) {
            $currency_id = $_REQUEST['currency_id'];
            if (!empty($currency_id)) {
                array_push($arr2, 3);
            }
        } else {
            $currency_id = "";
        }
        $cond1 = "brand = '$this->brand'";
        $cond2 = "id = '$name'";
        $cond3 = "account_id = '$account_id'";
        $cond4 = "currency_id = '$currency_id'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        if ($arr_1_cnt > 0) {
            $data['cash_code'] = $this->AccountModel->AddCashCode($arr4);
        } else {
            $data['cash_code'] = $this->AccountModel->AddCashCode($cond1);
        }
        $this->load->view('account/cash/exportCash', $data);
    }

    public function addcashcode()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($data['permission']->add == 1) {

            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/addcashcode');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doaddcashcode()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($permission->add == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('cash_code')->where('name=', $_POST['name'])->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $data['name'] = $_POST['name'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['account_id'] = $_POST['account_id'];
            $data['currency_id'] = $_POST['currency_id'];
            $data['brand'] = $this->brand;
            echo json_encode(['records' => 0]);

            if ($this->db->insert('cash_code', $data)) {
                $true = "Cash Added Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Add Cash ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editcash()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['cash_code'] = $this->db->get_where('cash_code', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/editcash');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditcash($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($permission->edit == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('cash_code')->where('name=', $_POST['name'])->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['account_id'] = $_POST['account_id'];
            $data['currency_id'] = $_POST['currency_id'];
            echo json_encode(['records' => 0]);
            $this->admin_model->addToLoggerUpdate('cash_code', 219, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('cash_code', $data, array('id' => $id))) {
                $true = "cash Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Edit cash ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deletecash($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 219);
        if ($check) {
            $this->admin_model->addToLoggerDelete('cash_code', 219, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('cash_code', array('id' => $id))) {
                $true = "Cash Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "account/cashcode");
            } else {
                $error = "Failed To Delete Cash ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "account/cashcode");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    ///////// paymentmethodcode/////
    function paymentmethodcode()
    {
        $check = $this->admin_model->checkPermission($this->role, 207);
        if ($check) {
            //header
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
            //body
            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $cond = "brand = '$this->brand'";
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }

                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['account_id'])) {
                    $account_id = $_REQUEST['account_id'];
                    if (!empty($account_id)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $account_id = "";
                }
                if (isset($_REQUEST['currency_id'])) {
                    $currency_id = $_REQUEST['currency_id'];
                    if (!empty($currency_id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $currency_id = "";
                }
                $cond1 = "name like '%$name%'";
                $cond2 = "type = '$type'";
                $cond3 = "account_id = '$account_id'";
                $cond4 = "currency_id = '$currency_id'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr3 = array();
                for ($i = 0; $i < count($arr2); $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                $data['payment_method'] = $this->AccountModel->AllPaymentMethodfilter($limit, $offset, $arr4, $this->brand);
                //$data['total_rows'] = $data['payment_method']->num_rows();
                $count = $this->AccountModel->AllPaymentMethodfilter(0, 0, $arr4, $this->brand)->num_rows();
            } else {
                $data['payment_method'] = $this->AccountModel->AllPaymentMethodPages($limit, $offset, $cond);
                $count = $this->AccountModel->AllPaymentMethodfilter(0, 0, $cond, $this->brand)->num_rows();
            }

            $config['base_url'] = base_url('account/paymentmethodcode');
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

            $data['brand'] = $this->admin_model->getBrand($this->brand);
            $data['offset'] = $offset;
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/payment/paymentmethodcode');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportpaymentmethodcode()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=payment_method.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        //body ..
        $data['user'] = $this->user;
        $arr2 = array();
        if (isset($_REQUEST['type'])) {
            $type = $_REQUEST['type'];
            if (!empty($type)) {
                array_push($arr2, 0);
            }
        } else {
            $type = "";
        }
        if (isset($_REQUEST['account_id'])) {
            $account_id = $_REQUEST['account_id'];
            if (!empty($account_id)) {
                array_push($arr2, 1);
            }
        } else {
            $account_id = "";
        }
        if (isset($_REQUEST['currency_id'])) {
            $currency_id = $_REQUEST['currency_id'];
            if (!empty($currency_id)) {
                array_push($arr2, 3);
            }
        } else {
            $currency_id = "";
        }
        $cond1 = "brand = '$this->brand'";
        $cond2 = "type = '$type'";
        $cond3 = "account_id = '$account_id'";
        $cond4 = "currency_id = '$currency_id'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        if ($arr_1_cnt > 0) {
            $data['payment_method'] = $this->AccountModel->AllPaymentMethod($arr4, $this->brand);
        } else {
            $data['payment_method'] = $this->AccountModel->AllPaymentMethod($cond1);
        }
        $this->load->view('account/payment/exportpaymentmethodcode', $data);
    }

    public function Addpaymentmethodcode()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/payment/addpaymentmethodcode');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddpaymentmethodcode()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        if ($permission->add == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('payment_method')->where('name=', $_POST['name'])->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $setup = $this->AccountModel->getSetup();
            $data['name'] = $_POST['name'];
            $data['type'] = $_POST['type'];
            $data['payment_desc'] = $_POST['payment_desc'];
            if (isset($_POST['acc_code'])) {
                $data['acc_code'] = $_POST['acc_code'];
            } else {
                $data['acc_code'] = '';
            }
            if (isset($_POST['bank'])) {
                $data['bank'] = $_POST['bank'];
            } else {
                $data['bank'] = '';
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['account_id'] = $_POST['account_id'];
            $data['currency_id'] = $_POST['currency_id'];
            $data['brand'] = $this->brand;
            if ($data['type'] == 1) {
                $data['ost_id'] = $setup->cash_acc_id;
                $data['ost_code'] = $setup->cash_acc_acode;
                $data['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->cash_acc_id)->parent_id;
                $data['p_ost_code'] = $this->AccountModel->get_accountRowID($data['p_ost_id'])->acode;
            } else {
                if ($data['type'] == 2) {
                    $data['ost_id'] = $setup->bank_acc_id;
                    $data['ost_code'] = $setup->bank_acc_acode;
                    $data['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->bank_acc_id)->parent_id;
                    $data['p_ost_code'] = $this->AccountModel->get_accountRowID($data['p_ost_id'])->acode;
                } else {
                    $data['ost_id'] = '';
                    $data['ost_code'] = '';
                    $data['p_ost_code'] = '';
                    $data['p_ost_id'] = '';
                }
            }

            echo json_encode(['records' => 0]);

            if ($this->db->insert('payment_method', $data)) {
                $true = "payment Added Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Add payment ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editpaymentmethodcode()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $id = base64_decode($_GET['t']);
            $data['payment_method'] = $this->db->get_where('payment_method', array('id' => $id))->row();
            // print_r('<pre>');
            // print_r($data);
            // die;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/payment/editpaymentmethodcode');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doeditpaymentmethodcode($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        if ($permission->edit == 1) {
            if (isset($_POST['name'])) {
                $records = $this->db->select('*')->from('payment_method')->where('name=', $_POST['name'])->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $setup = $this->AccountModel->getSetup();

            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['type'] = $_POST['type'];
            $data['payment_desc'] = $_POST['payment_desc'];
            if (isset($_POST['acc_code'])) {
                $data['acc_code'] = $_POST['acc_code'];
            } else {
                $data['acc_code'] = '';
            }
            if (isset($_POST['bank'])) {
                $data['bank'] = $_POST['bank'];
            } else {
                $data['bank'] = '';
            }

            $data['created_by'] = $this->user;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['account_id'] = $_POST['account_id'];
            $data['currency_id'] = $_POST['currency_id'];
            $data['brand'] = $this->brand;
            if ($data['type'] == 1) {
                $data['ost_id'] = $setup->cash_acc_id;
                $data['ost_code'] = $setup->cash_acc_acode;
                $data['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->cash_acc_id)->parent_id;
                $data['p_ost_code'] = $this->AccountModel->get_accountRowID($data['p_ost_id'])->acode;
            } else {
                if ($data['type'] == 2) {
                    $data['ost_id'] = $setup->bank_acc_id;
                    $data['ost_code'] = $setup->bank_acc_acode;
                    $data['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->bank_acc_id)->parent_id;
                    $data['p_ost_code'] = $this->AccountModel->get_accountRowID($data['p_ost_id'])->acode;
                } else {
                    $data['ost_id'] = '';
                    $data['ost_code'] = '';
                    $data['p_ost_code'] = '';
                    $data['p_ost_id'] = '';
                }
            }


            echo json_encode(['records' => 0]);
            $this->admin_model->addToLoggerUpdate('payment_method', 207, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('payment_method', $data, array('id' => $id))) {
                $true = "payment Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Edit payment ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deletepaymentmethodcode($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 207);
        if ($check) {
            $this->admin_model->addToLoggerDelete('payment_method', 207, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('payment_method', array('id' => $id))) {
                $true = "paymentmethod Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "account/paymentmethodcode");
            } else {
                $error = "Failed To Delete paymentmethod ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "account/paymentmethodcode");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function accountConfig()
    {
        $check = $this->admin_model->checkPermission($this->role, 217);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 217);
            $data['brand'] = $this->brand;
            $data['brand_name'] = $this->admin_model->getbrand($this->brand);
            // print_r($this->brand);
            // die;
            if ($this->db->get_where('acc_setup', array('brand' => $this->brand))->num_rows() == 0) {
                $data1['brand'] = $this->brand;
                $this->db->insert('acc_setup', $data1);
            }
            $data['accConfig'] = $this->db->get_where('acc_setup', array('brand' => $this->brand))->row();
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/setup/accountConfig');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
        $this->load->helper('file');
    }
    public function saveAccountConfig()
    {
        $id = $this->input->post('id');
        $row_num = $this->db->get_where('acc_setup', array('brand' => $this->brand))->num_rows();

        $data['cashin_num'] = $this->input->post('cashin_num');
        $data['cashout_num'] = $this->input->post('cashout_num');
        $data['bankin_num'] = $this->input->post('bankin_num');
        $data['bankout_num'] = $this->input->post('bankout_num');
        $data['manual_num'] = $this->input->post('manual_num');
        $data['rec_num'] = $this->input->post('rec_num');
        $data['pay_num'] = $this->input->post('pay_num');
        $data['rev_num'] = $this->input->post('rev_num');
        $data['exp_num'] = $this->input->post('exp_num');
        $data['begin_num'] = $this->input->post('begin_num');
        $data['cash_acc_id'] = $this->input->post('cash_acc_id');
        $data['cash_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('cash_acc_id'))->acode) ?? '';

        $data['bank_acc_id'] = $this->input->post('bank_acc_id');
        $data['bank_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('bank_acc_id'))->acode) ?? '';
        $data['cust_acc_id'] = $this->input->post('cust_acc_id');
        $data['cust_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('cust_acc_id'))->acode) ?? '';
        $data['ven_acc_id'] = $this->input->post('ven_acc_id');
        $data['ven_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('ven_acc_id'))->acode) ?? '';

        $data['rev_acc_id'] = $this->input->post('rev_acc_id');
        $data['rev_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('rev_acc_id'))->acode) ?? '';
        $data['exp_acc_id'] = $this->input->post('exp_acc_id');
        $data['exp_acc_acode'] = ($this->AccountModel->getchartData($this->input->post('exp_acc_id'))->acode) ?? '';

        $data['local_currency_id'] = $this->input->post('local_currency_id');
        // $data['sdate1'] = date("Y-m-d", strtotime($this->input->post('sdate1')));
        // $data['sdate2'] = date("Y-m-d", strtotime($this->input->post('sdate2')));

        $data['sdate1'] = $this->input->post('sdate1');
        $data['sdate2'] = $this->input->post('sdate2');
        // echo $data;


        if ($row_num == 0) {
            $data['brand'] = $this->brand;
            if ($this->db->insert('acc_setup', $data)) {
                $true = "Account Configration Update Successfully  ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Update Account Configration ...";
                $this->session->set_flashdata('error', $error);
            }
        } else {
            $this->db->where('id', $id);
            if ($this->db->update('acc_setup', $data)) {
                $true = "Account Configration Update Successfully  ...";
                $this->session->set_flashdata('true', $true);
            } else {
                $error = "Failed To Update Account Configration ...";
                $this->session->set_flashdata('error', $error);
            }
        }
        // echo 'account/accountConfig';
    }
    //************ cash in */
    public function cashintrnlist()
    {
        $check = $this->admin_model->checkPermission($this->role, 221);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
            $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 239);

            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;

            $type = "1";
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/cashintrnlist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function receipt_print($id)
    {
        $this->load->view('account/cash/receipt_print');
    }
    public function get_cashInList()
    {
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 239);

        $data['user'] = $this->user;
        $data['brand'] = $this->brand;
        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $type = "1";
        $filter_data = $this->input->post('filter_data');
        parse_str($filter_data, $params);
        $arr2 = array();
        // var_dump($this->input->post('searchCash'));
        if ($filter_data) {

            if (isset($params['searchCash'])) {
                $searchCash = $params['searchCash'];
                if (!empty($searchCash)) {
                    array_push($arr2, 0);
                }
            } else {
                $searchCash = "";
            }

            if (isset($params['searchCdate']) && $params['searchCdate'] != '') {
                $searchCdate = explode(' - ', $params['searchCdate']);

                $date1 = explode('/', $searchCdate[0]);
                $date2 = explode('/', $searchCdate[1]);

                $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_from = date("Y-m-d", strtotime($finalDate1));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($finalDate2)));
                if (!empty($finalDate1) && !empty($finalDate2)) {
                    array_push($arr2, 1);
                }
            } else {
                $searchCdate = "";
                $date_from = "";
                $date_to = "";
            }

            if (isset($params['searchSer'])) {
                $searchSer = $params['searchSer'];
                if (!empty($searchSer)) {
                    array_push($arr2, 2);
                }
            } else {
                $searchSer = "";
            }
            if (isset($params['searchRevenue'])) {
                $searchRevenue = $params['searchRevenue'];
                if (!empty($searchRevenue)) {
                    array_push($arr2, 3);
                }
            } else {
                $searchRevenue = "";
            }

            if (isset($params['searchCcode'])) {
                $searchCcode = $params['searchCcode'];
                if (!empty($searchCcode)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchCcode = "";
            }
        } else {
            $searchCash = "";
            $searchSer = "";
            $searchRevenue = "";
            $searchCcode = "";
            $date_from = "";
            $date_to = "";
        }

        $cond1 = "bank_id = '$searchCash'";
        $cond2 = "date BETWEEN '$date_from' AND '$date_to' ";
        $cond3 = "ccode like '%$searchSer%'";
        $cond4 = "trn_id = '$searchRevenue'";
        $cond5 = "doc_no like '%$searchCcode%'";

        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();

        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // ************//
        // var_dump($arr2);
        if ($arr_1_cnt > 0) {
            $data['cash_trn'] = $this->AccountModel->AllCashPages($this->brand, $type, $arr4)->result_array();;
        } else {
            $data['cash_trn'] = $this->AccountModel->AllCashPages($this->brand, $type, '1')->result_array();;
        }
        echo base64_encode(json_encode($data));
    }

    public function editCashinTrn($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 239);
        if ($data['permission']->edit == 1 || $data['audit_permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $id = base64_decode($id);
            $data['cashin'] = $this->db->get_where('cashin', array('id' => $id, 'brand' => $this->brand))->row();
            $data['acc_setup'] = $setup;
            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }
            $cash_select = $this->db->get_where('payment_method', array('id' => $data['cashin']->cash_id))->row()->account_id;
            $account_select = $this->db->get_where('account_chart', array('id' => $cash_select))->row();
            $data['cash_acc_id'] = $account_select->id;
            $data['cash_acc'] = $account_select->acode;
            $data['cash_acc_name'] = $account_select->name;
            $data['brand'] = $this->brand;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/editCashinTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditCashinTrn_audit()
    {
        $id = base64_decode($_POST['aud_id']);
        $data['audit_chk'] = $this->input->post('audit_chk');
        if ($data['audit_chk']) {
            $data['audit_comment'] = $_POST['audit_comment'];
            $data['audit_date'] =  date('Y-m-d H:i:s');
            $data['audit_by'] = $this->user;
        } else {
            $data['audit_comment'] = '';
            $data['audit_date']  = null;
            $data['audit_by'] = '';
        }
        if ($this->db->update('cashin', $data, array('id' => $id))) {
            $this->admin_model->addToLoggerUpdate('cashin', 239, 'id', $id, 0, 0, $this->user);
            $true = "Audit Successfully ...";
            $this->session->set_flashdata('true', $true);

            echo json_encode(['records' => 0]);
        } else {
            $error = "Failed To Audit Cash In Entry ...";
            $this->session->set_flashdata('error', $error);
            echo json_encode(['records' => 1]);
        }
    }
    public function doEditCashinTrn()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        if ($permission->edit == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('cashin')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }

            $id = base64_decode($_POST['id']);
            $serial = str_pad($_POST['serial'], 10, '0', STR_PAD_LEFT);
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['cash_id'] = $_POST['cash_id'];
            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];

            $data['desc_file'] = $_POST['desc_file'];
            $data['name_file'] = $_POST['fileuploadspan'];

            $fileToatt = $_POST['fileToDelete'];
            $new_file = $_FILES['doc_file']['name'];

            if ($new_file == true) {
                $new_file = str_replace(' ', "-", $_FILES['doc_file']['name']);
                if ($_FILES['doc_file']['size'] != 0) {
                    if (!is_dir('./assets/uploads/account/cashin/')) {
                        mkdir('./assets/uploads/account/cashin/', 0777, TRUE);
                    }
                    $config['file']['upload_path'] = './assets/uploads/account/cashin/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 5000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('doc_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 2]);
                        return;
                    } else {
                        if ($fileToatt && $fileToatt != '') {
                            if (file_exists('./assets/uploads/account/cashin/' . $fileToatt)) {
                                unlink('./assets/uploads/account/cashin/' . $fileToatt);
                            }
                        }
                        $data_file = $this->file_upload->data();
                        $data['doc_file'] = $data_file['file_name'];
                    }
                } else {
                    $data['doc_file'] = "";
                    $data['name_file'] = "";
                }
            }

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['cash_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);

            $this->admin_model->addToLoggerUpdate('cashin', 221, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('cashin', $data, array('id' => $id))) {

                $this->db->delete('entry_data_total', array('trns_type' => "Cash In", 'trns_id' => $id));
                $this->db->delete('entry_data', array('trns_type' => "Cash In", 'trns_id' => $id));
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Cash In";
                $entry_data['trns_id'] = $id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] =  (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_account'] = '';
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_at'] = date('Y-m-d H:i:s');
                $entry_data['created_by'] = $this->user;

                $entry_data['deb_amount'] = $_POST['amount'];
                $entry_data['deb_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['deb_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['ev_crd'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Cash In",
                    'trns_id' => $id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'deb_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'crd_account' => $_POST['trn_id'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Cash In", 'trns_id' => $id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['deb_amount'] = 0;
                        $entry_data['deb_acc_id'] = '';
                        $entry_data['deb_acc_acode'] = '';
                        $entry_data['ev_deb'] = 0;
                        $entry_data['deb_account'] = '';
                        $entry_data['crd_account'] = $_POST['trn_id'];

                        $entry_data['crd_amount'] = $_POST['amount'];
                        $entry_data['crd_acc_id'] = $_POST['trn_id'];
                        $entry_data['crd_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Cash In Edited Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Edit Cash In Entry ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Edit Cash In Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addCashinTrn()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 239);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;
            $data['parent_id'] = $setup->cash_acc_id;
            $data['parent_acode'] = $setup->cash_acc_acode;
            $data['parent_name'] = $this->AccountModel->getByID('account_chart', $data['parent_id']);
            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }
            $data['brand'] = $this->brand;

            $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/addCashinTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCashinTrn()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        if ($permission->add == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('cashin')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $setup = $this->AccountModel->getsetup();

            $cash_code = doubleval($setup->cashin_num);
            $newcash = $cash_code + 1;
            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('cashin_num' => str_pad($newcash, 10, "0", STR_PAD_LEFT)));

            $serial = str_pad($newcash, 10, '0', STR_PAD_LEFT);
            $data['cash_type'] = 1; //1 for cash in - 2 for cash out
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['cash_id'] = $_POST['cash_id'];

            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];
            $data['brand'] = $this->brand;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            $data['desc_file'] = $_POST['desc_file'];

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['cash_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);
            if ($_FILES['doc_file']['size'] != 0) {
                if (!is_dir('./assets/uploads/account/cashin/')) {
                    mkdir('./assets/uploads/account/cashin/', 0777, TRUE);
                }
                $config['file']['upload_path'] = './assets/uploads/account/cashin/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 5000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('doc_file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 2]);
                    return;
                } else {
                    $data_file = $this->file_upload->data();
                    $data['doc_file'] = $data_file['file_name'];
                    $data['name_file'] = $data_file['orig_name'];
                }
            } else {
                $data['doc_file'] = "";
                $data['name_file'] = "";
            }

            if ($this->db->insert('cashin', $data)) {
                $cashin_id = $this->db->insert_id();

                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Cash In";
                $entry_data['trns_id'] = $cashin_id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_account'] = '';
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_by'] = $this->user;
                $entry_data['created_at'] = date('Y-m-d H:i:s');

                $entry_data['deb_amount'] = $_POST['amount'];
                $entry_data['deb_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['deb_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['ev_crd'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Cash In",
                    'trns_id' => $cashin_id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'deb_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'crd_account' => $_POST['trn_id'],

                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Cash In", 'trns_id' => $cashin_id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['deb_amount'] = 0;
                        $entry_data['deb_acc_id'] = '';
                        $entry_data['deb_acc_acode'] = '';
                        $entry_data['ev_deb'] = 0;
                        $entry_data['deb_account'] = '';
                        $entry_data['crd_account'] = $_POST['trn_id'];
                        $entry_data['crd_amount'] = $_POST['amount'];
                        $entry_data['crd_acc_id'] = $_POST['trn_id'];
                        $entry_data['crd_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Cash In Add Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Add Cash In Entry ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Add Cash In Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function get_trn_currency()
    {
        $cash_id = $this->input->post('cash_id', TRUE);
        $date = $this->input->post('date', TRUE);

        if ($cash_id != '') {
            $cash_pay = $this->db->get_where('payment_method', array('id' => $cash_id))->row();
            $data['currency_id'] = $cash_pay->currency_id;
            $data['options'] = $this->admin_model->selectCurrency($data['currency_id']);
            $data['rate'] = $this->AccountModel->getrate($data['currency_id'], $date);
            $account = $this->db->query("SELECT * FROM account_chart where id = '" . $cash_pay->account_id . "'")->row();

            $data['cash_acc_acode'] = $account->acode;
            $data['cash_acc_id'] = $account->id;

            $data['cash_acc_ccode'] = $account->ccode;
            $data['cash_acc_name'] = $account->name;
            echo json_encode($data);
        }
    }
    public function get_trn_account()
    {
        $account_id = $this->input->post('account_id', TRUE);
        if ($account_id != '') {
            $account = $this->db->get_where('account_chart', array('id' => $account_id))->row();
            $data['acc_third_party'] = $account->acc_thrd_party;
            $data['acc_name'] = $account->name;
            $type = $account->acc_type_id;
            $source_table = "";
            if ($type >= 1 && $type <= 4) {
                $source_table = "payment_method";
            } else if ($type == 5) {
                $source_table = "customer";
            } else if ($type == 6) {
                $source_table = "vendor";
            }
            if ($source_table != "")
                $data['combo'] = $this->AccountModel->selectCombo_New($source_table);
            echo json_encode($data);
        } else
            echo '';
    }
    public function get_trn_currency_rate()
    {
        $currency_hid = $this->input->post('currency_hid');
        $date = $this->input->post('date');
        $setup = $this->AccountModel->getsetup();

        if (isset($setup->local_currency_id)) {
            $data['local_currency'] = $setup->local_currency_id;
        } else {
            $data['local_currency'] = '';
        }

        if ($data['local_currency'] == $currency_hid) {
            $data['rate'] = 1;
            echo json_encode($data);
        } else {
            if ($currency_hid != '' && $date) {
                if ($this->AccountModel->getrate($currency_hid, $date)) {
                    $data['rate'] = $this->AccountModel->getrate($currency_hid, $date);
                    echo json_encode($data);
                } else {
                    echo json_encode('');
                }
            } else {
                echo json_encode('');
            }
        }
    }
    public function deleteCashinTrn($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 221);
        if ($check) {
            $this->admin_model->addToLoggerDelete('cashin', 221, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('cashin', array('id' => $id))) {
                $fileToatt = $this->db->get_where('cashin', array('id' => $id))->row()->doc_file;
                if ($fileToatt && $fileToatt != '') {
                    unlink('./assets/uploads/account/cashin/' . $fileToatt);
                }
                if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Cash In'))) {
                    if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Cash In'))) {
                        $true = "Cash In Deleted Successfully ...";
                        $this->session->set_flashdata('true', $true);
                    }
                }
            } else {
                $error = "Failed To Delete Cash In ...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url() . "account/cashintrnlist");
        } else {
            echo "You have no permission to access this page";
        }
    }

    //************ cash out */
    public function cashouttrnlist()
    {
        $check = $this->admin_model->checkPermission($this->role, 221);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
            $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 240);

            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;

            $type = "2";
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/cashouttrnlist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function get_cashOutList()
    {
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 221);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 239);

        $data['user'] = $this->user;
        $data['brand'] = $this->brand;
        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $type = "2";
        $filter_data = $this->input->post('filter_data');
        parse_str($filter_data, $params);
        $arr2 = array();
        if ($filter_data) {

            if (isset($params['searchCash'])) {
                $searchCash = $params['searchCash'];
                if (!empty($searchCash)) {
                    array_push($arr2, 0);
                }
            } else {
                $searchCash = "";
            }

            if (isset($params['searchCdate']) && $params['searchCdate'] != '') {
                $searchCdate = explode(' - ', $params['searchCdate']);

                $date1 = explode('/', $searchCdate[0]);
                $date2 = explode('/', $searchCdate[1]);

                $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_from = date("Y-m-d", strtotime($finalDate1));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($finalDate2)));
                if (!empty($finalDate1) && !empty($finalDate2)) {
                    array_push($arr2, 1);
                }
            } else {
                $searchCdate = "";
                $date_from = "";
                $date_to = "";
            }

            if (isset($params['searchSer'])) {
                $searchSer = $params['searchSer'];
                if (!empty($searchSer)) {
                    array_push($arr2, 2);
                }
            } else {
                $searchSer = "";
            }
            if (isset($params['searchRevenue'])) {
                $searchRevenue = $params['searchRevenue'];
                if (!empty($searchRevenue)) {
                    array_push($arr2, 3);
                }
            } else {
                $searchRevenue = "";
            }

            if (isset($params['searchCcode'])) {
                $searchCcode = $params['searchCcode'];
                if (!empty($searchCcode)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchCcode = "";
            }
        } else {
            $searchCash = "";
            $searchSer = "";
            $searchRevenue = "";
            $searchCcode = "";
            $date_from = "";
            $date_to = "";
        }

        $cond1 = "bank_id = '$searchCash'";
        $cond2 = "date BETWEEN '$date_from' AND '$date_to' ";
        $cond3 = "ccode like '%$searchSer%'";
        $cond4 = "trn_id = '$searchRevenue'";
        $cond5 = "doc_no like '%$searchCcode%'";

        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();

        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // ************//
        if ($arr_1_cnt > 0) {
            $data['cash_trn'] = $this->AccountModel->AllCashPages($this->brand, $type, $arr4)->result_array();;
        } else {
            $data['cash_trn'] = $this->AccountModel->AllCashPages($this->brand, $type, '1')->result_array();;
        }
        echo base64_encode(json_encode($data));
    }

    public function editCashoutTrn($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 240);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $id = base64_decode($id);
            $data['cashout'] = $this->db->get_where('cashout', array('id' => $id, 'brand' => $this->brand))->row();
            $data['acc_setup'] = $setup;
            if ($setup->rev_acc_id != 0) {
                $data['exp_id'] = $setup->exp_acc_id;
                $data['exp_acode'] = $setup->exp_acc_acode;
                $data['exp_name'] = $this->AccountModel->getByID('account_chart', $data['exp_id']);
            } else {
                $data['exp_name'] = "-";
            }
            $cash_select = $this->db->get_where('payment_method', array('id' => $data['cashout']->cash_id))->row()->account_id;
            $account_select = $this->db->get_where('account_chart', array('id' => $cash_select))->row();
            $data['cash_acc_id'] = $account_select->id;
            $data['cash_acc'] = $account_select->acode;
            $data['cash_acc_name'] = $account_select->name;
            $data['brand'] = $this->brand;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/EditCashoutTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditCashoutTrn_audit()
    {
        $id = base64_decode($_POST['aud_id']);
        $data['audit_chk'] = $this->input->post('audit_chk');
        if ($data['audit_chk']) {
            $data['audit_comment'] = $_POST['audit_comment'];
            $data['audit_date'] =  date('Y-m-d H:i:s');
            $data['audit_by'] = $this->user;
        } else {
            $data['audit_comment'] = '';
            $data['audit_date']  = null;
            $data['audit_by'] = '';
        }
        if ($this->db->update('cashout', $data, array('id' => $id))) {
            $this->admin_model->addToLoggerUpdate('cashout', 240, 'id', $id, 0, 0, $this->user);
            $true = "Audit Successfully ...";
            $this->session->set_flashdata('true', $true);

            echo json_encode(['records' => 0]);
        } else {
            $error = "Failed To Audit Cash Out Entry ...";
            $this->session->set_flashdata('error', $error);
            echo json_encode(['records' => 1]);
        }
    }
    public function doEditCashoutTrn()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($permission->edit == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('cashout')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();

                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $id = base64_decode($_POST['id']);
            $serial = str_pad($_POST['serial'], 10, '0', STR_PAD_LEFT);
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['cash_id'] = $_POST['cash_id'];
            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;
            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];

            $data['desc_file'] = $_POST['desc_file'];
            $data['name_file'] = $_POST['fileuploadspan'];

            $fileToatt = $_POST['fileToDelete'];
            $new_file = $_FILES['doc_file']['name'];
            if ($new_file == true) {
                $new_file = str_replace(' ', "-", $_FILES['doc_file']['name']);
                if ($_FILES['doc_file']['size'] != 0) {
                    if (!is_dir('./assets/uploads/account/cashout/')) {
                        mkdir('./assets/uploads/account/cashout/', 0777, TRUE);
                    }
                    $config['file']['upload_path'] = './assets/uploads/account/cashout/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 5000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('doc_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 2]);
                        return;
                    } else {
                        if ($fileToatt && $fileToatt != '') {
                            if (file_exists('./assets/uploads/account/cashout/' . $fileToatt)) {
                                unlink('./assets/uploads/account/cashout/' . $fileToatt);
                            }
                        }
                        $data_file = $this->file_upload->data();
                        $data['doc_file'] = $data_file['file_name'];
                    }
                } else {
                    $data['doc_file'] = "";
                    $data['name_file'] = "";
                }
            }

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['cash_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);

            $data['brand'] = $this->brand;
            $this->admin_model->addToLoggerUpdate('cashout', 222, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('cashout', $data, array('id' => $id))) {

                $this->db->delete('entry_data_total', array('trns_type' => "Cash Out", 'trns_id' => $id));
                $this->db->delete('entry_data', array('trns_type' => "Cash Out", 'trns_id' => $id));
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Cash Out";
                $entry_data['trns_id'] = $id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] = '';
                $entry_data['crd_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_at'] = date('Y-m-d H:i:s');
                $entry_data['created_by'] = $this->user;

                $entry_data['crd_amount'] = $_POST['amount'];
                $entry_data['crd_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;

                $entry_data['deb_amount'] = 0;
                $entry_data['deb_acc_id'] = '';
                $entry_data['deb_acc_acode'] = '';
                $entry_data['ev_deb'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Cash Out",
                    'trns_id' => $id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'crd_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'deb_account' => $_POST['trn_id'],
                    'ev_amount' => $entry_data['ev_crd'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );

                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Cash Out", 'trns_id' => $id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['crd_amount'] = 0;
                        $entry_data['crd_acc_id'] = '';
                        $entry_data['crd_acc_acode'] = '';
                        $entry_data['ev_crd'] = 0;
                        $entry_data['deb_account'] = $_POST['trn_id'];
                        $entry_data['crd_account'] = '';
                        $entry_data['deb_amount'] = $_POST['amount'];
                        $entry_data['deb_acc_id'] = $_POST['trn_id'];
                        $entry_data['deb_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->exp_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->exp_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Cash Out Edited Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Edit Cash Out ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Edit Cash Out ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addCashoutTrn()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 240);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;
            $data['parent_id'] = $setup->cash_acc_id;
            $data['parent_acode'] = $setup->cash_acc_acode;
            $data['parent_name'] = $this->AccountModel->getByID('account_chart', $data['parent_id']);
            if ($setup->exp_acc_id != 0) {
                $data['rev_id'] = $setup->exp_acc_id;
                $data['rev_acode'] = $setup->exp_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }
            $data['brand'] = $this->brand;

            $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/cash/addCashoutTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCashoutTrn()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 222);
        if ($permission->add == 1) {

            $setup = $this->AccountModel->getsetup();
            $cash_code = doubleval($setup->cashout_num);
            $newcash = $cash_code + 1;
            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('cashout_num' => str_pad($newcash, 10, "0", STR_PAD_LEFT)));

            $serial = str_pad($newcash, 10, '0', STR_PAD_LEFT);
            $data['cash_type'] = 2; //1 for cash in - 2 for cash out
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['cash_id'] = $_POST['cash_id'];

            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];
            $data['brand'] = $this->brand;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            $data['desc_file'] = $_POST['desc_file'];
            // $data['name_file'] = $_POST['fileuploadspan'];

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['cash_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);
            if ($_FILES['doc_file']['size'] != 0) {
                if (!is_dir('./assets/uploads/account/cashout/')) {
                    mkdir('./assets/uploads/account/cashout/', 0777, TRUE);
                }
                $config['file']['upload_path'] = './assets/uploads/account/cashout/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 5000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('doc_file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    echo "error";
                    return;
                } else {
                    $data_file = $this->file_upload->data();
                    $data['doc_file'] = $data_file['file_name'];
                    $data['name_file'] = $data_file['orig_name'];
                }
            } else {
                $data['doc_file'] = "";
                $data['name_file'] = "";
            }

            if ($this->db->insert('cashout', $data)) {
                $cashout_id = $this->db->insert_id();
                // $this->admin_model->addToLoggerUpdate('cashout', 222, 'id', $cashout_id, 0, 0, $this->user);

                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Cash Out";
                $entry_data['trns_id'] = $cashout_id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] = '';
                $entry_data['crd_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_by'] = $this->user;
                $entry_data['created_at'] = date('Y-m-d H:i:s');

                $entry_data['crd_amount'] = $_POST['amount'];
                $entry_data['crd_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;

                $entry_data['deb_amount'] = 0;
                $entry_data['deb_acc_id'] = '';
                $entry_data['deb_acc_acode'] = '';
                $entry_data['ev_deb'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Cash Out",
                    'trns_id' => $cashout_id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'ev_amount' => $entry_data['ev_crd'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'crd_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'deb_account' => $_POST['trn_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Cash Out", 'trns_id' => $cashout_id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['crd_amount'] = 0;
                        $entry_data['crd_acc_id'] = '';
                        $entry_data['crd_acc_acode'] = '';
                        $entry_data['ev_crd'] = 0;
                        $entry_data['crd_account'] = '';
                        $entry_data['deb_account'] = $_POST['trn_id'];

                        $entry_data['deb_amount'] = $_POST['amount'];
                        $entry_data['deb_acc_id'] = $_POST['trn_id'];
                        $entry_data['deb_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Cash Out Added Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Add Cash Out Entry ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Add Cash out ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCashoutTrn($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 222);
        if ($check) {
            $id =  base64_decode($id);
            $this->admin_model->addToLoggerDelete('cashout', 222, 'id', $id, 0, 0, $this->user);
            $fileToatt = $this->db->get_where('cashout', array('id' => $id))->row()->doc_file;
            if ($fileToatt && $fileToatt != '') {
                unlink('./assets/uploads/account/cashin/' . $fileToatt);
            }
            if ($this->db->delete('cashout', array('id' => $id))) {
                if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Cash out'))) {
                    if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Cash out'))) {
                        if ($this->db->affected_rows() > 0) {
                            $true = "Cash out Deleted Successfully ...";
                            $this->session->set_flashdata('true', $true);
                        } else {
                            $error = "Failed To Delete Cash out ...";
                            $this->session->set_flashdata('error', $error);
                        }
                    }
                }
            } else {
                $error = "Failed To Delete Cash out ...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url() . "account/cashouttrnlist");
        } else {
            echo "You have no permission to access this page";
        }
    }

    //************ Bank in */
    public function bankintrnlist()
    {
        $check = $this->admin_model->checkPermission($this->role, 224);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 224);

            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;

            $type = "1";
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/bankintrnlist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function get_bankInList()
    {
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 224);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 241);

        $data['user'] = $this->user;
        $data['brand'] = $this->brand;
        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $type = "1";
        $filter_data = $this->input->post('filter_data');
        parse_str($filter_data, $params);
        $arr2 = array();
        if ($filter_data) {

            if (isset($params['searchBank'])) {
                $searchBank = $params['searchBank'];
                if (!empty($searchBank)) {
                    array_push($arr2, 0);
                }
            } else {
                $searchBank = "";
            }

            if (isset($params['searchCdate']) && $params['searchCdate'] != '') {
                $searchCdate = explode(' - ', $params['searchCdate']);

                $date1 = explode('/', $searchCdate[0]);
                $date2 = explode('/', $searchCdate[1]);

                $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_from = date("Y-m-d", strtotime($finalDate1));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($finalDate2)));
                if (!empty($finalDate1) && !empty($finalDate2)) {
                    array_push($arr2, 1);
                }
            } else {
                $searchCdate = "";
                $date_from = "";
                $date_to = "";
            }

            if (isset($params['searchSer'])) {
                $searchSer = $params['searchSer'];
                if (!empty($searchSer)) {
                    array_push($arr2, 2);
                }
            } else {
                $searchSer = "";
            }
            if (isset($params['searchRevenue'])) {
                $searchRevenue = $params['searchRevenue'];
                if (!empty($searchRevenue)) {
                    array_push($arr2, 3);
                }
            } else {
                $searchRevenue = "";
            }

            if (isset($params['searchCcode'])) {
                $searchCcode = $params['searchCcode'];
                if (!empty($searchCcode)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchCcode = "";
            }
            if (isset($params['searchChequeNo'])) {
                $searchChequeNo = $params['searchChequeNo'];
                if (!empty($searchChequeNo)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchChequeNo = "";
            }
            if (isset($params['searchChequeDate'])) {
                $searchChequeDate = $params['searchChequeDate'];
                if (!empty($searchChequeDate)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchChequeDate = "";
            }
        } else {
            $searchBank = "";
            $searchSer = "";
            $searchRevenue = "";
            $searchCcode = "";
            $date_from = "";
            $date_to = "";
            $searchChequeNo = "";
            $searchChequeDate = "";
        }

        $cond1 = "bank_id = '$searchBank'";
        $cond2 = "date BETWEEN '$date_from' AND '$date_to' ";
        $cond3 = "ccode like '%$searchSer%'";
        $cond4 = "trn_id = '$searchRevenue'";
        $cond5 = "doc_no like '%$searchCcode%'";

        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();

        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // ************//
        // var_dump($arr2);
        if ($arr_1_cnt > 0) {
            $data['bank_trn'] = $this->AccountModel->Allbanktrn($this->brand, $type, $arr4)->result_array();;
        } else {
            $data['bank_trn'] = $this->AccountModel->Allbanktrn($this->brand, $type, '1')->result_array();;
        }
        echo base64_encode(json_encode($data));
    }

    public function editbankinTrn($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 224);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 241);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $id = base64_decode($id);
            $data['bankin'] = $this->db->get_where('bankin', array('id' => $id, 'brand' => $this->brand))->row();
            $data['acc_setup'] = $setup;

            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }
            $bank_select = $this->db->get_where('payment_method', array('id' => $data['bankin']->bank_id))->row()->account_id;
            $account_select = $this->db->get_where('account_chart', array('id' => $bank_select))->row();
            $data['cash_acc_id'] = $account_select->id;
            $data['cash_acc'] = $account_select->acode;
            $data['cash_acc_name'] = $account_select->name;

            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/editbankinTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditBankinTrn_audit()
    {
        $id = base64_decode($_POST['aud_id']);
        $data['audit_chk'] = $this->input->post('audit_chk');
        if ($data['audit_chk']) {
            $data['audit_comment'] = $_POST['audit_comment'];
            $data['audit_date'] =  date('Y-m-d H:i:s');
            $data['audit_by'] = $this->user;
        } else {
            $data['audit_comment'] = '';
            $data['audit_date']  = null;
            $data['audit_by'] = '';
        }
        if ($this->db->update('bankin', $data, array('id' => $id))) {
            $this->admin_model->addToLoggerUpdate('bankin', 241, 'id', $id, 0, 0, $this->user);
            $true = "Audit Successfully ...";
            $this->session->set_flashdata('true', $true);

            echo json_encode(['records' => 0]);
        } else {
            $error = "Failed To Audit Bank In Entry ...";
            $this->session->set_flashdata('error', $error);
            echo json_encode(['records' => 1]);
        }
    }
    public function doEditbankinTrn()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 224);
        if ($permission->edit == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('bankin')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }

            $id = base64_decode($_POST['id']);
            $serial = str_pad($_POST['serial'], 10, '0', STR_PAD_LEFT);
            $data['ccode'] = $_POST['serial'];
            $data['doc_no'] = $_POST['doc_no'];
            $data['bank_id'] = $_POST['bank_id'];
            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['cheque_date'] = date("Y-m-d", strtotime($_POST['cdate1']));
            $data['cheque_no'] = $_POST['check_no'];
            $data['rem'] = $_POST['rem'];

            $data['desc_file'] = $_POST['desc_file'];
            $data['name_file'] = $_POST['fileuploadspan'];

            $fileToatt = $_POST['fileToDelete'];
            $new_file = $_FILES['doc_file']['name'];

            if ($new_file == true) {
                $new_file = str_replace(' ', "-", $_FILES['doc_file']['name']);
                if ($_FILES['doc_file']['size'] != 0) {
                    if (!is_dir('./assets/uploads/account/bankin/')) {
                        mkdir('./assets/uploads/account/bankin/', 0777, TRUE);
                    }
                    $config['file']['upload_path'] = './assets/uploads/account/bankin/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 5000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('doc_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 2]);
                        return;
                    } else {
                        if ($fileToatt && $fileToatt != '') {
                            if (file_exists('./assets/uploads/account/bankin/' . $fileToatt)) {
                                unlink('./assets/uploads/account/bankin/' . $fileToatt);
                            }
                        }
                        $data_file = $this->file_upload->data();
                        $data['doc_file'] = $data_file['file_name'];
                    }
                } else {
                    $data['doc_file'] = "";
                    $data['name_file'] = "";
                }
            }

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['bank_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);

            $this->admin_model->addToLoggerUpdate('bankin', 224, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('bankin', $data, array('id' => $id))) {

                $this->db->delete('entry_data_total', array('trns_type' => "Bank In", 'trns_id' => $id));
                $this->db->delete('entry_data', array('trns_type' => "Bank In", 'trns_id' => $id));
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Bank In";
                $entry_data['trns_id'] = $id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] =  (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']);
                $entry_data['crd_account'] = '';
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_at'] = date('Y-m-d H:i:s');
                $entry_data['created_by'] = $this->user;

                $entry_data['deb_amount'] = $_POST['amount'];
                $entry_data['deb_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']);
                $entry_data['deb_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->bank_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->bank_acc_acode;

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['ev_crd'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Bank In",
                    'trns_id' => $id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'deb_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']),
                    'crd_account' => $_POST['trn_id'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Bank In", 'trns_id' => $id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['deb_amount'] = 0;
                        $entry_data['deb_acc_id'] = '';
                        $entry_data['deb_acc_acode'] = '';
                        $entry_data['ev_deb'] = 0;
                        $entry_data['deb_account'] = '';
                        $entry_data['crd_account'] = $_POST['trn_id'];

                        $entry_data['crd_amount'] = $_POST['amount'];
                        $entry_data['crd_acc_id'] = $_POST['trn_id'];
                        $entry_data['crd_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Bank In Edited Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Edit bank In ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Edit Cash In Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addbankinTrn()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 224);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;
            $data['parent_id'] = $setup->bank_acc_id;
            $data['parent_acode'] = $setup->bank_acc_acode;
            $data['parent_name'] = $this->AccountModel->getByID('account_chart', $data['parent_id']);
            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }

            $data['brand'] = $this->brand;

            $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/addbankinTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddbankinTrn()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 224);
        if ($permission->add == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('bankin')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $setup = $this->AccountModel->getsetup();

            $cash_code = doubleval($setup->bankin_num);
            $newcash = $cash_code + 1;
            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('bankin_num' => str_pad($newcash, 10, "0", STR_PAD_LEFT)));

            $serial = str_pad($newcash, 10, '0', STR_PAD_LEFT);
            $data['bank_type'] = 1; //1 for bank in - 2 for bank out
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['bank_id'] = $_POST['bank_id'];

            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;
            $data['cheque_no'] = $_POST['check_no'];
            $data['cheque_date'] = date("Y-m-d", strtotime($_POST['cdate1']));

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];
            $data['brand'] = $this->brand;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            $data['desc_file'] = $_POST['desc_file'];

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['bank_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);
            if ($_FILES['doc_file']['size'] != 0) {
                if (!is_dir('./assets/uploads/account/bankin/')) {
                    mkdir('./assets/uploads/account/bankin/', 0777, TRUE);
                }
                $config['file']['upload_path'] = './assets/uploads/account/bankin/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 5000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('doc_file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 2]);
                    return;
                } else {
                    $data_file = $this->file_upload->data();
                    $data['doc_file'] = $data_file['file_name'];
                    $data['name_file'] = $data_file['orig_name'];
                }
            } else {
                $data['doc_file'] = "";
                $data['name_file'] = "";
            }

            if ($this->db->insert('bankin', $data)) {
                $bankin_id =  $this->db->insert_id();

                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Bank In";
                $entry_data['trns_id'] = $bankin_id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_account'] = '';
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_by'] = $this->user;
                $entry_data['created_at'] = date('Y-m-d H:i:s');

                $entry_data['deb_amount'] = $_POST['amount'];
                $entry_data['deb_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['deb_acc_acode'] =  $dep_acc_row->acode;
                $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->bank_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->bank_acc_acode;

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['ev_crd'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Bank In",
                    'trns_id' => $bankin_id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'deb_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'crd_account' => $_POST['trn_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Bank In", 'trns_id' => $bankin_id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['deb_amount'] = 0;
                        $entry_data['deb_acc_id'] = '';
                        $entry_data['deb_acc_acode'] = '';
                        $entry_data['ev_deb'] = 0;
                        $entry_data['deb_account'] = '';

                        $entry_data['crd_account'] = $_POST['trn_id'];
                        $entry_data['crd_amount'] = $_POST['amount'];
                        $entry_data['crd_acc_id'] = $_POST['trn_id'];
                        $entry_data['crd_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Bank In Add Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Add Bank In Entry ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Add bANK In Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function bank_trn_currency()
    {
        $bank_id = $this->input->post('bank_id', TRUE);
        $date = $this->input->post('date', TRUE);

        if ($bank_id != '') {
            $bank_pay = $this->db->get_where('payment_method', array('id' => $bank_id))->row();
            $data['currency_id'] = $bank_pay->currency_id;
            $data['options'] = $this->admin_model->selectCurrency($data['currency_id']);
            $data['rate'] = $this->AccountModel->getrate($data['currency_id'], $date);
            $account = $this->db->query("SELECT * FROM account_chart where id = '" . $bank_pay->account_id . "'")->row();

            $data['bank_acc_acode'] = $account->acode;
            $data['bank_acc_id'] = $account->id;

            $data['bank_acc_ccode'] = $account->ccode;
            $data['bank_acc_name'] = $account->name;
            echo json_encode($data);
        }
    }

    public function bank_trn_currency_rate()
    {
        $currency_hid = $this->input->post('currency_hid');
        $date = $this->input->post('date');
        $setup = $this->AccountModel->getsetup();

        if (isset($setup->local_currency_id)) {
            $data['local_currency'] = $setup->local_currency_id;
        } else {
            $data['local_currency'] = '';
        }

        if ($data['local_currency'] == $currency_hid) {
            $data['rate'] = 1;
            echo json_encode($data);
        } else {
            if ($currency_hid != '' && $date) {
                if ($this->AccountModel->getrate($currency_hid, $date)) {
                    $data['rate'] = $this->AccountModel->getrate($currency_hid, $date);
                    echo json_encode($data);
                } else {
                    echo json_encode('');
                }
            } else {
                echo json_encode('');
            }
        }
    }
    public function deletebankinTrn($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 224);
        if ($check) {
            $this->admin_model->addToLoggerDelete('bankin', 224, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('bankin', array('id' => $id))) {
                $fileToatt = $this->db->get_where('bankin', array('id' => $id))->row()->doc_file;
                if ($fileToatt && $fileToatt != '') {
                    unlink('./assets/uploads/account/bankin/' . $fileToatt);
                }
                if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Bank In'))) {
                    if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Bank In'))) {
                        $true = "Bank In Deleted Successfully ...";
                        $this->session->set_flashdata('true', $true);
                    }
                }
            } else {
                $error = "Failed To Delete Bank In...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url() . "account/bankintrnlist");
        } else {
            echo "You have no permission to access this page";
        }
    }

    //************ Bank out */
    public function bankouttrnlist()
    {
        $check = $this->admin_model->checkPermission($this->role, 225);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 225);

            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;

            $type = "2";
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/bankouttrnlist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function get_bankOutList()
    {
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 225);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 242);

        $data['user'] = $this->user;
        $data['brand'] = $this->brand;
        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $type = "2";
        $filter_data = $this->input->post('filter_data');
        parse_str($filter_data, $params);
        $arr2 = array();
        if ($filter_data) {

            if (isset($params['searchBank'])) {
                $searchBank = $params['searchBank'];
                if (!empty($searchBank)) {
                    array_push($arr2, 0);
                }
            } else {
                $searchBank = "";
            }

            if (isset($params['searchCdate']) && $params['searchCdate'] != '') {
                $searchCdate = explode(' - ', $params['searchCdate']);

                $date1 = explode('/', $searchCdate[0]);
                $date2 = explode('/', $searchCdate[1]);

                $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                $date_from = date("Y-m-d", strtotime($finalDate1));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($finalDate2)));
                if (!empty($finalDate1) && !empty($finalDate2)) {
                    array_push($arr2, 1);
                }
            } else {
                $searchCdate = "";
                $date_from = "";
                $date_to = "";
            }

            if (isset($params['searchSer'])) {
                $searchSer = $params['searchSer'];
                if (!empty($searchSer)) {
                    array_push($arr2, 2);
                }
            } else {
                $searchSer = "";
            }
            if (isset($params['searchRevenue'])) {
                $searchRevenue = $params['searchRevenue'];
                if (!empty($searchRevenue)) {
                    array_push($arr2, 3);
                }
            } else {
                $searchRevenue = "";
            }

            if (isset($params['searchCcode'])) {
                $searchCcode = $params['searchCcode'];
                if (!empty($searchCcode)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchCcode = "";
            }
            if (isset($params['searchChequeNo'])) {
                $searchChequeNo = $params['searchChequeNo'];
                if (!empty($searchChequeNo)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchChequeNo = "";
            }
            if (isset($params['searchChequeDate'])) {
                $searchChequeDate = $params['searchChequeDate'];
                if (!empty($searchChequeDate)) {
                    array_push($arr2, 4);
                }
            } else {
                $searchChequeDate = "";
            }
        } else {
            $searchBank = "";
            $searchSer = "";
            $searchRevenue = "";
            $searchCcode = "";
            $date_from = "";
            $date_to = "";
            $searchChequeNo = "";
            $searchChequeDate = "";
        }

        $cond1 = "bank_id = '$searchBank'";
        $cond2 = "date BETWEEN '$date_from' AND '$date_to' ";
        $cond3 = "ccode like '%$searchSer%'";
        $cond4 = "trn_id = '$searchRevenue'";
        $cond5 = "doc_no like '%$searchCcode%'";

        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();

        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // ************//
        // var_dump($arr2);
        if ($arr_1_cnt > 0) {
            $data['bank_trn'] = $this->AccountModel->Allbanktrn($this->brand, $type, $arr4)->result_array();;
        } else {
            $data['bank_trn'] = $this->AccountModel->Allbanktrn($this->brand, $type, '1')->result_array();;
        }
        echo base64_encode(json_encode($data));
    }

    public function editbankoutTrn($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 225);
        $data['audit_permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 242);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 225);

            $id = base64_decode($id);
            $data['bankout'] = $this->db->get_where('bankout', array('id' => $id, 'brand' => $this->brand))->row();
            $data['acc_setup'] = $setup = $this->AccountModel->getsetup();

            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->exp_acc_id;
                $data['rev_acode'] = $setup->exp_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }
            $cash_select = $this->db->get_where('payment_method', array('id' => $data['bankout']->bank_id))->row()->account_id;
            $account_select = $this->db->get_where('account_chart', array('id' => $cash_select))->row();
            $data['cash_acc_id'] = $account_select->id;
            $data['cash_acc'] = $account_select->acode;
            $data['cash_acc_name'] = $account_select->name;

            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/editbankoutTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditBankoutTrn_audit()
    {
        $id = base64_decode($_POST['aud_id']);
        $data['audit_chk'] = $this->input->post('audit_chk');
        if ($data['audit_chk']) {
            $data['audit_comment'] = $_POST['audit_comment'];
            $data['audit_date'] =  date('Y-m-d H:i:s');
            $data['audit_by'] = $this->user;
        } else {
            $data['audit_comment'] = '';
            $data['audit_date']  = null;
            $data['audit_by'] = '';
        }
        if ($this->db->update('bankout', $data, array('id' => $id))) {
            $this->admin_model->addToLoggerUpdate('bankin', 242, 'id', $id, 0, 0, $this->user);
            $true = "Audit Successfully ...";
            $this->session->set_flashdata('true', $true);

            echo json_encode(['records' => 0]);
        } else {
            $error = "Failed To Audit Bank Out Entry ...";
            $this->session->set_flashdata('error', $error);
            echo json_encode(['records' => 1]);
        }
    }
    public function doEditbankoutTrn()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 225);
        if ($permission->edit == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('bankout')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($_POST['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }

            $id = base64_decode($_POST['id']);
            $serial = str_pad($_POST['serial'], 10, '0', STR_PAD_LEFT);
            $data['ccode'] = $_POST['serial'];
            $data['doc_no'] = $_POST['doc_no'];
            $data['bank_id'] = $_POST['bank_id'];
            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['cheque_date'] = date("Y-m-d", strtotime($_POST['cdate1']));
            $data['cheque_no'] = $_POST['check_no'];
            $data['rem'] = $_POST['rem'];

            $data['desc_file'] = $_POST['desc_file'];
            $data['name_file'] = $_POST['fileuploadspan'];

            $fileToatt = $_POST['fileToDelete'];
            $new_file = $_FILES['doc_file']['name'];

            if ($new_file == true) {
                $new_file = str_replace(' ', "-", $_FILES['doc_file']['name']);
                if ($_FILES['doc_file']['size'] != 0) {
                    if (!is_dir('./assets/uploads/account/bankout/')) {
                        mkdir('./assets/uploads/account/bankout/', 0777, TRUE);
                    }
                    $config['file']['upload_path'] = './assets/uploads/account/bankout/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 5000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('doc_file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 2]);
                        return;
                    } else {
                        if ($fileToatt && $fileToatt != '') {
                            if (file_exists('./assets/uploads/account/bankout/' . $fileToatt)) {
                                unlink('./assets/uploads/account/bankout/' . $fileToatt);
                            }
                        }
                        $data_file = $this->file_upload->data();
                        $data['doc_file'] = $data_file['file_name'];
                    }
                } else {
                    $data['doc_file'] = "";
                    $data['name_file'] = "";
                }
            }

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['bank_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);

            $this->admin_model->addToLoggerUpdate('bankout', 225, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('bankout', $data, array('id' => $id))) {

                $this->db->delete('entry_data_total', array('trns_type' => "Bank Out", 'trns_id' => $id));
                $this->db->delete('entry_data', array('trns_type' => "Bank Out", 'trns_id' => $id));
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Bank Out";
                $entry_data['trns_id'] = $id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] =  '';
                $entry_data['crd_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']);
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_at'] = date('Y-m-d H:i:s');
                $entry_data['created_by'] = $this->user;

                $entry_data['crd_amount'] = $_POST['amount'];
                $entry_data['crd_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']);
                $entry_data['crd_acc_acode'] = $dep_acc_row->acode;
                $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->bank_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->bank_acc_acode;

                $entry_data['deb_amount'] = 0;
                $entry_data['deb_acc_id'] = '';
                $entry_data['deb_acc_acode'] = '';
                $entry_data['ev_deb'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Bank Out",
                    'trns_id' => $id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'crd_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['bank_acc_id']),
                    'deb_account' => $_POST['trn_id'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Bank Out", 'trns_id' => $id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['crd_amount'] = 0;
                        $entry_data['crd_acc_id'] = '';
                        $entry_data['crd_acc_acode'] = '';
                        $entry_data['ev_crd'] = 0;
                        $entry_data['crd_account'] = '';
                        $entry_data['deb_account'] = $_POST['trn_id'];

                        $entry_data['deb_amount'] = $_POST['amount'];
                        $entry_data['deb_acc_id'] = $_POST['trn_id'];
                        $entry_data['deb_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_deb'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->rev_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->rev_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Bank Out Edited Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Edit bank Out ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Edit Cash Out Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addbankoutTrn()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 225);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;
            $data['parent_id'] = $setup->bank_acc_id;
            $data['parent_acode'] = $setup->bank_acc_acode;
            $data['parent_name'] = $this->AccountModel->getByID('account_chart', $data['parent_id']);
            if ($setup->exp_acc_id != 0) {
                $data['rev_id'] = $setup->exp_acc_id;
                $data['rev_acode'] = $setup->exp_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }

            $data['brand'] = $this->brand;

            $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/bank/addbankoutTrn');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddbankoutTrn()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 225);
        if ($permission->add == 1) {
            if (isset($_POST['doc_no'])) {
                $records = $this->db->select('*')->from('bankout')->where('doc_no=', $_POST['doc_no'])->where('brand=', $this->brand)->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $setup = $this->AccountModel->getsetup();

            $cash_code = doubleval($setup->bankout_num);
            $newcash = $cash_code + 1;
            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('bankout_num' => str_pad($newcash, 10, "0", STR_PAD_LEFT)));

            $serial = str_pad($newcash, 10, '0', STR_PAD_LEFT);
            $data['bank_type'] = 2; //1 for bank in - 2 for bank out
            $data['ccode'] = $serial;
            $data['doc_no'] = $_POST['doc_no'];
            $data['bank_id'] = $_POST['bank_id'];

            $data['date'] = date("Y-m-d", strtotime($_POST['cdate']));
            $data['trn_type'] = $_POST['trn_typ'];
            $data['trn_id'] = $_POST['trn_id'];
            $data['trn_code'] = $this->AccountModel->get_accountRowID($_POST['trn_id'])->acode;
            $data['cheque_no'] = $_POST['check_no'];
            $data['cheque_date'] = date("Y-m-d", strtotime($_POST['cdate1']));

            $data['amount'] = $_POST['amount'];
            $data['currency_id'] = $_POST['currency_hid'];
            $data['rate'] = $_POST['rate_h'];
            $data['rem'] = $_POST['rem'];
            $data['brand'] = $this->brand;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            $data['desc_file'] = $_POST['desc_file'];

            $dep_pay_acco = $this->AccountModel->getpayment_method_account_id($_POST['bank_id']);
            $dep_acc_row = $this->AccountModel->get_accountRowID($dep_pay_acco);
            if ($_FILES['doc_file']['size'] != 0) {
                if (!is_dir('./assets/uploads/account/bankout/')) {
                    mkdir('./assets/uploads/account/bankout/', 0777, TRUE);
                }
                $config['file']['upload_path'] = './assets/uploads/account/bankout/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 5000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('doc_file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    echo "error";
                    return;
                } else {
                    $data_file = $this->file_upload->data();
                    $data['doc_file'] = $data_file['file_name'];
                    $data['name_file'] = $data_file['orig_name'];
                }
            } else {
                $data['doc_file'] = "";
                $data['name_file'] = "";
            }

            if ($this->db->insert('bankout', $data)) {
                $bankin_id =  $this->db->insert_id();

                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Bank Out";
                $entry_data['trns_id'] = $bankin_id;
                $entry_data['trns_ser'] = $serial;
                $entry_data['trns_code'] = $_POST['doc_no'];
                $entry_data['trns_date'] = date("Y-m-d", strtotime($_POST['cdate']));
                $entry_data['currency_id'] = $_POST['currency_hid'];
                $entry_data['rate'] = $_POST['rate_h'];
                $entry_data['typ_account'] = $_POST['trn_typ'];
                $entry_data['deb_account'] = '';
                $entry_data['crd_account'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['data1'] = $_POST['rem'];
                $entry_data['data2'] = $_POST['rem'];
                $entry_data['created_by'] = $this->user;
                $entry_data['created_at'] = date('Y-m-d H:i:s');

                $entry_data['crd_amount'] = $_POST['amount'];
                $entry_data['crd_acc_id'] = (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']);
                $entry_data['crd_acc_acode'] =  $dep_acc_row->acode;
                $entry_data['ev_crd'] = $entry_data['crd_amount'] * $_POST['rate_h'];
                $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->bank_acc_id;
                $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->bank_acc_acode;

                $entry_data['deb_amount'] = 0;
                $entry_data['deb_acc_id'] = '';
                $entry_data['deb_acc_acode'] = '';
                $entry_data['ev_deb'] = 0;
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Bank Out",
                    'trns_id' => $bankin_id,
                    'trns_ser' => $serial,
                    'trns_code' => $_POST['doc_no'],
                    'amount' => $_POST['amount'],
                    'trns_date' => date("Y-m-d", strtotime($_POST['cdate'])),
                    'currency_id' => $_POST['currency_hid'],
                    'rate' => $_POST['rate_h'],
                    'ev_amount' => $entry_data['ev_deb'],
                    'data1' => $_POST['rem'],
                    'data2' => $_POST['rem'],
                    'deb_account' => $_POST['trn_id'],
                    'crd_account' => (($dep_pay_acco) ? $dep_pay_acco  : $_POST['cash_acc_id']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->get('entry_data_total', array('trns_type' => "Bank Out", 'trns_id' => $bankin_id))->row()->id;
                    if ($this->db->insert('entry_data', $entry_data)) {
                        $entry_data['crd_amount'] = 0;
                        $entry_data['crd_acc_id'] = '';
                        $entry_data['crd_acc_acode'] = '';
                        $entry_data['ev_crd'] = 0;
                        $entry_data['crd_account'] = '';

                        $entry_data['deb_account'] = $_POST['trn_id'];
                        $entry_data['deb_amount'] = $_POST['amount'];
                        $entry_data['deb_acc_id'] = $_POST['trn_id'];
                        $entry_data['deb_acc_acode'] = $this->AccountModel->getAcodeByID($_POST['trn_id']);
                        $entry_data['ev_deb'] = $entry_data['deb_amount'] * $_POST['rate_h'];
                        $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->exp_acc_id;
                        $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->exp_acc_acode;

                        if ($this->db->insert('entry_data', $entry_data)) {
                            $true = "Bank Out Add Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            echo json_encode(['records' => 0]);
                        }
                    } else {
                        $error = "Failed To Add Bank Out Entry ...";
                        $this->session->set_flashdata('error', $error);
                        echo json_encode(['records' => 1]);
                    }
                }
            } else {
                $error = "Failed To Add Bank Out Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deletebankoutTrn($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 225);
        if ($check) {
            $this->admin_model->addToLoggerDelete('bankout', 225, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('bankout', array('id' => $id))) {
                $fileToatt = $this->db->get_where('bankout', array('id' => $id))->row()->doc_file;
                if ($fileToatt && $fileToatt != '') {
                    unlink('./assets/uploads/account/bankut/' . $fileToatt);
                }
                if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Bank Out'))) {
                    if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Bank Out'))) {
                        $true = "Bank In Deleted Successfully ...";
                        $this->session->set_flashdata('true', $true);
                    }
                }
            } else {
                $error = "Failed To Delete bank Out...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url() . "account/bankouttrnlist");
        } else {
            echo "You have no permission to access this page";
        }
    }

    /***********************ManualEntryList*********************/
    public function ManualEntryList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 226);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $sort_by = $this->input->post('sort_by');
            if ($sort_by === null) {
                $sort_by = $this->session->userdata('sort_by');
            } else {
                $this->session->set_userdata('sort_by', $sort_by);
            }

            $arr2 = array();

            $ser = $this->input->post('ser');
            if ($ser === null) {
                $ser = $this->session->userdata('ser');
            } else {
                $this->session->set_userdata('ser', $ser);
            }
            if (!empty($ser)) {
                array_push($arr2, 0);
            }
            $from_date = $this->input->post('from_date');
            if ($from_date === null) {
                $from_date = $this->session->userdata('from_date');
            } else {
                $this->session->set_userdata('from_date', $from_date);
            }
            if (!empty($from_date)) {
                array_push($arr2, 1);
            }

            $to_date = $this->input->post('to_date');
            if ($to_date === null) {
                $to_date = $this->session->userdata('to_date');
            } else {
                $this->session->set_userdata('to_date', $to_date);
            }
            if (!empty($to_date)) {
                array_push($arr2, 2);
            }
            $cond1 = "ccode like '%$ser%'";
            $cond2 = "date >= '$from_date'";
            $cond3 = "date <= '$to_date'";

            $arr1 = array($cond1, $cond2, $cond3);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            //************//
            // print_r($arr4);
            // die;
            // if (isset($_POST['search'])) {
            if ($arr_1_cnt > 0) {
                $data['manual_entries'] = $this->AccountModel->AllManualEntries($this->brand, $sort_by, $arr4, $limit, $offset);
                $count = $this->AccountModel->AllManualEntries($this->brand, '', $arr4, 0, 0)->num_rows();
            } else {
                $data['manual_entries'] = $this->AccountModel->AllManualEntriesPages($this->brand, $sort_by, $limit, $offset);
                $count = $this->AccountModel->AllManualEntries($this->brand, '', 1, 0, 0)->num_rows();
            }

            $config['base_url'] = base_url('account/ManualEntryList');
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
            $config['num_links'] = 10;
            $config['show_count'] = TRUE;
            $this->pagination->initialize($config);

            $data['brand'] = $this->brand;
            $vs_date = $this->AccountModel->getsetup();
            $data['parent_id'] = $vs_date->cash_acc_id;

            $data['vs_date1'] = $vs_date->sdate1;
            $data['vs_date2'] = $vs_date->sdate2;
            $data['current_page'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['ser'] = $ser;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/manual/manualentrylist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addManualEntry()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;

            // $data['acc_setup'] = $this->db->get_where('acc_setup', array('brand' => $this->brand))->row();
            $data['parent_id'] = $data['acc_setup']->cash_acc_id;
            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }


            //$data['rev_id'] = $data['acc_setup']->rev_acc_id;
            //$data['rev_name'] = $this->db->get_where('account_chart', array('brand' => $this->brand, 'id' => $data['rev_id']))->row()->name;
            $data['brand'] = $this->brand;
            // $data['brand'] = $this->admin_model->getbrand($this->brand);
            $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/manual/addManualEntry');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddManualEntry()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($permission->add == 1) {
            $form = array(
                'doc_no' => $_POST['form'][2]['value'],
                'cdate' => $_POST['form'][3]['value'],
                'currency_hid' => $_POST['form'][4]['value'],
                'rate_h' => $_POST['form'][6]['value'],
                'rem' => $_POST['form'][7]['value'],
            );
            $table = $_POST['table'];
            $rows = $_POST['rows'];
            if (isset($form['doc_no'])) {
                $records = $this->db->select('*')->from('manual_master')->where('doc_no=', $form['doc_no'])->where('brand=', $this->brand)->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }

            $acc_setup = $this->AccountModel->getsetup();
            $serial = doubleval($acc_setup->manual_num);
            $newSerial = $serial + 1;
            $serial = $newSerial;
            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('manual_num' => str_pad($newSerial, 10, "0", STR_PAD_LEFT)));

            $data['ccode'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
            $data['doc_no'] = $form['doc_no'];
            $data['date'] = date("Y-m-d", strtotime($form['cdate']));
            $data['currency_id'] = $form['currency_hid'];
            $data['rate'] = $form['rate_h'];
            $data['rem'] = $form['rem'];
            $data['brand'] = $this->brand;
            $data['tot_deb'] = $table['debit_tot'];
            $data['tot_ev_deb'] = $table['tot_evdebit'];
            $data['tot_crd'] = $table['credit_tot'];
            $data['tot_ev_crd'] = $table['tot_evcredit'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            if ($this->db->insert('manual_master', $data)) {
                $trn_id = $this->db->insert_id("manual_master");
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Manual Entry",
                    'trns_id' => $trn_id,
                    'trns_ser' => str_pad($serial, 10, '0', STR_PAD_LEFT),
                    'trns_code' => $form['doc_no'],
                    'amount' => $table['debit_tot'],
                    'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    'currency_id' => $form['currency_hid'],
                    'rate' => $form['rate_h'],
                    'ev_amount' => $table['tot_evdebit'],
                    'data1' => trim($form['rem']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->insert_id("entry_data_total");


                    $details['tot_id'] = $trn_id;
                    $details['brand'] = $this->brand;
                    $details['tot_code'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
                    $details['date'] = date("Y-m-d", strtotime($form['cdate']));
                    $details['currency_id'] = $form['currency_hid'];
                    $details['rate'] = $form['rate_h'];
                    $details['created_at'] = date('Y-m-d H:i:s');
                    $details['created_by'] = $this->user;

                    for ($i = 0; $i < $rows; $i++) {
                        $details['deb_amount'] = $table['table'][$i]['debit'];
                        $details['ev_deb_amount'] = $table['table'][$i]['evdebit'];
                        $details['crd_amount'] = $table['table'][$i]['credit'];
                        $details['ev_crd_amount'] = $table['table'][$i]['evcredit'];
                        $details['account_id'] = $table['table'][$i]['account_id'];
                        $details['acc_acode'] = $this->AccountModel->getAcodeByID($details['account_id']);
                        $details['third_party_id'] = $table['table'][$i]['account_3party'];
                        $details['data1'] = trim($table['table'][$i]['desc_text']);

                        if ($this->db->insert('manual_details', $details)) {
                            $entry_data['brand'] = $this->brand;
                            $entry_data['trns_type'] = "Manual Entry";
                            $entry_data['trns_id'] = $trn_id;
                            $entry_data['trns_ser'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
                            $entry_data['trns_code'] = $form['doc_no'];
                            $entry_data['data2'] = trim($details['data1']);
                            if ($details['deb_amount'] != 0) {
                                $entry_data['deb_amount'] = $details['deb_amount'];
                                $entry_data['deb_acc_id'] = $details['account_id'];
                                $entry_data['deb_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_deb'] = $details['ev_deb_amount'];
                                $entry_data['crd_amount'] = 0;
                                $entry_data['crd_acc_id'] = '';
                                $entry_data['crd_acc_acode'] = '';
                                $entry_data['ev_crd'] = 0;
                            } else {
                                $entry_data['crd_amount'] = $details['crd_amount'];
                                $entry_data['crd_acc_id'] = $details['account_id'];
                                $entry_data['crd_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_crd'] = $details['ev_crd_amount'];
                                $entry_data['deb_amount'] = 0;
                                $entry_data['deb_acc_id'] = '';
                                $entry_data['deb_acc_acode'] = '';
                                $entry_data['ev_deb'] = 0;
                            }
                            $entry_data['trns_date'] = date("Y-m-d", strtotime($form['cdate']));
                            $entry_data['currency_id'] = $form['currency_hid'];
                            $entry_data['rate'] = $form['rate_h'];
                            $entry_data['typ_account'] = "Other";
                            // $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                            // $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;
                            //deb_account and crd_account
                            $entry_data['created_at'] = date('Y-m-d H:i:s');
                            $entry_data['created_by'] = $this->user;
                            if (!($this->db->insert('entry_data', $entry_data))) {
                                $error = "Failed To Add Manual Entry ...";
                                $this->session->set_flashdata('error', $error);
                                echo json_encode(['records' => 1]);
                                return;
                            }
                        } else {
                            $error = "Failed To Add Manual Entry ...";
                            $this->session->set_flashdata('error', $error);
                            echo json_encode(['records' => 1]);
                            return;
                        }
                    }

                    $true = "Manual Entry Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    echo json_encode(['records' => 0]);
                } else {
                    $error = "Failed To Add Manual Entry ...";
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 1]);
                }
            } else {
                $error = "Failed To Add Manual Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
            echo json_encode(['records' => 1]);
        }
    }

    public function editManualEntry()
    {

        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $id = base64_decode($_GET['t']);
            $data['brand'] = $this->brand;
            // $data['brand'] = $this->admin_model->getbrand($this->brand);
            $data['master'] = $this->db->get_where('manual_master', array('id' => $id, 'brand' => $this->brand))->row();
            $data['details'] = $this->db->get_where('manual_details', array('tot_id' => $id, 'brand' => $this->brand))->result_array();
            $data['current_page'] = $_GET['c'];

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/manual/editManualEntry');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditManualEntry()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($permission->edit == 1) {
            $form = array(
                'serial' => $_POST['form'][1]['value'],
                'id' => $_POST['form'][2]['value'],
                'doc_no' => $_POST['form'][4]['value'],
                'cdate' => $_POST['form'][5]['value'],
                'currency_hid' => $_POST['form'][6]['value'],
                'rate_h' => $_POST['form'][8]['value'],
                'rem' => $_POST['form'][9]['value'],
            );
            $table = $_POST['table'];
            $rows = $_POST['rows'];
            if (isset($form['doc_no'])) {
                $records = $this->db->select('*')->from('manual_master')->where('doc_no=', $form['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($form['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }


            $id = base64_decode($form['id']);
            $master = $this->db->get_where('manual_master', ['id' => $id])->row();
            $data['ccode'] = $form['serial'];
            $data['doc_no'] = $form['doc_no'];
            $data['date'] = date("Y-m-d", strtotime($form['cdate']));
            $data['currency_id'] = $form['currency_hid'];
            $data['rate'] = $form['rate_h'];
            $data['rem'] = trim($form['rem']);
            $data['brand'] = $this->brand;
            $data['tot_deb'] = $table['debit_tot'];
            $data['tot_ev_deb'] = $table['tot_evdebit'];
            $data['tot_crd'] = $table['credit_tot'];
            $data['tot_ev_crd'] = $table['tot_evcredit'];

            $this->admin_model->addToLoggerUpdate('manual_master', 226, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('manual_master', $data, array('id' => $id))) {
                try {
                    $this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Manual Entry'));
                } catch (\Throwable $th) {
                }
                try {
                    $this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Manual Entry'));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $this->db->delete('manual_details', array('tot_id' => $id));
                } catch (\Throwable $th) {
                }
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Manual Entry",
                    'trns_id' => $id,
                    'trns_ser' => $form['serial'],
                    'trns_code' => $form['doc_no'],
                    'amount' => $table['debit_tot'],
                    'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    'currency_id' => $form['currency_hid'],
                    'rate' => $form['rate_h'],
                    'ev_amount' => $table['tot_evdebit'],
                    'data1' => trim($form['rem']),
                    'created_at' => $master->created_at,
                    'created_by' => $master->created_by
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->insert_id("entry_data_total");

                    $details['tot_id'] = $id;
                    $details['brand'] = $this->brand;
                    $details['tot_code'] = $form['serial'];
                    $details['date'] = date("Y-m-d", strtotime($form['cdate']));
                    $details['currency_id'] = $form['currency_hid'];
                    $details['rate'] = $form['rate_h'];
                    $details['created_at'] = $master->created_at;
                    $details['created_by'] = $master->created_by;

                    for ($i = 0; $i < $rows; $i++) {
                        $details['deb_amount'] = $table['table'][$i]['debit'];
                        $details['ev_deb_amount'] = $table['table'][$i]['evdebit'];
                        $details['crd_amount'] = $table['table'][$i]['credit'];
                        $details['ev_crd_amount'] = $table['table'][$i]['evcredit'];
                        $details['account_id'] = $table['table'][$i]['account_id'];
                        $details['acc_acode'] = $this->AccountModel->getAcodeByID($details['account_id']);
                        $details['third_party_id'] = $table['table'][$i]['account_3party'];
                        $details['data1'] = trim($table['table'][$i]['desc_text']);
                        if ($this->db->insert('manual_details', $details)) {
                            $entry_data['brand'] = $this->brand;
                            $entry_data['trns_type'] = "Manual Entry";
                            $entry_data['trns_id'] = $id;
                            $entry_data['trns_ser'] = $form['serial'];
                            $entry_data['trns_code'] = $form['doc_no'];
                            $entry_data['data2'] = $details['data1'];

                            if ($details['deb_amount'] != 0) {
                                $entry_data['deb_amount'] = $details['deb_amount'];
                                $entry_data['deb_acc_id'] = $details['account_id'];
                                $entry_data['deb_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_deb'] = $details['ev_deb_amount'];
                                $entry_data['crd_amount'] = 0;
                                $entry_data['crd_acc_id'] = '';
                                $entry_data['crd_acc_acode'] = '';
                                $entry_data['ev_crd'] = 0;
                            } else {
                                $entry_data['crd_amount'] = $details['crd_amount'];
                                $entry_data['crd_acc_id'] = $details['account_id'];
                                $entry_data['crd_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_crd'] = $details['ev_crd_amount'];
                                $entry_data['deb_amount'] = 0;
                                $entry_data['deb_acc_id'] = '';
                                $entry_data['deb_acc_acode'] = '';
                                $entry_data['ev_deb'] = 0;
                            }
                            $entry_data['trns_date'] = date("Y-m-d", strtotime($form['cdate']));
                            $entry_data['currency_id'] = $form['currency_hid'];
                            $entry_data['rate'] = $form['rate_h'];
                            $entry_data['typ_account'] = "Other";

                            $entry_data['created_at'] = $master->created_at;
                            $entry_data['created_by'] = $master->created_by;

                            if (!($this->db->insert('entry_data', $entry_data))) {
                                $error = "Failed To Add Manual Entry ...";
                                $this->session->set_flashdata('error', $error);
                                echo json_encode(['records' => 1]);
                                return;
                            }
                        } else {
                            $error = "Failed To Edit Manual Entry ...";
                            $this->session->set_flashdata('error', $error);
                            echo json_encode(['records' => 1]);
                            return;
                        }
                    }
                    // print_r('<pre>');
                    // var_dump($table['table']);
                    // die;

                    $true = "Manual Entry Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    echo json_encode(['records' => 0]);
                } else {
                    $error = "Failed To Edit Manual Entry ...";
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 1]);
                }
            } else {
                $error = "Failed To Edit Manual Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteManualEntry($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 226);
        if ($check) {
            $this->admin_model->addToLoggerDelete('manual_master', 230, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('manual_master', array('id' => $id))) {
                if ($this->db->delete('manual_details', array('tot_id' => $id))) {
                    if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Manual Entry'))) {
                        if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Manual Entry'))) {
                            $true = "Manual Entry Deleted Successfully ...";
                            $this->session->set_flashdata('true', $true);
                        } else {
                            $error = "Failed To Delete Manual Entry ...";
                            $this->session->set_flashdata('error', $error);
                        }
                    } else {
                        $error = "Failed To Delete Manual Entry ...";
                        $this->session->set_flashdata('error', $error);
                    }
                } else {
                    $error = "Failed To Delete Manual Entry ...";
                    $this->session->set_flashdata('error', $error);
                }
            } else {
                $error = "Failed To Delete Manual Entry ...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url("account/ManualEntryList"));
        } else {
            echo "You have no permission to access this page";
        }
    }

    /**************************BeginEntryList*********************/
    public function BeginEntryList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 226);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['ser'])) {
                    $ser = $_REQUEST['ser'];
                    if (!empty($ser)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $ser = "";
                }

                if (isset($_POST['date']) && $_POST['date'] != '') {
                    $cdaterange1 = explode(' - ', $_POST['date']);

                    $date1 = explode('/', $cdaterange1[0]);
                    $date2 = explode('/', $cdaterange1[1]);

                    $finalDate1 = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                    $finalDate2 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
                    $date_from = date("Y-m-d", strtotime($finalDate1));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($finalDate2)));
                    if (!empty($finalDate1) && !empty($finalDate2)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }


                $cond1 = "ccode like '$ser'";
                $cond2 = "date BETWEEN '$date_from' AND '$date_to' ";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //************//
                if ($arr_1_cnt > 0) {
                    $data['begin_entries'] = $this->AccountModel->AllEntries('begin_master', $this->brand, $arr4);
                } else {
                    $data['begin_entries'] = $this->AccountModel->AllEntriesPages('begin_master', $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->AccountModel->AllEntries('begin_master', $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('account/BeginEntryList');
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
                $data['begin_entries'] = $this->AccountModel->AllEntriesPages('begin_master', $this->brand, $limit, $offset);
            }
            $data['brand'] = $this->brand;
            $vs_date = $this->AccountModel->getsetup();
            $data['parent_id'] = $vs_date->cash_acc_id;

            $data['vs_date1'] = $vs_date->sdate1;
            $data['vs_date2'] = $vs_date->sdate2;
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/begin/beginentrylist');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addBeginEntry()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
            $setup = $this->AccountModel->getsetup();

            $data['acc_setup'] = $setup;

            // $data['acc_setup'] = $this->db->get_where('acc_setup', array('brand' => $this->brand))->row();
            $data['parent_id'] = $data['acc_setup']->cash_acc_id;
            if ($setup->rev_acc_id != 0) {
                $data['rev_id'] = $setup->rev_acc_id;
                $data['rev_acode'] = $setup->rev_acc_acode;
                $data['rev_name'] = $this->AccountModel->getByID('account_chart', $data['rev_id']);
            } else {
                $data['rev_name'] = "-";
            }


            //$data['rev_id'] = $data['acc_setup']->rev_acc_id;
            //$data['rev_name'] = $this->db->get_where('account_chart', array('brand' => $this->brand, 'id' => $data['rev_id']))->row()->name;
            $data['brand'] = $this->brand;
            // $data['brand'] = $this->admin_model->getbrand($this->brand);
            $data['date'] = date("Y-m-d", strtotime($setup->sdate1));
            // $data['date'] = date("Y-m-d");
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/begin/addBeginEntry');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddBeginEntry()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($permission->add == 1) {
            $form = array(
                'doc_no' => $_POST['form'][2]['value'],
                'cdate' => $_POST['form'][3]['value'],
                'currency_hid' => $_POST['form'][4]['value'],
                'rate_h' => $_POST['form'][6]['value'],
                'rem' => $_POST['form'][7]['value'],
            );
            $table = $_POST['table'];
            $rows = $_POST['rows'];
            if (isset($form['doc_no'])) {
                $records = $this->db->select('*')->from('begin_master')->where('doc_no=', $form['doc_no'])->where('brand', $this->brand)->order_by('id')->get()->num_rows();
                if ($records != 0) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }
            $acc_setup = $this->AccountModel->getsetup();
            $serial = doubleval($acc_setup->begin_num);
            $newSerial = $serial + 1;

            $this->db->where('brand', $this->brand);
            $this->db->update('acc_setup', array('begin_num' => str_pad($newSerial, 10, "0", STR_PAD_LEFT)));

            $data['ccode'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
            $data['doc_no'] = $form['doc_no'];
            $data['date'] = date("Y-m-d", strtotime($form['cdate']));
            $data['currency_id'] = $form['currency_hid'];
            $data['rate'] = $form['rate_h'];
            $data['rem'] = $form['rem'];
            $data['brand'] = $this->brand;
            $data['tot_deb'] = $table['debit_tot'];
            $data['tot_ev_deb'] = $table['tot_evdebit'];
            $data['tot_crd'] = $table['credit_tot'];
            $data['tot_ev_crd'] = $table['tot_evcredit'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->user;

            if ($this->db->insert('begin_master', $data)) {
                $trn_id = $this->db->insert_id("begin_master");
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Begin Entry",
                    'trns_id' => $trn_id,
                    'trns_ser' => str_pad($serial, 10, '0', STR_PAD_LEFT),
                    'trns_code' => $form['doc_no'],
                    'amount' => $table['debit_tot'],
                    'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    'currency_id' => $form['currency_hid'],
                    'rate' => $form['rate_h'],
                    'ev_amount' => $table['tot_evdebit'],
                    'data1' => $form['rem'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->insert_id("entry_data_total");

                    $details['tot_id'] = $trn_id;
                    $details['brand'] = $this->brand;
                    $details['tot_code'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
                    $details['date'] = date("Y-m-d", strtotime($form['cdate']));
                    $details['currency_id'] = $form['currency_hid'];
                    $details['rate'] = $form['rate_h'];
                    $details['created_at'] = date('Y-m-d H:i:s');
                    $details['created_by'] = $this->user;

                    for ($i = 0; $i < $rows; $i++) {
                        $details['deb_amount'] = $table['table'][$i]['debit'];
                        $details['ev_deb_amount'] = $table['table'][$i]['evdebit'];
                        $details['crd_amount'] = $table['table'][$i]['credit'];
                        $details['ev_crd_amount'] = $table['table'][$i]['evcredit'];
                        $details['account_id'] = $table['table'][$i]['account_id'];
                        $details['acc_acode'] = $this->AccountModel->getAcodeByID($details['account_id']);

                        if ($this->db->insert('begin_details', $details)) {
                            $entry_data['brand'] = $this->brand;
                            $entry_data['trns_type'] = "Begin Entry";
                            $entry_data['trns_id'] = $trn_id;
                            $entry_data['trns_ser'] = str_pad($serial, 10, '0', STR_PAD_LEFT);
                            $entry_data['trns_code'] = $form['doc_no'];
                            if ($details['deb_amount'] != 0) {
                                $entry_data['deb_amount'] = $details['deb_amount'];
                                $entry_data['deb_acc_id'] = $details['account_id'];
                                $entry_data['deb_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_deb'] = $details['ev_deb_amount'];
                                $entry_data['crd_amount'] = 0;
                                $entry_data['crd_acc_id'] = '';
                                $entry_data['crd_acc_acode'] = '';
                                $entry_data['ev_crd'] = 0;
                            } else {
                                $entry_data['crd_amount'] = $details['crd_amount'];
                                $entry_data['crd_acc_id'] = $details['account_id'];
                                $entry_data['crd_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_crd'] = $details['ev_crd_amount'];
                                $entry_data['deb_amount'] = 0;
                                $entry_data['deb_acc_id'] = '';
                                $entry_data['deb_acc_acode'] = '';
                                $entry_data['ev_deb'] = 0;
                            }
                            $entry_data['trns_date'] = date("Y-m-d", strtotime($form['cdate']));
                            $entry_data['currency_id'] = $form['currency_hid'];
                            $entry_data['rate'] = $form['rate_h'];
                            $entry_data['typ_account'] = "Other";
                            // $entry_data['main_acc_id'] = $this->AccountModel->getSetup()->cash_acc_id;
                            // $entry_data['main_acc_acode'] = $this->AccountModel->getSetup()->cash_acc_acode;
                            //deb_account and crd_account
                            $entry_data['created_at'] = date('Y-m-d H:i:s');
                            $entry_data['created_by'] = $this->user;
                            if (!($this->db->insert('entry_data', $entry_data))) {
                                $error = "Failed To Add Beginning Entry ...";
                                $this->session->set_flashdata('error', $error);
                                echo json_encode(['records' => 1]);
                                return;
                            }
                        } else {
                            $error = "Failed To Add Beginning Entry ...";
                            $this->session->set_flashdata('error', $error);
                            echo json_encode(['records' => 1]);
                            return;
                        }
                    }
                    // $data_t = array(
                    //     'brand' => $this->brand,
                    //     'trns_type' => "Begin Entry",
                    //     'trns_id' => $trn_id,
                    //     'trns_ser' => str_pad($serial, 5, '0', STR_PAD_LEFT),
                    //     'trns_code' => $form['doc_no'],
                    //     'amount' => $table['debit_tot'],
                    //     'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    //     'currency_id' => $form['currency_hid'],
                    //     'rate' => $form['rate_h'],
                    //     'ev_amount' => $table['tot_evdebit'],
                    //     'data1' => $form['rem'],
                    //     'created_at' => date('Y-m-d H:i:s'),
                    //     'created_by' => $this->user
                    // );
                    // if ($this->db->insert('entry_data_total', $data_t)) {
                    $true = "Beginning Entry Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    echo json_encode(['records' => 0]);
                } else {
                    $error = "Failed To Add Beginning Entry ...";
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 1]);
                }
            } else {
                $error = "Failed To Add Beginning Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
            echo json_encode(['records' => 1]);
        }
    }

    public function editBeginEntry()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($data['permission']->edit == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $setup = $this->AccountModel->getsetup();

            $id = base64_decode($_GET['t']);
            $data['brand'] = $this->brand;
            // $data['brand'] = $this->admin_model->getbrand($this->brand);
            $data['master'] = $this->db->get_where('begin_master', array('id' => $id, 'brand' => $this->brand))->row();
            $data['details'] = $this->db->get_where('begin_details', array('tot_id' => $id, 'brand' => $this->brand))->result_array();
            // $data['count'] =
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/begin/editBeginEntry');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditBeginEntry()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 226);
        if ($permission->edit == 1) {
            $form = array(
                'serial' => $_POST['form'][1]['value'],
                'id' => $_POST['form'][2]['value'],
                'doc_no' => $_POST['form'][4]['value'],
                'cdate' => $_POST['form'][5]['value'],
                'currency_hid' => $_POST['form'][6]['value'],
                'rate_h' => $_POST['form'][8]['value'],
                'rem' => $_POST['form'][9]['value'],
            );
            $table = $_POST['table'];
            $rows = $_POST['rows'];
            if (isset($form['doc_no'])) {
                $records = $this->db->select('*')->from('begin_master')->where('doc_no=', $form['doc_no'])->where('brand=', $this->brand)->order_by('id')->get();
                if ($records->num_rows() != 0 && $records->row()->id != base64_decode($form['id'])) {
                    echo json_encode(['records' => 1]);
                    return;
                }
            }


            $id = base64_decode($form['id']);
            $master = $this->db->get_where('begin_master', ['id' => $id])->row();
            $data['ccode'] = $form['serial'];
            $data['doc_no'] = $form['doc_no'];
            $data['date'] = date("Y-m-d", strtotime($form['cdate']));
            $data['currency_id'] = $form['currency_hid'];
            $data['rate'] = $form['rate_h'];
            $data['rem'] = $form['rem'];
            $data['brand'] = $this->brand;
            $data['tot_deb'] = $table['debit_tot'];
            $data['tot_ev_deb'] = $table['tot_evdebit'];
            $data['tot_crd'] = $table['credit_tot'];
            $data['tot_ev_crd'] = $table['tot_evcredit'];

            $this->admin_model->addToLoggerUpdate('begin_master', 226, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('begin_master', $data, array('id' => $id))) {
                try {
                    $this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Begin Entry'));
                } catch (\Throwable $th) {
                }
                try {
                    $this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Begin Entry'));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $this->db->delete('begin_details', array('tot_id' => $id));
                } catch (\Throwable $th) {
                }
                $data_t = array(
                    'brand' => $this->brand,
                    'trns_type' => "Begin Entry",
                    'trns_id' => $id,
                    'trns_ser' => $form['serial'],
                    'trns_code' => $form['doc_no'],
                    'amount' => $table['debit_tot'],
                    'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    'currency_id' => $form['currency_hid'],
                    'rate' => $form['rate_h'],
                    'ev_amount' => $table['tot_evdebit'],
                    'data1' => $form['rem'],
                    'created_at' => $master->created_at,
                    'created_by' => $master->created_by
                );
                if ($this->db->insert('entry_data_total', $data_t)) {
                    $entry_data['tot_id'] = $this->db->insert_id("entry_data_total");

                    $details['tot_id'] = $id;
                    $details['brand'] = $this->brand;
                    $details['tot_code'] = $form['serial'];
                    $details['date'] = date("Y-m-d", strtotime($form['cdate']));
                    $details['currency_id'] = $form['currency_hid'];
                    $details['rate'] = $form['rate_h'];
                    $details['created_at'] = $master->created_at;
                    $details['created_by'] = $master->created_by;

                    for ($i = 0; $i < $rows; $i++) {
                        $details['deb_amount'] = $table['table'][$i]['debit'];
                        $details['ev_deb_amount'] = $table['table'][$i]['evdebit'];
                        $details['crd_amount'] = $table['table'][$i]['credit'];
                        $details['ev_crd_amount'] = $table['table'][$i]['evcredit'];
                        $details['account_id'] = $table['table'][$i]['account_id'];
                        $details['acc_acode'] = $this->AccountModel->getAcodeByID($details['account_id']);

                        if ($this->db->insert('begin_details', $details)) {
                            $entry_data['brand'] = $this->brand;
                            $entry_data['trns_type'] = "Begin Entry";
                            $entry_data['trns_id'] = $id;
                            $entry_data['trns_ser'] = $form['serial'];
                            $entry_data['trns_code'] = $form['doc_no'];
                            if ($details['deb_amount'] != 0) {
                                $entry_data['deb_amount'] = $details['deb_amount'];
                                $entry_data['deb_acc_id'] = $details['account_id'];
                                $entry_data['deb_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_deb'] = $details['ev_deb_amount'];
                                $entry_data['crd_amount'] = 0;
                                $entry_data['crd_acc_id'] = '';
                                $entry_data['crd_acc_acode'] = '';
                                $entry_data['ev_crd'] = 0;
                            } else {
                                $entry_data['crd_amount'] = $details['crd_amount'];
                                $entry_data['crd_acc_id'] = $details['account_id'];
                                $entry_data['crd_acc_acode'] = $details['acc_acode'];
                                $entry_data['ev_crd'] = $details['ev_crd_amount'];
                                $entry_data['deb_amount'] = 0;
                                $entry_data['deb_acc_id'] = '';
                                $entry_data['deb_acc_acode'] = '';
                                $entry_data['ev_deb'] = 0;
                            }
                            $entry_data['trns_date'] = date("Y-m-d", strtotime($form['cdate']));
                            $entry_data['currency_id'] = $form['currency_hid'];
                            $entry_data['rate'] = $form['rate_h'];
                            $entry_data['typ_account'] = "Other";

                            $entry_data['created_at'] = $master->created_at;
                            $entry_data['created_by'] = $master->created_by;

                            if (!($this->db->insert('entry_data', $entry_data))) {
                                $error = "Failed To Add Beginning Entry ...";
                                $this->session->set_flashdata('error', $error);
                                echo json_encode(['records' => 1]);
                                return;
                            }
                        } else {
                            $error = "Failed To Edit Beginning Entry ...";
                            $this->session->set_flashdata('error', $error);
                            echo json_encode(['records' => 1]);
                            return;
                        }
                    }
                    // $data_t = array(
                    //     'brand' => $this->brand,
                    //     'trns_type' => "Begin Entry",
                    //     'trns_id' => $id,
                    //     'trns_ser' => $form['serial'],
                    //     'trns_code' => $form['doc_no'],
                    //     'amount' => $table['debit_tot'],
                    //     'trns_date' => date("Y-m-d", strtotime($form['cdate'])),
                    //     'currency_id' => $form['currency_hid'],
                    //     'rate' => $form['rate_h'],
                    //     'ev_amount' => $table['tot_evdebit'],
                    //     'data1' => $form['rem'],
                    //     'created_at' => $master->created_at,
                    //     'created_by' => $master->created_by
                    // );
                    // if ($this->db->insert('entry_data_total', $data_t)) {
                    $true = "Beginning Entry Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    echo json_encode(['records' => 0]);
                } else {
                    $error = "Failed To Edit Beginning Entry ...";
                    $this->session->set_flashdata('error', $error);
                    echo json_encode(['records' => 1]);
                }
            } else {
                $error = "Failed To Edit Beginning Entry ...";
                $this->session->set_flashdata('error', $error);
                echo json_encode(['records' => 1]);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteBeginEntry($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 226);
        if ($check) {
            $this->admin_model->addToLoggerDelete('begin_master', 230, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('begin_master', array('id' => $id))) {
                if ($this->db->delete('begin_details', array('tot_id' => $id))) {
                    if ($this->db->delete('entry_data_total', array('trns_id' => $id, 'trns_type' => 'Begin Entry'))) {
                        if ($this->db->delete('entry_data', array('trns_id' => $id, 'trns_type' => 'Begin Entry'))) {
                            $true = "Beginning Entry Deleted Successfully ...";
                            $this->session->set_flashdata('true', $true);
                        } else {
                            $error = "Failed To Delete Beginning Entry ...";
                            $this->session->set_flashdata('error', $error);
                        }
                    } else {
                        $error = "Failed To Delete Beginning Entry ...";
                        $this->session->set_flashdata('error', $error);
                    }
                } else {
                    $error = "Failed To Delete Beginning Entry ...";
                    $this->session->set_flashdata('error', $error);
                }
            } else {
                $error = "Failed To Delete Beginning Entry ...";
                $this->session->set_flashdata('error', $error);
            }
            redirect(base_url("account/BeginEntryList"));
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function c_cust_payment_entry()
    {

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $setup = $this->AccountModel->getsetup();

        $deb_account_id = $setup->cust_acc_id;
        $deb_account_acode = $setup->cust_acc_acode;


        $rev_code = $setup->rev_num;
        $newrec = doubleval($rev_code);
        $newrec++;

        $vs_date1 = date('Y-m-d', strtotime($setup->sdate1));
        $vs_date2 = date('Y-m-d', strtotime($setup->sdate2));
        $cust_pay = $this->db->query("select * from payment order by id ");
        $is = 0;
        foreach ($cust_pay->result() as $row) {

            $crd_account_id = $this->AccountModel->getpayment_method_account_id($row->currency);
            $crd_account_acode = $this->AccountModel->getAcodeByID($crd_account_id);

            $paymentCurrency = $row->currency;
            $crd_account_id =

                $rate = $row->rate;
            $pay_amount = $row->net_amount;
            $inv_ev_amount = $row->ev_amount;

            $data_t = array(
                'brand' => $this->brand,
                'trns_type' => "Payment",
                'trns_id' => $row->id,
                'trns_ser' => str_pad($newrec, 10, '0', STR_PAD_LEFT),
                'trns_code' => '',
                'amount' => $pay_amount,
                'trns_date' => $row->payment_date,
                'currency_id' => $paymentCurrency,
                'rate' => $rate,
                'deb_account' => '',
                'crd_account' => $row->customer,
                'ev_amount' => $inv_ev_amount,
                'typ_account' => 'customer',
                'created_at' => $row->created_at,
                'created_by' => $row->created_by

            );
            if ($this->db->insert('entry_data_total', $data_t)) {
                $entry_data['tot_id'] = $this->db->insert_id('entry_data_total');
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Invoice";
                $entry_data['trns_id'] = $row->id;
                $entry_data['trns_ser'] = str_pad($newrec, 10, '0', STR_PAD_LEFT);
                $entry_data['trns_code'] = $row->external_serial;
                $entry_data['trns_date'] = $row->payment_date;
                $entry_data['currency_id'] = $paymentCurrency;
                $entry_data['rate'] = $rate;
                $entry_data['typ_account'] = 'Customer';

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['crd_account'] = '';
                $entry_data['ev_crd'] = 0;

                $entry_data['deb_amount'] = $pay_amount;
                $entry_data['deb_acc_id'] = $setup->cust_acc_id;
                $entry_data['deb_acc_acode'] = $setup->cust_acc_acode;
                $entry_data['deb_account'] = $row->customer;
                $entry_data['ev_deb'] = $inv_ev_amount;

                $entry_data['created_at'] = $row->created_at;
                $entry_data['created_by'] = $row->created_by;

                if ($this->db->insert('entry_data', $entry_data)) {
                    $entry_data['crd_amount'] = $pay_amount;
                    $entry_data['crd_acc_id'] = $setup->rev_acc_id;
                    $entry_data['crd_acc_acode'] = $setup->rev_acc_acode;
                    $entry_data['crd_account'] = '';
                    $entry_data['ev_crd'] = $inv_ev_amount;

                    $entry_data['deb_amount'] = 0;
                    $entry_data['deb_acc_id'] = '';
                    $entry_data['deb_acc_acode'] = '';
                    $entry_data['deb_account'] = '';
                    $entry_data['ev_deb'] = 0;

                    if ($this->db->insert('entry_data', $entry_data)) {
                        $this->db->where('id', $setup->id);
                        $this->db->update('acc_setup', array('rec_num' => str_pad($newrec, 10, "0", STR_PAD_LEFT)));
                    }
                }
            }
            print_r($newrec);
            $newrec++;
            print_r($newrec);
            $is = $is + 1;
            if ($is == 10) {
                break;
            }
        }
        $true = " Successfully ...";
        $this->session->set_flashdata('true', $true);
    }
    public function c_cust_invoice_entry()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $setup = $this->AccountModel->getsetup();

        $deb_account_id = $setup->cust_acc_id;
        $deb_account_acode = $setup->cust_acc_acode;
        $crd_account_id = $setup->rev_acc_id;
        $crd_account_acode = $setup->rev_acc_acode;

        $rec_code = $setup->rec_num;
        $newrec = doubleval($rec_code);
        $newrec++;
        // print_r($newrec);
        // die;
        $vs_date1 = date('Y-m-d', strtotime($setup->sdate1));
        $vs_date2 = date('Y-m-d', strtotime($setup->sdate2));
        $invoice = $this->db->query("select * from invoices order by id ");
        $is = 0;
        foreach ($invoice->result() as $row) {
            $invoiceCurrency = $row->currency;
            $rate = $row->rate;
            $inv_amount = $row->amount;
            $inv_ev_amount = $row->ev_amount;

            $data_t = array(
                'brand' => $this->brand,
                'trns_type' => "Invoice",
                'trns_id' => $row->id,
                'trns_ser' => str_pad($newrec, 10, '0', STR_PAD_LEFT),
                'trns_code' => $row->external_serial,
                'amount' => $inv_amount,
                'trns_date' => $row->issue_date,
                'currency_id' => $invoiceCurrency,
                'rate' => $rate,
                'deb_account' => $row->customer,
                'crd_account' => '',
                'ev_amount' => $inv_ev_amount,
                'typ_account' => 'customer',
                'created_at' => $row->created_at,
                'created_by' => $row->created_by

            );
            if ($this->db->insert('entry_data_total', $data_t)) {
                $entry_data['tot_id'] = $this->db->insert_id('entry_data_total');
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Invoice";
                $entry_data['trns_id'] = $row->id;
                $entry_data['trns_ser'] = str_pad($newrec, 10, '0', STR_PAD_LEFT);
                $entry_data['trns_code'] = $row->external_serial;
                $entry_data['trns_date'] = $row->issue_date;
                $entry_data['currency_id'] = $invoiceCurrency;
                $entry_data['rate'] = $rate;
                $entry_data['typ_account'] = 'Customer';

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['crd_account'] = '';
                $entry_data['ev_crd'] = 0;

                $entry_data['deb_amount'] = $inv_amount;
                $entry_data['deb_acc_id'] = $setup->cust_acc_id;
                $entry_data['deb_acc_acode'] = $setup->cust_acc_acode;
                $entry_data['deb_account'] = $row->customer;
                $entry_data['ev_deb'] = $inv_ev_amount;

                $entry_data['created_at'] = $row->created_at;
                $entry_data['created_by'] = $row->created_by;

                if ($this->db->insert('entry_data', $entry_data)) {
                    $entry_data['crd_amount'] = $inv_amount;
                    $entry_data['crd_acc_id'] = $setup->rev_acc_id;
                    $entry_data['crd_acc_acode'] = $setup->rev_acc_acode;
                    $entry_data['crd_account'] = '';
                    $entry_data['ev_crd'] = $inv_ev_amount;

                    $entry_data['deb_amount'] = 0;
                    $entry_data['deb_acc_id'] = '';
                    $entry_data['deb_acc_acode'] = '';
                    $entry_data['deb_account'] = '';
                    $entry_data['ev_deb'] = 0;

                    if ($this->db->insert('entry_data', $entry_data)) {
                        $this->db->where('id', $setup->id);
                        $this->db->update('acc_setup', array('rec_num' => str_pad($newrec, 10, "0", STR_PAD_LEFT)));
                    }
                }
            }
            // print_r($newrec);
            $newrec++;
            // print_r($newrec);
            // $is = $is + 1;
            // if ($is == 10) {
            //     break;
            // }


        }
        $true = " Successfully ...";
        $this->session->set_flashdata('true', $true);
    }
    public function c_cust_invoice_tables()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2048M');
        $setup = $this->AccountModel->getsetup();

        $rev_code = doubleval($setup->rec_num);
        $vs_date1 = date('Y-m-d', strtotime($setup->sdate1));
        $vs_date2 = date('Y-m-d', strtotime($setup->sdate2));
        $newrev = $rev_code;
        $invoice = $this->db->query("select * from invoices ");
        $is = 0;
        foreach ($invoice->result() as $row) {
            $po_ids = $row->po_ids;
            $id = explode(",", $po_ids);
            $all = 0;
            for ($i = 0; $i < count($id); $i++) {

                $total = $this->projects_model->totalRevenuePO($id[$i]);
                $all = $all + $total['total'];
            }



            $invoiceTotal = $this->accounting_model->getInvoiceTotal($row->po_ids);
            $invoiceCurrency = $this->accounting_model->getInvoiceCurrency($row->po_ids);
            $job = $this->db->query(" SELECT * FROM job WHERE po IN (" . $row->po_ids . ") ")->result();
            $poCount = count($job);
            $jobTotal = 0;
            $ev_jobTotal = 0;

            foreach ($job as $k => $job) {
                $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                $jobTotal += $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                $ev_jobTotal += number_format($this->accounting_model->transfareTotalToCurrencyRate($invoiceCurrency, 2, $row->issue_date, $jobTotal), 2);
            }
            if ($jobTotal != 0) {
                continue;
            }
            $rate = $ev_jobTotal / $jobTotal;
            $this->db->where('id', $row->id);
            $this->db->update('invoices', array('amount' => $jobTotal, 'ev_amount' => $ev_jobTotal, 'currency' => $invoiceCurrency, 'rate' => $rate));






            $data_t = array(
                'brand' => $this->brand,
                'trns_type' => "Invoice",
                'trns_id' => $row->id,
                'trns_ser' => str_pad($newrev, 10, '0', STR_PAD_LEFT),
                'trns_code' => $row->external_serial,
                'amount' => $jobTotal,
                'trns_date' => $row->issue_date,
                'currency_id' => $invoiceCurrency,
                'rate' => $rate,
                'ev_amount' => $ev_jobTotal,
                'created_at' => $row->created_at,
                'created_by' => $row->created_by

            );
            if ($this->db->insert('entry_data_total', $data_t)) {
                $entry_data['tot_id'] = $this->db->insert_id('entry_data_total');
                $entry_data['brand'] = $this->brand;
                $entry_data['trns_type'] = "Invoice";
                $entry_data['trns_id'] = $row->id;
                $entry_data['trns_ser'] = str_pad($newrev, 10, '0', STR_PAD_LEFT);
                $entry_data['trns_code'] = $row->external_serial;
                $entry_data['trns_date'] = $row->issue_date;
                $entry_data['currency_id'] = $invoiceCurrency;
                $entry_data['rate'] = $rate;
                $entry_data['typ_account'] = 'Customer';

                $entry_data['crd_amount'] = 0;
                $entry_data['crd_acc_id'] = '';
                $entry_data['crd_acc_acode'] = '';
                $entry_data['crd_account'] = '';
                $entry_data['ev_crd'] = 0;

                $entry_data['deb_amount'] = $jobTotal;
                $entry_data['deb_acc_id'] = $setup->cust_acc_id;
                $entry_data['deb_acc_acode'] = $setup->cust_acc_acode;
                $entry_data['deb_account'] = $row->customer;
                $entry_data['ev_deb'] = $ev_jobTotal;

                $entry_data['created_at'] = $row->created_at;
                $entry_data['created_by'] = $row->created_by;

                if ($this->db->insert('entry_data', $entry_data)) {
                    $entry_data['crd_amount'] = $jobTotal;
                    $entry_data['crd_acc_id'] = $setup->rev_acc_id;
                    $entry_data['crd_acc_acode'] = $setup->rev_acc_acode;
                    $entry_data['crd_account'] = '';
                    $entry_data['ev_crd'] = $ev_jobTotal;

                    $entry_data['deb_amount'] = 0;
                    $entry_data['deb_acc_id'] = '';
                    $entry_data['deb_acc_acode'] = '';
                    $entry_data['deb_account'] = '';
                    $entry_data['ev_deb'] = 0;

                    if ($this->db->insert('entry_data', $entry_data)) {
                        $collection_inv['brand'] = $this->brand;
                        $collection_inv['invoive_id'] = $row->id;
                        $collection_inv['invoice_currency'] = $invoiceCurrency;
                        $collection_inv['invoice_date'] = $row->issue_date;
                        $collection_inv['coll_type'] = 'Invoice';
                        $collection_inv['invoice_amount'] = $jobTotal;
                        $collection_inv['invoice_ev'] = $ev_jobTotal;
                        $collection_inv['remain'] = $ev_jobTotal;
                        if ($this->db->insert('invoices_collection', $collection_inv)) {
                            $this->db->where('id', $setup->id);
                            $this->db->update('acc_setup', array('rec_num' => str_pad($newrev, 10, "0", STR_PAD_LEFT)));
                        }
                    }
                }
            }
            $newrev = $rev_code + 1;
            $is = $is + 1;
            // if ($is == 10) {
            //     break;
            // }
        }
        $true = " Successfully ...";
        $this->session->set_flashdata('true', $true);
    }
    function importPaymentMethod()
    {
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $inputFileType = PHPExcel_IOFactory::identify($path);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path);
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $flag = true;
            $i = 0;
            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;
            $succ = 0;

            foreach ($allDataInSheet as $value) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                $id = $value['C'];
                $inserdata['ccode'] = str_pad($id, 10, '0', STR_PAD_LEFT);
                if ($value['E'] == 'Bank') {
                    $inserdata['type'] = '2';
                    $inserdata['ost_id'] = $setup->bank_acc_id;
                    $inserdata['ost_code'] = $setup->bank_acc_acode;
                    $inserdata['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->bank_acc_id)->parent_id;
                    if ($inserdata['p_ost_id'] == '') {
                        $inserdata['p_ost_code'] = '';
                    } else {
                        $inserdata['p_ost_code'] = $this->AccountModel->get_accountRowID($inserdata['p_ost_id'])->acode;
                    }
                }
                if ($value['E'] == 'Cash') {
                    $inserdata['type'] = '1';
                    $inserdata['ost_id'] = $setup->cash_acc_id;
                    $inserdata['ost_code'] = $setup->cash_acc_acode;
                    $inserdata['p_ost_id'] = $this->AccountModel->get_accountRowID($setup->cash_acc_id)->parent_id;
                    if ($inserdata['p_ost_id'] == '') {
                        $inserdata['p_ost_code'] = '';
                    } else {
                        $inserdata['p_ost_code'] = $this->AccountModel->get_accountRowID($inserdata['p_ost_id'])->acode;
                    }
                }
                $inserdata['bank'] = $this->AccountModel->getByNAME('bank', $value['F']);
                $inserdata['acc_code'] = $value['G'];
                $inserdata['currency_id'] = $this->AccountModel->getByNAME('currency', $value['H']);
                if ($value['I'] != '') {
                    $this->db->like('name', $value['I'], 'before');
                    $query = $this->db->get('account_chart');
                    if ($query->num_rows() != 0) {
                        $inserdata['account_id'] = $query->row()->id;
                    } else {
                        $inserdata['account_id'] = '';
                    }
                } else {
                    $inserdata['account_id'] = '';
                }
                //query("select * from account_chart where name like '%" . $value['I'] . "'")->id;
                //$this->AccountModel->getByNAME('account_chart', $value['I']);

                if ($id <> '') {
                    if ($this->db->update('payment_method', $inserdata, array('id' => $id))) {
                        $succ++;
                    }
                }
            }
            if ($succ > 0) {
                echo "Payment Method Imported successfully";
            } else {
                echo "ERROR !";
            }
        }
    }
    function auto_num_Transaction()
    {
        $transaction_type = $this->input->post('transaction', TRUE);
        $date_trns = $this->input->post('cdate', TRUE);
        $month_trns = date('m', strtotime($date_trns));
        $year_trns = date('Y', strtotime($date_trns));
        $sql = "SELECT SUBSTRING(trns_code,-5) as trns_code from entry_data_total where trns_type ='" . $transaction_type . "' and month(trns_date) = '" . $month_trns . "' and year(trns_date) = '" . $year_trns . "' and brand = '" . $this->brand . "' order by trns_code  DESC limit 1";

        $qu = $this->db->query($sql);
        $query = $qu->result_array();
        if ($qu->num_rows() > 0) {
            $auto_num = intval($query[0]['trns_code']) + 1;
        } else {
            $auto_num = 1;
        }

        $new_auto_num = str_pad($month_trns, 2, '0', STR_PAD_LEFT) . "-" . str_pad($auto_num, 5, '0', STR_PAD_LEFT);

        echo $new_auto_num;
    }
    function auto_num()
    {
        $date_trns = $this->input->post('cdate', TRUE);
        $month_trns = date('m', strtotime($date_trns));
        $year_trns = date('Y', strtotime($date_trns));
        $sql = "SELECT SUBSTRING(trns_code,-5) as trns_code from entry_data_total where trns_type ='Manual Entry' and month(trns_date) = '" . $month_trns . "' and year(trns_date) = '" . $year_trns . "' and brand = '" . $this->brand . "' order by trns_code  DESC limit 1";

        $qu = $this->db->query($sql);
        $query = $qu->result_array();
        //var_dump($query[0]['trns_code']);
        if ($qu->num_rows() > 0) {
            $auto_num = intval($query[0]['trns_code']) + 1;
        } else {
            $auto_num = 1;
        }

        $new_auto_num = str_pad($month_trns, 2, '0', STR_PAD_LEFT) . "-" . str_pad($auto_num, 5, '0', STR_PAD_LEFT);

        echo $new_auto_num;
    }
    function auto_num_CashIn()
    {
        $date_trns = $this->input->post('cdate', TRUE);
        $month_trns = date('m', strtotime($date_trns));
        $year_trns = date('Y', strtotime($date_trns));
        $sql = "SELECT SUBSTRING(trns_code,-5) as trns_code from entry_data_total where trns_type ='Cash In' and month(trns_date) = '" . $month_trns . "' and year(trns_date) = '" . $year_trns . "' and brand = '" . $this->brand . "' order by trns_code  DESC limit 1";

        $qu = $this->db->query($sql);
        $query = $qu->result_array();
        //var_dump($query[0]['trns_code']);
        if ($qu->num_rows() > 0) {
            $auto_num = intval($query[0]['trns_code']) + 1;
        } else {
            $auto_num = 1;
        }

        $new_auto_num = str_pad($month_trns, 2, '0', STR_PAD_LEFT) . "-" . str_pad($auto_num, 5, '0', STR_PAD_LEFT);

        echo $new_auto_num;
    }
    function auto_num_CashOut()
    {
        $date_trns = $this->input->post('cdate', TRUE);
        $month_trns = date('m', strtotime($date_trns));
        $year_trns = date('Y', strtotime($date_trns));
        $sql = "SELECT SUBSTRING(trns_code,-5) as trns_code from entry_data_total where trns_type ='Cash Out' and month(trns_date) = '" . $month_trns . "' and year(trns_date) = '" . $year_trns . "' and brand = '" . $this->brand . "' order by trns_code  DESC limit 1";

        $qu = $this->db->query($sql);
        $query = $qu->result_array();
        if ($qu->num_rows() > 0) {
            $auto_num = intval($query[0]['trns_code']) + 1;
        } else {
            $auto_num = 1;
        }

        $new_auto_num = str_pad($month_trns, 2, '0', STR_PAD_LEFT) . "-" . str_pad($auto_num, 5, '0', STR_PAD_LEFT);

        echo $new_auto_num;
    }
    // function importhr()
    // {
    //     if (isset($_FILES["file"]["name"])) {
    //         $path = $_FILES["file"]["tmp_name"];
    //         $object = PHPExcel_IOFactory::load($path);
    //         $inputFileType = PHPExcel_IOFactory::identify($path);
    //         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    //         $objPHPExcel = $objReader->load($path);
    //         $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    //         $flag = true;
    //         $i = 0;
    //         $setup = $this->AccountModel->getSetup();
    //         $data['setup'] = $setup;
    //         $succ = 0;

    //         foreach ($allDataInSheet as $value) {
    //             if ($flag) {
    //                 $flag = false;
    //                 continue;
    //             }
    //             $id = $value['A'] . trim();
    //             $inserdata['time_zone'] = $value['K'] . trim();
    //             if ($id <> '') {
    //                 if ($this->db->update('employees', $inserdata, array('id' => $id))) {
    //                     $succ++;
    //                 }
    //             }
    //         }
    //         if ($succ > 0) {
    //             echo "Payment Method Imported successfully";
    //         } else {
    //             echo "ERROR !";
    //         }
    //     }
    // }
    function fileToDelete()
    {
        $id = base64_decode($_POST['id']);
        $file_toDelete = $_POST['file_toDelete'];
        $type = $_POST['type'];
        $file_name = './assets/uploads/account/' . $type . '/' . $file_toDelete;
        $data['doc_file'] = "";
        $data['name_file'] = "";
        $data['desc_file'] = "";
        if (unlink($file_name)) {
            if ($this->db->update($type, $data, array('id' => $id))) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
}
