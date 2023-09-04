<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Automation_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getEmpName($emp_id)
    {
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }
    public function getUserName($user_id)
    {
        $result = $this->db->get_where('users', array('id' => $user_id))->row();
        if (isset($result->user_name)) {
            return $result->user_name;
        } else {
            return '';
        }
    }
    public function getEmpDep($emp_id)
    {
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();
        if (isset($result->department)) {
            $department = $this->db->get_where('department', array('id' => $result->department))->row();
            if (isset($department))
                return $department->name;
        } else {
            return '';
        }
    }

    public function AllTickets($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `automation_tickets` WHERE " . $filter . " Order By `status` ASC,`created_at` DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `automation_tickets` WHERE " . $filter . " AND emp_id = $this->emp_id Order By `status` ASC,`created_at` DESC");
        }
        return $data;
    }

    public function AllTicketPages($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `automation_tickets` Order By `status` ASC,`created_at` DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `automation_tickets` WHERE emp_id = $this->emp_id Order By `status` ASC,`created_at` DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function selectTicketType($id = "")
    {
        $types = array("Service Request", "Change Request", "Incident", "Development");
        $data = "";
        foreach ($types as $type) {
            if ($type == $id) {
                $data .= "<option value='" . $type . "' selected='selected'>" . $type . "</option>";
            } else {
                $data .= "<option value='" . $type . "'>" . $type . "</option>";
            }
        }
        return $data;
    }

    public function getTicketStatus($status)
    {

        $statusArray = ['0' => "New", '1' => "Opened", '2' => "In Progress", '3' => "Closed"];
        $statusColor = ['0' => "success", '1' => "info", '2' => "warning", '3' => "dark"];
        $data['status'] = $statusArray[$status];
        $data['color'] = $statusColor[$status];
        return $data;
    }

    public function sendTicketMail($mailSubject, $mailBody, $mailToID = '')
    {

        if (empty($mailToID)) {
            $mailTo = "dev@thetranslationgate.com";
            $emp_name = "DEV Team";
        } else {
            $mailTo = $this->db->get_where('users', array('id' => $mailToID))->row()->email;
            $emp_name = $this->admin_model->getUser($mailToID);
        }
        //       if(empty($mailFrom))
        $mailFrom = "dev@aixnexus.com";
        //        $mailFrom = $this->db->get_where('users',array('id'=>$this->user))->row()->email;



        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //     $headers .= "Cc: dev@thetranslationgate.com\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $subject = $mailSubject;
        $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                        <title>Nexus | Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        th{
                          border: 1px solid;
                        }
                        td {
                          border: 1px solid;
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                        <p>Dear ' . $emp_name . ',</p>
                         <p>' . $mailBody . '</p>
                        <p>Thank You!</p>
                    </body>
                    </html>';
        // echo $message; 
        mail($mailTo, $subject, $message, $headers);
    }

    // IT
    public function sendITTicketMail($mailSubject, $mailBody, $email_array)
    {

        $mailTo = "help@thetranslationgate.com";
        $from = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";
        foreach ($email_array as $val) {
            $headers .= 'CC: ' . $val . "\r\n";
        }
        $subject = $mailSubject;
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
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        th{
                          border: 1px solid;
                        }
                        td {
                          border: 1px solid;
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                       
                         <p>' . $mailBody . '</p>
                       
                    </body>
                    </html>';
        // echo $message; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function AllTickets_IT($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `it_tickets` WHERE " . $filter . " Order By id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `it_tickets` WHERE " . $filter . " AND emp_id = $this->emp_id Order By id DESC");
        }
        return $data;
    }

    public function AllTicketPages_IT($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `it_tickets` Order By id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `it_tickets` WHERE emp_id = $this->emp_id Order By id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    // service type
    public function allServiceTypes($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `automation_service_types` WHERE " . $filter . " Order By created_at DESC");
        }
        return $data;
    }

    public function allServiceTypesPages($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `automation_service_types` Order By created_at DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function selectServiceTypes($id = "")
    {
        $types = $this->db->get_where('automation_service_types')->result();
        $data = "";
        foreach ($types as $type) {
            if ($type->id == $id) {
                $data .= "<option value='" . $type->id . "' selected='selected'>" . $type->title . "</option>";
            } else {
                $data .= "<option value='" . $type->id . "'>" . $type->title . "</option>";
            }
        }
        return $data;
    }

    public function getServiceType($id)
    {
        $result = $this->db->get_where('automation_service_types', array('id' => $id))->row();
        if (isset($result->title)) {
            return $result->title;
        } else {
            return '';
        }
    }

    public function checkIfSoftwareMember($emp_id)
    {
        $data = false;
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();
        if (isset($result->department)) {
            if ($result->department == 14)
                $data = true;
        }

        return $data;
    }

    public function TicketsCount($permission, $filter, $status)
    {
        if ($filter == '') {
            $filter = '1';
        }
        if ($permission->view == 1) {
            $sql = "SELECT count(id) as total FROM `automation_tickets` WHERE " . $filter . " AND status = $status ";
            $data = $this->db->query($sql)->row()->total;
        } elseif ($permission->view == 2) {
            $sql = "SELECT count(id) as total FROM `automation_tickets` WHERE " . $filter . " AND status = $status AND emp_id = $this->emp_id ";
            $data = $this->db->query($sql)->row()->total;
        }
        return $data;
    }

}