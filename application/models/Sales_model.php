<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Sales_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function AllActivities($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_activity` AS l WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_activity` AS l WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC ");
        }
        return $data;
    }

    public function AllActivitiesPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_activity` AS l HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_activity` AS l WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        }

        return $data;
    }

    public function selectContactMethod($select = "")
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
        } else {
            $selected1 = '';
            $selected2 = '';
            $selected3 = '';
            $selected4 = '';
            $selected5 = '';
        }

        $outpt = '<option value="1" ' . $selected1 . '>Call</option>
                  <option value="2" ' . $selected2 . '>Email</option>
                  <option value="3" ' . $selected3 . '>Skype</option>
                  <option value="4" ' . $selected4 . '>Meeting</option>
                  <option value="5" ' . $selected5 . '>Linked in</option>
                  ';
        return $outpt;
    }

    public function getContactMethod($select = "")
    {
        if ($select == 1) {
            $outpt = 'Call';
        } elseif ($select == 2) {
            $outpt = 'Email';
        } elseif ($select == 3) {
            $outpt = 'Skype';
        } elseif ($select == 4) {
            $outpt = 'Meeting';
        } elseif ($select == 5) {
            $outpt = 'Linked in';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function selectActivityStatus($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
            $selected3 = '';
            $selected4 = '';
        }

        $outpt = '<option value="1" ' . $selected1 . '>Interested</option>
                  <option value="2" ' . $selected2 . '>Not Answer</option>
                  <option value="3" ' . $selected3 . '>Not Interested</option>
                  <option value="4" ' . $selected4 . '>Prospect</option>
                  ';
        return $outpt;
    }

    public function getActivityStatus($select = "")
    {
        if ($select == 1) {
            $outpt = 'Interested';
        } elseif ($select == 2) {
            $outpt = 'Not Answer';
        } elseif ($select == 3) {
            $outpt = 'Not Interested';
        } elseif ($select == 4) {
            $outpt = 'Prospect';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function SelectFeedback($id = "")
    {
        $feedback = $this->db->get('contact_feedback')->result();
        $data = "";
        foreach ($feedback as $feedback) {
            if ($feedback->id == $id) {
                $data .= "<option value='" . $feedback->id . "' selected='selected'>" . $feedback->name . "</option>";
            } else {
                $data .= "<option value='" . $feedback->id . "'>" . $feedback->name . "</option>";
            }
        }
        return $data;
    }

    public function getFeedback($feedback)
    {
        $result = $this->db->get_where('contact_feedback', array('id' => $feedback))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectPm($id = "", $brand = "")
    {
        // $pm = $this->db->get_where('users',array('role'=>2,'brand'=>$brand))->result();
        $pm = $this->db->query(" SELECT * FROM users WHERE (role = '2' OR role = '29' OR role = '16' OR role = '42' OR role = '43' OR role = '45' OR role = '47' OR role = '52') AND brand = '$this->brand' ")->result();
        foreach ($pm as $pm) {
            if ($pm->id == $id) {
                $data .= "<option value='" . $pm->id . "' selected='selected'>" . $pm->user_name . "</option>";
            } else {
                $data .= "<option value='" . $pm->id . "'>" . $pm->user_name . "</option>";
            }
        }
        return $data;
    }


    public function getAllFollowUp($permission, $user, $id)
    {
        if ($permission->view == 1) {
            $data = $this->db->order_by('id', 'desc')->get_where('sales_follow_up', array('sales' => $id));
        } elseif ($permission->view == 2) {
            $data = $this->db->order_by('id', 'desc')->get_where('sales_follow_up', array('sales' => $id, 'created_by' => $user));
        }
        return $data;
    }

    public function AllOpportunities($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,r.region,
               (SELECT brand FROM customer WHERE customer.id = l.customer) AS brand 
               FROM `sales_opportunity` AS l 
               LEFT OUTER JOIN customer_leads AS r
               ON l.lead = r.id  WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,r.region,
               (SELECT brand FROM customer WHERE customer.id = l.customer) AS brand 
               FROM `sales_opportunity` AS l 
               LEFT OUTER JOIN customer_leads AS r
               ON l.lead = r.id  WHERE " . $filter . " AND l.created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC ");
        }
        return $data;
    }

    public function AllOpportunitiesPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $sql = "SELECT l.*,r.region,
            (SELECT brand FROM customer WHERE customer.id = l.customer) AS brand 
            FROM `sales_opportunity` AS l 
            LEFT OUTER JOIN customer_leads AS r
            ON l.lead = r.id HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset";

            $data = $this->db->query($sql);
        } elseif ($permission->view == 2) {
            $sql = " SELECT l.*,r.region,
            (SELECT brand FROM customer WHERE customer.id = l.customer) AS brand 
            FROM `sales_opportunity` AS l 
            LEFT OUTER JOIN customer_leads AS r
            ON l.lead = r.id WHERE l.created_by = '" . $user . "' HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset";

            $data = $this->db->query($sql);
        }

        return $data;
    }


    public function SelectProjectStatus($id = "")
    {
        $status = $this->db->get('project_status')->result();
        $data = "";
        foreach ($status as $status) {
            if ($status->id == $id) {
                $data .= "<option value='" . $status->id . "' selected='selected'>" . $status->name . "</option>";
            } else {
                $data .= "<option value='" . $status->id . "'>" . $status->name . "</option>";
            }
        }
        return $data;
    }

    public function getProjectStatus($status)
    {
        $result = $this->db->get_where('project_status', array('id' => $status))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectTools($id = "")
    {
        $tool = $this->db->get_where('tools', array('parent' => 0))->result();
        $data = "";
        foreach ($tool as $tool) {
            $child = $this->db->get_where('tools', array('parent' => $tool->id));
            if ($child->num_rows() > 0) {
                $data .= " <option disabled='disabled' style='font-weight: bold;'> --" . $tool->name . " -- </option>";
            } else {
                if ($tool->id == $id) {
                    $data .= "<option value='" . $tool->id . "' selected='selected'>" . $tool->name . "</option>";
                } else {
                    $data .= "<option value='" . $tool->id . "'>" . $tool->name . "</option>";
                }
            }
            foreach ($child->result() as $child) {
                if ($child->id == $id) {
                    $data .= "<option value='" . $child->id . "' selected='selected'>" . $child->name . "</option>";
                } else {
                    $data .= "<option value='" . $child->id . "'>" . $child->name . "</option>";
                }
            }
        }
        return $data;
    }
    public function selectMultiTools($id = "")
    {
        $tools = $this->db->get('tools')->result();
        $data = "";
        $arr_id = explode(",", $id);
        foreach ($tools as $tools) {
            if (in_array($tools->id, $arr_id)) {
                $data .= "<option value='" . $tools->id . "' selected='selected'>" . $tools->name . "</option>";
            } else {
                $data .= "<option value='" . $tools->id . "'>" . $tools->name . "</option>";
            }
        }
        return $data;
    }

    public function getToolName($tool)
    {
        $result = $this->db->get_where('tools', array('id' => $tool))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getRegionAbbreviations($id)
    {
        $abbreviation = $this->db->get_where('regions', array('id' => $id))->row()->abbreviations;
        return $abbreviation;
    }

    public function getUserAbbreviations($id)
    {
        $abbreviation = $this->db->get_where('users', array('id' => $id))->row()->abbreviations;
        return $abbreviation;
    }

    public function getBrandAbbreviations($id)
    {
        $abbreviation = $this->db->get_where('brand', array('id' => $id))->row()->abbreviations;
        return $abbreviation;
    }

    public function getServiceAbbreviations($id)
    {
        $abbreviation = $this->db->get_where('services', array('id' => $id))->row()->abbreviations;
        return $abbreviation;
    }

    public function getPriceListByLead($lead = "", $pricList = "", $product_line = "")
    {
        $result = $this->db->get_where('customer_price_list', array('lead' => $lead, 'product_line' => $product_line, 'approved' => 1))->result();
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
            if ($pricList == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <input type="text" id="rate_' . $x . '" value="' . $row->rate . '" hidden> 
                            <td><input type="radio" name="price_list" onclick="getCheckedPriceListIdRate()" id="' . $x . '" value="' . $row->id . '" ' . $radio . ' ' . $checked . '></td>
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
        return $data;
    }

    public function getPriceListById($pricList = "")
    {
        $row = $this->db->get_where('customer_price_list', array('id' => $pricList))->row();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Product Line</th>
                            <th>Subject Matter</th>
                            <th>Service</th>
                            <th>Source Language</th>
                            <th>Target Language</th>
                            <th>Rate</th>
                            <th>Unit</th>
                            <th>Currency</th>
                        </tr>
                    </thead>
        
                    <tbody>';

        $data .= '<tr class="">
                <td>' . $this->customer_model->getProductLine($row->product_line) . '</td>
                <td>' . $this->admin_model->getFields($row->subject) . '</td>
                <td>' . $this->admin_model->getServices($row->service) . '</td>
                <td>' . $this->admin_model->getLanguage($row->source) . '</td>
                <td>' . $this->admin_model->getLanguage($row->target) . '</td>
                <td>' . $row->rate . '</td>
                <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
            </tr>';

        $data .= '</tbody></table>';
        return $data;
    }

    public function calculateRevenue($opportunity, $type, $volume, $priceList)
    {
        $rate = $this->db->get_where('customer_price_list', array('id' => $priceList))->row()->rate;
        if ($type == 1) {
            $result = $rate * $volume;
        } elseif ($type == 2) {
            $fuzzy = $this->db->get_where('project_fuzzy', array('opportunity' => $opportunity))->result();
            $result = 0;
            foreach ($fuzzy as $row) {
                $result = $result + ($row->unit_number * $row->value * $rate);
            }
        }
        return $result;
    }

    public function calculateRevenueJob($job, $type, $volume, $priceList)
    {
        $rate = $this->db->get_where('job_price_list', array('id' => $priceList))->row()->rate;
        if ($type == 1) {
            $result = $rate * $volume;
        } elseif ($type == 2) {
            $fuzzy = $this->db->get_where('project_fuzzy', array('job' => $job))->result();
            $result = 0;
            foreach ($fuzzy as $row) {
                $result = $result + ($row->unit_number * $row->value * $rate);
            }
        }
        return $result;
    }

    public function getPriceListData($id)
    {
        $row = $this->db->get_where('customer_price_list', array('id' => $id))->row();
        return $row;
    }
    public function sendAliasMail($lead, $pm, $sam)
    {
        $mailTo = "help@thetranslationgate.com";
        $pm_mail = $this->db->get_where('users', array('id' => $pm))->row()->email;
        $sam_mail = $this->db->get_where('users', array('id' => $sam))->row()->email;
        $leadData = $this->db->get_where('customer_leads', array('id' => $lead))->row();
        $customer_brand = $this->db->get_where('customer', array('id' => $leadData->customer))->row();
        $brand = $this->db->get_where('brand', array('id' => $customer_brand->brand))->row()->alias;
        $region = $this->db->get_where('regions', array('id' => $leadData->region))->row()->name;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $pm_mail . "\r\n";
        $headers .= 'From: ' . $sam_mail . "\r\n" . 'Reply-To: ' . $sam_mail . "\r\n";

        $subject = "Create Alias - " . date("Y-m-d H:i:s");
        if ($customer_brand->brand == 1) {
            $project = "projects@" . $brand;
            $region = $region . "@" . $brand;
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
                        <p>Dear IT Team,</p>
                           <p>Please create the below alias.</p>
                           <p>Alias:</p>
                           <p>' . strtolower(str_replace(' ', '', $customer_brand->name)) . '@' . $brand . '</p>
                           <p> Forward to:</p>
                           <p>' . $project . '</p><p>' . $region . '</p><p>' . $pm_mail . '</p>
                           <p> Thanks</p>
                        </body>
                        </html>';
            //    echo "$message"; 
            mail($mailTo, $subject, $message, $headers);
        } elseif ($customer_brand->brand == 2) {
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
                        <p>Dear IT Team,</p>
                           <p>Please create the below alias.</p>
                           <p>Alias:</p>
                           <p>' . strtolower(str_replace(' ', '', $customer_brand->name)) . '@' . $brand . '</p>
                           <p>Forward to:</p>
                            <p>shehab.hussein@localizera.com</p>
                            <p>dalia.diab@localizera.com</p>
                            <p>radwa.gamal@localizera.com</p>
                            <p>natasha.symon@localizera.com</p>
                           <p> Thanks</p>
                        </body>
                        </html>';
            //    echo "$message"; 
            mail($mailTo, $subject, $message, $headers);
        } elseif ($customer_brand->brand == 3) {
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
                        <p>Dear IT Team,</p>
                           <p>Please create the below alias.</p>
                           <p>Alias:</p>
                           <p>' . strtolower(str_replace(' ', '', $customer_brand->name)) . '@' . $brand . '</p>
                           <p> Forward to:</p>
                            <p>pm@europelocalize.com</p>
                            <p>warsaw@europelocalize.com</p>
                           <p> Thanks</p>
                        </body>
                        </html>';
            //    echo "$message"; 
            mail($mailTo, $subject, $message, $headers);
        } elseif ($customer_brand->brand == 11) {
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
                        <p>Dear IT Team,</p>
                           <p>Please create the below alias.</p>
                           <p>Alias:</p>
                           <p>' . strtolower(str_replace(' ', '', $customer_brand->name)) . '@' . $brand . '</p>
                           <p> Forward to:</p>
                            <p>pm@columbuslang.com</p>
                            <p>sam@columbuslang.com</p
                           <p> Thanks</p>
                        </body>
                        </html>';
            //    echo "$message"; 
            mail($mailTo, $subject, $message, $headers);
        }
    }

    public function getPriceListFuzzy($opportunity, $volume, $type, $rate, $disabled = 0)
    {
        $result = $this->db->get_where('project_fuzzy', array('opportunity' => $opportunity));
        if ($disabled == 1) {
            $disable = "disabled=''";
            $readonly = "readonly=''";
        } else {
            $readonly = "";
            $disable = "";
        }
        if ($type == 2) {
            $totalRows = $result->num_rows();
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows" value="' . $totalRows . '" id="total_rows" onchange="projectFuzzy()" ' . $disable . '></div>';
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
                $total_price = $row->value * $row->unit_number * $rate;
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $x . '" value="' . $row->prcnt . '" name="prcnt_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="unit_number_' . $x . '" value="' . $row->unit_number . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="0" name="unit_number_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="value_' . $x . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="' . $row->value . '" name="value_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="total_price_' . $x . '" name="total_price_' . $x . '" value="' . $total_price . '" readonly="" ' . $disable . '></td>
                            </tr>';
                $x++;
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type" value="2" hidden="">';
        } else if ($type == 1) {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolume()' onkeypress='return numbersOnly(event)' name='volume' value='" . $volume . "' id='volume' required " . $readonly . ">
                            </div>
                        </div>";
            $data .= '<input type="text" name="type" value="1" hidden="">';
        }
        echo $data;
    }

    public function getPriceListFuzzyJob($job, $volume, $type, $rate, $disabled = 0)
    {
        $result = $this->db->get_where('project_fuzzy', array('job' => $job));
        if ($disabled == 1) {
            $disable = "disabled=''";
        } else {
            $disable = "";
        }
        if ($type == 2) {
            $totalRows = $result->num_rows();
            $data = '<label class="col-lg-3 control-label" for="role name">Number Of Rows</label><div class="col-lg-3"><input type="text" class=" form-control" name="total_rows" value="' . $totalRows . '" id="total_rows" onchange="projectFuzzy()" ' . $disable . '></div>';
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
                $total_price = $row->value * $row->unit_number * $rate;
                $data .= '<tr class="">
                                <td><input type="text" id="prcnt_' . $x . '" value="' . $row->prcnt . '" name="prcnt_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="unit_number_' . $x . '" value="' . $row->unit_number . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="0" name="unit_number_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="value_' . $x . '" onblur="fuzzyCalculation(' . $x . ');totalRevenue(' . $totalRows . ')" value="' . $row->value . '" name="value_' . $x . '" required ' . $disable . '></td>
                                <td><input type="text" id="total_price_' . $x . '" name="total_price_' . $x . '" value="' . $total_price . '" readonly="" ' . $disable . '></td>
                            </tr>';
                $x++;
            }
            $data .= '</tbody></table>';
            $data .= '<input type="text" name="type" value="2" hidden="">';
        } else if ($type == 1) {
            $data = " <div class='form-group'>
                            <label class='col-lg-3 control-label'>Volume</label>

                            <div class='col-lg-6'>
                                <input type='text' class=' form-control' onblur='totalRevenueVolume()' onkeypress='return numbersOnly(event)' name='volume' value='" . $volume . "' id='volume' required " . $disable . ">
                            </div>
                        </div>";
            $data .= '<input type="text" name="type" value="1" hidden="">';
        }
        echo $data;
    }

    public function RemainderMail($row)
    {
        $activity = $this->db->get_where('sales_activity', array('id' => $row->sales))->row();
        $sam = $this->db->get_where('users', array('id' => $row->created_by))->row();
        $mailTo = $sam->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Falaq' . "\r\n";

        $subject = "Follow Up Remainder - " . date("Y-m-d H:i:s");

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
                       <p>Please check your follow up </p><p> Activity #' . $activity->id . '</p><p> Client : ' . $this->customer_model->getCustomer($activity->customer) . '</p>
                       <p>Follow Up Date : ' . $row->new_hitting . '</p>
                       <p>Your Comment : ' . $row->comment . '</p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
        $this->db->update('sales_follow_up', array('remainder' => 1), array('id' => $row->id));
    }

    public function opportunityJobs($permission, $user, $id)
    {
        if ($permission->view == 1) {
            $data = $this->db->get_where('job', array('opportunity' => $id));
        } elseif ($permission->view == 2) {
            $data = $this->db->get_where('job', array('opportunity' => $id, 'created_by' => $user));
        }
        return $data;
    }

    public function AllProjects($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $sql = "SELECT j.*, p.name AS project_name,p.code AS project_code,p.customer,p.lead,p.product_line,p.opportunity,r.region,
            (SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM job AS j LEFT OUTER JOIN project AS p 
             ON p.id = j.project_id LEFT OUTER JOIN customer_leads AS r ON p.lead = r.id WHERE " . $filter . " HAVING brand = '$brand' " . " ORDER BY ID DESC ";

            $data = $this->db->query($sql);
        } elseif ($permission->view == 2) {
            $sql = " SELECT j.*, p.name AS project_name,p.code AS project_code,p.customer,p.lead,p.product_line,p.opportunity,r.region,
            (SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM job AS j LEFT OUTER JOIN project AS p 
             ON p.id = j.project_id LEFT OUTER JOIN customer_leads AS r ON p.lead = r.id WHERE j.assigned_sam = '$this->user' AND " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ";
            $data = $this->db->query($sql);
        }
        return $data;
    }

    public function AllProjectsPages($permission, $user, $brand, $limit, $offset)
    {

        if ($permission->view == 1) {
            $data = $this->db->query("SELECT j.*, p.name AS project_name,p.code AS project_code,p.customer,p.lead,p.product_line,p.opportunity,r.region,
   (SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM job AS j LEFT OUTER JOIN project AS p 
    ON p.id = j.project_id LEFT OUTER JOIN customer_leads AS r ON p.lead = r.id HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT j.*, p.name AS project_name,p.code AS project_code,p.customer,p.lead,p.product_line,p.opportunity,r.region,
   (SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM job AS j LEFT OUTER JOIN project AS p 
    ON p.id = j.project_id LEFT OUTER JOIN customer_leads AS r ON p.lead = r.id WHERE j.assigned_sam = '$this->user' HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        }

        return $data;
    }

    public function sendAssigningMail($user, $brand, $pms, $opportunity_id)
    {
        $opportunity = $this->db->get_where('sales_opportunity', array('id' => $opportunity_id))->row();
        $lead = $this->db->get_where('customer_leads', array('id' => $opportunity->lead))->row();
        $jobs = $this->db->get_where('job', array('opportunity' => $opportunity_id, 'created_by' => $this->user));

        $subject = "New Opportunity - $opportunity->project_name";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $this->admin_model->getUserEmail($user) . "\r\n";
        $headers .= 'From: ' . $this->admin_model->getUserEmail($user) . "\r\n" . 'Reply-To: ' . $this->admin_model->getUserEmail($user) . "\r\n";
        $headers .= "Cc: 'mohamed.elshehaby@thetranslationgate.com" . "\r\n";

        $pmMails = array();
        foreach ($pms->result() as $user) {
            $pmMail = $this->admin_model->getUserEmail($user->pm);
            array_push($pmMails, $pmMail);
        }

        $mailTo = implode(',', $pmMails);
        if ($brand == 1) {
            $headers .= "Cc: 'mahmoud.roshdy@thetranslationgate.com" . "\r\n";
        } elseif ($brand == 2) {
            $headers .= "Cc: 'algohary@dtpzone.com" . "\r\n";
        } elseif ($brand == 3) {
            $headers .= "Cc: 'emre@europelocalize.com" . "\r\n";
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
                    <p>Hello Dear,</p>
                       <p> You are assigned to a new opportunity </p>                      
                       <p>Opportunity Number : <a href="' . base_url() . 'projects/saveProject?t=' .
            base64_encode($opportunity->id) . '">' . $opportunity->id . '</a></p>
                       <p>Project Name : ' . $opportunity->project_name . '</p>
                       <p>Customer : ' . $this->customer_model->getCustomer($opportunity->customer) . '</p>
                       <p>Region : ' . $this->admin_model->getRegion($lead->region) . '</p>
                       <p>Country : ' . $this->admin_model->getCountry($lead->country) . '</p>
                       <p><a href="' . base_url() . 'projects/saveProject?t=' . base64_encode($opportunity->id) . '"> View Opportunity</a></p>
                        <br/>
                        ';
        if (isset($jobs)) {
            $message .= '<p><b>Opportunity Jobs : <b></p>
                      <table style="overflow:scroll;border: 1px solid;width: 100%;text-align: center" >
                         <thead>
                           <tr>
                                <th>Job Name</th>
                                <th>Product Line</th>
                                <th>Service</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th>Volume</th>
                                <th>Rate</th>
                                <th>Total Revenue</th>
                                <th>Currency</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Created By</th>
                                <th>Created At</th>
                           </tr>
                         </thead>
                         <tbody>';
            foreach ($jobs->result() as $row) {
                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                $message .= '  <tr>
                                <td>' . $row->name . '</td>
                                <td>' . $this->customer_model->getProductLine($priceList->product_line) . '</td>
                                <td>' . $this->admin_model->getServices($priceList->service) . '</td>
                                <td>' . $this->admin_model->getLanguage($priceList->source) . '</td>
                                <td>' . $this->admin_model->getLanguage($priceList->target) . '</td>
                                <td>' . $row->volume . '</td>
                                <td>' . $priceList->rate . '</td>
                                <td>' . $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id) . '</td>
                                <td>' . $this->admin_model->getCurrency($priceList->currency) . '</td>
                                <td>' . $row->start_date . '</td>
                                <td>' . $row->delivery_date . '</td>
                                <td>' . $this->admin_model->getAdmin($row->created_by) . '</td>
                                <td>' . $row->created_at . '</td>
                           </tr>';
            }
            $message .= '  </tbody>
                         </table>
                        <br/><br/>';
        }
        $message .= ' <p> Thanks</p>
                    </body>
                    </html>';
        mail($mailTo, $subject, $message, $headers);
    }

    public function AllbusinessReviews($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_business_reviews` AS l WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            if ($this->role == 2) {
                $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM customer_pm WHERE customer_pm.lead = l.lead AND customer_pm.pm = '$user') AS total FROM `sales_business_reviews` AS l WHERE " . $filter . " HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC ");
            } elseif ($this->role == 3 || $this->role == 29) {
                $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_business_reviews` AS l WHERE " . $filter . " AND created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC ");
            }
        }
        return $data;
    }

    public function AllbusinessReviewsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_business_reviews` AS l HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            if ($this->role == 2) {
                $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM customer_pm WHERE customer_pm.lead = l.lead AND customer_pm.pm = '$user') AS total FROM `sales_business_reviews` AS l HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC LIMIT $limit OFFSET $offset");
            } elseif ($this->role == 3 || $this->role == 29) {
                $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `sales_business_reviews` AS l WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
            }
        }

        return $data;
    }


    public function SelectSlaReason($id = "")
    {
        $reason = $this->db->get('sla_reason')->result();
        $data = "";
        foreach ($reason as $reason) {
            if ($reason->id == $id) {
                $data .= "<option value='" . $reason->id . "' selected='selected'>" . $reason->name . "</option>";
            } else {
                $data .= "<option value='" . $reason->id . "'>" . $reason->name . "</option>";
            }
        }
        return $data;
    }

    public function getSlaReason($reason)
    {
        $result = $this->db->get_where('sla_reason', array('id' => $reason))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function SelectSipIssue($id = "")
    {
        $issue = $this->db->get('sip_issue')->result();
        $data = "";
        foreach ($issue as $issue) {
            if ($issue->id == $id) {
                $data .= "<option value='" . $issue->id . "' selected='selected'>" . $issue->name . "</option>";
            } else {
                $data .= "<option value='" . $issue->id . "'>" . $issue->name . "</option>";
            }
        }
        return $data;
    }

    public function getSipIssue($issue)
    {
        $result = $this->db->get_where('sip_issue', array('id' => $issue))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function sendBusinessReviewMail($data, $user, $id)
    {
        $subject = "New Business Review";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $this->admin_model->getUserEmail($user) . "\r\n";
        $headers .= 'From: ' . $this->admin_model->getUserEmail($user) . "\r\n" . 'Reply-To: ' . $this->admin_model->getUserEmail($user) . "\r\n";

        $customerData = $this->db->get_where('customer', array('id' => $data['customer']))->row();
        if ($data['type'] == 1) {
            $type = "SLA";
        } elseif ($data['type'] == 2) {
            $type = "SIP";
        }

        $mailTo = $customerData->alias;
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
                                                 <td style="background-color: #f9f9f9;">Number</td>
                                                 <td style="background-color:#ddd;">' . $id . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Client</td>
                                                 <td style="background-color:#ddd;">' . $customerData->name . '</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Type</td>
                                                 <td style="background-color:#ddd;">' . $type . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>';
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendActivityCommentMail($data, $user, $brand)
    {
        $subject = "Sales Activity Comment";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $this->admin_model->getUserEmail($user) . "\r\n";
        $headers .= 'From: ' . $this->admin_model->getUserEmail($user) . "\r\n" . 'Reply-To: ' . $this->admin_model->getUserEmail($user) . "\r\n";

        $lead = $this->db->get_where('customer_leads', array('id' => $data['lead']))->row();
        $customerData = $this->db->get_where('customer', array('id' => $lead->customer))->row();
        if ($brand == 1) {
            $mailTo = "marketing@thetranslationgate.com";
        } elseif ($brand == 2) {
            $mailTo = "marketing@dtpzone.com";
        } elseif ($brand == 3) {
            $mailTo = "marketing@europelocalize.com";
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
                    </style>
                    <!--Core js-->
                </head>
                    <body>
                        <p>Dear Team,</p>
                        <p>Please check the below comment:</p>
                        <p>Customer : ' . $customerData->name . '</p>
                        <p>Comment : ' . $data['comment'] . '</p>
                    </body>
                </html>';
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendLeadCommentMail($data, $user, $brand)
    {
        $subject = "Sales Activity Comment";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $this->admin_model->getUserEmail($user) . "\r\n";
        $headers .= 'From: ' . $this->admin_model->getUserEmail($user) . "\r\n" . 'Reply-To: ' . $this->admin_model->getUserEmail($user) . "\r\n";
        if ($brand == 1) {
            $headers .= "Cc: marketing@thetranslationgate.com" . "\r\n";
        } elseif ($brand == 2) {
            $headers .= "Cc: marketing@dtpzone.com" . "\r\n";
        } elseif ($brand == 3) {
            $headers .= "Cc: marketing@europelocalize.com" . "\r\n";
        }

        $activity = $this->db->get_where('sales_activity', array('id' => $data['activity']))->row();
        $customerData = $this->db->get_where('customer', array('id' => $activity->customer))->row();

        $mailTo = $this->admin_model->getUserEmail($activity->created_by);

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
                        <p>Dear ' . $this->admin_model->getAdmin($activity->created_by) . ',</p>
                        <p>Please check the below comment:</p>
                        <p>Activity : ' . $activity->id . '</p>
                        <p>Customer : ' . $customerData->name . '</p>
                        <p>Comment : ' . $data['comment'] . '</p>
                    </body>
                </html>';
        mail($mailTo, $subject, $message, $headers);
    }

    //lost opportunity
    public function SelectLostReasons($id = "")
    {
        $lostReasons = $this->db->get('sales_opportunity_lost_reasons')->result();
        $data = "";
        foreach ($lostReasons as $lostReasons) {
            if ($lostReasons->id == $id) {
                $data .= "<option value='" . $lostReasons->id . "' selected='selected'>" . $lostReasons->name . "</option>";
            } else {
                $data .= "<option value='" . $lostReasons->id . "'>" . $lostReasons->name . "</option>";
            }
        }
        return $data;
    }
    public function getLostReasons($id = "")
    {
        $result = $this->db->get_where('sales_opportunity_lost_reasons', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getLostOpportunityPM($customer_id, $lead)
    {
        $customer_status = $this->db->query(" SELECT status FROM customer WHERE id = '$customer_id' ")->row();
        if ($customer_status->status == 1) {
            //lead //select all pm  roles 2 or 16 
            $row = $this->db->query(" SELECT id,user_name FROM users WHERE (role = '2' OR role = '29' OR role = '16' OR role = '42' OR role = '43' OR role = '47' OR role = '52') AND brand = '$this->brand' AND status = '1' ")->result();
        } elseif ($customer_status->status == 2) {
            //exicting //select assigned pm
            $row = $this->db->query(" SELECT u.id,u.user_name FROM users AS u LEFT OUTER JOIN customer_pm AS p ON u.id = p.pm WHERE p.lead = '$lead'  ")->result();
        }
        $data = "<option value='' disabled='' selected='selected'>-- Select PM --</option>";
        foreach ($row as $row) {
            $data .= "<option value='" . $row->id . "' selected='selected'>" . $row->user_name . "</option>";
        }
        return $data;
    }

    public function SelectAllProductLines($id = "")
    {
        $productLine = $this->db->get('customer_product_line')->result();
        $data = "";
        foreach ($productLine as $productLine) {
            if ($productLine->id == $id) {
                $data .= "<option value='" . $productLine->id . "' selected='selected'>" . $productLine->name . "</option>";
            } else {
                $data .= "<option value='" . $productLine->id . "'>" . $productLine->name . "</option>";
            }
        }
        return $data;
    }
    public function getProductLines($id = "")
    {
        $result = $this->db->get_where('customer_product_line', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function AllLostOpportunity($permission, $user, $filter, $brand)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT s.*,l.region,l.country FROM sales_lost_opportunity AS s LEFT OUTER JOIN customer_leads AS l ON l.id = s.lead WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT s.*,l.region,l.country FROM sales_lost_opportunity AS s LEFT OUTER JOIN customer_leads AS l ON l.id = s.lead WHERE " . $filter . " AND s.created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC ");
        }
        return $data;
    }

    public function AllLostOpportunityPages($permission, $user, $limit, $offset, $brand)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT s.*,l.region,l.country FROM sales_lost_opportunity AS s LEFT OUTER JOIN customer_leads AS l ON l.id = s.lead HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT s.*,l.region,l.country FROM sales_lost_opportunity AS s LEFT OUTER JOIN customer_leads AS l ON l.id = s.lead WHERE s.created_by = '$user' HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset");
        }

        return $data;
    }

    public function calculateRevenueJobForSalesOfCost($job, $type, $volume, $rate)
    {
        if ($type == 1) {
            $result = $rate * $volume;
        } elseif ($type == 2) {
            $fuzzy = $this->db->get_where('project_fuzzy', array('job' => $job))->result();
            $result = 0;
            foreach ($fuzzy as $row) {
                $result = $result + ($row->unit_number * $row->value * $rate);
            }
        }
        return $result;
    }

    // new
    public function getClientPriceStatus($status = "")
    {

        if ($status == 0) {
            $outpt = "<p class='badge badge-secondary p-2'><i class='fa fa-stop-circle pr-1'></i><span>Waiting Approval</span></p>";
        } elseif ($status == 1) {
            $outpt = "<p class='badge badge-dark p-2'><i class='fa fa-check-circle text-white pr-1'></i><span>Approved</span></p>";
        } elseif ($status == 2) {
            $outpt = "<p class='badge badge-danger p-2'><i class='fa fa-times-circle pr-1 text-white'></i><span>Rejected</span></p>";
        } else {
            $outpt = "";
        }

        return $outpt;
    }

    public function selectClientPriceStatus($select = "")
    {
        // 0 => waiting approval
        if ($select == 3) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } elseif ($select == 2) {
            $selected3 = 'selected';
        }
        $outpt = '<option value="3" ' . $selected1 . '>Waiting Approval</option>
                  <option value="1" ' . $selected2 . '>Approved</option>
                  <option value="2" ' . $selected3 . '>Rejected</option>';
        return $outpt;
    }

    public function selectClientType($select = "")
    {
        // var_dump($select);
        if ($select == 1) {
            $selected1 = 'selected';
            $selected2 = '';
            $selected3 = '';
        } elseif ($select == 2) {
            $selected2 = 'selected';
            $selected1 = '';
            $selected3 = '';
        } elseif ($select == 3) {
            $selected3 = 'selected';
            $selected2 = '';
            $selected1 = '';
        }
        $outpt = '<option value="1" ' . $selected1 . '>Zone only</option>
                  <option value="2" ' . $selected2 . '>Multi-Zone</option>
                  <option value="3" ' . $selected3 . '>24 H</option>';
        return $outpt;
    }

    public function getClientType($status = "")
    {
        if ($status == 1) {
            $outpt = '<span class="badge badge-dark p-2">Zone only</span>';
        } elseif ($status == 2) {
            $outpt = '<span class="text-white badge badge-warning p-2">Multi-Zone</span>';
        } elseif ($status == 3) {
            $outpt = '<span class="badge badge-success p-2">24 H</span>';
        } else {
            $outpt = "";
        }

        return $outpt;
    }
}
