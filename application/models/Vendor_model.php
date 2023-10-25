<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Vendor_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // public function AllVendors($permission,$user,$brand,$filter)
    //    {
    //        if($permission->view == 1){
    //            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' AND ".$filter." ORDER BY id DESC");
    //        }elseif($permission->view == 2){
    //            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' AND created_by = '$user' AND ".$filter." ORDER BY id DESC");
    //        }
    //        return $data;
    //    }

    public function AllVendors($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND created_by = '$user' AND " . $filter . " ORDER BY id DESC");
        }
        return $data;
    }

    public function AllVendorsTTG($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId,s.copied FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND " . $filter . " ORDER BY v.id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId,s.copied FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND created_by = '$user' AND " . $filter . " ORDER BY v.id DESC");
        }
        return $data;
    }

    public function AllVendorsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' AND created_by = '$user' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function viewVmTickets($brand, $filter = "")
    {
        if ($filter) {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE " . $filter . " HAVING brand = '$brand' order by id desc");
        } else {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v HAVING brand = '$brand' order by id desc");
        }
        return $data;
    }

    public function viewVmTicketsPages($brand, $limit, $offset, $filter = "")
    {
        if ($filter) {
            $sql = "SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v  WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ";
        } else {
            $sql = "SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ";
        }
        $data = $this->db->query($sql);
        return $data;
    }
    public function countVmTicketsPages($brand, $filter = "")
    {
        if ($filter) {
            $data = $this->db->query("SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v  WHERE " . $filter . " HAVING brand = '$brand' ");
        } else {
            $data = $this->db->query("SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v HAVING brand = '$brand'  ");
        }
        return $data;
    }
    public function viewSalesVmTickets($permission, $user, $from_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => $from_id, 'ticket_from' => 1));
        } elseif ($permission->view == 2) {
            $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => $from_id, 'ticket_from' => 1, 'created_by' => $user));
        }
        return $data;
    }

    public function viewVmTicketWithoutOpp($permission, $brand, $user, $data, $filter_created_by = '')
    {
        if ($brand == 3 and $permission->view == 1) {
            if (!empty($filter_created_by))
                $data = $this->db->query("SELECT v.*,(SELECT `brand` FROM `users` WHERE users.id = v.created_by) AS `brand` From vm_ticket as v WHERE `from_id` = 0 AND `ticket_from` = 3 AND `created_by` = $filter_created_by HAVING `brand` = 3 order by `id` desc");
            else
                $data = $this->db->query("SELECT v.*,(SELECT `brand` FROM `users` WHERE users.id = v.created_by) AS `brand` From vm_ticket as v WHERE `from_id` = 0 AND `ticket_from` = 3 HAVING `brand` = 3 order by `id` desc");
        } else {
            if ($permission->view == 1) {
                if (!empty($filter_created_by))
                    $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => 0, 'ticket_from' => 3, 'created_by' => $filter_created_by));
                else
                    $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => 0, 'ticket_from' => 3));

            } elseif ($permission->view == 2) {
                $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => 0, 'ticket_from' => 3, 'created_by' => $user));
            }
        }

        return $data;
    }


    public function viewPmVmTickets($permission, $user, $from_id)
    {
        if ($permission->view == 1) {
            $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => $from_id, 'ticket_from' => 2));
        } elseif ($permission->view == 2) {
            $data = $this->db->order_by('id', 'desc')->get_where('vm_ticket', array('from_id' => $from_id, 'ticket_from' => 2, 'created_by' => $user));
        }
        return $data;
    }

    public function viewPmAllTickets($permission, $brand, $filter = "", $user = "")
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE " . $filter . " AND ticket_from = '2' HAVING brand = '$brand' order by id desc");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE " . $filter . " AND ticket_from = '2' AND created_by = '$user' HAVING brand = '$brand' order by id desc");
        }

        return $data;
    }

    public function viewPmAllTicketsPages($permission, $brand, $user, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE ticket_from = '2' HAVING brand = '$brand' order by id desc LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE ticket_from = '2' AND created_by = '$user' HAVING brand = '$brand' order by id desc LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function viewVmSheet($permission, $user, $brand, $filter = "")
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,r.subject AS vendor_subject,r.tools AS vendor_tools,r.country,r.mother_tongue,r.type,(SELECT brand FROM vendor WHERE vendor.id = v.vendor) AS brand FROM `vendor_sheet` AS v
            LEFT OUTER JOIN vendor AS r ON r.id = v.vendor
            WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,r.subject AS vendor_subject,r.tools AS vendor_tools,r.country,r.mother_tongue,r.type(SELECT brand FROM vendor WHERE vendor.id = v.vendor) AS brand FROM `vendor_sheet` AS v
            LEFT OUTER JOIN vendor AS r ON r.id = v.vendor
            WHERE created_by = '$user' AND " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        }
        return $data;
    }

    public function viewVmSheetPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("  SELECT v.*,r.subject AS vendor_subject,r.tools AS vendor_tools,r.country,r.mother_tongue,r.type,(SELECT brand FROM vendor WHERE vendor.id = v.vendor) AS brand FROM `vendor_sheet` AS v
            LEFT OUTER JOIN vendor AS r ON r.id = v.vendor HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("  SELECT v.*,r.subject AS vendor_subject,r.tools AS vendor_tools,r.country,r.mother_tongue,r.type.(SELECT brand FROM vendor WHERE vendor.id = v.vendor) AS brand FROM `vendor_sheet` AS v
            LEFT OUTER JOIN vendor AS r ON r.id = v.vendor
            WHERE created_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function selectTicketType($select = "")
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

        $outpt = '<option value="1" ' . $selected1 . '>New Resource</option>
                  <option value="2" ' . $selected2 . '>Price Inquiry</option>
                  <option value="3" ' . $selected3 . '>General</option>
                  <option value="4" ' . $selected4 . '>Resources Availability</option>
                  <option value="5" ' . $selected5 . '>CV Request</option>
                  ';
        return $outpt;
    }

    public function selectSalesTicketType($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } elseif ($select == 5) {
            $selected5 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
            $selected4 = '';
            $selected5 = '';
        }

        $outpt = '<option value="1" ' . $selected1 . '>New Resource</option>
                  <option value="2" ' . $selected2 . '>Price Inquiry</option>
                  <option value="4" ' . $selected4 . '>Resources Availability</option>
                  <option value="5" ' . $selected5 . '>CV Request</option>
                  ';
        return $outpt;
    }

    public function getTicketType($select = "")
    {
        if ($select == 1) {
            $outpt = 'New Resource';
        } elseif ($select == 2) {
            $outpt = 'Price Inquiry';
        } elseif ($select == 3) {
            $outpt = 'General';
        } elseif ($select == 4) {
            $outpt = 'Resources Availability';
        } elseif ($select == 5) {
            $outpt = 'CV Request';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function selectTicketStatusPartly($select = "")
    {
        if ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } else {
            $selected2 = '';
            $selected3 = '';
        }

        $outpt = '<option value="2" ' . $selected2 . '>Opened</option>
                  <option value="3" ' . $selected3 . '>Partly Closed</option>
                  ';
        return $outpt;
    }

    public function selectTicketStatusClosed($select = "")
    {
        if ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } else {
            $selected2 = '';
            $selected3 = '';
            $selected4 = '';
        }

        $outpt = '<option value="2" ' . $selected2 . ' disabled="">Opened</option>
                  <option value="3" ' . $selected3 . '>Partly Closed</option>
                  <option value="4" ' . $selected4 . '>Closed</option>
                  ';
        return $outpt;
    }

    public function selectAllTicketStatus($select = "")
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

        $outpt = '<option value="1" ' . $selected1 . '>New</option>
                  <option value="2" ' . $selected2 . '>Opened</option>
                  <option value="3" ' . $selected3 . '>Partly Closed</option>
                  <option value="4" ' . $selected4 . '>Closed</option>
                  <option value="5" ' . $selected5 . '>Closed Waiting Requester Acceptance</option>
                  ';
        return $outpt;
    }

    public function getTicketStatus($select = "")
    {
        if ($select == 0) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #FF4E28">Rejected</span>';
        } else if ($select == 1) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">New</span>';
        } else if ($select == 2) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #07b817">Opened</span>';
        } else if ($select == 3) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #e8e806">Partly Closed</span>';
        } else if ($select == 4) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #fb0404">Closed</span>';
        } else if ($select == 5) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #f05a0a">Closed Waiting Requester Acceptance</span>';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function getVendorName($vendor)
    {
        $result = $this->db->get_where('vendor', array('id' => $vendor))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectVendor($id = "", $brand = "")
    {
        $vendor = $this->db->order_by('name', 'ASC')->get_where('vendor', array('brand' => $brand))->result();
        $data = "";
        foreach ($vendor as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' selected='selected' country='" . $vendor->country . "'>" . $vendor->name . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "' country='" . $vendor->country . "'>" . $vendor->name . "</option>";
            }
        }
        return $data;
    }

    public function selectVendorByMail($id = "", $brand = "")
    {
        $vendor = $this->db->order_by('name', 'ASC')->get_where('vendor', array('brand' => $brand))->result();
        $data = "";
        foreach ($vendor as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' country='" . trim($vendor->country) . "' selected='selected' >" . $vendor->name . ' - ' . $vendor->email . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "' country='" . trim($vendor->country) . "'>" . $vendor->name . ' - ' . $vendor->email . "</option>";
            }
        }
        return $data;
    }

    public function selectVendorSheet($id = "", $brand = "")
    {
        $vendor = $this->db->query(" SELECT DISTINCT id,vendor,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM `vendor_sheet` HAVING brand = '$brand'  ")->result();
        $data = "";
        foreach ($vendor as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' selected='selected'>" . self::getVendorName($vendor->vendor) . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "'>" . self::getVendorName($vendor->vendor) . "</option>";
            }
        }
        return $data;
    }

    public function selectVendorByJob($id, $source, $target, $service, $brand)
    {
        // $vendor = $this->db->get_where('vendor_sheet',array('source_lang'=>$source,'target_lang'=>$target,'service'=>$service))->result();
        // $vendor = $this->db->query(" SELECT *,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM `vendor_sheet` WHERE source_lang = '$source' AND target_lang = '$target' AND service = '$service' HAVING brand = '$brand' ")->result();
        // $data = "";
        // foreach ($vendor as $vendor) {
        //     if ($vendor->id == $id) {
        //         $data .= "<option value='" . $vendor->id . "' selected='selected'>" . $this->vendor_model->getVendorName($vendor->vendor) . "</option>";
        //     } else {
        //         $data .= "<option value='" . $vendor->id . "'>" . $this->vendor_model->getVendorName($vendor->vendor) . "</option>";
        //     }
        // }
        // return $data;

        $vendor = $this->db->query(" SELECT DISTINCT v.id,v.name FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON s.vendor = v.id WHERE v.brand = '$brand' AND s.source_lang = '$source' AND s.target_lang = '$target' AND s.service = '$service' AND v.status = '0' ORDER BY v.name ASC ")->result();

        foreach ($vendor as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' selected='selected'>" . $vendor->name . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "'>" . $vendor->name . "</option>";
            }
        }
        return $data;
    }

    public function selectVendorByJobLEFreelancer($id, $brand)
    {
        $vendor = $this->db->query(" SELECT DISTINCT v.id,v.name FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON s.vendor = v.id WHERE v.brand = '$brand' AND s.service = '19' AND v.status = '0' ORDER BY v.name ASC ")->result();

        foreach ($vendor as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' selected='selected'>" . $vendor->name . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "'>" . $vendor->name . "</option>";
            }
        }
        return $data;
    }

    public function getTicketStatusNum($brand)
    {
        $data['new'] = $this->db->query(" SELECT *,(SELECT brand FROM `users` WHERE users.id = created_by) AS brand FROM `vm_ticket` WHERE status = 1 HAVING brand = '$brand' ")->num_rows();
        $data['opened'] = $this->db->query(" SELECT *,(SELECT brand FROM `users` WHERE users.id = created_by) AS brand FROM `vm_ticket` WHERE status = 2 HAVING brand = '$brand' ")->num_rows();
        $data['part_closed'] = $this->db->query(" SELECT *,(SELECT brand FROM `users` WHERE users.id = created_by) AS brand FROM `vm_ticket` WHERE status = 3 HAVING brand = '$brand' ")->num_rows();
        $data['closed'] = $this->db->query(" SELECT *,(SELECT brand FROM `users` WHERE users.id = created_by) AS brand FROM `vm_ticket` WHERE status = 4 HAVING brand = '$brand' ")->num_rows();
        // $data = $this->db->query(" SELECT (SELECT COUNT(*) FROM `vm_ticket` WHERE status = 1) AS new,(SELECT COUNT(*) FROM `vm_ticket` WHERE status = 2) AS opened,(SELECT COUNT(*) FROM `vm_ticket` WHERE status = 3) AS part_closed,(SELECT COUNT(*) FROM `vm_ticket` WHERE status = 4) AS closed ")->row();
        return $data;
    }

    public function changeTicketToOpen($id, $user)
    {
        $result = $this->db->get_where('vm_ticket', array('id' => $id))->row();
        if ($result->status == 1) {
            $data['status'] = 2;
            if ($this->db->update('vm_ticket', $data, array('id' => $id))) {
                $this->addTicketTimeStatus($id, $user, 2);
            }
        }
    }

    public function addTicketTimeStatus($ticket, $user, $status)
    {
        $time['status'] = $status;
        $time['ticket'] = $ticket;
        $time['created_by'] = $user;
        $time['created_at'] = date("Y-m-d H:i:s");
        $this->db->insert('vm_ticket_time', $time);
    }

    public function ticketTime($id)
    {
        $row = $this->db->get_where('vm_ticket_time', array('ticket' => $id))->result();
        $hrs = 0;
        $counter = 0;
        foreach ($row as $row) {
            if ($row->status <= 3) {
                $time = strtotime($row->created_at);
            } else {
                $time = strtotime($row->created_at) - $time;
                $hrs = $hrs + $time / (60 * 60);
            }
        }
        // return round($hrs,2);
        $arr = round($hrs, 2);
        $date = explode(".", $arr);
        if (isset($date[1])) {
            return $date[0] . ':' . round(($date[1] / 100) * 60);
        } else {
            return $date[0] . ':0';
        }
    }

    public function getVendorData($id)
    {
        $data = $this->db->get_where('vendor', array('id' => $id))->row();
        return $data;
    }

    public function getVendorSheetData($id)
    {
        $data = $this->db->get_where('vendor_sheet', array('id' => $id))->row();
        return $data;
    }

    public function getVendorSheetByVendor($vendor)
    {
        $data = $this->db->get_where('vendor_sheet', array('vendor' => $vendor))->result();
        return $data;
    }

    public function sendNewTicketEmail($user,$ticketNumber,$brand,$emailSubject = "",$opportunity = 0)
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
        $row = $this->db->get_where('vm_ticket', array('id' => $ticketNumber))->row();
        $pmMail = $this->admin_model->getUserEmail($user);
        $pmManagerEmail = $this->projects_model->getUserManagerEmail();
        $subject = "New Ticket : #" . $ticketNumber . " - " . $emailSubject;
        $cc = "";

        //PM CC..
        if ($opportunity > 0) {
            $pmId = $this->db->get_where('sales_opportunity', array('id' => $opportunity))->row()->pm;
            $cc = $this->admin_model->getUserEmail($pmId);
        }

        if ($brand == 1) {
            $mailTo = "vm@thetranslationgate.com";
        } elseif ($brand == 2) {
            $mailTo = "vm@localizera.com";
        } elseif ($brand == 3) {
            $mailTo = "vm@europelocalize.com";
        } elseif ($brand == 4) {
            $mailTo = "vm@afaqtranslations.com";
        } elseif ($brand == 11) {
            $mailTo = "vendormanagement@columbuslang.com";
        }

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($pmMail);
        // replace my mail by pm manger it is just for testing
        $this->email->to($mailTo);
        $this->email->cc($pmMail . ", " . $pmManagerEmail . ", " . $cc);
        //  $this->email->cc($pmMail.",".$cc);
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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear VM Team,</p>
                       <p> Please Check This New Ticket #' . $ticketNumber . ' </p>
                       <p>Created By : ' . $this->admin_model->getUser($user) . '</p>
                       <div class="space15"></div>                                    
                            <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                <tbody>
                                    <tr>
                                         <td colspan=2 style="background-color: #ddd;">Ticket Data</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Ticket Number</td>
                                         <td style="background-color:#ddd;">' . $ticketNumber . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Ticket Subject</td>
                                         <td style="background-color:#ddd;">' . $row->ticket_subject . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Request Type</td>
                                         <td style="background-color:#ddd;">' . self::getTicketType($row->request_type) . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Number Of Rescource</td>
                                         <td style="background-color:#ddd;">' . $row->number_of_resource . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Service</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getServices($row->service) . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Task Type</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getTaskType($row->task_type) . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Rate</td>
                                         <td style="background-color:#ddd;">' . $row->rate . '</td>
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
                                         <td style="background-color: #f9f9f9;">Currency</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getCurrency($row->currency) . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Source Language</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($row->source_lang). '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Target Language</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getLanguage($row->target_lang) . '</td>
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
                                         <td style="background-color: #f9f9f9;">Subject Matter</td>
                                         <td style="background-color:#ddd;">' . $this->admin_model->getFields($row->subject) . '</td>
                                    </tr>
                                    <tr>
                                         <td style="background-color: #f9f9f9;">Software</td>
                                         <td style="background-color:#ddd;">' . $this->sales_model->getToolName($row->software) . '</td>
                                    </tr>                                    
                                </tbody>
                            </table>
                    </body>
                    </html>';
        $this->email->message($message);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function sendTicketMail($user,$ticketNumber,$mailSubject,$msg,$brand)
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

        $userData = $this->admin_model->getUserData($user);
        $MailTo = $userData->email;
        $subject = $mailSubject . " : #" . $ticketNumber;
        $ticketData = $this->db->get_where('vm_ticket', array('id' => $ticketNumber))->row();

        if ($ticketData->ticket_from == 1) {
            $msgData = '<p> Opportunity Number: #' . $ticketData->from_id . '</p>';
            $pmId = $this->db->get_where('sales_opportunity', array('id' => $ticketData->from_id))->row()->pm;
            $this->email->cc($this->admin_model->getUserEmail($pmId));
        } elseif ($ticketData->ticket_from == 2) {
            $msgData = '<p> Project Number: #' . $ticketData->from_id . '</p>';
        }

        if ($brand == 1) {
            $this->email->from("vm@thetranslationgate.com");
            $this->email->cc("vm@thetranslationgate.com");
            $this->email->set_header('Reply-To', "vm@thetranslationgate.com");
        } elseif ($brand == 2) {
            $this->email->from("vm@localizera.com");
            $this->email->cc("vm@localizera.com");
            $this->email->set_header('Reply-To', "vm@thetranslationgate.com");
        } elseif ($brand == 3) {
            $this->email->from("vm@europelocalize.com");
            $this->email->cc("vm@europelocalize.com");
            $this->email->set_header('Reply-To', "vm@thetranslationgate.com");
        } elseif ($brand == 4) {
            $headers .= "Cc: vm@afaqtranslations.com " . "\r\n";
            $headers .= "Cc: nour.mahmoud@afaqtranslations.com" . "\r\n";
            $headers .= 'From: vm@afaqtranslations.com ' . "\r\n" . 'Reply-To: vm@afaqtranslations.com' . "\r\n";
        } elseif ($brand == 11) {
            $this->email->from("vendormanagement@columbuslang.com");
            $this->email->cc("vendormanagement@columbuslang.com");
            $this->email->set_header('Reply-To', "vm@thetranslationgate.com");
        }

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        // replace my mail by pm manger it is just for testing
        $this->email->to($MailTo);
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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear ' . $userData->user_name . ' ,</p>
                       <p> ' . $msg . ' </p>
                       <p> ' . $msgData . ' </p>
                       <p> Thanks</p>
                    </body>
                    </html>';

        $this->email->message($message);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function TicketReplyMail($user,$ticketNumber,$brand,$comment,$emailSubject = "")
    {
        $userData = $this->admin_model->getUserData($user);
        $MailTo = $userData->email;
        $subject = " New Reply : #" . $ticketNumber . " Project Name :" . $emailSubject;
        $ticketData = $this->db->get_where('vm_ticket', array('id' => $ticketNumber))->row();

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        if ($ticketData->ticket_from == 1) {
            $msgData = '<p> Opportunity Number: #' . $ticketData->from_id . '</p>';
            $pmId = $this->db->get_where('sales_opportunity', array('id' => $ticketData->from_id))->row()->pm;
            $headers .= "Cc: " . $this->admin_model->getUserEmail($pmId) . "\r\n";
        } elseif ($ticketData->ticket_from == 2) {
            $msgData = '<p> Project Number: #' . $ticketData->from_id . '</p>';
        }

        if ($brand == 1) {
            $headers .= "Cc: vm@thetranslationgate.com " . "\r\n";
            $headers .= 'From: vm@thetranslationgate.com ' . "\r\n" . 'Reply-To: vm@thetranslationgate.com' . "\r\n";
        } elseif ($brand == 2) {
            $headers .= "Cc: vm@localizera.com " . "\r\n";
            $headers .= 'From: vm@localizera.com ' . "\r\n" . 'Reply-To: vm@localizera.com' . "\r\n";
        } elseif ($brand == 3) {
            $headers .= "Cc: vm@europelocalize.com " . "\r\n";
            $headers .= 'From: vm@europelocalize.com ' . "\r\n" . 'Reply-To: vm@europelocalize.com' . "\r\n";
        } elseif ($brand == 4) {
            $headers .= "Cc: vm@afaqtranslations.com " . "\r\n";
            $headers .= "Cc: nour.mahmoud@afaqtranslations.com" . "\r\n";
            $headers .= 'From: vm@afaqtranslations.com ' . "\r\n" . 'Reply-To: vm@afaqtranslations.com' . "\r\n";
        } elseif ($brand == 11) {
            $headers .= "Cc: vendormanagement@columbuslang.com " . "\r\n";
            $headers .= 'From: vendormanagement@columbuslang.com ' . "\r\n" . 'Reply-To: vendormanagement@columbuslang.com' . "\r\n";
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
                    <p>Dear All,</p>
                       <p> A new reply has already sent to your ticket by : ' . $this->admin_model->getUserData($this->user)->user_name . ', please check .. </p>
                       <p> ' . $msgData . ' </p>
                       <p> Replay : ' . $comment . ' </p>
                       <p> Thanks</p>
                    </body>
                    </html>';
        mail($MailTo, $subject, $message, $headers);
    }

    public function ticketAcceptanceMail($ticket, $type)
    {
        $ticketData = $this->db->get_where('vm_ticket', array('id' => $ticket))->row();
        $userData = $this->admin_model->getUserData($ticketData->created_by);
        $MailTo = "vm@thetranslationgate.com";
        $subject = " Closing Ticket Request : #" . $ticket;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        if ($ticketData->ticket_from == 1) {
            $pmId = $this->db->get_where('sales_opportunity', array('id' => $ticketData->from_id))->row()->pm;
            $headers .= "Cc: " . $this->admin_model->getUserEmail($pmId) . "\r\n";
            $msgData = '<p> Opportunity Number: #' . $ticketData->from_id . '</p>';
        } elseif ($ticketData->ticket_from == 2) {
            $msgData = '<p> Project Number: #' . $ticketData->from_id . '</p>';
        }

        $headers .= "Cc: " . $userData->email . "\r\n";
        $headers .= 'From: ' . $userData->email . "\r\n" . 'Reply-To:' . $userData->email . "\r\n";
        if ($type == 2) {
            $data = "declined";
        }
        if ($type == 1) {
            $data = "accept";
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
                    <p>Dear VM Team,</p>
                       <p> ' . $userData->user_name . ' ' . $data . ' to close your ticekt please check ..</p>
                       <p> ' . $msgData . ' </p>
                       <p> Thanks</p>
                    </body>
                    </html>';
        mail($MailTo, $subject, $message, $headers);
    }

    public function getVendorInfo($id)
    {
        $row = $this->db->get_where('vendor', array('id' => $id))->row();

        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                        <thead>
                            <tr>
                                 <th>Email</th>
                                 <th>Contact</th>
                                 <th>Country</th>
                            </tr>
                        </thead>                            
                        <tbody>
                            <tr class="">
                                <td>' . $row->email . '</td>
                                <td>' . $row->contact . '</td>
                                <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            </tr>
                        </tbody>
                    </table>';
        return $data;
    }

    public function selectVendorType($select = "")
    {
        if ($select == 0) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '<option value="0" ' . $selected1 . '>Freelancer</option>
                  <option value="1" ' . $selected2 . '>In House</option>
                  ';
        return $outpt;
    }

    public function getVendorType($select = "")
    {
        if ($select == 0) {
            $outpt = 'Freelancer';
        } elseif ($select == 1) {
            $outpt = 'In House';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function getVendorTableData($id, $task_type, $rate)
    {
        $row = $this->db->get_where('vendor_sheet', array('vendor' => $id, 'task_type' => $task_type))->row();
        if (isset($row->rate)) {
            $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                        <thead>
                            <tr>
                                 <th>Unit</th>
                                 <th>Rate</th>
                                 <th>Currency</th>
                            </tr>
                        </thead>                            
                        <tbody>
                            <tr class="">
                                <input type="text" id="unit_1" name="unit_1" value="' . $row->unit . '" hidden="">
                                <input type="text" id="currency_1" name="currency_1" value="' . $row->currency . '" hidden="">
                                <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                                <td><input onblur="calculateVendorCostChecked()" type="text" id="rate_1" name="rate_1" value="' . $rate . '"></td>
                                <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                            </tr>
                        </tbody>
                    </table>';
            echo $data;
        }
    }

    public function viewVmTicketsActivity($permission, $brand, $user, $filter = 1)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.id AS ticket,v.created_at AS request_time,v.request_type,v.service,v.task_type,v.number_of_resource,v.rate,v.source_lang,v.target_lang,v.start_date,v.due_date,
                v.delivery_date,v.count,v.unit,v.currency,v.subject,v.software,v.created_by AS requester,v.status AS ticket_status,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand,t.created_by AS vm,t.created_at AS open_time FROM `vm_ticket` AS v
                LEFT OUTER JOIN vm_ticket_time AS t ON t.id = (SELECT id FROM vm_ticket_time WHERE ticket = v.id and status = '2' LIMIT 1 )
                WHERE " . $filter . " HAVING brand = '$brand' ORDER BY v.id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.id AS ticket,v.created_at AS request_time,v.request_type,v.service,v.task_type,v.number_of_resource,v.rate,v.source_lang,v.target_lang,v.start_date,v.due_date,
                v.delivery_date,v.count,v.unit,v.currency,v.subject,v.software,v.created_by AS requester,v.status AS ticket_status,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand,t.created_by AS vm,t.created_at AS open_time FROM `vm_ticket` AS v
                LEFT OUTER JOIN vm_ticket_time AS t ON t.id = (SELECT id FROM vm_ticket_time WHERE ticket = v.id and status = '2' LIMIT 1 )
                WHERE " . $filter . " AND t.created_by = '$user' HAVING brand = '$brand' ORDER BY v.id DESC ");
        }
        return $data;
    }

    public function viewVmTicketsActivityPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.id AS ticket,v.created_at AS request_time,v.request_type,v.service,v.task_type,v.number_of_resource,v.rate,v.source_lang,v.target_lang,v.start_date,v.due_date,
                v.delivery_date,v.count,v.unit,v.currency,v.subject,v.software,v.created_by AS requester,v.status AS ticket_status,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand,t.created_by AS vm,t.created_at AS open_time FROM `vm_ticket` AS v
                LEFT OUTER JOIN vm_ticket_time AS t ON t.id = (SELECT id FROM vm_ticket_time WHERE ticket = v.id and status = '2' LIMIT 1 )
                HAVING brand = '$brand' ORDER BY v.id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.id AS ticket,v.created_at AS request_time,v.request_type,v.service,v.task_type,v.number_of_resource,v.rate,v.source_lang,v.target_lang,v.start_date,v.due_date,
                v.delivery_date,v.count,v.unit,v.currency,v.subject,v.software,v.created_by AS requester,v.status AS ticket_status,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand,t.created_by AS vm,t.created_at AS open_time FROM `vm_ticket` AS v
                LEFT OUTER JOIN vm_ticket_time AS t ON t.id = (SELECT id FROM vm_ticket_time WHERE ticket = v.id and status = '2' LIMIT 1 )
                WHERE t.created_by = '$user' HAVING brand = '$brand' ORDER BY v.id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllVendorsCV($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `vendor_cv` WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vendor_cv` WHERE brand = '$brand' AND created_by = '$user' AND " . $filter . " ORDER BY id DESC");
        }
        return $data;
    }

    public function AllVendorsCVPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `vendor_cv` WHERE brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vendor_cv` WHERE brand = '$brand' AND created_by = '$user' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function selectVendorColor($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '
                  <option value="1" ' . $selected1 . '>Red</option>
                  <option value="2" ' . $selected2 . '>Yellow</option>';
        return $outpt;
    }

    public function viewPmSalesTickets($permission, $brand, $filter = "", $user = "")
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT s.pm,s.customer,s.project_name,t.*,(SELECT brand FROM `users` WHERE users.id = s.created_by) AS brand FROM vm_ticket AS t LEFT OUTER JOIN sales_opportunity AS s ON s.id = t.from_id WHERE t.ticket_from = 1 AND " . $filter . " HAVING brand = '$brand' order by id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT s.pm,s.customer,s.project_name,t.* FROM vm_ticket AS t
                LEFT OUTER JOIN sales_opportunity AS s ON s.id = t.from_id
                WHERE t.ticket_from = 1 AND " . $filter . " AND s.pm = '$user' order by id desc ");
        }

        return $data;
    }

    public function viewPmSalesTicketsPages($permission, $brand, $user, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT s.pm,s.customer,s.project_name,t.*,(SELECT brand FROM `users` WHERE users.id = s.created_by) AS brand FROM vm_ticket AS t LEFT OUTER JOIN sales_opportunity AS s ON s.id = t.from_id WHERE t.ticket_from = 1 HAVING brand = '$brand' order by id desc LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT s.pm,s.customer,s.project_name,t.* FROM vm_ticket AS t
                LEFT OUTER JOIN sales_opportunity AS s ON s.id = t.from_id
                WHERE t.ticket_from = 1 AND s.pm = '$user' order by id desc LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function validateEmail($email = "", $brand = "")
    {

        if ($this->db->query("SELECT * FROM  vendor WHERE email LIKE '%$email%' AND brand = '$brand' ")->num_rows() > 0) {
            $data = "1";
        } else {
            $data = "0";
        }
        return $data;
    }

    public function validateEmailEdit($email, $id, $brand)
    {
        //$d1= $this->db->query("SELECT * FROM  vendor WHERE email = '$email' AND id = '$id' ")->num_rows();
        $d1 = $this->db->query("SELECT * FROM  vendor WHERE email LIKE '%$email%' AND id != '$id' AND brand = '$brand' ")->num_rows();
        if ($d1 >= 1) {
            $data = "1";
        } else {
            $data = "0";
        }
        /* if($d2 > 0 ){
              $data = "2";
         }*/
        return $data;
    }

    public function changeTicketToClose()
    {
        $ticket = $this->db->query("SELECT * FROM vm_ticket WHERE status = '5'");
        foreach ($ticket->result() as $row) {
            $statusRow = $this->db->query("SELECT * FROM vm_ticket_time WHERE ticket = '$row->id' AND status = '5' ORDER BY id DESC LIMIT 1")->row();
            $lastDate = strtotime($statusRow->created_at);
            $currentDate = strtotime("now");
            $days = abs($lastDate - $currentDate) / 60 / 60 / 24;
            //update status
            if ($days >= 3) {
                $data['status'] = 4;
                if ($this->db->update('vm_ticket', $data, array('id' => $row->id))) {
                    $this->addTicketTimeStatus($row->id, 0, 4);
                }
            }
        }
    }

    public function selectVendorStatus($select = "")
    {
        if ($select == 0) {
            $selected1 = 'selected';
        } elseif ($select == 1) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '<option value="0" ' . $selected1 . '>Active</option>
                  <option value="1" ' . $selected2 . '>Deactive</option>';
        return $outpt;
    }

    public function getVendorStatus($select = "")
    {
        if ($select == 0) {
            $outpt = 'Active';
        } elseif ($select == 1) {
            $outpt = 'Deactive';
        } else {
            $outpt = "";
        }
        return $outpt;
    }


    public function selectVmEmployeeId($id = "", $brand = "")
    {
        $vm = $this->db->query(" SELECT * FROM users WHERE (role = '11' OR role = '32') AND brand = '$this->brand' AND status = '1' ")->result();
        foreach ($vm as $vm) {
            if ($vm->id == $id) {
                $data .= "<option value='" . $vm->employees_id . "' selected='selected'>" . $vm->user_name . "</option>";
            } else {
                $data .= "<option value='" . $vm->employees_id . "'>" . $vm->user_name . "</option>";
            }
        }
        return $data;
    }


    //tickets with issue
    public function viewVmTicketsWithIssues($role, $user, $brand, $filter = "")
    {
        if ($filter) {
            if ($role == 32) {
                $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE issue_status = 1 AND " . $filter . " HAVING brand = '$brand' order by id desc");
            } else {
                $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE issue_status = 1 AND v.issue_by = '$user' AND " . $filter . " HAVING brand = '$brand' order by id desc");
            }

        } else {
            if ($role == 32) {
                $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE issue_status = 1 HAVING brand = '$brand' order by id desc");
            } else {
                $data = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v WHERE issue_status = 1 AND v.issue_by = '$user' HAVING brand = '$brand' order by id desc");
            }

        }
        return $data;
    }
    public function viewVmTicketsWithIssuesPages($role, $user, $brand, $limit, $offset)
    {
        if ($role == 32) {
            $data = $this->db->query("SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v WHERE issue_status = 1 HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } else {
            $data = $this->db->query("SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM vm_ticket AS v WHERE issue_status = 1 AND v.issue_by = '$user' HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }

        return $data;
    }
    //
    public function AllCompanies($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM `companies` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllCompaniesPages($brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `companies` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }
    public function AllFavouriteVendor($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND " . $filter . " HAVING favourite = '1' ORDER BY id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT v.*,s.source_lang,s.target_lang,s.dialect,s.service,s.task_type,s.rate,s.special_rate,s.unit,s.currency,s.created_at AS sheetCreatedAt,s.created_by AS sheetCreatedBy,s.id AS sheetId FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON v.id = s.vendor 
                 WHERE brand = '$brand' AND created_by = '$user' AND " . $filter . " HAVING favourite = '1' ORDER BY id DESC");
        }
        return $data;
    }

    public function AllFavouriteVendorPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' HAVING favourite = '1' ORDER BY id DESC LIMIT $limit OFFSET $offset  ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `vendor` WHERE brand = '$brand' AND created_by = '$user' HAVING favourite = '1' ORDER BY id DESC LIMIT $limit OFFSET $offset  ");
        }
        return $data;
    }

    public function AllExternalVendorCount($filter)
    {
        return $this->db->select('count(*) as count')->from('vendor_request as vr')
            ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->where($filter)->get()->row();
    }

    public function AllExternalVendorsPages($filter, $limit, $offset)
    {
        $query = $this->db->select('vr.*,vsr.id AS sheetid,slang.name as source_lang,tlang.name as target_lang,vsr.dialect,s.name as service_name,
                                  t.name as task_type_name,vsr.rate,vsr.special_rate,u.name as unit_name,currency.name as currency_name,
                                  countries.name as country_name')->from('vendor_request as vr')
            ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->join('currency', 'vsr.currency = currency.id')
            ->join('languages AS slang', 'vsr.source_lang = slang.id')->join('languages AS tlang', 'vsr.target_lang = tlang.id')
            ->join('services AS s', 'vsr.service = s.id')->join('task_type AS t', 'vsr.task_type = t.id')->join('unit AS u', 'vsr.unit = u.id')
            ->join('countries', 'vr.country=countries.id')->where($filter);
        if ($limit != 0) {
            return $query->order_by('vr.id', 'DESC')->limit($limit, $offset)->get();
        } else {
            return $query->order_by('vr.id', 'DESC')->get();
        }
    }
    public function getExternalVendor($sheet_id)
    {
        return $this->db->select('vr.*,vsr.id AS sheetid,vsr.source_lang,vsr.target_lang,vsr.dialect,vsr.service,vsr.task_type,vsr.rate,vsr.special_rate,vsr.currency,vsr.status,vsr.unit')->from('vendor_request as vr')
            ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->where("vsr.id", $sheet_id)->get()->row();

    }
    public function getVendor($external_vendor)
    {
        return $this->db->select('id')->from('vendor')->where("external_id", $external_vendor)->get()->row();

    }

    public function generateVendorPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890?/*#$%^&_+';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function SendVendorNewAccountEmailPortal($vendor_id)
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

        $vendors = $this->db->get_where('vendor', array('id' => $vendor_id))->result();
        foreach ($vendors as $vendor) {
            $vendor_brand = $vendor->brand;
            $data['vendor'] = $vendor;
            $data['nexusLink'] = $nexusLink = $this->projects_model->getNexusLinkByBrand($vendor_brand);

            if ($vendor_brand == 1) {
                $subject = "TTG || Nexus New Profile";
                $vm_email = "vm@thetranslationgate.com";
                $message = $this->load->view("nexus/new_profile_ttg.php", $data, true);
            } elseif ($vendor_brand == 3) {
                $subject = "Europe Localize || Nexus New Profile";
                $vm_email = "vm@europelocalize.com";
                $message = $this->load->view("nexus/new_profile_el.php", $data, true);
            } elseif ($vendor_brand == 11) {
                $subject = "Columbus Lang || Nexus New Profile";
                $vm_email = "Vendormanagement@Columbuslang.com";
                $message = $this->load->view("nexus/new_profile_cl.php", $data, true);
            } elseif ($vendor_brand == 2) {
                $subject = "Localizera || Nexus New Profile";
                $vm_email = "vm@localizera.com";
                $message = $this->load->view("nexus/new_profile_loc.php", $data, true);
            }

            $this->email->from($vm_email);
            $this->email->cc("help@aixnexus.com, $vm_email");
            $this->email->to($vendor->email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_header('Reply-To', $vm_email);
            $this->email->set_mailtype('html');
            $this->email->send();
            echo $message;
        }
    }

    public function getVendorFeedbackAVG($column, $vendor_id)
    {
        $data = $this->db->query(" SELECT avg($column) as avg_data FROM `task_feedback` WHERE vendor_id = $vendor_id")->row()->avg_data;
        return $data;
    }

	 public function getVendorTaskCount($vendor_id)
    {
        $data = $this->db->query(" SELECT count(id) as task_count FROM `job_task` WHERE vendor = $vendor_id")->row()->task_count;
        return $data;
    }
    // vendor campaign
    public function CreateCampaignTable($tableName)
    { 
        $sql = "CREATE TABLE $tableName(
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            vendor_id INT(11) NOT NULL, 
            camp_id INT(11) NOT NULL,
            camp_date datetime NULL,
            vendor_name VARCHAR(250) NOT NULL,
            vendor_email VARCHAR(250) NOT NULL,  
            brand INT(11) NOT NULL, 
            send_flag TinyInt(1) NOT NULL Default 0,
            status  VARCHAR(50) NOT NULL Default 'active'

        )";
        $query = $this->db->query($sql);
        return $query;
    } 
    
    public function sendCampaignVendors($tableName)
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
        $this->email->from('vm@thetranslationgate.com');
        $subject = "You made our top 100 vendor list! Tell us what you think.";
        $this->email->subject($subject); 
        $vendor = $this->db->get_where("$tableName", array('send_flag' => 0))->row();  
        if(!empty($vendor)){
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
                            font-size: 18px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        p {
                            font-size: 18px;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                        }
                        </style>
                        <!--Core js-->
                    </head>
                    <body>
                        <p>Hey ' . $vendor->vendor_name . ',</p>
                        <p>Hope you’re doing well and safe!</p>
                        <p>We just wanted to tell you how lucky we are to have you as a part of our community. The Translation Gate always goes far and beyond to make its members feel appreciated and heard.</p>

                        <p>We’re conducting this survey https://docs.google.com/forms/d/e/1FAIpQLScIt2aQi2jYdMLOZZWIvt_Pazm8Ii-4-9KocdOEtQ2Y9uUd2Q/viewform to learn more about your thoughts on our services and cooperation. It will only take you 3 minutes.</p>

                        <p>In the meantime, Please contact the VM team through vm@thetranslationgate.com to help you in case you have any queries or issues.</p>

                        <p>Thank you for being part of our wonderful family!</p>
                                      

                    </body>
                    </html>';

            $mailTo = $vendor->vendor_email;
            $this->email->to($mailTo);
            $this->email->message($msg);
            $this->email->set_header('Reply-To', 'vm@thetranslationgate.com');
            $this->email->set_mailtype('html');             
            if ($this->email->send()) {
            // if send update flag = 1
                $data['send_flag'] = 1;
                $data['camp_date'] = date("Y-m-d H:i:s");
                $this->db->update("$tableName", $data, array('id' => $vendor->id));
               
            }
        }else{           
            $data['status'] = "closed";
            $this->db->update("$tableName", $data);
            
        }
        
    }  
    
    public function getActiveVendors($brand,$campaignID){
        
        $tableName = 'camp_'.$campaignID;
      //  $vendors = $this->db->query("SELECT DISTINCT(vendor.id),name ,email,brand FROM `vendor` join `job_task` ON `job_task`.vendor = `vendor`.`id` where brand=$brand  and name like '%test%'")->result();
        $vendors = $this->db->query("SELECT DISTINCT(vendor.id),name ,email,brand FROM `vendor` join `job_task` ON `job_task`.vendor = `vendor`.`id` where brand=$brand  ")->result();
                
        foreach ($vendors as $vendor) {
            $data['vendor_id'] = $vendor->id;
            $data['vendor_name'] = $vendor->name;
            $data['vendor_email'] = $vendor->email;
            $data['brand'] = $vendor->brand;
            $data['camp_id'] = $campaignID;
            $this->db->insert("$tableName", $data);                
        }
        
    } 


}