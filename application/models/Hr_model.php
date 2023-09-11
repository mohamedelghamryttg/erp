<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Hr_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function meetingMail($data)
    {
        $attendees = explode(";", $data['attendees']);
        $MailTo = $attendees[0];
        $subject = $data['title'];

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        for ($i = 1; $i < count($attendees); $i++) {
            $headers .= "Cc: " . $attendees[$i] . "\r\n";
        }

        $headers .= "Cc: asmaa.saafan@thetranslationgate.com" . "\r\n";
        $headers .= 'From: asmaa.saafan@thetranslationgate.com' . "\r\n" . 'Reply-To: asmaa.saafan@thetranslationgate.com' . "\r\n";
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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                        ' . $data['description'] . '
                    </body>
                    </html>';

        //echo $message;
        mail($MailTo, $subject, $message, $headers);
    }

    public function meetingMailRemainder($data)
    {
        $MailTo = $data->attendees;
        $subject = $data->title;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: asmaa.saafan@thetranslationgate.com" . "\r\n";
        $headers .= "Cc: mohamed.elshehaby@thetranslationgate.com" . "\r\n";
        $headers .= 'From: asmaa.saafan@thetranslationgate.com' . "\r\n" . 'Reply-To: asmaa.saafan@thetranslationgate.com' . "\r\n";
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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                        <p>This email is just a reminder that the next ' . $data->subject . ' meeting will be held on ' . $data->start . ' in the Meeting Room. </p>
                        <p>Thank You!</p>
                    </body>
                    </html>';

        echo $message;
        mail($MailTo, $subject, $message, $headers);
    }

    public function getDepartment($department)
    {
        $result = $this->db->get_where('department', array('id' => $department))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectDepartment($id = "", $division = 0)
    {
        $department = $this->db->get_where('department', array('brand' => $this->brand, 'division' => $division))->result();
        $data = "<option disabled='disabled' value='' selected=''>-- Select Department --</option>";
        foreach ($department as $department) {
            if ($department->id == $id) {
                $data .= "<option value='" . $department->id . "' selected='selected'>" . $department->name . "</option>";
            } else {
                $data .= "<option value='" . $department->id . "'>" . $department->name . "</option>";
            }
        }
        return $data;
    }

    public function getDivision($division)
    {
        $result = $this->db->get_where('division', array('id' => $division))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectDivision($id = "")
    {
        $division = $this->db->get_where('division', array('brand' => $this->brand))->result();
        $data = "";
        foreach ($division as $division) {
            if ($division->id == $id) {
                $data .= "<option value='" . $division->id . "' selected='selected'>" . $division->name . "</option>";
            } else {
                $data .= "<option value='" . $division->id . "'>" . $division->name . "</option>";
            }
        }
        return $data;
    }

    public function getTitle($title)
    {
        $result = $this->db->get_where('structure', array('id' => $title))->row();
        if (isset($result->title)) {
            return $result->title;
        } else {
            return '';
        }
    }


    public function selectTitle($id = "")
    {
        $title = $this->db->get('structure')->result();
        $data = "";
        foreach ($title as $title) {
            if ($title->id == $id) {
                $data .= "<option value='" . $title->id . "' selected='selected'>" . $title->title . "</option>";
            } else {
                $data .= "<option value='" . $title->id . "'>" . $title->title . "</option>";
            }
        }
        return $data;
    }


    public function selectPosition($id = "", $department = 0, $division = 0)
    {
        $title = $this->db->get_where('structure', array('division' => $division, 'department' => $department, 'brand' => $this->brand))->result();
        $data = "<option disabled='disabled' value='' selected=''>-- Select Position --</option>";
        foreach ($title as $title) {
            if ($title->id == $id) {
                $data .= "<option value='" . $title->id . "' selected='selected'>" . $title->title . "</option>";
            } else {
                $data .= "<option value='" . $title->id . "'>" . $title->title . "</option>";
            }
        }
        return $data;
    }

    public function selectEmployee($id = "")
    {
        $employee = $this->db->get('employees')->result();
        $data = "";
        foreach ($employee as $employee) {
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }
        }
        return $data;
    }

    public function selectTrack($id = "")
    {
        $track = $this->db->get('track')->result();
        $data = "";
        foreach ($track as $track) {
            if ($track->id == $id) {
                $data .= "<option value='" . $track->id . "' selected='selected'>" . $track->name . "</option>";
            } else {
                $data .= "<option value='" . $track->id . "'>" . $track->name . "</option>";
            }
        }
        return $data;
    }

    public function getTrack($track)
    {
        $result = $this->db->get_where('track', array('id' => $track))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }



    public function getEmployee($employee)
    {
        $result = $this->db->get_where('employees', array('id' => $employee))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function AllEmployees($filter)
    {

        // $data = $this->db->query(" SELECT * FROM `employees` WHERE ".$filter." AND brand = '$brand' ORDER BY id ASC , id DESC ");
        $data = $this->db->query(" SELECT * FROM `employees` WHERE " . $filter . " ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllEmployeesPages($limit, $offset)
    {
        //$data = $this->db->query("SELECT * FROM `employees` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        $data = $this->db->query("SELECT * FROM `employees` ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }


    public function AllMedicalInsurance($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `medical_insurance` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllMedicalInsurancePages($brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `medical_insurance` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllStructure($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `structure` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllStructurePages($brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `structure` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllDepartment($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `department` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllDepartmentPages($brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `department` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllDivision($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `division` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllDivisionPages($brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `division` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function attendanceMac($permission, $filter)
    {
        if ($permission->view == 1) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://attendance.thetranslationgate.com/abc/index.php/api/attendanceLog");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //      	curl_setopt($cURL_Handle, CURLOPT_BUFFERSIZE, 1000000);
            // curl_setopt($cURL_Handle, CURLOPT_NOPROGRESS, false);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "filter=$filter");
            $data = json_decode(curl_exec($ch), TRUE);
        } elseif ($permission->view == 2) {
            $userData = $this->db->get_where('users', array('id' => $this->user))->row()->employees_id;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://attendance.thetranslationgate.com/abc/index.php/api/attendanceLogByUser");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //      	curl_setopt($cURL_Handle, CURLOPT_BUFFERSIZE, 1000000);
            // curl_setopt($cURL_Handle, CURLOPT_NOPROGRESS, false);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "filter=$filter&USRID=$userData");
            $data = json_decode(curl_exec($ch), TRUE);
        }
        return $data;
    }

    public function attendance($permission, $filter)
    {
        if ($permission->view == 1) {
            //All ..
            $attendanceArr = array();

            $data = $this->db->query(" SELECT DISTINCT USRID,(SELECT SRVDT FROM attendance_log AS log WHERE log.USRID = l.USRID AND TNAKEY = '1' AND DATE(log.SRVDT) = DATE(l.SRVDT) 
            							ORDER BY log.id ASC LIMIT 1) AS SignIn FROM attendance_log AS l
         								WHERE " . $filter . "")->result();
        } elseif ($permission->view == 2) {
            //BY USER ..
            $userData = $this->db->get_where('users', array('id' => $this->user))->row()->employees_id;
            $data = $this->db->query(" SELECT DISTINCT USRID,(SELECT SRVDT FROM attendance_log AS log WHERE log.USRID = l.USRID AND TNAKEY = '1' AND DATE(log.SRVDT) = DATE(l.SRVDT) 
            							ORDER BY log.id ASC LIMIT 1) AS SignIn FROM attendance_log AS l
         								WHERE " . $filter . " AND l.USRID = '$userData'")->result();
        }
        return $data;
    }

    public function remoteAttendance($data)
    {
        $SRVDT = $data['SRVDT'];
        $USRID = $data['USRID'];
        $TNAKEY = $data['TNAKEY'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://attendance.thetranslationgate.com/abc/index.php/api/remoteAttendance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "SRVDT=$SRVDT&USRID=$USRID&TNAKEY=$TNAKEY");
        $data = curl_exec($ch);
        return $data;
    }

    ////////
    //vacation
    //start vacation
    public function selectAllVacationTypies($id = '')
    {
        $vacation_types = $this->db->query("SELECT * FROM vacation_types")->result();
        $data = "";
        foreach ($vacation_types as $vacation_types) {
            if ($vacation_types->id == $id) {
                $data .= "<option value='" . $vacation_types->id . "' selected='selected'>" . $vacation_types->name . "</option>";
            } else {
                $data .= "<option value='" . $vacation_types->id . "'>" . $vacation_types->name . "</option>";
            }
        }
        return $data;
    }
    public function getAllVacationTypies($id = '')
    {
        $vacation_types = $this->db->query("SELECT * FROM vacation_types WHERE id = '$id'")->row();
        if (isset($vacation_types->name)) {
            return $vacation_types->name;
        } else {
            return '';
        }

    }

    public function getRequestsForDirectManager($emp_id)
    {
        $title = $this->db->query(" SELECT title FROM employees WHERE id = '$emp_id' ")->row()->title;
        if ($title == 37) {
            /* $data = $this->db->query("SELECT * FROM vacation_transaction WHERE emp_id in (SELECT id FROM employees WHERE title in(11,15,16,17,28,37,40,44,48,51,54,56,59))");*/
            $data = $this->db->query("SELECT * FROM vacation_transaction WHERE emp_id in (SELECT id FROM employees WHERE manager in(13,14) || title in (SELECT id FROM structure WHERE parent = (SELECT title FROM employees WHERE id = '$emp_id')) )HAVING status = 0 ");
        } else {
            $data = $this->db->query("SELECT * FROM vacation_transaction WHERE emp_id in (SELECT id FROM employees WHERE title in (SELECT id FROM structure WHERE parent = (SELECT title FROM employees WHERE id = '$emp_id'))) HAVING status = 0 ");
        }
        return $data;
    }
    public function getManagerId($emp_id)
    {
        $data = $this->db->query("SELECT id From employees WHERE title = (SELECT parent FROM structure WHERE id = (SELECT title FROM employees WHERE id = '$emp_id'))");
        return $data->row()->id;
    }

    public function getUser($emb_id)
    {
        $result = $this->db->get_where('users', array('employees_id' => $emb_id))->row();
        if (isset($result->user_name)) {
            return $result->user_name;
        } else {
            return '';
        }
    }
    ///5/8/2020
    public function getEmpName($emb_id)
    {
        $result = $this->db->get_where('employees', array('id' => $emb_id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }
    public function getEmpId($user_id)
    {
        $result = $this->db->get_where('users', array('id' => $user_id))->row();
        if (isset($result->employees_id)) {
            return $result->employees_id;
        } else {
            return '';
        }
    }
    //vacation status
    public function getVacationStatus($select = "")
    {
        if ($select == 1) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #07b817">approved</span>';
        } else if ($select == 2) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } else if ($select == 0) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #e8e806">Waiting Confirmation</span>';
        } else {
            $outpt = "";
        }
        return $outpt;
    }


    public function calculateAvailableVacationDays($type_of_vacation, $id, $death_leave_degree)
    {
        ///to retrive the balance for employees  (avialable days)
        /// get availabale credite of days depend on the vacation type 
        $year = date("Y");
        $data = $this->db->query(" SELECT * FROM vacation_balance WHERE emp_id = '$id' AND year = '$year'");
        if ($type_of_vacation == 1) {
            //annual leave
            $month = date('m');
            if ($month <= 3) {
                return $data->row()->current_year + $data->row()->previous_year;
            } else {
                return $data->row()->current_year;
            }

        } elseif ($type_of_vacation == 2) {
            //casual leave
            // depend on balance "21 * 3.5 " & max = 6 
            // get all balance 
            $allBalance = $data->row()->current_year + $data->row()->casual_leave + $data->row()->annual_leave;
            if ($allBalance >= 21) {
                $casual_limit = 6;
            } else {
                $casual_limit = round($allBalance / 3.5 * 2) / 2;
            }
            $remainOfCasual = $casual_limit - $data->row()->casual_leave;
            $total_balance = $data->row()->current_year;
            if ($total_balance >= 0) {
                $totalRemaining = $total_balance - $remainOfCasual;
                if ($totalRemaining > 0) {
                    return $remainOfCasual;
                } elseif ($totalRemaining <= $remainOfCasual) {

                    return $total_balance;
                }
            } else {
                return $data;
            }
        } elseif ($type_of_vacation == 3) {
            //for sick leave
            return $data->row()->sick_leave;
        } elseif ($type_of_vacation == 4) {
            //for mariage leave
            return $data->row()->marriage;
        } elseif ($type_of_vacation == 5) {
            //for Maternity Leave
            return $data->row()->maternity_leave;
        } elseif ($type_of_vacation == 6) {
            //for Death Leave
            if ($death_leave_degree == 1) {
                return 3;
            } elseif ($death_leave_degree == 2) {
                return 1;
            }
        } elseif ($type_of_vacation == 7) {
            //for Hajj 
            return $data->row()->hajj;
        } elseif ($type_of_vacation == 8) {
            //for rest leave
            return 365;
        }
    }
    public function checkVacationCredite($type_of_vacation, $days, $id)
    {
        //to check if the employee has engouph credit to suptract the days from  
        //$data = $this->db->query(" SELECT * FROM vacation_balance WHERE emp_id = (SELECT employees_id FROM users WHERE id = '$id')");
        $year = date("Y");
        $data = $this->db->query(" SELECT * FROM vacation_balance WHERE emp_id = '$id' AND year = '$year'");
        if ($type_of_vacation == 1) {
            //annual leave 
            $month = date('m');
            if ($month <= 3) {
                return ($data->row()->current_year + $data->row()->previous_year) - $days;
            } else {
                return $data->row()->current_year - $days;
            }

        } elseif ($type_of_vacation == 2) {
            //casual leave
            // depend on balance "21 * 3.5 " & max = 6 
            // get all balance 
            $allBalance = $data->row()->current_year + $data->row()->casual_leave + $data->row()->annual_leave;
            if ($allBalance >= 21) {
                $casual_limit = 6;
            } else {
                $casual_limit = round($allBalance / 3.5 * 2) / 2;
            }
            $remainOfCasual = $casual_limit - $data->row()->casual_leave;
            $total_balance = $data->row()->current_year;
            if ($total_balance >= 0) {
                $totalRemaining = $total_balance - $remainOfCasual;
                if ($totalRemaining > 0) {
                    return $remainOfCasual - $days;
                } elseif ($totalRemaining <= $remainOfCasual) {
                    return $total_balance - $days;
                }
            } else {
                return $data;
            }
        } elseif ($type_of_vacation == 3) {
            //for sick leave
            return $data->row()->sick_leave - $days;
        } elseif ($type_of_vacation == 4) {
            //for mariage leave
            return $data->row()->marriage;
        } elseif ($type_of_vacation == 5) {
            //for Maternity Leave
            return $data->row()->maternity_leave;
        } elseif ($type_of_vacation == 7) {
            //for Hajj 
            return $data->row()->hajj;
        } elseif ($type_of_vacation == 8) {
            //for rest leave
            return 365;
        }

    }
    public function updataVacationBalance($days, $id, $typeOfVacation)
    {
        //$credite = $this->db->get_where('vacation_balance',array('emp_id'=>$id))->row();
        $year = date("Y");
        $credite = $this->db->query(" SELECT * FROM vacation_balance WHERE emp_id = '$id' AND year = '$year'")->row();
        $month = date('m');
        if ($typeOfVacation == 1) {
            //annual
            $data['annual_leave'] = $credite->annual_leave + $days;
            if ($credite->previous_year > 0 && $month <= 3) {
                if ($days <= $credite->previous_year) {
                    $data['previous_year'] = $credite->previous_year - $days;
                } else {
                    $temp = $days - $credite->previous_year;
                    $this->db->query("UPDATE vacation_balance SET previous_year = '0' WHERE emp_id = '$id' AND year = '$year'");
                    $data['current_year'] = $credite->current_year - $temp;
                }
            } else {
                $data['current_year'] = $credite->current_year - $days;
            }
            $this->db->update('vacation_balance', $data, array('emp_id' => $id, 'year' => $year));
            // $this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);

        } elseif ($typeOfVacation == 2) {
            //casual
            $data['casual_leave'] = $credite->casual_leave + $days;

            $data['current_year'] = $credite->current_year - $days;
            $this->db->update('vacation_balance', $data, array('emp_id' => $id, 'year' => $year));
            //$this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        } elseif ($typeOfVacation == 3) {
            //sick
            $data['sick_leave'] = $credite->sick_leave - $days;
            $this->db->update('vacation_balance', $data, array('emp_id' => $id, 'year' => $year));
            //$this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        } elseif ($typeOfVacation == 4) {
            //mariage
            $this->db->query("UPDATE vacation_balance SET marriage = '0' WHERE emp_id = '$id' AND year = '$year'");
            // $this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        } elseif ($typeOfVacation == 5) {
            //maternity
            $this->db->query("UPDATE vacation_balance SET maternity_leave = '0' WHERE emp_id = '$id' AND year = '$year'");
            // $this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        } elseif ($typeOfVacation == 6) {
            //death
            $data['death_leave'] = $credite->death_leave + $days;
            $this->db->update('vacation_balance', $data, array('emp_id' => $id, 'year' => $year));
            // $this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        } elseif ($typeOfVacation == 7) {
            //hajj
            $this->db->query("UPDATE vacation_balance SET hajj = '0' WHERE emp_id = '$id' AND year = '$year'");
            // $this->admin_model->addToLoggerUpdate('vacation_balance',143,'id',$this->db->insert_id(),102,102,$this->user);
        }
    }
    public function getRequestedDays($start_date, $end_date, $type_of_vacation = "0", $day_type = "")
    {
        //calculate number of days with out sat and sun
        $diff = strtotime($end_date) - strtotime($start_date);
        $size = (floor($diff / (60 * 60 * 24))) + 1;
        $arr = [];
        for ($i = 0; $i < $size; $i++) {
            $startDateToTimestamp = strtotime($start_date . ' + ' . $i . ' days');
            $day = date('D', $startDateToTimestamp);
            // 
            $end_date_format = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

            $holidays = $this->db->query("SELECT * FROM `holidays_plan` where holiday_date = '$end_date_format'")->num_rows();
            //
            if ($type_of_vacation != 3) {
                if ($day == 'Sat' || $day == 'Sun' || $holidays > 0) {
                    continue;
                }
            }

            $arr[] = $day;
        }
        $data = sizeof($arr);
        if ($day_type == "1" & $data > 0) {
            $data = 0.5;
        }
        //    $holidays = $this->db->query("SELECT * FROM `holidays_plan` where holiday_date BETWEEN '$start_date' AND '$end_date'")->num_rows();
        //    $lastData = $data - $holidays;
        // return $lastData;
        return $data;
    }
    public function getEndDate($type_of_vacation, $start_date, $end_date = "0", $death_leave_degree = "")
    {
        //calculate end date dependon type of vacation with out date and time 
        if ($type_of_vacation == 4) {
            //mariage end date after 5 days without sat and sun
            $arr = [];
            $size = 5;
            for ($i = 0; $i < $size; $i++) {
                $startDateToTimestamp = strtotime($start_date . ' + ' . $i . ' days');
                $day = date('D', $startDateToTimestamp);
                $end_date_format = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));

                $holidays = $this->db->query("SELECT * FROM `holidays_plan` where holiday_date = '$end_date_format'")->num_rows();

                if ($day == 'Sat' || $day == 'Sun' || $holidays > 0) {
                    $size++;
                    continue;
                }
                $arr[] = $end_date_format;
            }
            $endDate = array_pop($arr);
        } elseif ($type_of_vacation == 5) {
            //matrinety leave for 3 month as 90 days
            $endDate = date('Y-m-d', strtotime($start_date . ' + 90 days'));
        } elseif ($type_of_vacation == 6) {
            //death leave depend on relative degree
            if ($death_leave_degree == 1) {
                $arr = [];
                $size = 3;
                for ($i = 0; $i < $size; $i++) {
                    $startDateToTimestamp = strtotime($start_date . ' + ' . $i . ' days');
                    $day = date('D', $startDateToTimestamp);
                    $end_date_format = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));
                    $holidays = $this->db->query("SELECT * FROM `holidays_plan` where holiday_date = '$end_date_format'")->num_rows();
                    if ($day == 'Sat' || $day == 'Sun' || $holidays > 0) {
                        $size++;
                        continue;
                    }
                    $arr[] = $end_date_format;
                }
                $endDate = array_pop($arr);
            } elseif ($death_leave_degree == 2) {
                $arr = [];
                $size = 1;
                for ($i = 0; $i < $size; $i++) {
                    $startDateToTimestamp = strtotime($start_date . ' + ' . $i . ' days');
                    $day = date('D', $startDateToTimestamp);
                    $end_date_format = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));
                    $holidays = $this->db->query("SELECT * FROM `holidays_plan` where holiday_date = '$end_date_format'")->num_rows();
                    if ($day == 'Sat' || $day == 'Sun' || $holidays > 0) {
                        $size++;
                        continue;
                    }
                    $arr[] = $end_date_format;
                }
                $endDate = array_pop($arr);
            }
        } elseif ($type_of_vacation == 7) {
            //hajj leave for 1 month as 30 days
            $endDate = date('Y-m-d', strtotime($start_date . ' + 30 days'));
        } else {
            $endDate = $end_date;
        }
        return $endDate;
    }
    ///on approve vacation request
    public function onApprove($start_date, $end_date, $emp_id)
    {
        $data = $this->db->query("SELECT * FROM `vacation_transaction` WHERE emp_id = '$emp_id' and status = 1 ")->result();
        $counter = 0;
        foreach ($data as $data) {
            $oldRequest = $this->hr_model->getArrayOfRequestedDays($data->start_date, $data->end_date);
            $newRequest = $this->hr_model->getArrayOfRequestedDays($start_date, $end_date);
            for ($i = 0; $i < sizeof($newRequest); $i++) {
                if (in_array($newRequest[$i], $oldRequest, true)) {
                    $counter = $counter + 1;

                }
            }
        }
        return $counter;
    }

    // public function validateVacRequestedDays($start_date,$end_date,$emp_id){
    //     $data = $this->db->query("SELECT * FROM `vacation_transaction` WHERE emp_id = '$emp_id' AND (start_date <= '$start_date' AND end_date >= '$end_date') AND status = 1 ")->num_rows();
    //     return $data;
    // }
    public function getArrayOfRequestedDays($start_date, $end_date)
    {
        //to return array of days at request
        $diff = strtotime($end_date) - strtotime($start_date);
        $size = (floor($diff / (60 * 60 * 24))) + 1;
        $arr = [];
        for ($i = 0; $i < $size; $i++) {
            $startDateToTimestamp = strtotime($start_date . ' + ' . $i . ' days');
            $day = date('Y-m-d', $startDateToTimestamp);
            $arr[] = $day;
        }
        $data = $arr;
        return $data;
    }

    //////  ///end vacation

    public function selectEmployeeForVT($id = "")
    {
        $employee = $this->db->get('employees')->result();
        $data = "";
        foreach ($employee as $employee) {
            $excist = $this->db->query("SELECT * FROM vacation_balance WHERE emp_id = '$employee->id'")->row();
            if ($excist) {
                continue;
            }
            if ($employee->status == 1) {
                continue;
            }
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }
        }
        return $data;
    }



    public function AllVacationBalance($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `vacation_balance` WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vacation_balance` WHERE brand = '$brand' AND created_by ='$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }
    public function AllVacationBalancePages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `vacation_balance` WHERE brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vacation_balance` WHERE brand = '$brand' AND created_by ='$user' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }

    ////

    public function AllMissingAttendance($permission, $user, $filter)
    {
        $emp = $this->db->get_where('users', array('id' => $user))->row()->employees_id;
        if ($permission->view == 1) {
            // $data = $this->db->query("SELECT * FROM `missing_attendance` ");
            if ($this->role == 31) {
                $data = $this->db->query(" SELECT * FROM `missing_attendance` WHERE " . $filter . " ");
            } else {
                $data = $this->db->query(" SELECT * FROM `missing_attendance` WHERE " . $filter . " AND USRID ='$emp'");
            }
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `missing_attendance` WHERE " . $filter . " AND USRID ='$emp'");
        }
        return $data;
    }
    public function AllMissingAttendancePages($permission, $user, $limit, $offset)
    {
        $emp = $this->db->get_where('users', array('id' => $user))->row()->employees_id;
        if ($permission->view == 1) {
            //$data = $this->db->query("SELECT * FROM `missing_attendance` ");
            if ($this->role == 31) {
                $data = $this->db->query(" SELECT * FROM `missing_attendance` ORDER BY id DESC LIMIT $limit OFFSET $offset");
            } else {
                $data = $this->db->query(" SELECT * FROM `missing_attendance` WHERE USRID ='$emp' ORDER BY id DESC LIMIT $limit OFFSET $offset");
            }
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `missing_attendance` WHERE USRID ='$emp' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }
    //////////

    public function getTitleData($title)
    {
        $structure = $this->db->get_where('structure', array('id' => $title, 'brand' => $this->brand))->row();

        $data = "<table class='table table-striped table-hover table-bordered' style='overflow:scroll;'>
                    <thead>
                    <tr>
                        <th>Track</th>
                        <th>Direct Manager Title</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>" . self::getTrack($structure->track) . "</td>
                        <td>" . self::getTitle($structure->parent) . "</td>
                    </tr>
                    </tbody>
                </table>";
        return $data;
    }

    public function getDirectManagerByTitle($title)
    {
        $structure = $this->db->get_where('structure', array('id' => $title, 'brand' => $this->brand))->row();
        $manager = $this->db->get_where('employees', array('title' => $structure->parent, 'brand' => $this->brand))->result();
        //$data = "<option disabled='disabled' selected=''>-- Select Manager --</option>";
        foreach ($manager as $manager) {
            if ($manager->id == $title) {
                $data = "<option value='" . $manager->id . "' selected='selected'>" . $manager->name . "</option>";
            } else {
                $data = "<option value='" . $manager->id . "'>" . $manager->name . "</option>";
            }
        }
        return $data;
    }
    ////social insurance 
    public function AllSocialInsurance($permission, $user, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `social_insurance` WHERE " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `social_insurance` WHERE created_by ='$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }
    public function AllSocialInsurancePages($permission, $user, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `social_insurance` ORDER BY id DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `social_insurance` WHERE created_by ='$user' ");
        }
        return $data;
    }

    public function selectEmployeeForSocialInsurance($id = "")
    {
        $employees = $this->db->get('employees')->result();
        $data = "";
        foreach ($employees as $employee) {
            $excist = $this->db->query("SELECT * FROM social_insurance WHERE employee_id = '$employee->id'")->row();
            if ($excist) {
                continue;
            }
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }
        }
        return $data;
    }
    ////for strucure tree view
    /* public function getChild($title="")
    {
        $child = $this->db->query("SELECT * From structure WHERE parent = '$title'")->result();
        $data = "";
        foreach ($child as $child) {
         //$data .= "<h5>". $child->title . "</h5>";
           $data .= "<h5 onclick='get_grand_child()'>". $child->title . "</h5>";
          $data .= "<div id='item2' style='display: none; padding-left: 25px'>"
                         . self::getGrandChild($child->id). 
                    "</div>";
        }
       return $data;

    }
     public function getGrandChild($title="")
    {
        $grandChild = $this->db->query("SELECT * From structure WHERE parent = '$title'")->result();
        $data = "";
        foreach ($grandChild as $child) {
           $data .= "<h6>". $child->title . "</h6>";
           // $data .= "test";
          
        }
        return $data;

    }*/

    public function selectYear($id = "")
    {
        $year = $this->db->get('years')->result();
        $data = "";
        foreach ($year as $year) {
            if ($year->id == $id) {
                $data .= "<option value='" . $year->id . "' selected='selected'>" . $year->name . "</option>";
            } else {
                $data .= "<option value='" . $year->id . "'>" . $year->name . "</option>";
            }
        }
        return $data;
    }


    public function getYear($year)
    {

        $result = $this->db->get_where('years', array('id' => $year))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function AllHolidayPlan($filter)
    {
        $data = $this->db->query(" SELECT * FROM `holidays_plan` WHERE " . $filter . " ORDER BY holiday_date DESC ");
        return $data;
    }

    public function AllHolidayPlanPages($limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `holidays_plan` ORDER BY holiday_date DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllVacationRequests($filter)
    {
        $data = $this->db->query("SELECT * FROM `vacation_transaction` WHERE " . $filter . " ORDER BY id DESC ");
        return $data;
    }
    public function AllVacationRequestsPages($limit, $offset)
    {

        $data = $this->db->query(" SELECT * FROM `vacation_transaction` ORDER BY id DESC LIMIT $limit OFFSET $offset");
        return $data;
    }
    //missing attendance 
    public function getMissingAttendanceRequests($emp_id, $title, $start_date = 0, $end_date = 0)
    {
        if ($title == 37 || $title == 123) {
            $data = $this->db->query("SELECT * FROM missing_attendance WHERE (manager_approval = 0 ) AND SRVDT BETWEEN '$start_date' AND '$end_date' ORDER BY `missing_attendance`.`SRVDT` ASC");
        } else {
            $data = $this->db->query("SELECT * FROM missing_attendance WHERE USRID in (SELECT id FROM employees WHERE manager = '$emp_id' ) HAVING manager_approval = 0  ");
        }
        return $data;
    }

    //
    public function getResignationReason($id)
    {
        $result = $this->db->get_where('resignation_reasons', array('id' => $id))->row();
        if (isset($result->reason)) {
            return $result->reason;
        } else {
            return '';
        }
    }


    public function selectResignationReason($id = "")
    {
        $reasons = $this->db->get('resignation_reasons')->result();
        $data = "";
        foreach ($reasons as $reason) {
            if ($reason->id == $id) {
                $data .= "<option value='" . $reason->id . "' selected='selected'>" . $reason->reason . "</option>";
            } else {
                $data .= "<option value='" . $reason->id . "'>" . $reason->reason . "</option>";
            }
        }
        return $data;
    }

    //// 

    public function sendMissingAttendanceRequestMail($data, $brand)
    {
        $managerId = $this->hr_model->getManagerId($data['USRID']);
        $managerMail = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->email;
        $managerName = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->first_name;
        $employeeMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $mailTo = $managerMail;
        if ($data['TNAKEY'] == 1) {
            $TNAKEY = "Sign In";
        } elseif ($data['TNAKEY'] == 2) {
            $TNAKEY = "Sign Out";
        }
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //$headers .= "Cc: ".$employeeMail."\r\n";
        $headers .= 'From: ' . $employeeMail . "\r\n";

        $subject = "New Missing Attendance Request ";

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
                     <p> Hello ' . $managerName . ' , </P>
                    <p> There is Missing Attendance Request from ' . self::getEmployee($data['USRID']) . ' need to be <a href="' . base_url() . 'hr/attendance" target="_blank"> Approved ..</a>  </p>
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                        
                         <th>Employee Name</th>
                         <th>Date </th>
                         <th>Sign In/Out</th>

                       
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>' . self::getEmployee($data['USRID']) . '</td>
                        <td>' . $data['SRVDT'] . '</td>
                        <td>' . $TNAKEY . '</td>
                      </tr>
                      </tbody>
                    </table> 

                     <p> Thank you, </p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    ///

    public function sendVacationRequestMail($data, $brand)
    {
        $managerId = $this->hr_model->getManagerId($data['emp_id']);
        $managerMail = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->email;
        $managerName = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->first_name;
        $employeeMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $mailTo = $managerMail;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //$headers .= "Cc: ".$employeeMail."\r\n";
        $headers .= 'From: ' . $employeeMail . "\r\n";

        $subject = "New Vacation Request ";

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
                    <p> Hello ' . $managerName . ' , </P>
                    <p> There is Vacation Request from ' . self::getEmployee($data['emp_id']) . ' need to be <a href="' . base_url() . 'hr/vacation" target="_blank"> Approved ..</a>  </p>
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                        
                            <th>Employee Name</th>
                            <th>Type of vacation</th>
                            <th>Start Date</th>
                            <th>End Date</th>       
                                     

                       
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>' . self::getEmployee($data['emp_id']) . '</td>
                        <td>' . self::getAllVacationTypies($data['type_of_vacation ']) . '</td>
                        <td>' . $data['start_date'] . '</td>
                        <td>' . $data['end_date'] . '</td>
                      </tr>
                      </tbody>
                    </table> 

                     <p> Thank you, </p>
                    </body>
                    </html>';
        mail($mailTo, $subject, $message, $headers);
    }
    //
    // public function getDoubleDaysEmployeeData($emp_id,$brand){
    //     $data = $this->db->query(" SELECT * FROM `employees` where id = '$emp_id'")->row();
    //     if($data->brand == 2){
    //        return false;
    //     }elseif ($data->brand == 1) {
    //           if($data->division == 4){
    //            return false;
    //           }else{
    //            return true;
    //           }
    //      }
    // }
    ///// for pm vacation plan


    public function AllPmVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '1' OR group_id = '2' OR group_id = '3' OR group_id = '7'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }
    //  public function AllPmVacationPlan($permission,$user,$brand,$region){
    //      if($permission->view == 1){
    //         $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE region = '$region' HAVING brand = '$brand' ORDER BY id DESC ");
    //     }elseif($permission->view == 2){
    //         $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE created_by ='$user' AND region = '$region' HAVING brand = '$brand' ");
    //     }
    //     return $data;
    // }


    public function calculateRequestedDaysForPmVacationPlane($user_id, $quarter, $edit = "", $id = "")
    {
        if ($edit == 1) {
            $data = $this->db->query("SELECT p.requested_days,QUARTER(p.date_from) AS quarter_number FROM `pm_vacation_plan`AS p WHERE p.created_by = '$user_id' AND p.id != '$id' HAVING quarter_number = '$quarter'  ")->result();
        } else {
            $data = $this->db->query("SELECT p.requested_days,QUARTER(p.date_from) AS quarter_number FROM `pm_vacation_plan`AS p WHERE p.created_by = '$user_id' HAVING quarter_number = '$quarter'  ")->result();
        }
        $counter = 0;
        foreach ($data as $d) {
            $counter = $counter + $d->requested_days;
        }
        return $counter;
    }
    public function checkForPmsVacationPlansAtSameRegion($start_date, $end_date, $group_id, $edit = "", $id = "")
    {
        if ($edit == 1) {
            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' AND id != '$id' ")->result();
        } else {
            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ")->result();
        }
        $counter = 0;
        foreach ($data as $data) {
            $oldRequest = $this->hr_model->getArrayOfRequestedDays($data->date_from, $data->date_to);
            $newRequest = $this->hr_model->getArrayOfRequestedDays($start_date, $end_date);
            for ($i = 0; $i < sizeof($newRequest); $i++) {
                if (in_array($newRequest[$i], $oldRequest, true)) {
                    $counter = $counter + 1;

                }
            }
        }
        return $counter;
    }
    ////
    // Vm Vacations Plan
    public function AllVmVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '4'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }
    // Qa Vacations Plan
    public function AllQaVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '5'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }
    // Automation Vacations Plan
    public function AllAutomationVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '6'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }


    //////


    //////

    // DTP Vacations Plan
    public function AllDTPVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '10'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }
    // LE Vacations Plan
    public function AllLEVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '9'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }
    // Translation Vacations Plan
    public function AllTranslationVacationPlan($permission, $group_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_vacation_plan` WHERE group_id = '8'");
        } elseif ($permission->view == 2) {

            $data = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE group_id = '$group_id' ");
        }
        return $data;
    }

    //get vacaction requests
    public function getVacationRequest($filter, $limit, $offset)
    {
        $data = $this->db->select('v.*')->from('pm_vacation_plan As v')
            ->join('users AS u', 'v.created_by=u.id')->join("employees As e", "u.employees_id=e.id")->where($filter)->order_by('v.id', 'DESC')->limit($limit, $offset)->get();
        var_dump($filter);
        return $data;
    }



    ///KPI Module
    public function selectAllEmployeesByManagerID($emp_id, $id = "")
    {
        $employees = $this->db->query("SELECT * FROM employees WHERE manager = '$emp_id'AND status = '0'")->result();
        $data = "";
        foreach ($employees as $employee) {
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }

        }
        return $data;
    }
    public function selectAllEmployeesByTitle($emp_id = "", $title = "")
    {
        if (!empty($emp_id) && $emp_id != 'none') {
            $employees = $this->db->query("SELECT DISTINCT title FROM employees WHERE manager = '$emp_id' and status = 0")->result();
        } else {
            $employees = $this->db->query("SELECT DISTINCT title FROM employees WHERE status = 0")->result();
        }
        //$employees = $this->db->query("SELECT * FROM employees WHERE manager = '$emp_id'")->result();
        // $employees = $this->db->query("SELECT DISTINCT title FROM employees WHERE manager = '$emp_id' and status = 0")->result();

        $data = "";
        foreach ($employees as $employee) {
            if ($employee->title == $title) {
                $data .= "<option value='" . $employee->title . "' selected='selected'>" . $this->getTitle($employee->title) . "</option>";
            } else {
                $data .= "<option value='" . $employee->title . "'>" . $this->getTitle($employee->title) . "</option>";
            }

        }
        return $data;
    }

    public function getEmployeesNameByTitle($title = "")
    {

        // $employees = $this->db->query("SELECT *  FROM employees WHERE title = '$title' and status = 0")->result();
        // $data = "";
        // foreach ($employees as $employee) {
        //     if ($employee->title == $title) {
        //         $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
        //      }else {
        //         $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
        //     }

        // }
        // return $data;
        $data = $this->db->query("SELECT *  FROM employees WHERE title = '$title' and status = 0")->result();
        return $data;
    }
    public function AllKpi($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `kpi` WHERE " . $filter . " Order By Id Desc");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `kpi` WHERE " . $filter . " AND (manager_id = $this->emp_id or employee_title = (SELECT title  FROM employees WHERE id = $this->emp_id)) Order By Id Desc");
        }
        return $data;
    }
    public function AllKpiPages($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `kpi` Order By Id Desc LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `kpi` where manager_id = $this->emp_id or employee_title = (SELECT title  FROM employees WHERE id = $this->emp_id)  Order By Id Desc LIMIT $limit OFFSET $offset");
        }
        return $data;
    }

    public function getKpi($kpiId)
    {
        $data = $this->db->query("SELECT * from kpi WHERE id = '$kpiId'")->row();
        return $data;
    }

    public function getCoreheaders($kpiId)
    {
        $data = $this->db->query("SELECT * from kpi_core WHERE kpi_id = '$kpiId'")->result();
        return $data;
    }

    //    public function getCoreheaders($employee_title){
//        $data =  $this->db->query("SELECT * from kpi_core WHERE employee_title = '$employee_title'")->result();
//       
//        return $data;        
//        
//    }
    public function drawKpiScoreTable($employee_title, $year, $month, $employee_name)
    {
        $data = "";
        //  $kpi =  $this->db->query("SELECT * from kpi  WHERE employee_title = '$employee_title' and year ='$year' and month ='$month'")->row();
        $kpi = $this->db->query("SELECT * from kpi  WHERE employee_title = '$employee_title' AND active = 1 ")->row();

        if ($kpi) {
            $core_headers = $this->hr_model->getCoreheaders($kpi->id);
            $total_weight = $this->db->query("SELECT sum(`weight`)as total From kpi_sub WHERE kpi_core_id IN (SELECT id From kpi_core WHERE kpi_id = '$kpi->id')")->row();
            if ($total_weight->total != 100) {
                $data .= "<tr>";
                $data .= "<td colspan='6' class='bg-danger-o-10 text-center'><h4 class='text-danger'>Warning! Kpi Weight not equal 100 ,please Fix</h4></td>";
                $data .= "</tr>";
            }
            foreach ($core_headers as $key => $value) {
                $sub = $this->db->query("SELECT * From kpi_sub WHERE kpi_core_id = '$value->id'")->result();
                $data .= "<tr>";
                $data .= "<td colspan='6'><h4 class='text-success'>" . $value->core_name . "</h4></td>";
                $data .= "</tr>";
                foreach ($sub as $key => $val) {
                    $logData = "";
                    if (!empty($employee_name) && !empty($month)) {
                        $logs = $this->db->query("SELECT count(id) as log_count FROM `kpi_incidents_log` WHERE emp_id = $employee_name AND MONTH(date) = $month AND  kpi_sub_id = $val->id")->row();
                        if ($logs->log_count > 0) {
                            $logData = "<a target='_blank' title='$logs->log_count Incident(s),Click to view...' href='" . base_url() . "performanceManagment/viewEmployeeincidentLog/$employee_name/$month/$val->id'> <i class='fa fa-info-circle text-danger'></i></a>";
                        }
                    }
                    $data .= "<tr>";
                    $data .= "<input class='form-control' type='text' name='sub_id' value='" . $val->id . "' hidden>";
                    $data .= "<td width='30%'><p>" . $val->sub_name . $logData . "</p></td>";
                    $data .= "<td><div class='input-group'>
                                    <input class='form-control weight' type='number' min='1' max='100' id='weight_" . $val->id . "' name='weight_" . $val->id . "' value='" . $val->weight . "' onchange='calculateScore(" . $val->id . ");' required>
                                    <div class='input-group-append'>
                                        <span class='input-group-text' id='basic-addon2'>%</span>
                                    </div>
                                </div></td>";
                    $data .= "<td><div class='input-group'>
                                    <input class='form-control' type='number'  min='1' id='target_" . $val->id . "' name='target_" . $val->id . "' value='" . $val->target . "'onchange='calculateScore(" . $val->id . ");'  required>
                                    <div class='input-group-append'>
                                        <span class='input-group-text' id='basic-addon2'>" . $val->target_type . "</span>
                                    </div>
                                </div></td>";
                    $data .= "<td><div class='input-group'>
                                   <input class='form-control' type='number' min='0' id='achieved_" . $val->id . "' name='achieved_" . $val->id . "' onchange='calculateScore(" . $val->id . ");' value='' required>
                                    <div class='input-group-append'>
                                        <span class='input-group-text' id='basic-addon2'>" . $val->target_type . "</span>
                                    </div>
                                </div></td>";
                    $data .= "<td> <div class='input-group'>
                                    <input class='form-control' type='text' id='score_" . $val->id . "' name='score_" . $val->id . "' value='' readonly >
                                    <div class='input-group-append'>
                                        <span class='input-group-text' id='basic-addon2'>%</span>
                                    </div>
                                </div> </td>";
                    $data .= "<td><textarea class='form-control' name='comment_" . $val->id . "'></textarea></td>";
                    $data .= "</tr>";
                }

            }
            $data .= "<tr><td><input class='form-control' type='text' name='kpi_id' value='" . $kpi->id . "' hidden></td></tr>";
        }

        return $data;
    }

    public function AllKpiScore($permission, $filter)
    {
       
    //	  $check = $this->admin_model->getUserEmployees2Level($this->emp_id);
     //   if($check != false)
    //        $where2Level = " OR emp_id IN ($check)";
     //   else
      //      $where2Level="";
    
        if ($permission->view == 2) {
            $data = $this->db->query("SELECT id,emp_id,year,month,kpi_id,created_by FROM `kpi_score` WHERE " . $filter . " AND emp_id = $this->emp_id Order By Id Desc");
        } else if ($permission->view == 1) {
            //follow team  leader & view all
            if ($permission->follow == 2) {
                $data = $this->db->query("SELECT id,emp_id,year,month,kpi_id,created_by FROM `kpi_score` WHERE " . $filter . " AND created_by = $this->user   Order By Id Desc");
            } else {
                $data = $this->db->query("SELECT id,emp_id,year,month,kpi_id,created_by FROM `kpi_score` WHERE " . $filter . " Order By Id Desc ");
            }
        }
        return $data;
    }

    public function AllKpiScorePages($permission, $limit, $offset)
    {	  
    	//$check = $this->admin_model->getUserEmployees2Level($this->emp_id);
       // if($check != false)
       //     $where2Level = " OR emp_id IN ($check)";
     //   else
       //     $where2Level="";
     
        if ($permission->view == 2) {
            $data = $this->db->query("SELECT id, emp_id,year,month,kpi_id,created_by FROM `kpi_score` WHERE emp_id = $this->emp_id Order By Id Desc LIMIT $limit OFFSET $offset ");
        } else if ($permission->view == 1) {
            if ($permission->follow == 2) {
                $data = $this->db->query("SELECT id, emp_id,year,month,kpi_id,created_by FROM `kpi_score` WHERE created_by = $this->user OR emp_id = $this->emp_id  Order By Id Desc LIMIT $limit OFFSET $offset ");
            } else {
                $data = $this->db->query("SELECT id, emp_id,year,month,kpi_id,created_by FROM `kpi_score` Order By Id Desc LIMIT $limit OFFSET $offset ");
            }
        }
        return $data;
    }


    //     public function AllEmployeeKpiScore($emp_id,$filter){
//        $data = $this->db->query("SELECT id, emp_id,year,month,kpi_id FROM `kpi_score` WHERE ".$filter." AND emp_id = '$emp_id' ");
//        return $data;
//    }
//    public function AllEmployeeKpiScorePages($emp_id,$limit,$offset){
//        $data = $this->db->query("SELECT id, emp_id,year,month,kpi_id FROM `kpi_score` WHERE emp_id = '$emp_id' LIMIT $limit OFFSET $offset ");
//        return $data;
//    }    


    public function getScoreStatus($id)
    {
        $action = $this->db->get_where('kpi_score', array('id' => $id))->row();
        $status = $action->status;
        if ($status == 0)
            $data = "Pending(Waiting 1-1 Meeting)";
        else if ($status == 1)
            $data = "Finish 1-1 Meeting";
        else if ($status == 2)
            $data = "HR Meeting";
        else
            $data = "Accepted";


        return $data;
    }
    public function sendKpiEmail($managerId, $userid, $month, $emailSubject = "")
    {
        $head = "manager";
        $user = $this->db->get_where('users', array('employees_id' => $userid))->row();
        $userMail = $user->email;
        //manager
        $manager = $this->db->get_where('users', array('id' => $managerId))->row();
        $managerMail = $manager->email;
        //info
        $monthName = $this->accounting_model->getMonth($month);
        $user_name = $user->user_name;
        $link = "<a href='" . base_url() . "performanceManagment/kpiScore'> Please Check </a>";
        // hr email 
        $hr = $this->db->get_where('users', array('role' => 31))->row();
        $hrMail = $hr->email;

        $subject = "Scorecard : " . $monthName;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // $headers .= "Cc: ".$hrMail. "\r\n";  
        $mailTo = $userMail;

        if ($emailSubject == "update")
            $msg = "Kpi For Month $monthName Updated";
        elseif ($emailSubject == "new")
            $msg = "Kindly find $monthName ScoreCard .";
        else {
            $msg = "ScoreCard For Month $monthName Status : $emailSubject";
            if ($emailSubject != "Finish 1-1 Meeting") {
                $mailTo = $managerMail;
                $user_name = $manager->user_name;
                $headers .= 'From: ' . $userMail . "\r\n" . 'Reply-To: ' . $userMail . "\r\n";
                $head = "emp";
            }

        }
        if ($head != "emp")
            $headers .= 'From: ' . $managerMail . "\r\n" . 'Reply-To: ' . $managerMail . "\r\n";

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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear ' . $user_name . ' ,</p>
                       
                       <p>  ' . $msg . ' </p>                     
                       <p>' . $link . '</p>                     
                       <p> Thanks</p>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }

    public function performanceMatrix($score, $scoreYear = '')
    {
        if ($scoreYear >= 5) {
            return self::updatedPerformanceMatrix($score);
        }
        if ($score >= 0 && $score <= 60) {
            $grade = "Week Performance";
            $color = "danger";
        } elseif ($score > 60 && $score <= 74) {
            $grade = "Below Average Performance";
            $color = "warning";
        } elseif ($score > 74 && $score <= 84) {
            $grade = "Average Performance";
            $color = "yellow";
        } elseif ($score > 84 && $score <= 95) {
            $grade = "Solid Performance";
            $color = "success";
        } elseif ($score > 95) {
            $grade = "Exceeding Performance";
            $color = "primary";
        }
        $data['grade'] = $grade;
        $data['color'] = $color;
        return $data;

    }

    public function getSubCoreName($id)
    {
        $data = $this->db->query("SELECT sub_name  as name from kpi_sub WHERE id = '$id'")->row()->name;
        return $data;
    }

    public function selectDepartmentKpi($id = "", $division = '')
    {
        $where = "brand='$this->brand' ";
        if (!empty($division))
            $where = "brand='$this->brand' AND division='$division' ";
        $department = $this->db->get_where('department', $where)->result();
        $data = "";
        foreach ($department as $department) {
            if ($department->id == $id) {
                $data .= "<option value='" . $department->id . "' selected='selected'>" . $department->name . "</option>";
            } else {
                $data .= "<option value='" . $department->id . "'>" . $department->name . "</option>";
            }
        }
        return $data;
    }

    public function getEmployeesNameByManager($emp_id = "", $id = "")
    {

        if ($emp_id)
            $where = "manager = $emp_id and status = 0";
        else
            $where = "status = 0";
        $employees = $this->db->query("SELECT name,id FROM employees WHERE $where ")->result_array();
        $data = "";
        foreach ($employees as $value) {

            if ($value['id'] == $id) {
                $data .= "<option value='" . $value['id'] . "' selected='selected'>" . $value['name'] . "</option>";
            } else {
                $data .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
        }
        return $data;
    }

    public function AllIncidentLog($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `kpi_incidents_log` WHERE " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `kpi_incidents_log` WHERE " . $filter . " AND (created_by = $this->user OR emp_id = $this->emp_id) ORDER BY id DESC");
        }
        return $data;
    }
    public function AllIncidentLogPages($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `kpi_incidents_log` ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM `kpi_incidents_log` where created_by = $this->user OR emp_id = $this->emp_id ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }

    // check max number of missing attendance
    public function getNumOfMissingAttendance($emp_id, $date, $id = '')
    {

        $date = date_format($date, 'Y-m-d H:i:s');
        if ($date > '2022-05-21 00:00:00') {
            $day = date('d', strtotime($date));
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));

            if ($day <= 20) {
                $endDate = date("$year-$month-20 23:59:59");
                $startDate = date("Y-m-21 00:00:00", strtotime("-1 month", strtotime($endDate)));
            } else {
                $startDate = date("$year-$month-21 00:00:00");
                $endDate = date("Y-m-20 23:59:59", strtotime("+1 month", strtotime($startDate)));
            }
            $where = "USRID =$emp_id AND SRVDT BETWEEN '$startDate' and '$endDate'";
            if ($id)
                $where .= " AND id != $id";
            $data = $this->db->query("SELECT count('id') as count_rows FROM `missing_attendance` where $where")->row()->count_rows;
        } else {
            $data = 0;
        }

        return $data;
    }

    // time sheet
    public function getDayStatus($emp_id, $day)
    {
        // get foreach day records from attendance log/missing_attendance table where USRID = emp_id & SRVDT = this day "w"
        // else get foreach day records from holidays_plan table / holiday_date "h" or sat-sun
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 1 "v"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 2 "do"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 3 "sl"
        // else display absent "a"  
        $date = date('Y-m-d', strtotime($day));
        $dayName = date('D', strtotime($day));
        $vacation = $this->db->query("SELECT count('id') as count_rows FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND (type_of_vacation =1 || type_of_vacation=2 || type_of_vacation=5 || type_of_vacation=6 || type_of_vacation=7) AND '$date' BETWEEN `start_date` and `end_date`")->row()->count_rows;
        if ($vacation > 0 && ($dayName != "Sat" && $dayName != "Sun")) {
            $data = "V";
        } else {
            $rest = $this->db->query("SELECT count('id') as count_rows FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND type_of_vacation = 8  AND '$date' BETWEEN `start_date` and `end_date`")->row()->count_rows;
            if ($rest > 0) {
                $data = "RL";
            } else {
                $marriage = $this->db->query("SELECT count('id') as count_rows FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND type_of_vacation = 4 AND '$date' BETWEEN `start_date` and `end_date`")->row()->count_rows;
                if ($marriage > 0) {
                    $data = "MV";
                } else {
                    $sickleave = $this->db->query("SELECT count('id') as count_rows FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND type_of_vacation =3 AND '$date' BETWEEN `start_date` and `end_date`")->row()->count_rows;
                    if ($sickleave > 0) {
                        $data = "SL";
                    } else {
                        $attendance_log_in = $this->db->query("SELECT count('id') as count_rows FROM `attendance_log` where USRID = $emp_id AND TNAKEY =1 AND SRVDT like '$date %'")->row()->count_rows;
                        $attendance_log_out = 0;
                        $signIn = $this->db->query("SELECT SRVDT FROM `attendance_log` where USRID = $emp_id AND TNAKEY =1 AND SRVDT like '$date %'")->row();
                        $signIn_log = $signIn ? $signIn->SRVDT : 0;
                        if ($signIn_log != 0) {
                            $attendance_log_out = $this->db->query("SELECT count('id') as count_rows FROM attendance_log AS log WHERE log.USRID = $emp_id AND TNAKEY = '2' AND
                                                        ((log.SRVDT BETWEEN '" . $signIn_log . "' AND DATE_ADD('" . $signIn_log . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $signIn_log . "')")->row()->count_rows;
                        }
                        //$attendance_log_out = $this->db->query("SELECT count('id') as count_rows FROM `attendance_log` where USRID = $emp_id AND TNAKEY =2 AND SRVDT like '$date %'")->row()->count_rows;

                        if ($attendance_log_in > 0 && $attendance_log_out > 0) {
                            $data = "W";
                        } else {
                            if ($dayName == "Sat" || $dayName == "Sun") {
                                $data = "WE";
                            } else {
                                $holiday = $this->db->query("SELECT count('id') as count_rows FROM `holidays_plan` where holiday_date like '$date'")->row()->count_rows;
                                if ($holiday > 0) {
                                    $data = "H";
                                } else {
                                    $data = "A";
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function selectAllEmployeesByTitleSelf($emp_id = "", $title = "")
    {
        if (!empty($emp_id) && $emp_id != 'none') {
            $employees = $this->db->query("SELECT DISTINCT title FROM employees WHERE (manager = '$emp_id' or id = '$emp_id')and status = 0")->result();
        } else {
            $employees = $this->db->query("SELECT DISTINCT title FROM employees WHERE status = 0")->result();
        }
        $data = "";
        foreach ($employees as $employee) {
            if ($employee->title == $title) {
                $data .= "<option value='" . $employee->title . "' selected='selected'>" . $this->getTitle($employee->title) . "</option>";
            } else {
                $data .= "<option value='" . $employee->title . "'>" . $this->getTitle($employee->title) . "</option>";
            }

        }
        return $data;
    }

    public function selectPerformanceMatrix($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } elseif ($select == 5) {
            $selected5 = 'selected';
        }
        $outpt = '<option value="1" ' . $selected1 . '>Week Performance</option>
                  <option value="2" ' . $selected2 . '>Below Average Performance</option>
                  <option value="3" ' . $selected3 . '>Average Performance</option>
                  <option value="4" ' . $selected4 . '>Solid Performance</option>
                  <option value="5" ' . $selected5 . '>Exceeding Performance</option>';
        return $outpt;

    }
    public function selectKpiScoreStatus($select = "")
    {

        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        }

        $outpt = '<option value="1" ' . $selected1 . '>Pending(Waiting 1-1 Meeting)</option>
                  <option value="2" ' . $selected2 . '>Finish 1-1 Meeting</option>
                  <option value="3" ' . $selected3 . '>HR Meeting</option>
                  <option value="4" ' . $selected4 . '>Accepted</option>';

        return $outpt;

    }

    // payroll    
    public function selectPayrollActions($name = "")
    {
        $result = $this->db->get('payroll_actions')->result();
        $data = "";
        foreach ($result as $val) {
            if ($val->id == $name) {
                $data .= "<option value='" . $val->id . "' selected='selected'>" . $val->name . "</option>";
            } else {
                $data .= "<option value='" . $val->id . "'>" . $val->name . "</option>";
            }
        }
        return $data;
    }

    public function getPayrollActions($id)
    {
        $result = $this->db->get_where('payroll_actions', array('id' => $id))->row();
        $data = "";
        if (!empty($result)) {
            $data = $result->name;
        }

        return $data;
    }

    public function selectPayrollUnits($select = '')
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } elseif ($select == 5) {
            $selected5 = 'selected';
        } elseif ($select == 6) {
            $selected6 = 'selected';
        } elseif ($select == 7) {
            $selected7 = 'selected';
        }
        $outpt = '<option value="1" ' . $selected1 . '>Hours</option>
                  <option value="2" ' . $selected2 . '>Days</option>
                  <option value="3" ' . $selected3 . '>Net Month</option>
                  <option value="4" ' . $selected4 . '>%</option>
                  <option value="5" ' . $selected5 . '>Currency (EGP)</option>
                  <option value="6" ' . $selected6 . '>Currency ($)</option>
                  <option value="7" ' . $selected7 . '>Currency (AED)</option>';
        return $outpt;
    }

    public function getPayrollUnits($id)
    {
        $data = '';
        if ($id == 1) {
            $data = 'Hours';
        } elseif ($id == 2) {
            $data = 'Days';
        } elseif ($id == 3) {
            $data = 'Net Month';
        } elseif ($id == 4) {
            $data = '%';
        } elseif ($id == 5) {
            $data = 'Currency (EGP)';
        } elseif ($id == 6) {
            $data = 'Currency ($)';
        } elseif ($id == 7) {
            $data = 'Currency (AED)';
        }

        return $data;
    }

    public function AllPayroll($permission, $filter)
    {

        $data = $this->db->query("SELECT * FROM `payroll` WHERE " . $filter . " ORDER BY id DESC ");

        return $data;
    }
    public function AllPayrollPages($permission, $limit, $offset)
    {

        $data = $this->db->query("SELECT * FROM `payroll` ORDER BY id DESC LIMIT $limit OFFSET $offset ");

        return $data;
    }
    // end payroll

    public function selectEmployeesByDepartment($department, $id = "")
    {
        if (!empty($department)) {
            $employees = $this->db->query("SELECT * FROM employees WHERE department = '$department'")->result();
        } else {
            $employees = $this->db->query("SELECT * FROM employees")->result();
        }
        $data = "";
        foreach ($employees as $employee) {
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }

        }
        return $data;
    }

    public function selectYearANDMonth($yearVal = "", $monthVal = "")
    {
        $years = $this->db->get('years')->result();
        $months = $this->db->get('months')->result();
        $data = "";
        foreach ($years as $year) {
            if ($year->id >= 5) {
                foreach ($months as $month) {
                    if ($year->id == $yearVal && $month->value == $monthVal) {
                        $data .= "<option value='" . $month->value . "-" . $year->id . "' selected='selected'>" . $month->name . " , " . $year->name . "</option>";
                    } else {
                        $data .= "<option value='" . $month->value . "-" . $year->id . "'>" . $month->name . " , " . $year->name . "</option>";
                    }
                }
            }
        }
        return $data;
    }

    // get kpi cores 
    public function selectActiveKpiCore($kpi)
    {
        $data = '';
        $kpi_core = $this->db->get_where('kpi_core', array('kpi_id' => $kpi))->result();
        foreach ($kpi_core as $core) {
            $data .= "<option value='" . $core->id . "'>" . $core->core_name . "</option>";
        }
        return $data;
    }
    // get kpi cores -> sub
    public function selectActiveKpiSubCore($core_id)
    {
        $data = '';
        $kpi_sub = $this->db->get_where('kpi_sub', array('kpi_core_id' => $core_id))->result();
        foreach ($kpi_sub as $sub) {
            $data .= "<option value='" . $sub->id . "'>" . $sub->sub_name . "</option>";
        }
        return $data;
    }

    public function getCoreName($id)
    {
        $data = $this->db->query("SELECT core_name  as name from kpi_core WHERE id = '$id'")->row()->name;
        return $data;
    }

    // for active kpi design
    public function switchKpiActive($kpiId)
    {
        $thisKpi = $this->db->get_where('kpi', array('id' => $kpiId))->row();
        if ($thisKpi->active == 1) {
            $data['active'] = 0;
            $this->db->update('kpi', $data, array('id <>' => $kpiId, 'employee_title' => $thisKpi->employee_title));

        }
    }

    // For Updated Performance Matrix Boundaries

    public function updatedPerformanceMatrix($score)
    {
        if ($score >= 0 && $score <= 50) {
            $grade = "Week Performance";
            $color = "danger";
        } elseif ($score > 50 && $score <= 65) {
            $grade = "Below Average Performance";
            $color = "warning";
        } elseif ($score > 65 && $score <= 80) {
            $grade = "Average Performance";
            $color = "yellow";
        } elseif ($score > 80 && $score <= 95) {
            $grade = "Solid Performance";
            $color = "success";
        } elseif ($score > 95) {
            $grade = "Exceeding Performance";
            $color = "primary";
        }
        $data['grade'] = $grade;
        $data['color'] = $color;
        return $data;

    }

    public function getScoreAveragePerformance($score, $weight, $year)
    {
        $data = false;
        $v = (float) $score / (float) $weight;
        // year less than 2023
        if ($year < 5) {
            if ($v * 100 <= 84) {
                $data = true;
            }
        } else {
            if ($v * 100 <= 80) {
                $data = true;
            }
        }
        return $data;
    }

    public function getMatrixBoundaries($matrix, $year)
    {
        // $year = 4(2022) OR =5(2023)
        if ($year == 4) {
            if ($matrix == 1) {
                $data['matrix_min'] = 0;
                $data['matrix_max'] = 60;
            } elseif ($matrix == 2) {
                $data['matrix_min'] = 60;
                $data['matrix_max'] = 74;
            } elseif ($matrix == 3) {
                $data['matrix_min'] = 74;
                $data['matrix_max'] = 84;
            } elseif ($matrix == 4) {
                $data['matrix_min'] = 84;
                $data['matrix_max'] = 95;
            } elseif ($matrix == 5) {
                $data['matrix_min'] = 95;
                $data['matrix_max'] = 100;
            }

        } elseif ($year == 5) {
            if ($matrix == 1) {
                $data['matrix_min'] = 0;
                $data['matrix_max'] = 50;
            } elseif ($matrix == 2) {
                $data['matrix_min'] = 50;
                $data['matrix_max'] = 65;
            } elseif ($matrix == 3) {
                $data['matrix_min'] = 65;
                $data['matrix_max'] = 80;
            } elseif ($matrix == 4) {
                $data['matrix_min'] = 80;
                $data['matrix_max'] = 95;
            } elseif ($matrix == 5) {
                $data['matrix_min'] = 95;
                $data['matrix_max'] = 100;
            }
        }
        return $data;
    }

    //location attendance cancelled
    public function getLocationAttendanceRequests($emp_id, $role, $start_date = 0, $end_date = 0)
    {
        if ($role == 31 || $role == 46) {
            $data = $this->db->query("SELECT * FROM attendance_approval WHERE (manager_approval = 0 || hr_approval = 0) AND SRVDT BETWEEN '$start_date' AND '$end_date' ORDER BY `attendance_approval`.`SRVDT` ASC");
        } else {
            $data = $this->db->query("SELECT * FROM attendance_approval WHERE USRID in (SELECT id FROM employees WHERE manager = '$emp_id' ) HAVING manager_approval = 0  || hr_approval = 0");
        }
        return $data;
    }
    // check attendance location
    public function checkAttendanceLocation($signin = '', $signout = '')
    {
        // 0=>Office ,1=>Work from Home
        $data = $signin_loc = $signout_loc = '';
        if (!empty($signin)) {
            $signin_location = $this->db->get_where('attendance_log', array('id' => $signin))->row()->location;
            if ($signin_location == 0 && $signin_location != null) {
                $signin_loc = 'O';
            } elseif ($signin_location == 1) {
                $signin_loc = 'H';
            }
        }
        if (!empty($signout)) {
            $signout_location = $this->db->get_where('attendance_log', array('id' => $signout))->row()->location;
            if ($signout_location == 0 && $signout_location != null) {
                $signout_loc = 'O';
            } elseif ($signout_location == 1) {
                $signout_loc = 'H';
            }
        }

        if ($signin_loc == $signout_loc) {
            $data = $signin_loc;
        } else {
            $data = $signin_loc . '/' . $signout_loc;
        }
        return $data;
    }

    public function checkAttendanceLocationDetails($emp_id, $day)
    {
        // 0=>Office ,1=>Work from Home
        $data = $signin_loc = $signout_loc = '';
        // first login & last logout
        $signIn = $this->db->query("SELECT id,SRVDT FROM attendance_log AS log WHERE log.USRID = " . $emp_id . " AND TNAKEY = '1' AND DATE(SRVDT) = '" . $day . "' ORDER BY log.id ASC LIMIT 1")->row();
        $signOut = $this->db->query("SELECT id FROM attendance_log AS log WHERE log.USRID = " . $emp_id . " AND TNAKEY = '2' AND
        ((log.SRVDT BETWEEN '" . $signIn->SRVDT . "' AND DATE_ADD('" . $signIn->SRVDT . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $signIn->SRVDT . "') ORDER BY log.id DESC LIMIT 1")->row();

        if (!empty($signIn)) {
            $signin_location = $this->db->get_where('attendance_log', array('id' => $signIn->id))->row()->location;
            if ($signin_location == 0 && $signin_location != null) {
                $signin_loc = 'O';
            } elseif ($signin_location == 1) {
                $signin_loc = 'H';
            }
        }
        if (!empty($signOut)) {
            $signout_location = $this->db->get_where('attendance_log', array('id' => $signOut->id))->row()->location;
            if ($signout_location == 0 && $signout_location != null) {
                $signout_loc = 'O';
            } elseif ($signout_location == 1) {
                $signout_loc = 'H';
            }
        }

        if ($signin_loc == $signout_loc) {
            $data = $signin_loc;
        } elseif ($signin_loc == 'O' || $signout_loc == 'O') {
            $data = 'O';
        }
        return $data;
    }

    public function getDayStatusClass($status)
    {
        $data = '';
        if ($status == 'W' || $status == 'WO') {
            $data = "bg-success text-white";
        } else if ($status == 'A') {
            $data = 'bg-danger text-white text-left';
        } else if ($status == 'WH') {
            $data = 'bg-warning text-white';
        } else if ($status == 'V') {
            $data = 'bg-light';
        } else if (substr_count($status, '/') > 0) {
            $data = 'two-background text-white';
        }
        return $data;
    }

    public function getTnakeyType($type)
    {
        $data = '';
        if ($type == 1) {
            $data = "Sign In";
        } elseif ($type == 2) {
            $data = "Sign Out";
        }
        return $data;
    }

    public function getLocationType($type)
    {
        $data = '';
        if ($type == 0 && $type != null) {
            $data = "Office";
        } elseif ($type == 1) {
            $data = "Home";
        }
        return $data;
    }

    public function checkIsFriday($value = '')
    {
        if (!empty($value))
            $date = date_format($value, 'Y-m-d H:i:s');
        else
            $date = date("Y-m-d H:i:s");

        $dayNum = date('w', strtotime($date));

        if ($dayNum >= 5) { // for friday
            $result = 'true';
        } else {
            $result = 'false';
        }

        return $result;
    }

    public function sendLocationAttendanceRequestMail($data, $brand)
    {
        $managerId = $this->hr_model->getManagerId($data['USRID']);
        $managerMail = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->email;
        $managerName = $this->db->get_where('users', array('employees_id' => $managerId, 'brand' => $brand))->row()->first_name;
        $employeeMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $mailTo = $managerMail;
        if ($data['TNAKEY'] == 1) {
            $TNAKEY = "Sign In";
        } elseif ($data['TNAKEY'] == 2) {
            $TNAKEY = "Sign Out";
        }
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        //$headers .= "Cc: ".$employeeMail."\r\n";
        $headers .= 'From: ' . $employeeMail . "\r\n";

        $subject = "New Attendance Request ";

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
                     <p> Hello ' . $managerName . ' , </P>
                    <p> There is Attendance Request from ' . self::getEmployee($data['USRID']) . ' need to be <a href="' . base_url() . 'hr/attendance" target="_blank"> Approved ..</a>  </p>
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                        
                         <th>Employee Name</th>
                         <th>Date </th>
                         <th>Sign In/Out</th>
                         <th>Location</th>

                       
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>' . self::getEmployee($data['USRID']) . '</td>
                        <td>' . $data['SRVDT'] . '</td>
                        <td>' . $TNAKEY . '</td>
                        <td>' . self::getLocationType($data['location']) . '</td>
                      </tr>
                      </tbody>
                    </table> 

                     <p> Thank you, </p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function checkThisUserIsEmployeeManager($emp_id)
    {
        $data = False;
        $row = $this->db->get_where('employees', array('id' => $emp_id))->row();
        if ($row > 0 && $row->manager == $this->emp_id) {
            $data = True;
        }

        return $data;
    }

    public function getDatesFromPayrollMonth($payroll_month)
    {

        $payroll_month = explode("-", $_REQUEST['payroll_month']);
        $data['month'] = $month = $payroll_month[0];
        $data['year'] = $year = $payroll_month[1];
        $data['year_str'] = $year_str = $this->hr_model->getYear($year);
        // set dates                                      
        $data['date_to'] = $date_to = date("$year_str-$month-20");
        $data['date_from'] = $date_from = date("Y-m-d", strtotime("-1 month +1 day", strtotime($date_to)));


        return $data;
    }

    public function checkTimeSheetRowStatus($emp_id, $payroll_month, $count_deduction)
    {
        $data['class'] = '';
        $data['status'] = '';
        $data['msg'] = '';
        $data['need_approval'] = 0;

        if ($payroll_month == 0) {
            $data['class'] = 'bg-info';
            $data['msg'] = 'Please Select Payroll Month';
            $data['status'] = '';
        } elseif ($count_deduction > 0) {
            $data['class'] = 'bg-info';
            $data['msg'] = "The TimeSheet Is Not Completed";
            $data['status'] = 'Pending';
        } elseif ($count_deduction == 0 && $payroll_month != 0) {
            //elseif($payroll_month != 0){
            // get from time sheet approval 
            $row = $this->db->get_where('timesheet_approval', array('emp_id' => $emp_id, 'payroll_month' => $payroll_month))->row();
            if (empty($row) || $row->manager_approval == 0) {
                // check attendance log records
                $dates = self::getDatesFromPayrollMonth($payroll_month);
                $date_from = $dates['date_from'];
                $date_to = $dates['date_to'];
                $num_rows = $this->db->get_where('employees', array('manager' => $emp_id))->num_rows();
                if ($num_rows > 0) {
                    $data['class'] = 'bg-success';
                    $data['msg'] = ' Approved ';
                    $data['status'] = 'Approved';
                } else {
                    $data['class'] = 'bg-warning';
                    $data['msg'] = 'Waiting Manager Approval';
                    $data['status'] = 'pending';
                    $data['need_approval'] = 1;
                }
            } elseif ($row->manager_approval == 1) {
                $data['class'] = 'bg-success';
                $data['msg'] = "Approved By " . $this->admin_model->getUser($row->created_by) . "";
                $data['status'] = 'Approved';
            } elseif ($row->manager_approval == 2) {
                $data['class'] = 'bg-danger';
                $data['msg'] = "Rejected By " . $this->admin_model->getUser($row->created_by) . "($row->comment)";
                $data['status'] = 'Rejected';
            }
        }

        return $data;
    }

    public function sendRejectTimeSheetMail($data)
    {
        $from = "erp@aixnexus.com";
        $mailTo = "asmaa.saafan@thetranslationgate.com";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";
        $subject = "New Rejected Time Sheet ";
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
                     <p> Hello Team, </P>
                    <p> There is rejected Time Sheet ,please Check ..</a>  </p>
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>                        
                         <th>Employee Name</th>
                         <th>Payroll Month </th>
                         <th>Status</th>
                         <th>Comment</th>
                         <th>status By</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>' . self::getEmployee($data['emp_id']) . '</td>
                        <td>' . $data['payroll_month'] . '</td>
                        <td> Rejected  </td>
                         <td>' . $data['comment'] . '</td>
                         <td>' . $this->admin_model->getUser($data['created_by']) . '</td>
                      </tr>
                      </tbody>
                    </table> 

                     <p> Thank you, </p>
                    </body>
                    </html>';
        mail($mailTo, $subject, $message, $headers);
    }

public function selectAllEmployeesByManagerID2level($emp_id, $id = "")
    {
        $check = $this->admin_model->getUserEmployees2Level($emp_id);
        if($check != false)
            $where2Level = " OR id IN ($check)";
         else
            $where2Level="";
         
        $employees = $this->db->query("SELECT * FROM employees WHERE manager = '$emp_id'". $where2Level)->result();
        $data = "";
        foreach ($employees as $employee) {
            if ($employee->id == $id) {
                $data .= "<option value='" . $employee->id . "' selected='selected'>" . $employee->name . "</option>";
            } else {
                $data .= "<option value='" . $employee->id . "'>" . $employee->name . "</option>";
            }

        }
        return $data;
    }
    
    // test
    public function getDayStatusFast($emp_id, $day)
    {
        // get foreach day records from attendance log/missing_attendance table where USRID = emp_id & SRVDT = this day "w"
        // else get foreach day records from holidays_plan table / holiday_date "h" or sat-sun
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 1 "v"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 2 "do"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 3 "sl"
        // else display absent "a"  
        $date = date('Y-m-d', strtotime($day));
        $dayName = date('D', strtotime($day));
        $vacation_transaction = $this->db->query("SELECT type_of_vacation FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND '$date' BETWEEN `start_date` and `end_date`")->row();
        if(!empty($vacation_transaction)){
            $vacation_type = $vacation_transaction->type_of_vacation;            
           if(($vacation_type == 1 || $vacation_type ==2 ||$vacation_type ==5 || $vacation_type ==6 || $vacation_type ==7) && ($dayName != "Sat" && $dayName != "Sun")){
                $data = "V";
            }elseif($vacation_type == 8 ){
                    $data = "RL";            
            }elseif($vacation_type == 4 ){
                    $data = "MV";            
            }elseif($vacation_type == 3 ){
                    $data = "SL";
            }
        }else{  
            $attendance_log = $this->db->query("SELECT * FROM `attendance_view` where USRID = $emp_id AND SignIn like '$date %'")->row();
            if (!empty($attendance_log)){            
                if ($attendance_log->SignIn != null && $attendance_log->SignOut !=null) {
                    $location = self::checkAttendanceLocationDetailsFast($attendance_log->SignInLocation,$attendance_log->SignOutLocation);
                    $data = "W".$location;
                }else {
                    $data = "A";
                }          
            }
            else {
                if ($dayName == "Sat" || $dayName == "Sun") {
                    $data = "WE";
                } else {
                    $holiday = $this->db->query("SELECT count('id') as count_rows FROM `holidays_plan` where holiday_date like '$date'")->row()->count_rows;
                    if ($holiday > 0) {
                        $data = "H";
                    } else {
                        $data = "A";
                    }
                }
            }
        }

        return $data;
    }
    
    public function getDayStatusFast_old($emp_id, $day)
    {
        // get foreach day records from attendance log/missing_attendance table where USRID = emp_id & SRVDT = this day "w"
        // else get foreach day records from holidays_plan table / holiday_date "h" or sat-sun
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 1 "v"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 2 "do"
        // else get foreach day records from vacation_transaction table where day between  start_day - end_day & emp_id = $emp_id / type = 3 "sl"
        // else display absent "a"  
        $date = date('Y-m-d', strtotime($day));
        $dayName = date('D', strtotime($day));
        $vacation_transaction = $this->db->query("SELECT type_of_vacation FROM `vacation_transaction` where status = 1 AND emp_id = $emp_id AND '$date' BETWEEN `start_date` and `end_date`")->row();
        if(!empty($vacation_transaction)){
            $vacation_type = $vacation_transaction->type_of_vacation;            
           if(($vacation_type == 1 || $vacation_type ==2 ||$vacation_type ==5 || $vacation_type ==6 || $vacation_type ==7) && ($dayName != "Sat" && $dayName != "Sun")){
                $data = "V";
            }elseif($vacation_type == 8 ){
                    $data = "RL";            
            }elseif($vacation_type == 4 ){
                    $data = "MV";            
            }elseif($vacation_type == 3 ){
                    $data = "SL";
            }
        }else{  
            $attendance_log_in = $this->db->query("SELECT count('id') as count_rows FROM `attendance_log` where USRID = $emp_id AND TNAKEY =1 AND SRVDT like '$date %'")->row()->count_rows;
            if ($attendance_log_in > 0){
                $attendance_log_out = 0;          
                $signIn = $this->db->query("SELECT SRVDT FROM `attendance_log` where USRID = $emp_id AND TNAKEY =1 AND SRVDT like '$date %'")->row();
                $signIn_log = $signIn ? $signIn->SRVDT : 0;
                if ($signIn_log != 0) {
                    $attendance_log_out = $this->db->query("SELECT count('id') as count_rows FROM attendance_log AS log WHERE log.USRID = $emp_id AND TNAKEY = '2' AND
                                                ((log.SRVDT BETWEEN '" . $signIn_log . "' AND DATE_ADD('" . $signIn_log . "', INTERVAL 18 hour)) AND log.SRVDT > '" . $signIn_log . "')")->row()->count_rows;
                }
                //$attendance_log_out = $this->db->query("SELECT count('id') as count_rows FROM `attendance_log` where USRID = $emp_id AND TNAKEY =2 AND SRVDT like '$date %'")->row()->count_rows;

                if ($attendance_log_in > 0 && $attendance_log_out > 0) {
                    $data = "W";
                }else {
                    $data = "A";
                }          
            }
            else {
                if ($dayName == "Sat" || $dayName == "Sun") {
                    $data = "WE";
                } else {
                    $holiday = $this->db->query("SELECT count('id') as count_rows FROM `holidays_plan` where holiday_date like '$date'")->row()->count_rows;
                    if ($holiday > 0) {
                        $data = "H";
                    } else {
                        $data = "A";
                    }
                }
            }
        }

        return $data;
    }

    public function checkAttendanceLocationDetailsFast($signin_location, $signout_location)
    {
        // 0=>Office ,1=>Work from Home
        $data = $signin_loc = $signout_loc = '';           
        
        if ($signin_location == 0 && $signin_location != null) {
            $signin_loc = 'O';
        } elseif ($signin_location == 1) {
            $signin_loc = 'H';
        }

        if ($signout_location == 0 && $signout_location != null) {
            $signout_loc = 'O';
        } elseif ($signout_location == 1) {
            $signout_loc = 'H';
        }

        if ($signin_loc == $signout_loc) {
            $data = $signin_loc;
        } elseif ($signin_loc == 'O' || $signout_loc == 'O') {
            $data = 'O';
        }
        return $data;
    }


}