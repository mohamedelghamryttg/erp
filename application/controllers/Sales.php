<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->brand = $this->session->userdata('brand');
        $this->user = $this->session->userdata('id');
    }
    public function salesActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 23);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 23);
            //body ..
            $data['user'] = $this->user;

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
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 2);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $id = "";
                }

                $cond1 = "customer = '$customer'";
                $cond2 = "created_by = '$created_by'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to'";
                $cond4 = "id = '$id'";
                // $cond5 = "c.region = '$region'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['sales'] = $this->sales_model->AllActivities($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['sales'] = $this->sales_model->AllActivitiesPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->sales_model->AllActivities($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('sales/salesActivity');
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

                $data['sales'] = $this->sales_model->AllActivitiesPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/salesActivity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportActivities()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Activities.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 23);
        //body ..
        $data['user'] = $this->user;

        $arr2 = array();
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 0);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 1);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 2);
            }
        } else {
            $date_from = "";
            $date_to = "";
        }
        // print_r($arr2);
        $cond1 = "customer = '$customer'";
        $cond2 = "created_by = '$created_by'";
        $cond3 = "created_at BETWEEN '$date_from' AND '$date_to'";
        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['sales'] = $this->sales_model->AllActivities($data['permission'], $this->user, $this->brand, $arr4);
        } else {
            $data['sales'] = $this->sales_model->AllActivities($data['permission'], $this->user, $this->brand, 9, 0);
        }

        $this->load->view('sales/exportAllActivities.php', $data);

    }

    public function addSalesActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 24);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 24);
            //body ..
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/addSalesActivity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editSalesActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 33);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 33);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_activity', array('id' => $data['id']))->row();
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            $data['comments'] = $this->db->get_where('customer_activity_comment', array('activity' => $data['id']))->result();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/editSalesActivity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 24);
        if ($check) {
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            if (!isset($_POST['contact_id'])) {
                $error = "Please ADD Customer Contact Data ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/salesActivity");
            }
            $data['status'] = $_POST['status'];
            if (isset($_POST['rolled_in'])) {
                $data['rolled_in'] = $_POST['rolled_in'];
                if ($data['rolled_in'] == 1) {
                    $customer['payment'] = $_POST['payment'];
                    $data['pm'] = $_POST['pm'];
                    $customer['status'] = '2';
                    $this->db->update('customer', $customer, array('id' => $data['customer']));
                    $pm['pm'] = $_POST['pm'];
                    $pm['lead'] = $data['lead'];
                    $pm['customer'] = $data['customer'];
                    $pm['created_by'] = $this->user;
                    $pm['created_at'] = date("Y-m-d H:i:s");
                    $this->db->insert('customer_pm', $pm);
                    $this->sales_model->sendAliasMail($data['lead'], $pm['pm'], $this->user);
                }
            }
            $data['feedback'] = $_POST['feedback'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('sales_activity', $data)) {
                if (strlen(trim($data['comment'])) > 0) {
                    //Lead Comment ..
                    $marketing['activity'] = $this->db->insert_id();
                    $marketing['lead'] = $data['lead'];
                    $marketing['comment'] = $data['comment'];
                    $marketing['team'] = 3;
                    $marketing['created_by'] = $data['created_by'];
                    $marketing['created_at'] = $data['created_at'];
                    $this->db->insert('customer_activity_comment', $marketing);
                    $this->sales_model->sendActivityCommentMail($marketing, $this->user, $this->brand);
                }
                $true = "Activity Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/salesActivity");
            } else {
                $error = "Failed To Add Activity ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/salesActivity");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 33);
        if ($check) {
            $referer = $_POST['referer'];
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['status'] = $_POST['status'];
            $data['feedback'] = $_POST['feedback'];
            $data['comment'] = $_POST['comment'];
            $id = base64_decode($_POST['id']);
            $this->admin_model->addToLoggerUpdate('sales_activity', 33, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('sales_activity', $data, array('id' => $id))) {
                $true = "Activity Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."sales/salesActivity");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/salesActivity");
                }
            } else {
                $error = "Failed To Edit Activity ...";
                $this->session->set_flashdata('error', $error);
                // redirect(base_url()."sales/salesActivity");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/salesActivity");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addSalesComment()
    {
        $marketing['activity'] = $_POST['activity'];
        $marketing['lead'] = $_POST['lead'];
        $marketing['comment'] = $_POST['comment'];
        $marketing['team'] = 3;
        $marketing['created_by'] = $this->user;
        $marketing['created_at'] = date("Y-m-d H:i:s");
        if ($this->db->insert('customer_activity_comment', $marketing)) {
            echo "Your Message Sent Successfully ...";
        } else {
            echo "Failed to Send, Please try Again!";
        }
    }

    public function deleteSalesActivity()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 23);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('sales_activity', 34, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('sales_activity', array('id' => $id))) {
                $true = "Activity Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Activity ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function leadData()
    {
        ini_set('memory_limit', '-1');
        $customer = $_POST['customer'];
        $sam = $this->user;
        if ($this->role == 21 || $this->role == 12) {
            $row = $this->db->query("SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        } else {
            $row = $this->db->query("SELECT c.* FROM `customer_leads` AS c LEFT OUTER JOIN customer_sam AS cs ON c.id = cs.lead WHERE c.customer='$customer' AND cs.sam = '$sam'")->result();

        }
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($row as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" value="' . $row->id . '" ' . $radio . '></td>
                        <input type="text" name="lead_status" id="lead_status" value="' . $this->customer_model->customerLeadStatus($customer) . '" hidden="" required="">
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function leadDataPm()
    {
        $customer = $_POST['customer'];
        $pm = $this->user;
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($row as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" onclick="getProductLineByLead()" value="' . $row->id . '" ' . $radio . '></td>
                        <input type="text" name="lead_status" id="lead_status" value="' . $this->customer_model->customerLeadStatus($customer) . '" hidden="" required="">
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function leadDataAccounting()
    {
        $customer = $_POST['customer'];
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($row as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" onclick="getVirifiedPoByCustomer();clearPaymentData();" value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function leadDataPayment()
    {
        $customer = $_POST['customer'];
        echo $this->customer_model->leadDataPayment(0, $customer);
    }

    public function customerContact()
    {

        if (isset($_POST['lead'])) {
            $lead = $_POST['lead'];
            $result = $this->db->get_where('customer_contacts', array('lead' => $lead))->result();
            $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <th>Choose</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Skype Account</th>
                            </tr>
                        </thead>
            
                        <tbody>';
            $x = 1;
            foreach ($result as $row) {
                if ($x == 1) {
                    $radio = "required";
                } else {
                    $radio = "";
                }
                $data .= '<tr class="">
                                <td><input type="radio" name="contact_id" value="' . $row->id . '" ' . $radio . '></td>
                                <td>' . $row->name . '</td>
                                <td>' . $row->email . '</td>
                                <td>' . $row->phone . '</td>
                                <td>' . $row->job_title . '</td>
                                <td>' . $row->location . '</td>
                                <td>' . $row->skype_account . '</td>
                            </tr>';
                $x++;
            }
            $data .= '</tbody></table>';
            echo $data;
        } else {
            echo "<p style='color: red;'>Please Choose Customer First ...</p>";
        }
    }

    public function followUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 25);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 25);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['user'] = $this->user;
            $data['follow'] = $this->sales_model->getAllFollowUp($data['permission'], $this->user, $data['id']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/followUp.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addFollowUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 26);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 26);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/addFollowUp.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddFollowUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 26);
        if ($check) {
            $data['sales'] = $_POST['id'];
            $data['follow_up'] = $_POST['follow_up'];
            $data['call_status'] = $_POST['call_status'];
            $data['new_hitting'] = $_POST['new_hitting'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('sales_follow_up', $data)) {
                $true = "Follow up Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($data['sales']));
            } else {
                $error = "Failed To Add Follow up ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($data['sales']));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editFollowUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 43);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 43);
            //body ..
            $data['sales'] = base64_decode($_GET['t']);
            $id = base64_decode($_GET['row']);
            $data['row'] = $this->db->get_where('sales_follow_up', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/editFollowUp.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditFollowUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 43);
        if ($check) {
            $sales = $_POST['sales'];
            $id = $_POST['id'];
            $data['follow_up'] = $_POST['follow_up'];
            $data['call_status'] = $_POST['call_status'];
            $data['new_hitting'] = $_POST['new_hitting'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('sales_follow_up', 43, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('sales_follow_up', $data, array('id' => $id))) {
                $true = "Follow up Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($sales));
            } else {
                $error = "Failed To Edit Follow up ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($sales));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteFollowUp()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 44);
        if ($check) {
            $id = base64_decode($_GET['row']);
            $sales = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('sales_follow_up', 44, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('sales_follow_up', array('id' => $id))) {
                $true = "Follow Up Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($sales));
            } else {
                $error = "Failed To Delete Follow Up ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/followUp?t=" . base64_encode($sales));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function opportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['project_name'])) {
                    $project_name = $_REQUEST['project_name'];
                    if (!empty($project_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $project_name = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['project_status'])) {
                    $project_status = $_REQUEST['project_status'];
                    if (!empty($project_status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $project_status = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $id = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 5);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $region = "";
                }
                // print_r($arr2);
                $cond1 = "l.project_name LIKE '%$project_name%'";
                $cond2 = "l.customer = '$customer'";
                $cond3 = "l.project_status = '$project_status'";
                $cond4 = "l.created_by = '$created_by'";
                $cond5 = "l.id = '$id'";
                $cond6 = "l.created_at BETWEEN '$date_from' AND '$date_to'";
                $cond7 = "r.region = '$region'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['opportunity'] = $this->sales_model->AllOpportunities($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['opportunity'] = $this->sales_model->AllOpportunitiesPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->sales_model->AllOpportunities($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('sales/opportunity');
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

                $data['opportunity'] = $this->sales_model->AllOpportunitiesPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/opportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportOpportunity()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Opportunity.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;

            $arr2 = array();
            if (isset($_REQUEST['project_name'])) {
                $project_name = $_REQUEST['project_name'];
                if (!empty($project_name)) {
                    array_push($arr2, 0);
                }
            } else {
                $project_name = "";
            }
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 1);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['project_status'])) {
                $project_status = $_REQUEST['project_status'];
                if (!empty($project_status)) {
                    array_push($arr2, 2);
                }
            } else {
                $project_status = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 3);
                }
            } else {
                $created_by = "";
            }
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (!empty($id)) {
                    array_push($arr2, 4);
                }
            } else {
                $id = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 5);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 6);
                }
            } else {
                $region = "";
            }
            // print_r($arr2);
            $cond1 = "l.project_name LIKE '%$project_name%'";
            $cond2 = "l.customer = '$customer'";
            $cond3 = "l.project_status = '$project_status'";
            $cond4 = "l.created_by = '$created_by'";
            $cond5 = "l.id = '$id'";
            $cond6 = "l.created_at BETWEEN '$date_from' AND '$date_to'";
            $cond7 = "r.region = '$region'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['opportunity'] = $this->sales_model->AllOpportunities($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['opportunity'] = $this->sales_model->AllOpportunitiesPages($data['permission'], $this->user, $this->brand, 9, 0);
            }
            //Pages ..
            $this->load->view('sales/exportOpportunity.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewOpportunityJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;
            $data['opportunity'] = base64_decode($_GET['t']);
            $data['job'] = $this->sales_model->opportunityJobs($data['permission'], $this->user, $data['opportunity']);
            $data['opportunity_data'] = $this->db->get_where('sales_opportunity', array('id' => $data['opportunity']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/opportunityJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addOpportunityJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;
            $data['opportunity'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_opportunity', array('id' => $data['opportunity']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/addOpportunityJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doOpportunityJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            $price_list = $_POST['price_list'];
            if (isset($_POST['price_list'])) {
                $price_list = $_POST['price_list'];
            } else {
                $error = "Failed To Add Job, Please make sure to select from price list ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
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
            $data['opportunity'] = base64_decode($_POST['opportunity']);
            if ($data['type'] == 1) {
                $data['volume'] = $_POST['volume'];
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['assigned_sam'] = $this->user;
            $data['name'] = $_POST['name'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            if ($this->db->insert('job', $data)) {
                if ($data['type'] == 2) {
                    $fuzzy['job'] = $this->db->insert_id();
                    $fuzzy['opportunity'] = $data['opportunity'];
                    for ($i = 1; $i <= $_POST['total_rows']; $i++) {
                        $fuzzy['prcnt'] = $_POST['prcnt_' . $i];
                        $fuzzy['unit_number'] = $_POST['unit_number_' . $i];
                        $fuzzy['value'] = $_POST['value_' . $i];
                        $this->db->insert('project_fuzzy', $fuzzy);
                    }
                }
                $true = "Job Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
            } else {
                $error = "Failed To Add Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editOpportunityJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;
            $data['job'] = base64_decode($_GET['t']);
            $data['opportunity'] = base64_decode($_GET['o']);
            $data['opp_data'] = $this->db->get_Where('sales_opportunity', array('id' => $data['opportunity']))->row();
            $data['row'] = $this->projects_model->getJobData($data['job']);
            $data['priceList'] = $this->projects_model->getJobPriceListData($data['row']->price_list);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/editOpportunityJob.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditOpportunityJob()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $opportunity = base64_decode($_POST['opportunity']);
            $price_list = $_POST['price_list'];
            if (isset($_POST['price_list'])) {
                $price_list = $_POST['price_list'];
            } else {
                $error = "Failed To Edit Job, Please make sure to select from price list ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
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
            if ($data['type'] == 1) {
                $data['volume'] = $_POST['volume'];
            }

            $this->admin_model->addToLoggerUpdate('job', 67, 'id', $id, 0, 0, $this->user);
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
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
            } else {
                $error = "Failed To Edit Job ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/viewOpportunityJob?t=" . $_POST['opportunity']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 29);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 29);
            //body ..
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/addOpportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 29);
        if ($check) {
            $data['project_name'] = $_POST['project_name'];
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['project_status'] = $_POST['project_status'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['product_line'] = $_POST['product_line'];
            $data['pm'] = $_POST['pm'];
            if ($this->brand == 1)
                $data['branch_name'] = $_POST['branch_name'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if (!isset($_POST['contact_id'])) {
                $error = "Failed To Add New Opportunity, Please select a contact first ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/opportunity");
            }
            if ($this->db->insert('sales_opportunity', $data)) {
                $true = "New Opportunity Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/opportunity");
            } else {
                $error = "Failed To Add New Opportunity ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/opportunity");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 35);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 35);
            //body ..
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_opportunity', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/editOpportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 35);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['project_name'] = $_POST['project_name'];
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['project_status'] = $_POST['project_status'];
            $data['product_line'] = $_POST['product_line'];
            $data['pm'] = $_POST['pm'];
            if ($this->brand == 1)
                $data['branch_name'] = $_POST['branch_name'];

            $this->admin_model->addToLoggerUpdate('sales_opportunity', 35, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('sales_opportunity', $data, array('id' => $id))) {
                $true = "Opportunity Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                // redirect(base_url()."sales/opportunity");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/opportunity");
                }
            } else {
                $error = "Failed To Edit Opportunity ...";
                $this->session->set_flashdata('error', $error);
                // redirect(base_url()."sales/opportunity");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/opportunity");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteOpportunity()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('sales_opportunity', 36, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('sales_opportunity', array('id' => $id))) {
                $true = "Opportunity Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/opportunity");
            } else {
                $error = "Failed To Delete Opportunity ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/opportunity");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function showPriceList()
    {
        $lead = $_POST['lead'];
        $product_line = $_POST['product_line'];
        $result = $this->db->get_where('customer_price_list', array('lead' => $lead, 'product_line' => $product_line))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Product Line</th>
                            <th>Subject Matter</th>
                            <th>Service</th>
                            <th>Task Type</th>
                            <th>Source Language</th>
                            <th>Target Language</th>
                            <th>Rate</th>
                            <th>Unit</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($result as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                            <input type="text" id="rate_' . $x . '" value="' . $row->rate . '" hidden> 
                            <td><input type="radio" name="price_list" onclick="getCheckedPriceListIdRate()" id="' . $x . '" value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->customer_model->getProductLine($row->product_line) . '</td>
                            <td>' . $this->admin_model->getFields($row->subject) . '</td>
                            <td>' . $this->admin_model->getServices($row->service) . '</td>
                            <td>' . $this->admin_model->getTaskType($row->task_type) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->source) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->target) . '</td>
                            <td>' . $row->rate . '</td>
                            <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                            <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getPriceListFuzzy()
    {
        $priceId = $_POST['priceId'];
        $result = $this->db->get_where('customer_fuzzy', array('priceList' => $priceId));
        if ($result->num_rows() > 0) {
            $totalRows = $result->num_rows();
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows" value="' . $totalRows . '" id="total_rows" onchange="projectFuzzy()"></div>';
            $data .= '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Percentages</th>
                            <th>Unit Number</th>
                            <th>Resource percentage</th>
                            <th>price</th>
                        </tr>
                    </thead>
        
                    <tbody>';
            $x = 1;
            foreach ($result->result() as $row) {
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $x . '" value="' . $row->prcnt . '" name="prcnt_' . $x . '" required></td>
                                <td><input type="text" id="unit_number_' . $x . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="0" name="unit_number_' . $x . '" required></td>
                                <td><input type="text" id="value_' . $x . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="' . $row->value . '" name="value_' . $x . '" required></td>
                                <td><input type="text" id="total_price_' . $x . '" name="total_price_' . $x . '" value="0" readonly=""></td>
                            </tr>';
                $x++;
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type" value="2" hidden="">';
        } else {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolume()' onkeypress='return numbersOnly(event)' name='volume' value='0' id='volume' required>
                            </div>
                        </div>";
            $data .= '<input type="text" name="type" value="1" hidden="">';
        }
        echo $data;
    }

    public function getPriceListFuzzyByIteration($i)
    {
        $priceId = $_POST['priceId'];
        $result = $this->db->get_where('customer_fuzzy', array('priceList' => $priceId));
        if ($result->num_rows() > 0) {
            $totalRows = $result->num_rows();
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows_' . $i . '" value="' . $totalRows . '" id="total_rows_' . $i . '" onchange="projectFuzzyByIteration(' . $i . ')"></div>';
            $data .= '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Percentages</th>
                            <th>Unit Number</th>
                            <th>Resource percentage</th>
                            <th>price</th>
                        </tr>
                    </thead>
        
                    <tbody>';
            $x = 1;
            foreach ($result->result() as $row) {
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $x . '_' . $i . '" value="' . $row->prcnt . '" name="prcnt_' . $x . '_' . $i . '" required></td>
                                <td><input type="text" id="unit_number_' . $x . '_' . $i . '" onblur="fuzzyCalculationByIteration(' . $x . ',' . $i . ');totalRevenueByIteration(' . $totalRows . ',' . $i . ')" value="0" name="unit_number_' . $x . '_' . $i . '" required></td>
                                <td><input type="text" id="value_' . $x . '_' . $i . '" onblur="fuzzyCalculationByIteration(' . $x . ',' . $i . ');totalRevenueByIteration(' . $totalRows . ',' . $i . ')" value="' . $row->value . '" name="value_' . $x . '_' . $i . '" required></td>
                                <td><input type="text" id="total_price_' . $x . '_' . $i . '" name="total_price_' . $x . '_' . $i . '" value="0" readonly=""></td>
                            </tr>';
                $x++;
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type_' . $i . '" value="2" hidden="">';
        } else {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolumeByIteration(" . $i . ")' onkeypress='return numbersOnly(event)' name='volume_" . $i . "' value='0' id='volume_" . $i . "' required>
                            </div>
                        </div>";
            $data .= '<input type="text" name="type_' . $i . '" value="1" hidden="">';
        }
        echo $data;
    }

    public function projectFuzzy()
    {
        $totalRows = $_POST['total_rows'];
        if ($totalRows > 0) {
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows" value="' . $totalRows . '" id="total_rows" onchange="projectFuzzy()"></div>';
            $data .= '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Percentages</th>
                            <th>Unit Number</th>
                            <th>Resource percentage</th>
                            <th>price</th>
                        </tr>
                    </thead>
        
                    <tbody>';
            for ($i = 1; $i <= $totalRows; $i++) {
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $i . '" name="prcnt_' . $i . '" required></td>
                                <td><input type="text" id="unit_number_' . $i . '" onblur="fuzzyCalculation(' . $i . ');totalRevenue(' . $totalRows . ')" value="0" name="unit_number_' . $i . '" required></td>
                                <td><input type="text" id="value_' . $i . '" onblur="fuzzyCalculation(' . $i . ');totalRevenue(' . $totalRows . ')" name="value_' . $i . '" required></td>
                                <td><input type="text" id="total_price_' . $i . '" name="total_price_' . $i . '" value="0" readonly=""></td>
                            </tr>';
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type" value="2" hidden="">';
        } else {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolume()' onkeypress='return numbersOnly(event)' name='volume' value='0' id='volume' required>
                            </div>
                        </div>";
            $data .= '<input type="text" name="type" value="1" hidden="">';
        }
        echo $data;
    }

    public function projectFuzzyByIteration($iteration)
    {
        $totalRows = $_POST['total_rows'];
        if ($totalRows > 0) {
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows_' . $iteration . '" value="' . $totalRows . '" id="total_rows_' . $iteration . '" onchange="projectFuzzyByIteration(' . $iteration . ')"></div>';
            $data .= '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Percentages</th>
                            <th>Unit Number</th>
                            <th>Resource percentage</th>
                            <th>price</th>
                        </tr>
                    </thead>
        
                    <tbody>';
            for ($i = 1; $i <= $totalRows; $i++) {
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $i . '_' . $iteration . '" name="prcnt_' . $i . '_' . $iteration . '" required></td>
                                <td><input type="text" id="unit_number_' . $i . '_' . $iteration . '" onblur="fuzzyCalculationByIteration(' . $i . ',' . $iteration . ');totalRevenueByIteration(' . $totalRows . ',' . $iteration . ')" value="0" name="unit_number_' . $i . '_' . $iteration . '" required></td>
                                <td><input type="text" id="value_' . $i . '_' . $iteration . '" onblur="fuzzyCalculationByIteration(' . $i . ',' . $iteration . ');totalRevenueByIteration(' . $totalRows . ',' . $iteration . ')" name="value_' . $i . '_' . $iteration . '" required></td>
                                <td><input type="text" id="total_price_' . $i . '_' . $iteration . '" name="total_price_' . $i . '_' . $iteration . '" value="0" readonly=""></td>
                            </tr>';
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type_' . $iteration . '" value="2" hidden="">';
        } else {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolumeByIteration(" . $iteration . ")' onkeypress='return numbersOnly(event)' name='volume_" . $iteration . "' value='0' id='volume_" . $iteration . "' required>
                            </div>
                        </div>";
            $data .= '<input type="text" name="type_' . $iteration . '" value="1" hidden="">';
        }
        echo $data;
    }

    public function showPriceListByService()
    {
        $lead = $_POST['lead'];
        $product_line = $_POST['product_line'];
        $service = $_POST['service'];
        $result = $this->db->get_where('customer_price_list', array('lead' => $lead, 'product_line' => $product_line, 'service' => $service, 'approved' => 1))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Product Line</th>
                            <th>Subject Matter</th>
                            <th>Service</th>
                            <th>Task Type</th>
                            <th>Source Language</th>
                            <th>Target Language</th>
                            <th>Rate</th>
                            <th>Unit</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($result as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                            <input type="text" id="rate_' . $x . '" value="' . $row->rate . '" hidden> 
                            <td><input type="radio" name="price_list" onclick="getCheckedPriceListIdRate()" id="' . $x . '" value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->customer_model->getProductLine($row->product_line) . '</td>
                            <td>' . $this->admin_model->getFields($row->subject) . '</td>
                            <td>' . $this->admin_model->getServices($row->service) . '</td>
                            <td>' . $this->admin_model->getTaskType($row->task_type) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->source) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->target) . '</td>
                            <td>' . $row->rate . '</td>
                            <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                            <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function showPriceListByServiceIteration($i)
    {
        $lead = $_POST['lead'];
        $product_line = $_POST['product_line'];
        $service = $_POST['service'];
        $result = $this->db->get_where('customer_price_list', array('lead' => $lead, 'product_line' => $product_line, 'service' => $service, 'approved' => 1))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Product Line</th>
                            <th>Subject Matter</th>
                            <th>Service</th>
                            <th>Task Type</th>
                            <th>Source Language</th>
                            <th>Target Language</th>
                            <th>Rate</th>
                            <th>Unit</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($result as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            $data .= '<tr class="">
                            <input type="text" id="rate_' . $x . '_' . $i . '" value="' . $row->rate . '" hidden> 
                            <td><input type="radio" name="price_list_' . $i . '" onclick="getCheckedPriceListIdRateByIteration(' . $i . ')" id="' . $x . '" value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->customer_model->getProductLine($row->product_line) . '</td>
                            <td>' . $this->admin_model->getFields($row->subject) . '</td>
                            <td>' . $this->admin_model->getServices($row->service) . '</td>
                            <td>' . $this->admin_model->getTaskType($row->task_type) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->source) . '</td>
                            <td>' . $this->admin_model->getLanguage($row->target) . '</td>
                            <td>' . $row->rate . '</td>
                            <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                            <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function assignOpportunity()
    {
        $id = base64_decode($_GET['t']);
        $lead = base64_decode($_GET['lead']);
        $data['assigned_by'] = $this->user;
        $data['assigned_at'] = date("Y-m-d H:i:s");
        $data['assigned'] = '1';
        $data['saved'] = '0';
        $checkPmAssigned = $this->db->get_where('customer_pm', array('lead' => $lead));
        if ($checkPmAssigned->num_rows() > 0) {
            if ($this->db->update('sales_opportunity', $data, array('id' => $id))) {
                $this->sales_model->sendAssigningMail($this->user, $this->brand, $checkPmAssigned, $id);
                $true = "Opportunity Assigned Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/opportunity");
            } else {
                $error = "Failed To Assign Opportunity ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/opportunity");
            }
        } else {
            $error = "Failed There's no assigned PM for this customer ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "sales/opportunity");
        }
    }

    public function projects()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 93);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 93);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['project_name'])) {
                    $project_name = $_REQUEST['project_name'];
                    if (!empty($project_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $project_name = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 2);
                    }
                } else {
                    $date_from = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $created_by = 0;
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $region = "";
                }
                // print_r($arr2);
                $cond1 = "p.name LIKE '%$project_name%'";
                $cond2 = "p.customer = '$customer'";
                $cond3 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
                $cond4 = "j.assigned_sam = '$created_by'";
                $cond5 = "r.region = '$region'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->sales_model->AllProjects($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->sales_model->AllProjectsPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->sales_model->AllProjects($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('sales/projects');
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

                $data['project'] = $this->sales_model->AllProjectsPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/sales_projects.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportProjects()
    {

        ini_set('memory_limit', '-1');
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=sales_projects.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 93);
        $brand = $this->brand;
        $arr2 = array();
        if (isset($_REQUEST['project_name'])) {
            $project_name = $_REQUEST['project_name'];
            if (!empty($project_name)) {
                array_push($arr2, 0);
            }
        } else {
            $project_name = "";
        }
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 1);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 2);
            }
        } else {
            $date_from = "";
        }
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 3);
            }
        } else {
            $created_by = 0;
        }
        if (isset($_REQUEST['region'])) {
            $region = $_REQUEST['region'];
            if (!empty($region)) {
                array_push($arr2, 4);
            }
        } else {
            $region = "";
        }
        // print_r($arr2);
        $cond1 = "p.name LIKE '%$project_name%'";
        $cond2 = "p.customer = '$customer'";
        $cond3 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
        $cond4 = "j.assigned_sam = '$created_by'";
        $cond5 = "r.region = '$region'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);

        if ($arr_1_cnt > 0) {
            $data['project'] = $this->sales_model->AllProjects($data['permission'], $this->user, $this->brand, $arr4);
        } else {
            $data['project'] = $this->sales_model->AllProjects($data['permission'], $this->user, $this->brand, 1, 0);
        }

        $this->load->view('sales/exportProjects.php', $data);
    }

    public function businessReviews()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 108);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 108);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            $scren_var = ['id', 'customer', 'created_by', 'type', 'date_from', 'date_to', 'region'];
            if (rtrim($_SERVER['HTTP_REFERER'] ?? '', '/') != base_url('sales/businessReviews')) {
                for ($i = 0; $i < count($scren_var); $i++) {
                    $this->session->unset_userdata($scren_var[$i]);
                    $data[$scren_var[$i]] = "";
                }
            }

            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('sales/businessReviews');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();

            //***********//
            if ($this->input->post('search')) {
                $data['id'] = $this->input->post('id');
                $data['customer'] = $this->input->post('customer');
                $data['created_by'] = $this->input->post('created_by');
                $data['type'] = $this->input->post('type');
                $data['date_from'] = $this->input->post('date_from') ? date("Y-m-d", strtotime($this->input->post('date_from'))) : '';
                $data['date_to'] = $this->input->post('date_to') ? date("Y-m-d", strtotime($this->input->post('date_to'))) : '';
                $data['region'] = $this->input->post('region');

                for ($i = 0; $i < count($scren_var); $i++) {
                    if (!empty($data[$scren_var[$i]])) {
                        $this->session->set_userdata($scren_var[$i], $data[$scren_var[$i]]);
                    } else {
                        $this->session->unset_userdata($scren_var[$i]);
                    }

                }
                //********************//
            } elseif ($this->input->post('submitReset')) {

                for ($i = 0; $i < count($scren_var); $i++) {
                    $this->session->unset_userdata($scren_var[$i]);
                    $data[$scren_var[$i]] = "";
                }

                //**********************//
            }
            for ($i = 0; $i < count($scren_var); $i++) {
                $data[$scren_var[$i]] = $this->session->userdata($scren_var[$i]);
            }

            //**********************//

            $id = $data['id'];
            $customer = $data['customer'];
            $created_by = $data['created_by'];
            $type = $data['type'];
            $date_from = $data['date_from'];
            $date_to = $data['date_to'];
            $region = $data['region'];

            //**********************//
            if (!empty($id)) {
                $data['id'] = $id;
                array_push($arr2, 0);
                array_push($arr1, "id = '$id'");

            }
            if (!empty($customer)) {
                $data['customer'] = $customer;
                array_push($arr2, 1);
                array_push($arr1, "customer = '$customer'");
            }
            if (!empty($created_by)) {
                $data['created_by'] = $created_by;
                array_push($arr2, 2);
                array_push($arr1, "created_by = '$created_by'");

            }
            if (!empty($type)) {
                $data['type'] = $type;
                array_push($arr2, 3);
                array_push($arr1, "type = '$type'");

            }
            if (!empty($date_from) && !empty($date_to)) {
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                array_push($arr2, 4);
                array_push($arr1, "created_at BETWEEN '$date_from' AND '$date_to' ");

            }
            if (!empty($region)) {
                $data['region'] = $region;
                array_push($arr2, 5);
                array_push($arr1, "c.region = '$region'");

            }
            //************************//
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['business'] = $this->sales_model->AllbusinessReviewsPages($data['permission'], $this->user, $this->brand, $arr4, $limit, $offset);
                $count = $this->sales_model->AllbusinessReviews($data['permission'], $this->user, $this->brand, $arr4)->num_rows();
            } else {
                $data['business'] = $this->sales_model->AllbusinessReviewsPages($data['permission'], $this->user, $this->brand, '1', $limit, $offset);
                $count = $this->sales_model->AllbusinessReviews($data['permission'], $this->user, $this->brand, '1')->num_rows();

            }
            $data['total_rows'] = $count;

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/businessReviews.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }

    }

    public function exportBusinessReviews()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Business Reviews.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 108);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 108);
            //body ..
            $data['user'] = $this->user;

            $arr2 = array();
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (!empty($id)) {
                    array_push($arr2, 0);
                }
            } else {
                $id = "";
            }
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 1);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 2);
                }
            } else {
                $created_by = "";
            }
            if (isset($_REQUEST['type'])) {
                $type = $_REQUEST['type'];
                if (!empty($type)) {
                    array_push($arr2, 3);
                }
            } else {
                $type = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 4);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }
            // print_r($arr2);
            $cond1 = "id = '$id'";
            $cond2 = "customer = '$customer'";
            $cond3 = "created_by = '$created_by'";
            $cond4 = "type = '$type'";
            $cond5 = "created_at BETWEEN '$date_from' AND '$date_to'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            //print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['business'] = $this->sales_model->AllbusinessReviews($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['business'] = $this->sales_model->AllbusinessReviewsPages($data['permission'], $this->user, $this->brand, 9, 0);
            }

            //Pages ..

            $this->load->view('sales/exportBusinessReviews.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addBusinessReviews()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 108);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/addBusinessReviews.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function checkSlaAttachment()
    {
        $lead = $_POST['lead'];
        $data = $this->db->get_where('customer_leads', array('id' => $lead))->row()->sla_attachment;
        if (strlen($data) > 0) {
            echo $html = ' <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="role name">Download SLA Attachment</label>

                            <div class="col-lg-6">
                                <a href=' . base_url() . 'assets/uploads/slaAttachment/' . $data . '>Click Me</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="role name">Update SLA Attachment</label>

                            <div class="col-lg-6">
                                <input type="file" class=" form-control" name="sla_attachment" id="sla_attachment">
                            </div>
                        </div>
                        ';
        } else {
            echo $html = ' <div class="form-group row">
                            <label class="col-lg-3 col-form-label text-right" for="role name">Attachment</label>

                            <div class="col-lg-6">
                                <input type="file" class=" form-control" name="sla_attachment" id="sla_attachment" required>
                            </div>
                        </div> ';
        }
    }

    public function doAddBusinessReviews()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 108);
        if ($permission->add == 1) {
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['type'] = $_POST['type'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if (!isset($_POST['contact_id'])) {
                $error = "Failed To Add, Please select a contact first ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/BusinessReviews");
            }
            if ($data['type'] == 1) {
                $data['sla_reason'] = $_POST['sla_reason'];
                if ($_FILES['sla_attachment']['size'] != 0) {
                    //$config['sla_attachment']['upload_path']          = './assets/uploads/slaAttachment/';
                    $config['sla_attachment']['upload_path'] = './assets/uploads/slaAttachment/';
                    $config['sla_attachment']['encrypt_name'] = TRUE;
                    $config['sla_attachment']['allowed_types'] = 'zip|rar';
                    $config['sla_attachment']['max_size'] = 100000000000;
                    $this->load->library('upload', $config['sla_attachment'], 'file_upload');
                    if (!$this->file_upload->do_upload('sla_attachment')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['sla_attachment'] = $leadData['sla_attachment'] = $data_file['file_name'];
                        $this->db->update('customer_leads', $leadData, array('id' => $data['lead']));
                    }
                }
            } elseif ($data['type'] == 2) {
                $data['sip_issue'] = $_POST['sip_issue'];
                $data['sip_reason'] = $_POST['sip_reason'];
                $data['sip_improvement_owner'] = $_POST['sip_improvement_owner'];
                $data['sip_proposed_solution'] = $_POST['sip_proposed_solution'];
                $data['sip_due_date'] = $_POST['sip_due_date'];
                $data['sip_status_resolution'] = $_POST['sip_status_resolution'];
            }
            if ($this->db->insert('sales_business_reviews', $data)) {
                //$this->sales_model->sendBusinessReviewMail($data,$this->user,$this->db->insert_id());
                $true = "New Business Review Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/BusinessReviews");
            } else {
                $error = "Failed To Add New Business Review ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/BusinessReviews");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editBusinessReviews()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 108);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_business_reviews', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('sales/editBusinessReviews.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditBusinessReviews()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 35);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['lead'] = $_POST['lead'];
            $data['customer'] = $_POST['customer'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['type'] = $_POST['type'];
            if (!isset($_POST['contact_id'])) {
                $error = "Failed To Edit, Please select a contact first ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."sales/BusinessReviews");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/BusinessReviews");
                }
            }
            if ($data['type'] == 1) {
                $old = $this->db->get_where('sales_business_reviews', array('id' => $id))->row();
                if ($data['lead'] == $old->lead) {
                    $data['sla_reason'] = $_POST['sla_reason'];
                    if ($_FILES['sla_attachment']['size'] != 0) {
                        //$config['sla_attachment']['upload_path']          = './assets/uploads/slaAttachment/';
                        $config['sla_attachment']['upload_path'] = './assets/uploads/slaAttachment/';
                        $config['sla_attachment']['encrypt_name'] = TRUE;
                        $config['sla_attachment']['allowed_types'] = 'zip|rar';
                        $config['sla_attachment']['max_size'] = 100000000000;
                        $this->load->library('upload', $config['sla_attachment'], 'file_upload');
                        if (!$this->file_upload->do_upload('sla_attachment')) {
                            $error = $this->file_upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $data_file = $this->file_upload->data();
                            $data['sla_attachment'] = $leadData['sla_attachment'] = $data_file['file_name'];
                            $this->db->update('customer_leads', $leadData, array('id' => $data['lead']));
                        }
                    }
                } else {
                    $data['sla_reason'] = $_POST['sla_reason'];
                    if ($_FILES['sla_attachment']['size'] != 0) {
                        //$config['sla_attachment']['upload_path']          = './assets/uploads/slaAttachment/';
                        $config['sla_attachment']['upload_path'] = './assets/uploads/slaAttachment/';
                        $config['sla_attachment']['encrypt_name'] = TRUE;
                        $config['sla_attachment']['allowed_types'] = 'zip|rar';
                        $config['sla_attachment']['max_size'] = 100000000000;
                        $this->load->library('upload', $config['sla_attachment'], 'file_upload');
                        if (!$this->file_upload->do_upload('sla_attachment')) {
                            $error = $this->file_upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $data_file = $this->file_upload->data();
                            $data['sla_attachment'] = $leadData['sla_attachment'] = $data_file['file_name'];
                            $this->db->update('customer_leads', $leadData, array('id' => $data['lead']));
                        }
                    } else {
                        $leadData['sla_attachment'] = $old->sla_attachment;
                        $this->db->update('customer_leads', $leadData, array('id' => $data['lead']));
                        $this->db->update('customer_leads', array('sla_attachment' => ""), array('id' => $old->lead));
                    }
                }
            } elseif ($data['type'] == 2) {
                $data['sip_issue'] = $_POST['sip_issue'];
                $data['sip_reason'] = $_POST['sip_reason'];
                $data['sip_improvement_owner'] = $_POST['sip_improvement_owner'];
                $data['sip_proposed_solution'] = $_POST['sip_proposed_solution'];
                $data['sip_due_date'] = $_POST['sip_due_date'];
                $data['sip_status_resolution'] = $_POST['sip_status_resolution'];
            }

            $this->admin_model->addToLoggerUpdate('sales_business_reviews', 108, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('sales_business_reviews', $data, array('id' => $id))) {
                $true = "Business Review Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."sales/BusinessReviews");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/BusinessReviews");
                }
            } else {
                $error = "Failed To Edit Business Review ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."sales/BusinessReviews");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/BusinessReviews");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // public function exportBusinessReviews(){
    //       $file_type = "vnd.ms-excel";
    //        $file_ending = "xls";
    //        // $file_type = "msword";
    //        // $file_ending = "doc";
    //        header("Content-Type: application/$file_type");
    //        header("Content-Disposition: attachment; filename=businessReviews.$file_ending");
    //        header("Pragma: no-cache");
    //        header("Expires: 0");
    //        //body ..
    //        $data['user'] = $this->user;

    //        $data['business'] = $this->db->query(" SELECT *,(SELECT brand FROM customer WHERE customer.id = sales_business_reviews.customer) AS brand FROM `sales_business_reviews` WHERE created_at BETWEEN '2019-04-01' AND '2019-05-01' HAVING brand = '1' ");
    //        $this->load->view('sales/exportAllBusiness.php',$data);

    //    }

    public function exportOpportunities()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=opportunities.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 23);
        //body ..
        $data['user'] = $this->user;

        $data['opportunity'] = $this->db->query(" SELECT *,(SELECT brand FROM customer WHERE customer.id = sales_opportunity.customer) AS brand FROM `sales_opportunity` WHERE created_at BETWEEN '2019-04-01' AND '2019-05-01' HAVING brand = '1' ORDER BY `id` DESC  ");

        $this->load->view('sales/exportAllOpportunity.php', $data);

    }

    public function SAMClosedOpportunity()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=opportunities.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $row = $this->db->query("SELECT p.opportunity,p.customer,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT created_by FROM sales_opportunity WHERE sales_opportunity.id = p.opportunity) AS SAM,j.* FROM job AS j LEFT OUTER JOIN project AS p ON p.id = j.project_id WHERE p.opportunity > 0 AND j.status = '1' AND j.closed_date BETWEEN '2019-01-01' AND '2019-07-01' HAVING brand = '1' ORDER BY `p`.`opportunity` ASC ")->result();

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
			 <th>SAM</th>
			 <th>Job Code</th>
               <th>Client Name</th>
               <th>PO Number</th>
               <th>Service</th>
               <th>Source</th>
               <th>Target</th>
               <th>Volume</th>
               <th>Rate</th>
               <th>Total Revenue</th>
               <th>Currency</th>
               <th>Total Revenue (USD)</th>
        </tr>
    </thead>
    <tbody>';
        foreach ($row as $row) {
            $priceList = $this->projects_model->getJobPriceListData($row->price_list);
            $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
            $poData = $this->projects_model->getJobPoData($row->po);
            $data .= '<tr class="gradeX">
            <td>' . $this->admin_model->getAdmin($row->SAM) . '</td>
            <td>' . $row->code . '</td>
            <td>' . $this->customer_model->getCustomer($row->customer) . '</td>
                      <td>' . $poData->number . '</td>
                      <td>' . $this->admin_model->getServices($priceList->service) . '</td>
                      <td>' . $this->admin_model->getLanguage($priceList->source) . '</td>
                      <td>' . $this->admin_model->getLanguage($priceList->target) . '</td>';
            if ($row->type == 1) {
                $data .= '<td>' . $row->volume . '</td>';
            } elseif ($row->type == 2) {
                $data .= '<td>' . $total_revenue / $priceList->rate . '</td>';
            }
            $data .= '<td>' . $priceList->rate . '</td>
                      <td>' . number_format($total_revenue, 2) . '</td>
                      <td>' . $this->admin_model->getCurrency($priceList->currency) . '</td>
                      <td>' . number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $row->closed_date, $total_revenue), 2) . '</td>
                    </tr>';
        }
        $data .= '</tbody>
            </table>
            </body>
            </html>';
        echo $data;
    }

    //lost opportunity 


    public function lostOpportunity()
    {
        $check = $this->admin_model->checkPermission($this->role, 155);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 155);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['project_name'])) {
                    $projectName = $_REQUEST['project_name'];
                    if (!empty($projectName)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $projectName = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                if (isset($_REQUEST['pm'])) {
                    $pm = $_REQUEST['pm'];
                    if (!empty($pm)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $pm = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $region = "";
                }
                $cond1 = "s.project_name LIKE '%$projectName%'";
                $cond2 = "s.customer = '$customer'";
                $cond3 = "s.created_by = '$created_by'";
                $cond4 = "s.created_at BETWEEN '$date_from' AND '$date_to'";
                $cond5 = "s.pm = '$pm'";
                $cond6 = "l.region = '$region'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['lost_opportunity'] = $this->sales_model->AllLostOpportunity($data['permission'], $this->user, $arr4, $this->brand);
                } else {
                    $data['lost_opportunity'] = $this->sales_model->AllLostOpportunityPages($data['permission'], $this->user, 9, 0, $this->brand);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->sales_model->AllLostOpportunity($data['permission'], $this->user, 1, $this->brand)->num_rows();
                $config['base_url'] = base_url('sales/lostOpportunity');
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

                $data['lost_opportunity'] = $this->sales_model->AllLostOpportunityPages($data['permission'], $this->user, $limit, $offset, $this->brand);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/lostOpportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addLostOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 155);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 155);
            //body ..
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/addLostOpportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddLostOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 155);
        if ($check) {

            $data['project_name'] = $_POST['project_name'];
            $data['customer'] = $_POST['customer'];
            $data['lead'] = $_POST['lead'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['lost_reasons'] = $_POST['lost_reasons'];
            $data['product_line'] = $_POST['product_line'];
            $data['pm'] = $_POST['pm'];
            $data['currency'] = $_POST['currency'];
            $data['source'] = $_POST['source'];
            $data['target'] = $_POST['target'];
            $data['service'] = $_POST['service'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['rate'] = $_POST['rate'];
            $data['volume'] = $_POST['volume'];
            $data['total_revenue'] = $_POST['total_revenue'];
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if (!isset($_POST['contact_id'])) {
                $error = "Failed To Add Lost Opportunity, Please select a contact first ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/lostOpportunity");

            }
            if ($this->db->insert('sales_lost_opportunity', $data)) {
                $true = "Lost Opportunity Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "sales/lostOpportunity");
            } else {
                $error = "Failed To Add Lost Opportunity ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/lostOpportunity");
            }

        } else {
            echo "You have no permission to access this page";
        }

    }

    public function editLostOpportunity()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 155);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('sales_lost_opportunity', array('id' => $data['id']))->row();
            $data['sam'] = $this->user;
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/editLostOpportunity.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditLostOpportunity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 155);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['project_name'] = $_POST['project_name'];
            $data['customer'] = $_POST['customer'];
            $data['lead'] = $_POST['lead'];
            $data['contact_method'] = $_POST['contact_method'];
            $data['contact_id'] = $_POST['contact_id'];
            $data['lost_reasons'] = $_POST['lost_reasons'];
            $data['product_line'] = $_POST['product_line'];
            $data['pm'] = $_POST['pm'];
            $data['currency'] = $_POST['currency'];
            $data['source'] = $_POST['source'];
            $data['target'] = $_POST['target'];
            $data['service'] = $_POST['service'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['rate'] = $_POST['rate'];
            $data['volume'] = $_POST['volume'];
            $data['total_revenue'] = $_POST['total_revenue'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['brand'] = $this->brand;
            if (!isset($_POST['contact_id'])) {
                $error = "Failed To Add Lost Opportunity...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "sales/lostOpportunity");
            }
            $this->admin_model->addToLoggerUpdate('sales_lost_opportunity', 155, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('sales_lost_opportunity', $data, array('id' => $id))) {
                $true = " Lost Opportunity Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/lostOpportunity");
                }
            } else {
                $error = "Failed To Edit Lost Opportunity ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "sales/lostOpportunity");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteLostOpportunity()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 155);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('sales_lost_opportunity', 155, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('sales_lost_opportunity', array('id' => $id))) {
                $true = "Lost Opportunity Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Lost Opportunity ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function getLostOpportunityPM()
    {
        $customer_id = $_POST['customer_id'];
        $lead = $_POST['lead'];
        echo $this->sales_model->getLostOpportunityPM($customer_id, $lead);
    }
    public function CalculateTotalRevenueForLostOpportunities()
    {
        $rate = $_POST['rate'];
        $volume = $_POST['volume'];
        echo $rate * $volume;
    }
    public function exportlostOpportunity()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Lost Opportunities.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 28);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 28);
            //body ..
            $data['user'] = $this->user;
            $arr2 = array();
            if (isset($_REQUEST['project_name'])) {
                $projectName = $_REQUEST['project_name'];
                if (!empty($projectName)) {
                    array_push($arr2, 0);
                }
            } else {
                $projectName = "";
            }
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 1);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 2);
                }
            } else {
                $created_by = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 3);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }
            if (isset($_REQUEST['pm'])) {
                $pm = $_REQUEST['pm'];
                if (!empty($pm)) {
                    array_push($arr2, 4);
                }
            } else {
                $pm = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 5);
                }
            } else {
                $region = "";
            }
            $cond1 = "s.project_name LIKE '%$projectName%'";
            $cond2 = "s.customer = '$customer'";
            $cond3 = "s.created_by = '$created_by'";
            $cond4 = "s.created_at BETWEEN '$date_from' AND '$date_to'";
            $cond5 = "s.pm = '$pm'";
            $cond6 = "l.region = '$region'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['lost_opportunity'] = $this->sales_model->AllLostOpportunity($data['permission'], $this->user, $arr4, $this->brand);
            } else {
                $data['lost_opportunity'] = $this->sales_model->AllLostOpportunityPages($data['permission'], $this->user, 9, 0, $this->brand);
            }

            //Pages ..

            $this->load->view('sales/exportlostOpportunity.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }
}
?>