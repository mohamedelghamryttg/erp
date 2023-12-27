<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Excelfile');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->brand = $this->session->userdata('brand');
        $this->user = $this->session->userdata('id');
    }
    public function index()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 10);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 10);
            //body ..

            $data['user'] = $this->user;
            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $count = 0;

            $arr2 = array();
            if ($this->input->post('customer_name') != null) {
                $customerName = $this->input->post('customer_name');
                if (!empty($customerName)) {
                    array_push($arr2, 0);
                }
            } else {
                $customerName = "";
            }
            if ($this->input->post('website') != null) {
                $website = $this->input->post('website');
                if (!empty($website)) {
                    array_push($arr2, 1);
                }
            } else {
                $website = "";
            }
            if ($this->input->post('created_by') != null) {
                $created_by = $this->input->post('created_by');
                if (!empty($created_by)) {
                    array_push($arr2, 2);
                }
            } else {
                $created_by = "";
            }
            if ($this->input->post('status') != null) {
                $status = $this->input->post('status');
                if (!empty($status)) {
                    array_push($arr2, 3);
                }
            } else {
                $status = "";
            }
            if ($this->input->post('alias') != null) {
                $alias = $this->input->post('alias');
                if (!empty($alias)) {
                    array_push($arr2, 4);
                }
            } else {
                $alias = "";
            }
            $client_type = $this->input->post('client_type');
            if ($client_type === null) {
            } else {
                if (!empty($client_type)) {
                    array_push($arr2, 5);
                }
            }

            $search = $this->session->userdata('search');
            if (count($arr2) > 0) {
                $this->session->set_userdata("search", $search);
                $cond1 = "`name` LIKE '%$customerName%'";
                $cond2 = "`website` LIKE '%$website%'";
                $cond3 = "`created_by` = '$created_by'";
                $cond4 = "`status` = '$status'";
                $cond5 = "`alias` LIKE '%$alias%'";
                $cond6 = "`client_type` = '$client_type'";

                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);

                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    //$data['customer'] = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, $arr4);
                    $data['customer'] = $this->customer_model->AllCustomersPages($data['permission'], $this->user, $this->brand, $limit, $offset, $arr4);
                    $count = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, $arr4)->num_rows();
                } else {
                    $data['customer'] = $this->customer_model->AllCustomersPages($data['permission'], $this->user, $this->brand, $limit, $offset, 1);
                    $count = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, 1)->num_rows();
                }
            } else {
                // if ($this->session->userdata('search') != NULL) {
                $search = $this->session->userdata('search');
                // }

                $count = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, 1)->num_rows();
                $data['customer'] = $this->customer_model->AllCustomersPages($data['permission'], $this->user, $this->brand, $limit, $offset, 1);
                // $data['total_rows'] = $count;
                // var_dump($data['customer']);
            }

            $config['base_url'] = base_url('customer/index/');
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


            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/customer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function Oldindex()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 10);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 10);
            //body ..
            // $data['customer'] = $this->customer_model->AllCustomers($data['permission'],$this->user,$this->brand);
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer_name'])) {
                    $customerName = $_REQUEST['customer_name'];
                    if (!empty($customerName)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customerName = "";
                }
                if (isset($_REQUEST['website'])) {
                    $website = $_REQUEST['website'];
                    if (!empty($website)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $website = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['alias'])) {
                    $alias = $_REQUEST['alias'];
                    if (!empty($alias)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $alias = "";
                }
                // print_r($arr2);
                $cond1 = "name LIKE '%$customerName%'";
                $cond2 = "website LIKE '%$website%'";
                $cond3 = "created_by = '$created_by'";
                $cond4 = "status = '$status'";
                $cond5 = "alias LIKE '%$alias%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['customer'] = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['customer'] = $this->customer_model->AllCustomersPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['customer']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/index/');
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

                $data['customer'] = $this->customer_model->AllCustomersPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('customer/customer.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportcustomer()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=customer.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 10);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 10);
            //body ..
            // $data['customer'] = $this->customer_model->AllCustomers($data['permission'],$this->user,$this->brand);
            $data['user'] = $this->user;
            $arr2 = array();
            if (isset($_REQUEST['customer_name'])) {
                $customerName = $_REQUEST['customer_name'];
                if (!empty($customerName)) {
                    array_push($arr2, 0);
                }
            } else {
                $customerName = "";
            }
            if (isset($_REQUEST['website'])) {
                $website = $_REQUEST['website'];
                if (!empty($website)) {
                    array_push($arr2, 1);
                }
            } else {
                $website = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 2);
                }
            } else {
                $created_by = "";
            }
            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    array_push($arr2, 3);
                }
            } else {
                $status = "";
            }
            if (isset($_REQUEST['alias'])) {
                $alias = $_REQUEST['alias'];
                if (!empty($alias)) {
                    array_push($arr2, 4);
                }
            } else {
                $alias = "";
            }
            if (isset($_REQUEST['client_type'])) {
                $client_type = $_REQUEST['client_type'];
                if (!empty($client_type)) {
                    array_push($arr2, 5);
                }
            } else {
                $client_type = "";
            }
            // print_r($arr2);
            $cond1 = "name = '$customerName'";
            $cond2 = "website = '$website'";
            $cond3 = "created_by = '$created_by'";
            $cond4 = "status = '$status'";
            $cond5 = "alias = '$alias'";
            $cond6 = "client_type = '$client_type'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['customer'] = $this->customer_model->AllCustomers($data['permission'], $this->user, $this->brand, $arr4);
            }
            $this->load->view('customer/exportcustomer.php', $data);
        }
    }

    public function addCustomer()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 11);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 11);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addCustomer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCustomer()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 11);
        if ($check) {
            $data['name'] = $_POST['name'];
            $data['website'] = $_POST['website'];
            $data['status'] = '1';
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            $websiteCheck = $this->db->get_where('customer', array('website' => $data['website'], 'brand' => $this->brand))->num_rows();
            if ($websiteCheck > 0) {
                $error = "Failed : There's another customer with the same website ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer");
            } else {
                if ($this->db->insert('customer', $data)) {
                    $true = "Customer Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "customer");
                } else {
                    $error = "Failed To Add Customer ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCustomer()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 12);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 12);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['customer'] = $this->customer_model->customerById($id);
            $data['role'] = $this->role;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editCustomer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCustomer($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 12);
        if ($check) {
            $oldWebsite = $this->db->get_where('customer', array('id' => $id))->row()->website;

            $data['name'] = $_POST['name'];
            $data['website'] = $_POST['website'];
            $data['alias'] = $_POST['alias'];
            $data['payment'] = $_POST['payment'];
            $data['client_type'] = $_POST['client_type'] ?? Null;

            $referer = $_POST['referer'];
            if ($oldWebsite == $data['website']) {
                $this->admin_model->addToLoggerUpdate('customer', 12, 'id', $id, 0, 0, $this->user);

                if ($this->db->update('customer', $data, array('id' => $id))) {
                    $this->customer_model->addLastUpdated('customer', $id);
                    $true = "Customer Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    // redirect(base_url()."customer");
                    if (!empty($referer)) {
                        redirect($referer);
                    } else {
                        redirect(base_url() . "customer");
                    }
                } else {
                    $error = "Failed To Edit Customer ...";
                    $this->session->set_flashdata('error', $error);
                    //redirect(base_url()."customer");
                    if (!empty($referer)) {
                        redirect($referer);
                    } else {
                        redirect(base_url() . "customer");
                    }
                }
            } else {
                $websiteCheck = $this->db->get_where('customer', array('website' => $data['website'], 'brand' => $this->brand))->num_rows();
                if ($websiteCheck > 0) {
                    $error = "Failed : There's another customer with the same website ...";
                    $this->session->set_flashdata('error', $error);
                    //redirect(base_url()."customer");
                    if (!empty($referer)) {
                        redirect($referer);
                    } else {
                        redirect(base_url() . "customer");
                    }
                } else {
                    $this->admin_model->addToLoggerUpdate('customer', 12, 'id', $id, 0, 0, $this->user);
                    if ($this->db->update('customer', $data, array('id' => $id))) {
                        $this->customer_model->addLastUpdated('customer', $id);
                        $true = "Customer Edited Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "customer");
                    } else {
                        $error = "Failed To Edit Customer ...";
                        $this->session->set_flashdata('error', $error);
                        //redirect(base_url()."customer");
                        if (!empty($referer)) {
                            redirect($referer);
                        } else {
                            redirect(base_url() . "customer");
                        }
                    }
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCustomer()
    {
        // Check Permission ..
        $id = base64_decode($_GET['t']);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 10);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('customer', 13, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer', array('id' => $id))) {
                $true = "customer Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."customer");
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete customer ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."customer");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function leads()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 14);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $region = "";
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

                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $created_by = "";
                }
                $idsArray = array();
                $leadIds = "";
                if (isset($_REQUEST['assigned_to'])) {
                    $data['assigned_to'] = $assigned_to = $_REQUEST['assigned_to'];
                    if (!empty($assigned_to)) {
                        array_push($arr2, 4);
                        $data['assigned_to'] = $assigned_to;
                        $ids = $this->db->select('lead')->get_where('customer_sam', array('sam' => $assigned_to))->result();
                        if (!empty($ids)) {
                            foreach ($ids as $val)
                                array_push($idsArray, $val->lead);
                            $leadIds = implode(" , ", $idsArray);
                        } else {
                            $leadIds = "0";
                        }
                    }
                }
                // print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "region = '$region'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond4 = "created_by = '$created_by'";
                $cond5 = "id IN ($leadIds)";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['leads'] = $this->customer_model->allCustomerLeadsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['leads']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->allCustomerLeads($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/leads');
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

                $data['leads'] = $this->customer_model->allCustomerLeadsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'],$this->user,$this->brand,1);
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/leads.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportleads()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CustomerLeads.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 14);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 0);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 1);
                }
            } else {
                $region = "";
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

            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 3);
                }
            } else {
                $created_by = "";
            }
            $idsArray = array();
            $leadIds = "";
            if (isset($_REQUEST['assigned_to'])) {
                $assigned_to = $_REQUEST['assigned_to'];
                if (!empty($assigned_to)) {
                    array_push($arr2, 4);
                    $data['assigned_to'] = $assigned_to;
                    $ids = $this->db->select('lead')->get_where('customer_sam', array('sam' => $assigned_to))->result();
                    if (!empty($ids)) {
                        foreach ($ids as $val)
                            array_push($idsArray, $val->lead);
                        $leadIds = implode(" , ", $idsArray);
                    } else {
                        $leadIds = "0";
                    }
                }
            }
            // print_r($arr2);
            $cond1 = "customer = '$customer'";
            $cond2 = "region = '$region'";
            $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond4 = "created_by = '$created_by'";
            $cond5 = "id IN ($leadIds)";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'], $this->user, $this->brand, 1);
            }

            //Pages ..

            $this->load->view('customer/exportleads.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLead()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addLead.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddLead()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($permission->add == 1) {
            $data['customer'] = $_POST['customer'];
            $data['region'] = $_POST['region'];
            $data['country'] = $_POST['country'];
            $data['type'] = $_POST['type'];
            $data['source'] = $_POST['source'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['approved'] = "1";
            $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 15);
            if ($permission->follow == 2) {
                $data['status'] = $_POST['status'];
            }
            if ($this->db->insert('customer_leads', $data)) {
                $id = $this->db->insert_id();
                $sam['lead'] = $id;
                $sam['sam'] = $data['created_by'];
                $sam['customer'] = $data['customer'];
                if (!$this->db->insert('customer_sam', $sam)) {
                    $this->db->delete('customer_leads', array('id' => $id));
                    $error = "Failed To Add Customer Lead ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer/leads");
                }

                $true = "Customer Lead Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/leads");
            } else {
                $error = "Failed To Add Customer Lead ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/leads");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editLead()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['lead'] = $this->db->get_where('customer_leads', array('id' => $id))->row();
            $data['brand'] = $this->brand;
            // $data['activityComment'] = $this->db->query(" SELECT s.id,s.lead,s.created_by,(SELECT COUNT(*) FROM `customer_activity_comment` WHERE activity = s.id AND lead = '$id') AS total FROM sales_activity AS s HAVING total > 0 ");
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editLead.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditLead($id)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($permission->edit == 1) {
            $data['customer'] = $_POST['customer'];
            $data['region'] = $_POST['region'];
            $data['country'] = $_POST['country'];
            $data['type'] = $_POST['type'];
            $data['source'] = $_POST['source'];
            $data['comment'] = $_POST['comment'];
            $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 15);
            if ($permission->follow == 2) {
                $data['status'] = $_POST['status'];
                $data['approved'] = $_POST['approved'];
                $data['approved_by'] = $this->user;
                $data['approve_date'] = date("Y-m-d H:i:s");
            }
            $this->admin_model->addToLoggerUpdate('customer_leads', 16, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('customer_leads', $data, array('id' => $id))) {
                $true = "Customer Lead Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/leads");
                }
            } else {
                $error = "Failed To edit Customer Lead ...";
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    $this->session->set_flashdata('error', $error);
                }
                redirect(base_url() . "customer/leads");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLeadComment()
    {
        $marketing['activity'] = $_POST['activity'];
        $marketing['lead'] = $_POST['lead'];
        $marketing['comment'] = $_POST['comment'];
        $marketing['team'] = 22;
        $marketing['created_by'] = $this->user;
        $marketing['created_at'] = date("Y-m-d H:i:s");
        if ($this->db->insert('customer_activity_comment', $marketing)) {
            $this->sales_model->sendLeadCommentMail($marketing, $this->user, $this->brand);
            echo "Your Message Sent Successfully ...";
        } else {
            echo "Failed to Send, Please try Again!";
        }
    }

    public function deleteLead()
    {
        // Check Permission ..
        $id = base64_decode($_GET['t']);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('customer_leads', 17, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer_leads', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('customer_sam', 17, 'lead', $id, 1, $id, $this->user);
                $this->db->delete('customer_sam', array('lead' => $id));
                // $this->db->delete('customer_contacts',array('lead' => $id));
                $true = "Lead Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Lead ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteSamCustomer()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($permission->follow == 2) {
            $id = $_POST['t'];
            $rowId = $_POST['rowId'];
            $sam = $this->db->get_where('customer_sam', array('id' => $id))->row()->sam;
            $this->admin_model->addToLoggerDelete('customer_sam', 14, 'id', $id, 0, $id, $this->user);
            if ($this->db->delete('customer_sam', array('id' => $id))) {
                echo $this->customer_model->samLeadsTable($rowId);
                $this->customer_model->UnAssignSamCustomerMail($sam, $rowId);
            } else {
                $error = "Failed To Delete Sam ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function assignSamCustomer()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($permission->follow == 2) {
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['sam'] = $_POST['sam'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('customer_sam', $data)) {
                echo $this->customer_model->samLeadsTable($data['lead']);
                $this->customer_model->assignSamCustomerMail($data['sam'], $data['lead']);
            } else {
                $error = "Failed To Assign Sam ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function leadContacts()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 19);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 19);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['lead'] = $this->db->get_where('customer_leads', array('id' => $data['id']))->row();
            $data['contacts'] = $this->customer_model->customerContacts($data['permission'], $this->user, $data['id']);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/leadContacts.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addLeadContacts()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 20);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 20);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addLeadContacts.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddLeadContacts()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 20);
        if ($check) {
            $data['lead'] = base64_decode($_GET['t']);
            $data['name'] = $_POST['name'];
            $data['phone'] = $_POST['phone'];
            $data['email'] = $_POST['email'];
            $data['skype_account'] = $_POST['skype_account'];
            $data['job_title'] = $_POST['job_title'];
            $data['location'] = $_POST['location'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('customer_contacts', $data)) {
                $true = "Customer Contacts Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/leadContacts?t=" . $_GET['t']);
            } else {
                $error = "Failed To Add Customer Contacts ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/leadContacts?t=" . $_GET['t']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editLeadContacts()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 21);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 21);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['contact'] = $this->db->get_where('customer_contacts', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editLeadContacts.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditLeadContacts()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 21);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $data['name'] = $_POST['name'];
            $data['phone'] = $_POST['phone'];
            $data['email'] = $_POST['email'];
            $data['skype_account'] = $_POST['skype_account'];
            $data['job_title'] = $_POST['job_title'];
            $data['location'] = $_POST['location'];
            $data['comment'] = $_POST['comment'];
            $lead = $_POST['lead'];
            $this->admin_model->addToLoggerUpdate('customer_contacts', 21, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('customer_contacts', $data, array('id' => $id))) {
                $this->customer_model->addLastUpdated('customer_contacts', $id);
                $true = "Customer Contacts Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/leadContacts?t=" . base64_encode($lead));
            } else {
                $error = "Failed To Edit Customer Contacts ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/leadContacts?t=" . base64_encode($lead));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteLeadContacts()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 19);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_contacts', 22, 'id', $id, 0, $id, $this->user);
            if ($this->db->delete('customer_contacts', array('id' => $id))) {
                $true = "Customer Contacts Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Customer Contacts ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getCountries()
    {
        $region = $_POST['region'];
        if (isset($_POST['country'])) {
            $country = $_POST['country'];
        } else {
            $country = "";
        }
        $data = '<option disabled="disabled" selected="selected">-- Select Country --</option>';
        $data .= $this->admin_model->selectCountries($country, $region);

        echo $data;
    }

    public function priceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 18);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 18);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
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
                if (isset($_REQUEST['status'])) {
                    if ($_REQUEST['status'] == 3) {
                        $status = 0;
                    } else {
                        $status = $_REQUEST['status'];
                    }
                    $data['status'] = $_REQUEST['status'];
                    if ($_REQUEST['status'] > 0) {
                        array_push($arr2, 7);
                    }
                } else {
                    $status = "";
                }
                // print_r($arr2);
                $cond1 = "product_line = '$product_line'";
                $cond2 = "customer = '$customer'";
                $cond3 = "source = '$source'";
                $cond4 = "target = '$target'";
                $cond5 = "service = '$service'";
                $cond6 = "task_type = '$task_type'";
                $cond7 = "created_by = '$created_by'";
                $cond8 = "approved = '$status'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['priceList'] = $this->customer_model->getAllPriceList($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['priceList'] = $this->customer_model->getAllPriceListPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->getAllPriceList($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/priceList');
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

                $data['priceList'] = $this->customer_model->getAllPriceListPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/priceList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportPriceList()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=priceList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 18);
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
        if (isset($_REQUEST['status'])) {
            if ($_REQUEST['status'] == 3) {
                $status = 0;
            } else {
                $status = $_REQUEST['status'];
            }
            $data['status'] = $_REQUEST['status'];
            if ($_REQUEST['status'] > 0) {
                array_push($arr2, 7);
            }
        } else {
            $status = "";
        }
        // print_r($arr2);
        $cond1 = "product_line = '$product_line'";
        $cond2 = "customer = '$customer'";
        $cond3 = "source = '$source'";
        $cond4 = "target = '$target'";
        $cond5 = "service = '$service'";
        $cond6 = "task_type = '$task_type'";
        $cond7 = "created_by = '$created_by'";
        $cond8 = "approved = '$status'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);
        $data['priceList'] = $this->customer_model->getAllPriceList($data['permission'], $this->user, $this->brand, $arr4);
        $this->load->view('customer/exportPriceList.php', $data);
    }

    public function addPriceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 27);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 27);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addPriceList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddPriceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 27);
        if ($check) {
            if (isset($_POST['lead']) && isset($_POST['customer']) && isset($_POST['product_line']) && isset($_POST['source']) && isset($_POST['target']) && isset($_POST['service']) && isset($_POST['task_type']) && isset($_POST['subject']) && isset($_POST['unit']) && isset($_POST['rate']) && isset($_POST['currency'])) {
                $data['lead'] = $_POST['lead'];
                $data['customer'] = $_POST['customer'];
                $data['product_line'] = $_POST['product_line'];
                $data['source'] = $_POST['source'];
                $data['target'] = $_POST['target'];
                $data['service'] = $_POST['service'];
                $data['task_type'] = $_POST['task_type'];
                $data['subject'] = $_POST['subject'];
                $data['unit'] = $_POST['unit'];
                $data['rate'] = $_POST['rate'];
                $data['currency'] = $_POST['currency'];
                $data['comment'] = $_POST['comment'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['approved'] = ($this->role == 12 || $this->user == 237) ? 1 : 0;

                if ($this->db->insert('customer_price_list', $data)) {
                    $price_id = $this->db->insert_id();
                    // send email need to approve
                    if ($this->role != 12 && $this->user != 237) {
                        $this->customer_model->sendNewPriceMail($price_id, 1);
                    }
                    //AddFuzzy ...
                    $cols = $_POST['cols'];
                    if ($cols != 0) {
                        $fuzzy['priceList'] = $price_id;
                        for ($i = 1; $i <= $cols + 2; $i++) {
                            $fuzzy['prcnt'] = $_POST['prcnt_' . $i];
                            $fuzzy['value'] = $_POST['value_' . $i];
                            $this->db->insert('customer_fuzzy', $fuzzy);
                        }
                    }

                    $true = "Customer PriceList Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "customer/priceList");
                } else {
                    $error = "Failed To Add Customer PriceList ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer/priceList");
                }
            } else {
                $error = "Failed To Add Customer PriceList, Please check all inputs ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/priceList");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function fuzzyTable()
    {
        $cols = $_POST['cols'];
        if ($cols != 0) {
            $data = ' <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                                            <thead>
                                                <tr>';

            for ($i = 1; $i <= $cols; $i++) {
                $data .= ' <th><input type="text" name="prcnt_' . $i . '" id="prcnt_' . $i . '" required=""></th> ';
            }
            $data .= ' <th><input type="text" value="Repts" name="prcnt_' . $i . '" id="prcnt_' . $i . '" readonly="" required=""></th> ';
            $repts = $i + 1;
            $data .= ' <th><input type="text" value="No match" name="prcnt_' . $repts . '" id="prcnt_' . $repts . '" readonly="" required=""></th> ';
            $data .= ' <th>Min</th> ';
            $data .= '</tr></thead><tbody><tr>';
            for ($i = 1; $i <= $cols + 2; $i++) {
                $data .= '<td><input type="text" onkeypress="return rateCode(event)" onblur="calculateFuzzy(' . $i . ')" name="value_' . $i . '" id="value_' . $i . '" required=""></td>';
            }
            $data .= ' <td></td> ';
            $data .= '</tr></thead><tbody><tr>';
            for ($i = 1; $i <= $cols + 2; $i++) {
                $data .= '<td id="result_' . $i . '"></td>';
            }
            $data .= '<td id="min"></td>';
            $data .= '</tr></tbody></table>';
            echo $data;
        } else {
            echo "";
        }
    }

    public function editPriceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 30);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 30);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['price'] = $this->db->get_where('customer_price_list', array('id' => $data['id']))->row();
            $data['fuzzy'] = $this->db->get_where('customer_fuzzy', array('priceList' => $data['id']));
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editPriceList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditPriceList($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            $referer = $_POST['referer'];
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['product_line'] = $_POST['product_line'];
            $data['source'] = $_POST['source'];
            $data['target'] = $_POST['target'];
            $data['service'] = $_POST['service'];
            $data['task_type'] = $_POST['task_type'];
            $data['subject'] = $_POST['subject'];
            $data['unit'] = $_POST['unit'];
            $data['rate'] = $_POST['rate'];
            $data['currency'] = $_POST['currency'];
            $data['comment'] = $_POST['comment'];
            if ($this->role != 12 && $this->user != 237)
                $data['approved'] = 0;

            $this->admin_model->addToLoggerUpdate('customer_price_list', 28, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('customer_price_list', $data, array('id' => $id))) {
                if ($this->role != 12 && $this->user != 237) {
                    $this->customer_model->sendNewPriceMail($id, 2);
                }
                //EditFuzzy ...
                $this->admin_model->addToLoggerDelete('customer_fuzzy', 28, 'priceList', $id, 1, 0, $this->user);
                $this->db->delete('customer_fuzzy', array('priceList' => $id));
                $cols = $_POST['cols'];
                $fuzzy['priceList'] = $id;
                for ($i = 1; $i <= $cols; $i++) {
                    $fuzzy['prcnt'] = $_POST['prcnt_' . $i];
                    $fuzzy['value'] = $_POST['value_' . $i];
                    $this->db->insert('customer_fuzzy', $fuzzy);
                }

                $true = "Customer PriceList Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/priceList");
                }
            } else {
                $error = "Failed To Edit Customer PriceList ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/priceList");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deletePriceList()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 18);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_price_list', 31, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer_price_list', array('id' => $id))) {
                //EditFuzzy ...
                $this->admin_model->addToLoggerDelete('customer_fuzzy', 31, 'priceList', $id, 1, 0, $this->user);
                $this->db->delete('customer_fuzzy', array('priceList' => $id));
                $true = "Customer PriceList Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Customer PriceList ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addBulkPriceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 32);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 32);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addBulkPriceList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddBulkPriceList()
    {
        //file upload ...
        $config['file']['upload_path']          = './assets/uploads/PriceList/';
        //$config['file']['upload_path'] = '/var/www/html/assets/uploads/priceList/';
        $config['file']['encrypt_name'] = TRUE;
        $config['file']['allowed_types'] = 'xlsx';
        $config['file']['max_size'] = 10000;
        $config['file']['max_width'] = 1024;
        $config['file']['max_height'] = 768;
        $this->load->library('upload', $config['file'], 'file_upload');
        if (!$this->file_upload->do_upload('file')) {
            $error = $this->file_upload->display_errors();
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "customer/priceList");
        } else {
            $data_file = $this->file_upload->data();
            $data['file'] = $data_file['file_name'];
            $file = "assets/uploads/priceList/" . $data['file'];
            $obj = PHPExcel_IOFactory::load($file);
            $sheet = $obj->getSheet(0);
            $lastRow = $sheet->getHighestRow();

            for ($row = 2; $row <= $lastRow; $row++) {
                //PriceList Data ..
                $data['customer'] = trim($sheet->getCell('A' . $row)->getValue());
                $data['lead'] = trim($sheet->getCell('B' . $row)->getValue());
                $data['product_line'] = $this->customer_model->getProductLineID(trim($sheet->getCell('C' . $row)->getValue()), $this->brand);
                $data['currency'] = $this->admin_model->getCurrencyID(trim($sheet->getCell('D' . $row)->getValue()));
                $data['source'] = $this->admin_model->getLanguageID(trim($sheet->getCell('E' . $row)->getValue()));
                $data['target'] = $this->admin_model->getLanguageID(trim($sheet->getCell('F' . $row)->getValue()));
                $data['service'] = $this->admin_model->getServicesID(trim($sheet->getCell('G' . $row)->getValue()));
                $data['task_type'] = $this->admin_model->getTaskTypeID(trim($sheet->getCell('H' . $row)->getValue()));
                $data['subject'] = $this->admin_model->getFieldsID(trim($sheet->getCell('I' . $row)->getValue()));
                $data['unit'] = $this->admin_model->getUnitID(trim($sheet->getCell('J' . $row)->getValue()));
                $data['rate'] = trim($sheet->getCell('K' . $row)->getValue());
                $data['comment'] = trim($sheet->getCell('L' . $row)->getValue());
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['approved'] = $this->role == 12 ? 1 : 0;

                if ($this->db->insert('customer_price_list', $data)) {
                    $price_id = $this->db->insert_id();
                    // send email need to approve
                    if ($this->role != 12) {
                        $this->customer_model->sendNewPriceMail($price_id, 1);
                    }
                    //get Fuzzy ..
                    $fuzzy['priceList'] = $price_id;
                    $lastColumn = $sheet->getHighestColumn();
                    $lastColumn++;
                    $index = 1;
                    for ($column = 'M'; $column != $lastColumn; $column++) {
                        if (trim($sheet->getCell($column . $row)->getValue()) != "" || trim($sheet->getCell($column . $row)->getValue()) != NULL) {
                            if ($index % 2 != 0) {
                                $fuzzy['prcnt'] = trim($sheet->getCell($column . $row)->getValue());
                            } else {
                                $fuzzy['value'] = trim($sheet->getCell($column . $row)->getValue());
                                $this->db->insert('customer_fuzzy', $fuzzy);
                            }
                        }
                        $index++;
                    }
                } else {
                    $error = "Failed To Upload Customer PriceList ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer/priceList");
                }
            }
            $true = "Customer PriceList Uploaded Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "customer/priceList");
        }
    }

    public function customerBranch()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 45);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $region = "";
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
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $created_by = "";
                }
                $idsArray = array();
                $leadIds = "";
                if (isset($_REQUEST['assigned_to'])) {
                    $data['assigned_to'] = $assigned_to = $_REQUEST['assigned_to'];
                    if (!empty($assigned_to)) {
                        array_push($arr2, 4);
                        $data['assigned_to'] = $assigned_to;
                        $ids = $this->db->select('lead')->get_where('customer_sam', array('sam' => $assigned_to))->result();
                        if (!empty($ids)) {
                            foreach ($ids as $val)
                                array_push($idsArray, $val->lead);
                            $leadIds = implode(" , ", $idsArray);
                        } else {
                            $leadIds = "0";
                        }
                    }
                }
                // print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "region = '$region'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond4 = "created_by = '$created_by'";
                $cond5 = "id IN ($leadIds)";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['branch'] = $this->customer_model->allCustomerBranches($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['branch'] = $this->customer_model->allCustomerBranchesPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['branch']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->allCustomerBranches($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/customerBranch');
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



                $data['branch'] = $this->customer_model->allCustomerBranchesPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // $data['branch'] = $this->customer_model->allCustomerbranches($data['permission'],$this->user,$this->brand);
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/branches.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportbranches()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CustomerBranches.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 45);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 0);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 1);
                }
            } else {
                $region = "";
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
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 3);
                }
            } else {
                $created_by = "";
            }
            $idsArray = array();
            $leadIds = "";
            if (isset($_REQUEST['assigned_to'])) {
                $assigned_to = $_REQUEST['assigned_to'];
                if (!empty($assigned_to)) {
                    array_push($arr2, 4);
                    $data['assigned_to'] = $assigned_to;
                    $ids = $this->db->select('lead')->get_where('customer_sam', array('sam' => $assigned_to))->result();
                    if (!empty($ids)) {
                        foreach ($ids as $val)
                            array_push($idsArray, $val->lead);
                        $leadIds = implode(" , ", $idsArray);
                    } else {
                        $leadIds = "0";
                    }
                }
            }
            // print_r($arr2);
            $cond1 = "customer = '$customer'";
            $cond2 = "region = '$region'";
            $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond4 = "created_by = '$created_by'";
            $cond5 = "id IN ($leadIds)";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['branch'] = $this->customer_model->allCustomerBranches($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['branch'] = $this->customer_model->allCustomerBranches($data['permission'], $this->user, $this->brand, 1);
            }

            //Pages ..

            $this->load->view('customer/exportbranches.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function editBranch()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 47);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['branch'] = $this->db->get_where('customer_leads', array('id' => $id))->row();
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            // $data['activityComment'] = $this->db->query(" SELECT s.id,s.lead,s.created_by,(SELECT COUNT(*) FROM `customer_activity_comment` WHERE activity = s.id AND lead = '$id') AS total FROM sales_activity AS s HAVING total > 0 ");
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editBranch.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addBranch()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 46);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addBranch.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddBranch()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
        if ($permission->add == 1) {
            $data['customer'] = $_POST['customer'];
            $data['region'] = $_POST['region'];
            $data['country'] = $_POST['country'];
            $data['type'] = $_POST['type'];
            $data['source'] = $_POST['source'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['approved'] = "1";

            if ($this->db->insert('customer_leads', $data)) {
                $id = $this->db->insert_id();
                $sam['lead'] = $id;
                $sam['sam'] = $data['created_by'];
                $sam['customer'] = $data['customer'];
                if (!$this->db->insert('customer_sam', $sam)) {
                    $this->db->delete('customer_leads', array('id' => $id));
                    $error = "Failed To Add Customer Branch ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer/customerBranch");
                }

                $true = "Customer Branch Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/customerBranch");
            } else {
                $error = "Failed To Add Customer Branch ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/customerBranch");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditBranch($id)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
        if ($permission->edit == 1) {
            $referer = $_POST['referer'];
            $data['customer'] = $_POST['customer'];
            $data['region'] = $_POST['region'];
            $data['country'] = $_POST['country'];
            $data['type'] = $_POST['type'];
            $data['source'] = $_POST['source'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('customer_leads', 46, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('customer_leads', $data, array('id' => $id))) {
                $true = "Customer Branch Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/customerBranch");
                }
            } else {
                $error = "Failed To edit Customer Branch ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/customerBranch");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCustomerBranch()
    {
        // Check Permission ..
        $id = base64_decode($_GET['t']);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 45);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('customer_leads', 48, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer_leads', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('customer_sam', 48, 'lead', $id, 1, $id, $this->user);
                $this->db->delete('customer_sam', array('lead' => $id));
                // $this->db->delete('customer_contacts',array('lead' => $id));
                $true = "Branch Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Branch ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getTaskType()
    {
        $service = $_POST['service'];
        $data = "<option disabled='disabled' value='' selected=''>-- Select Task Type --</option>";
        $data .= $this->admin_model->selectTaskType(0, $service);
        echo $data;
    }


    public function pmCustomer()
    {
        ini_set('memory_limit', '-1');
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 58);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 58);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $region = "";
                }

                // print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "region = '$region'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['branch'] = $this->customer_model->allCustomerPM($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['branch'] = $this->customer_model->allCustomerPmPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['branch']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->allCustomerPM($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/pmCustomer');
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

                $data['branch'] = $this->customer_model->allCustomerPmPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'],$this->user,$this->brand,1);
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('customer/pmCustomerManagement.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportPmCustomer()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Customer PM Management.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 58);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 58);
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 0);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 1);
                }
            } else {
                $region = "";
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
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 3);
                }
            } else {
                $created_by = "";
            }
            // print_r($arr2);
            $cond1 = "customer = '$customer'";
            $cond2 = "region = '$region'";
            $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
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
                $data['branch'] = $this->customer_model->allCustomerPm($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['branch'] = $this->customer_model->allCustomerPmPages($data['permission'], $this->user, $this->brand, 9, 0);
            }

            //Pages ..

            $this->load->view('customer/exportPmCustomer.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function assignPmCustomer()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 58);
        if ($permission->follow == 2) {
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['pm'] = $_POST['pm'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('customer_pm', $data)) {
                $true = "PM Assigned Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Assign PM ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getAssignedPM()
    {
        $lead = $_POST['lead'];
        echo $this->customer_model->getAssignedPM($lead);
    }

    public function deletePmCustomer()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 58);
        if ($permission->follow == 2) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_pm', 58, 'id', $id, 0, $id, $this->user);
            if ($this->db->delete('customer_pm', array('id' => $id))) {
                $true = "Pm Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Pm ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function productLines()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 59);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
            //body ..
            /*hagar */
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['Product_Line_name'])) {
                    $ProductLineName = $_REQUEST['Product_Line_name'];
                    if (!empty($ProductLineName)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $ProductLineName = "";
                }
                // print_r($arr2);
                $cond1 = "name = '$ProductLineName'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['productLines'] = $this->customer_model->allProductLines($data['permission'], $this->user, $this->brand, $arr4);
                    //print_r($data['productLines']->result());
                } else {
                    $data['productLines'] = $this->customer_model->allProductLinesPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['productLines']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->allProductLines($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/productLines');
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

                $data['productLines'] = $this->customer_model->allProductLinesPages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }

            //////////
            // $data['productLines'] = $this->customer_model->allProductLines($this->user,$this->brand,1);
            $data['user'] = $this->user;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/productLines.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    ////export product line 
    public function exportProductLine()
    {


        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Prouduct line.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 59);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] =
                /*hagar */
                $arr2 = array();
            if (isset($_REQUEST['Product_Line_name'])) {
                $ProductLineName = $_REQUEST['Product_Line_name'];
                if (!empty($ProductLineName)) {
                    array_push($arr2, 0);
                }
            } else {
                $ProductLineName = "";
            }
            // print_r($arr2);
            $cond1 = "name = '$ProductLineName'";
            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['productLines'] = $this->customer_model->allProductLines($data['permission'], $this->user, $this->brand, $arr4);
                //print_r($data['productLines']->result());
            } else {
                $data['productLines'] = $this->customer_model->allProductLinesPages($data['permission'], $this->user, $this->brand, 9, 0);
            }
            $this->load->view('customer/exportProductLineExl.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addProductLine()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addProductLines.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddProductLine()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('customer_product_line', $data)) {
                $true = "Product Line Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/productLines");
            } else {
                $error = "Failed To Add Product Line ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/productLines");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editProductLine()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('customer_product_line', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editProductLine.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditProductLine()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
        if ($permission->edit == 1) {
            $id = base64_decode($_GET['id']);
            $data['name'] = $_POST['name'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $referer = $_POST['referer'];
            $this->admin_model->addToLoggerUpdate('customer_product_line', 61, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('customer_product_line', $data, array('id' => $id))) {
                $true = "Product Line Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."customer/productLines");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/productLines");
                }
            } else {
                $error = "Failed To Edit Product Line ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."customer/productLines");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "customer/productLines");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteProductLine()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 59);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_product_line', 62, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('customer_product_line', array('id' => $id))) {
                $true = "Product Line Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                // redirect(base_url()."customer/productLines");
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Product Line ...";
                $this->session->set_flashdata('error', $error);
                // redirect(base_url()."customer/productLines");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getProductLineByCustomer()
    {
        $lead = $_POST['lead'];
        $lines = $this->db->query(" SELECT DISTINCT(product_line),(SELECT brand FROM `customer` WHERE id = p.customer) AS brand FROM `customer_price_list` AS p WHERE p.lead = '$lead' Having brand = '$this->brand' ")->result();
        $data = "<option disabled='disabled' value='' selected='selected'>-- Select Product Line --</option>";
        foreach ($lines as $lines) {
            $data .= "<option value='" . $lines->product_line . "'>" . $this->customer_model->getProductLine($lines->product_line) . "</option>";
        }

        echo $data;
    }

    public function exportAllBranches()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=SamCustomers.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['row'] = $this->db->query(" SELECT l.*,c.status AS customer_status,c.brand FROM `customer_leads` AS l LEFT OUTER JOIN customer AS c ON c.id = l.customer WHERE brand = '1'  ")->result();
        $this->load->view('customer/exportAllBranches.php', $data);
    }

    public function exportCustomerContacts()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=customerContacts.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        //$data['row'] = $this->db->query(" SELECT l.*,c.name,c.phone,c.email,c.skype_account,c.job_title,c.location,(SELECT count(*) FROM `customer_sam` WHERE sam = '8' AND lead = l.id ) AS total FROM `customer_leads` AS l LEFT OUTER JOIN customer_contacts AS c ON c.lead = l.id HAVING total >= '1' ")->result();
        $data['row'] = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE l.customer = customer.id AND status = '1') AS brand,c.name,c.phone,c.email,c.skype_account,c.job_title,c.location FROM `customer_leads` AS l LEFT OUTER JOIN customer_contacts AS c ON c.lead = l.id HAVING brand = '5'  ")->result();
        $this->load->view('customer/exportCustomerContacts.php', $data);
    }

    public function chatRoom()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 99);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 99);
            //body ..
            $data['customer'] = $this->customer_model->AllChatRooms($data['permission'], $this->user, $this->brand);
            $data['user'] = $this->user;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('customer/chatRoom.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function chat()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 99);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 99);
            //body ..
            $data['roomId'] = base64_decode($_GET['t']);
            $data['message'] = $this->customer_model->ChatMessages($data['roomId']);
            $data['roomData'] = $this->db->get_where('website_chat', array('id' => $data['roomId']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('customer/chat.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getAllRoomMassages()
    {
        if (isset($_POST['room'])) {
            $room = $_POST['room'];
            $messages = $this->customer_model->ChatMessages($room);
            $roomData = $this->db->get_where('website_chat', array('id' => $room))->row();
            $data = "";
            foreach ($messages->result() as $message) {
                if ($message->user_type == 1) {
                    $data .= '
                    <tr class="">
                    <td>' . $this->admin_model->getAdmin($message->created_by) . '</td>
                    <td></td>
                    <td>' . $message->message . '</td>
                    <td>' . $message->created_at . '</td>
                    </tr>';
                } else if ($message->user_type == 2) {
                    $data .= '<tr class="">
                                    <td>' . $roomData->name . '</td>
                                    <td>' . $roomData->email . '</td>
                                    <td>' . $message->message . '</td>
                                    <td>' . $message->created_at . '</td>
                                </tr>';
                }
            }

            echo $data;
        } else {
            echo "";
        }
    }

    public function sendNewMessage()
    {
        if (isset($_POST['room']) && isset($_POST['message'])) {
            $data['room'] = $_POST['room'];
            $data['message'] = $_POST['message'];
            $data['user_type'] = 1;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('website_chat_room', $data)) {
                echo 1;
            }
        } else {
            echo "0";
        }
    }

    public function closeRoom()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 99);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 99);
            //body ..
            $roomId = base64_decode($_GET['t']);
            $dataDB['closed'] = 1;
            if ($this->db->update('website_chat', $dataDB, array('id' => $roomId))) {
                $true = "Chat Room Closed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "customer/chatRoom");
            } else {
                $error = "Failed To Close, Please Try Again ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/chatRoom");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportCustomersListAssigned()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=exportCustomersListAssigned.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $row = $this->db->query("SELECT name,status,(SELECT count(*) FROM `customer_sam` WHERE sam = '10' AND customer = customer.id ) AS total FROM `customer` HAVING total > 0")->result();

        $data = '<!DOCTYPE ><html dir=rtl>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
</style>
</head>
<body>
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
        <tr>

            <th>Client Name</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>';
        foreach ($row as $row) {
            $data .= '<tr class="gradeX">
            <td>' . $row->name . '</td>
            <td>';
            if ($row->status == 1) {
                $data .= "Lead";
            } elseif ($row->status == 2) {
                $data .= "Existing";
            }
            $data .= '</td></tr>';
        }
        $data .= '</tbody>
            </table>
            </body>
            </html>';
        echo $data;
    }

    // Existing Customers Before 01-01-2019 ..
    public function exportExistingCustomers()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=exportCustomersListAssigned.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $row = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,s.rolled_in,s.created_at FROM customer AS c LEFT OUTER JOIN sales_activity AS s ON s.customer = c.id AND s.rolled_in = '1' WHERE c.brand = '1' AND c.status = '2' AND (s.created_at < '2019-01-01' OR s.created_by IS NULL) ORDER BY `c`.`id` ASC  ")->result();

        $data = '<!DOCTYPE ><html>
    <head>
<style>
@media print {
table {font-size: smaller; }
thead {display: table-header-group; }
table { page-break-inside:auto; width:75%; }
tr { page-break-inside:avoid; page-break-after:auto; }
}
table {
  border: 1px solid black;
  font-size:18px;
}
table td {
  border: 1px solid black;
}
table th {
  border: 1px solid black;
}
.clr{
  background-color: #EEEEEE;
  text-align: center;
}
.clr1 {
background-color: #FFFFCC;
  text-align: center;
}
</style>
</head>
<body>
<table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
    <thead>
        <tr>

            <th>Client Name</th>
            <th>Rolled In Date</th>
        </tr>
    </thead>
    <tbody>';
        foreach ($row as $row) {
            $data .= '<tr class="gradeX">
            <td>' . $row->name . '</td>
            <td>' . $row->created_at . '</td>
            ';
        }
        $data .= '</tbody>
            </table>
            </body>
            </html>';
        echo $data;
    }

    /////////report mona
    public function viewReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=customers.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 19);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 19);
            //body ..
            $data['user'] = $this->user;
            $data['row'] = $this->db->query("SELECT *,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = c.lead)AS total FROM customer_sam AS c WHERE c.sam = '14' OR c.sam = '73' HAVING total > 1 ORDER BY `total` DESC")->result();

            //Pages ..
            $this->load->view('customer/viewReport.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }
    //////////
    //

    public function customerPortal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 156);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 156);
            //body ..
            $data['role'] = $this->role;
            $data['id'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['customer'] = $this->db->get_where('customer', array('id' => $data['id']))->row();
            $data['contacts'] = $this->customer_model->customerPortal($data['permission'], $this->user, $data['id']);

            // var_dump($data['contacts']->result());
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/customerPortal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCustomerPortal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 156);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 156);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['role'] = $this->role;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addCustomerPortal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCustomerPortal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 156);
        if ($check) {
            $data['customer'] = base64_decode($_GET['t']);
            $data['link'] = $_POST['link'];

            $data['username'] = $_POST['username'];
            $data['password'] = $_POST['password'];
            $data['portal'] = $_POST['portal'];
            $data['additional_info'] = $_POST['additional_info'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['notes'] = $_POST['notes'] ?? '';
            if (!($data['link'] == '' && $data['username'] == '' && $data['password'] == '' && $data['portal'] == '' && $data['additional_info'] == '' && $data['notes'] == '' && $_FILES['customer_profile']['size'] == 0)) {
                if ($_FILES['customer_profile']['size'] != 0) {
                    if (!is_dir('./assets/uploads/customer_profiles/')) {
                        mkdir('./assets/uploads/customer_profiles/', 0777, TRUE);
                    }
                    $config['file']['upload_path'] = './assets/uploads/customer_profiles/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 5000000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('customer_profile')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        echo "error";
                        return;
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['customer_profile'] = $data_file['file_name'];
                    }
                }
                if ($this->db->insert('customer_portal', $data)) {
                    $true = "Customer Portal Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    echo "success";
                } else {
                    $error = "Failed To Add Customer Portal ...";
                    $this->session->set_flashdata('error', $error);
                    echo "error";
                }
            } else {
                echo "success";
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCustomerPortal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 156);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 156);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['contact'] = $this->db->get_where('customer_portal', array('id' => $data['id']))->row();
            $data['role'] = $this->role;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/editCustomerPortal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCustomerPortal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 156);
        if ($check) {
            $id = base64_decode($_POST['id']);

            $data['link'] = $_POST['link'];
            $data['username'] = $_POST['username'];
            $data['password'] = $_POST['password'];
            $data['portal'] = $_POST['portal'];
            $data['additional_info'] = $_POST['additional_info'];
            $data['notes'] = $_POST['notes'] ?? Null;
            // $customer = $_POST['customer'];
            $fileToatt = $_POST['fileToDelete'];
            if (!($data['link'] == '' && $data['username'] == '' && $data['password'] == '' && $data['portal'] == '' && $data['additional_info'] == '' && $data['notes'] == '' && $_FILES['customer_profile']['size'] == 0)) {

                $this->admin_model->addToLoggerUpdate('customer_portal', 156, 'id', $id, 0, 0, $this->user);
                if ($_FILES['customer_profile']['size'] != 0) {
                    if ($_FILES['customer_profile']['name'] != $fileToatt) {

                        if (!is_dir('./assets/uploads/customer_profiles/')) {
                            mkdir('./assets/uploads/customer_profiles/', 0777, TRUE);
                        }
                        $config['file']['upload_path'] = './assets/uploads/customer_profiles/';
                        $config['file']['encrypt_name'] = TRUE;
                        $config['file']['allowed_types'] = 'zip|rar';
                        $config['file']['max_size'] = 5000000;
                        $this->load->library('upload', $config['file'], 'file_upload');
                        if (!$this->file_upload->do_upload('customer_profile')) {
                            $error = $this->file_upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            echo "error";
                            return;
                        } else {
                            $data_file = $this->file_upload->data();
                            $data['customer_profile'] = $data_file['file_name'];
                        }
                    }
                }
                if ($this->db->update('customer_portal', $data, array('id' => $id))) {
                    if ($this->db->affected_rows() >= 0) {
                        $this->customer_model->addLastUpdated('customer_portal', $id);
                        $true = "Customer Portal Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        echo "success";
                    } else {
                        $error = "Failed To Add Customer Portal ...";
                        $this->session->set_flashdata('error', $error);
                        echo "error";
                    }
                } else {
                    $error = "Failed To Add Customer Portal ...";
                    $this->session->set_flashdata('error', $error);
                    echo "error";
                }
            } else {
                $this->admin_model->addToLoggerDelete('customer_portal', 156, 'id', $id, 0, $id, $this->user);
                $this->db->delete('customer_portal', array('id' => $id));
                echo "success";
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCustomerPortal()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 156);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('customer_portal', 156, 'id', $id, 0, $id, $this->user);
            if ($this->db->delete('customer_portal', array('id' => $id))) {
                $true = "Customer Portal Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Customer Portal ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportCustomerEmail()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CustomerEmail.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['row'] = $this->db->query(" SELECT * from customer_email")->result();
        $this->load->view('customer/exportCustomerEmail.php', $data);
    }

    public function ExportCustomerReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CustomerReport.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['row'] = $this->db->query(" SELECT c.name,c.website,l.id FROM customer AS c LEFT OUTER JOIN customer_leads AS l ON l.customer=c.id WHERE l.region = '1' AND c.brand = '1' ")->result();
        $this->load->view('customer/ExportCustomerReport.php', $data);
    }

    public function ExportCustomerTotalRevenue()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Customer2019.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['row'] = $this->db->query(" SELECT c.name,c.website,l.id FROM customer AS c LEFT OUTER JOIN customer_leads AS l ON l.customer=c.id WHERE l.region = '1' AND c.brand = '1' ")->result();
        $this->load->view('customer/ExportCustomerTotalRevenue.php', $data);
    }

    public function searchLeadsAjax()
    {
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        //body ..

        $arr2 = array();
        $idsArray = array();
        $leadIds = "";
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 0);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['region'])) {
            $region = $_REQUEST['region'];
            if (!empty($region)) {
                array_push($arr2, 1);
            }
        } else {
            $region = "";
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

        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 3);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['assigned_to'])) {
            $data['assigned_to'] = $assigned_to = $_REQUEST['assigned_to'];
            if (!empty($assigned_to)) {
                array_push($arr2, 4);
                $data['assigned_to'] = $assigned_to;
                $ids = $this->db->select('lead')->get_where('customer_sam', array('sam' => $assigned_to))->result();
                if (!empty($ids)) {
                    foreach ($ids as $val)
                        array_push($idsArray, $val->lead);
                    $leadIds = implode(" , ", $idsArray);
                } else {
                    $leadIds = "0";
                }
            }
        }
        // print_r($arr2);
        $cond1 = "customer = '$customer'";
        $cond2 = "region = '$region'";
        $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
        $cond4 = "created_by = '$created_by'";
        $cond5 = "id IN ($leadIds)";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['leads'] = $this->customer_model->allCustomerLeads($data['permission'], $this->user, $this->brand, $arr4);
        } else {
            $data['leads'] = $this->customer_model->allCustomerLeadsPages($data['permission'], $this->user, $this->brand, 9, 0);
        }
        $data['total_rows'] = $data['leads']->num_rows();

        $data['user'] = $this->user;
        $data['brand'] = $this->brand;

        //Pages ..

        return $this->load->view('customer_new/search_leads.php', $data);
    }

    public function addCustomerData()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 11);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 11);
            $data['permission2'] = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/addCustomerNew.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCustomerData()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 11);
        if ($check) {
            // print_r($_POST);exit();
            $data['name'] = $_POST['name'];
            $data['website'] = $_POST['website'];
            $data['client_type'] = $_POST['client_type'];

            $data['status'] = '1';
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            $websiteCheck = $this->db->get_where('customer', array('website' => $data['website'], 'brand' => $this->brand))->num_rows();
            if ($websiteCheck > 0) {
                $error = "Failed : There's another customer with the same website ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer");
            } else {


                if ($this->db->insert('customer', $data)) {
                    // after add customer add lead 
                    $customer_id = $this->db->insert_id();
                    foreach ($_POST['region'] as $k => $val) {
                        $leadData['customer'] = $customer_id;
                        $leadData['region'] = $_POST['region'][$k];
                        $leadData['country'] = $_POST['country'][$k];
                        $leadData['type'] = $_POST['type'][$k];
                        $leadData['source'] = $_POST['source'][$k];
                        $leadData['comment'] = $_POST['comment'][$k];
                        $leadData['created_by'] = $this->user;
                        $leadData['created_at'] = date("Y-m-d H:i:s");
                        $leadData['approved'] = "1";
                        $leadData['status'] = $_POST['status'][$k] ?? 0;

                        if ($this->db->insert('customer_leads', $leadData)) {
                            $lead_id = $this->db->insert_id();
                            $sam['lead'] = $lead_id;
                            $sam['sam'] = $data['created_by'];
                            $sam['customer'] = $leadData['customer'];
                            if (!$this->db->insert('customer_sam', $sam)) {
                                $this->db->delete('customer_leads', array('id' => $lead_id));
                                $error = "Failed To Add Customer Lead ...";
                                $this->session->set_flashdata('error', $error);
                                redirect(base_url() . "customer/leads");
                            }
                            // start lead contacts
                            foreach ($_POST["contactName_$k"] as $x => $cont) {
                                $contactData['lead'] = $lead_id;
                                $contactData['name'] = $_POST["contactName_$k"][$x];
                                $contactData['phone'] = $_POST["contactPhone_$k"][$x];
                                $contactData['email'] = $_POST["contactEmail_$k"][$x];
                                $contactData['skype_account'] = $_POST["contactSkype_$k"][$x];
                                $contactData['job_title'] = $_POST["contactJob_$k"][$x];
                                $contactData['location'] = $_POST["contactLocation_$k"][$x];
                                $contactData['comment'] = $_POST["contactComment_$k"][$x];
                                $contactData['created_by'] = $this->user;
                                $contactData['created_at'] = date("Y-m-d H:i:s");

                                if ($this->db->insert('customer_contacts', $contactData)) {
                                } else {
                                    $t = base64_encode($lead_id);
                                    $error = "Failed To Add Customer Contacts ...";
                                    $this->session->set_flashdata('error', $error);
                                    redirect(base_url() . "customer/leadContacts?t=" . $t);
                                }
                            }
                            // end lead contacts

                        } else {
                            $error = "Failed To Add Customer Lead ...";
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "customer/leads");
                        }
                    }
                    // end add lead
                    $true = "Customer Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "customer");
                } else {
                    $error = "Failed To Add Customer ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // for waiting approve price list
    public function priceListApproval()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 211);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 18);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
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
                    $data['priceList'] = $this->customer_model->getAllPriceListWaitingApproval($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['priceList'] = $this->customer_model->getAllPriceListWaitingApprovalPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->customer_model->getAllPriceListWaitingApproval($data['permission'], $this->user, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('customer/priceListApproval');
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

                $data['priceList'] = $this->customer_model->getAllPriceListWaitingApprovalPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/priceListApproval.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewPriceList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 211);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 30);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['price'] = $this->db->get_where('customer_price_list', array('id' => $data['id']))->row();
            $data['fuzzy'] = $this->db->get_where('customer_fuzzy', array('priceList' => $data['id']));
            $data['leadData'] = $this->db->get_where('customer_leads', array('id' => $data['price']->lead))->row();
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('customer_new/viewPriceList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function approvePriceList()
    {
        $check = $this->admin_model->checkPermission($this->role, 211);
        if ($check && $this->role == 12) {
            // if($check ){ 
            $id = base64_decode($_GET['t']);
            $row = $this->db->get_where('customer_price_list', array('id' => $id))->row();
            if ($row->approved == 0) {
                $data['approved_by'] = $this->user;
                $data['approved_at'] = date("Y-m-d H:i:s");
                $data['approved_comment'] = '';
                $data['approved'] = 1;
                if ($this->db->update('customer_price_list', $data, array('id' => $id))) {
                    $this->customer_model->sendApprovalPriceMail($id, 1);
                    $true = "Price List Approved Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "customer/priceListApproval");
                } else {
                    $error = "Failed To Approve Price List ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "customer/priceListApproval");
                }
            } else {
                if ($row->approved == 1)
                    $error = "Already Approved , Please Check...";
                elseif ($row->approved == 2)
                    $error = "Already Rejected , Please Check...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/priceListApproval");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doApprovePriceList($id)
    {
        $check = $this->admin_model->checkPermission($this->role, 211);
        if ($check && $this->role == 12) {
            // if($check ){ 
            $row = $this->db->get_where('customer_price_list', array('id' => $id))->row();
            if ($row->approved == 0) {
                $data['approved_by'] = $this->user;
                $data['approved_at'] = date("Y-m-d H:i:s");
                $data['approved_comment'] = $_POST['approve_comment'];
                if (isset($_POST['submit'])) {
                    $data['approved'] = 1;
                    if ($this->db->update('customer_price_list', $data, array('id' => $id))) {
                        $this->customer_model->sendApprovalPriceMail($id, 1);
                        $true = "Price List Approved Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "customer/priceListApproval");
                    } else {
                        $error = "Failed To Approve Price List ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "customer/priceListApproval");
                    }
                } elseif (isset($_POST['reject'])) {
                    $data['approved'] = 2;
                    if ($this->db->update('customer_price_list', $data, array('id' => $id))) {
                        $this->customer_model->sendApprovalPriceMail($id, 2);
                        $true = "Price List Rejected Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "customer/priceListApproval");
                    } else {
                        $error = "Failed To Reject Price List ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "customer/priceListApproval");
                    }
                }
            } else {
                if ($row->approved == 1)
                    $error = "Already Approved , Please Check...";
                elseif ($row->approved == 2)
                    $error = "Already Rejected , Please Check...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "customer/priceListApproval");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    function fileToDelete()
    {
        $id = base64_decode($_POST['id']);
        $file_name = './assets/uploads/customer_profiles/' . $_POST['file_toDelete'];
        $data['customer_profile'] = "";
        if ($this->db->update('customer_portal', $data, array('id' => $id))) {
            if (unlink($file_name)) {
                $this->customer_model->addLastUpdated('customer_portal', $id);
                echo "success";
                return;
            } else {
                echo "error";
                return;
            }
        } else {
            echo "error";
            return;
        }
    }
}
