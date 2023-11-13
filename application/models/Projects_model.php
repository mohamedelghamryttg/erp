<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Projects_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function findall($vfilter = '', $having = '')
    {

        // $this->db->select('*');
        // if ($vfilter != '') {
        //     $this->db->where($vfilter);
        // }
        // if ($having != '') {
        //     $this->db->having($having);
        // }
        // $query = $this->db->get('projects_view');

        $sql = "SELECT 
        p.id AS id,
        p.opportunity AS opportunity,
        p.branch_name AS branch_name,
        p.code AS code,
        p.name AS name,
        p.customer AS customer,
        p.lead AS `lead`,
        p.product_line AS product_line,
        p.cpo_file AS cpo_file,
        p.po AS po,
        p.type AS type,
        p.status AS status,
        p.closed_date AS closed_date,
        p.closed_by AS closed_by,
        p.verified AS verified,
        p.has_error AS has_error,
        p.verified_at AS verified_at,
        p.verified_by AS verified_by,
        p.created_by AS created_by,
        p.created_at AS created_at,
        b.id AS brand,
        b.name AS brandname,
        j.id AS closed,
        c.name AS customername,
        l.name AS productline,
        u.user_name AS username,
        TIMESTAMPDIFF(HOUR,
            j1.min_start,
            j1.max_delivery) AS total_hours,
        TIMESTAMPDIFF(HOUR,
            j1.min_start,
            CURRENT_TIMESTAMP()) AS interval_hours,
        j1.min_start AS min_start,
        j1.max_delivery AS max_delivery,
        CURRENT_TIMESTAMP() AS now,
        j2.allclosed AS allclosed,
        j3.closedstat AS closedstat
    FROM
        ((((((((project p
        LEFT JOIN customer c ON (c.id = p.customer))
        LEFT JOIN brand b ON (b.id = c.brand))
        LEFT JOIN customer_product_line l ON (l.id = p.product_line))
        LEFT JOIN users u ON (u.id = p.created_by))
        LEFT JOIN (SELECT 
            job.project_id AS project_id,
                job.status AS status,
                job.id AS id
        FROM
            job
        WHERE
            job.status <> 1
        GROUP BY job.project_id , job.status) j ON (j.project_id = p.id))
        LEFT JOIN (SELECT 
            job.project_id AS project_id,
                MIN(job.start_date) AS min_start,
                MAX(job.delivery_date) AS max_delivery,
                IFNULL(COUNT(job.id), 0) AS closed
        FROM
            job
        GROUP BY job.project_id) j1 ON (j1.project_id = p.id))
        LEFT JOIN (SELECT 
            job.project_id AS project_id,
                IFNULL(COUNT(job.id), 0) AS allclosed
        FROM
            job
        GROUP BY job.project_id) j2 ON (j2.project_id = p.id))
        LEFT JOIN (SELECT 
            job.project_id AS project_id,
                IFNULL(COUNT(job.id), 0) AS closedstat
        FROM
            job
        WHERE
            job.status = 1
        GROUP BY job.project_id) j3 ON (j3.project_id = p.id))";
        // ->result();
        $query = $this->db->query($sql);
        // var_dump($query);
        // die;




        return $query;
    }

    function make_datatables($rowno, $rowperpage, $vfilter)
    {
        // $this->make_query();
        // if ($_POST["length"] != -1) {
        //     $this->db->limit($_POST['length'], $_POST['start']);
        // }
        // $query = $this->db->get();
        $rowno = $_POST['start'];
        $rowperpage = $_POST['length'];

        $vfilter =  $vfilter;
        $query = $this->db->query('call projects_view(' . $rowperpage . ',' . $rowno . ',"' . $vfilter . '" )');
        $res      = $query->result();

        $query->next_result();
        // $query->free_result();

        return $res;
    }
    function get_filtered_data()
    {

        $vfilter =  ' 1 ';
        $rowno = '0';
        $rowperpage = '0';
        $query = $this->db->query('call projects_view(' . $rowperpage . ',' . $rowno . ',"' . $vfilter . '" )');
        $res      = $query->result_array();
        $query->next_result();
        // $query->free_result();
        // $query = $this->db->get();
        return count($res);
    }
    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from("project");
        // $vfilter =  ' 1 ';
        // $rowno = $_POST['start'];
        // $rowperpage = $_POST['length'];
        // $query = $this->db->query('call projects_view(' . $rowperpage . ',' . $rowno . ',"' . $vfilter . '" )');
        // $res      = $query->result_array();
        // $query->next_result();
        // $query->free_result();
        // return count($res);
        // $this->db->select("*");  
        //    $this->db->from($this->table);  
        return $this->db->count_all_results();
    }
    //**************** */
    public function getRecord($rowno, $rowperpage, $vfilter)
    {
        $vfilter =  $vfilter;
        $res = $this->db->get('projects_view');
        // $query = $this->db->query('call projects_view(' . $rowperpage . ',' . $rowno . ',"' . $vfilter . '" )');
        // $res      = $query->result_array();
        // $query->next_result();
        // $query->free_result();
        return $res;
    }
    public function getRecordCount()
    {
        return $this->db->count_all('project');
    }
    public function projCountRecord_stat($vfilter)
    {

        $query = $this->db->query('call projcountrecord("' . $vfilter . '" )');
        $res      = $query->row();
        $query->next_result();
        $query->free_result();
        return $res;
    }


    // public function AllProjects($permission, $user, $brand, $filter, $having = 1)
    // {

    //     $sql = "select t.* from 
    //         (
    //         SELECT p.*
    //         ,b.id as brand
    //         ,b.name as brandname

    //         ,c.name as customername
    //         ,l.name as productline
    //         ,u.user_name as username
    //         FROM `project` AS p
    //         inner join customer as c on c.id = p.customer
    //         inner join brand as b on b.id = c.brand 
    //         inner join customer_product_line as l on l.id = p.product_line
    //         inner join users as u on u.id = p.created_by
    //         ) t
    //         WHERE " . $filter;

    //     if ($permission->view == 1) {
    //         $sql .= " HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ";
    //         $data = $this->db->query($sql);
    //     } elseif ($permission->view == 2) {
    //         $sql .= " AND created_by = '$user'  HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ";
    //         $data = $this->db->query($sql);
    //         // $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT IF ((SELECT count(*) from job where project_id = p.id) = (SELECT count(*) from job where project_id = p.id AND status = '1'), 1, 0)) AS closed FROM `project` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
    //     }
    //     return $data;
    // }

    // public function AllProjectsPages($permission, $user, $brand, $limit, $offset)
    // {
    //     $sql = "select t.* from 
    //     (
    //     SELECT p.*
    //     ,b.id as brand
    //     ,b.name as brandname

    //     ,c.name as customername
    //     ,l.name as productline
    //     ,u.user_name as username
    //     FROM `project` AS p
    //     inner join customer as c on c.id = p.customer
    //     inner join brand as b on b.id = c.brand 
    //     inner join customer_product_line as l on l.id = p.product_line
    //     inner join users as u on u.id = p.created_by
    //     ) t ";


    //     if ($permission->view == 1) {
    //         $sql .= " HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ";
    //         $data = $this->db->query($sql);
    //     } elseif ($permission->view == 2) {
    //         $sql .= "  WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ";
    //         $data = $this->db->query($sql);
    //         // $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT IF ((SELECT count(*) from job where project_id = p.id) = (SELECT count(*) from job where project_id = p.id AND status = '1'), 1, 0)) AS closed FROM `project` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
    //     }
    //     return $data;
    // }
    public function AllProjects($permission, $user, $brand, $filter, $having = 1)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT IF ((SELECT count(*) from job where project_id = p.id) = (SELECT count(*) from job where project_id = p.id AND status = '1'), 1, 0)) AS closed FROM `project` AS p WHERE " . $filter . " HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT IF ((SELECT count(*) from job where project_id = p.id) = (SELECT count(*) from job where project_id = p.id AND status = '1'), 1, 0)) AS closed FROM `project` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllProjectsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllProjectsCount($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function OpportunitiesByPm($permission, $pm, $brand)
    {
        if ($permission->view == 1) {
            $sql = " SELECT p.*,c.brand AS brand,c.name as customer_name,u.user_name as sam_name
            FROM `sales_opportunity` AS p 
            inner join customer c on c.id = p.customer
            inner join users as u on u.id = p.created_by
            WHERE p.assigned = '1' AND p.saved = '0' HAVING brand = '$brand' ";
            $data = $this->db->query($sql);
            //" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `sales_opportunity` AS p WHERE p.assigned = '1' AND p.saved = '0' HAVING brand = '$brand' ");
        } elseif ($permission->view == 2) {
            $sql = "SELECT p.*,c.brand AS brand,cp.lead_count AS total 
            ,c.name as customer_name,u.user_name as sam_name
            FROM `sales_opportunity` AS p 
            inner join customer c on c.id = p.customer
            inner join users as u on u.id = p.created_by
            left join (select count(`lead`) as lead_count,`lead` from customer_pm group by `lead`) cp on cp.lead = p.lead 
            WHERE p.assigned = '1' AND p.saved = '0' HAVING total > 0 AND brand = '$brand' ";
            $data = $this->db->query($sql);
            //"SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT COUNT(*) FROM customer_pm WHERE customer_pm.lead = p.lead AND customer_pm.pm = '$pm') AS total FROM `sales_opportunity` AS p WHERE p.assigned = '1' AND p.saved = '0' HAVING total > 0 AND brand = '$brand' ");
        }
        return $data;
    }

    public function generateProjectCode($lead, $pm)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $leadRow = $this->db->get_where('customer_leads', array('id' => $lead))->row();
            $customer = $this->db->get_where('customer', array('id' => $leadRow->customer))->row();
            $id = $this->db->query(" show table status where name='project' ")->row();
            $projectCode = $this->sales_model->getUserAbbreviations($pm) . '-' . $id->Auto_increment . '-' . $this->sales_model->getRegionAbbreviations($leadRow->region) . '-' . $this->sales_model->getBrandAbbreviations($customer->brand);
        } elseif ($this->brand == 11) {
            $id = $this->db->query(" show table status where name='project' ")->row();
            $projectCode = 'columbuslang-' . $id->Auto_increment;
        }
        return $projectCode;
    }

    public function updateProjectCode($lead, $id, $pm)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $leadRow = $this->db->get_where('customer_leads', array('id' => $lead))->row();
            $customer = $this->db->get_where('customer', array('id' => $leadRow->customer))->row();
            $projectCode = $this->sales_model->getUserAbbreviations($pm) . '-' . $id . '-' . $this->sales_model->getRegionAbbreviations($leadRow->region) . '-' . $this->sales_model->getBrandAbbreviations($customer->brand);
        } elseif ($this->brand == 11) {
            $projectCode = 'columbuslang-' . $id;
        }
        return $projectCode;
    }

    public function projectJobs($permission, $user, $id)
    {
        if ($permission->view == 1) {
            $data = $this->db->get_where('job', array('project_id' => $id));
        } elseif ($permission->view == 2) {
            $data = $this->db->get_where('job', array('project_id' => $id, 'created_by' => $user));
        }
        return $data;
    }

    public function generateJobCode($projectId, $priceList)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $projectCode = $this->db->get_where('project', array('id' => $projectId))->row()->code;
            $service = $this->db->get_where('customer_price_list', array('id' => $priceList))->row()->service;
            $id = $this->db->query(" show table status where name='job' ")->row();
            $jobCode = $projectCode . '-' . $id->Auto_increment . '-' . $this->sales_model->getServiceAbbreviations($service);
        } elseif ($this->brand == 11) {
            $projectCode = $this->db->get_where('project', array('id' => $projectId))->row()->code;
            $id = $this->db->query(" show table status where name='job' ")->row();
            $jobCode = $projectCode . '-' . $id->Auto_increment;
        }
        return $jobCode;
    }

    public function updateJobCode($projectId, $priceList, $id)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $projectCode = $this->db->get_where('project', array('id' => $projectId))->row()->code;
            $service = $this->db->get_where('customer_price_list', array('id' => $priceList))->row()->service;
            $jobCode = $projectCode . '-' . $id . '-' . $this->sales_model->getServiceAbbreviations($service);
        } elseif ($this->brand == 11) {
            $projectCode = $this->db->get_where('project', array('id' => $projectId))->row()->code;
            $jobCode = $projectCode . '-' . $id;
        }
        return $jobCode;
    }

    public function generateTaskCode($taskId)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $taskCode = $this->db->get_where('job', array('id' => $taskId))->row()->code;
            $id = $this->db->query(" show table status where name='job_task' ")->row();
            $jobCode = $taskCode . '-' . $id->Auto_increment;
        } elseif ($this->brand == 11) {
            $taskCode = $this->db->get_where('job', array('id' => $taskId))->row()->code;
            $id = $this->db->query(" show table status where name='job_task' ")->row();
            $jobCode = $taskCode . '-' . $id->Auto_increment;
        }
        return $jobCode;
    }

    public function updateTaskCode($taskId, $id)
    {
        if ($this->brand == 1 or $this->brand == 2 or $this->brand == 3) {
            $taskCode = $this->db->get_where('job', array('id' => $taskId))->row()->code;
            $jobCode = $taskCode . '-' . $id;
        } elseif ($this->brand == 11) {
            $taskCode = $this->db->get_where('job', array('id' => $taskId))->row()->code;
            $jobCode = $taskCode . '-' . $id;
        }
        return $jobCode;
    }

    public function getProjectData($id)
    {
        $result = $this->db->get_where('project', array('id' => $id))->row();
        return $result;
    }

    public function getJobData($id)
    {
        $result = $this->db->get_where('job', array('id' => $id))->row();
        return $result;
    }

    public function getTaskData($id)
    {
        $result = $this->db->get_where('job_task', array('id' => $id))->row();
        return $result;
    }

    public function jobTasks($permission, $user, $id)
    {
        if ($permission->view == 1) {
            $data = $this->db->get_where('job_task', array('job_id' => $id));
        } elseif ($permission->view == 2) {
            $data = $this->db->get_where('job_task', array('job_id' => $id, 'created_by' => $user));
        }
        return $data;
    }

    public function getJobPriceListData($id)
    {
        $row = $this->db->get_where('job_price_list', array('id' => $id))->row();
        return $row;
    }

    public function sendVendorTaskMail($id, $user, $brand)
    {
        $row = self::getTaskData($id);
        $job = self::getJobData($row->job_id);
        $jobPrice = self::getJobPriceListData($job->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);

        $vendor = $this->vendor_model->getVendorData($row->vendor);
        $mailTo = $vendor->email;
        $subject = "New Vendor Task : " . $row->subject;


        if ($brand == 1) {

            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@thetranslationgate.com');
            $this->email->subject($subject);
            // $msg = $this->load->view('admin/mail','',TRUE);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }
            $this->email->message('<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>');
        } else if ($brand == 3) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,
            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@europelocalize.com');
            $this->email->subject($subject);
            // $msg = $this->load->view('admin/mail','',TRUE);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }
            $this->email->message('<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>');
        } else if ($brand == 2) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@localizera.com');
            $this->email->subject($subject);
            // $msg = $this->load->view('admin/mail','',TRUE);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }
            $this->email->message('<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>');
        } elseif ($brand == 11) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vendormanagement@columbuslang.com, projectmanagement@columbuslang.com');
            $this->email->subject($subject);
            // $msg = $this->load->view('admin/mail','',TRUE);
            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }
            $this->email->message('<!DOCTYPE html>
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
                            <div class="panel-body">
                                            <div class="adv-table editable-table ">
                                                <div class="clearfix">
                                                    <div class="btn-group">
                                                        <span class=" btn-primary" style="">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="space15"></div>
                                                
                                                <table class="table table-striped table-hover table-bordered" id="" style="border: 0px solid;width: 100%;text-align: left;">
                                                    <tbody>
                                                       
                                                       <tr>
                                                             <td style="background-color: #8d001e;">Job Assignment Detail :</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Job Code</td>
                                                             <td style="background-color:#ddd;">' . $job->code . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Linguist Data</td>
                                                             <td style="background-color:#ddd;"> ' . $pmMail . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Product Line</td>
                                                             <td style="background-color:#ddd;">' . $this->customer_model->getProductLine($jobPrice->product_line) . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Languages</td>
                                                             <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '->' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                                        </tr>
            
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Service</td>
                                                             <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . ' ' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Count</td>
                                                             <td style="background-color:#ddd;">' . $row->count . ' ' . $this->admin_model->getUnit($row->unit) . '</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Rate</td>
                                                             <td style="background-color:#ddd;">' . $row->rate . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Total Cost</td>
                                                             <td style="background-color:#ddd;">' . $row->rate * $row->count . ' ' . $this->admin_model->getCurrency($row->currency) . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Deadline</td>
                                                             <td style="background-color:#ddd;">' . $row->delivery_date . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Task File</td>
                                                             <td style="background-color:#ddd;">' . $file . '</td>
                                                        </tr>
                                                        <tr>
                                                             <td style="background-color: #f9f9f9;">Instructions</td>
                                                             <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                      </div>
                            </body>
                            </html>');
        }

        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function sendVendorTaskMailVendorModule($id, $user, $brand, $update = '')
    {
        $data['nexusLink'] = $nexusLink = self::getNexusLinkByBrand($brand);
        $data['row'] = self::getTaskData($id);
        $data['job'] = self::getJobData($data['row']->job_id);
        $data['jobPrice'] = self::getJobPriceListData($data['job']->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);
        $data['acceptLink'] = $nexusLink . "/Project/viewOffer?t=" . base64_encode($id);
        $vendor = $this->vendor_model->getVendorData($data['row']->vendor);
        $mailTo = $vendor->email;

        $subject = "Nexus || New Task: " . $data['row']->subject;
        if (!empty($update)) {
            $subject = "Nexus || Task Updated : " . $data['row']->subject;
        }
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        if ($brand == 1) {
            $this->email->cc($pmMail . ', vm@thetranslationgate.com');
        } elseif ($brand == 2) {
            $this->email->cc($pmMail . ', vm@localizera.com');
        } elseif ($brand == 3) {
            $this->email->cc($pmMail . ', vm@europelocalize.com');
        } elseif ($brand == 11) {
            $this->email->cc($pmMail . ', Vendormanagement@Columbuslang.com');
        }

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($pmMail);
        // $this->email->cc($pmMail);
        $this->email->to($mailTo);
        $this->email->subject($subject);
        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("nexus/new_job.php", $data, true);
        if (!empty($update)) {
            $message = $this->load->view("nexus/update_job.php", $data, true);
        }
        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function sendVendorUpdateTaskMail($id, $user, $brand)
    {
        $row = self::getTaskData($id);
        $job = self::getJobData($row->job_id);
        $jobPrice = self::getJobPriceListData($job->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);

        $vendor = $this->vendor_model->getVendorData($row->vendor);
        $mailTo = $vendor->email;
        $subject = "Updated Vendor Task : " . $row->subject;

        if ($brand == 1) {

            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@thetranslationgate.com');
            $this->email->subject($subject);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }

            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } else if ($brand == 3) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@europelocalize.com');
            $this->email->subject($subject);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }

            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } else if ($brand == 2) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vm@localizera.com');
            $this->email->subject($subject);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }

            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } elseif ($brand == 11) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->cc($pmMail . ', vendormanagement@columbuslang.com');
            $this->email->subject($subject);

            if (strlen($row->file) > 1) {
                $file = '<a href="' . base_url() . 'assets/uploads/taskFile/' . $row->file . '" target="_blank">Click Here ..</a>';
            }

            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">' . $row->code . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Type</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Service</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Vendor</td>
                                                 <td style="background-color:#ddd;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Source</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Target</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Count</td>
                                                 <td style="background-color:#ddd;">' . $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Unit</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Rate</td>
                                                 <td style="background-color:#ddd;">' . $row->rate . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Total Cost</td>
                                                 <td style="background-color:#ddd;">' . $row->rate * $row->count . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Currency</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task File</td>
                                                 <td style="background-color:#ddd;">' . $file . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Instructions</td>
                                                 <td style="background-color:#ddd;">' . $row->insrtuctions . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Start Date</td>
                                                 <td style="background-color:#ddd;">' . $row->start_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Delivery Date</td>
                                                 <td style="background-color:#ddd;">' . $row->delivery_date . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Time Zone</td>
                                                 <td style="background-color:#ddd;">' . $this->admin_model->getTimeZone($row->time_zone) . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        }

        //echo $msg;
        $this->email->message($msg);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function sendVPOMail($id, $user, $brand)
    {
        $row = self::getTaskData($id);
        $job = self::getJobData($row->job_id);
        $jobPrice = self::getJobPriceListData($job->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);

        $vendor = $this->vendor_model->getVendorData($row->vendor);
        $mailTo = $vendor->email;
        $subject = "Vendor VPO : " . $row->subject;
        $total = $row->count * $row->rate;

        if ($brand == 1) {

            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            $this->email->to($mailTo);
            $this->email->subject($subject);
            $this->email->cc($pmMail . ', vm@thetranslationgate.com, accountspayable@thetranslationgate.com');
            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td style="font-size:bold;"><img src="' . base_url() . 'assets/images/logo_ar.png" alt="" style="width:50%;"></td>
                                                 <td><p>3A Almashtal st, Taksim Elshishiny Corniche El-Nil,</p><p>Maadi, Cairo 11511 - EGYPT </p> Tel: +202 2528 1190 </p><p> Fax: +202 2528 3816 info@thetranslationgate.com </p> <p>www.thetranslationgate.com<p></td>
                                            </tr>
                                            <tr>
                                            Click Here to Download Your PO File <a href="' . base_url() . 'po/download?t=' . base64_encode($row->id) . '" target="_blank">Click Here ..</a>
                                            </tr>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ffff06;color:#ff0606;text-align:left;font-size:18px;">
                                                    <p>Dear our valued Vendor, please take into consideration the below conditions:</p>
                                                    <p>• Payments will be processed within 45 to 60 days from date of receiving your invoice by 
                                                    accountspayable@thetranslationgate.com.</p>
                                                    <p>• Once you submit your work to our PM, please send your invoice along with the PO number received
                                                    from our PM via email to accountspayable@thetranslationgate.com.</p>
                                                    <p>• The company is not responsible for any payment delay due to sending the invoice to the incorrect 
                                                    contact/person, The invoice must be sent to: accountspayable@thetranslationgate.com.</p>
                                                    <p>• If any delay from your side to send your invoice once you finished the work, so it is not the company' . "'" . 's 
                                                    responsibility, and the normal duration paymnet will be applied "45 to 60 days from date of receiving your late invoice".</p> 
                                                    <p>• PLEASE DO NOT SEND your invoice to the Project/Vendor Manager. Invoices MUST ONLY be sent to accountspayable@thetranslationgate.com, if you wish you can keep the PM cced. </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td colspan=2 style="background-color: #622422;color: white;">PO</td>
                                            <td colspan=2 style="background-color:#fc6;color: black;">' . $row->code . '</td>
                                           </tr>
                                           <tr>
                                            <td style="background-color: #622422;color: white;">Project Manager</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getAdmin($user) . '</td>
                                            <td style="background-color: #622422;color: white;">PO Date</td>
                                            <td style="background-color:#fc6;color: black;">' . $row->delivery_date . '</td>
                                           </tr>
                                           <tr>
                                            <td style="background-color: #622422;color: white;">Service</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getServices($jobPrice->service) . '</td>
                                            <td style="background-color: #622422;color: white;">Vendor Name</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                           </tr>
                                           <tr>
                                           <td style="background-color: #622422;color: white;">Source</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            <td style="background-color: #622422;color: white;">Vendor Email</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->vendor_model->getVendorData($row->vendor)->email . '</td>
                                           </tr>
                                           <tr>
                                           <td style="background-color: #622422;color: white;">Target</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            <td style="background-color: #622422;color: white;">Contact Person</td>
                                            <td style="background-color:#fc6;color: black;"></td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td style="background-color: #622422;color: white;">Task Name</td>
                                            <td style="background-color: #622422;color: white;">Volume</td>
                                            <td style="background-color: #622422;color: white;">Unit</td>
                                            <td style="background-color: #622422;color: white;">Rate</td>
                                            <td style="background-color: #622422;color: white;">Price</td>
                                           </tr>
                                           <tr>
                                            <td style="background-color: #fc6;color: black;">' . $row->subject . '</td>
                                            <td style="background-color: #fc6;color: black;">' . $row->count . '</td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            <td style="background-color: #fc6;color: black;">' . $row->rate . '</td>
                                            <td style="background-color: #fc6;color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background-color: #fc6;color: black;">Total</td>
                                            <td style="background-color: #fc6;color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background-color:#fc6;color: black;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;font-size:18px;">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ffff06;color:black;text-align:left;">
                                                 <p style="color:red;font-weight: bold;text-decoration: underline;">Terms & Conditions:</p> 
                                                <p>• Vendors must Include "The Translation Gate" PO Number in their invoices. </p>
                                                <p>• Payment transfer fees will be divided 50-50 between the company and the vendor.</p>
                                                <p>• Your invoice should include the payment methods with full and correct details, and "The Translation Gate" is not responsible for 
                                                any payment delays caused by incorrect details that the Vendor submits on the payment invoices.  
                                                <p>• We use Money Bookers or PayPal  for the amounts less than 300 USD, Western union for the amounts from 300 to 700 USD or 
                                                Bank transfers for the amounts more than 700 USD.</p>
                                                <p>• Any change or editing in the PO content should be made only through the direct PM, otherwise the PO will be cancelled. 
                                                <p>• Failure to comply with job instructions will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• Deadline extensions can ONLY be requested 12 hours before the job.' . "'" . 's deadline and will be reviewed if applicable, and failure to meet the deadlines requested in this PO will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• If the service quality is below the accepted standards, deductions or job cancellation might be applied.</p>
                                                <p>• This PO will be considered "cancelled", if our PM did not receive an email confirmation of accepting the job, and indicating fully 
                                                understanding of the job.' . "'" . 's instructions, and accepting the delivery deadline.</p>
                                                <p>• Payments expire after 1 year from task delivery dates.</p>
                                                 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } else if ($brand == 3) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->subject($subject);
            $this->email->cc($pmMail . ', vm@europelocalize.com');
            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td style="font-size:bold;"><img src="' . base_url() . 'assets/images/europe.png" alt="" style="width:50%;"></td>
                                                 <td><p>Ul. Borowej Góry 6/64, 01-354 Warsaw, Poland</p><p>Tel: + 48 (22) 163 42 63</p></td>
                                            </tr>
                                            <tr>
                                            Click Here to Download Your PO File <a href="' . base_url() . 'po/download?t=' . base64_encode($row->id) . '" target="_blank">Click Here ..</a>
                                            </tr>
                                            <tr>
                                                 <td colspan=2 style="background-color: #06b8e8;color:#d306e8;text-align:left;">
                                                 <p style="color:red;font-weight: bold;text-decoration: underline;">Terms & Conditions:</p> 
                                                <p>• Vendors must Include "Europe Localize" PO Number in their invoices. </p>
                                                <p>• Payment transfer fees will be divided 50-50 between the company and the vendor.</p>
                                                <p>• Your invoice should include the payment methods with full and correct details, and "Europe Localize" is not responsible for 
                                                any payment delays caused by incorrect details that the Vendor submits on the payment invoices.  
                                                <p>• We use Money Bookers or PayPal  for the amounts less than 300 USD, Western union for the amounts from 300 to 700 USD or 
                                                Bank transfers for the amounts more than 700 USD.</p>
                                                <p>• Any change or editing in the PO content should be made only through the direct PM, otherwise the PO will be cancelled. 
                                                <p>• Failure to comply with job instructions will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• Deadline extensions can ONLY be requested 12 hours before the job.' . "'" . 's deadline and will be reviewed if applicable, and failure to meet the deadlines requested in this PO will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• If the service quality is below the accepted standards, deductions or job cancellation might be applied.</p>
                                                <p>• This PO will be considered "cancelled", if our PM did not receive an email confirmation of accepting the job, and indicating fully 
                                                understanding of the job.' . "'" . 's instructions, and accepting the delivery deadline.</p>
                                                <p>• Payments expire after 1 year from task delivery dates.</p>
                                                 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td colspan=2 style="color: #d306e8;">PO</td>
                                            <td colspan=2 style="color: black;">' . $row->code . '</td>
                                           </tr>
                                           <tr>
                                            <td style="color: #d306e8;">Project Manager</td>
                                            <td style="color: black;">' . $this->admin_model->getAdmin($user) . '</td>
                                            <td style="color: #d306e8;">PO Date</td>
                                            <td style="color: black;">' . $row->delivery_date . '</td>
                                           </tr>
                                           <tr>
                                            <td style="color: #d306e8;">Service</td>
                                            <td style="color: black;">' . $this->admin_model->getServices($jobPrice->service) . '</td>
                                            <td style="color: #d306e8;">Vendor Name</td>
                                            <td style="color: black;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                           </tr>
                                           <tr>
                                           <td style="color: #d306e8;">Source</td>
                                            <td style="color: black;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            <td style="color: #d306e8;">Vendor Email</td>
                                            <td style="color: black;">' . $this->vendor_model->getVendorData($row->vendor)->email . '</td>
                                           </tr>
                                           <tr>
                                           <td style="color: #d306e8;">Target</td>
                                            <td style="color: black;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            <td style="color: #d306e8;">Contact Person</td>
                                            <td style="color: black;"></td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td style="color: #d306e8;">Task Name</td>
                                            <td style="color: #d306e8;">Volume</td>
                                            <td style="color: #d306e8;">Unit</td>
                                            <td style="color: #d306e8;">Rate</td>
                                            <td style="color: #d306e8;">Price</td>
                                           </tr>
                                           <tr>
                                            <td style="color: black;">' . $row->subject . '</td>
                                            <td style="color: black;">' . $row->count . '</td>
                                            <td style="color: black;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            <td style="color: black;">' . $row->rate . '</td>
                                            <td style="color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="color: black;">Total</td>
                                            <td style="color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="color: black;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;font-size:18px;">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #06b8e8;color:#d306e8;text-align:left;">
                                                    <p>Dear our valued Vendor, please take into consideration the below conditions:</p>
                                                    <p>• Payments will be processed within 45 to 60 days from date of receiving your invoice by 
                                                     belgin.cemil@europelocalize.com.</p>
                                                    <p>• Once you submit your work to our PM, please send your invoice along with the PO number received
                                                    from our PM via email to  belgin.cemil@europelocalize.com.</p>
                                                    <p>• The company is not responsible for any payment delay due to sending the invoice to the incorrect 
                                                    contact/person, The invoice must be sent to:  belgin.cemil@europelocalize.com.</p>
                                                    <p>• If any delay from your side to send your invoice once you finished the work, so it is not the company' . "'" . 's 
                                                    responsibility, and the normal duration paymnet will be applied "45 to 60 days from date of receiving your late invoice".</p> 
                                                    <p>• PLEASE DO NOT SEND your invoice to the Project/Vendor Manager. Invoices MUST ONLY be sent to  belgin.cemil@europelocalize.com, if you wish you can keep the PM cced. </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } else if ($brand == 2) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->subject($subject);
            $this->email->cc($pmMail . ', vm@localizera.com');
            $msg = '<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td style="font-size:bold;"><img src="' . base_url() . 'assets/images/dtp_zone.png" alt="" style="width:50%;"></td>
                                                 <td><p>3 Saad Zallam St. El Maddi – Cairo – Egypt.</p><p>Mobile: +2 01020666959</p><p>Phone: +2 02 25276200</p><p>Fax: +2 02 25283816</p></td>
                                            </tr>
                                            <tr>
                                            Click Here to Download Your PO File <a href="' . base_url() . 'po/download?t=' . base64_encode($row->id) . '" target="_blank">Click Here ..</a>
                                            </tr>
                                            <tr>
                                                 <td colspan=2 style="background-color: #06b8e8;color:#d306e8;text-align:left;">
                                                 <p style="color:red;font-weight: bold;text-decoration: underline;">Terms & Conditions:</p> 
                                                <p>• Vendors must Include "DTP Zone" PO Number in their invoices. </p>
                                                <p>• Payment transfer fees will be divided 50-50 between the company and the vendor.</p>
                                                <p>• Your invoice should include the payment methods with full and correct details, and "DTP Zone" is not responsible for 
                                                any payment delays caused by incorrect details that the Vendor submits on the payment invoices.  
                                                <p>• We use Money Bookers or PayPal  for the amounts less than 300 USD, Western union for the amounts from 300 to 700 USD or 
                                                Bank transfers for the amounts more than 700 USD.</p>
                                                <p>• Any change or editing in the PO content should be made only through the direct PM, otherwise the PO will be cancelled. 
                                                <p>• Failure to comply with job instructions will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• Deadline extensions can ONLY be requested 12 hours before the job.' . "'" . 's deadline and will be reviewed if applicable, and failure to meet the deadlines requested in this PO will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                                <p>• If the service quality is below the accepted standards, deductions or job cancellation might be applied.</p>
                                                <p>• This PO will be considered "cancelled", if our PM did not receive an email confirmation of accepting the job, and indicating fully 
                                                understanding of the job.' . "'" . 's instructions, and accepting the delivery deadline.</p>
                                                <p>• Payments expire after 1 year from task delivery dates.</p>
                                                 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td colspan=2 style="color: #d306e8;">PO</td>
                                            <td colspan=2 style="color: black;">' . $row->code . '</td>
                                           </tr>
                                           <tr>
                                            <td style="color: #d306e8;">Project Manager</td>
                                            <td style="color: black;">' . $this->admin_model->getAdmin($user) . '</td>
                                            <td style="color: #d306e8;">PO Date</td>
                                            <td style="color: black;">' . $row->delivery_date . '</td>
                                           </tr>
                                           <tr>
                                            <td style="color: #d306e8;">Service</td>
                                            <td style="color: black;">' . $this->admin_model->getServices($jobPrice->service) . '</td>
                                            <td style="color: #d306e8;">Vendor Name</td>
                                            <td style="color: black;">' . $this->vendor_model->getVendorName($row->vendor) . '</td>
                                           </tr>
                                           <tr>
                                           <td style="color: #d306e8;">Source</td>
                                            <td style="color: black;">' . $this->admin_model->getLanguage($jobPrice->source) . '</td>
                                            <td style="color: #d306e8;">Vendor Email</td>
                                            <td style="color: black;">' . $this->vendor_model->getVendorData($row->vendor)->email . '</td>
                                           </tr>
                                           <tr>
                                           <td style="color: #d306e8;">Target</td>
                                            <td style="color: black;">' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                            <td style="color: #d306e8;">Contact Person</td>
                                            <td style="color: black;"></td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                           <tr>
                                            <td style="color: #d306e8;">Task Name</td>
                                            <td style="color: #d306e8;">Volume</td>
                                            <td style="color: #d306e8;">Unit</td>
                                            <td style="color: #d306e8;">Rate</td>
                                            <td style="color: #d306e8;">Price</td>
                                           </tr>
                                           <tr>
                                            <td style="color: black;">' . $row->subject . '</td>
                                            <td style="color: black;">' . $row->count . '</td>
                                            <td style="color: black;">' . $this->admin_model->getUnit($row->unit) . '</td>
                                            <td style="color: black;">' . $row->rate . '</td>
                                            <td style="color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="color: black;">Total</td>
                                            <td style="color: black;">' . $row->count * $row->rate . '</td>
                                           </tr>
                                           <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="color: black;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                           </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;font-size:18px;">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #06b8e8;color:#d306e8;text-align:left;">
                                                    <p>Dear our valued Vendor, please take into consideration the below conditions:</p>
                                                    <p>• Payments will be processed within 45 to 60 days from date of receiving your invoice by 
                                                     mira.mohammed@dtpzone.com.</p>
                                                    <p>• Once you submit your work to our PM, please send your invoice along with the PO number received
                                                    from our PM via email to  mira.mohammed@dtpzone.com.</p>
                                                    <p>• The company is not responsible for any payment delay due to sending the invoice to the incorrect 
                                                    contact/person, The invoice must be sent to:  mira.mohammed@dtpzone.com.</p>
                                                    <p>• If any delay from your side to send your invoice once you finished the work, so it is not the company' . "'" . 's 
                                                    responsibility, and the normal duration paymnet will be applied "45 to 60 days from date of receiving your late invoice".</p> 
                                                    <p>• PLEASE DO NOT SEND your invoice to the Project/Vendor Manager. Invoices MUST ONLY be sent to  mira.mohammed@dtpzone.com, if you wish you can keep the PM cced. </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        } elseif ($brand == 11) {
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
                'smtp_port' => 25,
                'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
                'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
                'charset' => 'utf-8',
                'validate' => TRUE,
                'wordwrap' => TRUE,

            );

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($pmMail);
            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);
            $this->email->subject($subject);

            $this->email->cc($pmMail . ', vendormanagement@columbuslang.com, projectmanagement@columbuslang.com, invoices@columbuslang.com');
            $msg = '<!DOCTYPE html>
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
                                td {
                                    padding: 0.5em;
                                    padding-right: 1em;
                                    }
                                </style>
                                <!--Core js-->
                            </head>
            
                            <body>
                            <div class="panel-body">
                                            <div class="adv-table editable-table ">
                                                <div class="clearfix">
                                                    <div class="btn-group">
                                                        <span class=" btn-primary" style="">
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="space15"></div>
                                                
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: center">
                                                    <tbody>
                                                        <tr>
                                                             <td style="font-size:bold;"><img src="' . base_url() . 'assets/images/columbus_logo.jpg" alt="" style="width:50%;"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                <tr style="font-size: 16px;color:black;"> 
                                                    <td style="width: 40%;border-bottom:2px dotted gray;">
                                                       SELLER   
                                                    </td>
                                                    <td style="width: 40%; border-bottom:2px dotted gray;">
                                                       BUYER 
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>Columbus Lang</td>
                                                    <td>' . $vendor->name . '</td>
                                                </tr>
                                                <tr>
                                                    <td>7438 RESTFUL STREET WINTER PARK, fl. 32792</td>
                                                    <td>' . $this->admin_model->getCountry($vendor->country) . '</td>
                                                </tr>
                                                <tr>
                                                    <td>8885550104 <br> 8885550105</td>
                                                    <td>' . $vendor->contact . '</td>
                                                </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: center">
                                                    <tbody>
                                                      <tr>
                                                        <br>
                                                      </tr>
                                                    </tbody>
                                                </table>
            
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left;">
                                                    <tbody>
                                                        <tr style="font-size: 16px;color:black;"> 
                                                             <td style="width: 25%;border-bottom:2px dotted gray;">
                                                               SALESPERSON    
                                                            </td>
                                                            <td style="width: 25%;border-bottom:2px dotted gray;">
                                                               PO NUMBER  
                                                            </td>
                                                            
                                                            <td style="width: 25%;border-bottom:2px dotted gray;">
                                                               Languages  
                                                            </td>
                                                            <td style="width: 25%;border-bottom:2px dotted gray;">
                                                               Service  
                                                            </td>
                                                        </tr>
                                                         <tr>
                                                        <td>' . $this->admin_model->getAdmin($row->created_by) . '</td>
                                                        <td>' . $row->code . '</td>
                                                        <td>' . $this->admin_model->getLanguage($jobPrice->source) . '->' . $this->admin_model->getLanguage($jobPrice->target) . '</td>
                                                        <td>' . $this->admin_model->getServices($this->admin_model->getTaskTypeParent($row->task_type)) . '</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                               <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                      <tr>
                                                        <br>
                                                      </tr>
                                                    </tbody>
                                                </table>
            
                                                 
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                      <tr>
                                                        <hr style="border-top:1px dotted gray;">
                                                        <hr style="border-top:1px dotted gray;">
                                                        <hr style="border-top:1px dotted gray;">
                                                      </tr>
                                                    </tbody>
                                                </table> 
            
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                      <tr style="font-size: 16px;color:black;"> 
                                                        <td style=" width:33%;border-bottom:2px dotted gray;">
                                                           QUANTITY   
                                                        </td>
                                                        
                                                        <td style="width:33%;border-bottom:2px dotted gray;">
                                                           PRICE    
                                                        </td> 
                                                        <td style="width:33%;border-bottom:2px dotted gray;">
                                                           AMOUNT    
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td>' . $row->count . '</td>
                                                        <td>' . $row->rate . '</td>
                                                        <td>' . $row->count . '</td>
                                                        
                                                    </tr>
            
                                                    </tbody>
                                                </table>
                                                 <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                      <tr>
                                                        <br>
                                                        <br>
                                                        <br>
                                                      </tr>
                                                    </tbody>
                                                </table> 
                                                 <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                       <tr>
                                                           <td style="width: 33%;"> </td>
                                                           <td style="width: 33%;">Total</td>
                                                           <td style="width: 33%;">' . $total . '</td>
                                                       </tr>
                                                       
                                                    </tbody>
                                                </table> 
                                                 <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;text-align: left">
                                                    <tbody>
                                                      <tr>
                                                        <hr style="border-top:1px dotted gray;">
                                                        <hr style="border-top:1px dotted gray;">
                                                        <hr style="border-top:1px dotted gray;">
                                                      </tr>
                                                    </tbody>
                                                </table> 
                                                <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;width: 100%;font-size:18px;">
                                                    <tbody>
                                                        <tr>
                                                             <td colspan=2 style="color:black;text-align:left;">
                                                              <p style="color:black;font-weight: bold;border-bottom:2px dotted gray;">TERMS OF AGREEMENT</p> 
                                                            <p>Payments will be processed within 45 to 60 days from date of receiving your invoice by invoices@columbuslang.com </p>
                                                            <p>The company is not responsible for any payment delay due to sending the invoice to the incorrect contact/person, 
                                                             The invoice must be sent to: invoices@columbuslang.com</p>
                                                             </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                      </div>
                            </body>
                            </html>';
        }
        //echo $msg;
        $this->email->message($msg);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function getProjectStatus($status = "")
    {
        if ($status == 0) {
            echo "Running";
        } elseif ($status == 1) {
            echo "Closed";
        }
    }

    public function getNewProjectStatus($status = "", $projectId = "")
    {
        $projectStatus = $this->checkCloseProject($projectId);
        if ($projectStatus == 1) {
            echo "Closed";
        } else {
            echo "Running";
        }
    }


    public function selectProjectStatus($select = "")
    {
        if ($select == 0) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '<option value="0" ' . $selected1 . '>Running</option>
                  <option value="1" ' . $selected2 . '>Closed</option>';
        return $outpt;
    }

    public function getJobStatus($status = "")
    {
        if ($status == 0) {
            echo "Running";
        } elseif ($status == 1) {
            echo "Delivered";
        } elseif ($status == 2) {
            echo "Cancelled";
        } elseif ($status == 4) {
            echo "Waiting Vendor Acceptance";
        } elseif ($status == 3) {
            // from vendor
            echo "Rejected";
        } elseif ($status == 5) {
            echo "Waiting PM Confirmation";
        } elseif ($status == 6) {
            echo "Not Started Yet";
        } elseif ($status == 7) {
            echo "Heads Up ";
        } elseif ($status == 8) {
            echo "Heads Up ( Marked as Available )";
        } elseif ($status == 9) {
            echo "Heads Up ( Marked as Not Available )";
        }
    }

    public function selectJobStatus($select = "")
    {
        if ($select == 0) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '<option value="0" ' . $selected1 . '>Running</option>
                  <option value="1" ' . $selected2 . '>Delivered</option>';
        return $outpt;
    }

    // public function checkCloseJob($job){
    // $tasksNum = $this->db->query(" SELECT * FROM `job_task` WHERE status <> 2 AND job_id = '$job'  ")->num_rows();
    // $DTPNum = $this->db->query(" SELECT * FROM `dtp_request` WHERE status <> 0 AND job_id = '$job'  ")->num_rows();
    // $translationNum = $this->db->query(" SELECT * FROM `translation_request` WHERE status <> 0 AND job_id = '$job'  ")->num_rows();
    // $closedTaskNum = $this->db->get_where('job_task',array('job_id'=>$job,'status'=>1))->num_rows();
    // $closedDTPNum = $this->db->get_where('dtp_request',array('job_id'=>$job,'status'=>3))->num_rows();
    // $closedTranslationNum = $this->db->get_where('translation_request',array('job_id'=>$job,'status'=>3))->num_rows();
    // if(($tasksNum + $DTPNum + $translationNum) == 0){
    // return false;
    // }else{
    // if(($tasksNum + $DTPNum + $translationNum) === ($closedTaskNum + $closedDTPNum + $closedTranslationNum)){
    // return true;
    // }else{
    // return false;
    // }
    // }
    // }

    public function checkCloseJob($job)
    {
        $tasksNum = $this->db->query(" SELECT * FROM `job_task` WHERE status <> 2 AND job_id = '$job'  ")->num_rows();
        $DTPNum = $this->db->query(" SELECT * FROM `dtp_request` WHERE (status <> 0 AND status <> 4) AND job_id = '$job'  ")->num_rows();
        $translationNum = $this->db->query(" SELECT * FROM `translation_request` WHERE (status <> 0 AND status <> 4) AND job_id = '$job'  ")->num_rows();
        $LeTasksNum = $this->db->query(" SELECT * FROM `le_request` WHERE (status <> 0 AND status <> 4) AND job_id = '$job'  ")->num_rows();
        $closedTaskNum = $this->db->get_where('job_task', array('job_id' => $job, 'status' => 1))->num_rows();
        $closedDTPNum = $this->db->get_where('dtp_request', array('job_id' => $job, 'status' => 3))->num_rows();
        $closedTranslationNum = $this->db->get_where('translation_request', array('job_id' => $job, 'status' => 3))->num_rows();
        $closedLeNum = $this->db->get_where('le_request', array('job_id' => $job, 'status' => 3))->num_rows();
        if (($tasksNum + $DTPNum + $translationNum + $LeTasksNum) == 0) {
            return false;
        } else {
            if (($tasksNum + $DTPNum + $translationNum + $LeTasksNum) === ($closedTaskNum + $closedDTPNum + $closedTranslationNum + $closedLeNum)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkProjectPo($po, $select)
    {
        $check = $this->db->get_where('po', array('number' => trim($po)));
        if ($check->num_rows() > 0) {
            $poId = $check->row()->id;
            $jobIds = $this->db->query(" SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM job WHERE po = '$poId' ")->row();
            if ($select == $jobIds->ids) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function checkCloseProject($project)
    {
        $jobsNum = $this->db->get_where('job', array('project_id' => $project))->num_rows();
        $closedJobNum = $this->db->get_where('job', array('project_id' => $project, 'status' => 1))->num_rows();
        if ($jobsNum == 0) {
            return false;
        } else {
            if ($jobsNum === $closedJobNum) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function totalRevenueProject($id)
    {
        $jobs = $this->db->get_where('job', array('project_id' => $id))->result();
        $data['total'] = 0;
        foreach ($jobs as $job) {
            $total = 0;
            $priceList = self::getJobPriceListData($job->price_list);
            $data['currency'] = $priceList->currency;
            if ($job->type == 1) {
                $total = $priceList->rate * $job->volume;
            } elseif ($job->type == 2) {
                $fuzzy = $this->db->get_where('project_fuzzy', array('job' => $job->id))->result();
                $total = 0;
                foreach ($fuzzy as $row) {
                    $total = $total + ($row->unit_number * $row->value * $priceList->rate);
                }
            }
            $data['total'] = $data['total'] + $total;
        }

        return $data;
    }

    public function totalRevenuePO($id)
    {
        $jobs = $this->db->get_where('job', array('po' => $id))->result();
        $data['total'] = 0;
        foreach ($jobs as $job) {
            $total = 0;
            $priceList = self::getJobPriceListData($job->price_list);
            $data['currency'] = $priceList->currency;
            if ($job->type == 1) {
                $total = $priceList->rate * $job->volume;
            } elseif ($job->type == 2) {
                $fuzzy = $this->db->get_where('project_fuzzy', array('job' => $job->id))->result();
                $total = 0;
                foreach ($fuzzy as $row) {
                    $total = $total + ($row->unit_number * $row->value * $priceList->rate);
                }
            }
            $data['total'] = $data['total'] + $total;
        }

        return $data;
    }

    public function totalTaskProject($id)
    {
        $job_ids = $this->db->query(" SELECT GROUP_CONCAT(id SEPARATOR ',') AS job_ids FROM job WHERE project_id = '$id' ")->row()->job_ids;
        if ($job_ids == NULL) {
            $job_ids = 0;
        }
        $task = $this->db->query(" SELECT * FROM `job_task` WHERE job_id IN (" . $job_ids . ") ")->result();
        $total = 0;
        foreach ($task as $task) {
            $total = $total + ($task->rate * $task->count);
        }
        return $total;
    }

    public function allJobs($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE project_id <> 0 AND " . $filter . " HAVING brand = '$brand' order by id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE j.created_by = '$user' AND project_id <> 0 AND " . $filter . " HAVING brand = '$brand' order by id desc ");
        }
        return $data;
    }

    public function allJobsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE project_id <> 0
                HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE j.created_by = '$user' AND project_id <> 0 HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllTasks($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT j.*,l.source,l.target,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job_task AS j 
                LEFT OUTER JOIN job AS p on j.job_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = p.price_list
                WHERE job_id <> 0 AND " . $filter . " HAVING brand = '$brand' order by id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT j.*,l.source,l.target,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job_task AS j 
                LEFT OUTER JOIN job AS p on j.job_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = p.price_list
                WHERE j.created_by = '$user' AND job_id <> 0 AND " . $filter . " HAVING brand = '$brand' order by id desc ");
        }
        return $data;
    }


    public function AllTasksPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT j.*,l.source,l.target,l.rate,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job_task AS j 
                LEFT OUTER JOIN job AS p on j.job_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = p.price_list
                WHERE project_id <> 0
                HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT j.*,l.source,l.target,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job_task AS j 
                LEFT OUTER JOIN job AS p on j.job_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = p.price_list
                WHERE j.created_by = '$user' AND job_id <> 0 HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function sendRejectMail($data, $pm, $opportunity)
    {
        $row = $this->db->get_where('sales_opportunity', array('id' => $opportunity))->row();
        $sam = $this->db->get_where('users', array('id' => $row->created_by))->row();
        $pmMail = $this->db->get_where('users', array('id' => $pm))->row()->email;
        $mailTo = $sam->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";

        $subject = "Opportunity Rejected #" . $opportunity . " - " . date("Y-m-d H:i:s");

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
                    <p>Dear ' . $sam->user_name . ',</p>
                       <p>Please check your Opportunity #' . $opportunity . ' </p>
                       <p>PM Comment : ' . $data['reject_reason'] . '</p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendVendorCancelTaskMail($id, $user, $brand)
    {
        $data['row'] = $row = self::getTaskData($id);
        $data['job'] = $job = self::getJobData($row->job_id);
        $data['jobPrice'] = $jobPrice = self::getJobPriceListData($job->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);
        $vendor = $this->vendor_model->getVendorData($row->vendor);
        $mailTo = $vendor->email;

        $subject = "Nexus || Task Cancelled : " . $row->code;
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        if ($brand == 1) {
            $this->email->cc($pmMail . ', vm@thetranslationgate.com');
        } elseif ($brand == 3) {
            $this->email->cc($pmMail . ', vm@europelocalize.com');
        } elseif ($brand == 2) {
            $this->email->cc($pmMail . ', vm@localizera.com');
        } elseif ($brand == 11) {
            $this->email->cc($pmMail . ', Vendormanagement@Columbuslang.com');
        }
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("nexus/cancel_task.php", $data, true);
        $this->email->from($pmMail);
        $this->email->to($mailTo);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function AllCustomerJobs($permission, $user, $brand)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `job_customer` AS p WHERE p.status = '0' HAVING brand = '$brand' ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand,(SELECT COUNT(*) FROM customer_pm WHERE customer_pm.lead = p.lead AND customer_pm.pm = '$user') AS total FROM `job_customer` AS p WHERE p.status = '0' HAVING total > 0 AND brand = '$brand' ");
        }
        return $data;
    }

    public function getJobPoData($id)
    {
        $po = $this->db->get_where('po', array('id' => $id))->row();
        return $po;
    }

    public function lateDeliveryReport($filter, $brand)
    {
        $jobs = $this->db->query(" SELECT j.*,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM `job` AS j WHERE j.status = '0' AND j.delivery_date IS NOT NULL AND " . $filter . " HAVING brand = '$brand' ");
        return $jobs;
    }

    public function clientAllJobs($permission, $user, $brand, $filter)
    {
        $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.lead = p.lead) AS total FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE project_id <> 0 AND " . $filter . " HAVING total > '0' order by id desc ");
        return $data;
    }

    public function clientAllJobsPages($permission, $user, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.lead = p.lead) AS total FROM job AS j 
                LEFT OUTER JOIN project AS p on j.project_id = p.id
                LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
                WHERE project_id <> 0
                HAVING total > '0' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function returnDTPTakenTime($task, $stoped)
    {
        $dtpHistory = $this->db->get_where('dtp_request_history', array('task' => $task));
        $LastRunning = $this->db->query(" SELECT * FROM `dtp_request_history` WHERE task = '$task' AND status = 1 ORDER BY id desc ")->row();
        $started = strtotime($LastRunning->created_at);
        $stoped = strtotime($stoped);

        $taken = $stoped - $started;
        return $taken / (60 * 60);
    }

    public function getDTPJobTime($jobId)
    {
        $time = $this->db->query("SELECT SUM(taken_time) AS totalTime FROM `dtp_request_history` WHERE `task` = '$jobId' ")->row();
        $timeTotal = explode(".", $time->totalTime);
        // print_r($timeTotal);
        $data['hrs'] = round($timeTotal[0]);
        $data['mins'] = round(($time->totalTime - $timeTotal[0]) * 60);
        return $data;
    }

    public function getDTPRate($target_direction, $source_application, $translation_in)
    {
        $data = $this->db->get_where('dtp_rates', array('target_direction' => $target_direction, 'source_application' => $source_application, 'translation_in' => $translation_in));
        if ($data->num_rows() > 0) {
            return $data->row()->rate;
        } else {
            return "";
        }
    }

    public function getDTPTaskStatus($status = "")
    {
        if ($status == 1) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Waiting Confirmation</span>';
        } elseif ($status == 2) {
            echo '<span class="badge badge-danger p-2" style="background-color: #07b817">Running</span>';
        } elseif ($status == 0) {
            echo '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } elseif ($status == 3) {
            echo '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Closed</span>';
        } elseif ($status == 5) {
            echo '<span class="badge badge-danger p-2" style="background-color: #6303A5">Update</span>';
        } elseif ($status == 4) {
            echo '<span class="badge badge-danger p-5" style="background-color: #FF5733">Cancelled</span>';
        } elseif ($status == 6) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Not Started Yet</span>';
        } elseif ($status == 7) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Heads Up ( Waiting Response )</span>';
        } elseif ($status == 8) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Heads Up ( Marked as Available )</span>';
        } elseif ($status == 9) {
            echo '<span class="badge badge-danger p-2" style="background-color: #FF5733">Heads Up ( Marked as Not Available )</span>';
        }
    }

    public function newDtpTasks($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE status = 1 HAVING brand = '$brand' ");
        return $data;
    }

    public function AllDTPTasks($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE " . $filter . " AND status_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        }
        return $data;
    }

    public function AllDTPTasksPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE status_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllDTPPm($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE " . $filter . " AND created_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        }
        return $data;
    }


    public function AllDTPJobs($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` WHERE " . $filter . " AND dtp = '$user' HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllDTPJobsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = dtp_request_job.created_by) AS brand FROM `dtp_request_job` WHERE dtp = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function getTranslationTaskStatus($status = "")
    {
        if ($status == 1) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Waiting Confirmation</span>';
        } elseif ($status == 2) {
            echo '<span class="badge badge-danger p-2" style="background-color: #07b817">Running</span>';
        } elseif ($status == 0) {
            echo '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } elseif ($status == 3) {
            echo '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Closed</span>';
        } elseif ($status == 5) {
            echo '<span class="badge badge-danger p-2" style="background-color: #6303A5">Update</span>';
        } elseif ($status == 4) {
            echo '<span class="badge badge-danger p-2" style="background-color: #FF5733">Cancelled</span>';
        } elseif ($status == 6) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Not Started Yet</span>';
        } elseif ($status == 7) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Heads Up ( Waiting Response )</span>';
        } elseif ($status == 8) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Heads Up ( Marked as Available )</span>';
        } elseif ($status == 9) {
            echo '<span class="badge badge-danger p-2" style="background-color: #FF5733">Heads Up ( Marked as Not Available )</span>';
        }
    }

    public function newTranslationTasks($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE status = 1 HAVING brand = '$brand' ");
        return $data;
    }

    public function AllTranslationTasks($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5 AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, delivery_date ASC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE " . $filter . " AND status_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5 AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, delivery_date ASC ");
        }
        return $data;
    }

    public function AllTranslationTasksPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where `id` = translation_request.created_by) AS `brand` FROM `translation_request` WHERE (status <> 0 AND (`status` <> 1 AND `status` <> 5 AND `status` < 6)) HAVING `brand` = '$brand' ORDER BY `status` ASC, `delivery_date` ASC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where `id` = translation_request.created_by) AS `brand` FROM `translation_request` WHERE `status_by` = '$user' AND (`status` <> 0 AND (`status` <> 1 AND `status` <> 5 AND `status` < 6)) HAVING `brand` = '$brand' ORDER BY `status` ASC, `delivery_date` ASC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllTranslationPm($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE " . $filter . " AND created_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        }
        return $data;
    }

    public function getTranslationJobStatus($status = "")
    {
        if ($status == 0) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Not Started</span>';
        } elseif ($status == 1) {
            echo '<span class="badge badge-danger p-2" style="background-color: #07b817">Running</span>';
        } elseif ($status == 3) {
            echo '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } elseif ($status == 2) {
            echo '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Closed</span>';
        } elseif ($status == 4) {
            echo '<span class="badge badge-danger p-2" style="background-color: #6303A5">Partly Closed</span>';
        }
    }

    public function AllTranslationJobs($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request_job.created_by) AS brand FROM `translation_request_job` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request_job.created_by) AS brand FROM `translation_request_job` WHERE " . $filter . " AND translator = '$user' HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllTranslationJobsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = translation_request_job.created_by) AS brand FROM `translation_request_job` HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = translation_request_job.created_by) AS brand FROM `translation_request_job` WHERE translator = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function returnTranslationTakenTime($task, $stoped)
    {
        $dtpHistory = $this->db->get_where('translation_request_history', array('task' => $task));
        $LastRunning = $this->db->query(" SELECT * FROM `translation_request_history` WHERE task = '$task' AND status = 1 ORDER BY id desc ")->row();
        $started = strtotime($LastRunning->created_at);
        $stoped = strtotime($stoped);

        $taken = $stoped - $started;
        return $taken / (60 * 60);
    }

    public function getTranslationJobTime($jobId)
    {
        $time = $this->db->query("SELECT SUM(taken_time) AS totalTime FROM `translation_request_history` WHERE `task` = '$jobId' ")->row();
        $timeTotal = explode(".", $time->totalTime);
        // print_r($timeTotal);
        $data['hrs'] = round($timeTotal[0]);
        $data['mins'] = round(($time->totalTime - $timeTotal[0]) * 60);
        return $data;
    }

    public function checkCloseTranslationRequest($request)
    {
        $allJobs = $this->db->get_where('translation_request_job', array('request_id' => $request))->num_rows();
        $closedJobs = $this->db->query(" SELECT * FROM `translation_request_job` WHERE request_id = '$request' AND (status = 2 OR status = 4 OR status = 3) ")->num_rows();
        if ($allJobs == 0) {
            return false;
        } else {
            if ($allJobs == $closedJobs) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getLETaskStatus($status = "")
    {
        if ($status == 1) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Waiting Confirmation</span>';
        } elseif ($status == 2) {
            echo '<span class="badge badge-danger p-2" style="background-color: #07b817">Running</span>';
        } elseif ($status == 0) {
            echo '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } elseif ($status == 3) {
            echo '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Closed</span>';
        } elseif ($status == 5) {
            echo '<span class="badge badge-danger p-2" style="background-color: #6303A5">Update</span>';
        } elseif ($status == 4) {
            echo '<span class="badge badge-danger p-5" style="background-color: #FF5733">Cancelled</span>';
        } elseif ($status == 6) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Not Started Yet</span>';
        } elseif ($status == 7) {
            echo '<span class="badge badge-danger p-2" style="background-color: #999">Heads Up ( Waiting Response )</span>';
        } elseif ($status == 8) {
            echo '<span class="badge badge-danger p-2" style="background-color: #e8e806">Heads Up ( Marked as Available )</span>';
        } elseif ($status == 9) {
            echo '<span class="badge badge-danger p-2" style="background-color: #FF5733">Heads Up ( Marked as Not Available )</span>';
        }
    }

    public function newLETasks($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE status = 1 HAVING brand = '$brand' ");
        return $data;
    }

    public function AllLETasks($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE " . $filter . " AND status_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        }
        return $data;
    }

    public function AllLETasksPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE status_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5  AND status < 6)) HAVING brand = '$brand' ORDER BY status ASC, id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }


    public function AllLEPm($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE " . $filter . " AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE " . $filter . " AND created_by = '$user' AND (status <> 0 AND (status <> 1 AND status <> 5)) HAVING brand = '$brand' ORDER BY status ASC, id DESC ");
        }
        return $data;
    }


    ////////request with no job

    public function AllLETasksNoJob($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE job_id = 0 AND " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE job_id = 0 AND " . $filter . " AND created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllLETasksPagesNoJob($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE job_id = 0 HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE job_id = 0 AND created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }


    /////////////////

    public function AllLEJobs($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request_job.created_by) AS brand FROM `le_request_job` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY status ASC , id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request_job.created_by) AS brand FROM `le_request_job` WHERE " . $filter . " AND le = '$user' HAVING brand = '$brand' ORDER BY status ASC , id DESC ");
        }
        return $data;
    }

    public function AllLEJobsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT *,(SELECT brand FROM `users` where id = le_request_job.created_by) AS brand FROM `le_request_job` HAVING brand = '$brand' ORDER BY status ASC , id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = le_request_job.created_by) AS brand FROM `le_request_job` WHERE le = '$user' HAVING brand = '$brand' ORDER BY status ASC , id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function checkCloseLERequest($request)
    {
        $allJobs = $this->db->get_where('le_request_job', array('request_id' => $request))->num_rows();
        $closedJobs = $this->db->query(" SELECT * FROM `le_request_job` WHERE request_id = '$request' AND (status = 2 OR status = 4 OR status = 3) ")->num_rows();
        if ($allJobs == 0) {
            return false;
        } else {
            if ($allJobs == $closedJobs) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkCloseDTPRequest($request)
    {
        $allJobs = $this->db->get_where('dtp_request_job', array('request_id' => $request))->num_rows();
        $closedJobs = $this->db->query(" SELECT * FROM `dtp_request_job` WHERE request_id = '$request' AND (status = 2 OR status = 4 OR status = 3) ")->num_rows();
        if ($allJobs == 0) {
            return false;
        } else {
            if ($allJobs == $closedJobs) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function returnLETakenTime($task, $stoped)
    {
        $dtpHistory = $this->db->get_where('le_request_history', array('task' => $task));
        $LastRunning = $this->db->query(" SELECT * FROM `le_request_history` WHERE task = '$task' AND status = 1 ORDER BY id desc ")->row();
        $started = strtotime($LastRunning->created_at);
        $stoped = strtotime($stoped);

        $taken = $stoped - $started;
        return $taken / (60 * 60);
    }

    public function getLEJobTime($jobId)
    {
        $time = $this->db->query("SELECT SUM(taken_time) AS totalTime FROM `le_request_history` WHERE `task` = '$jobId' ")->row();
        $timeTotal = explode(".", $time->totalTime);
        // print_r($timeTotal);
        $data['hrs'] = round($timeTotal[0]);
        $data['mins'] = round(($time->totalTime - $timeTotal[0]) * 60);
        return $data;
    }

    public function sendLERequestMail($id)
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail($requestData->created_by);
        $mailTo = "le@thetranslationgate.com";
        if (strlen($requestData->file) > 1) {
            $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/leRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
        } else {
            $attachment = '';
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";

        $subject = "New LE Request # LE-" . $id . " - " . $requestData->subject;

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
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>                        
                        <th>Task Code</th>
                        <th>Task Name</th>
                        <th>Task Type</th>
                        <th>Linguist Format</th>
                        <th>Deliverable Format</th>
                        <th>Unit</th>
                        <th>Volume</th>
                        <th>Complexicty</th>
                        <th>Rate</th>
                        <th>Start Date</th>
                        <th>Delivery Date</th>
                        <th>Task File</th>
                        <th>PM</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>                        
                        <td> LE-' . $requestData->id . '</td>
                        <td>' . $requestData->subject . '</td>
                        <td>' . $this->admin_model->getLETaskType($requestData->task_type) . '</td> ';
        if (is_numeric($requestData->linguist) && is_numeric($requestData->deliverable)) {
            $message .= ' <td>' . $this->admin_model->getLeFormat($requestData->linguist) . '</td>
                        <td>' . $this->admin_model->getLeFormat($requestData->deliverable) . '</td>';
        } else {
            $message .= '    <td>' . $requestData->linguist . '</td>
                        <td>' . $requestData->deliverable . '</td>';
        }
        $message .= '   <td>' . $this->admin_model->getUnit($requestData->unit) . '</td>
                        <td>' . $requestData->volume . '</td>
                        <td>' . $this->projects_model->getLeComplexictyForM($requestData->complexicty) . '</td> 
                        <td>' . $requestData->rate . '</td>
                        <td>' . $requestData->start_date . '</td>
                        <td>' . $requestData->delivery_date . '</td>
                        <td>' . $attachment . '</td>                            
                        <td>' . $this->admin_model->getAdmin($requestData->created_by) . '</td>
                        <td>' . $requestData->created_at . '</td>
                      </tr>
                      </tbody>
                    </table>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPRequestMail($id)
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail($requestData->created_by);
        if ($this->brand == 2) {
            $mailTo = "maged.kamel@localizera.com";
        } elseif ($this->brand == 3) {
            $mailTo = "dtp@europelocalize.com";
        } else {
            $mailTo = "dtp@thetranslationgate.com";
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";

        if (strlen($requestData->file) > 1) {
            $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/dtpRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
        } else {
            $attachment = '';
        }
        $subject = "New DTP Request # DTP-" . $id . " - " . $requestData->task_name;

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
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                        <th>Task Code</th>                       
                        <th>Task Name</th>
                        <th>Task Type</th>
                        <th>Volume</th>
                        <th>Unit</th>                       
                        <th>File Attachment</th>
                        <th>Start Date</th>
                        <th>Delivery Date</th>
                        <th>PM</th>
                        <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                          <td> DTP-' . $requestData->id . '</td>
                          <td>' . $requestData->task_name . '</td>
                          <td>' . $this->admin_model->getDTPTaskType($requestData->task_type) . '</td>
                          <td>' . $requestData->volume . '</td>
                           <td>' . $this->admin_model->getUnit($requestData->unit) . '</td>
                            <td>' . $attachment . '</td> 
                          <td>' . $requestData->start_date . '</td>
                          <td>' . $requestData->delivery_date . '</td>
                          <td>' . $this->admin_model->getAdmin($requestData->created_by) . '</td>
                          <td>' . $requestData->created_at . '</td>
                      </tr>
                      </tbody>
                    </table>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationRequestMail($id)
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail($requestData->created_by);
        $mailTo = "translation.allocators@thetranslationgate.com";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";

        $subject = "New Translation Request # Translation-" . $id . " - " . $requestData->subject;
        if (strlen($requestData->file) > 1) {
            $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/translationRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
        } else {
            $attachment = '';
        }
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
                    <table class="table table-striped  table-hover table-bordered" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" id="">
                    <thead>
                      <tr>
                       <th>Task Code</th> 
                        <th>Task Name</th>                       
                        <th>Task Type</th>                      
                        <th>Count</th>
                        <th>Unit</th>
                        <th>Attachment</th>
                       <th>Start Date</th>
                       <th>Delivery Date</th>
                       <th>PM</th>
                       <th>Created Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <td> Translation-' . $requestData->id . '</td>                         
                            <td>' . $requestData->subject . '</td>
                            <td>' . $this->admin_model->getTaskType($requestData->task_type) . '</td>
                            <td>' . $requestData->count . '</td>
                            <td>' . $this->admin_model->getUnit($requestData->unit) . '</td>
                            <td>' . $attachment . '</td>
                            <td>' . $requestData->start_date . '</td>
                            <td>' . $requestData->delivery_date . '</td>
                             <td>' . $this->admin_model->getAdmin($requestData->created_by) . '</td>
                            <td>' . $requestData->created_at . '</td>
                      </tr>
                      </tbody>
                    </table>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLERequestStatusMail($id, $data, $comment = "", $file = "")
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $LE = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $LE . "\r\n";
        $headers .= 'From: ' . $LE . "\r\n";
        $msgData = "";
        $subject = "LE Request # LE-" . $id . " - " . $requestData->subject;

        if (strlen($file) > 1) {
            $fileMsg = 'Check the attachment file <a href="' . base_url() . 'assets/uploads/leRequest/' . $file . '" target="_blank">Click Here ..</a>';
        } else {
            $fileMsg = '';
        }

        if ($data['status'] == 2) {
            $msgData .= '<p>Your request has been accepted, please check</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>Your request has been Rejected, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your request has been Closed, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>' . $fileMsg . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 5) {
            $msgData .= '<p>Your request needs some updates, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        }

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
                        ' . $msgData . '
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendJobAssignment($userId, $mailSubject, $mailBody)
    {
        $user = $this->db->get_where('users', array('id' => $userId))->row();
        $mailTo = $user->email;
        $from = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $from . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";
        $msgData = "";
        //$subject = "New Job Assignment: ".date("Y-m-d H:i:s");
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
                        <p>Dear ' . $user->user_name . ', </p>
                         <p>' . $mailBody . '</p>
                        <p>Thank You!</p>
                    </body>
                    </html>';
        // echo $message; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationRequestStatusMail($id, $data, $comment = "", $file = "")
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $translation = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $translation . "\r\n";
        $headers .= "Cc: ahmed.naiem@thetranslationgate.com" . "\r\n";
        $headers .= 'From: ' . $translation . "\r\n";
        $msgData = "";
        $subject = "Translation Request # Translation-" . $id . " - " . $requestData->subject;

        if (strlen($file) > 1) {
            $fileMsg = 'Check the attachment file <a href="' . base_url() . 'assets/uploads/translationRequest/' . $file . '" target="_blank">Click Here ..</a>';
        } else {
            $fileMsg = '';
        }

        if ($data['status'] == 2) {
            $msgData .= '<p>Your request has been accepted, please check</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>Your request has been Rejected, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your request has been Closed, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>' . $fileMsg . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 5) {
            $msgData .= '<p>Your request needs some updates, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        }

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
                        ' . $msgData . '
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPRequestStatusMail($id, $data, $comment = "", $file = "")
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $DTP = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $DTP . "\r\n";
        $headers .= 'From: ' . $DTP . "\r\n";
        $msgData = "";
        $subject = "DTP Request # DTP-" . $id . " - " . $requestData->task_name;


        if (strlen($file) > 1) {
            $fileMsg = 'Check the attachment file <a href="' . base_url() . 'assets/uploads/dtpRequest/' . $file . '" target="_blank">Click Here ..</a>';
        } else {
            $fileMsg = '';
        }


        if ($data['status'] == 2) {
            $msgData .= '<p>Your request has been accepted, please check</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>Your request has been Rejected, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your request has been Closed, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>' . $fileMsg . '</p>';
            $msgData .= '<p>Thank You!</p>';
        } elseif ($data['status'] == 5) {
            $msgData .= '<p>Your request needs some updates, please check</p>';
            $msgData .= '<p>' . $comment . '</p>';
            $msgData .= '<p>Thank You!</p>';
        }

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
                        ' . $msgData . '
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLEJobStatusMail($id, $data)
    {
        $jobData = $this->db->get_where('le_request_job', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $jobData->created_by))->row()->email;
        $mailTo = $this->db->get_where('users', array('id' => $jobData->le))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: le@thetranslationgate.com " . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "LE Job";

        if ($data['status'] == 2) {
            $msgData .= '<p>Your Job has been Closed, please check.</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>You have assigned to a new job, please check.</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your job has been rejected, please check</p>';
        } elseif ($data['status'] == 1) {
            $msgData .= '<p>Your job has been accepted, please check</p>';
        } elseif ($data['status'] == 4) {
            $msgData .= '<p>Your job has been partly closed, please check</p>';
        }

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
                        ' . $msgData . '
                        <p>Thank You!</p>
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPJobStatusMail($id, $data)
    {
        $jobData = $this->db->get_where('dtp_request_job', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $jobData->created_by))->row()->email;
        $mailTo = $this->db->get_where('users', array('id' => $jobData->dtp))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "DTP Job";

        if ($data['status'] == 2) {
            $msgData .= '<p>Your Job has been Closed, please check.</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>You have assigned to a new job, please check.</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your job has been rejected, please check</p>';
        } elseif ($data['status'] == 1) {
            $msgData .= '<p>Your job has been accepted, please check</p>';
        } elseif ($data['status'] == 4) {
            $msgData .= '<p>Your job has been partly closed, please check</p>';
        }

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
                        ' . $msgData . '
                        <p>Thank You!</p>
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationJobStatusMail($id, $data)
    {
        $jobData = $this->db->get_where('translation_request_job', array('id' => $id))->row();
        $pmMail = $this->db->get_where('users', array('id' => $jobData->created_by))->row()->email;
        $mailTo = $this->db->get_where('users', array('id' => $jobData->translator))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Translation Job";

        if ($data['status'] == 2) {
            $msgData .= '<p>Your Job has been Closed, please check.</p>';
        } elseif ($data['status'] == 0) {
            $msgData .= '<p>You have assigned to a new job, please check.</p>';
        } elseif ($data['status'] == 3) {
            $msgData .= '<p>Your job has been rejected, please check</p>';
        } elseif ($data['status'] == 1) {
            $msgData .= '<p>Your job has been accepted, please check</p>';
        } elseif ($data['status'] == 4) {
            $msgData .= '<p>Your job has been partly closed, please check</p>';
        }

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
                        ' . $msgData . '
                        <p>Thank You!</p>
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLEReOpenRequestMail($id)
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        $mailTo = "le@thetranslationgate.com";
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Re-opened LE Request # LE-" . $id . " - " . $requestData->subject;

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
                        Your request has been re-opened again, please check ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationReOpenRequestMail($id)
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $mailTo = "translation.allocator@thetranslationgate.com";
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Re-opened Translation Request # Translation-" . $id . " - " . $requestData->subject;

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
                        Your request has been re-opened again, please check ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPReOpenRequestMail($id)
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        if ($this->brand == 2) {
            $mailTo = "maged.kamel@localizera.com";
        } elseif ($this->brand == 3) {
            $mailTo = "dtp@europelocalize.com";
        } else {
            $mailTo = "dtp@thetranslationgate.com";
        }
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Re-opened DTP Request # DTP-" . $id . " - " . $requestData->subject;

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
                        Your request has been re-opened again, please check ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }
    ///late vpos 
    public function jobsWithoutTasks($brand)
    {
        $data = $this->db->query(" SELECT j.*,(SELECT brand FROM users WHERE j.created_by = users.id) AS brand,(SELECT count(*) from job_task where job_task.job_id = j.id) AS tasks,(SELECT COUNT(*) FROM translation_request WHERE j.id = translation_request.job_id) AS translation,(SELECT COUNT(*) FROM dtp_request WHERE j.id = dtp_request.job_id) AS dtp from job AS j WHERE j.project_id > 0 AND j.status = '1' HAVING brand = '$brand' ORDER BY id ASC");

        return $data;
    }
    //
    public function AllDTPFreeLance($task_type, $brand, $filter)
    {

        $data = $this->db->query(" SELECT *,(SELECT brand FROM users WHERE users.id = job_task.created_by) AS brand FROM `job_task` WHERE task_type IN ('$task_type') AND " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        return $data;
    }

    public function AllDTPFreeLancePages($task_type, $brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM users WHERE users.id = job_task.created_by) AS brand FROM `job_task` WHERE task_type IN ('$task_type') HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function sendTranslationCancelRequestMail($id)
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $mailTo = "translation.allocator@thetranslationgate.com";
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Re-opened Translation Request # Translation-" . $id . " - " . $requestData->subject;

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
                        Your request has been Cancelled ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPCancelRequestMail($id)
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        if ($this->brand == 2) {
            $mailTo = "maged.kamel@localizera.com";
        } elseif ($this->brand == 3) {
            $mailTo = "dtp@europelocalize.com";
        } else {
            $mailTo = "dtp@thetranslationgate.com";
        }
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Cancelled DTP Request # DTP - " . $id . " - " . $requestData->subject;

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
                        Your request has been Cancelled ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLECancelRequestMail($id)
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        $mailTo = "le@thetranslationgate.com";
        $pmMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $msgData = "";
        $subject = "Cancelled DTP Request # DTP - " . $id . " - " . $requestData->subject;

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
                        Your request has been Cancelled ..
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function getAssignedSam($lead)
    {
        $query = $this->db->query("SELECT GROUP_CONCAT(sam SEPARATOR ',') AS `sam` FROM `customer_sam` WHERE `lead` = '$lead' ")->row();
        return $query->sam;
    }

    public function sendTranslationCommentByMail($id, $mailTO, $comment)
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $mailTo = $mailTO;
        $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $mailFrom . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $msgData = "";
        $subject = "Comment On Translation Request" . $id . " - " . $requestData->subject;

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
                       ' . $comment . '</br>
                       <a href="' . base_url() . 'projects/translationTask?t=' . base64_encode($id) . '" class="">
                          <i class="fa fa-eye"></i> View Task
                        </a>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationCommentBtweenTeamByMail($id, $comment)
    {
        $requestData = $this->db->get_where('translation_request_job', array('id' => $id))->row();
        $role = $this->db->get_where('users', array('id' => $this->user))->row()->role;
        if ($role == 28) {
            //sender is allocator 
            $mailTo = $this->db->get_where('users', array('id' => $requestData->translator))->row()->email;
            $mailFrom = "translation.allocator@thetranslationgate.com";
        } elseif ($role = 27) {
            //sender is translator
            $mailTo = "translation.allocator@thetranslationgate.com";
            $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        }

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $mailFrom . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $msgData = "";
        $subject = "Comment On Translation Job";

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
                       ' . $comment . '</br>
                       <a href="' . base_url() . 'translation/viewTranslatorTask?t=' . base64_encode($id) . '" class="">
                          <i class="fa fa-eye"></i> View Task
                        </a>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLeCommentByMail($id, $comment, $flag)
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        if ($flag == 1) {
            //from Le
            $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        } elseif ($flag == 2) {
            //from pm
            // $mailTo = $this->db->get_where('users',array('id'=>$requestData->status_by))->row()->email;  
            $mailTo = "le@thetranslationgate.com";
        }
        $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $mailFrom . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $msgData = "";
        $subject = "Comment On Translation Request" . $id;

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
                       ' . $comment . '</br>
                       <a href="' . base_url() . 'projects/leTask?t=' . base64_encode($id) . '" class="">
                          <i class="fa fa-eye"></i> View Task
                        </a>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }
    public function sendDtpCommentByMail($id, $comment, $flag)
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        if ($flag == 1) {
            //from Dtp
            $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        } elseif ($flag == 2) {
            //from pm
            // $mailTo = $this->db->get_where('users',array('id'=>$requestData->status_by))->row()->email;   
            if ($this->brand == 2) {
                $mailTo = "maged.kamel@localizera.com";
            } elseif ($this->brand == 3) {
                $mailTo = "dtp@europelocalize.com";
            } else {
                $mailTo = "dtp@thetranslationgate.com";
            }
        }
        $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $mailFrom . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $msgData = "";
        $subject = "Comment On Translation Request" . $id;

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
                       ' . $comment . '</br>
                       <a href="' . base_url() . 'projects/dTPTask?t=' . base64_encode($id) . '" class="">
                          <i class="fa fa-eye"></i> View Task
                        </a>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }

    // calculate rate for le request
    public function calculateLeRequestRate($task_type, $linguist, $deliverable, $complexicty, $volume)
    {
        $complexictyValue = $this->db->query("SELECT * FROM le_request_amount WHERE task_type = '$task_type' AND linguist_format = '$linguist' AND deliverable_format = '$deliverable'")->row();
        if ($complexicty == 1) {
            $rate = $complexictyValue->complexicty_low * $volume;
        } elseif ($complexicty == 2) {
            $rate = $complexictyValue->complexicty_mid * $volume;
        } elseif ($complexicty == 3) {
            $rate = $complexictyValue->complexicty_high * $volume;
        }
        return $rate;
    }

    ///get le complexicty
    public function getLeComplexicty($id)
    {
        if ($id == 1) {
            echo 'Low';
        } elseif ($id == 2) {
            echo 'Mid';
        } elseif ($id == 3) {
            echo 'High';
        }
    }
    ///get le complexicty value
    public function getLeComplexictyValue($task_type, $linguist, $deliverable, $complexicty, $volume)
    {
        $complexictyValue = $this->db->query("SELECT * FROM le_request_amount WHERE task_type = '$task_type' AND linguist_format = '$linguist' AND deliverable_format = '$deliverable'")->row();
        if ($complexicty == 1) {
            $complexicty_value = $complexictyValue->complexicty_low;
        } elseif ($complexicty == 2) {
            $complexicty_value = $complexictyValue->complexicty_mid;
        } elseif ($complexicty == 3) {
            $complexicty_value = $complexictyValue->complexicty_high;
        }
        return $complexicty_value;
    }

    public function getJobsRevenue($pm, $date_from, $date_to)
    {
        $total = 0;
        $jobs = $this->db->query("SELECT j.id,j.type,j.volume,j.code,j.closed_date,j.price_list FROM job AS j 
										WHERE j.created_by = '$pm' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to'");
        foreach ($jobs->result() as $job) {
            $priceList = $this->projects_model->getJobPriceListData($job->price_list);
            $revenue = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
            $total_revenue = $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $job->closed_date, $revenue);
            $total = $total + $total_revenue;
        }
        $data['total'] = $total;
        $data['jobsNum'] = $jobs->num_rows();
        return $data;
    }

    public function getTotalCost($pm, $date_from, $date_to)
    {
        $this->db->query("SET SESSION group_concat_max_len = 100000000000;");
        $jobs = $this->db->query(" SELECT GROUP_CONCAT(j.id SEPARATOR ',') AS jobs FROM job AS j 
									WHERE j.created_by = '$pm' AND j.status = '1' AND j.closed_date BETWEEN '$date_from' AND '$date_to' ")->row()->jobs;
        if ($jobs == NULL) {
            $jobs = 0;
        }
        $tasks = $this->db->query(" SELECT * FROM `job_task` WHERE status = '1' AND job_id IN (" . $jobs . ") ")->result();
        $totalCost = 0;
        foreach ($tasks as $task) {
            $taskCost = $task->rate * $task->count;
            $totalCostUSD = $this->accounting_model->transfareTotalToCurrencyRate($task->currency, 2, $task->closed_date, $taskCost);
            $totalCost = $totalCost + $totalCostUSD;
        }
        return $totalCost;
    }

    public function getTotalCostByCustomer($customer, $date_from, $date_to)
    {
        $this->db->query("SET SESSION group_concat_max_len = 100000000000;");
        $jobs = $this->db->query(" SELECT GROUP_CONCAT(j.id SEPARATOR ',') AS jobs FROM job AS j LEFT OUTER JOIN project AS p ON p.id = j.project_id 
        							WHERE j.status = '1' AND p.customer = '$customer' AND j.closed_date BETWEEN '$date_from' AND '$date_to' ")->row()->jobs;
        if ($jobs == NULL) {
            $jobs = 0;
        }
        $tasks = $this->db->query(" SELECT * FROM `job_task` WHERE status = '1' AND job_id IN (" . $jobs . ") ")->result();
        $totalCost = 0;
        foreach ($tasks as $task) {
            $taskCost = $task->rate * $task->count;
            $totalCostUSD = $this->accounting_model->transfareTotalToCurrencyRate($task->currency, 2, $task->closed_date, $taskCost);
            $totalCost = $totalCost + $totalCostUSD;
        }
        return $totalCost;
    }

    public function selectPmEmployeeId($id = "", $brand = "")
    {
        // $pm = $this->db->get_where('users',array('role'=>2,'brand'=>$brand))->result();
        $pm = $this->db->query(" SELECT * FROM users WHERE (role = '2' OR role = '29' OR role = '16') AND brand = '$this->brand' AND status = '1' ")->result();
        $data = '';
        foreach ($pm as $pm) {
            if ($pm->id == $id) {
                $data .= "<option value='" . $pm->employees_id . "' selected='selected'>" . $pm->user_name . "</option>";
            } else {
                $data .= "<option value='" . $pm->employees_id . "'>" . $pm->user_name . "</option>";
            }
        }
        return $data;
    }


    public function AllPMOCustomer($permission, $user, $brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `customer` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id ASC");
        return $data;
    }

    public function creditNote($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        							FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po
            							WHERE " . $filter . " AND (type = 4 OR type = 1) HAVING brand = '$brand' order by id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        							FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po
            						WHERE " . $filter . " AND (type = 4 OR type = 1) AND p.created_by = '$user' HAVING brand = '$brand' order by id desc ");
        }
        return $data;
    }

    public function creditNotePages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        							FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po
									WHERE (type = 4 OR type = 1) HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        							FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po
									 WHERE p.created_by = '$user' AND (type = 4 OR type = 1) HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    //pm conversion request
    public function AllPmConversionRequest($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_conversion_request` WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `pm_conversion_request` WHERE brand = '$brand' AND created_by ='$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllPmConversionRequestPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `pm_conversion_request` WHERE brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `pm_conversion_request` WHERE brand = '$brand' AND created_by ='$user' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }
    public function getConversionTaskType($task_type)
    {
        $result = $this->db->get_where('pm_conversion_task_type', array('id' => $task_type))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectConversionTaskType($id = "")
    {
        $task_type = $this->db->get('pm_conversion_task_type')->result();
        $data = '';
        foreach ($task_type as $task_type) {
            if ($task_type->id == $id) {
                $data .= "<option value='" . $task_type->id . "' selected='selected'>" . $task_type->name . "</option>";
            } else {
                $data .= "<option value='" . $task_type->id . "'>" . $task_type->name . "</option>";
            }
        }
        return $data;
    }

    public function sendUpdateMail($data, $id)
    {
        $requestData = $this->db->get_where('pm_conversion_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $mailFrom = "le-conversion@thetranslationgate.com";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        $msgData = "";
        $subject = "Conversion Request Updated: " . $id;

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
                       Hi,
                       </br>
                       Your Request has been updated please check the status.
                       </br>
                       <a href="' . base_url() . 'projects/viewPmConversionRequest?t=' . base64_encode($id) . '" class="">
                          <i class="fa fa-eye"></i> View Task
                        </a>
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }
    //

    ///latedelevery job mail 
    public function sendLateDeliveryJobsMail($file)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $fileName = base_url() . 'assets/uploads/late_delivery_daily_report/' . $file;
        $this->email->attach($fileName);
        $this->email->from("falaqsystem@thetranslationgate.com");
        $this->email->to("tarek.seif@thetranslationgate.com");
        $this->email->subject("Late Delivery Jobs - " . date("Y-m-d H:i:s"));
        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    </head>
					<body>
                    <p>Hi Tarek,</p>
                    <p>Kindly find attached file with a list of the undelivered jobs.</p>
                    <p>Thank You!</p>
                    </body>
                    </html>';
        $this->email->message($message);

        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function activeCustomersDaily($file, $brand)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'erp@aixnexus.com',
            'smtp_pass' => 'EXoYlsum6Do@',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $fileName = base_url() . 'assets/uploads/active_customers_report/' . $file;
        $this->email->attach($fileName);
        $this->email->from("erp@aixnexus.com");
        $this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, zeinab.moustafa@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com,lobna.abdou@thetranslationgate.com");
        $this->email->cc("dev@thetranslationgate.com");
        $this->email->subject("Daily Active Customers - " . $brand);
        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    </head>
					<body>
                    <p>Hi,</p>
                    <p>Kindly find the attached file with a list of ' . $brand . ' active customers for the jobs added to the system yesterday.</p>
                    <p>Thank You!</p>
                    </body>
                    </html>';
        $this->email->message($message);
        $this->email->set_header('Reply-To', "dev@thetranslationgate.com");
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function activeCustomersWeekly($file, $brand)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'erp@aixnexus.com',
            'smtp_pass' => 'EXoYlsum6Do@',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $date = date("Y-m-d");
        $week_date = date("Y-m-d", strtotime("-7 days"));
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $fileName = base_url() . 'assets/uploads/active_customers_report/' . $file;
        $this->email->attach($fileName);
        $this->email->from("erp@aixnexus.com");
        // $this->email->to("mohamed.elshehaby@thetranslationgate.com");
        $this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, zeinab.moustafa@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com, lobna.abdou@thetranslationgate.com");
        $this->email->cc("dev@thetranslationgate.com");
        $this->email->subject("Weekly Active Customers - " . $brand);
        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    </head>
					<body>
                    <p>Hi,</p>
                    <p>Kindly find the attached file with a list of ' . $brand . ' active customers for the jobs added to the system from ' . $week_date . ' to ' . $date . ' </p>
                    <p>Thank You!</p>
                    </body>
                    </html>';
        $this->email->message($message);
        $this->email->set_header('Reply-To', "dev@thetranslationgate.com");
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function activeCustomersMonthly($file, $brand)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'erp@aixnexus.com',
            'smtp_pass' => 'EXoYlsum6Do@',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $date = date("Y-m-d");
        $month_date = date("Y-m-d", strtotime("-1 month"));
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $fileName = base_url() . 'assets/uploads/active_customers_report/' . $file;
        $this->email->attach($fileName);
        $this->email->from("erp@aixnexus.com");
        $this->email->to("mohamed.elghamry@thetranslationgate.com");
        // $this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, zeinab.moustafa@thetranslationgate.com");
        $this->email->cc("dev@thetranslationgate.com");
        $this->email->subject("Monthly Active Customers - " . $brand);
        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    </head>
					<body>
                    <p>Hi,</p>
                    <p>Kindly find the attached file with a list of ' . $brand . ' active customers for the jobs added to the system from ' . $month_date . ' to ' . $date . ' </p>
                    <p>Thank You!</p>
                    </body>
                    </html>';
        $this->email->message($message);
        $this->email->set_header('Reply-To', "dev@thetranslationgate.com");
        $this->email->set_mailtype('html');
        $this->email->send();
    }
    //

    //customer emails for customer feedback
    public function selectCustomerEmails($id = "")
    {
        $emails = $this->db->get('customer_email')->result();
        $data = '';
        foreach ($emails as $emails) {
            if ($emails->id == $id) {
                $data .= "<option value='" . $emails->email . "' selected='selected'>" . $emails->email . "</option>";
            } else {
                $data .= "<option value='" . $emails->email . "'>" . $emails->email . "</option>";
            }
        }
        return $data;
    }
    //
    public function selectCommission($id = "", $brand = "")
    {
        $commission = $this->db->get_where('commission', array('brand' => $brand))->result();
        $data = '';
        foreach ($commission as $commission) {
            if ($commission->id == $id) {
                $data .= "<option value='" . $commission->id . "' selected='selected'>" . $commission->name . "</option>";
            } else {
                $data .= "<option value='" . $commission->id . "'>" . $commission->name . "</option>";
            }
        }
        return $data;
    }

    public function getCommissionName($id)
    {
        $result = $this->db->get_where('commission', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getCommissionEmail($id)
    {
        $result = $this->db->get_where('commission', array('id' => $id))->row();
        if (isset($result->email)) {
            return $result->email;
        } else {
            return '';
        }
    }

    public function selectDTPAllocator($id = "")
    {
        $dtp = $this->db->get_where('users', array('role' => 24, 'brand' => $this->brand))->result();
        $data = '';
        foreach ($dtp as $dtp) {
            if ($dtp->id == $id) {
                $data .= "<option value='" . $dtp->id . "' selected='selected'>" . $dtp->user_name . "</option>";
            } else {
                $data .= "<option value='" . $dtp->id . "'>" . $dtp->user_name . "</option>";
            }
        }
        return $data;
    }

    public function AllHandover($permission, $user, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `handover` WHERE " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `handover` WHERE created_by ='$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }
    public function AllHandoverPages($permission, $user, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `handover` ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `handover` WHERE created_by ='$user' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }

    public function sendVendorMessageMail($id, $msg, $brand)
    {
        $data['row'] = self::getTaskData($id);
        $data['job'] = self::getJobData($data['row']->job_id);

        $pmMail = $this->admin_model->getUserEmail($data['row']->created_by);
        $vendor = $this->vendor_model->getVendorData($data['row']->vendor);
        $subject = "Nexus || New Reply: " . $data['row']->subject;
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($pmMail);
        $this->email->to($vendor->email);
        $this->email->subject($subject);
        $data['message'] = $msg;
        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("projects_new/emails/job_reply_message.php", $data, true);
        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function sendVendorResponseMail($id, $brand, $status)
    {

        $data['row'] = self::getTaskData($id);
        $data['job'] = self::getJobData($data['row']->job_id);
        $data['jobPrice'] = self::getJobPriceListData($data['job']->price_list);
        $pmMail = $this->admin_model->getUserEmail($data['row']->created_by);
        $vendor = $this->vendor_model->getVendorData($data['row']->vendor);

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($pmMail);
        $this->email->to($vendor->email);
        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;

        if ($status == "0") {

            $subject = "Nexus || Task Rejected: " . $data['row']->subject;
            $message = $this->load->view("projects_new/emails/job_rejected.php", $data, true);
        } elseif ($status == "1") {

            $subject = "Nexus || Task Confirmed: " . $data['row']->subject;

            $message = $this->load->view("projects_new/emails/job_confirmed.php", $data, true);
        }

        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }
    public function getTaskLoggerStatus($status)
    {
        if ($status == 0) {
            echo "Send New Offer & Waiting Vendor Acceptance";
        } elseif ($status == 1) {
            echo "Accept Offer";
        } elseif ($status == 2) {
            echo "Reject Offer";
        } elseif ($status == 3) {
            echo "Task Finished & Waiting PM Confirmation";
        } elseif ($status == 4) {
            echo "Task Accepted";
        } elseif ($status == 5) {
            echo "Task Rejected & Re-opened";
        } elseif ($status == 6) {
            echo "Task Cancelled";
        } elseif ($status == 7) {
            echo "Task Updated";
        } elseif ($status == 8) {
            echo "Heads Up ( Waiting Vendor Response )";
        } elseif ($status == 9) {
            echo "Heads Up ( Marked as Available )";
        } elseif ($status == 10) {
            echo "Heads Up ( Marked as Not Available )";
        }
    }

    public function addToTaskLogger($id, $status, $comment = '')
    {
        $log_data['from'] = 1;
        $log_data['task'] = $id;
        $log_data['status'] = $status;
        $log_data['comment'] = $comment;
        $log_data['created_by'] = $this->user;
        $log_data['created_at'] = date("Y-m-d H:i:s");
        $this->db->insert('job_task_log', $log_data);
    }

    public function projectTasks($permission, $user, $project_id)
    {
        $idsArray = array();
        $jobIds = "";
        $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($ids)) {
            foreach ($ids as $val)
                array_push($idsArray, $val->id);
            $jobIds = implode(" , ", $idsArray);
        } else {
            $jobIds = "0";
        }
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM job_task WHERE `job_id` IN ($jobIds)");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM job_task WHERE `created_by` = $user AND `job_id` IN ($jobIds)");
        }
        return $data;
    }

    public function projectTasksOffers($permission, $user, $project_id)
    {
        $idsArray = array();
        $jobIds = "";
        $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($ids)) {
            foreach ($ids as $val)
                array_push($idsArray, $val->id);
            $jobIds = implode(" , ", $idsArray);
        } else {
            $jobIds = "0";
        }
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM job_offer_list WHERE `job_id` IN ($jobIds)");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM job_offer_list WHERE `created_by` = $user AND `job_id` IN ($jobIds)");
        }
        return $data;
    }

    // send to all vendors
    public function sendToVendorList($id, $user, $brand, $update = '')
    {
        $data['nexusLink'] = $nexusLink = self::getNexusLinkByBrand($brand);
        $data['row'] = $this->db->get_where('job_offer_list', array('id' => $id))->row();
        $data['job'] = self::getJobData($data['row']->job_id);
        $data['jobPrice'] = self::getJobPriceListData($data['job']->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);
        $data['acceptLink'] = $nexusLink . "/Project/viewOffer?o=" . base64_encode($id);
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );

        $subject = "Nexus || New Task: " . $data['row']->subject;
        if (!empty($update)) {
            $subject = "Nexus || Task Updated : " . $data['row']->subject;
        }

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("nexus/new_job.php", $data, true);
        if (!empty($update)) {
            $message = $this->load->view("nexus/update_job.php", $data, true);
        }
        $vendor_list = explode(', ', $data['row']->vendor_list);
        foreach ($vendor_list as $val) {
            $vendor = $this->vendor_model->getVendorData($val);
            $mailTo = $vendor->email;
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_header('Reply-To', $pmMail);
            $this->email->set_mailtype('html');
            $this->email->from($pmMail);
            $this->email->to($mailTo);
            if ($brand == 1) {
                $this->email->cc($pmMail . ', vm@thetranslationgate.com');
            } elseif ($brand == 2) {
                $this->email->cc($pmMail . ', vm@localizera.com');
            } elseif ($brand == 3) {
                $this->email->cc($pmMail . ', vm@europelocalize.com');
            } elseif ($brand == 11) {
                $this->email->cc($pmMail . ', Vendormanagement@Columbuslang.com');
            }
            $this->email->send();
        }
    }

    public function sendVendorListCancelTaskMail($id, $user, $brand)
    {
        $data['row'] = $row = $this->db->get_where('job_offer_list', array('id' => $id))->row();
        $data['job'] = $job = self::getJobData($row->job_id);
        $data['jobPrice'] = $jobPrice = self::getJobPriceListData($job->price_list);
        $pmMail = $this->admin_model->getUserEmail($user);
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );

        $subject = "Nexus || Task Cancelled  : " . $row->subject;
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("nexus/cancel_offer.php", $data, true);
        $vendor_list = explode(', ', $data['row']->vendor_list);
        foreach ($vendor_list as $val) {
            $vendor = $this->vendor_model->getVendorData($val);
            $mailTo = $vendor->email;
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_header('Reply-To', $pmMail);
            $this->email->set_mailtype('html');
            $this->email->from($pmMail);
            $this->email->to($mailTo);
            if ($brand == 1) {
                $this->email->cc($pmMail . ', vm@thetranslationgate.com');
            } elseif ($brand == 2) {
                $this->email->cc($pmMail . ', vm@localizera.com');
            } elseif ($brand == 3) {
                $this->email->cc($pmMail . ', vm@europelocalize.com');
            } elseif ($brand == 11) {
                $this->email->cc($pmMail . ', Vendormanagement@Columbuslang.com');
            }
            $this->email->send();
        }
    }

    public function getVendorOfferStatus($status = "")
    {
        if ($status == 0) {
            echo "Vendor Accept Offer";
        } elseif ($status == 2) {
            echo "Cancelled";
        } elseif ($status == 4) {
            echo "Waiting Vendors Response";
        }
    }

    // order tasks

    public function projectTranslationRequest($permission, $user, $project_id)
    {
        $idsArray = array();
        $jobIds = "";
        if ($permission->view == 1) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        } elseif ($permission->view == 2) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id, 'created_by' => $user))->result();
        }
        $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($ids)) {
            foreach ($ids as $val)
                array_push($idsArray, $val->id);
            $jobIds = implode(" , ", $idsArray);
        } else {
            $jobIds = "0";
        }
        $data = $this->db->query("SELECT * FROM translation_request WHERE `job_id` IN ($jobIds)");

        return $data;
    }

    public function projectLeRequest($permission, $user, $project_id)
    {
        $idsArray = array();
        $jobIds = "";
        if ($permission->view == 1) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        } elseif ($permission->view == 2) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id, 'created_by' => $user))->result();
        }
        $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($ids)) {
            foreach ($ids as $val)
                array_push($idsArray, $val->id);
            $jobIds = implode(" , ", $idsArray);
        } else {
            $jobIds = "-1";
        }
        $data = $this->db->query("SELECT * FROM le_request WHERE job_id IN ($jobIds)");

        return $data;
    }

    public function projectDTPRequest($permission, $user, $project_id)
    {
        $idsArray = array();
        $jobIds = "";
        if ($permission->view == 1) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        } elseif ($permission->view == 2) {
            $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id, 'created_by' => $user))->result();
        }
        $ids = $this->db->select('id')->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($ids)) {
            foreach ($ids as $val)
                array_push($idsArray, $val->id);
            $jobIds = implode(" , ", $idsArray);
        } else {
            $jobIds = "0";
        }
        $data = $this->db->query("SELECT * FROM dtp_request WHERE `job_id` IN ($jobIds)");

        return $data;
    }

    public function selectRelatedTasks($job_id)
    {
        $where = "job_id = $job_id  AND job_id != 0 AND (Status = 6 OR Status = 1 OR Status = 2)";
        $where2 = "job_id = $job_id  AND job_id != 0 AND (Status = 6 OR Status = 5 OR Status = 4 OR Status = 0)";
        $translation_request = $this->db->where($where)->get("translation_request");
        $le_request = $this->db->where($where)->get("le_request");
        $dtp_request = $this->db->where($where)->get("dtp_request");
        $vendor_request = $this->db->where($where2)->get("job_task");
        $data = '';
        if (isset($translation_request)) {
            foreach ($translation_request->result() as $task) {
                $data .= "<option value='Translation//" . $task->id . "'> Translation Task-$task->id( " . $task->subject . ")</option>";
            }
        }
        if (isset($le_request)) {
            foreach ($le_request->result() as $task) {
                $data .= "<option value='LE//" . $task->id . "'> LE Task-$task->id( " . $task->subject . ")</option>";
            }
        }
        if (isset($dtp_request)) {
            foreach ($dtp_request->result() as $task) {
                $data .= "<option value='DTP//" . $task->id . "'> DTP Task-$task->id( " . $task->subject . ")</option>";
            }
        }
        if (isset($vendor_request)) {
            foreach ($vendor_request->result() as $task) {
                $data .= "<option value='Vendor//" . $task->id . "'> Vendor Task-$task->id( " . $task->subject . ")</option>";
            }
        }
        return $data;
    }

    public function CheckCloseRelatedTasks($job_id, $task_id, $task_type)
    {
        $where = "job_id = $job_id";
        $where .= " AND start_after_type = '$task_type'";
        $where .= " AND start_after_id = $task_id";
        $where .= " AND Status = 6 ";
        $translation_request = $this->db->where($where)->get("translation_request");
        $vendor_request = $this->db->where($where)->get("job_task");
        $vendor_offer_request = $this->db->where($where)->get("job_offer_list");
        $le_request = $this->db->where($where)->get("le_request");
        $dtp_request = $this->db->where($where)->get("dtp_request");
        // first get old task file
        $old_path = "";
        $external = 0;
        if ($task_type == "Translation") {
            $file_path = './assets/uploads/translationRequest/';
            $old_file = $this->db->get_where("translation_history", array("request" => $task_id))->row();
            $old_file_name = $old_file->file;
            if (strlen($old_file_name) > 1)
                $old_path = $file_path . $old_file_name;
        } elseif ($task_type == "LE") {
            $file_path = './assets/uploads/leRequest/';
            $old_file = $this->db->get_where("le_history", array("request" => $task_id))->row();
            $old_file_name = $old_file->file;
            if (strlen($old_file_name) > 1)
                $old_path = $file_path . $old_file_name;
        } elseif ($task_type == "DTP") {
            $file_path = './assets/uploads/dtpRequest/';
            $old_file = $this->db->get_where("dtp_history", array("request" => $task_id))->row();
            $old_file_name = $old_file->file;
            if (strlen($old_file_name) > 1)
                $old_path = $file_path . $old_file_name;
        } elseif ($task_type == "Vendor") {
            $external = 1;
            $nexusLink = self::getNexusLinkByBrand();
            $file_path = $nexusLink . '/assets/uploads/jobTaskVendorFiles/';
            $file = $this->db->get_where("job_task", array("id" => $task_id))->row();
            $old_file_name = $file->vendor_attachment;
            if (strlen($old_file_name) > 1)
                $old_path = $file_path . $old_file_name;
        }

        // start close
        if (isset($translation_request)) {
            foreach ($translation_request->result_array() as $task) {
                $data['status'] = 1;
                $this->projects_model->sendTranslationRequestMail($task['id']);
                // check if old file exists
                if (!empty($old_path)) {
                    if ($external == 0) {
                        $new_path = "./assets/uploads/translationRequest/";
                        copy($old_path, $new_path . $old_file_name);
                    }
                    $data['file'] = $old_file_name;
                }
                //end file check
                $this->db->update('translation_request', $data, array('id' => $task['id']));
            }
        }
        if (isset($vendor_request)) {
            foreach ($vendor_request->result_array() as $task) {
                $data['status'] = 4;
                $this->projects_model->sendVendorTaskMailVendorModule($task['id'], $task['created_by'], $this->brand);
                // task log
                $this->projects_model->addToTaskLogger($task['id'], 0);

                // check if old file exists
                if (!empty($old_path)) {
                    if ($external == 0) {
                        $new_path = "./assets/uploads/taskFile/";
                        copy($old_path, $new_path . $old_file_name);
                    }
                    $data['file'] = $old_file_name;
                }
                //end file check

                $this->db->update('job_task', $data, array('id' => $task['id']));
            }
        }
        if (isset($vendor_offer_request)) {
            foreach ($vendor_offer_request->result_array() as $task) {
                $data['status'] = 4;
                //  new email to all vendors
                $this->projects_model->sendToVendorList($task['id'], $task['created_by'], $this->brand);

                // check if old file exists
                if (!empty($old_path)) {
                    if ($external == 0) {
                        $new_path = "./assets/uploads/taskFile/";
                        copy($old_path, $new_path . $old_file_name);
                    }
                    $data['file'] = $old_file_name;
                }
                //end file check

                $this->db->update('job_offer_list', $data, array('id' => $task['id']));
            }
        }
        if (isset($le_request)) {
            foreach ($le_request->result_array() as $task) {
                $data['status'] = 1;
                $this->projects_model->sendLERequestMail($task['id']);

                // check if old file exists
                if (!empty($old_path)) {
                    if ($external == 0) {
                        $new_path = "./assets/uploads/leRequest/";
                        copy($old_path, $new_path . $old_file_name);
                    }
                    $data['file'] = $old_file_name;
                }
                //end file check

                $this->db->update('le_request', $data, array('id' => $task['id']));
            }
        }
        if (isset($dtp_request)) {
            foreach ($dtp_request->result_array() as $task) {
                $data['status'] = 1;
                $this->projects_model->sendDTPRequestMail($task['id']);

                // check if old file exists
                if (!empty($old_path)) {
                    if ($external == 0) {
                        $new_path = "./assets/uploads/dtpRequest/";
                        copy($old_path, $new_path . $old_file_name);
                    }
                    $data['file'] = $old_file_name;
                }
                //end file check

                $this->db->update('dtp_request', $data, array('id' => $task['id']));
            }
        }
    }

    public function getTaskFileLink($path, $file_name, $start_after_type)
    {
        $nexusLink = self::getNexusLinkByBrand();
        $check_local = @fopen(base_url($path . $file_name), 'r');
        $check_external = @fopen($nexusLink . 'assets/uploads/jobTaskVendorFiles/' . $file_name, 'r');
        if ($check_local) {
            $link = base_url() . $path . $file_name;
        } elseif ($start_after_type == "Vendor" && $check_external) {
            $link = $nexusLink . "/assets/uploads/jobTaskVendorFiles/" . $file_name;
        } else {
            $link = "";
        }
        echo $link;
    }

    public function getTaskVendorNotes($start_after_id)
    {
        $task = $this->db->get_where("job_task", array("id" => $start_after_id))->row();
        if (!empty($task->vendor_notes)) {
            $vendor_notes = strip_tags($task->vendor_notes);
            $link = '<a href="#" class="font-size-sm" onclick = "alert(`' . $vendor_notes . '`);"> File Link...</a>';
        } else {
            $link = "";
        }
        return $link;
    }

    public function getUserManagerEmail($user_id = '')
    {
        // get manager_id from employees
        // get manager user email where same brand of user 
        // except team coach
        $manager_email = "";
        if (!empty($user_id))
            $emp_id = $this->db->query("SELECT employees_id From users WHERE id = $user_id")->row()->employees_id;
        else
            $emp_id = $this->db->query("SELECT employees_id From users WHERE id = $this->user")->row()->employees_id;
        $manager_id = $this->db->query("SELECT manager From employees WHERE id = $emp_id")->row()->manager;
        if (isset($manager_id) && $manager_id != 14)
            $manager_email = $this->db->query("SELECT email From users WHERE employees_id = $manager_id AND brand = $this->brand")->row()->email;
        else
            $manager_email = "";
        return $manager_email;
    }

    public function checkPoExists($po)
    {
        $check = $this->db->get_where('po', array('number' => trim($po)));
        if ($check->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPoTotal($po, $select)
    {
        $poData = $this->db->get_where('po', array('id' => $po));
        if ($poData->num_rows() > 0) {
            $poTotal = $poData->row()->total_amount;
            $jobsTotal = self::totalRevenuePO($po)['total'];
            $selectTotal = 0;
            $jobs = $this->db->query(" SELECT * FROM job WHERE id IN (" . $select . ") AND (po != $po or po IS null)")->result();
            foreach ($jobs as $job) {
                $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                $selectTotal += $jobTotal;
            }
            if ($poTotal >= $jobsTotal + $selectTotal) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function selectPoAvailable($project)
    {
        $projectData = $this->db->get_where('project', array('id' => $project))->row();
        $poList = $this->db->get_where('po', array('customer' => $projectData->customer, 'lead' => $projectData->lead))->result();
        $data = "<option value='' selected disabled>-- Select Po Number</option>";
        foreach ($poList as $po) {
            $poTotal = $po->total_amount;
            $jobsTotal = self::totalRevenuePO($po->id)['total'];
            if ($poTotal > $jobsTotal) {
                $data .= "<option value='" . $po->id . "'>" . $po->number . "</option>";
            }
        }

        return $data;
    }

    public function selectTTGBranchName($id = "")
    {
        $branch = $this->db->get('ttg_branch')->result();
        $data = '';
        foreach ($branch as $branch) {
            if ($branch->id == $id) {
                $data .= "<option value='" . $branch->id . "' selected='selected'>" . $branch->name . "</option>";
            } else {
                $data .= "<option value='" . $branch->id . "'>" . $branch->name . "</option>";
            }
        }
        return $data;
    }

    public function getTTGBranchName($id)
    {
        $branch = $this->db->get_where('ttg_branch', array('id' => $id))->row();
        $name = '';
        if (isset($branch->name)) {
            $name = $branch->name;
        }
        return $name;
    }

    public function getTTGBranchForJob($job_id)
    {
        $name = '';
        $job = $this->db->get_where('job', array('id' => $job_id))->row();
        $project = $this->db->get_where('project', array('id' => $job->project_id))->row();
        if (isset($project)) {
            $branch = $this->db->get_where('ttg_branch', array('id' => $project->branch_name))->row();
            if (isset($branch->name)) {
                $name = $branch->name;
            }
        }
        return $name;
    }

    // for use in model not echo
    public function getTaskFileLinkForM($path, $file_name, $start_after_type)
    {
        $nexusLink = self::getNexusLinkByBrand();
        $check_local = @fopen(base_url($path . $file_name), 'r');
        $check_external = @fopen($nexusLink . '/assets/uploads/jobTaskVendorFiles/' . $file_name, 'r');
        if ($check_local) {
            $link = base_url() . $path . $file_name;
        } elseif ($start_after_type == "Vendor" && $check_external) {
            $link = $nexusLink . "/assets/uploads/jobTaskVendorFiles/" . $file_name;
        } else {
            $link = "";
        }
        return $link;
    }

    public function getLeComplexictyForM($id)
    {
        if ($id == 1) {
            $val = 'Low';
        } elseif ($id == 2) {
            $val = 'Mid';
        } elseif ($id == 3) {
            $val = 'High';
        }
        return $val;
    }
    // end for use in model    

    // start Projects Heads Up
    public function selectProjectPlanningStatus($select = "")
    {
        if ($select == 0) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } elseif ($select == 2) {
            $selected3 = 'selected';
        }
        $outpt = '<option value="0" ' . $selected1 . '>Still Not Saved</option>
                  <option value="1" ' . $selected2 . '>Saved As A project</option>
                  <option value="2" ' . $selected3 . '>Cancelled</option>';
        return $outpt;
    }
    public function getProjectPlanningStatus($status = "")
    {
        if ($status == 0) {
            echo "Still Not Saved";
        } elseif ($status == 1) {
            echo "Saved As A project";
        } elseif ($status == 2) {
            echo "Lost";
        }
    }

    public function getTaskPlanningStatus($status = "")
    {
        if ($status == 0) {
            echo "Waiting Response";
        } elseif ($status == 1) {
            echo "Available";
        } elseif ($status == 2) {
            echo "Not Available";
        } elseif ($status == 4) {
            echo "Cancelled";
        }
    }

    public function AllProjectPlanning($permission, $user, $brand, $filter, $having = 1)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p WHERE " . $filter . " HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' AND " . $having . " ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllProjectPlanningPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllProjectPlanningCount($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `project_planning` AS p WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function getProjectPlanningData($id)
    {
        $result = $this->db->get_where('project_planning', array('id' => $id))->row();
        return $result;
    }

    public function projectPlanningJobs($permission, $user, $id)
    {
        if ($permission->view == 1) {
            $data = $this->db->get_where('job', array('plan_id' => $id));
        } elseif ($permission->view == 2) {
            $data = $this->db->get_where('job', array('plan_id' => $id, 'created_by' => $user));
        }
        return $data;
    }

    public function getProjectCode($id)
    {
        $result = '';
        $row = $this->db->get_where('project', array('id' => $id))->row();
        if ($row)
            $result = $row->code;
        return $result;
    }

    public function sendRequestPlanMail($id, $requestType)
    {
        $data['requestType'] = $requestType;
        if ($requestType == 1) {
            $data['requestData'] = $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
            $mailTo = "translation.allocator@thetranslationgate.com";
            $subject = "New Translation 'Heads-Up' Request # Translation-" . $id . " - " . $requestData->subject;
            if (strlen($requestData->file) > 1) {
                $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/translationRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
            } else {
                $attachment = '';
            }
        } elseif ($requestType == 2) {
            $data['requestData'] = $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
            $mailTo = "le@thetranslationgate.com";
            $subject = "New LE 'Heads-Up' Request # LE-" . $id . " - " . $requestData->subject;
            if (strlen($requestData->file) > 1) {
                $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/leRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
            } else {
                $attachment = '';
            }
        } elseif ($requestType == 3) {
            $data['requestData'] = $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
            $pmMail = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
            $pmManagerEmail = self::getUserManagerEmail($requestData->created_by);
            if ($this->brand == 2) {
                $mailTo = "maged.kamel@dtpzone.com";
            } else {
                $mailTo = "dtp@thetranslationgate.com";
            }
            if (strlen($requestData->file) > 1) {
                $attachment = '<a href="' . $this->projects_model->getTaskFileLinkForM("assets/uploads/dtpRequest/", $requestData->file, $requestData->start_after_type) . '">Click Here</a>';
            } else {
                $attachment = '';
            }
            $subject = "New DTP 'Heads Up' Request # DTP-" . $id . " - " . $requestData->task_name;
        }
        $pmMail = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $pmManagerEmail = self::getUserManagerEmail($requestData->created_by);

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pmMail . "\r\n";
        $headers .= "Cc: " . $pmManagerEmail . "\r\n";
        $headers .= 'From: ' . $pmMail . "\r\n";
        $message = $this->load->view("project_planning/plan_request_email.php", $data, true);


        mail($mailTo, $subject, $message, $headers);
    }

    public function sendVendorRequestPlanMail($id, $user, $brand)
    {
        $data['nexusLink'] = $nexusLink = self::getNexusLinkByBrand($brand);
        $data['row'] = self::getTaskData($id);
        $data['job'] = self::getJobData($data['row']->job_id);
        $data['jobPrice'] = self::getJobPriceListData($data['job']->price_list);
        $data['acceptLink'] = $nexusLink . "/Project/viewJob?t=" . base64_encode($id);
        $pmMail = $this->admin_model->getUserEmail($user);

        $vendor = $this->vendor_model->getVendorData($data['row']->vendor);
        $mailTo = $vendor->email;
        $subject = "Nexus || New Task: " . $data['row']->subject;
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        if ($brand == 1) {
            $this->email->cc($pmMail . ', vm@thetranslationgate.com');
        } elseif ($brand == 2) {
            $this->email->cc($pmMail . ', vm@localizera.com');
        } elseif ($brand == 3) {
            $this->email->cc($pmMail . ', vm@europelocalize.com');
        } elseif ($brand == 11) {
            $this->email->cc($pmMail . ', Vendormanagement@Columbuslang.com');
        }

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($pmMail);

        $this->email->to($mailTo);
        $this->email->subject($subject);
        $fileName = base_url() . "assets/images/nexus.PNG";
        $this->email->attach($fileName);
        $logo_cid = $this->email->attachment_cid($fileName);
        $data['logo_cid'] = $logo_cid;
        $message = $this->load->view("project_planning/job_offer_email.php", $data, true);

        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function TranslationRequestsPlan($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = translation_request.created_by) AS brand FROM `translation_request` WHERE status = 7 HAVING brand = '$brand' ");
        return $data;
    }

    public function LeRequestsPlan($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = le_request.created_by) AS brand FROM `le_request` WHERE status = 7 HAVING brand = '$brand' ");
        return $data;
    }

    public function DtpRequestsPlan($brand)
    {
        $data = $this->db->query("SELECT *,(SELECT brand FROM `users` where id = dtp_request.created_by) AS brand FROM `dtp_request` WHERE status = 7 HAVING brand = '$brand' ");
        return $data;
    }

    public function sendLERequestPlanStatusMail($id, $data, $comment = "")
    {
        $requestData = $this->db->get_where('le_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $LE = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $LE . "\r\n";
        $headers .= 'From: ' . $LE . "\r\n";
        $msgData = "";
        $subject = "LE Request # LE-" . $id . " - " . $requestData->subject;

        if ($data['status'] == 8) {
            $msgData .= '<p>Your heads-up request has been accepted, please check.</p>';
        } elseif ($data['status'] == 9) {
            $msgData .= '<p>Your heads-up request has been Rejected, please check.</p>';
        }
        $msgData .= '<p>' . $comment . '</p>';
        $msgData .= '<p>Thank You!</p>';

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
                        ' . $msgData . '
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }

    public function sendTranslationRequestPlanStatusMail($id, $data, $comment = "")
    {
        $requestData = $this->db->get_where('translation_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $translation = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $translation . "\r\n";
        //        $headers .= "Cc: ahmed.naiem@thetranslationgate.com" . "\r\n";
        $headers .= 'From: ' . $translation . "\r\n";
        $msgData = "";
        $subject = "Translation Request # Translation-" . $id . " - " . $requestData->subject;

        if ($data['status'] == 8) {
            $msgData .= '<p>Your heads-up request has been accepted, please check.</p>';
        } elseif ($data['status'] == 9) {
            $msgData .= '<p>Your heads-up request has been Rejected, please check.</p>';
        }
        $msgData .= '<p>' . $comment . '</p>';
        $msgData .= '<p>Thank You!</p>';

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
                        ' . $msgData . '
                    </body>
                    </html>';
        // echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendDTPRequestPlanStatusMail($id, $data, $comment = "")
    {
        $requestData = $this->db->get_where('dtp_request', array('id' => $id))->row();
        $mailTo = $this->db->get_where('users', array('id' => $requestData->created_by))->row()->email;
        $DTP = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $DTP . "\r\n";
        $headers .= 'From: ' . $DTP . "\r\n";
        $msgData = "";
        $subject = "DTP Request # DTP-" . $id . " - " . $requestData->task_name;


        if ($data['status'] == 8) {
            $msgData .= '<p>Your heads-up request has been accepted, please check.</p>';
        } elseif ($data['status'] == 9) {
            $msgData .= '<p>Your heads-up request has been Rejected, please check.</p>';
        }
        $msgData .= '<p>' . $comment . '</p>';
        $msgData .= '<p>Thank You!</p>';


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
                        ' . $msgData . '
                    </body>
                    </html>';

        mail($mailTo, $subject, $message, $headers);
    }
    // for nexus brands

    public function getNexusLinkByBrand($brand = "")
    {
        $link = "";
        $id = !empty($brand) ? $brand : $this->brand;
        $brand_data = $this->db->get_where('brand', array('id' => $id))->row();
        if (!empty($brand_data)) {
            $link = "https://aixnexus.com/" . $brand_data->alias;
        }

        return $link;
    }
    // get progress by start & end date 
    public function getProjectProgress($project_id)
    {
        // get project jobs (start date / last date as end date)
        date_default_timezone_set("Africa/Cairo");
        // $first = $this->db->order_by('start_date', 'ASC')->get_where('job', array('project_id' => $project_id))->row();
        // $last = $this->db->order_by('delivery_date', 'DESC')->get_where('job', array('project_id' => $project_id))->row();

        // if ($first) {
        //     $start_date = new DateTime($first->start_date);
        // } else {
        //     $start_date = new DateTime();
        // }

        // if ($last) {
        //     $end_date = new DateTime($last->delivery_date);
        // } else {
        //     $end_date = new DateTime();
        // }

        // $current_date = new DateTime();
        // //$total = $start_date->diff($end_date);
        // $total = date_diff($start_date, $end_date);
        // if ($current_date > $start_date) {
        //     $interval = date_diff($start_date, $current_date);
        //     $interval_hours = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
        // } else {
        //     $interval_hours = 0;
        // }

        // $total_hours = ($total->days * 24 * 60) + ($total->h * 60) + $total->i;

        $sql = "select TIMESTAMPDIFF(HOUR,start_date,delivery_date) as total_hours,TIMESTAMPDIFF(HOUR,start_date,now()) as interval_hours,now(),start_date,delivery_date from (
            (select start_date  from job where project_id =" . $project_id . " order by start_date asc limit 1) as start_date,
            (select delivery_date from job where project_id =" . $project_id . " order by delivery_date DESC limit 1) as delivery_date
            ) ";
        $progr = $this->db->query($sql)->row();
        if ($progr) {

            if ($progr->total_hours > 0) {
                $progress = $progr->interval_hours * 100 / $progr->total_hours;
                $progress = $progress >= 100 ? 100 : round($progress, 0);
            } else {
                $progress = 0;
            }
        } else {
            $progress = 0;
        }
        // print_r($progress);
        return $progress;
    }

    // Client Pm

    public function AllClientPms($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `client_pm` WHERE " . $filter . "  ORDER BY id DESC ");
        }
        return $data;
    }

    public function AllClientPmsPages($permission, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `client_pm` ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function selectClientPM($customer, $id = '')
    {
        $pms = $this->db->get_where('client_pm', array('customer_id' => $customer))->result();
        $data = '';
        foreach ($pms as $row) {
            if ($row->id == $id) {
                $data .= "<option value='" . $row->id . "' selected='selected'>" . $row->name . "<b> (" . $row->email . ")<b></option>";
            } else {
                $data .= "<option value='" . $row->id . "'>" . $row->name . "<b> (" . $row->email . ")</b></option>";
            }
        }
        return $data;
    }

    public function getClientPM($id)
    {
        $data = '';
        $pm = $this->db->get_where('client_pm', array('id' => $id))->row();
        if (!empty($pm))
            $data = $pm->name . "(" . $pm->email . ")";
        return $data;
    }

    public function getQCTypeByService($service)
    {
        $data = '';
        $row = $this->db->get_where('services', array('id' => $service))->row();
        if (!empty($row))
            $data = $row->qclog;
        return $data;
    }

    public function getQCCatName($id)
    {
        $data = '';
        $row = $this->db->get_where('qcchklist_cat', array('id' => $id))->row();
        if (!empty($row))
            $data = $row->name;
        return $data;
    }

    public function checkJobQC($job_id)
    {
        $data = false;
        $row = $this->db->get_where('job_qc', array('job_id' => $job_id))->row();
        if (!empty($row))
            $data = true;
        return $data;
    }

    public function sendJobsOverDueQC($mailData, $jobList)
    {
        $mailTo = $mailData->qmemail ?? '';
        $subject = $mailData->qmemailsub ?? '';
        $mailBody = $mailData->qmemaildesc ?? '';

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from("falaqsystem@thetranslationgate.com");
        $this->email->to($mailTo);
        $this->email->subject($subject);
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
                          <p>' . $jobList . '</p>
                         <p>Thank You!</p>
                     </body>
                     </html>';
        //echo $message;
        $this->email->message($message);
        $this->email->set_mailtype('html');
        if ($this->email->send()) {
            echo $this->email->print_debugger();
            return true;
        }
    }

    public function checkJobEvaluationTasks($job_id)
    {
        $data = false;
        $tasks = $this->db->get_where('job_task', array('job_id' => $job_id))->result();
        if (empty($tasks))
            $data = true;
        else {
            foreach ($tasks as $task) {
                $row = $this->db->get_where('task_evaluation', array('job_id' => $job_id, 'task_id' => $task->id, 'pm_ev_type!=' => 'null'))->row();
                if (!empty($row))
                    $data = true;
            }
        }
        return $data;
    }

    public function checkTaskEvaluationExists($task_id)
    {
        $data = false;
        $row = $this->db->get_where('task_evaluation', array('task_id' => $task_id, 'pm_ev_type!=' => 'null'))->row();
        if (!empty($row))
            $data = true;

        return $data;
    }

    public function getPmSetup($brand_id)
    {
        $data = false;
        $row = $this->db->get_where('pm_setup', array('brand' => $brand_id))->row();
        if (!empty($row))
            $data = $row;

        return $data;
    }
    public function VendorBlockSetup($brand_id)
    {
        $data = 0;
        $row = $this->db->get_where('pm_setup', array('brand' => $brand_id))->row();
        if (!empty($row))
            $data = !empty($row->block_v_no) ? $row->block_v_no : 0;

        return $data;
    }

    // start project cost

    public function checkManagerAccess($project_id)
    {
        $result = false;
        $projectData = $this->projects_model->getProjectData($project_id);
        $project_user = $projectData->created_by;
        $userData = $this->admin_model->getUserData($project_user);
        $project_emp = $userData->employees_id;
        $managerAccess = $this->admin_model->checkIfUserIsEmployeeManager($project_emp);
        if ($managerAccess == TRUE)
            $result = true;
        return $result;
    }

    public function getProfitPercentageSetup($brand_id)
    {
        $data = null;
        $row = $this->db->get_where('pm_setup', array('brand' => $brand_id))->row();
        if (!empty($row))
            $data = !empty($row->min_profit_percentage) ? $row->min_profit_percentage : null;

        return $data;
    }

    public function getProjectRevenue($project_id, $job_id = '', $data = '')
    {
        $total = 0;
        if (empty($job_id))
            $jobs = $this->db->get_where('job', array('project_id' => $project_id))->result();
        else
            $jobs = $this->db->get_where('job', array('project_id' => $project_id, 'id !=' => $job_id))->result();
        if (!empty($jobs)) {
            foreach ($jobs as $row) {
                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                $revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                // ConvertCurrencyToDollar
                $revenueDollar = self::convertCurrencyToDollar($priceList->currency, $row->created_at, $revenue);
                $total += $revenueDollar;
            }
        }
        if (!empty($data)) {
            $data['created_at'] =  $this->db->get_where('job', array('id' => $job_id))->row()->created_at;
            $data = (object) $data;
            $priceList = $this->projects_model->getJobPriceListData($data->price_list);
            $revenue = $this->sales_model->calculateRevenueJob($data->id, $data->type, $data->volume, $priceList->id);
            // ConvertCurrencyToDollar
            $revenueDollar = self::convertCurrencyToDollar($priceList->currency, $data->created_at, $revenue);
            $total += $revenueDollar;
        }

        return $total;
    }

    public function getTranslationHourRate()
    {
        $result = 0;
        $sql = "SELECT `employees_id` FROM `users` where `role` = 28 AND `status` = 1";
        $query = $this->db->query($sql);
        $array1 = $query->result_array();
        $users = array_map(function ($value) {
            return $value['employees_id'];
        }, $array1);
        $users = implode(',', $users);
        if (!empty($users)) {
            $salary =  $this->db->query("SELECT MAX(salary) AS maxSalary FROM `emp_finance` where `emp_id` IN ($users)")->row();

            if (!empty($salary))
                $result = $salary->maxSalary / 30 / 8;
        }
        return $result;
    }

    public function getDtpHourRate()
    {
        $result = 0;
        $sql = "SELECT `employees_id` FROM `users` where `role` = 24 AND `status` = 1";
        $query = $this->db->query($sql);
        $array1 = $query->result_array();
        $users = array_map(function ($value) {
            return $value['employees_id'];
        }, $array1);
        $users = implode(',', $users);
        if (!empty($users)) {
            $salary =  $this->db->query("SELECT MAX(salary) AS maxSalary FROM `emp_finance` where `emp_id` IN ($users)")->row();
            if (!empty($salary))
                $result = $salary->maxSalary / 30 / 8;
        }

        return $result;
    }

    public function getLeHourRate()
    {
        $result = 0;
        $sql = "SELECT `employees_id` FROM `users` where `role` = 26 AND `status` = 1";
        $query = $this->db->query($sql);
        $array1 = $query->result_array();
        $users = array_map(function ($value) {
            return $value['employees_id'];
        }, $array1);
        $users = implode(',', $users);
        if (!empty($users)) {
            $salary =  $this->db->query("SELECT MAX(salary) AS maxSalary FROM `emp_finance` where `emp_id` IN ($users)")->row();
            if (!empty($salary))
                $result = $salary->maxSalary / 30 / 8;
        }

        return $result;
    }

    public function getProjectCost($project_id, $task_type = '', $task_id = '')
    {
        $cost = 0;
        $jobs = $this->db->get_where('job', array('project_id' => $project_id))->result();
        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                // vendor tasks 
                if (!empty($task_type) && $task_type == 1) {
                    $vTasks = $this->db->get_where('job_task', array('job_id' => $job->id, 'status !=' => 2, 'status !=' => 3, 'id !=' => $task_id))->result();
                } else {
                    $vTasks = $this->db->get_where('job_task', array('job_id' => $job->id, 'status !=' => 2, 'status !=' => 3))->result();
                }
                if (!empty($vTasks)) {
                    foreach ($vTasks as $task) {
                        $taskCost = $task->rate * $task->count;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar($task->currency, $task->created_at, $taskCost);
                    }
                }
                // translation tasks 
                if (!empty($task_type) && $task_type == 2) {
                    $transTasks = $this->db->get_where('translation_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $transTasks = $this->db->get_where('translation_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($transTasks)) {
                    foreach ($transTasks as $task) {
                        $hourRate = self::getTranslationHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;

                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
                // dtp tasks 
                if (!empty($task_type) && $task_type == 3) {
                    $dtTasks = $this->db->get_where('dtp_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $dtTasks = $this->db->get_where('dtp_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($dtpTasks)) {
                    foreach ($dtpTasks as $task) {
                        $hourRate = self::getDtpHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
                // le tasks 
                if (!empty($task_type) && $task_type == 4) {
                    $leTasks = $this->db->get_where('le_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $leTasks = $this->db->get_where('le_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($leTasks)) {
                    foreach ($leTasks as $task) {
                        $hourRate = self::getLeHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
            }
        }

        return $cost;
    }

    public function getProjectProfit($project_id)
    {
        $revenue = self::getProjectRevenue($project_id);
        $cost = self::getProjectCost($project_id);
        $result = $revenue - $cost;
        return $result;
    }

    public function getProjectProfitPercentage($project_id)
    {

        $revenue = self::getProjectRevenue($project_id);
        $profit = self::getProjectProfit($project_id);
        if ($revenue != 0)
            $result = $profit / $revenue * 100;
        else
            $result = 0;

        if ($result < 0)
            $result = 0;
        return $result;
    }

    public function getProfitCurrentPercentage($revenue, $cost)
    {

        $profit = $revenue - $cost;
        if ($revenue != 0)
            $currentProjectPre = $profit / $revenue * 100;
        else
            $currentProjectPre = 0;

        if ($currentProjectPre < 0)
            $currentProjectPre = 0;

        return $currentProjectPre;
    }

    public function checkProjectProfitPercentage($project_id)
    {
        $project_data =  $this->db->get_where('project', array('id' => $project_id))->row();
        $minProjectPre = $project_data->min_profit_percentage;
        if (!empty($minProjectPre)) {
            $currentProjectPre = self::getProjectProfitPercentage($project_id);
            // start checking
            if ($currentProjectPre >=  $minProjectPre) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    public function checkProjectProfitPercentageForJobs($project_id, $job_id = '', $data = '')
    {
        $project_data =  $this->db->get_where('project', array('id' => $project_id))->row();
        $minProjectPre = $project_data->min_profit_percentage;
        if (!empty($minProjectPre)) {
            $revenue = self::getProjectRevenue($project_id, $job_id, $data);
            $cost = self::getProjectCost($project_id);
            $currentProjectPre = self::getProfitCurrentPercentage($revenue, $cost);;
            // start checking
            if ($currentProjectPre >=  $minProjectPre) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    public function checkProjectProfitPercentageForTasks($project_id, $task_type, $task_id = '', $new_data = '')
    {
        $project_data =  $this->db->get_where('project', array('id' => $project_id))->row();
        $minProjectPre = $project_data->min_profit_percentage;
        if (!empty($minProjectPre)) {
            $revenue = self::getProjectRevenue($project_id);
            if (!empty($new_data))
                $taskCost = self::getTaskCost($task_type, $new_data);
            else
                $taskCost = 0;

            $cost = self::getProjectCost($project_id, $task_type, $task_id) + $taskCost;

            $currentProjectPre = self::getProfitCurrentPercentage($revenue, $cost);
            // start checking
            if ($currentProjectPre >=  $minProjectPre) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    public function convertCurrencyToDollar($currencyFrom, $date, $total)
    {
        if ($currencyFrom == 2) {
            return $total;
        } else {
            $dateArray = explode("-", $date);
            $year = $dateArray[0];
            $month = $dateArray[1];
            $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $currencyFrom, 'currency_to' => 2))->row();
            return floatval($total) * floatval($mainCurrencyData->rate ?? '');
        }
    }

    // adding new task 

    public function checkSingleTaskPercentage($project_id, $type, $data)
    {
        $project_data =  $this->db->get_where('project', array('id' => $project_id))->row();
        $minProjectPre = $project_data->min_profit_percentage;
        if (!empty($minProjectPre)) {
            $revenue = self::getProjectRevenue($project_id);
            if ($revenue != 0) {
                $taskCost = self::getTaskCost($type, $data);
                $cost = self::getProjectCost($project_id) + $taskCost;
                $profit = $revenue - $cost;

                $currentProjectPre = $profit / $revenue * 100;
            } else {
                $currentProjectPre = 0;
            }
            $currentProjectPre = self::getProjectProfitPercentage($project_id);
            // start checking
            if ($currentProjectPre >=  $minProjectPre) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    public function getTaskCost($type, $task)
    {
        $cost = 0;
        $task = (object) $task;
        if ($type == 1) {
            $taskCost = $task->rate * $task->count;
            // ConvertCurrencyToDollar
            $cost += self::convertCurrencyToDollar($task->currency, $task->created_at, $taskCost);
        }
        // translation tasks 
        elseif ($type == 2) {
            $hourRate = self::getTranslationHourRate();
            $workCost = $task->work_hours * $hourRate;
            $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
            $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
            $taskCost = $workCost + $overtimeCost + $doublepaidCost;

            // ConvertCurrencyToDollar
            $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
        } elseif ($type == 3) {
            $hourRate = self::getDtpHourRate();
            $workCost = $task->work_hours * $hourRate;
            $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
            $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
            $taskCost = $workCost + $overtimeCost + $doublepaidCost;
            // ConvertCurrencyToDollar
            $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
        } elseif ($type == 4) {
            $hourRate = self::getLeHourRate();
            $workCost = $task->work_hours * $hourRate;
            $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
            $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
            $taskCost = $workCost + $overtimeCost + $doublepaidCost;
            // ConvertCurrencyToDollar
            $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
        }

        return $cost;
    }

    public function checkTaskCostError($type, $task)
    {
        $error = "";
        $task = (object) $task;
        if ($type == 1) {
            $taskCost = $task->rate * $task->count;
            if ($taskCost == 0) {
                $error = "Task Cost can't equal zero";
            } else {
                // ConvertCurrencyToDollar
                $convert = self::convertCurrencyToDollar($task->currency, $task->created_at, $taskCost);
                if ($convert == 0) {
                    $error = "Currency Rate doesn't exists";
                }
            }
        }
        // translation tasks 
        elseif ($type == 2) {
            $hourRate = self::getTranslationHourRate();
            if ($hourRate == 0) {
                $error = "Hour Rate doesn't exists";
            } else {
                $workCost = $task->work_hours * $hourRate;
                $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                if ($taskCost == 0) {
                    $error = "Task Cost can't equal zero";
                } else {
                    // ConvertCurrencyToDollar
                    $convert = self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    if ($convert == 0) {
                        $error = "Currency Rate doesn't exists";
                    }
                }
            }
        } elseif ($type == 3) {
            $hourRate = self::getDtpHourRate();
            if ($hourRate == 0) {
                $error = "Hour Rate doesn't exists";
            } else {
                $workCost = $task->work_hours * $hourRate;
                $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                if ($taskCost == 0) {
                    $error = "Task Cost can't equal zero";
                } else {
                    // ConvertCurrencyToDollar
                    $convert = self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    if ($convert == 0) {
                        $error = "Currency Rate doesn't exists";
                    }
                }
            }
        } elseif ($type == 4) {
            $hourRate = self::getLeHourRate();
            if ($hourRate == 0) {
                $error = "Hour Rate doesn't exists";
            } else {
                $workCost = $task->work_hours * $hourRate;
                $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                if ($taskCost == 0) {
                    $error = "Task Cost can't equal zero";
                } else {
                    // ConvertCurrencyToDollar
                    $convert = self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    if ($convert == 0) {
                        $error = "Currency Rate doesn't exists";
                    }
                }
            }
        }

        return $error;
    }

    // planning
    public function getPlanRevenue($plan_id)
    {
        $total = 0;
        $jobs = $this->db->get_where('job', array('plan_id' => $plan_id))->result();
        if (!empty($jobs)) {
            foreach ($jobs as $row) {
                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                $revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                // ConvertCurrencyToDollar
                $revenueDollar = self::convertCurrencyToDollar($priceList->currency, $row->created_at, $revenue);
                $total += $revenueDollar;
            }
        }
        if (!empty($data)) {
            $data['created_at'] =  $this->db->get_where('job', array('id' => $job_id))->row()->created_at;
            $data = (object) $data;
            $priceList = $this->projects_model->getJobPriceListData($data->price_list);
            $revenue = $this->sales_model->calculateRevenueJob($data->id, $data->type, $data->volume, $priceList->id);
            // ConvertCurrencyToDollar
            $revenueDollar = self::convertCurrencyToDollar($priceList->currency, $data->created_at, $revenue);
            $total += $revenueDollar;
        }

        return $total;
    }

    public function getPlanCost($plan_id)
    {
        $cost = 0;
        $jobs = $this->db->get_where('job', array('plan_id' => $plan_id))->result();
        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                // vendor tasks 
                if (!empty($task_type) && $task_type == 1) {
                    $vTasks = $this->db->get_where('job_task', array('job_id' => $job->id, 'status !=' => 2, 'status !=' => 3, 'id !=' => $task_id))->result();
                } else {
                    $vTasks = $this->db->get_where('job_task', array('job_id' => $job->id, 'status !=' => 2, 'status !=' => 3))->result();
                }
                if (!empty($vTasks)) {
                    foreach ($vTasks as $task) {
                        $taskCost = $task->rate * $task->count;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar($task->currency, $task->created_at, $taskCost);
                    }
                }
                // translation tasks 
                if (!empty($task_type) && $task_type == 2) {
                    $transTasks = $this->db->get_where('translation_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $transTasks = $this->db->get_where('translation_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($transTasks)) {
                    foreach ($transTasks as $task) {
                        $hourRate = self::getTranslationHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;

                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
                // dtp tasks 
                if (!empty($task_type) && $task_type == 3) {
                    $dtTasks = $this->db->get_where('dtp_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $dtTasks = $this->db->get_where('dtp_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($dtpTasks)) {
                    foreach ($dtpTasks as $task) {
                        $hourRate = self::getDtpHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
                // le tasks 
                if (!empty($task_type) && $task_type == 4) {
                    $leTasks = $this->db->get_where('le_request', array('job_id' => $job->id, 'status !=' => 4, 'id !=' => $task_id))->result();
                } else {
                    $leTasks = $this->db->get_where('le_request', array('job_id' => $job->id, 'status !=' => 4))->result();
                }
                if (!empty($leTasks)) {
                    foreach ($leTasks as $task) {
                        $hourRate = self::getLeHourRate();
                        $workCost = $task->work_hours * $hourRate;
                        $overtimeCost = $task->overtime_hours * $hourRate * 1.5;
                        $doublepaidCost = $task->doublepaid_hours * $hourRate * 2;
                        $taskCost = $workCost + $overtimeCost + $doublepaidCost;
                        // ConvertCurrencyToDollar
                        $cost += self::convertCurrencyToDollar(1, $task->created_at, $taskCost);
                    }
                }
            }
        }

        return $cost;
    }

    public function getPlanProfit($plan_id)
    {
        $revenue = self::getPlanRevenue($plan_id);
        $cost = self::getPlanCost($plan_id);
        $result = $revenue - $cost;
        return $result;
    }

    public function checkPlanProfitPercentage($plan_id)
    {
        $minProjectPre =  $this->projects_model->getProfitPercentageSetup($this->brand);
        if (!empty($minProjectPre)) {
            $re = self::getPlanRevenue($plan_id);
            $co = self::getPlanCost($plan_id);
            $currentProjectPre = self::getProfitCurrentPercentage($re, $co);
            // start checking
            if ($currentProjectPre >=  $minProjectPre) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }
}
