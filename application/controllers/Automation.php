<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Automation extends CI_Controller
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
        $this->ticket_type = array("Service Request", "Change Request", "Incident");
        $this->load->model('automation_model');
    }

    public function tickets()
    {
        $check = $this->admin_model->checkPermission($this->role, 198);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 198);
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
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 1);
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
                        array_push($arr2, 2);
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
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 3);
                        $data['type'] = $type;
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 4);
                        $data['id'] = $id;
                    }
                } else {
                    $id = "";
                }

                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 5);
                        $data['status'] = $status;
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['action_type'])) {
                    $action_type = $_REQUEST['action_type'];
                    if (!empty($action_type)) {
                        array_push($arr2, 6);
                        $data['action_type'] = $action_type;
                    }
                } else {
                    $action_type = "";
                }
                if (isset($_REQUEST['approvalStatus'])) {
                    $approvalStatus = $_REQUEST['approvalStatus'];
                    if (!empty($approvalStatus)) {
                        array_push($arr2, 7);
                        $data['approval'] = $approvalStatus;
                    }
                } else {
                    $approvalStatus = "";
                }
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 8);
                        $data['year'] = $year;
                    }
                } else {
                    $year = "";
                }
                $cond1 = "date_format(created_at, '%m') LIKE '%$month%'";               
                $cond2 = "emp_id = '$employee_name'";
                $cond3 = "emp_id IN ($empIds)";
                $cond4 = "ticket_type = '$type'";
                $cond5 = "id = '$id'";

                $cond6 = "status = '$status'";
                $cond7 = "action_type = '$action_type'";
                $cond8 = "approval = '$approvalStatus'";
                $cond9 = "date_format(created_at, '%Y') LIKE '%$year%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8,$cond9);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['tickets'] = $this->automation_model->AllTickets($data['permission'], $arr4);
                } else {
                    $data['tickets'] = $this->automation_model->AllTickets($data['permission'], 1);
                }
            } else {
                $limit = 20;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->automation_model->AllTickets($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('automation/tickets');
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

                $data['tickets'] = $this->automation_model->AllTicketsPages($data['permission'], $limit, $offset);
            }
            //Pages ..

            $data['total_new'] = $this->automation_model->TicketsCount($data['permission'], 1, 0);
            $data['total_rows']  = $this->automation_model->AllTickets($data['permission'], 1)->num_rows();
            $data['total_opened'] = $this->automation_model->TicketsCount($data['permission'], 1, 1);
            $data['total_progress'] = $this->automation_model->TicketsCount($data['permission'], 1, 2);
            $data['total_closed'] = $this->automation_model->TicketsCount($data['permission'], 1, 3);
            $data['total_pending'] = $this->automation_model->TicketsCount($data['permission'], 1, 4);
            $data['total_cancelled'] = $this->automation_model->TicketsCount($data['permission'], 1, 5);
            $data['total_approval'] = $this->automation_model->TicketsCount($data['permission'], 1, 6);

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('automation/allTickets.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addTicket()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 198);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            $data['emp_id'] = $this->emp_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('automation/addTicket.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function saveTicket()
    {

        // print_r($this->user);exit();
        $data['emp_id'] = $this->emp_id;
        $data['subject'] = $_POST['subject'];
        $data['description'] = $_POST['description'];

        if ($_FILES['file']['size'] != 0) {
            $config['file']['upload_path']          = './assets/uploads/automationTickets/';
            //   $config['file']['upload_path'] = '/var/www/html/assets/uploads/automationTickets/';
            $config['file']['encrypt_name'] = TRUE;
            $config['file']['allowed_types'] = '*';
            $config['file']['max_size'] = 10000;

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
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");

        if ($this->db->insert('automation_tickets', $data)) {
            $id = $this->db->insert_id();
            $mailSubject = "Automation System - New Ticket #$id: " . date("Y-m-d H:i:s");
            $mailBody = "You have new ticket " . "<br>";
            $mailBody .= " From : " . $this->admin_model->getAdmin($this->user) . "<br>";
            $mailBody .= " Subject : " . $data['subject'] . "<br>";
            $mailBody .= "please check...";
            $this->automation_model->sendTicketMail($mailSubject, $mailBody);
            $true = "Ticket Send Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "automation/tickets");
        } else {
            $error = "Failed To Add Ticket ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function viewTicket()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 198);
        $id = base64_decode($_GET['t']);
        $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
       if ($data['permission']->view == 1 || $ticket->emp_id == $this->emp_id || $this->hr_model->checkThisUserIsEmployeeManager($ticket->emp_id)) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..            
            $data['emp_id'] = $this->emp_id;
            $data['role'] = $this->role;
            $data['ticket'] = $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
            $data['comments'] = $this->db->get_where('automation_ticket_comments', array('ticket_id' => $id))->result();

            // change status to opened
            if ($ticket->status == 0 && $data['permission']->view == 1) {
                $data_action['status'] = 1;
                $this->db->update('automation_tickets', $data_action, array('id' => $id));
                $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('automation/viewTicket.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function get_email($id = '')
    {
        $employee_id = $this->input->post('employee_id');
        $user_email = $this->admin_model->getUserEmail($employee_id);

        echo $user_email;
    }
    public function changeStatusTicket($id)
    {

        $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
        $status = $_POST['status'];
        if ($status == 3) {
            $data_action['action_type'] = $_POST['action_type'];
            $data_action['closed_at'] = date("Y-m-d H:i:s");
            $data_action['closed_by'] = $this->user;
            $mailSubject = "Automation System - Ticket #$id";
            $mailBody = "Your Ticket #$id has been done. <br/> Date : " . date('Y-m-d H:i:s');
            $this->automation_model->sendTicketMail($mailSubject, $mailBody, $ticket->created_by);
        }
        if ($status == 5) {
            $data_action['comment'] = $_POST['comment'];
            $data_action['closed_at'] = date("Y-m-d H:i:s");
            $data_action['closed_by'] = $this->user;
            $mailSubject = "Automation System - Ticket #$id";
            $mailBody = "Your Ticket #$id has been cancelled. <br/> Date : " . date('Y-m-d H:i:s');
            $mailBody .= "<br/><br/>" . $_POST['comment'];
            $this->automation_model->sendTicketMail($mailSubject, $mailBody, $ticket->created_by);
        }
        $data_action['status'] = $status;
        $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
        $this->db->update('automation_tickets', $data_action, array('id' => $id));
    }
    public function changeApprovalStatusTicket($id = '')
    {
        $id = $_POST['id'];
        $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
        $data_action['approval'] = $_POST['approvalStatus'];

        switch ($data_action['approval']) {
            case '0':
                $data_action['emp_approval_id'] = '';
                $data_action['emp_approval_email'] = '';
                $data_action['send_approval_at'] = date("Y-m-d H:i:s");
                $data_action['send_approval_by'] = '';
                $data_action['send_flg'] = '0';
                $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
                $this->db->update('automation_tickets', $data_action, array('id' => $id));

                break;
            case '1':
                $data_action['emp_approval_id'] = $_POST['emp_id'];
                $emp_name = $this->automation_model->getEmpName($data_action['emp_approval_id']);
                $data_action['emp_approval_email'] = $this->admin_model->getUserEmail($_POST['emp_id']);

                $data_action['send_approval_at'] = date("Y-m-d H:i:s");
                $data_action['send_approval_by'] = $this->user;

                // $config = array(
                //     'protocol' => 'smtp',
                //     'smtp_host' => 'ssl://smtp.googlemail.com',
                //     'smtp_port' => 587,
                //     'smtp_user' => 'mohamedel20@gmail.com',
                //     'smtp_pass' => 'wxnrcnlbevgmofbn',
                //     'mailtype' => 'html',
                //     'charset' => 'iso-8859-1',
                //     'wordwrap' => TRUE
                // );

                $message = $this->approvalMessage($id, $emp_name, $ticket);
                $mailTo = $data_action['emp_approval_email'];
                $mailFrom = "dev@thetranslationgate.com";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: ' . $mailFrom . "\r\n";
                $subject = "Automation System - Ticket #" . $id . " Approval Request";

                if (mail($mailTo, $subject, $message, $headers)) {
                    $this->email->clear(TRUE);
                    $data_action['send_flg'] = '1';
                    $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
                    $this->db->update('automation_tickets', $data_action, array('id' => $id));
                } else {
                    $this->email->clear(TRUE);
                    echo $this->email->print_debugger();
                }
                break;
            case '2':
                $data_action['emp_approval_at'] = date("Y-m-d H:i:s");
                $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
                $this->db->update('automation_tickets', $data_action, array('id' => $id));
                break;
            case '3':
                $data_action['emp_approval_at'] = date("Y-m-d H:i:s");
                $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
                $this->db->update('automation_tickets', $data_action, array('id' => $id));
                break;
            default:
                break;
        }
        echo "";
        // $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
        // $this->db->update('automation_tickets', $data_action, array('id' => $id));

    }
    function approvalMessage($id, $emp_name, $ticket)
    {
        $mailBody = "<p> Need Approval for this Request </p>";
        $mailBody .= "<h3> Ticket # $id <br/> Date : " . $ticket->created_at . "</h3> ";

        $mailBody .= "<hr>";
        $mailBody .= "<h4>Request From : " . $this->automation_model->getEmpName($ticket->emp_id) . "</h4>";
        $mailBody .= "<hr>";
        $mailBody .= "<h4>Subject : " . $ticket->subject . "</h4>";
        $mailBody .= "<hr>";
        $mailBody .= "<table><tr><td><h4>Description :</h4><div>" . $ticket->description . "</div></td></tr></table><br>";
        $mailBody .= "<hr>";
        $message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
        <title>Falaq| Site Manager</title>
        <style>
        body {
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.428571429;
            color: #333;
        }
        td div {
            width : 100%!important;
        }
        </style>
    </head>

    <body>
        <p>Dear ' . $emp_name . ',</p>
       
         <div>' . $mailBody . '</div>
        <p>Thank You!</p>
    </body>
    </html>';
        return $message;
    }
    public function sendReply()
    {


        $id = $data['ticket_id'] = $_POST['ticket_id'];
        $data['comment'] = $_POST['comment'];
        $data['emp_id'] = $this->emp_id;
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        if ($_FILES['file']['size'] != 0) {
            $config['file']['upload_path']          = './assets/uploads/automationTickets/';
            //  $config['file']['upload_path'] = '/var/www/html/assets/uploads/automationTickets/';
            $config['file']['encrypt_name'] = TRUE;
            $config['file']['allowed_types'] = '*';
            $config['file']['max_size'] = 10000;

            $this->load->library('upload', $config['file'], 'file_upload');
            if ($this->file_upload->do_upload('file')) {
                $data_file = $this->file_upload->data();
                $data['file'] = $data_file['file_name'];
            }
        }
        if ($this->db->insert('automation_ticket_comments', $data)) {
            $mailSubject = "Automation System - Ticket #$id";
            $mailBody = "You Have New Reply Please check ...";
            $mailBody .= "<br/><br/><a href='" . base_url() . "/automation/viewTicket?t=" . base64_encode($id) . "'>Click Here </a> to view the ticket ";
            if ($this->role == 21 || $this->role == 1) {
                $ticket_created_by = $this->db->get_where('automation_tickets', array('id' => $id))->row()->created_by;
                $this->automation_model->sendTicketMail($mailSubject, $mailBody, $ticket_created_by);
            } else {
                $this->automation_model->sendTicketMail($mailSubject, $mailBody);
            }
        }
    }

    public function changeTicketType($id)
    {

        $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
        $data['ticket_type'] = $_POST['ticket_type'];
        $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
        if ($this->db->update('automation_tickets', $data, array('id' => $id))) {

            $true = "Ticket Updated Successfully...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function changeServiceType($id)
    {

        $ticket = $this->db->get_where('automation_tickets', array('id' => $id))->row();
        $data['service_type'] = $_POST['service_type'];
        $this->admin_model->addToLoggerUpdate('automation_tickets', 198, 'id', $id, 0, 0, $this->user);
        if ($this->db->update('automation_tickets', $data, array('id' => $id))) {

            $true = "Ticket Updated Successfully...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function exportTickets()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Tickets.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 198);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 198);
            //body ..
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
            if (isset($_REQUEST['employee_name'])) {
                $employee_name = $_REQUEST['employee_name'];
                if (!empty($employee_name)) {
                    array_push($arr2, 1);
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
                    array_push($arr2, 2);
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
            if (isset($_REQUEST['type'])) {
                $type = $_REQUEST['type'];
                if (!empty($type)) {
                    array_push($arr2, 3);
                    $data['type'] = $type;
                }
            } else {
                $type = "";
            }
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (!empty($id)) {
                    array_push($arr2, 4);
                    $data['id'] = $id;
                }
            } else {
                $id = "";
            }

            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    array_push($arr2, 5);
                    $data['status'] = $status;
                }
            } else {
                $status = "";
            }
            if (isset($_REQUEST['action_type'])) {
                $action_type = $_REQUEST['action_type'];
                if (!empty($action_type)) {
                    array_push($arr2, 6);
                    $data['action_type'] = $action_type;
                }
            } else {
                $action_type = "";
            }
            if (isset($_REQUEST['approvalStatus'])) {
                $approvalStatus = $_REQUEST['approvalStatus'];
                if (!empty($approvalStatus)) {
                    array_push($arr2, 7);
                    $data['approval'] = $approvalStatus;
                }
            } else {
                $approvalStatus = "";
            }
               if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 8);
                        $data['year'] = $year;
                    }
                } else {
                    $year = "";
                }
            $cond1 = "date_format(created_at, '%m') LIKE '%$month%'";
            $cond2 = "emp_id = '$employee_name'";
            $cond3 = "emp_id IN ($empIds)";
            $cond4 = "ticket_type = '$type'";
            $cond5 = "id = '$id'";

            $cond6 = "status = '$status'";
            $cond7 = "action_type = '$action_type'";
            $cond8 = "approval = '$approvalStatus'";
            $cond9 = "date_format(created_at, '%Y') LIKE '%$year%'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8,$cond9);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['tickets'] = $this->automation_model->AllTickets($data['permission'], $arr4);
            } else {
                $data['tickets'] = $this->automation_model->AllTicketsPages($data['permission'], 9, 0);
            }

            $this->load->view('automation/exportTickets.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    // ticket type
    public function allServiceTypes()
    {
        $check = $this->admin_model->checkPermission($this->role, 232);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 232);

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 0);
                        $data['type'] = $type;
                    }
                } else {
                    $type = "";
                }
                $cond1 = "title like '%$type%'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['tickets'] = $this->automation_model->allServiceTypes($data['permission'], $arr4);
                } else {
                    $data['tickets'] = $this->automation_model->allServiceTypesPages($data['permission'], 9, 0);
                }
                $data['total_rows'] = $data['tickets']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->automation_model->allServiceTypes($data['permission'], 1)->num_rows();
                $config['base_url'] = base_url('automation/allServiceTypes');
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

                $data['tickets'] = $this->automation_model->allServiceTypesPages($data['permission'], $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('automation/service/allServiceTypes.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function saveServiceType()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 232);
        if ($permission->add == 1) {
            $data['title'] = $_POST['title'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('automation_service_types', $data)) {
                $true = "Data Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Data ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updateServiceType()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 232);
        if ($permission->edit == 1) {
            $id = $_POST['id'];
            $data['title'] = $_POST['title'];
            $this->admin_model->addToLoggerUpdate('automation_service_types', 232, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('automation_service_types', $data, array('id' => $id))) {
                $true = "Data Updated Successfully...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
}
